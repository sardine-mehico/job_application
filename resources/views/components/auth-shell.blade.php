@props([
    'title',
    'heading',
    'description',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|outfit:500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[radial-gradient(circle_at_top,_#fde68a,_#f5f5f4_40%,_#d6d3d1)] text-stone-900">
        <main class="mx-auto flex min-h-screen max-w-6xl items-center px-4 py-10 sm:px-6 lg:px-8">
            <div class="grid w-full gap-8 lg:grid-cols-[1.1fr_0.9fr]">
                <section class="rounded-[0.475rem] bg-stone-900 p-8 text-white shadow-2xl sm:p-10">
                    <p class="font-outfit text-sm uppercase tracking-[0.35em] text-amber-300">Cleaning Careers</p>
                    <h1 class="mt-5 max-w-xl text-4xl font-semibold leading-tight sm:text-5xl">{{ $heading }}</h1>
                    <p class="mt-5 max-w-xl text-lg text-stone-300">{{ $description }}</p>
                    <div class="mt-10 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-[0.475rem] border border-white/10 bg-white/5 p-5">
                            <p class="text-sm text-amber-300">Applicant experience</p>
                            <p class="mt-2 text-base text-stone-200">Multi-step, touch-friendly form with a progress tracker and confirmation modal.</p>
                        </div>
                        <div class="rounded-[0.475rem] border border-white/10 bg-white/5 p-5">
                            <p class="text-sm text-amber-300">Employer dashboard</p>
                            <p class="mt-2 text-base text-stone-200">Review, sort, and filter applications by date, suburb, and job title.</p>
                        </div>
                    </div>
                </section>

                <section class="rounded-[0.475rem] border border-stone-200 bg-white p-8 shadow-xl sm:p-10">
                    {{ $slot }}
                </section>
            </div>
        </main>
    </body>
</html>
