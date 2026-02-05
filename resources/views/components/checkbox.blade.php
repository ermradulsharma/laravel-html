@props(['name', 'value' => '1', 'checked' => false, 'label' => null])

@php
$attributes = $attributes->merge(['class' => 'form-check-input']);
$isChecked = old($name) ? old($name) == $value : $checked;
@endphp

<div class="form-check">
    <input
        type="checkbox"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ $value }}"
        {{ $isChecked ? 'checked' : '' }}
        {{ $attributes }}>

    @if($label)
    <label class="form-check-label" for="{{ $name }}">
        {{ $label }}
    </label>
    @endif
</div>

@error($name)
<div class="invalid-feedback d-block">{{ $message }}</div>
@enderror