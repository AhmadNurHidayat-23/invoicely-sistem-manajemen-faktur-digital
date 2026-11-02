@props(['name', 'label', 'value' => '', 'type' => 'text', 'textarea' => false, 'required' => false, 'hint' => null])
@php
    $value = old($name, $value);
    $value = is_scalar($value) ? (string) $value : '';
@endphp
<div class="field">
    <label for="{{ $name }}">{{ $label }}@if($required)<span class="required-mark" aria-hidden="true">*</span>@endif</label>
    @if($textarea)
        <textarea id="{{ $name }}" name="{{ $name }}" @required($required) {{ $attributes->merge(['rows' => 3]) }} @if($errors->has($name)) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif>{{ $value }}</textarea>
    @else
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ $value }}" @required($required) {{ $attributes }} @if($errors->has($name)) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif>
    @endif
    @if($hint)<small class="field-hint">{{ $hint }}</small>@endif
    @error($name)<small class="field-error" id="{{ $name }}-error">{{ $message }}</small>@enderror
</div>
