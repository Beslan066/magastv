<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Имя')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Пароль')" />

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Повторите пароль')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Consent Checkbox -->
        <div class="mt-4">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="consent" type="checkbox" name="consent" value="1" required
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        {{ old('consent') ? 'checked' : '' }}>
                </div>
                <div class="ml-3 text-sm">
                    <label for="consent" class="text-gray-600">
                        Я принимаю условия
                        <a href="https://magas.tv/privacy-policy" target="_blank"
                           class="text-indigo-600 hover:text-indigo-900 underline">
                            Политики конфиденциальности
                        </a>
                        и даю согласие на
                        <a href="https://magas.tv/soglasie-na-obrabotku-personalnykh-dannykh" target="_blank"
                           class="text-indigo-600 hover:text-indigo-900 underline">
                            обработку персональных данных
                        </a>
                    </label>
                    <x-input-error :messages="$errors->get('consent')" class="mt-1" />
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Уже есть аккаунт?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Зарегистрироваться') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
