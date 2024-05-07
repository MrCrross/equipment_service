@props(['disabled' => false, 'options' => '', 'selected' => 0, 'additionalFields' => []])
<?php
    if (!empty($attributes['data'])) {
        $defaultOptions = $attributes['data'];
        unset($attributes['data']);
    }
?>

<select
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
            'class' => 'border-gray-300 focus:border-indigo-500  focus:ring-indigo-500 rounded-md shadow-sm'
    ]) !!}
>
    @if (isset($defaultOptions))
        @foreach($defaultOptions as $item)
            <option
                value="{{$item->value}}"
                @if($selected == $item->value) selected @endif
                @foreach($additionalFields as $field)
                    data-{{$field}}="{{$item->$field}}"
                @endforeach
            >
                {{$item->label}}
            </option>
        @endforeach
    @else
        {{ $options }}
    @endif
</select>
