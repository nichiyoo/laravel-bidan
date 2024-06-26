<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Laporan Data Kritik dan Saran') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Laporan Data Kritik dan Saran pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <div class="flex flex-col justify-start gap-6 lg:items-end lg:flex-row">
        <a href="{{ route('admins.reviews.export', ['format' => 'csv']) }}">
            <x-button variant="outline">
                <i data-lucide="download"></i>
                {{ __('Unduh CSV') }}
            </x-button>
        </a>

        <a href="{{ route('admins.reviews.export', ['format' => 'pdf']) }}" target="_blank">
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
            <th>{{ __('Isi') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Tindakan') }}</th>
            <th>{{ __('Jawaban') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($reviews as $review)
                <tr>
                    <td>{{ $review->id }}</td>
                    <td><x-avatar value="{{ $review->user->name }}" size="sm" expand /></td>
                    <td>{{ \Illuminate\Support\Str::words($review->body, 7) }}</td>
                    <td> <x-badge value="{{ $review->status }}" /></td>
                    <td>{{ \Illuminate\Support\Str::words($review->action, 7) }}</td>
                    <td>{{ \Illuminate\Support\Str::words($review->respond, 7) }}</td>
                </tr>
            @empty
                <tr>
                    <td colSpan="6" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $reviews->links() }}
</x-app-layout>
