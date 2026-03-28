@php
    $rankLabels = [
        1 => 'Perfect Match',
        2 => 'Desirable',
        3 => 'Acceptable',
        4 => 'Avoid if possible',
        5 => 'DO NOT HIRE',
    ];
@endphp

<div class="min-h-screen bg-stone-100">
    <header class="bg-stone-900 text-white">
        <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
            <div>
                <h1 class="text-[1.1rem] font-semibold">Job applications</h1>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-[0.475rem] border border-white/15 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                    Log out
                </button>
            </form>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <section class="rounded-[0.475rem] bg-white p-6 shadow-lg sm:p-8">
            <div class="grid gap-4 lg:grid-cols-4">
                <div>
                    <label class="text-sm font-semibold text-stone-700">Suburb</label>
                    <select wire:model.live="suburb" class="mt-2 w-full rounded-[0.475rem] border border-stone-300 bg-white px-4 py-3 text-base outline-none transition focus:border-amber-500 focus:ring-4 focus:ring-amber-100">
                        <option value="">All suburbs</option>
                        @foreach ($suburbs as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold text-stone-700">Date from</label>
                    <input type="date" wire:model.live="dateFrom" class="mt-2 w-full rounded-[0.475rem] border border-stone-300 bg-white px-4 py-3 text-base outline-none transition focus:border-amber-500 focus:ring-4 focus:ring-amber-100">
                </div>
                <div>
                    <label class="text-sm font-semibold text-stone-700">Date to</label>
                    <input type="date" wire:model.live="dateTo" class="mt-2 w-full rounded-[0.475rem] border border-stone-300 bg-white px-4 py-3 text-base outline-none transition focus:border-amber-500 focus:ring-4 focus:ring-amber-100">
                </div>
                <div class="flex items-end">
                    <button type="button" wire:click="clearFilters" class="w-full rounded-[0.475rem] border border-stone-300 px-4 py-3 text-base font-semibold text-stone-700 transition hover:bg-stone-100">
                        Clear filters
                    </button>
                </div>
            </div>

            <div class="mt-8 overflow-hidden rounded-[0.475rem] border border-stone-200">
                <table class="min-w-full divide-y divide-stone-200">
                    <thead class="bg-stone-50">
                        <tr class="text-left text-sm font-semibold text-stone-700">
                            <th class="px-5 py-4">
                                <button wire:click="sortBy('created_at')" type="button" class="inline-flex items-center gap-2 text-left transition hover:text-stone-900">
                                    <span>Date</span>
                                    <span class="text-xs">{{ $sortField === 'created_at' ? ($sortDirection === 'asc' ? '▲' : '▼') : '↕' }}</span>
                                </button>
                            </th>
                            <th class="px-5 py-4">
                                <button wire:click="sortBy('name')" type="button" class="inline-flex items-center gap-2 text-left transition hover:text-stone-900">
                                    <span>Name</span>
                                    <span class="text-xs">{{ $sortField === 'name' ? ($sortDirection === 'asc' ? '▲' : '▼') : '↕' }}</span>
                                </button>
                            </th>
                            <th class="px-5 py-4">
                                <button wire:click="sortBy('suburb')" type="button" class="inline-flex items-center gap-2 text-left transition hover:text-stone-900">
                                    <span>Suburb</span>
                                    <span class="text-xs">{{ $sortField === 'suburb' ? ($sortDirection === 'asc' ? '▲' : '▼') : '↕' }}</span>
                                </button>
                            </th>
                            <th class="px-5 py-4">Contact</th>
                            <th class="px-5 py-4">
                                <button wire:click="sortBy('applicant_rank')" type="button" class="inline-flex items-center gap-2 text-left transition hover:text-stone-900">
                                    <span>Rank</span>
                                    <span class="text-xs">{{ $sortField === 'applicant_rank' ? ($sortDirection === 'asc' ? '▲' : '▼') : '↕' }}</span>
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200 bg-white">
                        @forelse ($applications as $application)
                            <tr
                                wire:click="openApplication({{ $application->id }})"
                                class="{{ $this->applicationRowClasses($application, $selectedApplication?->id === $application->id) }}"
                            >
                                <td class="px-5 py-4">{{ $application->created_at->format('d M Y') }}</td>
                                <td class="px-5 py-4 font-semibold text-stone-900">{{ $application->full_name }}</td>
                                <td class="px-5 py-4">{{ $application->suburb }}</td>
                                <td class="px-5 py-4">
                                    <div>{{ $application->contact_number }}</div>
                                    <div class="mt-1 text-stone-500">{{ $application->email }}</div>
                                </td>
                                <td class="px-5 py-4">
                                    {{ $application->applicant_rank ? $application->applicant_rank . ' - ' . $rankLabels[$application->applicant_rank] : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center text-stone-500">No applications match the current filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($selectedApplication)
                <section class="mt-8 rounded-[0.475rem] border border-stone-200 bg-stone-50 p-6 shadow-sm sm:p-8">
                    <div class="flex flex-col gap-4 border-b border-stone-200 pb-6 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <div class="flex flex-wrap items-center gap-3">
                                <h2 class="text-2xl font-semibold text-stone-900">{{ $selectedApplication->full_name }}</h2>
                                @if ($selectedApplication->applicant_rank)
                                    <span class="rounded-[0.475rem] bg-amber-100 px-3 py-1 text-sm font-semibold text-amber-900">
                                        Rank {{ $selectedApplication->applicant_rank }} - {{ $rankLabels[$selectedApplication->applicant_rank] }}
                                    </span>
                                @endif
                            </div>
                            <p class="mt-2 text-sm text-stone-500">Submitted {{ $selectedApplication->created_at->format('d M Y') }}</p>
                        </div>

                        <dl class="grid gap-3 text-sm text-stone-700 sm:grid-cols-2 lg:min-w-[20rem]">
                            <div>
                                <dt class="font-semibold text-stone-900">Suburb</dt>
                                <dd class="mt-1">{{ $selectedApplication->suburb }}</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-stone-900">Postcode</dt>
                                <dd class="mt-1">{{ $selectedApplication->postcode }}</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-stone-900">Contact</dt>
                                <dd class="mt-1">{{ $selectedApplication->contact_number }}</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-stone-900">Email</dt>
                                <dd class="mt-1 break-all">{{ $selectedApplication->email }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="grid gap-6 pt-6 lg:grid-cols-2">
                        <section class="space-y-4">
                            <h3 class="text-lg font-semibold text-stone-900">Submitted details</h3>

                            <div class="grid gap-4 text-sm text-stone-700 sm:grid-cols-2">
                                <div class="rounded-[0.475rem] border border-stone-200 bg-white px-4 py-3">
                                    <div class="font-semibold text-stone-900">Street address</div>
                                    <div class="mt-1">{{ $selectedApplication->street_address }}</div>
                                </div>
                                <div class="rounded-[0.475rem] border border-stone-200 bg-white px-4 py-3">
                                    <div class="font-semibold text-stone-900">Work rights</div>
                                    <div class="mt-1">{{ $selectedApplication->work_authorization }}</div>
                                    @if ($selectedApplication->work_authorization === 'Other' && filled($selectedApplication->work_authorization_other))
                                        <div class="mt-1 text-stone-500">Visa type: {{ $selectedApplication->work_authorization_other }}</div>
                                    @endif
                                </div>
                                <div class="{{ $this->detailHighlightClasses($selectedApplication, 'reliable_transport') }}">
                                    <div class="font-semibold text-stone-900">Reliable transport</div>
                                    <div class="mt-1">{{ $selectedApplication->reliable_transport }}</div>
                                </div>
                                <div class="{{ $this->detailHighlightClasses($selectedApplication, 'drivers_licence') }}">
                                    <div class="font-semibold text-stone-900">Driver's licence</div>
                                    <div class="mt-1">{{ $selectedApplication->drivers_licence }}</div>
                                </div>
                                <div class="{{ $this->detailHighlightClasses($selectedApplication, 'criminal_history') }}">
                                    <div class="font-semibold text-stone-900">Criminal history</div>
                                    <div class="mt-1">{{ $selectedApplication->criminal_history }}</div>
                                </div>
                                <div class="rounded-[0.475rem] border border-stone-200 bg-white px-4 py-3">
                                    <div class="font-semibold text-stone-900">Police clearance</div>
                                    <div class="mt-1">{{ $selectedApplication->police_clearance }}</div>
                                </div>
                                <div class="sm:col-span-2 {{ $this->detailHighlightClasses($selectedApplication, 'workers_compensation') }}">
                                    <div class="font-semibold text-stone-900">Workers compensation</div>
                                    <div class="mt-1">{{ $selectedApplication->workers_compensation }}</div>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-sm font-semibold uppercase tracking-[0.2em] text-stone-500">Availability</h4>
                                @if (! empty($selectedApplication->availability))
                                    <div class="mt-3 grid gap-3 text-sm text-stone-700 sm:grid-cols-2">
                                        @foreach ($selectedApplication->availability as $day => $value)
                                            @if (filled($value))
                                                <div class="rounded-[0.475rem] border border-stone-200 bg-white px-4 py-3">
                                                    <span class="font-semibold text-stone-900">{{ ucfirst($day) }}:</span>
                                                    {{ $value }}
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p class="mt-3 text-sm text-stone-500">No availability details were provided.</p>
                                @endif
                            </div>

                            <div>
                                <h4 class="text-sm font-semibold uppercase tracking-[0.2em] text-stone-500">Education</h4>
                                @if (! empty($selectedApplication->education))
                                    <div class="mt-3 space-y-3">
                                        @foreach ($selectedApplication->education as $item)
                                            <div class="rounded-[0.475rem] border border-stone-200 bg-white px-4 py-3 text-sm text-stone-700">
                                                <div class="font-semibold text-stone-900">{{ $item['qualification'] ?: 'Qualification not provided' }}</div>
                                                <div class="mt-1">{{ $item['institute'] ?: 'Institute not provided' }}</div>
                                                @if (! empty($item['year']))
                                                    <div class="mt-1 text-stone-500">Year: {{ $item['year'] }}</div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="mt-3 text-sm text-stone-500">No education history was provided.</p>
                                @endif
                            </div>
                        </section>

                        <section class="space-y-4">
                            <div>
                                <h4 class="text-sm font-semibold uppercase tracking-[0.2em] text-stone-500">Work history</h4>
                                @if (! empty($selectedApplication->work_history))
                                    <div class="mt-3 space-y-3">
                                        @foreach ($selectedApplication->work_history as $item)
                                            <div class="rounded-[0.475rem] border border-stone-200 bg-white px-4 py-3 text-sm text-stone-700">
                                                <div class="font-semibold text-stone-900">{{ $item['company_name'] ?: 'Company not provided' }}</div>
                                                <div class="mt-1">{{ $item['position'] ?: 'Position not provided' }}</div>
                                                @if (! empty($item['from']) || ! empty($item['to']))
                                                    <div class="mt-1 text-stone-500">
                                                        {{ $item['from'] ?: 'Start n/a' }} to {{ $item['to'] ?: 'End n/a' }}
                                                    </div>
                                                @endif
                                                @if (! empty($item['duties']))
                                                    <div class="mt-2 text-stone-600">{{ $item['duties'] }}</div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="mt-3 text-sm text-stone-500">No work history was provided.</p>
                                @endif
                            </div>

                            <div>
                                <h4 class="text-sm font-semibold uppercase tracking-[0.2em] text-stone-500">References</h4>
                                @if (! empty($selectedApplication->references))
                                    <div class="mt-3 space-y-3">
                                        @foreach ($selectedApplication->references as $item)
                                            <div class="rounded-[0.475rem] border border-stone-200 bg-white px-4 py-3 text-sm text-stone-700">
                                                <div class="font-semibold text-stone-900">{{ $item['name'] ?: 'Name not provided' }}</div>
                                                <div class="mt-1">{{ $item['company_name'] ?: 'Company not provided' }}</div>
                                                @if (! empty($item['position']))
                                                    <div class="mt-1">Position: {{ $item['position'] }}</div>
                                                @endif
                                                @if (! empty($item['contact_number']))
                                                    <div class="mt-1 text-stone-500">Contact: {{ $item['contact_number'] }}</div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="mt-3 text-sm text-stone-500">No references were provided.</p>
                                @endif
                            </div>

                            <div class="rounded-[0.475rem] border border-stone-200 bg-white p-5">
                                <div class="flex items-center justify-between gap-4">
                                    <h3 class="text-lg font-semibold text-stone-900">Employer review</h3>
                                    @if ($savedApplicationId === $selectedApplication->id)
                                        <span class="text-sm font-semibold text-emerald-700">Saved</span>
                                    @endif
                                </div>

                                <div class="mt-4">
                                    <label class="text-sm font-semibold text-stone-700">Applicant rank</label>
                                    <p class="mt-1 text-sm text-stone-500">1 - Perfect Match, 2 - Desirable, 3 - Acceptable, 4 - Avoid if possible, 5 - DO NOT HIRE</p>
                                    @if (in_array($rankings[$selectedApplication->id] ?? '', ['4'], true))
                                        <p class="mt-2 text-sm font-semibold text-red-700">This application includes a serious flag and has been preselected as 4 - Avoid if possible.</p>
                                    @endif
                                    <select wire:model="rankings.{{ $selectedApplication->id }}" class="mt-2 w-full rounded-[0.475rem] border border-stone-300 bg-white px-4 py-3 text-base outline-none transition focus:border-amber-500 focus:ring-4 focus:ring-amber-100">
                                        <option value="">Not ranked</option>
                                        <option value="1">1 - Perfect Match</option>
                                        <option value="2">2 - Desirable</option>
                                        <option value="3">3 - Acceptable</option>
                                        <option value="4">4 - Avoid if possible</option>
                                        <option value="5">5 - DO NOT HIRE</option>
                                    </select>
                                </div>

                                <div class="mt-4">
                                    <label class="text-sm font-semibold text-stone-700">Internal notes</label>
                                    <textarea wire:model="notes.{{ $selectedApplication->id }}" rows="5" class="mt-2 w-full rounded-[0.475rem] border border-stone-300 bg-white px-4 py-3 text-base outline-none transition focus:border-amber-500 focus:ring-4 focus:ring-amber-100"></textarea>
                                </div>

                                <div class="mt-4">
                                    <button type="button" wire:click="saveReview({{ $selectedApplication->id }})" class="rounded-[0.475rem] bg-amber-500 px-5 py-3 text-sm font-semibold text-stone-950 transition hover:bg-amber-400">
                                        Save review
                                    </button>
                                </div>
                            </div>
                        </section>
                    </div>
                </section>
            @endif

            <div class="mt-8">
                {{ $applications->links() }}
            </div>
        </section>
    </main>
</div>
