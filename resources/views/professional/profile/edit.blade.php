@extends('layouts.fixora')

@section('title', __('app.professional.edit_profile') . ' — FIXORA')

@section('content')
<div class="bg-autumn min-h-screen py-10" x-data="{ tab: '{{ request('tab', 'general') }}' }">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm text-fixora-slate hover:text-fixora-orange font-medium transition-smooth mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('app.nav.dashboard') }}
            </a>
            <h1 class="text-3xl font-bold text-fixora-maroon tracking-tight">{{ __('app.professional.edit_profile') }}</h1>
            <p class="text-fixora-slate mt-1">{{ __('app.professional.complete_profile_desc') }}</p>
        </div>

        {{-- Success / Error --}}
        @if (session('success'))
            <div class="mb-6 bg-fixora-olive/10 border border-fixora-olive text-fixora-olive px-4 py-3 rounded-xl shadow-soft">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-500 text-red-700 px-4 py-3 rounded-xl shadow-soft">
                ✗ {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-500 text-red-700 px-4 py-3 rounded-xl shadow-soft">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Tabs Navigation --}}
        <div class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-2 flex flex-wrap gap-1 mb-6">
            <button @click="tab = 'general'"
                    :class="tab === 'general' ? 'bg-fixora-maroon text-white shadow-card' : 'text-fixora-slate hover:bg-fixora-beige'"
                    class="px-4 py-2.5 rounded-xl font-semibold text-sm transition-smooth flex-1 min-w-[120px]">
                {{ __('app.admin.categories_title') === __('app.admin.categories_title') ? 'General' : '' }}
            </button>
            <button @click="tab = 'services'"
                    :class="tab === 'services' ? 'bg-fixora-maroon text-white shadow-card' : 'text-fixora-slate hover:bg-fixora-beige'"
                    class="px-4 py-2.5 rounded-xl font-semibold text-sm transition-smooth flex-1 min-w-[120px]">
                {{ __('app.professional.stats.services') }}
            </button>
            <button @click="tab = 'areas'"
                    :class="tab === 'areas' ? 'bg-fixora-maroon text-white shadow-card' : 'text-fixora-slate hover:bg-fixora-beige'"
                    class="px-4 py-2.5 rounded-xl font-semibold text-sm transition-smooth flex-1 min-w-[120px]">
                {{ __('app.admin.areas') }}
            </button>
            <button @click="tab = 'availability'"
                    :class="tab === 'availability' ? 'bg-fixora-maroon text-white shadow-card' : 'text-fixora-slate hover:bg-fixora-beige'"
                    class="px-4 py-2.5 rounded-xl font-semibold text-sm transition-smooth flex-1 min-w-[120px]">
                Availability
            </button>
        </div>

        {{-- TAB 1: General --}}
        <div x-show="tab === 'general'" x-transition>
            <form method="POST" action="{{ route('pro.profile.update') }}" enctype="multipart/form-data"
                  class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6 space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="tab" value="general">

                <div>
                    <label class="block text-sm font-semibold text-fixora-maroon mb-2">Cover Photo</label>
                    <div class="relative h-40 rounded-xl overflow-hidden bg-gradient-to-br from-fixora-maroon via-fixora-orange to-fixora-pink group cursor-pointer"
                         onclick="document.getElementById('cover_input').click()">
                        @if ($profile->cover_photo_url)
                            <img src="{{ $profile->cover_photo_url }}" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-smooth flex items-center justify-center">
                            <span class="text-white font-semibold">Change cover photo</span>
                        </div>
                    </div>
                    <input type="file" id="cover_input" name="cover_photo" accept="image/*" class="hidden">
                    @error('cover_photo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-fixora-maroon mb-2">Profile Photo</label>
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 rounded-2xl overflow-hidden border-4 border-white shadow-card bg-fixora-orange flex items-center justify-center flex-shrink-0">
                            @if ($profile->profile_photo_url)
                                <img src="{{ $profile->profile_photo_url }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-white font-bold text-2xl">{{ strtoupper(substr($profile->business_name ?? auth()->user()->name, 0, 1)) }}</span>
                            @endif
                        </div>
                        <input type="file" name="profile_photo" accept="image/*"
                               class="flex-1 text-sm text-fixora-slate file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:font-semibold file:bg-fixora-beige file:text-fixora-maroon hover:file:bg-fixora-beige-dark file:transition-smooth file:cursor-pointer">
                    </div>
                    @error('profile_photo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.admin.business_name') }}</label>
                        <input type="text" name="business_name" value="{{ old('business_name', $profile->business_name) }}"
                               placeholder="e.g. Ahmed Élec"
                               class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.professional.experience') }}</label>
                        <input type="number" name="experience_years" value="{{ old('experience_years', $profile->experience_years) }}" min="0" max="60" required
                               class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.customer.description') }}</label>
                    <textarea name="description" rows="4"
                              placeholder="{{ __('app.customer.description_placeholder') }}"
                              class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">{{ old('description', $profile->description) }}</textarea>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.admin.phone') }}</label>
                        <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}"
                               placeholder="+212 6 12 34 56 78"
                               class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-fixora-maroon mb-2">WhatsApp</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $profile->whatsapp) }}"
                               placeholder="+212612345678"
                               class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                    </div>
                </div>

                <div x-data="{ langs: '{{ old('languages_input', $profile->languages ? implode(', ', $profile->languages) : '') }}' }">
                    <label class="block text-sm font-semibold text-fixora-maroon mb-2">{{ __('app.about.title') }} (comma separated)</label>
                    <input type="text" x-model="langs"
                           placeholder="Français, العربية, English"
                           class="w-full px-4 py-3 rounded-xl border border-fixora-beige-dark bg-white text-fixora-ink focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                    <input type="hidden" name="languages"
                           :value="JSON.stringify(langs.split(',').map(s => s.trim()).filter(Boolean))">
                </div>

                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_available_now" value="1" @checked($profile->is_available_now)
                               class="w-5 h-5 rounded border-fixora-beige-dark text-fixora-orange focus:ring-fixora-orange">
                        <div>
                            <span class="font-semibold text-fixora-maroon">{{ __('app.professionals.available_now') }}</span>
                            <p class="text-sm text-fixora-slate">{{ __('app.professionals.available_now') }}</p>
                        </div>
                    </label>
                </div>

                <div class="flex gap-3 pt-4 border-t border-fixora-beige-dark">
                    <button type="submit"
                            class="bg-fixora-maroon text-white px-6 py-3 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth hover-lift shadow-card">
                        {{ __('app.buttons.save') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- TAB 2: Services --}}
        <div x-show="tab === 'services'" x-transition x-cloak>
            <form method="POST" action="{{ route('pro.profile.services') }}"
                  class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="tab" value="services">

                <h2 class="text-xl font-bold text-fixora-maroon mb-2">{{ __('app.professionals.services') }}</h2>
                <p class="text-fixora-slate text-sm mb-6">{{ __('app.categories.browse') }}</p>

                <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach ($categories as $cat)
                        <label class="cursor-pointer">
                            <input type="checkbox" name="services[]" value="{{ $cat->id }}"
                                   @checked($profile->services->contains($cat->id))
                                   class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-fixora-beige-dark bg-white hover:border-fixora-orange/50 peer-checked:border-fixora-orange peer-checked:bg-fixora-orange/5 transition-smooth">
                                <span class="font-medium text-fixora-maroon text-sm">{{ $cat->name }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>

                @error('services') <p class="text-red-600 text-sm mt-3">{{ $message }}</p> @enderror

                <div class="flex gap-3 pt-6 mt-6 border-t border-fixora-beige-dark">
                    <button type="submit"
                            class="bg-fixora-maroon text-white px-6 py-3 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth hover-lift shadow-card">
                        {{ __('app.buttons.save') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- TAB 3: Areas --}}
        <div x-show="tab === 'areas'" x-transition x-cloak>
            <form method="POST" action="{{ route('pro.profile.areas') }}"
                  class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="tab" value="areas">

                <h2 class="text-xl font-bold text-fixora-maroon mb-2">{{ __('app.admin.areas') }}</h2>
                <p class="text-fixora-slate text-sm mb-6">{{ __('app.customer.city') }}</p>

                <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach ($areas as $area)
                        <label class="cursor-pointer">
                            <input type="checkbox" name="areas[]" value="{{ $area->id }}"
                                   @checked($profile->areas->contains($area->id))
                                   class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-fixora-beige-dark bg-white hover:border-fixora-olive/50 peer-checked:border-fixora-olive peer-checked:bg-fixora-olive/5 transition-smooth">
                                <p class="font-medium text-fixora-maroon text-sm">📍 {{ $area->city }}</p>
                                <p class="text-xs text-fixora-mist">{{ $area->region }}</p>
                            </div>
                        </label>
                    @endforeach
                </div>

                @error('areas') <p class="text-red-600 text-sm mt-3">{{ $message }}</p> @enderror

                <div class="flex gap-3 pt-6 mt-6 border-t border-fixora-beige-dark">
                    <button type="submit"
                            class="bg-fixora-maroon text-white px-6 py-3 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth hover-lift shadow-card">
                        {{ __('app.buttons.save') }}
                    </button>
                </div>
            </form>
        </div>

        {{-- TAB 4: Availability --}}
        <div x-show="tab === 'availability'" x-transition x-cloak>
            <form method="POST" action="{{ route('pro.profile.availability') }}"
                  class="bg-white rounded-2xl shadow-card border border-fixora-beige-dark/50 p-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="tab" value="availability">

                <h2 class="text-xl font-bold text-fixora-maroon mb-2">Weekly Availability</h2>
                <p class="text-fixora-slate text-sm mb-6">Set your working hours for each day.</p>

                <div class="space-y-3">
                    @foreach ($days as $index => $day)
                        @php
                            $avail = $profile->availabilities->firstWhere('day_of_week', $index);
                            $isAvailable = $avail?->is_available ?? false;
                        @endphp
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3 p-4 rounded-xl bg-fixora-beige-light border border-fixora-beige-dark/50"
                             x-data="{ enabled: {{ $isAvailable ? 'true' : 'false' }} }">
                            <div class="flex items-center gap-3 w-full sm:w-48">
                                <input type="hidden" name="availability[{{ $index }}][is_available]" :value="enabled ? 1 : 0">
                                <button type="button" @click="enabled = !enabled"
                                        :class="enabled ? 'bg-fixora-olive' : 'bg-fixora-mist'"
                                        class="relative w-11 h-6 rounded-full transition-smooth">
                                    <span :class="enabled ? 'translate-x-5' : 'translate-x-0'"
                                          class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-smooth"></span>
                                </button>
                                <span class="font-semibold text-fixora-maroon text-sm">{{ $day }}</span>
                            </div>
                            <div class="flex items-center gap-2 flex-1" x-show="enabled" x-transition>
                                <input type="time" name="availability[{{ $index }}][start_time]"
                                       value="{{ $avail ? \Carbon\Carbon::parse($avail->start_time)->format('H:i') : '09:00' }}"
                                       class="px-3 py-2 rounded-lg border border-fixora-beige-dark bg-white text-sm focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                                <span class="text-fixora-mist text-sm">to</span>
                                <input type="time" name="availability[{{ $index }}][end_time]"
                                       value="{{ $avail ? \Carbon\Carbon::parse($avail->end_time)->format('H:i') : '18:00' }}"
                                       class="px-3 py-2 rounded-lg border border-fixora-beige-dark bg-white text-sm focus:border-fixora-orange focus:ring-2 focus:ring-fixora-orange/20 transition-smooth outline-none">
                            </div>
                            <span x-show="!enabled" class="text-sm text-fixora-mist italic">Not available</span>
                        </div>
                    @endforeach
                </div>

                <div class="flex gap-3 pt-6 mt-6 border-t border-fixora-beige-dark">
                    <button type="submit"
                            class="bg-fixora-maroon text-white px-6 py-3 rounded-xl font-semibold hover:bg-fixora-orange transition-smooth hover-lift shadow-card">
                        {{ __('app.buttons.save') }}
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
