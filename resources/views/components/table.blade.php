@props([
    'variant' => 'primary',
])

@php
    $cvariant = match ($variant) {
        'primary' => 'bg-primary text-white',
        'accent' => 'bg-accent text-white',
    };
@endphp

<div class="w-full overflow-x-auto rounded-lg frame">
    <table class="w-full text-sm table-auto [&_:is(th, td)]:px-8 [&_:is(th, td)]:py-2">
        <thead class="{{ $cvariant }}">
            <tr>
                {{ $head }}
            </tr>
        </thead>

        <tbody>
            {{ $body }}
        </tbody>
    </table>
</div>
