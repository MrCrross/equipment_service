<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="space-x-8 ">
                    <x-nav-link class="font-semibold text-xl text-gray-800 leading-tight" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('orders.headers.title') }}
                    </x-nav-link>
                    <x-nav-link class="font-semibold text-xl text-gray-800 leading-tight" :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                        {{ __('auth.profile') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="container mx-auto px-4 my-5">
            <div class="flex justify-between">
                <x-btn
                    body="success"
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'order-create-modal')"
                >{{ __('actions.add') }}</x-btn>

                <x-modal name="order-create-modal" focusable>
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
                            <div class="mt-2">
                                <x-btn type="submit">{{ __('actions.submit') }}</x-btn>
                            </div>
                        </div>
                    </form>
                </x-modal>
            </div>
            <form method="GET" action="{{ route('orders.index') }}"
                  class="rounded-xl shadow bg-gray-100 p-4 mt-2">
                @csrf
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('datatable.filters') }}</h1>
                <div class="grid grid-cols-3 gap-10">
                    <div class="">
                        <x-input-label
                            for="status_id"
                            :value="__('orders.fields.status')"
                        />
                        <x-select
                            id="status_id"
                            name="status_id"
                            class="mt-1"
                            :data="$order_statuses_select"
                            :selected="$filter->status_id ?? 0"
                        />
                    </div>
                    @can('equipment_orders_view')
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
                    @endcan
                </div>
                <h1 class="font-semibold text-xl text-gray-800 leading-tight my-2">{{ __('datatable.sorting') }}</h1>
                <div class="grid grid-cols-5 gap-10">
                    <div>
                        <x-input-label
                            for="order_status_id"
                            :value="__('orders.fields.status')"
                        />
                        <x-select
                            id="order_status_id"
                            name="order_status_id"
                            class="mt-1"
                            :data="$order->default"
                            :selected="$order->status_id ?? 0"
                        />
                    </div>
                    @can('equipment_orders_view')
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
                    @endcan
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
                    <th class="w-1/8 border-2 border-gray-400 px-4 py-2">№</th>
                    <th class="w-1/8 border-2 border-gray-400 px-4 py-2">{{ __('equipment.headers.main.single') }}</th>
                    <th class="w-1/8 border-2 border-gray-400 px-4 py-2">{{ __('orders.fields.status') }}</th>
                    <th class="w-1/8 border-2 border-gray-400 px-4 py-2">{{ __('orders.fields.master') }}</th>
                    <th class="w-1/8 border-2 border-gray-400 px-4 py-2">{{ __('orders.fields.client') }}</th>
                    <th class="w-1/8 border-2 border-gray-400 px-4 py-2">{{ __('orders.fields.phone') }}</th>
                    <th class="w-1/8 border-2 border-gray-400 px-4 py-2">{{ __('orders.fields.creator') }}</th>
                    <th class="w-1/8 border-2 border-gray-400 px-4 py-2">{{ __('orders.fields.editor') }}</th>
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
                                @if(empty($order->deleted_at))
                                    <x-badge body="green">{{ $order->status->name }}</x-badge>
                                @else
                                    <x-badge body="red">{{ $order->status->name }}</x-badge>
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
                            <td class="border-2 border-gray-400 px-4 py-2">{{ $order->creator->name }}</td>
                            <td class="border-2 border-gray-400 px-4 py-2">
                                @if(empty($order->editor))
                                    <x-no-data font="1"></x-no-data>
                                @else
                                    {{ $order->editor->name }}
                                @endif
                            </td>
                            <td class="border-2 border-gray-400 px-4 py-2">
                                <x-a body="info" href="{{ route('orders.show',$order->id) }}">{{ __('actions.view') }}</x-a>
                                @canany(['equipment_orders_edit', 'equipment_orders_my_edit'])
                                    @if(empty($order->deleted_at))
                                        <x-a href="{{ route('orders.edit',$order->id) }}">&#128393;</x-a>
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style = "display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <x-btn body="danger" type="submit">&times;</x-btn>
                                        </form>
                                    @endif
                                @endcanany
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="9"><x-no-data></x-no-data></td>
                    </tr>
                @endif
                </tbody>
            </table>
            <x-paginate :paginator="$orders"></x-paginate>
        </div>
    </div>
</x-app-layout>
