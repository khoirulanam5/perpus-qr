@props([
    'label' => '',
    'name' => '',
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'autofocus' => false,
    'autocomplete' => 'off',
    'class' => '',
])

<div class="form-group">
    <label for="{{ $name }}" class="form-label" style="font-weight: 600">{{ $label }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <select type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
        class="form-control text-dark @error($name) is-invalid @enderror {{ $class }}"
        placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }}
        {{ $readonly ? 'readonly' : '' }} {{ $autofocus ? 'autofocus' : '' }}
        {{ $autocomplete ? 'autocomplete' : '' }}>
        {{ $slot }}
    </select>
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
