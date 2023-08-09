@props([
    'name',
    'id' => '',
    'value' => '',
    'size' => 6,
    'placeholder' => 'Enter '.ucfirst($name).' here',
    'label' => 'Input Field',
    'class' => 'form-control',
    'required' => false,
    'disabled' => false,
])

<div class="form-group col-md-{{$size}}">
    <label>{{ $label }}</label>
    <textarea
        name="{{ $name }}"
        id="{{ $id }}"
        class="{{ $class }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
    >{{ old($name, $value) }}</textarea>
    @error($name)<p class="text-danger">{{ $message }}</p>@enderror
</div>
