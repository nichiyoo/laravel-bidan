<x-app-layout>
    <x-heading level="h2">
        <x-slot name="title">
            {{ __('Tambah Data Janji') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Tambah Data Janji, dan pastikan data yang dikirim benar') }}
        </x-slot>
    </x-heading>

    <form action="{{ route('patients.appointments.store') }}" method="post" class="grid gap-6 lg:grid-cols-2">
        @csrf

        <div class="col-span-full">
            <x-label for="date" :value="__('appointments.date.label')" />
            <x-input id="date" type="date" name="date" placeholder="{{ __('appointments.date.placeholder') }}"
                value="{{ $date }}" autocomplete="date" min="{{ $min }}" max="{{ $max }}"
                required />
            <x-error :value="$errors->get('date')" />

            <script>
                const date = document.getElementById('date');
                date.addEventListener('change', function() {
                    const url = new URL(window.location.href);
                    url.searchParams.set('date', date.value);
                    window.location.href = url.toString();
                });
            </script>
        </div>

        <div class="col-span-full">
            <x-label for="time" :value="__('appointments.time.label')" />
            <div class="grid grid-cols-3 gap-4 lg:grid-cols-6">
                @foreach ($timetable as $time => $available)
                    <label for="{{ $time }}"
                        class="px-4 py-2 text-sm text-center rounded-lg frame group has-[:disabled]:opacity-50
                        has-[:checked]:bg-accent has-[:checked]:text-white cursor-pointer has-[:checked]:border-accent">

                        <input type="radio" id={{ $time }} name="time" value="{{ $time }}"
                            class="hidden w-4 h-4 border-2 border-gray-300 rounded-full text-accent"
                            @if (!$available) disabled @endif
                            @if ($time == old('time')) checked @endif />

                        <span>{{ $time }}</span>
                    </label>
                @endforeach
            </div>
            <x-error :value="$errors->get('time')" />
        </div>

        <div class="col-span-full">
            <x-label for="service_id" :value="__('appointments.service_id.label')" />
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                @foreach ($services as $service)
                    <label for="{{ $service->id }}" required
                        class="overflow-hidden frame rounded-xl group cursor-pointer relative
                        has-[:checked]:ring-1 has-[:checked]:ring-accent has-[:checked]:border-accent">

                        <div class="absolute top-0 right-0 m-4 hidden group-has-[:checked]:block">
                            <x-button variant="accent" size="icon" label="{{ __('Dipilih') }}">
                                <i data-lucide="check"></i>
                            </x-button>
                        </div>

                        <input type="radio" id={{ $service->id }} name="service_id" value="{{ $service->id }}"
                            class="hidden w-4 h-4 border-2 border-gray-300 rounded-full text-accent"
                            @if ($service->id == old('service_id')) checked @endif />

                        <figure class="w-full overflow-hidden aspect-thumbnail">
                            <img src="{{ asset($service->photo) }}" alt="{{ $service->title }}"
                                class="object-cover w-full h-full transition-all duration-300 hover:scale-110">
                        </figure>

                        <div class="p-6 space-y-4">
                            <h3 class="text-lg font-bold text-primary">
                                {{ $service->title }}
                            </h3>

                            <p class="text-zinc-600 line-clamp-3">
                                {{ $service->description }}
                            </p>

                            <span class="block font-semibold text-accent">
                                Rp{{ $service->price }}
                            </span>
                        </div>
                    </label>
                @endforeach
            </div>
            <x-error :value="$errors->get('service_id')" />
        </div>

        <div class="col-span-full">
            <x-label for="payment_id" :value="__('appointments.payment_id.label')" />
            <x-select id="payment_id" name="payment_id" required>
                <option value="" @if (old('payment_id') == null) selected @endif disabled>
                    {{ __('appointments.payment_id.placeholder') }}
                </option>

                @foreach ($payments as $item)
                    <option value="{{ $item->id }}" @if ($item->id == old('payment_id')) selected @endif>
                        {{ $item->account }}
                    </option>
                @endforeach
            </x-select>
            <x-error :value="$errors->get('payment_id')" />
        </div>

        <div>
            <x-label for="frequency" :value="__('appointments.frequency.label')" />
            <x-select id="frequency" name="frequency" required>
                <option value="" @if (old('frequency') == null) selected @endif disabled>
                    {{ __('appointments.frequency.placeholder') }}
                </option>

                @foreach ($frequencies as $item)
                    <option value="{{ $item }}" @if ($item == old('frequency')) selected @endif>
                        {{ \Illuminate\Support\Str::title(__('frequencies.' . $item)) }}
                    </option>
                @endforeach
            </x-select>
            <x-error :value="$errors->get('frequency')" />
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
