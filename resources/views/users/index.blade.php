<x-app-layout>
    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">{{__('users.headers.title')}}</h2>
            </div>
            <div class="float-right">
                @can('users_edit')
                    <x-a
                        body="success"
                        href="{{ route('users.create') }}"
                    >{{__('users.headers.create')}}
                    </x-a>
                @endcan
            </div>
        </div>
    </x-slot>
    @if ($message = Session::get('success'))
        <div class="w-full px-10 py-5 bg-green-500">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="container mx-auto px-4 my-5">
        <form method="GET" action="{{route('users.index')}}"
              class="rounded-xl shadow bg-gray-100 p-4">
            @csrf
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{__('datatable.filters')}}</h1>
            <div class="grid grid-cols-3 gap-10">
                <div class="">
                    <x-input-label
                        for="name"
                        :value="__('users.fields.name')"
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
                        for="phone"
                        :value="__('users.fields.phone')"
                    />
                    <x-text-input
                        id="phone"
                        name="phone"
                        type="text"
                        :value="$filter->phone ?? __('')"
                        class="mt-1 block w-full"
                    />
                </div>
                <div class="">
                    <x-input-label
                        for="email"
                        :value="__('users.fields.email')"
                    />
                    <x-text-input
                        id="email"
                        name="email"
                        type="text"
                        :value="$filter->email ?? __('')"
                        class="mt-1 block w-full"
                    />
                </div>
                <div class="">
                    <x-input-label
                        for="login"
                        :value="__('users.fields.login')"
                    />
                    <x-text-input
                        id="login"
                        name="login"
                        type="text"
                        :value="$filter->login ?? __('')"
                        class="mt-1 block w-full"
                    />
                </div>
                @can('users_view-delete')
                <div class="">
                    <x-input-label
                        for="deleted_at"
                    >
                        {{ __('users.statuses.success') }}
                        <x-checkbox
                            id="deleted_at"
                            name="deleted_at"
                            value="1"
                            :checked="!empty($filter->deleted_at)"
                        />
                    </x-input-label>
                </div>
                @endcan
            </div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight my-2">{{__('datatable.sorting')}}</h1>
            <div class="grid grid-cols-5 gap-10">
                <div>
                    <x-input-label
                        for="order_name"
                        :value="__('users.fields.name')"
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
                        for="order_phone"
                        :value="__('users.fields.phone')"
                    />
                    <x-select
                        id="order_phone"
                        name="order_phone"
                        class="mt-1"
                        :data="$order->default"
                        :selected="$order->phone ?? 0"
                    />
                </div>
                <div>
                    <x-input-label
                        for="order_email"
                        :value="__('users.fields.email')"
                    />
                    <x-select
                        id="order_email"
                        name="order_email"
                        class="mt-1"
                        :data="$order->default"
                        :selected="$order->email ?? 0"
                    />
                </div>
                <div>
                    <x-input-label
                        for="order_login"
                        :value="__('users.fields.login')"
                    />
                    <x-select
                        id="order_login"
                        name="order_login"
                        class="mt-1"
                        :data="$order->default"
                        :selected="$order->login ?? 0"
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
            <tr>
                <th class="w-1/12 border-2 border-gray-400 px-4 py-2">№</th>
                <th class="w-1/9 border-2 border-gray-400 px-4 py-2">{{__('users.fields.name')}}</th>
                <th class="w-1/6 border-2 border-gray-400 px-4 py-2">{{__('users.fields.phone')}}</th>
                <th class="w-1/12 border-2 border-gray-400 px-4 py-2">{{__('users.fields.login')}}</th>
                <th class="w-1/6 border-2 border-gray-400 px-4 py-2">{{__('users.fields.email')}}</th>
                <th class="w-1/12 border-2 border-gray-400 px-4 py-2">{{__('users.fields.status')}}</th>
                <th class="w-1/6 border-2 border-gray-400 px-4 py-2">{{__('roles.headers.title')}}</th>
                <th class="w-1/3 border-2 border-gray-400 px-4 py-2">{{__('datatable.action')}}</th>
            </tr>
            @if(!empty($data->items()))
                @php $pageCount = ($data->currentPage() * $data->perPage()) - $data->perPage(); @endphp
                @foreach ($data as $key => $user)
                    <tr>
                        <td class="border-2 border-gray-400 px-4 py-2">{{ ++$key + $pageCount }}</td>
                        <td class="border-2 border-gray-400 px-4 py-2">{{ $user->name}}</td>
                        <td class="border-2 border-gray-400 px-4 py-2">{{ $user->phone }}</td>
                        <td class="border-2 border-gray-400 px-4 py-2">{{ $user->login }}</td>
                        <td class="border-2 border-gray-400 px-4 py-2">{{ $user->email }}</td>
                        <td class="border-2 border-gray-400 px-4 py-2">
                            @if(empty($user->deleted_at))
                                <x-badge body="green">{{ __('users.statuses.success') }}</x-badge>
                            @else
                                <x-badge body="red">{{ __('users.statuses.delete') }}</x-badge>
                            @endif
                        </td>
                        <td class="border-2 border-gray-400 px-4 py-2">
                            @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $roleName)
                                    <label class="rounded px-1 bg-green-500 mr-0.5">{{ $roleName }}</label>
                                @endforeach
                            @endif
                        </td>
                        <td class="border-2 border-gray-400 px-4 py-2">
                            <x-a
                                body="info"
                                href="{{ route('users.show',$user->id) }}"
                            >{{__('actions.view')}}
                            </x-a>
                            @can('users_delete')
                                @if(empty($user->deleted_at))
                                    <x-a href="{{ route('users.edit',$user->id) }}">&#128393;</x-a>
                                    <form
                                        action="{{ route('users.destroy', $user->id) }}"
                                        method="POST"
                                        style="display:inline"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <x-btn
                                            body="danger"
                                            type="submit"
                                        >&times;
                                        </x-btn>
                                    </form>
                                @endif
                            @endcan
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8"><x-no-data></x-no-data></td>
                </tr>
            @endif
        </table>
        <x-paginate :paginator="$data"></x-paginate>
    </div>
</x-app-layout>
