<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('users.fields.name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div  class="mt-4">
            <x-input-label for="phone" :value="__('users.fields.phone')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" min="1" required />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <!-- Login -->
        <div>
            <x-input-label for="login" :value="__('users.fields.login')" />
            <x-text-input id="login" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required />
            <x-input-error :messages="$errors->get('login')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('users.fields.email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('users.fields.password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('users.fields.confirm_password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('auth.registered') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('actions.register') }}
            </x-primary-button>
        </div>
    </form>
    <script src="{{asset('js/imask.js')}}"></script>
    <script>
        IMask(
            document.getElementById('phone'),
            {
                mask: '+{7}(000)000-00-00'
            }
        )
    </script>
</x-guest-layout>
