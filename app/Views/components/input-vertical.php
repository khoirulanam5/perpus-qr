@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'autofocus' => false,
    'autocomplete' => 'off',
    'class' => '',
    'id' => '',
])

<div class="form-group">
    <label for="{{ $name }}" class="form-label text-uppercase"
        style="font-weight: 600; font-size: 14px">{{ $label }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <input type="{{ $type }}" id="{{ $id ?: $name }}" name="{{ $name }}"
        class="form-control text-dark @error($name) is-invalid @enderror {{ $class }}"
        value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }} {{ $autofocus ? 'autofocus' : '' }}
        {{ $autocomplete ? 'autocomplete' : '' }}>
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
