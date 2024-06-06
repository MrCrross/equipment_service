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
        <div class="py-5 mx-5">
            <form action="{{route('orders.store')}}" method="POST">
                @csrf
                <div class="my-5 mx-5">
                    <div class="flex flex-col">
                        <x-input-label
                            for="equipment_id"
                            :value="__('equipment.headers.main.single')"
                        />
                        <x-select
                            id="equipment_id"
                            name="equipment_id"
                            class="mt-1"
                            :data="$equipment_select"
                            :placeholder="__('equipment.headers.main.single')"
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
                            :value="__('orders.fields.client')"
                        />
                        <x-text-input type="text" name="client_name"
                                      :placeholder="__('orders.fields.client')"></x-text-input>
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
