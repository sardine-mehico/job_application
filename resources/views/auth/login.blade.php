<x-auth-shell
    title="Employer login"
    heading="Employer sign in"
    description="Sign in to view and manage job applications."
>
    <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
        @csrf

        <div class="space-y-2">
            <label for="email" class="text-sm font-semibold text-stone-700">Username / Email</label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
                autofocus
                class="w-full rounded-[0.475rem] border border-stone-300 bg-white px-5 py-4 text-base outline-none transition focus:border-amber-500 focus:ring-4 focus:ring-amber-100"
            >
            @error('email')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="password" class="text-sm font-semibold text-stone-700">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                required
                class="w-full rounded-[0.475rem] border border-stone-300 bg-white px-5 py-4 text-base outline-none transition focus:border-amber-500 focus:ring-4 focus:ring-amber-100"
            >
        </div>

        <label class="flex items-center gap-3 text-sm text-stone-600">
            <input type="checkbox" name="remember" class="h-5 w-5 rounded-[0.475rem] border-stone-300 text-amber-600 focus:ring-amber-500">
            Keep me signed in
        </label>

        <button type="submit" class="w-full rounded-[0.475rem] bg-stone-900 px-5 py-4 text-base font-semibold text-white transition hover:bg-stone-700">
            Sign in
        </button>
    </form>
</x-auth-shell>
