<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'FIXORA' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400;0,500;0,600;0,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-fixora-beige-light">

    <div class="min-h-screen grid lg:grid-cols-5">

        {{-- Left: Brand panel (40% = 2/5) --}}
        <div class="hidden lg:flex lg:col-span-2 relative overflow-hidden bg-fixora-maroon">
            {{-- Decorative blobs --}}
            <div class="absolute top-0 right-0 w-96 h-96 bg-fixora-orange/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-fixora-pink/20 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

            <div class="relative flex flex-col justify-between p-10 w-full">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-11 h-11 rounded-xl bg-fixora-orange flex items-center justify-center text-white font-bold text-xl shadow-card group-hover:scale-105 transition-smooth">
                        F
                    </div>
                    <span class="text-2xl font-bold text-white tracking-tight">FIXORA</span>
                </a>

                {{-- Middle: Tagline + Features --}}
                <div class="my-8">
                    <p class="text-fixora-orange font-semibold text-sm uppercase tracking-wider mb-3">
                        Find. Connect. Fix.
                    </p>
                    <h2 class="text-4xl font-bold text-white leading-tight tracking-tight mb-6">
                        The right professional,<br>
                        <span class="text-fixora-orange">at the right place.</span>
                    </h2>

                    <div class="space-y-3">
                        @foreach ([
                            'Verified independent professionals',
                            'Transparent profiles and reviews',
                            'Direct messaging after request',
                            'Available across Morocco',
                        ] as $feature)
                            <div class="flex items-center gap-3">
                                <div class="w-7 h-7 rounded-full bg-fixora-orange/20 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-fixora-orange" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <p class="text-white/90 font-medium text-sm">{{ $feature }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Bottom: Trust --}}
                <div class="flex items-center gap-3 pt-6 border-t border-fixora-maroon-light/30">
                    <div class="flex -space-x-2">
                        <div class="w-9 h-9 rounded-full bg-fixora-orange border-2 border-fixora-maroon flex items-center justify-center text-white text-xs font-bold">A</div>
                        <div class="w-9 h-9 rounded-full bg-fixora-olive border-2 border-fixora-maroon flex items-center justify-center text-white text-xs font-bold">K</div>
                        <div class="w-9 h-9 rounded-full bg-fixora-pink border-2 border-fixora-maroon flex items-center justify-center text-white text-xs font-bold">M</div>
                    </div>
                    <div>
                        <div class="flex text-fixora-orange text-xs">★★★★★</div>
                        <p class="text-xs text-white/70">Trusted by professionals</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Form panel (60% = 3/5) --}}
        <div class="lg:col-span-3 flex flex-col">
            {{-- Mobile logo --}}
            <div class="lg:hidden flex justify-center pt-10">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-fixora-maroon to-fixora-orange flex items-center justify-center text-white font-bold text-lg shadow-card">
                        F
                    </div>
                    <span class="text-xl font-bold text-fixora-maroon tracking-tight">FIXORA</span>
                </a>
            </div>

            {{-- Form container --}}
            <div class="flex-1 flex items-center justify-center px-6 py-12 sm:px-12">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
