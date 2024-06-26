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
                <th>{{ __('Layanan') }}</th>
                <th>{{ __('Tanggal Janji') }}</th>
                <th>{{ __('Jam Janji') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Metode Pembayaran') }}</th>
                <th>{{ __('Jumlah Pembayaran') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->id }}</td>
                    <td>{{ $appointment->patient->user->name }}</td>
                    <td>{{ $appointment->service->title }}</td>
                    <td>{{ $appointment->date->format('d F Y') }}</td>
                    <td>{{ $appointment->time }} </td>
                    <td>{{ $appointment->status }}</td>
                    <td>{{ $appointment->payment->account }}</td>
                    <td>{{ $appointment->service->price + $appointment->code }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-print-layout>
