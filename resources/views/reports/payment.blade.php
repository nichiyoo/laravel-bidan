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
                <th>{{ __('Nama Rekening') }}</th>
                <th>{{ __('Nomor Rekening') }}</th>
                <th>{{ __('Keterangan') }}</th>
                <th>{{ __('Tanggal Dibuat') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->account }}</td>
                    <td>{{ $payment->number }}</td>
                    <td>{{ $payment->description }}</td>
                    <td>{{ $payment->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-print-layout>
