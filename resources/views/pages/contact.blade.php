@extends('layouts.fixora')

@section('title', __('app.contact.title') . ' — FIXORA')

@section('content')
<div class="bg-autumn min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="text-center mb-10">
            <span class="inline-block bg-fixora-orange/10 text-fixora-orange text-sm font-semibold px-4 py-1.5 rounded-full mb-4">
                {{ __('app.contact.get_in_touch') }}
            </span>
            <h1 class="text-4xl font-bold text-fixora-maroon tracking-tight mb-3">{{ __('app.contact.title') }}</h1>
            <p class="text-lg text-fixora-slate max-w-2xl mx-auto">
                {{ __('app.contact.subtitle') }}
            </p>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- Left: Contact Info --}}
            <div class="lg:col-span-1 space-y-4">

                {{-- Email --}}
                <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-5">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-xl bg-fixora-orange/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-fixora-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-xs text-fixora-mist font-semibold uppercase tracking-wider">{{ __('app.contact.info_email') }}</p>
                    </div>
                    <p class="font-semibold text-fixora-maroon">hello@fixora.ma</p>
                    <p class="text-xs text-fixora-mist mt-1">{{ __('app.contact.info_email_reply') }}</p>
                </div>

                {{-- Location --}}
                <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-5">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-xl bg-fixora-olive/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-fixora-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <p class="text-xs text-fixora-mist font-semibold uppercase tracking-wider">{{ __('app.contact.info_location') }}</p>
                    </div>
                    <p class="font-semibold text-fixora-maroon">{{ __('app.contact.info_location_desc') }}</p>
                    <p class="text-xs text-fixora-mist mt-1">{{ __('app.contact.info_location_available') }}</p>
                </div>

                {{-- Response time --}}
                <div class="bg-fixora-maroon rounded-2xl shadow-card p-5 text-white">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-2 h-2 bg-fixora-orange rounded-full animate-pulse"></span>
                        <p class="text-xs font-semibold uppercase tracking-wider text-fixora-orange">{{ __('app.contact.fast_response') }}</p>
                    </div>
                    <p class="font-bold text-lg">{{ __('app.contact.fast_response_title') }}</p>
                    <p class="text-sm text-white/70 mt-1">{{ __('app.contact.fast_response_time') }}</p>
                </div>
            </div>

            {{-- Right: Contact Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-fixora-maroon mb-2">{{ __('app.contact.form_title') }}</h2>
                    <p class="text-fixora-slate text-sm mb-6">{{ __('app.contact.form_subtitle') }}</p>

                    <form method="POST" action="#" class="space-y-4">
                        @csrf

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.contact.name') }}</label>
                                <input type="text" name="name" required
                                       placeholder="{{ __('app.contact.name') }}"
                                       class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.contact.email') }}</label>
                                <input type="email" name="email" required
                                       placeholder="you@example.com"
                                       class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.contact.subject') }}</label>
                            <select name="subject" required
                                    class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                                <option value="">{{ __('app.contact.subject') }}</option>
                                <option value="general">{{ __('app.contact.subject_general') }}</option>
                                <option value="support">{{ __('app.contact.subject_support') }}</option>
                                <option value="professional">{{ __('app.contact.subject_professional') }}</option>
                                <option value="partnership">{{ __('app.contact.subject_partnership') }}</option>
                                <option value="other">{{ __('app.contact.subject_other') }}</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.contact.message') }}</label>
                            <textarea name="message" rows="6" required
                                      placeholder="{{ __('app.contact.message') }}..."
                                      class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none resize-none"></textarea>
                        </div>

                        <button type="submit"
                                class="w-full bg-fixora-maroon text-white py-3.5 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth shadow-card hover-lift">
                            {{ __('app.contact.send') }}
                        </button>

                        <p class="text-xs text-fixora-mist text-center">
                            {{ __('app.contact.terms') }}
                        </p>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
