@extends('layouts.fixora')

@section('title', $provider->display_name . ' — FIXORA')

@section('content')
<div class="bg-autumn min-h-screen">
    {{-- Cover --}}
    <div class="relative h-72 md:h-96 overflow-hidden">
        @if ($provider->cover_photo_url)
            <img src="{{ $provider->cover_photo_url }}" alt="Cover" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-gradient-to-br from-fixora-maroon via-fixora-orange to-fixora-pink"></div>
        @endif

        <div class="absolute inset-0 bg-gradient-to-t from-fixora-maroon/90 via-fixora-maroon/40 to-transparent"></div>

        <a href="{{ url()->previous() }}" class="absolute top-6 left-6 glass rounded-full p-3 shadow-card hover:shadow-hover transition-smooth">
            <svg class="w-5 h-5 text-fixora-maroon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>

        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                <div class="flex items-end gap-4">
                    <div class="w-24 h-24 md:w-32 md:h-32 rounded-2xl border-4 border-white shadow-2xl overflow-hidden bg-white flex-shrink-0">
                        @if ($provider->profile_photo_url)
                            <img src="{{ $provider->profile_photo_url }}" alt="{{ $provider->display_name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-fixora-orange flex items-center justify-center text-white text-4xl font-bold">
                                {{ strtoupper(substr($provider->display_name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <div class="pb-2">
                        <div class="flex items-center gap-2 mb-1 flex-wrap">
                            <h1 class="text-3xl md:text-4xl font-bold text-white tracking-tight">
                                {{ $provider->display_name }}
                            </h1>
                            @if ($provider->verification_status === 'verified')
                                <span class="inline-flex items-center gap-1 bg-fixora-olive text-white text-xs font-semibold px-2 py-1 rounded-full shadow-card">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ __('app.professionals.verified') }}
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center gap-3 text-white/90 text-sm">
                            <div class="flex items-center gap-1">
                                <span class="text-fixora-orange">★</span>
                                <span class="font-bold">{{ number_format($provider->average_rating, 1) }}</span>
                                <span>({{ $stats['total_reviews'] }} {{ __('app.professionals.reviews') }})</span>
                            </div>
                            <span>•</span>
                            <span>{{ $provider->completed_services_count }} {{ __('app.professionals.services') }}</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('customer.requests.create', ['provider' => $provider->id]) }}"
                   class="inline-flex items-center justify-center gap-2 bg-fixora-orange text-white px-6 py-3.5 rounded-xl font-semibold shadow-2xl hover:bg-white hover:text-fixora-maroon transition-smooth hover-lift">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('app.professionals.request') }} {{ __('app.professionals.services') }}
                </a>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                {{-- Stats --}}
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-white rounded-2xl p-5 shadow-card border border-fixora-beige-dark/50">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-fixora-olive/10 flex items-center justify-center">
                                <svg class="w-6 h-6 text-fixora-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-fixora-maroon">{{ $provider->completed_services_count }}</p>
                                <p class="text-xs text-fixora-mist">{{ __('app.professionals.services') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-5 shadow-card border border-fixora-beige-dark/50">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-fixora-orange/10 flex items-center justify-center">
                                <svg class="w-6 h-6 text-fixora-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-fixora-maroon">{{ number_format($provider->average_rating, 1) }}</p>
                                <p class="text-xs text-fixora-mist">{{ __('app.professionals.rating') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-5 shadow-card border border-fixora-beige-dark/50">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-fixora-maroon/10 flex items-center justify-center">
                                <svg class="w-6 h-6 text-fixora-maroon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-2xl font-bold text-fixora-maroon">{{ $provider->experience_years }}<span class="text-sm">y</span></p>
                                <p class="text-xs text-fixora-mist">{{ __('app.professionals.experience') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- About --}}
                <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6">
                    <h2 class="text-xl font-bold text-fixora-maroon mb-3">{{ __('app.about.title') }}</h2>
                    <p class="text-fixora-slate leading-relaxed">{{ $provider->description }}</p>
                </div>

                {{-- Services --}}
                <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6">
                    <h2 class="text-xl font-bold text-fixora-maroon mb-4">{{ __('app.professionals.services') }}</h2>
                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach ($provider->services as $service)
                            <div class="flex items-center gap-3 p-4 rounded-xl bg-fixora-beige-light">
                                <div class="w-10 h-10 rounded-lg bg-fixora-orange flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="font-medium text-fixora-maroon">{{ $service->name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Reviews --}}
                <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-fixora-maroon">{{ __('app.professionals.reviews') }}</h2>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl font-bold text-fixora-maroon">{{ number_format($provider->average_rating, 1) }}</span>
                            <div>
                                <div class="flex text-fixora-orange text-sm">★★★★★</div>
                                <p class="text-xs text-fixora-mist">{{ $stats['total_reviews'] }} {{ __('app.professionals.reviews') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 mb-6 pb-6 border-b border-fixora-beige-dark">
                        @foreach ([5, 4, 3, 2, 1] as $star)
                            @php
                                $key = ['five_star', 'four_star', 'three_star', 'two_star', 'one_star'][5 - $star];
                                $count = $stats[$key];
                                $pct = $stats['total_reviews'] > 0 ? ($count / $stats['total_reviews']) * 100 : 0;
                            @endphp
                            <div class="flex items-center gap-3 text-sm">
                                <span class="text-fixora-slate w-10">{{ $star }} ★</span>
                                <div class="flex-1 h-2 bg-fixora-beige rounded-full overflow-hidden">
                                    <div class="h-full bg-fixora-orange rounded-full transition-smooth" style="width: {{ $pct }}%"></div>
                                </div>
                                <span class="text-fixora-mist w-8 text-right">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-5">
                        @forelse ($provider->reviews as $review)
                            <div class="flex items-start gap-3">
                                <div class="w-11 h-11 rounded-full bg-gradient-to-br from-fixora-orange to-fixora-pink flex items-center justify-center flex-shrink-0 shadow-card">
                                    <span class="text-white font-bold text-sm">
                                        {{ strtoupper(substr($review->customer->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="font-semibold text-fixora-maroon">{{ $review->customer->name }}</p>
                                        <div class="flex text-fixora-orange text-sm">
                                            @for ($i = 0; $i < $review->rating; $i++) ★ @endfor
                                        </div>
                                    </div>
                                    <p class="text-xs text-fixora-mist mb-2">{{ $review->created_at->diffForHumans() }}</p>
                                    @if ($review->comment)
                                        <p class="text-sm text-fixora-slate leading-relaxed">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-fixora-mist py-6">{{ __('app.professionals.no_results') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Sticky Contact --}}
            <div class="lg:col-span-1">
                <div class="glass rounded-2xl shadow-card p-6 sticky top-24 border border-white/50">
                    <h3 class="text-lg font-bold text-fixora-maroon mb-4">{{ __('app.contact.title') }}</h3>

                    @if ($provider->phone)
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-11 h-11 rounded-xl bg-fixora-orange/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-fixora-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs text-fixora-mist">{{ __('app.professionals.phone') }}</p>
                                <p class="font-medium text-fixora-maroon truncate">{{ $provider->phone }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="mt-6 pt-6 border-t border-fixora-beige-dark">
                        <a href="{{ route('customer.requests.create', ['provider' => $provider->id]) }}"
                           class="block w-full text-center bg-fixora-maroon text-white px-6 py-3.5 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth hover-lift shadow-card">
                            {{ __('app.professionals.request') }} {{ __('app.professionals.services') }}
                        </a>
                        <p class="text-xs text-fixora-mist text-center mt-3">
                            💬 {{ __('app.conversations.no_messages_desc') }}
                        </p>
                    </div>

                    @if ($provider->is_available_now)
                        <div class="mt-4 p-3 rounded-xl bg-fixora-olive/10 border border-fixora-olive/20">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-fixora-olive rounded-full animate-pulse"></span>
                                <p class="text-sm font-medium text-fixora-olive">{{ __('app.professionals.available_now') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
