<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Statistik') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Statistik data pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <div class="flex flex-col gap-4">
        <x-heading level="h4">
            <x-slot name="title">
                {{ __('Data Pembayaran') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae accusantium, saepe dicta velit dolorem soluta.') }}
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
    </div>
</x-app-layout>
