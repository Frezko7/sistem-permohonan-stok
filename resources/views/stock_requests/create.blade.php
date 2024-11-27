@extends('layouts.app')

@section('header')
    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Mohon Stok') }}
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

            <button type="button" id="add-stock-item" class="btn btn-secondary mt-4">Tambah Stok Lain</button>

            <!-- Catatan (Notes) -->
            <div class="mb-4">
                <label for="catatan" class="label"><span class="label-text">Catatan</span></label>
                <textarea class="textarea textarea-bordered w-full" id="catatan" name="catatan" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Hantar</button>
        </form>
    </div>

    <script>
        // Handle dynamic stock item fields
        document.getElementById('add-stock-item').addEventListener('click', function() {
            let stockItemHTML = `
                <div class="stock-item mb-4">
                    <label for="stock_id[]" class="label"><span class="label-text">Enter Stock ID</span></label>
                    <input type="text" class="input input-bordered w-full stock-id" name="stock_ids[]" placeholder="Enter stock ID" autocomplete="off" required>
                    
                    <ul class="stock-suggestions list-group position-absolute w-full bg-base-100 shadow-lg" style="z-index: 1000; display: none;"></ul>

                    <label for="requested_quantity[]" class="label"><span class="label-text">Requested Quantity</span></label>
                    <input type="number" class="input input-bordered w-full" name="requested_quantities[]" placeholder="Quantity" required>
                </div>
            `;
            document.getElementById('stock-items').insertAdjacentHTML('beforeend', stockItemHTML);
        });

        // Autocomplete functionality for stock ID input fields
        document.querySelectorAll('.stock-id').forEach(input => {
            input.addEventListener('input', function() {
                const search = this.value;
                const suggestionsList = this.nextElementSibling; // Stock suggestions UL

                if (search.length > 0) {
                    fetch(`{{ route('stocks.search') }}?search=${search}`)
                        .then(response => response.json())
                        .then(data => {
                            suggestionsList.innerHTML = '';
                            if (data.length > 0) {
                                suggestionsList.style.display = 'block';
                                data.forEach(stock => {
                                    const listItem = document.createElement('li');
                                    listItem.classList.add('list-group-item', 'cursor-pointer',
                                        'hover:bg-gray-200', 'p-2');
                                    listItem.textContent =
                                        `ID: ${stock.id} - ${stock.description}`;
                                    listItem.onclick = () => {
                                        this.value = stock.id;
                                        suggestionsList.style.display = 'none';
                                    };
                                    suggestionsList.appendChild(listItem);
                                });
                            } else {
                                suggestionsList.style.display = 'none';
                            }
                        });
                } else {
                    suggestionsList.style.display = 'none';
                }
            });
        });
    </script>
@endsection
