<x-print-layout>
    <h1>{{ __('Laporan Data Metode Pembayaran') }}</h1>
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
                <th>{{ __('Nama Rekening') }}</th>
                <th>{{ __('Nomor Rekening') }}</th>
                <th>{{ __('Keterangan') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->created_at->format('d F Y') }}</td>
                    <td>{{ $payment->account }}</td>
                    <td>{{ $payment->number }}</td>
                    <td>{{ $payment->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-print-layout>
