<aside x-data="{ open: $persist(false).as('sidebar') }" x-bind:class="{ 'w-full md:max-w-xs': open }"
    class="relative flex-none w-full bg-primary md:max-w-xs">

    <div class="absolute hidden px-4 text-white md:block top-4">
        <div class="flex items-center px-2 py-2 space-x-4 rounded-md cursor-pointer hover:bg-white/10"
            x-on:click="open = ! open">
            <i data-lucide="menu" class="size-5"></i>
            <span class="sr-only">{{ __('Open') }}</span>
        </div>
    </div>

    @php
        $dashboards = [
            [
                'label' => __('Statistik'),
                'href' => route('dashboard'),
            ],
            [
                'label' => __('Profil Pengguna'),
                'href' => route('patients.profile.edit'),
            ],
        ];

        $patients = [
            [
                'label' => __('Data Janji'),
                'href' => route('patients.appointments.index'),
            ],
            [
                'label' => __('Data Rekam Medis'),
                'href' => route('patients.diagnoses.index'),
            ],
            [
                'label' => __('Data Riwayat Pembayaran'),
                'href' => route('patients.receipts.index'),
            ],
            [
                'label' => __('Data Kritik dan Saran'),
                'href' => route('patients.reviews.index'),
            ],
        ];

        $masters = [
            [
                'label' => __('Master Data Pengguna'),
                'href' => route('admins.users.index'),
            ],
            [
                'label' => __('Master Data Pasien'),
                'href' => route('admins.patients.index'),
            ],
            [
                'label' => __('Master Data Artikel'),
                'href' => route('admins.articles.index'),
            ],
            [
                'label' => __('Master Data Layanan'),
                'href' => route('admins.services.index'),
            ],
            [
                'label' => __('Master Data Pembayaran'),
                'href' => route('admins.payments.index'),
            ],
        ];

        $reports = [
            [
                'label' => __('Laporan Pengguna'),
                'href' => route('admins.users.report'),
            ],
            [
                'label' => __('Laporan Pasien'),
                'href' => route('admins.patients.report'),
            ],
            [
                'label' => __('Laporan Artikel'),
                'href' => route('admins.articles.report'),
            ],
            [
                'label' => __('Laporan Layanan'),
                'href' => route('admins.services.report'),
            ],
            [
                'label' => __('Laporan Data Metode Pembayaran'),
                'href' => route('admins.payments.report'),
            ],
            [
                'label' => __('Laporan Janji'),
                'href' => route('admins.appointments.report'),
            ],
            [
                'label' => __('Laporan Rekam Medis'),
                'href' => route('admins.diagnoses.report'),
            ],
            [
                'label' => __('Laporan Kritik dan Saran'),
                'href' => route('admins.reviews.report'),
            ],
        ];
    @endphp

    <div class="px-4 my-16 mt-4 md:mt-32 gap-y-6">
        <x-sidenav open="open" label="{{ __('Beranda') }}" icon="home">
            @foreach ($dashboards as $dashboard)
                <a href="{{ $dashboard['href'] }}" class="block">
                    <li>
                        {{ $dashboard['label'] }}
                    </li>
                </a>
            @endforeach
        </x-sidenav>

        <x-sidenav open="open" label="{{ __('Data Pasien') }}" icon="heart-pulse">
            @foreach ($patients as $patient)
                <a href="{{ $patient['href'] }}" class="block">
                    <li>
                        {{ $patient['label'] }}
                    </li>
                </a>
            @endforeach
        </x-sidenav>

        <x-sidenav open="open" label="{{ __('Master Data Admin') }}" icon="hospital">
            @foreach ($masters as $master)
                <a href="{{ $master['href'] }}" class="block">
                    <li>
                        {{ $master['label'] }}
                    </li>
                </a>
            @endforeach
        </x-sidenav>

        <x-sidenav open="open" label="{{ __('Laporan') }}" icon="file-text">
            @foreach ($reports as $report)
                <a href="{{ $report['href'] }}" class="block">
                    <li>
                        {{ $report['label'] }}
                    </li>
                </a>
            @endforeach
        </x-sidenav>
    </div>

    <form action="{{ route('logout') }}" method="POST" class="absolute w-full px-4 text-white bottom-4">
        @csrf

        <button type="submit"
            class="flex items-center w-full px-2 py-2 space-x-4 text-sm rounded-md cursor-pointer hover:bg-white/10">
            <i data-lucide="door-closed" class="size-5"></i>
            <span class="md:sr-only" x-bind:class="{ 'md:sr-only': !open }">{{ __('Keluar') }}</span>
        </button>
    </form>
</aside>
