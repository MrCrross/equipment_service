<x-app-layout>

    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">{{ __('equipment.headers.main.title') }}</h2>
            </div>
            <div class="float-right">
                @can('equipment_edit')
                    <x-a body="success" href="{{ route('equipment.main.create') }}">{{ __('equipment.headers.main.create') }}</x-a>
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
    <form method="GET" action="{{route('equipment.main.index')}}"
          class="rounded-xl shadow bg-gray-100 p-4">
        @csrf
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('datatable.filters') }}</h1>
        <div class="grid grid-cols-3 gap-10">
            <div class="">
                <x-input-label
                    for="serial"
                    :value="__('equipment.fields.main.serial')"
                />
                <x-text-input
                    id="serial"
                    name="serial"
                    type="text"
                    :value="$filter->serial ?? __('')"
                    class="mt-1 block w-full"
                />
            </div>
            <div class="">
                <x-input-label
                    for="short_name"
                    :value="__('equipment.fields.main.short_name')"
                />
                <x-text-input
                    id="short_name"
                    name="short_name"
                    type="text"
                    :value="$filter->short_name ?? __('')"
                    class="mt-1 block w-full"
                />
            </div>
            <div class="">
                <x-input-label
                    for="model_id"
                    :value="__('equipment.headers.models.single')"
                />
                <x-select
                    id="model_id"
                    name="model_id"
                    class="mt-1 block w-full"
                    :data="$models_select"
                    :selected="$filter->model_id ?? 0"
                />
            </div>
            <div class="">
                <x-input-label
                    for="creator_id"
                    :value="__('users.headers.title')"
                />
                <x-select
                    id="creator_id"
                    name="creator_id"
                    class="mt-1 block w-full"
                    :data="$users_select"
                    :selected="$filter->creator_id ?? 0"
                />
            </div>
        </div>
        <h1 class="font-semibold text-xl text-gray-800 leading-tight my-2">{{ __('datatable.sorting') }}</h1>
        <div class="grid grid-cols-5 gap-10">
            <div>
                <x-input-label
                    for="order_serial"
                    :value="__('equipment.fields.main.serial')"
                />
                <x-select
                    id="order_serial"
                    name="order_serial"
                    class="mt-1"
                    :data="$order->default"
                    :selected="$order->serial ?? 0"
                />
            </div>
            <div>
                <x-input-label
                    for="order_short_name"
                    :value="__('equipment.fields.main.short_name')"
                />
                <x-select
                    id="order_short_name"
                    name="order_short_name"
                    class="mt-1"
                    :data="$order->default"
                    :selected="$order->short_name ?? 0"
                />
            </div>
            <div>
                <x-input-label
                    for="order_model_id"
                    :value="__('equipment.headers.models.single')"
                />
                <x-select
                    id="order_model_id"
                    name="order_model_id"
                    class="mt-1"
                    :data="$order->default"
                    :selected="$order->model_id ?? 0"
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
            <th class="w-1/6 border-2 border-gray-400 px-4 py-2">{{ __('equipment.headers.models.single') }}</th>
            <th class="w-1/6 border-2 border-gray-400 px-4 py-2">{{ __('equipment.fields.main.short_name') }}</th>
            <th class="w-1/6 border-2 border-gray-400 px-4 py-2">{{ __('equipment.fields.main.serial') }}</th>
            <th class="w-1/8 border-2 border-gray-400 px-4 py-2">{{ __('equipment.fields.main.creator') }}</th>
            <th class="w-1/8 border-2 border-gray-400 px-4 py-2">{{ __('equipment.fields.main.editor') }}</th>
            <th class="w-1/12 border-2 border-gray-400 px-4 py-2">{{__('equipment.fields.main.status')}}</th>
            <th class="w-1/2 border-2 border-gray-400 px-4 py-2">{{ __('datatable.action') }}</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($equipment->items()))
            @php $pageCount = ($equipment->currentPage() * $equipment->perPage()) - $equipment->perPage(); @endphp
            @foreach ($equipment as $key => $eq)
                <tr>
                    <td class="border-2 border-gray-400 px-4 py-2">{{ ++$key + $pageCount }}</td>
                    <td class="border-2 border-gray-400 px-4 py-2">{{ $eq->model->type->name . ' ' . $eq->model->brand->name . ' ' . $eq->model->name }}</td>
                    <td class="border-2 border-gray-400 px-4 py-2">{{ $eq->short_name }}</td>
                    <td class="border-2 border-gray-400 px-4 py-2">{{ $eq->serial }}</td>
                    <td class="border-2 border-gray-400 px-4 py-2">{{ $eq->creator->name }}</td>
                    <td class="border-2 border-gray-400 px-4 py-2">
                        @if(empty($eq->editor))
                            <x-no-data font="1"></x-no-data>
                        @else
                            {{ $eq->editor->name }}
                        @endif
                    </td>
                    <td class="border-2 border-gray-400 px-4 py-2">
                        @if(empty($eq->deleted_at))
                            <x-badge body="green">{{ __('equipment.statuses.success') }}</x-badge>
                        @else
                            <x-badge body="red">{{ __('equipment.statuses.delete') }}</x-badge>
                        @endif
                    </td>
                    <td class="border-2 border-gray-400 px-4 py-2">
                        <x-a body="info" href="{{ route('equipment.main.show', $eq->id) }}">{{ __('actions.view') }}</x-a>
                        @can('equipment_edit')
                            @if(empty($eq->deleted_at))
                                <x-a  href="{{ route('equipment.main.edit', $eq->id) }}">&#128393;</x-a>
                                <form action="{{ route('equipment.main.destroy', $eq->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <x-btn body="danger" type="submit">&times;</x-btn>
                                </form>
                            @endif
                        @endcan
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5"><x-no-data></x-no-data></td>
            </tr>
        @endif
        </tbody>
    </table>
    <x-paginate :paginator="$equipment"></x-paginate>
</div>
</x-app-layout>
