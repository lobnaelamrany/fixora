<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-fixora-maroon tracking-tight mb-2">{{ __('app.auth.reset_password_title') }}</h1>
        <p class="text-fixora-slate">{{ __('app.auth.reset_password_subtitle') }}</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.auth.email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                   placeholder="you@example.com"
                   class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
            @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.auth.new_password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   placeholder="{{ __('app.auth.password_min') }}"
                   class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
            @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.auth.confirm_new_password') }}</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   placeholder="{{ __('app.auth.password_repeat') }}"
                   class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
            @error('password_confirmation') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <button type="submit"
                class="w-full bg-fixora-maroon text-white py-3.5 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth hover-lift shadow-card">
            {{ __('app.auth.reset_password') }}
        </button>
    </form>
</x-guest-layout>
