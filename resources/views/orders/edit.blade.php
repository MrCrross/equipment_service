<x-app-layout>
    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('orders.headers.update') }}</h2>
            </div>
            <div class="float-right">
                <x-a href="{{ back()->getTargetUrl() }}">{{ __('actions.back') }}</x-a>
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
            <form action="{{route('orders.update', $order->id)}}" method="POST">
                @csrf
                @method('PATCH')
                <div class="my-5 mx-5">
                    <div class="flex flex-col">
                        <x-input-label
                            for="equipment_id"
                            :value="__('equipment.headers.main.single')"
                        />
                        @can('equipment_orders_print')
                        <x-select
                            id="equipment_id"
                            name="equipment_id"
                            class="mt-1"
                            :data="$equipment_select"
                            :selected="$order->equipment_id"
                            :placeholder="__('equipment.headers.main.single')"
                        />
                        @else
                            <input type="hidden" name="equipment_id" value="{{$order->equipment_id}}">
                            <x-select
                                id="equipment_id"
                                name="equipment_id"
                                class="mt-1"
                                :data="$equipment_select"
                                :selected="$order->equipment_id"
                                :placeholder="__('equipment.headers.main.single')"
                                disabled
                            />
                        @endcan
                    </div>
                    @can('equipment_orders_edit')
                    <div class="flex flex-col">
                        <x-input-label
                            for="master_id"
                            :value="__('orders.fields.master')"
                        />
                        <x-select
                            id="master_id"
                            name="master_id"
                            class="mt-1"
                            :data="$users_select"
                            :selected="$order->master_id"
                            :placeholder="__('orders.fields.master')"
                        />
                    </div>
                    @endcan
                    <div class="flex flex-col">
                        <x-input-label
                            for="status_code"
                            :value="__('orders.fields.status')"
                        />
                        @can('equipment_orders_print')
                        <x-select
                            id="status_code"
                            name="status_code"
                            class="mt-1"
                            :data="$order_statuses_select"
                            :selected="$order->status_code"
                            :placeholder="__('orders.fields.status')"
                        />
                        @else
                            <input type="hidden" name="status_code" value="{{$order->status_code}}">
                            <x-select
                                id="status_code"
                                name="status_code"
                                class="mt-1"
                                :data="$order_statuses_select"
                                :selected="$order->status_code"
                                :placeholder="__('orders.fields.status')"
                                disabled
                            />
                        @endcan
                    </div>
                    <div class="flex flex-col">
                        <x-input-label
                            for="date_repair"
                            :value="__('orders.fields.date_repair')"
                        />
                        @can('equipment_orders_print')
                            <x-text-input
                                id="date_repair"
                                name="date_repair"
                                type="date"
                                value="{{$order->date_repair}}"
                                class="mt-1 block w-full"
                                min="{{\Illuminate\Support\Carbon::now()->addDay()->format('Y-m-d')}}"
                            />
                        @else
                            <input type="hidden" name="date_repair" value="{{$order->date_repair}}">
                            <x-text-input
                                id="date_repair"
                                name="date_repair"
                                type="date"
                                value="{{$order->date_repair}}"
                                class="mt-1 block w-full"
                                min="{{\Illuminate\Support\Carbon::now()->addDay()->format('Y-m-d')}}"
                                disabled
                            />
                        @endcan
                    </div>
                    <div class="flex flex-col">
                        <x-input-label
                            for="phone"
                            :value="__('orders.fields.phone')"
                        />
                        @if(empty($order->phone))
                            {{$order->client->phone}}
                        @else
                            <x-text-input type="text" id="phone" name="phone" value="{{$order->phone}}" :placeholder="__('orders.fields.phone')"></x-text-input>
                        @endif
                    </div>
                    <div class="flex flex-col">
                        <x-input-label
                            for="client_name"
                            :value="__('orders.fields.client')"
                        />
                        @if(empty($order->client_name))
                            {{$order->client->name}}
                        @else
                            <x-text-input type="text" name="client_name" value="{{$order->client_name}}" :placeholder="__('orders.fields.client')"></x-text-input>
                        @endif
                    </div>
                    @if(!empty($order->client))
                        <input type="hidden" name="client_id" value="{{$order->client_id}}">
                    @endif
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
                        >{{$order->description}}</x-textarea>
                    </div>
                    <div class="flex flex-col">
                        <x-input-label
                            for="price"
                            :value="__('orders.fields.price')"
                        />
                        @can('equipment_orders_print')
                            <x-text-input
                                id="price"
                                name="price"
                                type="number"
                                class="mt-1 block w-full"
                                min="0.00"
                                step="0.01"
                                :value="$order->price"
                                :placeholder="__('orders.fields.price')"
                                required
                            />
                        @else
                            <input type="hidden" name="price" value="{{$order->price}}">
                            <x-text-input
                                id="price"
                                name="price"
                                type="number"
                                class="mt-1 block w-full"
                                min="0.00"
                                step="0.01"
                                :value="$order->price"
                                :placeholder="__('orders.fields.price')"
                                disabled
                            />
                        @endcan
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
    if ( document.getElementById('phone')) {
        IMask(
            document.getElementById('phone'),
            {
                mask: '+{7}(000)000-00-00'
            }
        )
    }
</script>
