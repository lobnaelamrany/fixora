@extends('layouts.fixora')

@section('title', __('app.brand.name') . ' — ' . __('app.brand.tagline'))

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-autumn">
        <div class="absolute top-0 right-0 w-96 h-96 bg-fixora-orange/15 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-fixora-olive/15 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
        <div class="absolute top-1/3 left-1/4 w-64 h-64 bg-fixora-pink/10 rounded-full blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="animate-fade-in-up">
                    <span class="inline-flex items-center gap-2 bg-white/80 border border-fixora-beige-dark text-fixora-olive text-sm font-semibold px-4 py-1.5 rounded-full mb-6 shadow-card">
                        <span class="w-2 h-2 bg-fixora-orange rounded-full animate-pulse-soft"></span>
                        {{ __('app.home.available_morocco') }}
                    </span>

                    <h1 class="text-5xl lg:text-6xl font-bold text-fixora-maroon leading-tight tracking-tight mb-6 text-balance">
                        {{ __('app.home.hero_title') }}
                        <span class="relative inline-block">
                            <span class="relative z-10 text-fixora-orange">{{ __('app.home.hero_title_highlight') }}</span>
                            <span class="absolute bottom-1 left-0 right-0 h-3 bg-fixora-pink/30 -z-0 rounded"></span>
                        </span>
                    </h1>

                    <p class="text-lg text-fixora-slate leading-relaxed mb-8 max-w-lg">
                        {{ __('app.home.hero_subtitle') }}
                    </p>

                    <div class="flex flex-col sm:flex-row gap-3 mb-10">
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center justify-center gap-2 bg-fixora-maroon text-white px-8 py-4 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth hover-lift shadow-hover">
                            {{ __('app.home.request_service') }}
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center justify-center bg-white/80 border-2 border-fixora-beige-dark text-fixora-maroon px-8 py-4 rounded-xl font-semibold hover:border-fixora-olive hover:text-fixora-olive transition-smooth shadow-soft">
                            {{ __('app.home.become_pro') }}
                        </a>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="flex -space-x-3">
                            <div class="w-10 h-10 rounded-full bg-fixora-maroon border-2 border-white flex items-center justify-center text-white text-sm font-bold shadow-card">A</div>
                            <div class="w-10 h-10 rounded-full bg-fixora-orange border-2 border-white flex items-center justify-center text-white text-sm font-bold shadow-card">K</div>
                            <div class="w-10 h-10 rounded-full bg-fixora-olive border-2 border-white flex items-center justify-center text-white text-sm font-bold shadow-card">M</div>
                        </div>
                        <div>
                            <div class="flex text-fixora-orange text-sm">★★★★★</div>
                            <p class="text-sm text-fixora-slate">{{ __('app.home.trusted_by') }}</p>
                        </div>
                    </div>
                </div>

                <div class="relative hidden lg:block">
                    <div class="relative bg-white rounded-2xl shadow-hover p-6 rotate-2 hover:rotate-0 transition-smooth">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-full bg-fixora-orange/15 flex items-center justify-center">
                                <svg class="w-6 h-6 text-fixora-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-fixora-maroon">Ahmed Élec</p>
                                <p class="text-xs text-fixora-slate">Electrician · Casablanca</p>
                            </div>
                            <span class="ml-auto text-fixora-orange font-bold">★ 4.8</span>
                        </div>
                        <div class="space-y-2 mb-4">
                            <div class="h-2 bg-fixora-beige rounded-full"></div>
                            <div class="h-2 bg-fixora-beige rounded-full w-4/5"></div>
                            <div class="h-2 bg-fixora-beige rounded-full w-3/5"></div>
                        </div>
                        <div class="flex gap-2">
                            <span class="text-xs bg-fixora-olive/15 text-fixora-olive px-2 py-1 rounded font-medium">Verified</span>
                            <span class="text-xs bg-fixora-orange/15 text-fixora-orange px-2 py-1 rounded font-medium">Available</span>
                        </div>
                    </div>

                    <div class="absolute -bottom-6 -left-6 bg-white rounded-xl shadow-hover p-4 animate-float">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-fixora-olive flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-fixora-maroon">Request accepted!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section class="bg-white border-y border-fixora-beige-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div>
                    <p class="text-3xl font-bold text-fixora-maroon">8+</p>
                    <p class="text-sm text-fixora-slate mt-1">{{ __('app.home.stats.categories') }}</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-fixora-maroon">12+</p>
                    <p class="text-sm text-fixora-slate mt-1">{{ __('app.home.stats.cities') }}</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-fixora-maroon">100%</p>
                    <p class="text-sm text-fixora-slate mt-1">{{ __('app.home.stats.free') }}</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-fixora-maroon">24/7</p>
                    <p class="text-sm text-fixora-slate mt-1">{{ __('app.home.stats.anytime') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section class="py-20 bg-fixora-beige">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-fixora-orange font-semibold text-sm uppercase tracking-wider">{{ __('app.home.how_it_works') }}</span>
                <h2 class="text-4xl font-bold text-fixora-maroon mt-2 mb-4 tracking-tight">
                    {{ __('app.home.how_it_works_subtitle') }}
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Step 1 --}}
                <div class="relative bg-white rounded-2xl p-8 shadow-card hover:shadow-hover hover-lift border border-fixora-beige-dark/50">
                    <div class="absolute -top-4 left-8 w-8 h-8 rounded-full bg-fixora-maroon text-white flex items-center justify-center font-bold text-sm shadow-card">1</div>
                    <div class="w-14 h-14 bg-fixora-orange/10 rounded-2xl flex items-center justify-center mb-6 mt-2">
                        <svg class="w-7 h-7 text-fixora-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-fixora-maroon mb-2">{{ __('app.home.step1_title') }}</h3>
                    <p class="text-fixora-slate leading-relaxed">{{ __('app.home.step1_desc') }}</p>
                </div>

                {{-- Step 2 --}}
                <div class="relative bg-white rounded-2xl p-8 shadow-card hover:shadow-hover hover-lift border border-fixora-beige-dark/50">
                    <div class="absolute -top-4 left-8 w-8 h-8 rounded-full bg-fixora-maroon text-white flex items-center justify-center font-bold text-sm shadow-card">2</div>
                    <div class="w-14 h-14 bg-fixora-olive/10 rounded-2xl flex items-center justify-center mb-6 mt-2">
                        <svg class="w-7 h-7 text-fixora-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-fixora-maroon mb-2">{{ __('app.home.step2_title') }}</h3>
                    <p class="text-fixora-slate leading-relaxed">{{ __('app.home.step2_desc') }}</p>
                </div>

                {{-- Step 3 --}}
                <div class="relative bg-white rounded-2xl p-8 shadow-card hover:shadow-hover hover-lift border border-fixora-beige-dark/50">
                    <div class="absolute -top-4 left-8 w-8 h-8 rounded-full bg-fixora-maroon text-white flex items-center justify-center font-bold text-sm shadow-card">3</div>
                    <div class="w-14 h-14 bg-fixora-pink/10 rounded-2xl flex items-center justify-center mb-6 mt-2">
                        <svg class="w-7 h-7 text-fixora-pink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-fixora-maroon mb-2">{{ __('app.home.step3_title') }}</h3>
                    <p class="text-fixora-slate leading-relaxed">{{ __('app.home.step3_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Categories --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-fixora-maroon mb-4 tracking-tight">{{ __('app.home.services_title') }}</h2>
                <p class="text-lg text-fixora-slate">{{ __('app.home.services_subtitle') }}</p>
            </div>

            @php
                $categories = \App\Models\ServiceCategory::active()->root()->withCount('providers')->get();
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($categories as $category)
                    <a href="{{ route('categories.show', $category) }}"
                       class="group bg-fixora-beige-light border border-fixora-beige-dark rounded-2xl p-6 hover:border-fixora-orange hover:shadow-card transition-smooth hover-lift">
                        <h3 class="text-lg font-bold text-fixora-maroon group-hover:text-fixora-orange mb-2 transition-smooth">
                            {{ $category->name }}
                        </h3>
                        <p class="text-sm text-fixora-slate mb-3 line-clamp-2">{{ $category->description }}</p>
                        <span class="text-xs text-fixora-mist font-medium">{{ $category->providers_count }} {{ __('app.categories.professionals') }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="relative overflow-hidden bg-fixora-maroon py-20">
        <div class="absolute top-0 right-0 w-96 h-96 bg-fixora-orange/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-fixora-pink/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-white mb-4 tracking-tight">{{ __('app.home.cta_title') }}</h2>
            <p class="text-xl text-fixora-beige-light/80 mb-8">{{ __('app.home.cta_subtitle') }}</p>
            <a href="{{ route('register') }}"
               class="inline-block bg-fixora-orange text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-white hover:text-fixora-maroon transition-smooth hover-lift shadow-hover">
                {{ __('app.home.cta_button') }}
            </a>
        </div>
    </section>
@endsection
