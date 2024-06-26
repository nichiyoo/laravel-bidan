<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Detail Kritik dan Saran') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Detail Kritik dan Saran, dan pastikan data yang dikirim benar') }}
        </x-slot>
    </x-heading>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="col-span-full">
            <x-label for="body" :value="__('reviews.body.label')" />
            <x-textarea id="body" name="body" value="{{ $review->body }}" readonly rows="5" />
        </div>

        <div class="col-span-full">
            <x-label for="action" :value="__('reviews.action.label')" />
            <x-textarea id="action" name="action" value="{{ $review->action }}" readonly rows="5" />
        </div>

        <div class="col-span-full">
            <x-label for="respond" :value="__('reviews.respond.label')" />
            <x-textarea id="respond" name="respond" value="{{ $review->respond }}" readonly rows="5" />
        </div>

        <div>
            <x-label for="status" :value="__('reviews.status.label')" />
            <x-input type="text" id="status" name="status" value="{{ $review->status }}" readonly />
        </div>
    </div>
</x-app-layout>
