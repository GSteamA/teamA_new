@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-blue-50']) }}>
    {{ $value ?? $slot }}
</label>
