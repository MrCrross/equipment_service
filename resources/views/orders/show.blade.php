<x-app-layout>
    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">{{ __('orders.headers.view') }}</h2>
            </div>
            <div class="float-right">
                @can('equipment_orders_view')
                    <x-a href="{{ route('orders.index') }}">{{ __('actions.back') }}</x-a>
                @else
                    <x-a href="{{ route('dashboard') }}">{{ __('actions.back') }}</x-a>
                @endcan
            </div>
        </div>
    </x-slot>
    <div class="container mx-auto flex flex-col justify-center items-center my-5 bg-gray-50 rounded">
        <div class="py-5 mx-5">
            <div class="flex flex-col">
                <strong>{{ __('equipment.headers.main.single') }}</strong>
                {{ $order->equipment->model->type->name . ' ' . $order->equipment->model->brand->name . ' ' . $order->equipment->model->name . ' ' . $order->equipment->serial }}
            </div>
            <div class="flex flex-col">
                <strong>{{ __('orders.fields.status') }}</strong>
                @if(!empty($order->status))
                @if(empty($order->deleted_at))
                    <x-badge body="green">{{ $order->status->name }}</x-badge>
                @else
                    <x-badge body="red">{{ $order->status->name }}</x-badge>
                @endif
                @endif
            </div>
            <div class="flex flex-col">
                <strong>{{ __('orders.fields.price') }}</strong>
                {{$order->price}}
            </div>
            <div class="flex flex-col">
                <strong>{{ __('orders.fields.master') }}</strong>
                @if(empty($order->master))
                    <x-no-data font="1"></x-no-data>
                @else
                    {{ $order->master->name }}
                @endif
            </div>
            <div class="flex flex-col">
                <strong>{{ __('orders.fields.client') }}</strong>
                @if(empty($order->client))
                    {{ $order->client_name }}
                @else
                    {{ $order->client->name }}
                @endif
            </div>
            <div class="flex flex-col">
                <strong>{{ __('orders.fields.phone') }}</strong>
                @if(empty($order->client))
                    {{ $order->phone }}
                @else
                    {{ $order->client->phone }}
                @endif
            </div>
            <div class="flex flex-col">
                <strong>{{ __('orders.fields.creator') }}</strong>
                {{ $order->creator->name }}
            </div>
            <div class="flex flex-col">
                <strong>{{ __('orders.fields.editor') }}</strong>
                @if(empty($order->editor))
                    <x-no-data font="1"></x-no-data>
                @else
                    {{ $order->editor->name }}
                @endif
            </div>
            @if(!empty($order->deleted_at))
                @canany(['equipment_orders_view-delete', 'equipment_orders_edit'])
                    <div class="my-3">
                        <form method="POST" action="{{route('orders.recovery', $order->id)}}">
                            @csrf
                            @method('PATCH')
                            <x-primary-button>{{ __('actions.recovery') }}</x-primary-button>
                        </form>
                    </div>
                @endcanany
            @endif
        </div>
        <x-history-table :history="$history"></x-history-table>
    </div>
</x-app-layout>
