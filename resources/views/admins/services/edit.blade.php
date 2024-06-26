<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Perbarui Data Layanan') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Perbarui Data Layanan, dan pastikan data yang dikirim benar') }}
        </x-slot>
    </x-heading>

    <form action="{{ route('admins.services.update', $service) }}" method="post" class="grid gap-6 lg:grid-cols-2"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <x-label for="title" :value="__('services.title.label')" />
            <x-input id="title" type="text" name="title" placeholder="{{ __('services.title.placeholder') }}"
                value="{{ old('title') ?? $service->title }}" autocomplete="title" autofocus required />
            <x-error :value="$errors->get('title')" />
        </div>

        <div>
            <x-label for="price" :value="__('services.price.label')" />
            <x-input id="price" type="number" name="price" placeholder="{{ __('services.price.placeholder') }}"
                value="{{ old('price') ?? $service->price }}" required />
            <x-error :value="$errors->get('price')" />
        </div>

        <div class="col-span-full">
            <x-label for="description" :value="__('services.description.label')" />
            <x-textarea id="description" name="description" placeholder="{{ __('services.description.placeholder') }}"
                value="{{ old('description') ?? $service->description }}" required rows="5" />
            <x-error :value="$errors->get('description')" />
        </div>

        <div class="col-span-full">
            <x-label for="photo" :value="__('services.photo.label')" />
            <x-image-upload name="photo" value="{{ $service->photo ? asset($service->photo) : null }}"
                placeholder="{{ __('services.photo.placeholder') }}" />
            <x-error :value="$errors->get('photo')" />
        </div>


        <div class="flex justify-end space-x-2 col-span-full">
            <x-button type="reset" variant="outline">
                {{ __('actions.reset') }}
            </x-button>

            <x-button type="submit" variant="primary">
                {{ __('actions.submit') }}
            </x-button>
        </div>
    </form>
</x-app-layout>
