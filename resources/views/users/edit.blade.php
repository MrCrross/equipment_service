<x-app-layout>
    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">{{ __('users.headers.edit') }}</h2>
            </div>
            <div class="float-right">
                <x-a href="{{ route('users.index') }}">{{ __('actions.back') }}</x-a>
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
    <x-template.user-role clone="1" :roles="$roles"></x-template.user-role>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div>
                    <x-input-label for="name" :value="__('users.fields.name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
                <div>
                    <x-input-label for="phone" :value="__('users.fields.phone')" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" min="1" required autocomplete="phone" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>
                <div>
                    <x-input-label for="login" :value="__('users.fields.login')" />
                    <x-text-input id="login" name="login" type="text" class="mt-1 block w-full" :value="old('login', $user->login)" min="1" required autocomplete="login" />
                    <x-input-error class="mt-2" :messages="$errors->get('login')" />
                </div>
                <div>
                    <x-input-label for="password" :value="__('users.fields.password')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="password_confirmation" :value="__('users.fields.confirm_password')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>
                <div class="mt-4">
                    <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('roles.headers.title') }}</h1>
                    <div class="py-4 flex flex-col justify-items-stretch container-line-UserRole">
                        @if($userRole->isNotEmpty())
                            @foreach($userRole as $key => $role)
                                <x-template.user-role :type="$key" :fieldID="$role" :roles="$roles"></x-template.user-role>
                            @endforeach
                        @else
                            <x-template.user-role :roles="$roles"></x-template.user-role>
                        @endif
                    </div>
                </div>
                <div class="flex items-center justify-center mt-4">
                    <x-btn type="submit">
                        {{ __('actions.submit') }}
                    </x-btn>
                </div>
            </div>
        </div>

    </form>
</x-app-layout>
<script src="{{asset('js/imask.js')}}"></script>
<script src="{{asset('js/templates/UserRoleTemplate.js')}}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new UserRoleTemplate("{{__('actions.search')}}");
    })
    IMask(
        document.getElementById('phone'),
        {
            mask: '+{7}(000)000-00-00'
        }
    )
</script>
