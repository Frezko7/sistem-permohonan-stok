@extends('layouts.app')

@section('header')
    <h1 class="text-center font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Borang Permohonan Stok') }}
    </h1>
@endsection

@section('content')
    <div class="container mx-auto mt-10">
        @if ($errors->any())
            <div class="alert alert-error mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('stock_requests.store') }}" method="POST" class="bg-base-200 p-6 rounded-lg shadow-md">
            @csrf

            <!-- Display User Info (Name, Bahagian, Phone Number) -->
            <div class="mb-4">
                <label for="user_name" class="label"><span class="label-text">Nama:</span></label>
                <input type="text" class="input input-bordered w-full" id="user_name" name="user_name"
                    value="{{ Auth::user()->name }}" readonly>
            </div>

            <div class="mb-4">
                <label for="bahagian_unit" class="label"><span class="label-text">Bahagian/Unit:</span></label>
                <input type="text" class="input input-bordered w-full" id="bahagian_unit" name="bahagian_unit"
                    value="{{ Auth::user()->bahagian_unit }}" readonly>
            </div>

            <div class="mb-4">
                <label for="phone_number" class="label"><span class="label-text">No. Telefon:</span></label>
                <input type="text" class="input input-bordered w-full" id="phone_number" name="phone_number"
                    value="{{ Auth::user()->phone_number }}" readonly>
            </div>

            <!-- Hidden Stock Request ID -->
            <input type="hidden" name="stock_request_id" id="stock_request_id"
                value="{{ old('stock_request_id', $stockRequestId ?? '') }}">

            <!-- Stock Items Section (Dynamic) -->
            <div id="stock-items">
                <div class="stock-item mb-4">
                    <label for="stock_id[]" class="label"><span class="label-text">No. Kod Stok:</span></label>
                    <input type="text" class="input input-bordered w-full stock-id" name="stock_ids[]"
                        placeholder="Masukkan kod stok" autocomplete="off" required>

                    <ul class="stock-suggestions list-group position-absolute w-full bg-base-100 shadow-lg"
                        style="z-index: 1000; display: none;"></ul>

                    <label for="requested_quantity[]" class="label"><span class="label-text">Kuantiti
                            Dimohon:</span></label>
                    <input type="number" class="input input-bordered w-full" name="requested_quantities[]"
                        placeholder="Kuantiti stok" required>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="button" id="add-stock-item" class="btn btn-secondary">Tambah Stok Lain</button>
            </div>

            <!-- Single Date Field -->
            <label for="date" class="label"><span class="label-text">Tarikh:</span></label>
            <input type="date" name="date" id="date" class="input input-bordered w-full"
                value="{{ old('date') }}">

            <!-- Catatan (Notes) -->
            <div class="mb-4">
                <label for="catatan" class="label"><span class="label-text">Catatan</span></label>
                <textarea class="textarea textarea-bordered w-full" id="catatan" name="catatan" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Hantar</button>
        </form>
    </div>

    <script>
        document.getElementById('add-stock-item').addEventListener('click', function() {
            let stockItemsContainer = document.getElementById('stock-items');

            let stockItemHTML = `
                <div class="stock-item mb-4">
                    <label for="stock_id[]" class="label"><span class="label-text">No. Kod Stok:</span></label>
                    <input type="text" class="input input-bordered w-full stock-id" name="stock_ids[]" placeholder="Masukkan kod stok" autocomplete="off" required>
                    
                    <ul class="stock-suggestions list-group position-absolute w-full bg-base-100 shadow-lg" style="z-index: 1000; display: none;"></ul>
    
                    <label for="requested_quantity[]" class="label"><span class="label-text">Kuantiti Dimohon:</span></label>
                    <input type="number" class="input input-bordered w-full" name="requested_quantities[]" placeholder="Kuantiti stok" required>
    
                    <button type="button" class="btn btn-danger mt-2 remove-stock-item">Buang Item</button>
                </div>
            `;

            // Append the new stock item to the container
            stockItemsContainer.insertAdjacentHTML('beforeend', stockItemHTML);

            // Add event listener for removing the stock item
            const removeButtons = stockItemsContainer.querySelectorAll('.remove-stock-item');
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    button.closest('.stock-item').remove();
                });
            });
        });
    </script>
@endsection
