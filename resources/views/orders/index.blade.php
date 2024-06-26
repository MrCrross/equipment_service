<x-app-layout>

    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">{{ __('orders.headers.title') }}</h2>
            </div>
            <div class="float-right">
                @can('equipment_orders_edit')
                    <x-a body="success" href="{{ route('orders.create') }}">{{ __('orders.headers.create') }}</x-a>
                @endcan
            </div>
        </div>
    </x-slot>


@if ($message = Session::get('success'))
    <div class="w-full px-10 py-5 bg-green-500" >
        <p>{{ $message }}</p>
    </div>
@endif

<div class="container mx-auto px-4 my-5">
    <form method="GET" action="{{ route('orders.index') }}"
          class="rounded-xl shadow bg-gray-100 p-4">
        @csrf
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('datatable.filters') }}</h1>
        <div class="grid grid-cols-3 gap-10">
            <div class="">
                <x-input-label
                    for="status_code"
                    :value="__('orders.fields.status')"
                />
                <x-select
                    id="status_code"
                    name="status_code"
                    class="mt-1"
                    :data="$order_statuses_select"
                    :selected="$filter->status_code ?? 0"
                />
            </div>
            <div class="">
                <x-input-label
                    for="master_id"
                    :value="__('orders.fields.master')"
                />
                <x-select
                    id="master_id"
                    name="master_id"
                    class="mt-1"
                    :data="$users_select"
                    :selected="$filter->master_id ?? 0"
                />
            </div>
            <div class="">
                <x-input-label
                    for="client_id"
                    :value="__('orders.fields.client')"
                />
                <x-select
                    id="client_id"
                    name="client_id"
                    class="mt-1"
                    :data="$users_select"
                    :selected="$filter->client_id ?? 0"
                />
            </div>
            <div class="">
                <x-input-label
                    for="creator_id"
                    :value="__('orders.fields.creator')"
                />
                <x-select
                    id="creator_id"
                    name="creator_id"
                    class="mt-1"
                    :data="$users_select"
                    :selected="$filter->creator_id ?? 0"
                />
            </div>
            <div class="">
                <x-input-label
                    for="editor_id"
                    :value="__('orders.fields.editor')"
                />
                <x-select
                    id="editor_id"
                    name="editor_id"
                    class="mt-1"
                    :data="$users_select"
                    :selected="$filter->editor_id ?? 0"
                />
            </div>
        </div>
        <h1 class="font-semibold text-xl text-gray-800 leading-tight my-2">{{ __('datatable.sorting') }}</h1>
        <div class="grid grid-cols-5 gap-10">
            <div>
                <x-input-label
                    for="order_status_code"
                    :value="__('orders.fields.status')"
                />
                <x-select
                    id="order_status_code"
                    name="order_status_code"
                    class="mt-1"
                    :data="$order->default"
                    :selected="$order->status_code ?? 0"
                />
            </div>
            <div>
                <x-input-label
                    for="order_master_id"
                    :value="__('orders.fields.master')"
                />
                <x-select
                    id="order_master_id"
                    name="order_master_id"
                    class="mt-1"
                    :data="$order->default"
                    :selected="$order->master_id ?? 0"
                />
            </div>
            <div>
                <x-input-label
                    for="order_client_id"
                    :value="__('orders.fields.client')"
                />
                <x-select
                    id="order_client_id"
                    name="order_client_id"
                    class="mt-1"
                    :data="$order->default"
                    :selected="$order->client_id ?? 0"
                />
            </div>
            <div>
                <x-input-label
                    for="order_creator_id"
                    :value="__('orders.fields.creator')"
                />
                <x-select
                    id="order_creator_id"
                    name="order_creator_id"
                    class="mt-1"
                    :data="$order->default"
                    :selected="$order->creator_id ?? 0"
                />
            </div>
            <div>
                <x-input-label
                    for="order_editor_id"
                    :value="__('orders.fields.editor')"
                />
                <x-select
                    id="order_editor_id"
                    name="order_editor_id"
                    class="mt-1"
                    :data="$order->default"
                    :selected="$order->editor_id ?? 0"
                />
            </div>
        </div>
        <div
            class="flex items-center gap-4 mt-4"
        >
            <x-primary-button>
                {{ __('actions.apply') }}
            </x-primary-button>
        </div>
    </form>
    <table class="table-auto w-full my-5">
        <thead>
        <tr>
            <th class="w-1/12 border-2 border-gray-400 px-4 py-2">№</th>
            <th class="w-2/12 border-2 border-gray-400 px-4 py-2">{{ __('equipment.headers.main.single') }}</th>
            <th class="w-1/12 border-2 border-gray-400 px-4 py-2">{{ __('orders.fields.status') }}</th>
            <th class="w-1/12 border-2 border-gray-400 px-4 py-2">{{ __('orders.fields.date_repair') }}</th>
            <th class="w-1/12 border-2 border-gray-400 px-4 py-2">{{ __('orders.fields.master') }}</th>
            <th class="w-1/12 border-2 border-gray-400 px-4 py-2">{{ __('orders.fields.client') }}</th>
            <th class="w-1/12 border-2 border-gray-400 px-4 py-2">{{ __('orders.fields.phone') }}</th>
            <th class="w-1/12 border-2 border-gray-400 px-4 py-2">{{ __('orders.fields.price') }}</th>
            <th class="w-3/12 border-2 border-gray-400 px-4 py-2">{{ __('datatable.action') }}</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($orders->items()))
            @php $pageCount = ($orders->currentPage() * $orders->perPage()) - $orders->perPage(); @endphp
            @foreach ($orders as $key => $order)
                <tr>
                    <td class="border-2 border-gray-400 px-4 py-2">{{ ++$key + $pageCount }}</td>
                    <td class="border-2 border-gray-400 px-4 py-2">{{ $order->equipment->model->type->name . ' ' . $order->equipment->model->brand->name . ' ' . $order->equipment->model->name . ' ' . $order->equipment->serial }}</td>
                    <td class="border-2 border-gray-400 px-4 py-2">
                        @if(!empty($order->status))
                        @if(empty($order->deleted_at))
                            <x-badge body="green">{{ $order->status->name }}</x-badge>
                        @else
                            <x-badge body="red">{{ $order->status->name }}</x-badge>
                        @endif
                        @endif
                    </td>
                    <td class="border-2 border-gray-400 px-4 py-2">
                        @if(!empty($order->date_repair))
                            {{\Carbon\Carbon::parse($order->date_repair)->format('d.m.Y')}}
                        @else
                            {{__('order_mails.changed_date.empty_date')}}
                        @endif
                    </td>
                    <td class="border-2 border-gray-400 px-4 py-2">
                        @if(empty($order->master))
                            <x-no-data font="1"></x-no-data>
                        @else
                            {{ $order->master->name }}
                        @endif
                    </td>
                    <td class="border-2 border-gray-400 px-4 py-2">
                        @if(empty($order->client))
                            {{ $order->client_name }}
                        @else
                            {{ $order->client->name }}
                        @endif
                    </td>
                    <td class="border-2 border-gray-400 px-4 py-2">
                        @if(empty($order->client))
                            {{ $order->phone }}
                        @else
                            {{ $order->client->phone }}
                        @endif
                    </td>
                    <td class="border-2 border-gray-400 px-4 py-2">{{ $order->price }}</td>
                    <td class="border-2 border-gray-400 px-4 py-2">
                        <x-a body="info" href="{{ route('orders.show', $order->id) }}">{{ __('actions.view') }}</x-a>
                        @can('equipment_orders_print')
                            <x-a body="info" href="{{ route('orders.print', $order->id) }}">{{ __('actions.print') }}</x-a>
                        @endcan
                        @can('equipment_orders_edit')
                            @if(empty($order->deleted_at))
                                <x-a href="{{ route('orders.edit',$order->id) }}">&#128393;</x-a>
                                @can('equipment_orders_view-delete')
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style = "display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <x-btn body="danger" type="submit">&times;</x-btn>
                                </form>
                                @endcan
                            @endif
                        @endcan
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="12"><x-no-data></x-no-data></td>
            </tr>
        @endif
        </tbody>
    </table>
    <x-paginate :paginator="$orders"></x-paginate>
</div>
</x-app-layout>
