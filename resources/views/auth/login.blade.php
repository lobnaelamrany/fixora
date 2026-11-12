<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-fixora-maroon tracking-tight mb-2">{{ __('app.auth.welcome_back') }}</h1>
        <p class="text-fixora-slate">{{ __('app.auth.login_subtitle') }}</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-semibold text-fixora-maroon mb-2">
                {{ __('app.auth.email') }}
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   placeholder="you@example.com"
                   class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
            @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-sm font-semibold text-fixora-maroon">
                    {{ __('app.auth.password') }}
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-fixora-orange hover:text-fixora-maroon font-medium transition-smooth">
                        {{ __('app.auth.forgot') }}
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   placeholder="••••••••"
                   class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
            @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                   class="w-4 h-4 rounded border-fixora-beige-dark text-fixora-orange focus:ring-fixora-orange focus:ring-2 transition-smooth">
            <label for="remember_me" class="ms-2 text-sm text-fixora-slate cursor-pointer">
                {{ __('app.auth.remember') }}
            </label>
        </div>

        <button type="submit"
                class="w-full bg-fixora-maroon text-white py-3.5 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth hover-lift shadow-card">
            {{ __('app.auth.login') }}
        </button>
    </form>

    <div class="relative my-8">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-fixora-beige-dark"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-3 bg-fixora-offwhite text-fixora-mist">{{ __('app.auth.new_to_fixora') }}</span>
        </div>
    </div>

    <a href="{{ route('register') }}"
       class="block w-full text-center border-2 border-fixora-beige-dark text-fixora-maroon py-3.5 rounded-xl font-semibold hover:border-fixora-orange hover:text-fixora-orange transition-smooth">
        {{ __('app.auth.create_account') }}
    </a>
</x-guest-layout>
