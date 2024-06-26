@props([
    'value' => 0.0,
])

<span class="font-medium text-accent">
    Rp{{ number_format($value, 2, '.', ',') }}
</span>
