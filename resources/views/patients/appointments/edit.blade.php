<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Perbarui Data Janji') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Perbarui Data Janji, dan pastikan data yang dikirim benar') }}
        </x-slot>
    </x-heading>

    <form action="{{ route('patients.appointments.update', $appointment) }}" method="post"
        class="grid gap-6 lg:grid-cols-2" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="col-span-full">
            <x-label for="deadline" :value="__('appointments.deadline.label')" />
            <div x-data="{
                datestr: null,
                timeleft: null,
            
                init() {
                    this.datestr = {{ json_encode($appointment->created_at->addMinutes($timeout)->toDateTimeString()) }};
                    this.timeleft = this.update();
            
                    setInterval(() => {
                        this.timeleft = this.update();
                    }, 1000);
                },
            
                update() {
                    const offset = new Date().getTimezoneOffset() * 60000;
                    const current = new Date();
                    const target = new Date(this.datestr);
            
                    const diff = target - current - offset;
                    if (diff < 0) window.location = '{{ route('patients.appointments.index') }}';
            
                    return humanizeTime(Math.max(0, diff / 1000));
                },
            }">
                <span class="font-medium text-accent" x-text="timeleft">test</span>
            </div>
        </div>

        <div class="col-span-full">
            <x-label for="name" :value="__('appointments.name.label')" />
            <x-avatar value="{{ $appointment->patient->user->name }}" size="sm" expand />
        </div>

        <div>
            <x-label for="date" :value="__('appointments.date.label')" />
            <x-input id="date" type="date" name="date"
                placeholder="{{ __('appointments.date.placeholder') }}"
                value="{{ $appointment->date->format('Y-m-d') }}" readonly />
        </div>

        <div>
            <x-label for="time" :value="__('appointments.time.label')" />
            <x-input id="time" type="time" name="time"
                placeholder="{{ __('appointments.time.placeholder') }}" value="{{ $appointment->time }}" readonly />
        </div>

        <div class="col-span-full">
            <x-label for="total" :value="__('appointments.total.label')" />
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-x-4 text-zinc-500">
                    <span class="flex-none">{{ __('appointments.code.label') }}</span>
                    <div class="w-full border-b border-dotted border-zinc-500"></div>
                    <span class="flex-none">
                        Rp{{ number_format($appointment->code, 2) }}
                    </span>
                </div>

                <div class="flex items-center gap-x-4 text-zinc-500">
                    <span class="flex-none">{{ __('appointments.price.label') }}</span>
                    <div class="w-full border-b border-dotted border-zinc-500"></div>
                    <span class="flex-none">
                        Rp{{ number_format($appointment->service->price, 2) }}
                    </span>
                </div>

                <div class="flex items-center gap-x-4 text-zinc-500">
                    <span class="flex-none">{{ __('appointments.sum.label') }}</span>
                    <div class="w-full border-b border-dotted border-zinc-500"></div>
                    <span class="flex-none font-bold text-accent">
                        Rp{{ number_format($appointment->service->price + $appointment->code, 2) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-span-full">
            <x-label for="note" :value="__('appointments.note.label')" />
            <p class="text-zinc-500">
                {{ __('Pastikan jumlah pembayaran yang dikirim benar, kode unik digunakan untuk mengkonfirmasi pembayaran') }}
            </p>
        </div>

        <div class="col-span-full">
            <x-label for="receipt" :value="__('appointments.receipt.label')" />
            <x-image-upload name="receipt" value="{{ old('receipt') }}"
                placeholder="{{ __('appointments.receipt.placeholder') }}" required />
            <x-error :value="$errors->get('receipt')" />
        </div>

        <div class="flex justify-end space-x-2 col-span-full">
            <x-button type="reset" variant="outline">
                {{ __('actions.reset') }}
            </x-button>

            <x-button type="submit" variant="primary">
                {{ __('actions.submit') }}
            </x-button>
        </div>
    </form>
</x-app-layout>
