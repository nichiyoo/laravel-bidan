<x-landing-layout>
    <section id="hero" class="grid items-center gap-8 py-20">
        <x-heading level="h1">
            <x-slot name="title">
                {{ __('Testimonial') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Apa yang customers menilai tentang layanan kami?') }}
            </x-slot>

            <a href="{{ route('login') }}" class="block">
                <x-button variant="accent" label="Daftar">
                    {{ __('Daftar') }}
                </x-button>
            </a>
        </x-heading>
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

    <section id="services" class="py-20">
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
