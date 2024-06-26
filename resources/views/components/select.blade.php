<select {!! $attributes->merge([
    'class' => 'form-select w-full px-4 py-2 bg-zinc-50 frame focus:border-accent focus:ring-accent rounded-md text-sm',
]) !!}>
    {{ $slot }}
</select>
