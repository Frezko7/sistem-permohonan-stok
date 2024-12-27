<section class="container mt-5 p-4 border rounded shadow-sm">
    <header class="d-flex align-items-center mb-3">
        <i class="bi bi-person-circle fs-3 me-2"></i>
        <h2 class="h4 mb-0 text-primary">
            {{ __('Maklumat Pengguna') }}
        </h2>
    </header>

    <p class="text-muted mb-4">
        {{ __('Kemaskini maklumat pengguna.') }}
    </p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mb-4">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Nama') }}</label>
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
            <label for="phone_number" class="form-label">{{ __('No. Telefon ') }}</label>
            <input id="phone_number" name="phone_number" type="tel" class="form-control"
                value="{{ old('phone_number', $user->phone_number) }}" required autocomplete="phone">
            @error('phone_number')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Unit/Bahagian Field -->
        <div class="mb-3">
            <label for="bahagian_unit" class="form-label">{{ __('Unit/Bahagian') }}</label>
            <select id="bahagian_unit" name="bahagian_unit" class="form-control" required>
                <option value="" disabled selected>Sila Pilih Unit/Bahagian</option>
                <option value="Bahagian Khidmat Pengurusan"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Bahagian Khidmat Pengurusan' ? 'selected' : '' }}>
                    --Bahagian Khidmat Pengurusan--</option>
                <option value="Unit Pentadbiran"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Unit Pentadbiran' ? 'selected' : '' }}>Unit
                    Pentadbiran</option>
                <option value="Unit Majlis Keraian"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Unit Majlis Keraian' ? 'selected' : '' }}>Unit
                    Majlis Keraian</option>
                <option value="Unit Teknologi Maklumat"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Unit Teknologi Maklumat' ? 'selected' : '' }}>
                    Unit Teknologi Maklumat</option>
                <option value="Unit Aset dan Perolehan"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Unit Aset dan Perolehan' ? 'selected' : '' }}>
                    Unit Aset dan Perolehan</option>
                <option value="Unit Sumber Manusia"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Unit Sumber Manusia' ? 'selected' : '' }}>Unit
                    Sumber Manusia</option>
                <option value="Unit Kewangan"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Unit Kewangan' ? 'selected' : '' }}>Unit Kewangan
                </option>
                <option value="Bahagian Pembangunan"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Bahagian Pembangunan' ? 'selected' : '' }}>
                    --Bahagian Pembangunan--</option>
                <option value="Unit Pembangunan Fizikal"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Unit Pembangunan Fizikal' ? 'selected' : '' }}>
                    Unit Pembangunan Fizikal</option>
                <option value="Unit Pembangunan Masyarakat"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Unit Pembangunan Masyarakat' ? 'selected' : '' }}>
                    Unit Pembangunan Masyarakat</option>
                <option value="Bahagian Pengurusan Tanah"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Bahagian Pengurusan Tanah' ? 'selected' : '' }}>
                    --Bahagian Pengurusan Tanah--</option>
                <option value="Unit Pembangunan Tanah"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Unit Pembangunan Tanah' ? 'selected' : '' }}>Unit
                    Pembangunan Tanah</option>
                <option value="Unit Pelupusan Tanah"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Unit Pelupusan Tanah' ? 'selected' : '' }}>Unit
                    Pelupusan Tanah</option>
                <option value="Unit Pendaftaran"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Unit Pendaftaran' ? 'selected' : '' }}>Unit
                    Pendaftaran</option>
                <option value="Unit Hasil"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Unit Hasil' ? 'selected' : '' }}>Unit Hasil
                </option>
                <option value="Unit Penguatkuasaan"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Unit Penguatkuasaan' ? 'selected' : '' }}>Unit
                    Penguatkuasaan</option>
                <option value="Unit Teknikal"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Unit Teknikal' ? 'selected' : '' }}>Unit Teknikal
                </option>
                <option value="Pejabat Pegawai Daerah"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Pejabat Pegawai Daerah' ? 'selected' : '' }}>
                    --Pejabat Pegawai Daerah--</option>
                <option value="Unit Perundangan"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Unit Perundangan' ? 'selected' : '' }}>Unit
                    Perundangan</option>
                <option value="Unit Integriti"
                    {{ old('bahagian_unit', $user->bahagian_unit) == 'Unit Integriti' ? 'selected' : '' }}>Unit
                    Integriti</option>
            </select>
            @error('bahagian_unit')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-success mb-0">{{ __('Berjaya disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
