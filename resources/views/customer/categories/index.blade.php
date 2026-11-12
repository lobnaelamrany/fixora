@extends('layouts.fixora')

@section('title', __('app.categories.all') . ' — FIXORA')

@section('content')
    <div class="bg-autumn min-h-screen">
        <section class="relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-fixora-orange/15 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-fixora-olive/15 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12">
                <div class="text-center max-w-2xl mx-auto">
                    <span class="inline-flex items-center gap-2 bg-white/80 border border-fixora-beige-dark text-fixora-olive text-sm font-semibold px-4 py-1.5 rounded-full mb-6 shadow-card">
                        <span class="w-2 h-2 bg-fixora-orange rounded-full animate-pulse-soft"></span>
                        {{ __('app.categories.browse') }}
                    </span>
                    <h1 class="text-4xl lg:text-5xl font-bold text-fixora-maroon mb-4 tracking-tight">
                        {{ __('app.categories.all') }}
                    </h1>
                    <p class="text-lg text-fixora-slate">
                        {{ __('app.categories.subtitle') }}
                    </p>
                </div>
            </div>
        </section>

        <section class="pb-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach ($categories as $category)
                        @php
                            $colors = [
                                'electricity' => ['bg' => 'orange', 'icon' => '⚡'],
                                'plumbing' => ['bg' => 'olive', 'icon' => '💧'],
                                'air-conditioning' => ['bg' => 'pink', 'icon' => '❄️'],
                                'heating' => ['bg' => 'orange', 'icon' => '🔥'],
                                'appliances' => ['bg' => 'olive', 'icon' => '🏠'],
                                'locksmith' => ['bg' => 'pink', 'icon' => '🔑'],
                                'it-computer' => ['bg' => 'orange', 'icon' => '💻'],
                                'general-maintenance' => ['bg' => 'olive', 'icon' => '🔧'],
                            ];
                            $color = $colors[$category->slug] ?? ['bg' => 'orange', 'icon' => '🛠️'];
                        @endphp

                        <a href="{{ route('categories.show', $category) }}"
                           class="group relative bg-white rounded-2xl p-6 border border-fixora-beige-dark/50 shadow-card hover:shadow-hover hover-lift transition-smooth overflow-hidden">

                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-fixora-{{ $color['bg'] }}/10 rounded-full group-hover:scale-125 transition-smooth"></div>

                            <div class="relative">
                                <div class="w-14 h-14 rounded-2xl bg-fixora-{{ $color['bg'] }}/15 flex items-center justify-center mb-4 group-hover:scale-110 transition-smooth">
                                    <span class="text-2xl">{{ $color['icon'] }}</span>
                                </div>

                                <h3 class="text-lg font-bold text-fixora-maroon group-hover:text-fixora-{{ $color['bg'] }} mb-2 transition-smooth">
                                    {{ $category->name }}
                                </h3>

                                <p class="text-sm text-fixora-slate mb-4 line-clamp-2">
                                    {{ $category->description }}
                                </p>

                                <div class="flex items-center justify-between pt-3 border-t border-fixora-beige-dark/50">
                                    <span class="text-xs font-medium text-fixora-mist">
                                        {{ $category->providers_count }} {{ __('app.categories.professionals') }}
                                    </span>
                                    <svg class="w-5 h-5 text-fixora-{{ $color['bg'] }} transform group-hover:translate-x-1 transition-smooth" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection
