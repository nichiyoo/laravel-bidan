<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Kelola Data Rekam Medis') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Kelola Data Rekam Medis pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <div class="flex flex-col justify-between gap-6 lg:items-end lg:flex-row">
        <form action="{{ route('patients.diagnoses.index') }}" method="get"
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
    </div>

    <x-table>
        <x-slot name="head">
            <th class="min-w-40">{{ __('Nama Pasien') }}</th>
            <th>{{ __('Tanggal') }}</th>
            <th>{{ __('Jam') }}</th>
            <th>{{ __('Layanan') }}</th>
            <th>{{ __('Aksi') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($diagnoses as $diagnosis)
                <tr>
                    <td>
                        <x-avatar value="{{ $diagnosis->appointment->patient->user->name }}" size="sm" expand />
                    </td>
                    <td><x-date value="{{ $diagnosis->appointment->date }}" /></td>
                    <td>{{ $diagnosis->appointment->time }}</td>
                    <td>{{ $diagnosis->appointment->service->title }}</td>
                    <td>
                        <a href="{{ route('patients.diagnoses.show', $diagnosis) }}">
                            <x-button variant="outline" size="icon" label="{{ __('Baca Detail') }}">
                                <i data-lucide="eye"></i>
                            </x-button>
                        </a>

                        @role('admin')
                            <a href="{{ route('admins.diagnoses.edit', $diagnosis) }}">
                                <x-button variant="outline" size="icon" label="{{ __('Edit') }}">
                                    <i data-lucide="edit"></i>
                                </x-button>
                            </a>
                        @endrole
                    </td>
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
