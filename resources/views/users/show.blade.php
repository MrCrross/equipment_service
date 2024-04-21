<x-app-layout>
    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">{{ __('users.headers.view') }}</h2>
            </div>
            <div class="float-right">
                <x-a href="{{ route('users.index') }}">{{ __('actions.back') }}</x-a>
            </div>
        </div>
    </x-slot>
    <div class="container mx-auto my-5 bg-gray-50 rounded">
        @if ($message = Session::get('success'))
            <div class="w-full px-10 py-5 bg-green-500">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="py-5 mx-5">
            <div class="flex flex-col">
                <strong>{{ __('users.fields.name') }}:</strong>
                {{ $user->name}}
            </div>
            <div class="flex flex-col">
                <strong>{{ __('users.fields.phone') }}:</strong>
                {{ $user->phone }}
            </div>
            <div class="flex flex-col">
                <strong>{{ __('users.fields.login') }}:</strong>
                {{ $user->login }}
            </div>
            <div class="flex flex-col">
                <strong>{{ __('users.fields.email') }}:</strong>
                {{ $user->email }}
            </div>
            <div class="my-3">
                <strong>{{ __('roles.headers.title') }}:</strong>
                @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $roleName)
                        <label class="rounded px-1 bg-green-500 mr-0.5">{{ $roleName }}</label>
                    @endforeach
                @endif
            </div>
            @if(!empty($user->deleted_at))
                @canany(['users_view-delete', 'users_edit'])
                    <div class="my-3">
                        <form method="POST" action="{{route('users.recovery', $user->id)}}">
                            @csrf
                            @method('PATCH')
                            <x-primary-button>{{ __('actions.recovery') }}</x-primary-button>
                        </form>
                    </div>
                @endcanany
            @endif
        </div>
    </div>
</x-app-layout>
