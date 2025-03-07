<x-guest-layout>
    <!-- Two-column Layout -->
    <div class="flex w-full max-w-7xl mx-auto">
        <!-- Left Side (Image) -->
        <div class="hidden lg:block w-1/2 bg-cover bg-center"
            style="background-image: url('{{ asset('images/IMG_1623.jpg') }}');">
            <!-- You can adjust the background image URL here -->
        </div>

        <!-- Right Side (Login Form) -->
        <div class="w-full lg:w-1/2 p-8 bg-white shadow-lg rounded-lg">
            <h4 class="text-2xl font-bold text-center mb-8">Sistem Permohonan Stok</h4>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email:')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Kata Laluan:')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <!-- Forgot Password -->
                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                        href="{{ route('password.request') }}">
                        {{ __('Lupa Kata Laluan?') }}
                    </a>

                    <!-- Login Button -->
                    <x-primary-button class="ms-3">
                        {{ __('Log Masuk') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
