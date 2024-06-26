<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Laporan Data Pasien') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Laporan Data Pasien pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>


    <div class="flex flex-col justify-start gap-6 lg:items-end lg:flex-row">
        <a href="{{ route('admins.patients.export', ['format' => 'csv']) }}">
            <x-button variant="outline">
                <i data-lucide="download"></i>
                {{ __('Unduh CSV') }}
            </x-button>
        </a>

        <a href="{{ route('admins.patients.export', ['format' => 'pdf']) }}" target="_blank">
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
            <th>{{ __('NIK') }}</th>
            <th>{{ __('Jenis Kelamin') }}</th>
            <th>{{ __('Alamat') }}</th>
            <th>{{ __('Telefon') }}</th>
            <th>{{ __('Tanggal Lahir') }}</th>
            <th>{{ __('Tempat Lahir') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($patients as $patient)
                <tr>
                    <td>{{ $patient->id }}</td>
                    <td><x-avatar value="{{ $patient->user->name }}" size="sm" expand /></td>
                    <td>{{ $patient->nik }}</td>
                    <td><x-gender value="{{ $patient->gender }}" /></td>
                    <td>{{ $patient->address }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>{{ $patient->birth_date->format('d F Y') }}</td>
                    <td>{{ $patient->birth_place }}</td>
                </tr>
            @empty
                <tr>
                    <td colSpan="7" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $patients->links() }}
</x-app-layout>
