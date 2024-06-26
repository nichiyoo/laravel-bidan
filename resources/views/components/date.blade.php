@props([
    'value' => null,
])

@php
    $date = \Carbon\Carbon::parse($value);
@endphp

<time datetime="{{ $date->toDateTimeString() }}">
    {{ $date->translatedFormat('d F Y') }}
</time>
