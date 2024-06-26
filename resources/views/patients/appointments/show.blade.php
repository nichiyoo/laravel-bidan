<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Detail Janji') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Detail Janji, dan pastikan data yang dikirim benar') }}
        </x-slot>
    </x-heading>

    <form action="{{ route('patients.appointments.store') }}" method="post" class="grid gap-6 lg:grid-cols-2">
        @csrf

        <div class="col-span-full">
            <x-label for="date" :value="__('appointments.date.label')" />
            <x-input id="date" type="date" name="date" value="{{ $appointment->date->format('Y-m-d') }}"
                readonly />
        </div>

        <div class="col-span-full">
            <x-label for="time" :value="__('appointments.time.label')" />
            <x-input id="time" type="time" name="time" value="{{ $appointment->time }}" readonly />
        </div>

        <div class="col-span-full">
            <x-label for="service_id" :value="__('appointments.service_id.label')" />
            <div class="grid gap-4 lg:grid-cols-3">
                <div for="{{ $appointment->service->id }}"
                    class="relative overflow-hidden cursor-pointer frame rounded-xl group">

                    <figure class="w-full overflow-hidden aspect-thumbnail">
                        <img src="{{ asset($appointment->service->photo) }}" alt="{{ $appointment->service->title }}"
                            class="object-cover w-full h-full transition-all duration-300 hover:scale-110">
                    </figure>

                    <div class="p-6 space-y-4">
                        <h3 class="text-lg font-bold text-primary">
                            {{ $appointment->service->title }}
                        </h3>

                        <p class="text-zinc-600 line-clamp-3">
                            {{ $appointment->service->description }}
                        </p>

                        <span class="block font-semibold text-accent">
                            Rp{{ $appointment->service->price }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-full">
            <x-label for="payment_id" :value="__('appointments.payment_id.label')" />
            <x-input type="text" id="payment_id" name="payment_id" value="{{ $appointment->payment->account }}"
                readonly />
        </div>

        <div>
            <x-label for="frequency" :value="__('appointments.frequency.label')" />
            <x-input type="text" id="frequency" name="frequency"
                value="{{ \Illuminate\Support\Str::title(__('frequencies.' . $appointment->notification->frequency)) }}"
                readonly />
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
