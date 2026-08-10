@props([
    'name',
    'label' => null,
    'type' => 'text',
    'placeholder' => null,
    'value' => null,
    'required' => false,
    'errorBag' => null,
    'rows' => 4,
    'options' => [],
    'help' => null,
])

@php
    $errorClass = $errorBag
        ? ($errors->getBag($errorBag)->has($name) ? 'is-invalid' : '')
        : ($errors->has($name) ? 'is-invalid' : '');

    $fieldValue = old($name, $value);
@endphp

<div {{ $attributes->merge(['class' => 'mb-3']) }}>

    @if($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}

            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif


    @if($type === 'textarea')

        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            rows="{{ $rows }}"
            placeholder="{{ $placeholder }}"
            class="form-control {{ $errorClass }}"
            @required($required)
        >{{ $fieldValue }}</textarea>


    @elseif($type === 'select')

        <select
            id="{{ $name }}"
            name="{{ $name }}"
            class="form-select {{ $errorClass }}"
            @required($required)
        >

            @foreach($options as $optionValue => $optionLabel)

                <option
                    value="{{ $optionValue }}"
                    @selected($fieldValue == $optionValue)
                >
                    {{ $optionLabel }}
                </option>

            @endforeach

        </select>


    @else

        <input
            id="{{ $name }}"
            type="{{ $type }}"
            name="{{ $name }}"
            value="{{ $fieldValue }}"
            placeholder="{{ $placeholder }}"
            class="form-control {{ $errorClass }}"
            @required($required)
        >

    @endif


    @if($help)
        <div class="form-text">
            {{ $help }}
        </div>
    @endif


    @if($errorBag)

        @foreach($errors->getBag($errorBag)->get($name) as $error)

            <div class="invalid-feedback">
                {{ $error }}
            </div>

        @endforeach

    @else

        @error($name)

            <div class="invalid-feedback">
                {{ $message }}
            </div>

        @enderror

    @endif

</div>
