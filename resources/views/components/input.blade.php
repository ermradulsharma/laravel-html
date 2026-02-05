@props(['name', 'value' => null, 'label' => null, 'error' => null])

@php
$attributes = $attributes->merge(['class' => 'form-control']);
@endphp

@if($label)
<label for="{{ $name }}" class="form-label">{{ $label }}</label>
@endif

<input
    type="text"
    name="{{ $name }}"
    id="{{ $name }}"
    value="{{ old($name, $value) }}"
    {{ $attributes }}
    @error($name) aria-invalid="true" @enderror>

@error($name)
<div class="invalid-feedback d-block">{{ $message }}</div>
@enderror