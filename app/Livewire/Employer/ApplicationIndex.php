<?php

namespace App\Livewire\Employer;

use App\Models\JobApplication;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ApplicationIndex extends Component
{
    use WithPagination;

    #[Url]
    public string $sortField = 'created_at';

    #[Url]
    public string $sortDirection = 'desc';

    #[Url]
    public string $suburb = '';

    #[Url]
    public string $dateFrom = '';

    #[Url]
    public string $dateTo = '';

    public array $rankings = [];

    public array $notes = [];

    public ?int $savedApplicationId = null;

    public ?int $selectedApplicationId = null;

    public function updatingSuburb(): void
    {
        $this->resetPage();
    }

    public function updatingDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatingDateTo(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        $allowed = ['created_at', 'name', 'suburb', 'applicant_rank'];

        if (! in_array($field, $allowed, true)) {
            return;
        }

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = in_array($field, ['created_at', 'applicant_rank'], true) ? 'desc' : 'asc';
        }
    }

    public function clearFilters(): void
    {
        $this->reset(['suburb', 'dateFrom', 'dateTo']);
        $this->resetPage();
    }

    public function openApplication(int $applicationId): void
    {
        $this->selectedApplicationId = JobApplication::query()->whereKey($applicationId)->value('id');
    }

    public function saveReview(int $applicationId): void
    {
        $application = JobApplication::query()->findOrFail($applicationId);

        $validated = Validator::make([
            'applicant_rank' => $this->rankings[$applicationId] ?? null,
            'employer_notes' => $this->notes[$applicationId] ?? null,
        ], [
            'applicant_rank' => ['nullable', 'integer', 'between:1,5'],
            'employer_notes' => ['nullable', 'string', 'max:5000'],
        ])->validate();

        $applicantRank = $validated['applicant_rank'] ?? null;

        if (($applicantRank === null || $applicantRank === '') && $this->hasCriticalConcern($application)) {
            $applicantRank = 4;
        }

        $application->update([
            'applicant_rank' => $applicantRank !== null && $applicantRank !== ''
                ? (int) $applicantRank
                : null,
            'employer_notes' => blank($validated['employer_notes'] ?? null)
                ? null
                : trim($validated['employer_notes']),
        ]);

        $this->rankings[$applicationId] = $application->applicant_rank === null ? '' : (string) $application->applicant_rank;
        $this->notes[$applicationId] = $application->employer_notes ?? '';
        $this->savedApplicationId = $applicationId;
    }

    public function render(): View
    {
        $query = JobApplication::query()
            ->when($this->suburb !== '', fn ($builder) => $builder->where('suburb', $this->suburb))
            ->when($this->dateFrom !== '', fn ($builder) => $builder->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo !== '', fn ($builder) => $builder->whereDate('created_at', '<=', $this->dateTo));

        if ($this->sortField === 'name') {
            $query->orderBy('last_name', $this->sortDirection)
                ->orderBy('first_name', $this->sortDirection);
        } else {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        $applications = $query->paginate(10);

        $this->syncReviewState($applications->items());

        if ($this->selectedApplicationId === null && count($applications->items()) > 0) {
            $this->selectedApplicationId = $applications->items()[0]->id;
        }

        if ($this->selectedApplicationId !== null && ! JobApplication::query()->whereKey($this->selectedApplicationId)->exists()) {
            $this->selectedApplicationId = count($applications->items()) > 0 ? $applications->items()[0]->id : null;
        }

        $selectedApplication = $this->selectedApplicationId
            ? JobApplication::query()->find($this->selectedApplicationId)
            : null;

        if ($selectedApplication) {
            $this->syncReviewState([$selectedApplication]);
        }

        return view('livewire.employer.application-index', [
            'applications' => $applications,
            'selectedApplication' => $selectedApplication,
            'suburbs' => JobApplication::query()->select('suburb')->distinct()->orderBy('suburb')->pluck('suburb'),
        ])->layout('layouts.app', [
            'title' => 'Employer Applications',
        ]);
    }

    protected function syncReviewState(array $applications): void
    {
        foreach ($applications as $application) {
            if (! array_key_exists($application->id, $this->rankings)) {
                $this->rankings[$application->id] = $application->applicant_rank === null
                    ? ($this->hasCriticalConcern($application) ? '4' : '')
                    : (string) $application->applicant_rank;
            }

            if (! array_key_exists($application->id, $this->notes)) {
                $this->notes[$application->id] = $application->employer_notes ?? '';
            }
        }
    }

    public function applicationRowClasses(JobApplication $application, bool $isSelected): string
    {
        $classes = 'cursor-pointer align-top text-sm text-stone-700 transition';

        if ($this->hasCriticalConcern($application)) {
            $classes .= ' bg-red-100 hover:bg-red-200';
        } elseif ($this->hasTransportConcern($application)) {
            $classes .= ' bg-stone-200 hover:bg-stone-300';
        } else {
            $classes .= ' hover:bg-amber-50';
        }

        if ($isSelected) {
            $classes .= $this->hasCriticalConcern($application)
                ? ' ring-2 ring-inset ring-red-300'
                : ($this->hasTransportConcern($application)
                    ? ' ring-2 ring-inset ring-stone-400'
                    : ' bg-amber-50');
        }

        return $classes;
    }

    public function detailHighlightClasses(JobApplication $application, string $field): string
    {
        $classes = 'rounded-[0.475rem] border px-4 py-3';

        if (in_array($field, ['criminal_history', 'workers_compensation'], true) && $this->isYes($application->{$field})) {
            return $classes . ' border-red-300 bg-red-100';
        }

        if (in_array($field, ['reliable_transport', 'drivers_licence'], true) && $this->isNo($application->{$field})) {
            return $classes . ' border-amber-300 bg-amber-100';
        }

        return $classes . ' border-stone-200 bg-white';
    }

    protected function hasTransportConcern(JobApplication $application): bool
    {
        return $this->isNo($application->reliable_transport) || $this->isNo($application->drivers_licence);
    }

    protected function hasCriticalConcern(JobApplication $application): bool
    {
        return $this->isYes($application->criminal_history) || $this->isYes($application->workers_compensation);
    }

    protected function isYes(?string $value): bool
    {
        return strtolower(trim((string) $value)) === 'yes';
    }

    protected function isNo(?string $value): bool
    {
        return strtolower(trim((string) $value)) === 'no';
    }
}
