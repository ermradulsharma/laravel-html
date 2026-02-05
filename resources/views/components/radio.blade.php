@props(['name', 'value', 'checked' => false, 'label' => null])

@php
$attributes = $attributes->merge(['class' => 'form-check-input']);
$isChecked = old($name) ? old($name) == $value : $checked;
@endphp

<div class="form-check">
    <input
        type="radio"
        name="{{ $name }}"
        id="{{ $name }}_{{ $value }}"
        value="{{ $value }}"
        {{ $isChecked ? 'checked' : '' }}
        {{ $attributes }}>

    @if($label)
    <label class="form-check-label" for="{{ $name }}_{{ $value }}">
        {{ $label }}
    </label>
    @endif
</div>

@error($name)
<div class="invalid-feedback d-block">{{ $message }}</div>
@enderror