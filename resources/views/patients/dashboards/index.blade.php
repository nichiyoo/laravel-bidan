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
        @php
            $dashboards = [
                [
                    'icon' => 'bar-chart-2',
                    'label' => __('Statistik'),
                    'href' => route('dashboard'),
                ],
                [
                    'icon' => 'user',
                    'label' => __('Profil Pengguna'),
                    'href' => route('patients.profile.edit'),
                ],
            ];
        @endphp

        <x-heading level="h4">
            <x-slot name="title">
                {{ __('Navigasi') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae accusantium, saepe dicta velit dolorem soluta.') }}
            </x-slot>
        </x-heading>

        <div class="grid gap-4 lg:grid-cols-2 xl:grid-cols-4">
            @foreach ($dashboards as $dashboard)
                <a href="{{ $dashboard['href'] }}" class="block">
                    <div class="flex p-4 mb-2 text-sm rounded-lg frame gap-x-2">
                        <i data-lucide="{{ $dashboard['icon'] }}" class="flex-none text-accent size-5"></i>
                        {{ $dashboard['label'] }}
                    </div>
                </a>
            @endforeach

            <form action="{{ route('logout') }}" method="POST" class="block">
                @csrf

                <button type="submit" class="flex w-full p-4 mb-2 text-sm rounded-lg frame gap-x-2">
                    <i data-lucide="door-closed" class="flex-none text-accent size-5"></i>
                    {{ __('Keluar') }}
                </button>
            </form>
        </div>
    </div>


    <div class="flex flex-col gap-4">
        @php
            $patients = [
                [
                    'icon' => 'calendar-check',
                    'label' => __('Data Janji'),
                    'href' => route('patients.appointments.index'),
                ],
                [
                    'icon' => 'heart-pulse',
                    'label' => __('Data Rekam Medis'),
                    'href' => route('patients.diagnoses.index'),
                ],
                [
                    'icon' => 'wallet',
                    'label' => __('Data Riwayat Pembayaran'),
                    'href' => route('patients.receipts.index'),
                ],
                [
                    'icon' => 'message-square',
                    'label' => __('Data Kritik dan Saran'),
                    'href' => route('patients.reviews.index'),
                ],
            ];
        @endphp

        <x-heading level="h4">
            <x-slot name="title">
                {{ __('Menu Pasien') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae accusantium, saepe dicta velit dolorem soluta.') }}
            </x-slot>
        </x-heading>

        <div class="grid gap-4 lg:grid-cols-2 xl:grid-cols-4">
            @foreach ($patients as $patient)
                <a href="{{ $patient['href'] }}" class="block">
                    <div class="flex p-4 mb-2 text-sm rounded-lg frame gap-x-2">
                        <i data-lucide="{{ $patient['icon'] }}" class="flex-none text-accent size-5"></i>
                        {{ $patient['label'] }}
                    </div>
                </a>
            @endforeach
        </div>
    </div>

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
