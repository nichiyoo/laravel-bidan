<x-print-layout>
    <h1>{{ __('Laporan Data Artikel') }}</h1>
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
                <th>{{ __('Nama Pasien') }}</th>
                <th>{{ __('Tanggal Janji') }}</th>
                <th>{{ __('Jam Janji') }}</th>
                <th>{{ __('Layanan') }}</th>
                <th>{{ __('Catatan Pemeriksaan') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($diagnoses as $diagnosis)
                <tr>
                    <td>{{ $diagnosis->id }}</td>
                    <td>{{ $diagnosis->appointment->patient->user->name }}</td>
                    <td>{{ $diagnosis->appointment->date }}</td>
                    <td>{{ $diagnosis->appointment->time }} </td>
                    <td>{{ $diagnosis->appointment->service->title }}</td>
                    <td>{{ $diagnosis->detail }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-print-layout>
