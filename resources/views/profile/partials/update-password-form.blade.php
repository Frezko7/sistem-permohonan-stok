<section class="container mt-5 p-4 border rounded shadow-sm">
    <header class="mb-3">
        <h2 class="h4 text-primary">
            {{ __('Kemaskini Kata Laluan') }}
        </h2>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mb-4">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">{{ __('Kata Laluan Lama') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control"
                autocomplete="current-password">
            @if ($errors->updatePassword->has('current_password'))
                <div class="text-danger mt-1">{{ $errors->updatePassword->first('current_password') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">{{ __('Kata Laluan Baru') }}</label>
            <input id="update_password_password" name="password" type="password" class="form-control"
                autocomplete="new-password">
            @if ($errors->updatePassword->has('password'))
                <div class="text-danger mt-1">{{ $errors->updatePassword->first('password') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">{{ __('Sahkan Laluan Baru') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="form-control" autocomplete="new-password">
            @if ($errors->updatePassword->has('password_confirmation'))
                <div class="text-danger mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-success mb-0">{{ __('Berjaya disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
