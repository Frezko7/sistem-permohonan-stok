<x-guest-layout>

    <!-- Two-column Layout -->
    <div class="flex w-full max-w-7xl mx-auto">
        <!-- Left Side (Image) -->
        <div class="hidden lg:block w-1/2 bg-cover bg-center"
            style="background-image: url('{{ asset('images/IMG_1623.jpg') }}');">
            <!-- Adjust the background image URL -->
        </div>

        <!-- Right Side (Registration Form) -->
        <div class="w-full lg:w-1/2 p-8 bg-white shadow-lg rounded-lg">
            <h2 class="text-3xl font-bold text-center mb-8">Sistem Pengurusan Aset</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                        required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Bahagian/Unit -->
                <div class="mt-4">
                    <x-input-label for="bahagian_unit" :value="__('Bahagian/Unit')" />
                    <x-text-input id="bahagian_unit" class="block mt-1 w-full" type="text" name="bahagian_unit"
                        :value="old('bahagian_unit')" required />
                    <x-input-error :messages="$errors->get('bahagian_unit')" class="mt-2" />
                </div>

                <!-- Phone Number -->
                <div class="mt-4">
                    <x-input-label for="phone_number" :value="__('Phone Number')" />
                    <x-text-input id="phone_number" class="block mt-1 w-full" type="tel" name="phone_number"
                        :value="old('phone_number')" required />
                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">

                    <x-primary-button class="ms-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
