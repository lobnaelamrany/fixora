@extends('layouts.fixora')

@section('title', __('app.customer.create_title') . ' — FIXORA')

@section('content')
<div class="bg-autumn min-h-screen py-10">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <a href="{{ route('customer.requests.index') }}"
               class="inline-flex items-center gap-2 text-sm text-fixora-slate hover:text-fixora-orange font-medium transition-smooth mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('app.customer.requests_title') }}
            </a>
            <h1 class="text-3xl font-bold text-fixora-maroon tracking-tight">{{ __('app.customer.create_title') }}</h1>
            <p class="text-fixora-slate mt-1">{{ __('app.customer.create_subtitle') }}</p>
        </div>

        @if ($provider)
            <div class="bg-fixora-orange/10 border border-fixora-orange rounded-2xl p-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-fixora-orange flex items-center justify-center text-white font-bold flex-shrink-0">
                        {{ strtoupper(substr($provider->display_name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-xs text-fixora-slate">{{ __('app.customer.requesting_from') }}</p>
                        <p class="font-semibold text-fixora-maroon">{{ $provider->display_name }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-500 text-red-700 px-4 py-3 rounded-2xl mb-6">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('customer.requests.store') }}"
              class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6 space-y-6">
            @csrf

            @if ($provider)
                <input type="hidden" name="provider_profile_id" value="{{ $provider->id }}">
            @endif

            <div>
                <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.customer.service_category') }} *</label>
                <select name="service_category_id" required
                        class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                    <option value="">{{ __('app.customer.choose_category') }}</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('service_category_id') == $cat->id)>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('service_category_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.customer.request_title') }} *</label>
                <input type="text" name="service_title" value="{{ old('service_title') }}" required
                       placeholder="{{ __('app.customer.request_title_placeholder') }}"
                       class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                @error('service_title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.customer.description') }} *</label>
                <textarea name="description" rows="5" required
                          placeholder="{{ __('app.customer.description_placeholder') }}"
                          class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none resize-none">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.customer.customer_type') }} *</label>
                    <select name="customer_type" required
                            class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                        <option value="individual" @selected(old('customer_type') === 'individual')>{{ __('app.auth.individual') }}</option>
                        <option value="business" @selected(old('customer_type') === 'business')>{{ __('app.auth.business') }}</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.customer.company_name') }}</label>
                    <input type="text" name="company_name" value="{{ old('company_name') }}"
                           class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.customer.city') }} *</label>
                    <input type="text" name="city" value="{{ old('city') }}" required
                           placeholder="{{ __('app.customer.city_placeholder') }}"
                           class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                    @error('city') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.customer.urgency') }} *</label>
                    <select name="urgency_level" required
                            class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                        <option value="normal" @selected(old('urgency_level') === 'normal')>{{ __('app.customer.urgency_normal') }}</option>
                        <option value="urgent" @selected(old('urgency_level') === 'urgent')>{{ __('app.customer.urgency_urgent') }}</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.customer.address') }} *</label>
                <input type="text" name="address" value="{{ old('address') }}" required
                       placeholder="{{ __('app.customer.address_placeholder') }}"
                       class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                @error('address') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.customer.preferred_date') }}</label>
                    <input type="date" name="preferred_date" value="{{ old('preferred_date') }}"
                           class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.customer.preferred_time') }}</label>
                    <input type="time" name="preferred_time" value="{{ old('preferred_time') }}"
                           class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t border-fixora-beige-dark">
                <a href="{{ route('customer.requests.index') }}"
                   class="flex-1 text-center bg-fixora-beige text-fixora-maroon px-6 py-3 rounded-xl font-semibold hover:bg-fixora-beige-dark transition-smooth">
                    {{ __('app.buttons.cancel') }}
                </a>
                <button type="submit"
                        class="flex-1 bg-fixora-maroon text-white px-6 py-3 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth shadow-card hover-lift">
                    {{ __('app.customer.submit_request') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
