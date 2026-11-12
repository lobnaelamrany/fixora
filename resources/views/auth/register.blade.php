<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-fixora-maroon tracking-tight mb-2">{{ __('app.auth.register_title') }}</h1>
        <p class="text-fixora-slate">{{ __('app.auth.register_subtitle') }}</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5" x-data="{ role: '{{ old('role', 'customer') }}' }">
        @csrf

        {{-- Role Selection --}}
        <div>
            <label class="block text-sm font-semibold text-fixora-maroon mb-3">
                {{ __('app.auth.i_want_to') }}
            </label>
            <div class="grid grid-cols-2 gap-3">
                {{-- Customer --}}
                <label class="relative cursor-pointer">
                    <input type="radio" name="role" value="customer" x-model="role" class="peer sr-only" {{ old('role', 'customer') === 'customer' ? 'checked' : '' }}>
                    <div class="p-4 rounded-xl border-2 border-fixora-beige-dark bg-white hover:border-fixora-orange/50 transition-smooth peer-checked:border-fixora-orange peer-checked:bg-fixora-orange/5">
                        <div class="flex items-center gap-2 mb-1">
                            <svg class="w-5 h-5 text-fixora-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="font-semibold text-fixora-maroon text-sm">{{ __('app.auth.request_service') }}</span>
                        </div>
                        <p class="text-xs text-fixora-slate">{{ __('app.auth.request_service_desc') }}</p>
                    </div>
                </label>

                {{-- Professional --}}
                <label class="relative cursor-pointer">
                    <input type="radio" name="role" value="professional" x-model="role" class="peer sr-only" {{ old('role') === 'professional' ? 'checked' : '' }}>
                    <div class="p-4 rounded-xl border-2 border-fixora-beige-dark bg-white hover:border-fixora-olive/50 transition-smooth peer-checked:border-fixora-olive peer-checked:bg-fixora-olive/5">
                        <div class="flex items-center gap-2 mb-1">
                            <svg class="w-5 h-5 text-fixora-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="font-semibold text-fixora-maroon text-sm">{{ __('app.auth.offer_service') }}</span>
                        </div>
                        <p class="text-xs text-fixora-slate">{{ __('app.auth.offer_service_desc') }}</p>
                    </div>
                </label>
            </div>
            @error('role') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Name --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.auth.full_name') }}</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   placeholder="{{ __('app.auth.full_name') }}"
                   class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
            @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.auth.email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   placeholder="you@example.com"
                   class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
            @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Professional: Company Name --}}
        <div x-show="role === 'professional'" x-transition>
            <label for="company_name" class="block text-sm font-semibold text-fixora-maroon mb-2">
                {{ __('app.auth.business_name_optional') }}
            </label>
            <input id="company_name" type="text" name="company_name" value="{{ old('company_name') }}"
                   placeholder="e.g. Ahmed Élec"
                   class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
            @error('company_name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Customer: Type --}}
        <div x-show="role === 'customer'" x-transition>
            <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.auth.account_type') }}</label>
            <div class="grid grid-cols-2 gap-3">
                <label class="cursor-pointer">
                    <input type="radio" name="customer_type" value="individual" class="peer sr-only" {{ old('customer_type', 'individual') === 'individual' ? 'checked' : '' }}>
                    <div class="px-4 py-2.5 rounded-xl border-2 border-fixora-beige-dark bg-white text-center text-sm font-medium text-fixora-slate peer-checked:border-fixora-orange peer-checked:text-fixora-orange peer-checked:bg-fixora-orange/5 transition-smooth">
                        {{ __('app.auth.individual') }}
                    </div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="customer_type" value="business" class="peer sr-only" {{ old('customer_type') === 'business' ? 'checked' : '' }}>
                    <div class="px-4 py-2.5 rounded-xl border-2 border-fixora-beige-dark bg-white text-center text-sm font-medium text-fixora-slate peer-checked:border-fixora-orange peer-checked:text-fixora-orange peer-checked:bg-fixora-orange/5 transition-smooth">
                        {{ __('app.auth.business') }}
                    </div>
                </label>
            </div>
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.auth.password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   placeholder="{{ __('app.auth.password_min') }}"
                   class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
            @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Confirm --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.auth.confirm_password') }}</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   placeholder="{{ __('app.auth.password_repeat') }}"
                   class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full bg-fixora-maroon text-white py-3.5 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth hover-lift shadow-card">
            {{ __('app.auth.register') }}
        </button>
    </form>

    <div class="relative my-8">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-fixora-beige-dark"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-3 bg-fixora-offwhite text-fixora-mist">{{ __('app.auth.already_have') }}</span>
        </div>
    </div>

    <a href="{{ route('login') }}"
       class="block w-full text-center border-2 border-fixora-beige-dark text-fixora-maroon py-3.5 rounded-xl font-semibold hover:border-fixora-orange hover:text-fixora-orange transition-smooth">
        {{ __('app.auth.login') }}
    </a>
</x-guest-layout>
