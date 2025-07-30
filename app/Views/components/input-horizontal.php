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
    'accept' => '',
])

<div class="form-group row mb-3">
    <label class="control-label col-sm-2 align-self-center mb-0 text-uppercase text-dark"
        style="font-weight: 600; font-size: 14px" or="{{ $name }}">{{ $label }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <div class="col-sm-10">
        <input type="{{ $type }}"
            class="form-control text-dark @error($name)
            is-invalid @enderror {{ $class }}"
            id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }}
            {{ $readonly ? 'readonly' : '' }} {{ $autofocus ? 'autofocus' : '' }}
            {{ $autocomplete ? 'autocomplete' : '' }} accept="{{ $accept }}">
        @error($name)
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
