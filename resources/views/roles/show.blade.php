<x-app-layout>
    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">{{ __('roles.headers.view') }}</h2>
            </div>
            <div class="float-right">
                <x-a href="{{ route('roles.index') }}">{{ __('actions.back') }}</x-a>
            </div>
        </div>
    </x-slot>
    <div class="container mx-auto my-5 bg-gray-50 rounded">
        <div class="py-5 mx-5">
            <div class="flex flex-col">
                <strong>{{ __('roles.fields.name') }}</strong>
                {{ $role->name }}
            </div>
            <div class="my-3">
                <strong>{{ __('roles.fields.permissions') }}</strong>
                @if(!empty($role->getPermissionNames()))
                    @foreach($role->getPermissionNames() as $permission)
                        <label class="rounded px-1 bg-green-500 mr-0.5 text-">{{ $permission }}</label>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
