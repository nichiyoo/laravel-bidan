<x-landing-layout>
    <section id="hero" class="grid items-center gap-8 py-20 lg:grid-cols-2">
        <x-heading level="h1">
            <x-slot name="title">
                {{ __('Buat Janji dengan mudah dan cepat') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Dengan menggunakan layanan kami, Anda dapat membuat Janji yang lebih cepat dan efektif, dengan berbagai metode pembayaran yang tersedia.') }}
            </x-slot>

            <a href="{{ route('dashboard') }}" class="block">
                <x-button variant="accent" label="Dashboard">
                    {{ __('Beranda') }}
                </x-button>
            </a>
        </x-heading>

        <div class="relative w-full">
            <a href="{{ route('patients.appointments.create') }}"
                class="absolute right-0 flex items-center justify-center p-2 space-x-2 bg-white rounded-full bottom-10 frame pe-5 animate-bounce">
                <x-button variant="accent" size="icon" label="{{ __('Buat Janji') }}">
                    <i data-lucide="plus"></i>
                </x-button>
                <span class="text-sm">
                    {{ __('Buat Janji') }}
                </span>
            </a>
            <img src="{{ asset('images/hero.png') }}" alt="Hero" class="object-cover w-full">
        </div>
    </section>

    <section id="layanan" class="py-20">
        <x-heading level="h2" class="max-w-xl mx-auto mb-8 text-center">
            <x-slot name="title">
                {{ __('Layanan yang tersedia') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Kami menyediakan layanan untuk membuat Janji yang lebih cepat dan efektif, dengan berbagai metode pembayaran yang tersedia.') }}
            </x-slot>
        </x-heading>

        <div class="grid gap-8 lg:grid-cols-3">
            @foreach ($services as $service)
                <div for="{{ $service->id }}" class="relative overflow-hidden bg-white frame rounded-xl group">

                    <figure class="w-full overflow-hidden aspect-thumbnail">
                        <img src="{{ asset($service->photo) }}" alt="{{ $service->title }}"
                            class="object-cover w-full h-full transition-all duration-300 hover:scale-110">
                    </figure>

                    <div class="p-6 space-y-4">
                        <h3 class="text-lg font-bold text-primary">
                            {{ $service->title }}
                        </h3>

                        <p class="text-zinc-600 line-clamp-3">
                            {{ $service->description }}
                        </p>

                        <span class="block font-semibold text-accent">
                            Rp{{ $service->price }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section id="article" class="py-20">
        <x-heading level="h2" class="max-w-xl mx-auto mb-8 text-center">
            <x-slot name="title">
                {{ __('Artikel') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Kami menyediakan arti yang berkualitas tinggi, yang dapat membantu Anda membuat Janji yang lebih efektif.') }}
            </x-slot>
        </x-heading>

        <div class="grid gap-8 lg:grid-cols-3">
            @foreach ($articles as $article)
                <div class="overflow-hidden bg-white frame rounded-xl">
                    <div class="w-full aspect-[4/3] overflow-hidden">
                        <img src="{{ asset($article->photo) }}" alt="{{ $article->title }}"
                            class="object-cover w-full h-full transition-all duration-300 hover:scale-110">
                    </div>

                    <div class="p-8 space-y-4">
                        <h3 class="text-lg font-bold text-primary">
                            {{ $article->title }}
                        </h3>
                        <p class="text-zinc-600 line-clamp-3">
                            {{ $article->excerpt }}
                        </p>

                        <a href="{{ route('articles.show', $article) }}" class="block">
                            <x-button variant="accent" size="sm">
                                {{ __('Baca') }}
                            </x-button>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section id="location" class="py-20">
        <x-heading level="h2" class="max-w-xl mx-auto mb-8 text-center">
            <x-slot name="title">
                {{ __('Lokasi') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Kami berusaha untuk membantu Anda membuat Janji yang lebih efektif, dengan berbagai metode pembayaran yang tersedia.') }}
            </x-slot>
        </x-heading>

        <div class="frame overlflow-hidden rounded-xl">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126920.2822852331!2d106.74711806225045!3d-6.229569455433135!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5371bf0fdad786a2!2sJakarta%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1717847241533!5m2!1sid!2sid"
                width="1280" height="720" loading="lazy" class="w-full aspect-video">
            </iframe>
        </div>
    </section>

    @php
        $testimonials = [
            [
                'name' => 'John Doe',
                'quote' =>
                    'Janji adalah sebuah perusahaan yang bertujuan untuk membantu Anda membuat Janji yang lebih efektif, dengan berbagai metode pembayaran yang tersedia.',
            ],
            [
                'name' => 'Jane Doe',
                'quote' =>
                    'Janji adalah sebuah perusahaan yang bertujuan untuk membantu Anda membuat Janji yang lebih efektif, dengan berbagai metode pembayaran yang tersedia.',
            ],
            [
                'name' => 'John Doe',
                'quote' =>
                    'Janji adalah sebuah perusahaan yang bertujuan untuk membantu Anda membuat Janji yang lebih efektif, dengan berbagai metode pembayaran yang tersedia.',
            ],
            [
                'name' => 'Jane Doe',
                'quote' =>
                    'Janji adalah sebuah perusahaan yang bertujuan untuk membantu Anda membuat Janji yang lebih efektif, dengan berbagai metode pembayaran yang tersedia.',
            ],
        ];
    @endphp

    <section id="testimonial" class="py-20">
        <x-heading level="h2" class="max-w-xl mx-auto mb-8 text-center">
            <x-slot name="title">
                {{ __('Testimonial') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Kami menyediakan arti yang berkualitas tinggi, yang dapat membantu Anda membuat Janji yang lebih efektif.') }}
            </x-slot>
        </x-heading>

        <div class="grid gap-8 lg:grid-cols-2">
            @foreach ($testimonials as $testimonial)
                <div class="p-8 space-y-2 bg-white frame rounded-xl">
                    <x-avatar value="{{ $testimonial['name'] }}" size="md" expand />
                    <p class="text-zinc-600 line-clamp-2">
                        {{ $testimonial['quote'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </section>
</x-landing-layout>
