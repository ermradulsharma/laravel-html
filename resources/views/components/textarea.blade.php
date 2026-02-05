@props(['name', 'value' => null, 'label' => null, 'rows' => 5])

@php
$attributes = $attributes->merge(['class' => 'form-control']);
@endphp

@if($label)
<label for="{{ $name }}" class="form-label">{{ $label }}</label>
@endif

<textarea
    name="{{ $name }}"
    id="{{ $name }}"
    rows="{{ $rows }}"
    {{ $attributes }}
    @error($name) aria-invalid="true" @enderror>{{ old($name, $value) }}</textarea>

@error($name)
<div class="invalid-feedback d-block">{{ $message }}</div>
@enderror