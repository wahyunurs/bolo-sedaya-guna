<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="mt-4 flex justify-center">
            <a href="{{ url('/auth/redirect') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <!-- Simple Google mark (stylized) -->
                <svg class="h-5 w-5 me-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                    focusable="false">
                    <circle cx="12" cy="12" r="12" fill="#fff" />
                    <g transform="translate(2,2) scale(0.83)">
                        <path
                            d="M20.66 12.693c0-.638-.057-1.25-.164-1.84H12v3.481h4.684c-.202 1.09-.814 2.016-1.736 2.64v2.2h2.805c1.642-1.514 2.912-3.746 2.912-6.481z"
                            fill="#4285F4" />
                        <path
                            d="M12 22c2.352 0 4.328-.778 5.771-2.108l-2.805-2.2c-.778.524-1.775.836-2.966.836-2.282 0-4.216-1.54-4.907-3.61H3.19v2.265C4.63 19.91 8.044 22 12 22z"
                            fill="#34A853" />
                        <path
                            d="M7.093 13.918A6.996 6.996 0 0 1 6.6 12c0-.66.112-1.3.307-1.918V7.817H3.19A10.003 10.003 0 0 0 2 12c0 1.61.37 3.136 1.03 4.547l3.063-2.629z"
                            fill="#FBBC05" />
                        <path
                            d="M12 6.48c1.277 0 2.424.44 3.326 1.304l2.495-2.495C16.32 3.16 14.344 2 12 2 8.044 2 4.63 4.09 3.19 6.818l3.713 2.265C7.784 7.998 9.718 6.48 12 6.48z"
                            fill="#EA4335" />
                    </g>
                </svg>
                <span>Lanjutkan dengan Google</span>
            </a>
        </div>
    </form>
</x-guest-layout>
