<x-print-layout>
    <h1>{{ __('Laporan Data Pengguna') }}</h1>
    <p>
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Rem odio, id quaerat nihil tempora magni
        reprehenderit pariatur molestiae autem a?
    </p>

    <span>
        {{ now()->format('d F Y') }}
    </span>

    <table>
        <thead>
            <tr>
                <th>{{ __('No') }}</th>
                <th>{{ __('Nama') }}</th>
                <th>{{ __('Email') }}</th>
                <th>{{ __('Role') }}</th>
                <th>{{ __('Tanggal Bergabung') }}</th>
                <th>{{ __('Tanggal Verifikasi') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->created_at->format('d F Y') }}</td>
                    <td>{{ $user->email_verified_at ? $user->email_verified_at->format('d F Y') : '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-print-layout>
