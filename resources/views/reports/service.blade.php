<x-print-layout>
    <h1>{{ __('Laporan Data Layanan') }}</h1>
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
                <th>{{ __('Nama Layanan') }}</th>
                <th>{{ __('Harga') }}</th>
                <th>{{ __('Deskripsi') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($services as $service)
                <tr>
                    <td>{{ $service->id }}</td>
                    <td>{{ $service->created_at->format('d F Y') }}</td>
                    <td>{{ $service->title }}</td>
                    <td>{{ $service->price }}</td>
                    <td>{{ $service->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-print-layout>
