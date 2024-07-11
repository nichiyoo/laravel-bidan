<nav class="py-6">
    <div class="flex items-center justify-between w-content">
        <a href="{{ route('welcome') }}">
            <x-logo variant="color" size="sm" />
        </a>

        <ul class="items-center hidden space-x-4 lg:flex">
            <li><a href="{{ route('welcome') }}">{{ __('Home') }}</a></li>
            <li><a href="{{ route('articles.index') }}">{{ __('Artikel') }}</a></li>
            <li><a href="{{ route('services.index') }}">{{ __('Layanan') }}</a></li>
            <li><a href="{{ route('testimonials.index') }}">{{ __('Testimoni') }}</a></li>
            <li>
                <a href="{{ route('dashboard') }}">
                    <x-button variant="primary" label="{{ __('Beranda') }}">
                        {{ __('Beranda') }}
                    </x-button>
                </a>
            </li>
        </ul>
    </div>
</nav>
