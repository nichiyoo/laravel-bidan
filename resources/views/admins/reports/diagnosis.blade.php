<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Laporan Data Rekam Medis') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Laporan Data Rekam Medis pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <div class="flex flex-col justify-between gap-6 lg:items-end lg:flex-row">
        <form action="{{ route('admins.diagnoses.report') }}" method="get"
            class="flex flex-col items-end gap-4 lg:flex-row" x-data="{
                $form: null,
                init() {
                    this.$form = this.$refs.form;
                },
            }" x-ref="form">

            <div class="w-full min-w-40">
                <x-label for="start" :value="__('fields.start.label')" />
                <x-input id="start" type="date" name="start" placeholder="{{ __('fields.start.placeholder') }}"
                    value="{{ $start }}" autocomplete="start" x-on:input.debounce.300ms="$form.submit()"
                    autofocus />
            </div>

            <div class="w-full min-w-40">
                <x-label for="end" :value="__('fields.end.label')" />
                <x-input id="end" type="date" name="end" placeholder="{{ __('fields.end.placeholder') }}"
                    value="{{ $end }}" autocomplete="end" x-on:input.debounce.300ms="$form.submit()" />
            </div>
        </form>

        <div class="flex flex-col justify-start gap-6 lg:items-end lg:flex-row">
            <a
                href="{{ route('admins.diagnoses.export', [
                    'format' => 'csv',
                    'start' => $start,
                    'end' => $end,
                ]) }}">
                <x-button variant="outline">
                    <i data-lucide="download"></i>
                    {{ __('Unduh CSV') }}
                </x-button>
            </a>

            <a href="{{ route('admins.diagnoses.export', [
                'format' => 'pdf',
                'start' => $start,
                'end' => $end,
            ]) }}"
                target="_blank">
                <x-button variant="outline">
                    <i data-lucide="download"></i>
                    {{ __('Unduh PDF') }}
                </x-button>
            </a>
        </div>
    </div>

    <x-table>
        <x-slot name="head">
            <th>{{ __('No') }}</th>
            <th>{{ __('Nama Pasien') }}</th>
            <th>{{ __('Tanggal Janji') }}</th>
            <th>{{ __('Jam Janji') }}</th>
            <th>{{ __('Layanan') }}</th>
            <th>{{ __('Catatan Pemeriksaan') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($diagnoses as $diagnosis)
                <tr>
                    <td>{{ $diagnosis->id }}</td>
                    <td>
                        <x-avatar value="{{ $diagnosis->appointment->patient->user->name }}" size="sm" expand />
                    </td>
                    <td><x-date value="{{ $diagnosis->appointment->date }}" /></td>
                    <td>{{ $diagnosis->appointment->time }} </td>
                    <td>{{ $diagnosis->appointment->service->title }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($diagnosis->detail, 100) }}</td>
                </tr>
            @empty
                <tr>
                    <td colSpan="5" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $diagnoses->links() }}
</x-app-layout>
