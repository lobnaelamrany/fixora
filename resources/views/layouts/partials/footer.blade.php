<footer class="bg-fixora-maroon text-fixora-beige-light mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid md:grid-cols-4 gap-8 mb-8">
            <div class="md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-9 h-9 rounded-lg bg-fixora-orange flex items-center justify-center font-bold text-white">F</div>
                    <span class="text-xl font-bold tracking-tight text-white">{{ __('app.brand.name') }}</span>
                </div>
                <p class="text-fixora-beige-dark/80 max-w-md leading-relaxed">
                    {{ __('app.footer.tagline') }}
                </p>
            </div>
            <div>
                <h4 class="font-semibold mb-4 text-white">{{ __('app.footer.platform') }}</h4>
                <ul class="space-y-2 text-fixora-beige-dark/80">
                    <li><a href="{{ route('categories.index') }}" class="hover:text-fixora-orange transition-smooth">{{ __('app.footer.services') }}</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-fixora-orange transition-smooth">{{ __('app.footer.become_pro') }}</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4 text-white">{{ __('app.footer.company') }}</h4>
                <ul class="space-y-2 text-fixora-beige-dark/80">
                    <li><a href="{{ route('about') }}" class="hover:text-fixora-orange transition-smooth">{{ __('app.footer.about') }}</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-fixora-orange transition-smooth">{{ __('app.footer.contact') }}</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-fixora-maroon-dark pt-6 flex flex-col sm:flex-row justify-between items-center gap-2 text-sm text-fixora-beige-dark/70">
            <p>&copy; {{ date('Y') }} {{ __('app.brand.name') }}. {{ __('app.footer.rights') }}</p>
            <p>{{ __('app.footer.made_in') }} 🇲🇦 🍂</p>
        </div>
    </div>
</footer>
