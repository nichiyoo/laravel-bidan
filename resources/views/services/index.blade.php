<x-landing-layout>
    <section id="hero" class="grid items-center gap-8 py-20">
        <x-heading level="h1">
            <x-slot name="title">
                {{ __('Layanan yang tersedia') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Kami menyediakan layanan untuk membuat Janji yang lebih cepat dan efektif, dengan berbagai metode pembayaran yang tersedia.') }}
            </x-slot>

            <a href="{{ route('login') }}" class="block">
                <x-button variant="accent" label="Daftar">
                    {{ __('Daftar') }}
                </x-button>
            </a>
        </x-heading>
    </section>

    <section id="services" class="py-20">
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

    {{ $services->links() }}

</x-landing-layout>
