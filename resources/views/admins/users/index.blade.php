<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Kelola Data Pengguna') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Kelola Data Pengguna pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <div class="flex flex-col justify-between gap-6 lg:items-end lg:flex-row">
        <form action="{{ route('admins.users.index') }}" method="get" class="flex flex-col items-end gap-4 lg:flex-row"
            x-data="{
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

        <a href="{{ route('admins.users.create') }}">
            <x-button variant="accent">
                <i data-lucide="plus"></i>
                {{ __('Pengguna') }}
            </x-button>
        </a>
    </div>

    <x-table>
        <x-slot name="head">
            <th class="min-w-40">{{ __('Nama') }}</th>
            <th>{{ __('Email') }}</th>
            <th>{{ __('Role') }}</th>
            <th>{{ __('Aksi') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($users as $user)
                <tr>
                    <td> <x-avatar value="{{ $user->name }}" size="sm" expand /></td>
                    <td>{{ $user->email }}</td>
                    <td><x-badge :value="$user->role" /></td>
                    <td>
                        <x-action edit="{{ route('admins.users.edit', $user) }}"
                            delete="{{ route('admins.users.destroy', $user) }}" />
                    </td>
                </tr>
            @empty
                <tr>
                    <td colSpan="5" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $users->links() }}
</x-app-layout>
