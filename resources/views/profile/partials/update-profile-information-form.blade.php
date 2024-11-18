<section class="container mt-5 p-4 border rounded shadow-sm">
    <header class="d-flex align-items-center mb-3">
        <i class="bi bi-person-circle fs-3 me-2"></i>
        <h2 class="h4 mb-0 text-primary">
            {{ __('Profile Information') }}
        </h2>
    </header>

    <p class="text-muted mb-4">
        {{ __("Update your account's profile information.") }}
    </p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mb-4">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="form-control"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control"
                value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-warning">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="btn btn-link p-0 text-decoration-underline">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Phone Number Field -->
        <div class="mb-3">
            <label for="phone_number" class="form-label">{{ __('Phone Number') }}</label>
            <input id="phone_number" name="phone_number" type="text" class="form-control"
                value="{{ old('phone_number', $user->phone_number) }}" required autocomplete="phone">
            @error('phone_number')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Unit/Bahagian Field -->
        <div class="mb-3">
            <label for="bahagian_unit" class="form-label">{{ __('Unit/Bahagian') }}</label>
            <input id="bahagian_unit" name="bahagian_unit" type="text" class="form-control"
                value="{{ old('bahagian_unit', $user->bahagian_unit) }}" required autocomplete="organization">
            @error('bahagian_unit')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-success mb-0">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
