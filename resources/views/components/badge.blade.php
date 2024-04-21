@props(['body' => 'green'])
@php
$class = match ($body) {
    'gray' => 'bg-gray-50 text-gray-600 ring-gray-500/10',
    'red' => 'bg-red-50 text-red-700 ring-red-600/10',
    'green' => 'bg-green-50 text-green-700 ring-green-600/20',
    'yellow' => 'bg-yellow-50 text-yellow-800 ring-yellow-600/20',
};
@endphp

<span {{$attributes->merge(['class' => 'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset ' . $class])}}>{{$slot}}</span>
