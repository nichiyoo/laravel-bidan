<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Kelola Data Janji') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Kelola Data Janji pada aplikasi') . ' ' . config('app.name') }}
        </x-slot>
    </x-heading>

    <div class="flex flex-col justify-between gap-6 lg:items-end lg:flex-row">
        <form action="{{ route('patients.appointments.index') }}" method="get"
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

            <div class="w-full min-w-40">
                <x-label for="status" :value="__('fields.status.label')" />
                <x-select id="status" name="status" x-on:change="$form.submit()">
                    <option value="" @if ($status == null) selected @endif>
                        {{ __('fields.status.placeholder') }}
                    </option>
                    @foreach ($statuses as $item)
                        <option value="{{ $item }}" @if ($item == $status) selected @endif>
                            {{ \Illuminate\Support\Str::title(__('status.' . $item)) }}
                        </option>
                    @endforeach
                </x-select>
            </div>
        </form>

        <a href="{{ route('patients.appointments.create') }}">
            <x-button variant="accent">
                <i data-lucide="plus"></i>
                {{ __('Janji') }}
            </x-button>
        </a>
    </div>

    <x-table>
        <x-slot name="head">
            <th class="min-w-40">{{ __('Nama Pasien') }}</th>
            <th>{{ __('Layanan') }}</th>
            <th>{{ __('Tanggal Janji') }}</th>
            <th>{{ __('Jam Janji') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Aksi') }}</th>
        </x-slot>

        <x-slot name="body">
            @forelse ($appointments as $appointment)
                <tr>
                    <td> <x-avatar value="{{ $appointment->patient->user->name }}" size="sm" expand /></td>
                    <td>{{ $appointment->service->title }}</td>
                    <td> <x-date value="{{ $appointment->date }}" /> </td>
                    <td> {{ $appointment->time }} </td>
                    <td> <x-badge value="{{ $appointment->status }}" /></td>
                    <td>
                        <div class="flex items-center space-x-2">
                            @if (auth()->user()->role == 'admin')
                                <a href="{{ route('patients.appointments.show', $appointment) }}" class="inline-flex">
                                    <x-button variant="outline" size="icon" label="{{ __('Lihat') }}">
                                        <i data-lucide="eye" class="size-5"></i>
                                    </x-button>
                                </a>
                            @endif

                            @if ($appointment->status == 'pending')
                                <a href="{{ route('patients.appointments.edit', $appointment) }}" class="inline-flex">
                                    <x-button variant="outline" size="icon" label="{{ __('Pembayaran') }}">
                                        <i data-lucide="dollar-sign" class="size-5"></i>
                                    </x-button>
                                </a>
                            @endif

                            @if (auth()->user()->role == 'admin' && $appointment->status == 'confirmed')
                                <a href="{{ route('admins.appointments.diagnoses.create', $appointment) }}"
                                    class="inline-flex">
                                    <x-button variant="outline" size="icon" label="{{ __('Rekam Medis') }}">
                                        <i data-lucide="pencil" class="size-5"></i>
                                    </x-button>
                                </a>
                            @endif

                            @if (!in_array($appointment->status, ['cancelled', 'finished']))
                                <x-button variant="outline" size="icon" label="{{ __('Batalkan') }}"
                                    x-on:click="$dispatch('modal', {
                                    name: 'delete-modal',
                                    action: '{{ route('patients.appointments.cancel', $appointment) }}'
                                })">
                                    <i data-lucide="x" class="size-5"></i>
                                </x-button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colSpan="5" class="text-center">{{ __('Tidak ada data') }}</td>
                </tr>
            @endforelse
        </x-slot>
    </x-table>

    {{ $appointments->links() }}
</x-app-layout>
