@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Information Update Form with custom background -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg bg-blue-100">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password Update Form with custom background -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg bg-green-100">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- User Delete Form with custom background -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg bg-red-100">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
