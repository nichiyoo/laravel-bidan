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
                <th>{{ __('Tanggal Dibuat') }}</th>
                <th>{{ __('Judul') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Dilihat') }}</th>
                <th>{{ __('Deskripsi') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->created_at->format('d F Y') }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->status }}</td>
                    <td>{{ $article->views }}</td>
                    <td>{{ $article->excerpt }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-print-layout>
