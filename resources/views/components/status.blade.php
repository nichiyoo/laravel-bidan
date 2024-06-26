@props(['status', 'timeout' => 5000])

@if ($status)
    <span {{ $attributes->merge() }} x-data="{
        timeout: null,
        init() {
            this.timeout = setTimeout(() => {
                this.$el.classList.add('hidden');
            }, {{ $timeout }});
        }
    }">
        {{ $status }}
    </span>
@endif
