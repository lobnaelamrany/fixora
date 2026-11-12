@extends('layouts.fixora')

@section('title', __('app.about.title') . ' — FIXORA')

@section('content')

{{-- Hero --}}
<section class="relative overflow-hidden bg-autumn py-20">
    <div class="absolute top-0 right-0 w-96 h-96 bg-fixora-orange/15 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-fixora-pink/15 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-block bg-fixora-orange/10 text-fixora-orange text-sm font-semibold px-4 py-1.5 rounded-full mb-6">
            {{ __('app.about.title') }}
        </span>
        <h1 class="text-5xl lg:text-6xl font-bold text-fixora-maroon leading-tight tracking-tight mb-6">
            {{ __('app.about.hero_title') }}
        </h1>
        <p class="text-xl text-fixora-slate leading-relaxed max-w-2xl mx-auto">
            {{ __('app.about.hero_subtitle') }}
        </p>
    </div>
</section>

{{-- Mission --}}
<section class="py-20 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-fixora-orange font-semibold text-sm uppercase tracking-wider">{{ __('app.about.mission_title') }}</span>
                <h2 class="text-4xl font-bold text-fixora-maroon mt-3 mb-6 tracking-tight">
                    {{ __('app.about.mission_heading') }}
                </h2>
                <p class="text-fixora-slate leading-relaxed mb-4">
                    {{ __('app.about.mission_p1') }}
                </p>
                <p class="text-fixora-slate leading-relaxed">
                    {{ __('app.about.mission_p2') }}
                </p>
            </div>

            <div class="bg-fixora-beige rounded-2xl p-8">
                <div class="space-y-4">
                    {{-- Find --}}
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-fixora-orange/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-fixora-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-fixora-maroon mb-1">{{ __('app.about.find') }}</h3>
                            <p class="text-sm text-fixora-slate">{{ __('app.about.find_desc') }}</p>
                        </div>
                    </div>

                    {{-- Connect --}}
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-fixora-olive/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-fixora-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-fixora-maroon mb-1">{{ __('app.about.connect') }}</h3>
                            <p class="text-sm text-fixora-slate">{{ __('app.about.connect_desc') }}</p>
                        </div>
                    </div>

                    {{-- Fix --}}
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-fixora-pink/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-fixora-pink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-fixora-maroon mb-1">{{ __('app.about.fix') }}</h3>
                            <p class="text-sm text-fixora-slate">{{ __('app.about.fix_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Values --}}
<section class="py-20 bg-fixora-beige">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-fixora-orange font-semibold text-sm uppercase tracking-wider">{{ __('app.about.values_title') }}</span>
            <h2 class="text-4xl font-bold text-fixora-maroon mt-3 tracking-tight">
                {{ __('app.about.values_heading') }}
            </h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach ([
                ['icon' => 'shield', 'title' => __('app.about.value_trust'), 'desc' => __('app.about.value_trust_desc')],
                ['icon' => 'sparkles', 'title' => __('app.about.value_simplicity'), 'desc' => __('app.about.value_simplicity_desc')],
                ['icon' => 'users', 'title' => __('app.about.value_community'), 'desc' => __('app.about.value_community_desc')],
            ] as $value)
                <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-8 hover:shadow-hover hover-lift transition-smooth">
                    <div class="w-14 h-14 rounded-2xl bg-fixora-orange/10 flex items-center justify-center mb-5">
                        @if ($value['icon'] === 'shield')
                            <svg class="w-7 h-7 text-fixora-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        @elseif ($value['icon'] === 'sparkles')
                            <svg class="w-7 h-7 text-fixora-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        @else
                            <svg class="w-7 h-7 text-fixora-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold text-fixora-maroon mb-2">{{ $value['title'] }}</h3>
                    <p class="text-fixora-slate leading-relaxed">{{ $value['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="py-16 bg-fixora-maroon">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <p class="text-4xl font-bold text-white mb-2">{{ \App\Models\ServiceCategory::count() }}+</p>
                <p class="text-sm text-fixora-beige-light/70">{{ __('app.home.stats.categories') }}</p>
            </div>
            <div>
                <p class="text-4xl font-bold text-white mb-2">{{ \App\Models\ServiceArea::count() }}+</p>
                <p class="text-sm text-fixora-beige-light/70">{{ __('app.home.stats.cities') }}</p>
            </div>
            <div>
                <p class="text-4xl font-bold text-white mb-2">{{ \App\Models\User::where('role', 'professional')->count() }}+</p>
                <p class="text-sm text-fixora-beige-light/70">{{ __('app.nav.professionals') }}</p>
            </div>
            <div>
                <p class="text-4xl font-bold text-white mb-2">24/7</p>
                <p class="text-sm text-fixora-beige-light/70">{{ __('app.home.stats.anytime') }}</p>
            </div>
        </div>
    </div>
</section>

{{-- How it works --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-fixora-orange font-semibold text-sm uppercase tracking-wider">{{ __('app.home.how_it_works') }}</span>
            <h2 class="text-4xl font-bold text-fixora-maroon mt-3 tracking-tight">
                {{ __('app.home.how_it_works_subtitle') }}
            </h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach ([
                ['num' => '1', 'title' => __('app.home.step1_title'), 'desc' => __('app.home.step1_desc')],
                ['num' => '2', 'title' => __('app.home.step2_title'), 'desc' => __('app.home.step2_desc')],
                ['num' => '3', 'title' => __('app.home.step3_title'), 'desc' => __('app.home.step3_desc')],
            ] as $step)
                <div class="relative bg-fixora-beige-light rounded-2xl p-8 border border-fixora-beige-dark/50">
                    <div class="absolute -top-4 left-8 w-10 h-10 rounded-full bg-fixora-maroon text-white flex items-center justify-center font-bold shadow-card">
                        {{ $step['num'] }}
                    </div>
                    <h3 class="text-xl font-bold text-fixora-maroon mb-2 mt-4">{{ $step['title'] }}</h3>
                    <p class="text-fixora-slate leading-relaxed">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 bg-autumn">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold text-fixora-maroon mb-4 tracking-tight">{{ __('app.home.cta_title') }}</h2>
        <p class="text-xl text-fixora-slate mb-8">{{ __('app.home.cta_subtitle') }}</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('register') }}"
               class="inline-flex items-center justify-center bg-fixora-maroon text-white px-8 py-4 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth shadow-card hover-lift">
                {{ __('app.home.cta_button') }}
            </a>
            <a href="{{ route('professionals.index') }}"
               class="inline-flex items-center justify-center bg-white border-2 border-fixora-beige-dark text-fixora-maroon px-8 py-4 rounded-xl font-semibold hover:border-fixora-orange hover:text-fixora-orange transition-smooth">
                {{ __('app.nav.professionals') }}
            </a>
        </div>
    </div>
</section>

@endsection
