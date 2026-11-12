@extends('layouts.fixora')

@section('title', $serviceRequest->reference_number . ' — FIXORA')

@section('content')
<div class="bg-autumn min-h-screen py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Back --}}
        <div class="mb-6">
            <a href="{{ route('customer.requests.index') }}"
               class="inline-flex items-center gap-2 text-sm text-fixora-slate hover:text-fixora-orange font-medium transition-smooth">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('app.customer.requests_title') }}
            </a>
        </div>

        {{-- Main Card --}}
        <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6 mb-6">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
                <div>
                    <span class="font-mono text-sm text-fixora-mist">{{ $serviceRequest->reference_number }}</span>
                    <h1 class="text-2xl font-bold text-fixora-maroon mt-1">{{ $serviceRequest->service_title }}</h1>
                    <p class="text-fixora-slate">{{ $serviceRequest->serviceCategory->name }}</p>
                </div>
                @php
                    $statusColors = [
                        'pending' => 'bg-fixora-amber/10 text-fixora-amber',
                        'accepted' => 'bg-fixora-orange/10 text-fixora-orange',
                        'in_progress' => 'bg-fixora-pink/10 text-fixora-pink',
                        'completed' => 'bg-fixora-olive/10 text-fixora-olive',
                        'declined' => 'bg-red-100 text-red-700',
                        'cancelled' => 'bg-gray-100 text-gray-600',
                    ];
                @endphp
                <span class="text-sm font-semibold px-3 py-1 rounded-full {{ $statusColors[$serviceRequest->status] ?? '' }} self-start">
                    {{ __('app.status.' . $serviceRequest->status) }}
                </span>
            </div>

            {{-- Description --}}
            <p class="text-fixora-slate leading-relaxed mb-6">{{ $serviceRequest->description }}</p>

            {{-- Details Grid --}}
            <div class="grid grid-cols-2 gap-4 border-t border-fixora-beige-dark pt-6">
                <div>
                    <p class="text-sm text-fixora-mist">{{ __('app.customer.city') }}</p>
                    <p class="font-medium text-fixora-maroon">{{ $serviceRequest->city }}</p>
                </div>
                <div>
                    <p class="text-sm text-fixora-mist">{{ __('app.customer.address') }}</p>
                    <p class="font-medium text-fixora-maroon">{{ $serviceRequest->address }}</p>
                </div>
                <div>
                    <p class="text-sm text-fixora-mist">{{ __('app.customer.urgency') }}</p>
                    <p class="font-medium text-fixora-maroon">{{ __('app.customer.urgency_' . $serviceRequest->urgency_level) }}</p>
                </div>
                <div>
                    <p class="text-sm text-fixora-mist">{{ __('app.customer.submitted') }}</p>
                    <p class="font-medium text-fixora-maroon">{{ $serviceRequest->submitted_at?->format('M d, Y H:i') ?? '—' }}</p>
                </div>
            </div>

            {{-- Professional --}}
            @if ($serviceRequest->providerProfile)
                <div class="mt-6 pt-6 border-t border-fixora-beige-dark">
                    <p class="text-sm text-fixora-mist mb-2">{{ __('app.customer.professional') }}</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-fixora-orange flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($serviceRequest->providerProfile->display_name, 0, 1)) }}
                        </div>
                        <p class="font-semibold text-fixora-maroon">
                            {{ $serviceRequest->providerProfile->display_name }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- Actions --}}
            @if (in_array($serviceRequest->status, ['pending', 'accepted']))
                <div class="mt-6 pt-6 border-t border-fixora-beige-dark">
                    <form method="POST" action="{{ route('customer.requests.cancel', $serviceRequest) }}"
                          onsubmit="return confirm('{{ __('app.customer.cancel_request') }}?')">
                        @csrf
                        <button type="submit"
                                class="bg-red-50 text-red-700 px-5 py-2.5 rounded-xl font-semibold hover:bg-red-100 transition-smooth text-sm">
                            {{ __('app.customer.cancel_request') }}
                        </button>
                    </form>
                </div>
            @endif

        </div>

        {{-- Status History --}}
        <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6 mb-6">
            <h2 class="text-lg font-bold text-fixora-maroon mb-4">{{ __('app.customer.history') }}</h2>
            <div class="space-y-3">
                @forelse ($serviceRequest->statusHistory as $entry)
                    <div class="flex gap-3 text-sm items-start">
                        <span class="text-fixora-mist w-32 flex-shrink-0">{{ $entry->created_at->format('M d, H:i') }}</span>
                        <div class="flex-1">
                            <span class="font-semibold text-fixora-maroon">
                                {{ __('app.status.' . $entry->new_status) }}
                            </span>
                            @if ($entry->note)
                                <span class="text-fixora-slate">— {{ $entry->note }}</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-fixora-mist">{{ __('app.customer.no_history') }}</p>
                @endforelse
            </div>
        </div>

        {{-- Review Form --}}
        @if ($serviceRequest->status === 'completed' && !$serviceRequest->review)
            <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6 mb-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-fixora-orange/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-fixora-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-fixora-maroon">{{ __('app.customer.rate_service') }}</h2>
                        <p class="text-sm text-fixora-slate">{{ __('app.customer.rate_subtitle') }} {{ $serviceRequest->providerProfile->display_name }}?</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('reviews.store', $serviceRequest) }}" class="space-y-4" x-data="{ rating: 0, hover: 0 }">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.customer.your_rating') }} *</label>
                        <div class="flex gap-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button"
                                        @click="rating = {{ $i }}"
                                        @mouseenter="hover = {{ $i }}"
                                        @mouseleave="hover = 0"
                                        class="transition-smooth">
                                    <svg class="w-10 h-10 transition-smooth"
                                         :class="(hover || rating) >= {{ $i }} ? 'text-fixora-orange' : 'text-fixora-beige-dark'"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" :value="rating" required>
                        @error('rating') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.customer.your_review_optional') }}</label>
                        <textarea name="comment" rows="3"
                                  placeholder="{{ __('app.customer.review_placeholder') }}"
                                  class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none resize-none">{{ old('comment') }}</textarea>
                        @error('comment') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit"
                            :disabled="rating === 0"
                            :class="rating === 0 ? 'bg-fixora-beige-dark text-fixora-mist cursor-not-allowed' : 'bg-fixora-maroon text-white hover:bg-fixora-orange shadow-card hover-lift'"
                            class="px-6 py-3 rounded-xl font-semibold transition-smooth">
                        {{ __('app.customer.submit_review') }}
                    </button>
                </form>
            </div>
        @endif

        {{-- Review Display --}}
        @if ($serviceRequest->review)
            <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-fixora-maroon">{{ __('app.customer.your_review_title') }}</h2>
                    <div class="flex text-fixora-orange text-lg">
                        @for ($i = 0; $i < $serviceRequest->review->rating; $i++) ★ @endfor
                    </div>
                </div>
                @if ($serviceRequest->review->comment)
                    <p class="text-fixora-slate leading-relaxed">{{ $serviceRequest->review->comment }}</p>
                @else
                    <p class="text-fixora-mist italic">{{ __('app.customer.no_comment') }}</p>
                @endif
                <p class="text-xs text-fixora-mist mt-3">{{ $serviceRequest->review->created_at->diffForHumans() }}</p>
            </div>
        @endif

    </div>
</div>
@endsection
