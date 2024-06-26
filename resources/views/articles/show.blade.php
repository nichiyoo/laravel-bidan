<x-landing-layout>
    <section id="hero" class="grid items-center gap-8 py-20">
        <x-heading level="h1">
            <x-slot name="title">
                {{ $article->title }}
            </x-slot>

            <x-slot name="description">
                {{ $article->excerpt }}
            </x-slot>
        </x-heading>

        <figure class="w-full overflow-hidden aspect-video rounded-xl">
            <img src="{{ asset($article->photo) }}" alt="{{ $article->title }}" class="object-cover w-full h-full">
        </figure>

        <div
            class="p-8 mx-auto space-y-4 prose prose-headings:font-sans prose-headings:tracking-normal max-w-none prose-p:leading-relaxed prose-pink">
            {!! $article->body !!}
        </div>
    </section>
</x-landing-layout>
