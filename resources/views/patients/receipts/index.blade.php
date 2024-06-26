<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Kelola Data Pembayaran') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Kelola Data Pembayaran pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <div class="grid gap-4 lg:grid-cols-2 xl:grid-cols-4">
        @foreach ($sums as $item)
            <div class="flex flex-col p-4 mb-2 text-sm rounded-lg frame gap-y-4">
                <div class="flex items-center justify-between text-zinc-500">
                    <span> {{ \Illuminate\Support\Str::title(__('status.' . $item->status)) }}</span>
                </div>
                <span class="text-2xl font-medium text-primary">
                    Rp{{ number_format($item->sum, 2) }}
                </span>
            </div>
        @endforeach
    </div>

    <x-table>
        <x-slot name="head">
            <th>{{ __('Tanggal') }}</th>
            <th class="min-w-40">{{ __('Nama Pasien') }}</th>
            <th>{{ __('Layanan') }}</th>
            <th>{{ __('Metode Pembayaran') }}</th>
            <th>{{ __('Jumlah Pembayaran') }}</th>
            <th>{{ __('Status') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($receipts as $receipt)
                <tr>
                    <td> <x-date value="{{ $receipt->date }}" /> </td>
                    <td> <x-avatar value="{{ $receipt->patient->user->name }}" size="sm" expand /></td>
                    <td>{{ $receipt->service->title }}</td>
                    <td>{{ $receipt->payment->account }}</td>
                    <td>
                        <x-currency value="{{ $receipt->service->price + $receipt->code }}" />
                    </td>
                    <td> <x-badge value="{{ $receipt->status }}" /></td>
                </tr>
            @empty
                <tr>
                    <td colSpan="5" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $receipts->links() }}
</x-app-layout>
