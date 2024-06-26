<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Kelola Data Layanan') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Kelola Data Layanan pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <div class="flex flex-col justify-between gap-6 lg:items-end lg:flex-row">
        <form action="{{ route('admins.services.index') }}" method="get"
            class="flex flex-col items-end gap-4 lg:flex-row" x-data="{
                $form: null,
                init() {
                    this.$form = this.$refs.form;
                },
            }" x-ref="form">

            <div class="w-full min-w-40">
                <x-label for="search" :value="__('fields.search.label')" />
                <x-input id="search" type="text" name="search"
                    placeholder="{{ __('fields.search.placeholder') }}" value="{{ $search }}"
                    autocomplete="search" x-on:input.debounce.300ms="$form.submit()" autofocus />
            </div>
        </form>


        <a href="{{ route('admins.services.create') }}">
            <x-button variant="accent">
                <i data-lucide="plus"></i>
                {{ __('Layanan') }}
            </x-button>
        </a>
    </div>

    <x-table>
        <x-slot name="head">
            <th class="min-w-40">{{ __('Nama Layanan') }}</th>
            <th>{{ __('Harga') }}</th>
            <th>{{ __('Tanggal Dibuat') }}</th>
            <th>{{ __('Aksi') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($services as $service)
                <tr>
                    <td>
                        {{ \Illuminate\Support\Str::words($service->title, 7) }}
                    </td>
                    <td> <x-currency value="{{ $service->price }}" /> </td>
                    <td> <x-date value="{{ $service->created_at }}" /> </td>
                    <td>
                        <x-action edit="{{ route('admins.services.edit', $service) }}"
                            delete="{{ route('admins.services.destroy', $service) }}" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colSpan="5" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $services->links() }}
</x-app-layout>
