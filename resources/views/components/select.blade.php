@props(['name', 'options' => [], 'selected' => null, 'label' => null, 'placeholder' => null])

@php
$attributes = $attributes->merge(['class' => 'form-select']);
@endphp

@if($label)
<label for="{{ $name }}" class="form-label">{{ $label }}</label>
@endif

<select
    name="{{ $name }}"
    id="{{ $name }}"
    {{ $attributes }}
    @error($name) aria-invalid="true" @enderror>
    @if($placeholder)
    <option value="">{{ $placeholder }}</option>
    @endif

    @foreach($options as $value => $text)
    <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>
        {{ $text }}
    </option>
    @endforeach
</select>

@error($name)
<div class="invalid-feedback d-block">{{ $message }}</div>
@enderror