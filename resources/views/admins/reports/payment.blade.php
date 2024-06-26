<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Laporan Data Metode Pembayaran') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Laporan Data Metode Pembayaran pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <div class="flex flex-col justify-start gap-6 lg:items-end lg:flex-row">
        <a href="{{ route('admins.payments.export', ['format' => 'csv']) }}">
            <x-button variant="outline">
                <i data-lucide="download"></i>
                {{ __('Unduh CSV') }}
            </x-button>
        </a>

        <a href="{{ route('admins.payments.export', ['format' => 'pdf']) }}" target="_blank">
            <x-button variant="outline">
                <i data-lucide="download"></i>
                {{ __('Unduh PDF') }}
            </x-button>
        </a>
    </div>

    <x-table>
        <x-slot name="head">
            <th>{{ __('No') }}</th>
            <th>{{ __('Nama Rekening') }}</th>
            <th>{{ __('Nomor Rekening') }}</th>
            <th>{{ __('Keterangan') }}</th>
            <th>{{ __('Tanggal Dibuat') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->account }}</td>
                    <td><span class="font-medium text-accent">{{ $payment->number }}</span></td>
                    <td>{{ \Illuminate\Support\Str::words($payment->description, 7) }}</td>
                    <td><x-date value="{{ $payment->created_at }}" /></td>
                </tr>
            @empty
                <tr>
                    <td colSpan="5" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $payments->links() }}
</x-app-layout>
