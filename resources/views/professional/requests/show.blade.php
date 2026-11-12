@extends('layouts.fixora')

@section('title', $serviceRequest->reference_number . ' — FIXORA')

@section('content')
<div class="bg-autumn min-h-screen py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-6">
            <a href="{{ route('pro.requests.index') }}" class="inline-flex items-center gap-2 text-sm text-fixora-slate hover:text-fixora-orange font-medium transition-smooth">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('app.professional.back_to_requests') }}
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-fixora-olive/10 border border-fixora-olive text-fixora-olive px-4 py-3 rounded-xl">
                ✓ {{ session('success') }}
            </div>
        @endif

        {{-- Main Card --}}
        <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
                <div>
                    <span class="font-mono text-sm text-fixora-mist">{{ $serviceRequest->reference_number }}</span>
                    <h1 class="text-2xl font-bold text-fixora-maroon mt-1">{{ $serviceRequest->service_title }}</h1>
                    <p class="text-fixora-slate">{{ $serviceRequest->serviceCategory->name }}</p>
                </div>
                <span class="text-sm font-semibold px-3 py-1 rounded-full bg-fixora-amber/10 text-fixora-amber self-start">
                    {{ __('app.status.' . $serviceRequest->status) }}
                </span>
            </div>

            <p class="text-fixora-slate leading-relaxed mb-6">{{ $serviceRequest->description }}</p>

            <div class="grid grid-cols-2 gap-4 border-t border-fixora-beige-dark pt-6">
                <div>
                    <p class="text-sm text-fixora-mist">{{ __('app.customer.professional') }}</p>
                    <p class="font-medium text-fixora-maroon">{{ $serviceRequest->customer->name }}</p>
                </div>
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
                @if ($serviceRequest->preferred_date)
                    <div>
                        <p class="text-sm text-fixora-mist">{{ __('app.customer.preferred_date') }}</p>
                        <p class="font-medium text-fixora-maroon">{{ $serviceRequest->preferred_date->format('M d, Y') }}</p>
                    </div>
                @endif
                @if ($serviceRequest->preferred_time)
                    <div>
                        <p class="text-sm text-fixora-mist">{{ __('app.customer.preferred_time') }}</p>
                        <p class="font-medium text-fixora-maroon">{{ $serviceRequest->preferred_time }}</p>
                    </div>
                @endif
            </div>

            {{-- Actions --}}
            @if ($serviceRequest->status === 'pending')
                <div class="flex gap-3 mt-6 pt-6 border-t border-fixora-beige-dark">
                    <form method="POST" action="{{ route('pro.requests.accept', $serviceRequest) }}" class="flex-1">
                        @csrf
                        <button type="submit"
                                class="w-full bg-fixora-olive text-white px-6 py-3 rounded-xl font-semibold hover:bg-fixora-olive/80 transition-smooth">
                            {{ __('app.professional.accept_request') }}
                        </button>
                    </form>
                    <button type="button" onclick="document.getElementById('decline-modal').classList.remove('hidden')"
                            class="flex-1 bg-red-100 text-red-700 px-6 py-3 rounded-xl font-semibold hover:bg-red-200 transition-smooth">
                        {{ __('app.professional.decline') }}
                    </button>
                </div>
            @elseif ($serviceRequest->status === 'accepted')
                <div class="mt-6 pt-6 border-t border-fixora-beige-dark">
                    <form method="POST" action="{{ route('pro.requests.start', $serviceRequest) }}">
                        @csrf
                        <button type="submit"
                                class="w-full bg-fixora-pink text-white px-6 py-3 rounded-xl font-semibold hover:bg-fixora-pink/80 transition-smooth">
                            {{ __('app.professional.start_service') }}
                        </button>
                    </form>
                </div>
            @elseif ($serviceRequest->status === 'in_progress')
                <div class="mt-6 pt-6 border-t border-fixora-beige-dark">
                    <form method="POST" action="{{ route('pro.requests.complete', $serviceRequest) }}">
                        @csrf
                        <button type="submit"
                                class="w-full bg-fixora-maroon text-white px-6 py-3 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth">
                            {{ __('app.professional.mark_completed') }}
                        </button>
                    </form>
                </div>
            @endif
        </div>

        {{-- Status History --}}
        <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6">
            <h2 class="text-lg font-bold text-fixora-maroon mb-4">{{ __('app.professional.history') }}</h2>
            <div class="space-y-3">
                @forelse ($serviceRequest->statusHistory as $entry)
                    <div class="flex gap-3 text-sm">
                        <span class="text-fixora-mist w-32">{{ $entry->created_at->format('M d, H:i') }}</span>
                        <span class="text-fixora-maroon font-medium">{{ __('app.status.' . $entry->new_status) }}</span>
                        @if ($entry->note)
                            <span class="text-fixora-slate">— {{ $entry->note }}</span>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-fixora-mist">{{ __('app.customer.no_history') }}</p>
                @endforelse
            </div>
        </div>

    </div>
</div>

{{-- Decline Modal --}}
<div id="decline-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full">
        <h3 class="text-xl font-bold text-fixora-maroon mb-4">{{ __('app.professional.decline_title') }}</h3>
        <form method="POST" action="{{ route('pro.requests.decline', $serviceRequest) }}">
            @csrf
            <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.professional.decline_reason') }}</label>
            <textarea name="decline_reason" rows="4" required
                      placeholder="{{ __('app.professional.decline_placeholder') }}"
                      class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 outline-none"></textarea>
            <div class="flex gap-2 mt-4">
                <button type="button" onclick="document.getElementById('decline-modal').classList.add('hidden')"
                        class="flex-1 bg-fixora-beige text-fixora-maroon px-4 py-2.5 rounded-xl font-semibold hover:bg-fixora-beige-dark transition-smooth">
                    {{ __('app.buttons.cancel') }}
                </button>
                <button type="submit"
                        class="flex-1 bg-red-600 text-white px-4 py-2.5 rounded-xl font-semibold hover:bg-red-700 transition-smooth">
                    {{ __('app.professional.decline') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
