<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('auth.profile_information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('auth.profile_data_update') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

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
            <x-text-input id="login" name="login" type="text" class="mt-1 block w-full" :value="old('login', $user->login)" required autofocus autocomplete="login" />
            <x-input-error class="mt-2" :messages="$errors->get('login')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('users.fields.email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (!$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('auth.email_no_verify') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('auth.verification_repeat') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('auth.profile_verification_link_sent') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('actions.save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('users.messages.update') }}</p>
            @endif
        </div>
    </form>
</section>
<script src="{{asset('js/imask.js')}}"></script>
<script>
    IMask(
        document.getElementById('phone'),
        {
            mask: '+{7}(000)000-00-00'
        }
    )
</script>
