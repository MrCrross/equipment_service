<x-app-layout>
    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('equipment.headers.brands.create') }}</h2>
            </div>
            <div class="float-right">
                <x-a href="{{ route('equipment.brands.index') }}">{{ __('actions.back') }}</x-a>
            </div>
        </div>
    </x-slot>
    @if (count($errors) > 0)
        <div class="w-full px-10 py-5 bg-red-700">
            <strong>{{ __('validation.whoops') }}</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container mx-auto my-5 bg-gray-50 rounded">
        <div class="py-5 mx-5 flex flex-col justify-center items-center">
            <form action="{{route('equipment.brands.store')}}" method="POST">
                @csrf
                <div class="my-5 mx-5">
                    <div class="flex flex-col">
                        <strong>{{ __('equipment.fields.brands.name') }}</strong>
                        <x-text-input type="text" name="name" :placeholder="__('equipment.fields.brands.name')"></x-text-input>
                    </div>
                    <div class="mt-2">
                        <x-btn type="submit">{{ __('actions.submit') }}</x-btn>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
