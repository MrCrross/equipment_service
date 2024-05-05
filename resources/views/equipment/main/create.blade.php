<x-app-layout>
    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('equipment.headers.main.create') }}</h2>
            </div>
            <div class="float-right">
                <x-a href="{{ route('equipment.main.index') }}">{{ __('actions.back') }}</x-a>
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

    <x-template.equipment-field clone="1" :key="0" :fields="$fields_select"></x-template.equipment-field>
    <div class="container mx-auto my-5 bg-gray-50 rounded">
        <div class="py-5 mx-5 flex flex-col justify-center items-center">
            <form action="{{route('equipment.main.store')}}" method="POST">
                @csrf
                <div class="my-5 mx-5">
                    <div class="flex flex-col">
                        <x-input-label
                            for="model_id"
                            :value="__('equipment.headers.models.single')"
                        />
                        <x-select
                            id="model_id"
                            name="model_id"
                            class="mt-1 block w-full"
                            :data="$models_select"
                            required
                        />
                    </div>
                    <div class="flex flex-col">
                        <x-input-label
                            for="short_name"
                            :value="__('equipment.fields.main.short_name')"
                        />
                        <x-text-input type="text" name="short_name" :placeholder="__('equipment.fields.main.short_name')"></x-text-input>
                    </div>
                    <div class="flex flex-col">
                        <x-input-label
                            for="serial"
                            :value="__('equipment.fields.main.serial')"
                        />
                        <x-text-input type="text" name="serial" :placeholder="__('equipment.fields.main.serial')"></x-text-input>
                    </div>
                    <div class="mt-4">
                        <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('equipment.headers.fields.title') }}</h1>
                        <div class="py-4 flex flex-col justify-items-stretch container-line-EquipmentField">
                            <x-template.equipment-field :key="0" :fields="$fields_select"></x-template.equipment-field>
                        </div>
                    </div>
                    <div class="mt-2">
                        <x-btn type="submit">{{ __('actions.submit') }}</x-btn>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
<script src="{{asset('js/templates/EquipmentFieldTemplate.js')}}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new EquipmentFieldTemplate();
    })
</script>
