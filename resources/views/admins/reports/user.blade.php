<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Laporan Data Pengguna') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Laporan Data Pengguna pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <div class="flex flex-col justify-start gap-6 lg:items-end lg:flex-row">
        <a href="{{ route('admins.users.export', ['format' => 'csv']) }}">
            <x-button variant="outline">
                <i data-lucide="download"></i>
                {{ __('Unduh CSV') }}
            </x-button>
        </a>

        <a href="{{ route('admins.users.export', ['format' => 'pdf']) }}" target="_blank">
            <x-button variant="outline">
                <i data-lucide="download"></i>
                {{ __('Unduh PDF') }}
            </x-button>
        </a>
    </div>

    <x-table>
        <x-slot name="head">
            <th>{{ __('No') }}</th>
            <th>{{ __('Nama') }}</th>
            <th>{{ __('Email') }}</th>
            <th>{{ __('Role') }}</th>
            <th>{{ __('Tanggal Bergabung') }}</th>
            <th>{{ __('Tanggal Verifikasi') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td> <x-avatar value="{{ $user->name }}" size="sm" expand /></td>
                    <td>{{ $user->email }}</td>
                    <td><x-badge :value="$user->role" /></td>
                    <td><x-date value="{{ $user->created_at }}" /></td>
                    <td><x-date value="{{ $user->email_verified_at }}" /></td>
                </tr>
            @empty
                <tr>
                    <td colSpan="6" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $users->links() }}
</x-app-layout>
