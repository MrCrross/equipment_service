<x-app-layout>
    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('roles.headers.update') }}</h2>
            </div>
            <div class="float-right">
                <x-a href="{{ route('roles.index') }}">{{ __('actions.back') }}</x-a>
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
            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="my-5 mx-5">
                    <div class="flex flex-col">
                        <strong>{{ __('roles.fields.name') }}</strong>
                        <x-text-input name="name" type="text"
                                      :placeholder="__('roles.fields.name')"
                                      :value="$role->name"
                                      class="form-input rounded border-gray-300"/>
                    </div>
                    <div class="my-2 flex flex-col">
                        <strong>{{ __('roles.fields.permissions') }}</strong>
                        @foreach($permission as $value)
                            <x-input-label>
                                <x-checkbox name="permission[]" :value="$value"
                                            :checked="in_array($value, $rolePermissions)"></x-checkbox>
                                {{ $value}}
                            </x-input-label>
                        @endforeach
                    </div>
                    <div class="mt-2">
                        <x-btn type="submit">{{ __('actions.submit') }}</x-btn>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
