@props([
    'name',
    'type' => 'text',
    'value' => '',
    'id' => '',
    'size' => 6,
    'placeholder' => 'Enter '.ucfirst($name).' here',
    'label' => 'Input Field',
    'class' => 'form-control',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
])

<div class="form-group col-md-{{$size}}">
    <label>{{ $label }}</label>
    <input
        type="{{ $type }}"
        id="{{ $id }}"
        name="{{ $name }}"
        class="{{ $class }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $readonly ? 'readonly' : '' }}
    />
    @error($name)<p style="color: #dc3545;font-style: italic" classs="text-danger">{{ $message  }}</p>@enderror
</div>
