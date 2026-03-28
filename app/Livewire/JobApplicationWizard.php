<?php

namespace App\Livewire;

use App\Models\JobApplication;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class JobApplicationWizard extends Component
{
    public int $step = 1;

    public bool $showThankYouModal = false;

    public string $first_name = '';
    public string $last_name = '';
    public string $street_address = '';
    public string $suburb = '';
    public string $postcode = '';
    public string $contact_number = '';
    public string $email = '';
    public string $work_authorization = '';
    public string $work_authorization_other = '';
    public string $reliable_transport = '';
    public string $drivers_licence = '';
    public string $criminal_history = '';
    public string $police_clearance = '';
    public string $workers_compensation = '';

    public array $availability = [
        'monday' => '',
        'tuesday' => '',
        'wednesday' => '',
        'thursday' => '',
        'friday' => '',
        'saturday' => '',
        'sunday' => '',
    ];

    public array $education = [
        ['year' => '', 'institute' => '', 'qualification' => ''],
        ['year' => '', 'institute' => '', 'qualification' => ''],
        ['year' => '', 'institute' => '', 'qualification' => ''],
    ];

    public array $work_history = [
        ['company_name' => '', 'from' => '', 'to' => '', 'position' => '', 'duties' => ''],
        ['company_name' => '', 'from' => '', 'to' => '', 'position' => '', 'duties' => ''],
        ['company_name' => '', 'from' => '', 'to' => '', 'position' => '', 'duties' => ''],
    ];

    public array $references = [
        ['name' => '', 'company_name' => '', 'position' => '', 'contact_number' => ''],
        ['name' => '', 'company_name' => '', 'position' => '', 'contact_number' => ''],
    ];

    public array $steps = [
        1 => 'Your details',
        2 => 'Eligibility',
        3 => 'Availability',
        4 => 'Education',
        5 => 'Work history',
        6 => 'References',
    ];

    public function nextStep(): void
    {
        $this->validate($this->rulesForStep($this->step));

        if ($this->step < count($this->steps)) {
            $this->step++;
        }
    }

    public function previousStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function goToStep(int $step): void
    {
        if ($step < 1 || $step > count($this->steps)) {
            return;
        }

        if ($step > $this->step) {
            $this->validate($this->rulesForStep($this->step));
        }

        $this->step = $step;
    }

    public function submit(): void
    {
        $this->validate($this->rules());

        JobApplication::create([
            'job_title' => '',
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'street_address' => $this->street_address,
            'suburb' => $this->suburb,
            'postcode' => $this->postcode,
            'contact_number' => $this->contact_number,
            'email' => $this->email,
            'work_authorization' => $this->work_authorization,
            'work_authorization_other' => $this->work_authorization === 'Other'
                ? $this->work_authorization_other
                : null,
            'reliable_transport' => $this->reliable_transport,
            'drivers_licence' => $this->drivers_licence,
            'criminal_history' => $this->criminal_history,
            'police_clearance' => $this->police_clearance,
            'workers_compensation' => $this->workers_compensation,
            'availability' => $this->sanitizeRepeater($this->availability),
            'education' => $this->sanitizeRepeater($this->education),
            'work_history' => $this->sanitizeRepeater($this->work_history),
            'references' => $this->sanitizeRepeater($this->references),
        ]);

        $this->resetForm();
        $this->showThankYouModal = true;
    }

    public function render(): View
    {
        return view('livewire.job-application-wizard')
            ->layout('layouts.app', [
                'title' => 'Cleaning Company Job Application',
            ]);
    }

    protected function rulesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'street_address' => ['required', 'string', 'max:255'],
                'suburb' => ['required', 'string', 'max:255'],
                'postcode' => ['required', 'digits_between:4,4'],
                'contact_number' => ['required', 'string', 'max:20'],
                'email' => ['required', 'email', 'max:255'],
            ],
            2 => [
                'work_authorization' => ['required', 'string', 'max:255'],
                'work_authorization_other' => ['nullable', 'string', 'max:255', 'required_if:work_authorization,Other'],
                'reliable_transport' => ['required', 'string', 'max:255'],
                'drivers_licence' => ['required', 'string', 'max:255'],
                'criminal_history' => ['required', 'string', 'max:255'],
                'police_clearance' => ['required', 'string', 'max:255'],
                'workers_compensation' => ['required', 'string', 'max:255'],
            ],
            3 => [
                'availability.*' => ['nullable', 'string', 'max:255'],
            ],
            4 => [
                'education.*.year' => ['nullable', 'digits:4'],
                'education.*.institute' => ['nullable', 'string', 'max:255'],
                'education.*.qualification' => ['nullable', 'string', 'max:255'],
            ],
            5 => [
                'work_history.0.company_name' => ['required', 'string', 'max:255'],
                'work_history.0.from' => ['required', 'date'],
                'work_history.0.to' => ['required', 'date'],
                'work_history.0.position' => ['required', 'string', 'max:255'],
                'work_history.0.duties' => ['required', 'string', 'max:2000'],
                'work_history.1.company_name' => ['nullable', 'string', 'max:255'],
                'work_history.1.from' => ['nullable', 'date'],
                'work_history.1.to' => ['nullable', 'date'],
                'work_history.1.position' => ['nullable', 'string', 'max:255'],
                'work_history.1.duties' => ['nullable', 'string', 'max:2000'],
                'work_history.2.company_name' => ['nullable', 'string', 'max:255'],
                'work_history.2.from' => ['nullable', 'date'],
                'work_history.2.to' => ['nullable', 'date'],
                'work_history.2.position' => ['nullable', 'string', 'max:255'],
                'work_history.2.duties' => ['nullable', 'string', 'max:2000'],
            ],
            6 => [
                'references.0.name' => ['required', 'string', 'max:255'],
                'references.0.company_name' => ['required', 'string', 'max:255'],
                'references.0.position' => ['required', 'string', 'max:255'],
                'references.0.contact_number' => ['required', 'string', 'max:20'],
                'references.1.name' => ['nullable', 'string', 'max:255'],
                'references.1.company_name' => ['nullable', 'string', 'max:255'],
                'references.1.position' => ['nullable', 'string', 'max:255'],
                'references.1.contact_number' => ['nullable', 'string', 'max:20'],
            ],
            default => [],
        };
    }

    protected function rules(): array
    {
        return array_merge(
            $this->rulesForStep(1),
            $this->rulesForStep(2),
            $this->rulesForStep(3),
            $this->rulesForStep(4),
            $this->rulesForStep(5),
            $this->rulesForStep(6),
        );
    }

    protected function sanitizeRepeater(array $items): array
    {
        return array_values(array_filter($items, function ($item) {
            if (! is_array($item)) {
                return filled($item);
            }

            return collect($item)->contains(fn ($value) => filled($value));
        }));
    }

    protected function resetForm(): void
    {
        $this->reset([
            'step',
            'first_name',
            'last_name',
            'street_address',
            'suburb',
            'postcode',
            'contact_number',
            'email',
            'work_authorization',
            'work_authorization_other',
            'reliable_transport',
            'drivers_licence',
            'criminal_history',
            'police_clearance',
            'workers_compensation',
            'availability',
            'education',
            'work_history',
            'references',
        ]);

        $this->step = 1;
        $this->availability = [
            'monday' => '',
            'tuesday' => '',
            'wednesday' => '',
            'thursday' => '',
            'friday' => '',
            'saturday' => '',
            'sunday' => '',
        ];
        $this->education = [
            ['year' => '', 'institute' => '', 'qualification' => ''],
            ['year' => '', 'institute' => '', 'qualification' => ''],
            ['year' => '', 'institute' => '', 'qualification' => ''],
        ];
        $this->work_history = [
            ['company_name' => '', 'from' => '', 'to' => '', 'position' => '', 'duties' => ''],
            ['company_name' => '', 'from' => '', 'to' => '', 'position' => '', 'duties' => ''],
            ['company_name' => '', 'from' => '', 'to' => '', 'position' => '', 'duties' => ''],
        ];
        $this->references = [
            ['name' => '', 'company_name' => '', 'position' => '', 'contact_number' => ''],
            ['name' => '', 'company_name' => '', 'position' => '', 'contact_number' => ''],
        ];
    }

    public function updatedWorkAuthorization(string $value): void
    {
        if ($value !== 'Other') {
            $this->work_authorization_other = '';
        }
    }
}
