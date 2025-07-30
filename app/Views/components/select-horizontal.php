@props([
    'label' => '',
    'name' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'autofocus' => false,
    'autocomplete' => 'off',
    'class' => '',
])

<div class="form-group row mb-3">
    <label for="{{ $name }}" class="col-sm-2 col-form-label text-dark" style="font-weight: 600; font-size: 14px">
        {{ $label }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    <div class="col-sm-10">
        <select id="{{ $name }}" name="{{ $name }}"
            class="form-control text-dark @error($name) is-invalid @enderror {{ $class }}"
            {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }} {{ $readonly ? 'readonly' : '' }}
            {{ $autofocus ? 'autofocus' : '' }} {{ $autocomplete ? 'autocomplete=' . $autocomplete : '' }}>
            {{ $slot }}
        </select>

        @error($name)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
