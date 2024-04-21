<x-app-layout>

    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">{{ __('roles.headers.title') }}</h2>
            </div>
            <div class="float-right">
                @can('roles_edit')
                    <x-a body="success" href="{{ route('roles.create') }}">{{ __('roles.headers.create') }}</x-a>
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
    <form method="GET" action="{{route('roles.index')}}"
          class="rounded-xl shadow bg-gray-100 p-4">
        @csrf
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('datatable.filters') }}</h1>
        <div class="grid grid-cols-3 gap-10">
            <div class="">
                <x-input-label
                    for="name"
                    :value="__('roles.fields.name')"
                />
                <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    :value="$filter->name ?? __('')"
                    class="mt-1 block w-full"
                />
            </div>
        </div>
        <h1 class="font-semibold text-xl text-gray-800 leading-tight my-2">{{ __('datatable.sorting') }}</h1>
        <div class="grid grid-cols-5 gap-10">
            <div>
                <x-input-label
                    for="order_name"
                    :value="__('roles.fields.name')"
                />
                <x-select
                    id="order_name"
                    name="order_name"
                    class="mt-1"
                    :data="$order->default"
                    :selected="$order->name ?? 0"
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
            <th class="w-1/4 border-2 border-gray-400 px-4 py-2">{{ __('roles.fields.name') }}</th>
            <th class="w-1/2 border-2 border-gray-400 px-4 py-2">{{ __('roles.fields.permissions') }}</th>
            <th class="w-1/2 border-2 border-gray-400 px-4 py-2">{{ __('datatable.action') }}</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($roles->items()))
            @php $pageCount = ($roles->currentPage() * $roles->perPage()) - $roles->perPage(); @endphp
            @foreach ($roles as $key => $role)
                <tr>
                    <td class="border-2 border-gray-400 px-4 py-2">{{ ++$key + $pageCount }}</td>
                    <td class="border-2 border-gray-400 px-4 py-2">{{ $role->name }}</td>
                    <td class="border-2 border-gray-400 px-4 py-2">
                        @if(!empty($role->getPermissionNames()))
                            @foreach($role->getPermissionNames() as $permission)
                                <x-badge body="green" class="mr-0.5 px-1">{{ $permission }}</x-badge>
                            @endforeach
                        @endif
                    </td>
                    <td class="border-2 border-gray-400 px-4 py-2">
                        <x-a body="info" href="{{ route('roles.show',$role->id) }}">{{ __('actions.view') }}</x-a>
                        @can('roles_edit')
                            <x-a href="{{ route('roles.edit',$role->id) }}">&#128393;</x-a>
                        @endcan
                        @can('roles_delete')
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style = "display:inline">
                                @csrf
                                @method('DELETE')
                                <x-btn body="danger" type="submit">&times;</x-btn>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4"><x-no-data></x-no-data></td>
            </tr>
        @endif
        </tbody>
    </table>
    <x-paginate :paginator="$roles"></x-paginate>
</div>
</x-app-layout>
