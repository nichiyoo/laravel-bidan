<x-landing-layout>
    <section id="hero" class="grid items-center gap-8 py-20">
        <x-heading level="h1">
            <x-slot name="title">
                {{ __('Dapatkan informasi tentang tips kesehatan') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Kami menyediakan artikel yang berkualitas tinggi, yang dapat membantu Anda membuat Janji yang lebih efektif.') }}
            </x-slot>

            <a href="{{ route('login') }}" class="block">
                <x-button variant="accent" label="Daftar">
                    {{ __('Daftar') }}
                </x-button>
            </a>
        </x-heading>
    </section>

    <section id="article" class="py-20">
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

</x-landing-layout>
