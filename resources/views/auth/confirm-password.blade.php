<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-fixora-maroon tracking-tight mb-2">{{ __('app.auth.confirm_password_title') }}</h1>
        <p class="text-fixora-slate">{{ __('app.auth.confirm_password_subtitle') }}</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <div>
            <label for="password" class="block text-sm font-semibold text-fixora-maroon mb-2">
                {{ __('app.auth.password') }}
            </label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   placeholder="••••••••"
                   class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
            @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <button type="submit"
                class="w-full bg-fixora-maroon text-white py-3.5 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth hover-lift shadow-card">
            {{ __('app.auth.confirm') }}
        </button>
    </form>
</x-guest-layout>
