<x-app-layout>
    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('orders.headers.create') }}</h2>
            </div>
            <div class="float-right">
                <x-a href="{{ route('orders.index') }}">{{ __('actions.back') }}</x-a>
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
        <div class="py-5 mx-5 w-1/2 mx-auto">
            <x-template.equipment-field clone="1" :key="0" :fields="$fields_select"></x-template.equipment-field>
            <form action="{{route('orders.store')}}" method="POST">
                @csrf
                <div class="my-5 mx-5 flex flex-col gap-3">
                    <div class="flex flex-col">
                        <x-input-label
                            for="client_id"
                            :value="__('orders.fields.client')"
                        />
                        <x-select
                            id="client_id"
                            name="client_id"
                            class="mt-1 block w-full"
                            :data="$clients"
                            :additionalFields="['phone', 'name']"
                            required
                        />
                    </div>
                    <div class="flex flex-col">
                        <x-input-label
                            for="phone"
                            :value="__('orders.fields.phone')"
                        />
                        <x-text-input type="text" id="phone" name="phone"
                                      :placeholder="__('orders.fields.phone')"></x-text-input>
                    </div>
                    <div class="flex flex-col">
                        <x-input-label
                            for="client_name"
                            :value="__('orders.fields.client_name')"
                        />
                        <x-text-input type="text" id="client_name" name="client_name"
                                      :placeholder="__('orders.fields.client_name')"></x-text-input>
                    </div>
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
                    <div class="mt-2">
                        <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('equipment.headers.fields.title') }}</h1>
                        <div class="py-2 flex flex-col justify-items-stretch container-line-EquipmentField">
                            <x-template.equipment-field :key="0" :fields="$fields_select"></x-template.equipment-field>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <x-input-label
                            for="description"
                            :value="__('orders.fields.description')"
                        />
                        <x-textarea
                            id="description"
                            name="description"
                            class="mt-1"
                            :placeholder="__('orders.fields.description')"
                        ></x-textarea>
                    </div>
                    <div class="flex flex-col">
                        <x-input-label
                            for="price"
                            :value="__('orders.fields.price')"
                        />
                        <x-text-input
                            id="price"
                            name="price"
                            type="number"
                            class="mt-1 block w-full"
                            min="0.00"
                            step="0.01"
                            :value="0.00"
                            :placeholder="__('orders.fields.price')"
                            required
                        />
                    </div>
                    <div class="mt-2">
                        <x-btn type="submit">{{ __('actions.submit') }}</x-btn>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
<script src="{{asset('js/imask.js')}}"></script>
<script>
    IMask(
        document.getElementById('phone'),
        {
            mask: '+{7}(000)000-00-00'
        }
    )
</script>
<script src="{{asset('js/templates/EquipmentFieldTemplate.js')}}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new EquipmentFieldTemplate("{{__('actions.search')}}");
        const clientID = document.getElementById('client_id');
        clientID.addEventListener('change', (e) => {
            const id = e.target.value;
            const clientName = document.getElementById('client_name')
            const clientPhone = document.getElementById('phone')
            if (+id !== 0) {
                clientName.value = e.target.selectedOptions[0].getAttribute('data-name')
                clientPhone.value = e.target.selectedOptions[0].getAttribute('data-phone')
                clientName.setAttribute('disabled', true)
                clientPhone.setAttribute('disabled', true)
            } else {
                clientName.value = ''
                clientPhone.value = ''
                clientName.removeAttribute('disabled')
                clientPhone.removeAttribute('disabled')
            }
        })
    })
</script>
