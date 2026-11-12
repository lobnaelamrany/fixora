@extends('layouts.fixora')

@section('title', __('app.conversations.title') . ' — FIXORA')

@section('content')
<div class="bg-autumn min-h-screen py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-fixora-maroon tracking-tight">{{ __('app.conversations.title') }}</h1>
            <p class="text-fixora-slate mt-1">
                {{ __('app.conversations.subtitle') }}
                {{ auth()->user()->isCustomer() ? __('app.conversations.professionals') : __('app.conversations.customers') }}.
            </p>
        </div>

        @if ($conversations->isEmpty())
            <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-12 text-center">
                <div class="w-20 h-20 bg-fixora-beige rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-fixora-mist" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-fixora-maroon mb-2">{{ __('app.conversations.no_messages') }}</h3>
                <p class="text-fixora-slate">{{ __('app.conversations.no_messages_desc') }}</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($conversations as $conv)
                    @php
                        $otherName = auth()->user()->isCustomer()
                            ? $conv->providerProfile->display_name
                            : $conv->customer->name;
                        $lastMessage = $conv->messages()->latest()->first();
                        $unreadCount = $conv->messages()
                            ->where('sender_id', '!=', auth()->id())
                            ->whereNull('read_at')
                            ->count();
                    @endphp
                    <a href="{{ route('conversations.show', $conv) }}"
                       class="block bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-5 hover:shadow-hover hover-lift transition-smooth">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-fixora-maroon to-fixora-orange flex items-center justify-center text-white font-bold flex-shrink-0">
                                {{ strtoupper(substr($otherName, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <h3 class="font-bold text-fixora-maroon truncate">{{ $otherName }}</h3>
                                    <span class="text-xs text-fixora-mist flex-shrink-0">
                                        {{ $conv->last_message_at?->diffForHumans() ?? $conv->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-xs text-fixora-mist mb-1">{{ $conv->serviceRequest->service_title }}</p>
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-sm text-fixora-slate truncate">
                                        {{ $lastMessage?->body ?? __('app.conversations.no_messages_yet') }}
                                    </p>
                                    @if ($unreadCount > 0)
                                        <span class="px-2 py-0.5 rounded-full bg-fixora-orange text-white text-xs font-bold flex-shrink-0">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $conversations->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
