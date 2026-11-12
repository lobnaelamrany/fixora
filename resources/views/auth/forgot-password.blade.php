<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-fixora-maroon tracking-tight mb-2">{{ __('app.auth.forgot_title') }}</h1>
        <p class="text-fixora-slate">{{ __('app.auth.forgot_subtitle') }}</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-semibold text-fixora-maroon mb-2">
                {{ __('app.auth.email') }}
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   placeholder="you@example.com"
                   class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
            @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <button type="submit"
                class="w-full bg-fixora-maroon text-white py-3.5 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth hover-lift shadow-card">
            {{ __('app.auth.send_reset_link') }}
        </button>
    </form>

    <div class="mt-8 text-center">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm text-fixora-orange font-medium hover:text-fixora-maroon transition-smooth">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            {{ __('app.auth.back_to_login') }}
        </a>
    </div>
</x-guest-layout>
