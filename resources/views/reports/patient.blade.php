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
                <th>{{ __('Tanggal Dibuat') }}</th>
                <th>{{ __('Nik') }}</th>
                <th>{{ __('Nama') }}</th>
                <th>{{ __('Jenis Kelamin') }}</th>
                <th>{{ __('Alamat') }}</th>
                <th>{{ __('Telefon') }}</th>
                <th>{{ __('Tanggal Lahir') }}</th>
                <th>{{ __('Tempat Lahir') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $patient)
                <tr>
                    <td>{{ $patient->id }}</td>
                    <td>{{ $patient->created_at->format('d F Y') }}</td>
                    <td>{{ $patient->user->name }}</td>
                    <td>{{ $patient->nik }}</td>
                    <td>{{ $patient->gender }}</td>
                    <td>{{ $patient->address }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>{{ $patient->birth_date->format('d F Y') }}</td>
                    <td>{{ $patient->birth_place }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-print-layout>
