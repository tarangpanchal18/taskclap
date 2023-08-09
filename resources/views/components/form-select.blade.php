@props([
    'name',
    'id' => '',
    'event' => '',
    'type' => 'text',
    'data' => '',
    'useDataAsKeyVal' => false,
    'value' => '',
    'size' => 6,
    'label' => 'Input Field',
    'class' => 'form-control',
    'required' => false,
    'disabled' => false,
    'multiple' => false,
])

<div class="form-group col-md-{{ $size }}">
    <label>{{ $label }}</label>
    <select id="{{ $id }}" {!! $event !!}  name="{{ $name }}" class="{{ $class }} select2" {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }} {{ $multiple ? 'multiple' : '' }}>
        <option value="">-- Select --</option>
        @if ($useDataAsKeyVal)
            @foreach (json_decode( html_entity_decode($data), TRUE) as $name => $id)
            <option {{ $value == $id ? 'selected' : '' }} value="{{ $id }}">{{ $name }}</option>
            @endforeach
        @else
            @foreach (json_decode( html_entity_decode($data), TRUE) as $name)
            <option {{ $value == $name ? 'selected' : '' }} value="{{ $name }}">{{ $name }}</option>
            @endforeach
        @endif
    </select>
    @error($name)<p class="text-danger">{{ $message }}</p>@enderror
</div>
