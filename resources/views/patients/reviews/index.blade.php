<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Kelola Data Kritik dan Saran') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Kelola Data Kritik dan Saran pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <div class="flex flex-col justify-between gap-6 lg:items-end lg:flex-row">
        <form action="{{ route('patients.reviews.index') }}" method="get"
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

        <a href="{{ route('patients.reviews.create') }}">
            <x-button variant="accent">
                <i data-lucide="plus"></i>
                {{ __('Kritik dan Saran') }}
            </x-button>
        </a>
    </div>

    <x-table>
        <x-slot name="head">
            <th class="min-w-40">{{ __('Nama') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Detail') }}</th>
            <th>{{ __('Tindakan') }}</th>
            <th>{{ __('Aksi') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($reviews as $review)
                <tr>
                    <td> <x-avatar value="{{ $review->user->name }}" size="sm" expand /></td>
                    <td><x-badge value="{{ $review->status }}" /></td>
                    <td>
                        {{ \Illuminate\Support\Str::words($review->body, 4) }}
                    </td>
                    <td>
                        {{ \Illuminate\Support\Str::words($review->action, 4) }}
                    </td>
                    <td>
                        <a href="{{ route('patients.reviews.show', $review) }}" class="inline-flex">
                            <x-button variant="outline" size="icon" label="{{ __('Lihat') }}">
                                <i data-lucide="eye" class="size-5"></i>
                            </x-button>
                        </a>

                        @role('admin')
                            <a href="{{ route('admins.reviews.edit', $review) }}" class="inline-flex">
                                <x-button variant="outline" size="icon" label="{{ __('Edit') }}">
                                    <i data-lucide="settings-2" class="size-5"></i>
                                </x-button>
                            </a>

                            <x-button class="block" variant="outline" size="icon" label="{{ __('Hapus') }}"
                                x-on:click="$dispatch('modal', {
                                    name: 'delete-modal',
                                    action: '{{ route('admins.reviews.destroy', $review) }}'
                                })">
                                <i data-lucide="trash-2" class="size-5"></i>
                            </x-button>
                        @endrole
                    </td>
                </tr>
            @empty
                <tr>
                    <td colSpan="5" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $reviews->links() }}
</x-app-layout>
