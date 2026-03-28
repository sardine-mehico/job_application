@php
    $inputClasses = 'mt-2 w-full rounded-[0.475rem] border border-stone-300 bg-white px-5 py-4 text-base text-stone-900 outline-none transition focus:border-amber-500 focus:ring-4 focus:ring-amber-100';
    $labelClasses = 'text-sm font-semibold text-stone-700';
@endphp

<div class="min-h-screen bg-[linear-gradient(180deg,_#292524_0%,_#292524_24rem,_#f5f5f4_24rem,_#f5f5f4_100%)]">
    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <section class="rounded-[0.475rem] bg-white p-6 shadow-xl sm:p-8">
            <div class="mb-6">
                <h1 class="font-outfit text-3xl font-semibold text-stone-900 sm:text-4xl">Employment Application</h1>
                <p class="mt-3 text-sm font-semibold uppercase tracking-[0.25em] text-amber-600">Step {{ $step }} of {{ count($steps) }}</p>
            </div>

            <form wire:submit="{{ $step === count($steps) ? 'submit' : 'nextStep' }}" class="space-y-8">
                    @if ($step === 1)
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label class="{{ $labelClasses }}">First Name:</label>
                                <input type="text" wire:model="first_name" class="{{ $inputClasses }}">
                                @error('first_name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="{{ $labelClasses }}">Last Name:</label>
                                <input type="text" wire:model="last_name" class="{{ $inputClasses }}">
                                @error('last_name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label class="{{ $labelClasses }}">Street Name & No:</label>
                                <input type="text" wire:model="street_address" class="{{ $inputClasses }}">
                                @error('street_address') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="{{ $labelClasses }}">Suburb:</label>
                                <input type="text" wire:model="suburb" class="{{ $inputClasses }}">
                                @error('suburb') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="{{ $labelClasses }}">Postcode:</label>
                                <input type="text" inputmode="numeric" wire:model="postcode" class="{{ $inputClasses }}">
                                @error('postcode') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="{{ $labelClasses }}">Contact No:</label>
                                <input type="text" inputmode="tel" wire:model="contact_number" class="{{ $inputClasses }}">
                                @error('contact_number') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="{{ $labelClasses }}">Email Address:</label>
                                <input type="email" wire:model="email" class="{{ $inputClasses }}">
                                @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    @endif

                    @if ($step === 2)
                        <div class="space-y-5">
                            <div>
                                <label class="{{ $labelClasses }}">Do you have permission to work in Australia? Visa - Residency Status</label>
                                <select wire:model="work_authorization" class="{{ $inputClasses }}">
                                    <option value=""></option>
                                    <option>Student Visa</option>
                                    <option>Working Holiday</option>
                                    <option>Work Visa</option>
                                    <option>Partner visa</option>
                                    <option>Australian Citizen</option>
                                    <option>Australian P.R.</option>
                                    <option>Other</option>
                                </select>
                                @error('work_authorization') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            @if ($work_authorization === 'Other')
                                <div>
                                    <label class="{{ $labelClasses }}">Please explain visa type</label>
                                    <input type="text" wire:model="work_authorization_other" class="{{ $inputClasses }}" placeholder="e.g. Bridging visa">
                                    @error('work_authorization_other') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            @endif
                            <div>
                                <label class="{{ $labelClasses }}">Do you have a reliable transport?</label>
                                <select wire:model="reliable_transport" class="{{ $inputClasses }}">
                                    <option value=""></option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                                @error('reliable_transport') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="{{ $labelClasses }}">Do you have a current driving licence?</label>
                                <select wire:model="drivers_licence" class="{{ $inputClasses }}">
                                    <option value=""></option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                                @error('drivers_licence') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="{{ $labelClasses }}">Do you have any pending criminal charges or have you been convicted of any crimes in Australia or overseas?</label>
                                <select wire:model="criminal_history" class="{{ $inputClasses }}">
                                    <option value=""></option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                                @error('criminal_history') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="{{ $labelClasses }}">Do you have a current police clearance (less than 12 months old)? or are you willing to apply for one?</label>
                                <select wire:model="police_clearance" class="{{ $inputClasses }}">
                                    <option value=""></option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                                @error('police_clearance') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="{{ $labelClasses }}">Have you ever claimed Workers Compensation, Accident / Sickness Insurance?</label>
                                <select wire:model="workers_compensation" class="{{ $inputClasses }}">
                                    <option value=""></option>
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                                @error('workers_compensation') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    @endif

                    @if ($step === 3)
                        <div class="grid gap-5">
                            <div>
                                <h2 class="text-xl font-semibold text-stone-900">Your Availibility</h2>
                            </div>
                            @foreach ([
                                'monday' => 'e.g. All day',
                                'tuesday' => 'e.g. 5am to 11am +  6pm to 11pm',
                                'wednesday' => 'e.g. 3pm to 11pm',
                                'thursday' => 'e.g. 5am to 10am',
                                'friday' => 'e.g. All day',
                                'saturday' => 'e.g. All day',
                                'sunday' => 'e.g. All day',
                            ] as $day => $placeholder)
                                <div>
                                    <label class="{{ $labelClasses }}">{{ ucfirst($day) }}:</label>
                                    <input type="text" wire:model="availability.{{ $day }}" class="{{ $inputClasses }}" placeholder="{{ $placeholder }}">
                                    @error("availability.$day") <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($step === 4)
                        <div class="space-y-6">
                            @foreach ($education as $index => $row)
                                <div class="rounded-[0.475rem] border border-stone-200 bg-stone-50 p-5">
                                    <p class="font-outfit text-sm uppercase tracking-[0.25em] text-amber-700">Education {{ $index + 1 }}</p>
                                    <div class="mt-4 grid gap-5 sm:grid-cols-[0.35fr_1fr_1fr]">
                                        <div>
                                            <label class="{{ $labelClasses }}">Year</label>
                                            <input type="text" wire:model="education.{{ $index }}.year" class="{{ $inputClasses }}" placeholder="{{ $index === 0 ? 'e.g. 1999' : '' }}">
                                        </div>
                                        <div>
                                            <label class="{{ $labelClasses }}">Educational Institute</label>
                                            <input type="text" wire:model="education.{{ $index }}.institute" class="{{ $inputClasses }}" placeholder="{{ $index === 0 ? 'e.g. WA School of Arts' : '' }}">
                                        </div>
                                        <div>
                                            <label class="{{ $labelClasses }}">Qualification Gained</label>
                                            <input type="text" wire:model="education.{{ $index }}.qualification" class="{{ $inputClasses }}" placeholder="{{ $index === 0 ? 'e.g. Diploma in History-Arts' : '' }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($step === 5)
                        <div class="space-y-6">
                            @foreach ($work_history as $index => $job)
                                <div class="rounded-[0.475rem] border border-stone-200 bg-stone-50 p-5">
                                    <p class="font-outfit text-sm uppercase tracking-[0.25em] text-amber-700">Work History {{ $index + 1 }}</p>
                                    <div class="mt-4 grid gap-5 sm:grid-cols-2">
                                        <div class="sm:col-span-2">
                                            <label class="{{ $labelClasses }}">
                                                {{ $index === 2 ? 'Company' : 'Company Name' }}
                                                @if ($index === 0)
                                                    <span class="text-red-600">*</span>
                                                @endif
                                            </label>
                                            <input type="text" wire:model="work_history.{{ $index }}.company_name" class="{{ $inputClasses }}">
                                            @error("work_history.$index.company_name") <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label class="{{ $labelClasses }}">
                                                From
                                                @if ($index === 0)
                                                    <span class="text-red-600">*</span>
                                                @endif
                                            </label>
                                            <input type="date" wire:model="work_history.{{ $index }}.from" class="{{ $inputClasses }}">
                                            @error("work_history.$index.from") <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label class="{{ $labelClasses }}">
                                                To
                                                @if ($index === 0)
                                                    <span class="text-red-600">*</span>
                                                @endif
                                            </label>
                                            <input type="date" wire:model="work_history.{{ $index }}.to" class="{{ $inputClasses }}">
                                            @error("work_history.$index.to") <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="{{ $labelClasses }}">
                                                Position
                                                @if ($index === 0)
                                                    <span class="text-red-600">*</span>
                                                @endif
                                            </label>
                                            <input type="text" wire:model="work_history.{{ $index }}.position" class="{{ $inputClasses }}" placeholder="{{ $index === 0 ? 'e.g. Cleaner' : '' }}">
                                            @error("work_history.$index.position") <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="{{ $labelClasses }}">
                                                Duties Performed
                                                @if ($index === 0)
                                                    <span class="text-red-600">*</span>
                                                @endif
                                            </label>
                                            <textarea wire:model="work_history.{{ $index }}.duties" class="{{ $inputClasses }} min-h-32" placeholder="{{ $index === 0 ? 'e.r.  -Supervising cleaners   -Cleaning of desks   -Rubbish removal   -Property inspection' : '' }}"></textarea>
                                            @error("work_history.$index.duties") <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($step === 6)
                        <div class="space-y-6">
                            @foreach ($references as $index => $reference)
                                <div class="rounded-[0.475rem] border border-stone-200 bg-stone-50 p-5">
                                    <p class="font-outfit text-sm uppercase tracking-[0.25em] text-amber-700">Reference {{ $index + 1 }}</p>
                                    <div class="mt-4 grid gap-5 sm:grid-cols-2">
                                        <div>
                                            <label class="{{ $labelClasses }}">Name:</label>
                                            <input type="text" wire:model="references.{{ $index }}.name" class="{{ $inputClasses }}">
                                            @error("references.$index.name") <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label class="{{ $labelClasses }}">Company Name:</label>
                                            <input type="text" wire:model="references.{{ $index }}.company_name" class="{{ $inputClasses }}">
                                            @error("references.$index.company_name") <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label class="{{ $labelClasses }}">Position:</label>
                                            <input type="text" wire:model="references.{{ $index }}.position" class="{{ $inputClasses }}">
                                            @error("references.$index.position") <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                        </div>
                                        <div>
                                            <label class="{{ $labelClasses }}">Contact No:</label>
                                            <input type="text" wire:model="references.{{ $index }}.contact_number" class="{{ $inputClasses }}">
                                            @error("references.$index.contact_number") <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex flex-col gap-3 border-t border-stone-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex gap-3">
                            @if ($step > 1)
                                <button type="button" wire:click="previousStep" class="rounded-[0.475rem] border border-stone-300 px-5 py-4 text-base font-semibold text-stone-700 transition hover:bg-stone-100">
                                    Back
                                </button>
                            @endif
                            <button type="submit" class="rounded-[0.475rem] bg-amber-500 px-6 py-4 text-base font-semibold text-stone-950 transition hover:bg-amber-400">
                                {{ $step === count($steps) ? 'Submit Application' : 'Continue' }}
                            </button>
                        </div>
                    </div>
            </form>
        </section>
    </div>

    @if ($showThankYouModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-stone-950/70 px-4">
            <div class="w-full max-w-md rounded-[0.475rem] bg-white p-8 text-center shadow-2xl">
                <p class="font-outfit text-sm uppercase tracking-[0.3em] text-amber-600">Application received</p>
                <h3 class="mt-3 text-3xl font-semibold text-stone-900">Thank you</h3>
                <p class="mt-4 text-base leading-7 text-stone-600">Your application has been submitted successfully.</p>
                <a href="https://www.google.com" class="mt-8 inline-flex w-full items-center justify-center rounded-[0.475rem] bg-stone-900 px-5 py-4 text-base font-semibold text-white transition hover:bg-stone-700">
                    OK
                </a>
            </div>
        </div>
    @endif
</div>
