@extends('layouts.fixora')

@section('title', __('app.conversations.title') . ' — FIXORA')

@section('content')
<div class="bg-autumn min-h-screen py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Back --}}
        <div class="mb-4">
            <a href="{{ route('conversations.index') }}"
               class="inline-flex items-center gap-2 text-sm text-fixora-slate hover:text-fixora-orange font-medium transition-smooth">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('app.conversations.all_messages') }}
            </a>
        </div>

        @php
            $otherName = auth()->user()->isCustomer()
                ? $conversation->providerProfile->display_name
                : $conversation->customer->name;
        @endphp

        {{-- Header --}}
        <div class="bg-white rounded-t-2xl shadow-card border border-fixora-beige-dark/50 border-b-0 p-5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-fixora-maroon to-fixora-orange flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr($otherName, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="font-bold text-fixora-maroon truncate">{{ $otherName }}</h2>
                    <p class="text-xs text-fixora-mist truncate">
                        {{ $conversation->serviceRequest->service_title }}
                        · {{ $conversation->serviceRequest->reference_number }}
                    </p>
                </div>
                <a href="{{ auth()->user()->isCustomer()
                    ? route('customer.requests.show', $conversation->serviceRequest)
                    : route('pro.requests.show', $conversation->serviceRequest) }}"
                   class="text-xs font-semibold text-fixora-orange hover:text-fixora-maroon transition-smooth flex-shrink-0">
                    {{ __('app.conversations.view_request') }} →
                </a>
            </div>
        </div>

        {{-- Messages --}}
        <div class="bg-fixora-beige-light border-x border-fixora-beige-dark/50 max-h-[500px] overflow-y-auto p-5 space-y-3">
            @forelse ($conversation->messages->sortBy('created_at') as $msg)
                @php $isMine = $msg->sender_id === auth()->id(); @endphp
                <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[75%]">
                        <div class="px-4 py-2.5 rounded-2xl {{ $isMine ? 'bg-fixora-maroon text-white rounded-tr-sm' : 'bg-white text-fixora-maroon rounded-tl-sm shadow-sm' }}">
                            <p class="text-sm leading-relaxed whitespace-pre-wrap">{{ $msg->body }}</p>
                        </div>
                        <p class="text-xs text-fixora-mist mt-1 {{ $isMine ? 'text-right' : 'text-left' }}">
                            {{ $msg->created_at->format('H:i') }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <p class="text-fixora-mist text-sm">{{ __('app.conversations.no_messages_yet') }}</p>
                </div>
            @endforelse
        </div>

        {{-- Message Form --}}
        <div class="bg-white rounded-b-2xl shadow-card border border-fixora-beige-dark/50 border-t-0 p-4">
            <form method="POST" action="{{ route('conversations.messages.store', $conversation) }}" class="flex gap-2">
                @csrf
                <input type="text" name="body" required autofocus
                       placeholder="{{ __('app.conversations.type_message') }}"
                       class="flex-1 px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink placeholder-fixora-mist focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                <button type="submit"
                        class="bg-fixora-maroon text-white px-5 py-3 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth shadow-card">
                    {{ __('app.conversations.send') }}
                </button>
            </form>
            @error('body') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

    </div>
</div>
@endsection
