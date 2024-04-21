<x-app-layout>

    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">{{ __('equipment.headers.fields.title') }}</h2>
            </div>
            <div class="float-right">
                @can('equipment_fields_edit')
                    <x-a body="success" href="{{ route('equipment.fields.create') }}">{{ __('equipment.headers.fields.create') }}</x-a>
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
    <form method="GET" action="{{route('equipment.fields.index')}}"
          class="rounded-xl shadow bg-gray-100 p-4">
        @csrf
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('datatable.filters') }}</h1>
        <div class="grid grid-cols-3 gap-10">
            <div class="">
                <x-input-label
                    for="name"
                    :value="__('equipment.fields.fields.name')"
                />
                <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    :value="$filter->name ?? __('')"
                    class="mt-1 block w-full"
                />
            </div>
            <div class="">
                <x-input-label
                    for="type_id"
                    :value="__('equipment.fields.fields.type')"
                />
                <x-select
                    id="type_id"
                    name="type_id"
                    class="mt-1 block w-full"
                    :data="$types_select"
                    :selected="$filter->type_id ?? 0"
                />
            </div>
        </div>
        <h1 class="font-semibold text-xl text-gray-800 leading-tight my-2">{{ __('datatable.sorting') }}</h1>
        <div class="grid grid-cols-5 gap-10">
            <div>
                <x-input-label
                    for="order_name"
                    :value="__('equipment.fields.fields.name')"
                />
                <x-select
                    id="order_name"
                    name="order_name"
                    class="mt-1"
                    :data="$order->default"
                    :selected="$order->name ?? 0"
                />
            </div>
            <div>
                <x-input-label
                    for="order_type_id"
                    :value="__('equipment.fields.fields.type')"
                />
                <x-select
                    id="order_type_id"
                    name="order_type_id"
                    class="mt-1"
                    :data="$order->default"
                    :selected="$order->type_id ?? 0"
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
            <th class="w-1/6 border-2 border-gray-400 px-4 py-2">{{ __('equipment.fields.fields.name') }}</th>
            <th class="w-1/6 border-2 border-gray-400 px-4 py-2">{{ __('equipment.fields.fields.type') }}</th>
            <th class="w-1/12 border-2 border-gray-400 px-4 py-2">{{__('equipment.fields.fields.status')}}</th>
            <th class="w-1/2 border-2 border-gray-400 px-4 py-2">{{ __('datatable.action') }}</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($fields->items()))
            @php $pageCount = ($fields->currentPage() * $fields->perPage()) - $fields->perPage(); @endphp
            @foreach ($fields as $key => $field)
                <tr>
                    <td class="border-2 border-gray-400 px-4 py-2">{{ ++$key + $pageCount }}</td>
                    <td class="border-2 border-gray-400 px-4 py-2">{{ $field->name }}</td>
                    <td class="border-2 border-gray-400 px-4 py-2">{{ $field->type->name }}</td>
                    <td class="border-2 border-gray-400 px-4 py-2">
                        @if(empty($field->deleted_at))
                            <x-badge body="green">{{ __('equipment.statuses.success') }}</x-badge>
                        @else
                            <x-badge body="red">{{ __('equipment.statuses.delete') }}</x-badge>
                        @endif
                    </td>
                    <td class="border-2 border-gray-400 px-4 py-2">
                        <x-a body="info" href="{{ route('equipment.fields.show', $field->id) }}">{{ __('actions.view') }}</x-a>
                        @can('equipment_fields_edit')
                            @if(empty($field->deleted_at))
                                <x-a  href="{{ route('equipment.fields.edit', $field->id) }}">&#128393;</x-a>
                                <form action="{{ route('equipment.fields.destroy', $field->id) }}" method="POST" class="inline-block">
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
    <x-paginate :paginator="$fields"></x-paginate>
</div>
</x-app-layout>
