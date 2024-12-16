@extends('layouts.app')

@section('header')
    <h1 class="text-center font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Borang Permohonan Stok') }}
    </h1>
@endsection

@section('content')
    <div class="container mx-auto mt-10">
        @if ($errors->any())
            <div class="alert alert-error mb-4 bg-red-100 text-red-800 p-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success mb-4 bg-green-100 text-green-800 p-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('stock_requests.store') }}" method="POST" class="bg-base-200 p-6 rounded-lg shadow-md">
            @csrf

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

            <div id="stock-items">
                <div class="stock-item mb-4 flex items-center gap-4">
                    <div class="flex-grow">
                        <label for="stock_id[]" class="label"><span class="label-text">No. Kod Stok:</span></label>
                        <input type="text" class="input input-bordered w-full stock-id" name="stock_ids[]"
                            placeholder="Masukkan kod stok" autocomplete="off" required>
                        <ul class="stock-suggestions list-group position-absolute w-full bg-base-100 shadow-lg"
                            style="z-index: 1000; display: none;"></ul>
                    </div>
                    <div class="flex-grow">
                        <label for="requested_quantity[]" class="label"><span class="label-text">Kuantiti
                                Dimohon:</span></label>
                        <input type="number" class="input input-bordered w-full" name="requested_quantities[]"
                            placeholder="Kuantiti stok" required>
                    </div>
                    <button type="button" class="btn btn-danger mt-6 remove-stock-item">Buang</button>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="button" id="add-stock-item" class="btn btn-secondary">Tambah Stok Lain</button>
            </div>

            <label for="date" class="label"><span class="label-text">Tarikh:</span></label>
            <input type="date" name="date" id="date" class="input input-bordered w-full"
                value="{{ old('date', now()->format('Y-m-d')) }}">

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
                <div class="stock-item mb-4 flex items-center gap-4">
                    <div class="flex-grow">
                        <label for="stock_id[]" class="label"><span class="label-text">No. Kod Stok:</span></label>
                        <input type="text" class="input input-bordered w-full stock-id" name="stock_ids[]" placeholder="Masukkan kod stok" autocomplete="off" required>
                        <ul class="stock-suggestions list-group position-absolute w-full bg-base-100 shadow-lg" style="z-index: 1000; display: none;"></ul>
                    </div>
                    <div class="flex-grow">
                        <label for="requested_quantity[]" class="label"><span class="label-text">Kuantiti Dimohon:</span></label>
                        <input type="number" class="input input-bordered w-full" name="requested_quantities[]" placeholder="Kuantiti stok" required>
                    </div>
                    <button type="button" class="btn btn-danger mt-6 remove-stock-item">Buang</button>
                </div>
            `;

            stockItemsContainer.insertAdjacentHTML('beforeend', stockItemHTML);

            const removeButtons = stockItemsContainer.querySelectorAll('.remove-stock-item');
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    button.closest('.stock-item').remove();
                });
            });
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            let stockIds = Array.from(document.querySelectorAll('input[name="stock_ids[]"]'))
                .map(input => input.value.trim());
            let duplicates = stockIds.filter((item, index) => stockIds.indexOf(item) !== index);

            if (duplicates.length > 0) {
                alert('Duplicate stock codes found: ' + duplicates.join(', '));
                event.preventDefault();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.stock-id').forEach(function(input) {
                input.addEventListener('input', function() {
                    const query = this.value;
                    const suggestionsList = this
                        .nextElementSibling; // Assuming it's the suggestions <ul>

                    if (query.length > 2) {
                        fetch(`/stock-suggestions?query=${query}`)
                            .then(response => response.json())
                            .then(data => {
                                suggestionsList.innerHTML = ''; // Clear previous suggestions
                                data.forEach(item => {
                                    const li = document.createElement('li');
                                    li.className = 'list-group-item cursor-pointer';
                                    li.textContent = item;
                                    li.addEventListener('click', () => {
                                        input.value =
                                            item; // Set the selected suggestion
                                        suggestionsList.style.display =
                                            'none'; // Hide suggestions
                                    });
                                    suggestionsList.appendChild(li);
                                });
                                suggestionsList.style.display = 'block'; // Show suggestions
                            });
                    } else {
                        suggestionsList.style.display =
                            'none'; // Hide suggestions if query is too short
                    }
                });
            });
        });
    </script>
@endsection
