<x-app-layout>

    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">{{ __('users.headers.create') }}</h2>
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
<form action="{{route('users.store')}}" method="POST">
    @csrf
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div  class="mt-4">
                <x-input-label for="name" :value="__('users.fields.name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            <div  class="mt-4">
                <x-input-label for="login" :value="__('users.fields.login')" />
                <x-text-input id="login" name="login" type="text" class="mt-1 block w-full" required autofocus autocomplete="login" />
                <x-input-error class="mt-2" :messages="$errors->get('login')" />
            </div>
            <div  class="mt-4">
                <x-input-label for="phone" :value="__('users.fields.phone')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" min="1" required autocomplete="phone" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
            <div class="mt-4">
                <x-label for="email" :value="__('users.fields.email')" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" required :placeholder="__('users.fields.email')"/>
            </div>
            <div class="mt-4">
                <x-label for="password" :value="__('users.fields.password')" />
                <x-input id="password" class="block mt-1 w-full"
                         type="password"
                         name="password"
                         required autocomplete="new-password"
                         :placeholder="__('users.fields.password')"/>
            </div>
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('users.fields.confirm_password')" />
                <x-input id="password_confirmation" class="block mt-1 w-full"
                         type="password"
                         name="password_confirmation" required
                         :placeholder="__('users.fields.confirm_password')"/>
            </div>
            <div class="mt-4">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('roles.headers.title') }}</h1>
                <div class="py-4 flex flex-col justify-items-stretch container-line-UserRole">
                    <x-template.user-role :roles="$roles"></x-template.user-role>
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
        new UserRoleTemplate();
    })
    IMask(
        document.getElementById('phone'),
        {
            mask: '+{7}(000)000-00-00'
        }
    )
</script>
