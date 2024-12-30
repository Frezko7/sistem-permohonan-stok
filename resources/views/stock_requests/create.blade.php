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

        <form id="stock-form" action="{{ route('stock_requests.store') }}" method="POST"
            class="bg-base-200 p-6 rounded-lg shadow-md">
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
                        <!-- Add a container for displaying the stock description -->
                        <div class="stock-description-display mt-2 border p-2 rounded bg-white-100 text-white-700"
                            style="min-height: 40px;">
                        </div>
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

            <button type="submit" id="submit-button" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to attach event listeners to stock ID inputs
            function attachStockIdListeners(input) {
                input.addEventListener('input', function() {
                    const query = this.value;
                    const suggestionsList = this.nextElementSibling; // Suggestions <ul>
                    const stockDescriptionDisplay = this.parentElement.querySelector(
                        '.stock-description-display'); // Stock description display

                    if (query.length > 2) {
                        // Fetch stock suggestions
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
                                        fetchStockDescription(item,
                                            stockDescriptionDisplay
                                        ); // Fetch and display stock description
                                    });
                                    suggestionsList.appendChild(li);
                                });
                                suggestionsList.style.display = 'block'; // Show suggestions
                            })
                            .catch(() => {
                                suggestionsList.innerHTML = '<li>Error loading suggestions</li>';
                            });
                    } else {
                        suggestionsList.style.display = 'none'; // Hide suggestions if query is too short
                        stockDescriptionDisplay.textContent = ''; // Clear stock description display
                    }
                });

                // Fetch stock description when user focuses out
                input.addEventListener('blur', function() {
                    const stockDescriptionDisplay = this.parentElement.querySelector(
                        '.stock-description-display');
                    fetchStockDescription(this.value, stockDescriptionDisplay);
                });
            }

            // Function to dynamically fetch stock suggestions
            document.querySelectorAll('.stock-id').forEach(attachStockIdListeners);

            // "Add More Item" button functionality
            document.getElementById('add-stock-item').addEventListener('click', function() {
                const stockItemsContainer = document.getElementById('stock-items');

                // New stock item HTML
                const stockItemHTML = `
            <div class="stock-item mb-4 flex items-center gap-4">
                <div class="flex-grow">
                    <label for="stock_id[]" class="label"><span class="label-text">No. Kod Stok:</span></label>
                    <input type="text" class="input input-bordered w-full stock-id" name="stock_ids[]" placeholder="Masukkan kod stok" autocomplete="off" required>
                    <ul class="stock-suggestions list-group position-absolute w-full bg-base-100 shadow-lg" style="z-index: 1000; display: none;"></ul>
                    <div class="stock-description-display mt-2 text-gray-600"></div> <!-- Display description -->
                </div>
                <div class="flex-grow">
                    <label for="requested_quantity[]" class="label"><span class="label-text">Kuantiti Dimohon:</span></label>
                    <input type="number" class="input input-bordered w-full" name="requested_quantities[]" placeholder="Kuantiti stok" required>
                </div>
                <button type="button" class="btn btn-danger mt-6 remove-stock-item">Buang</button>
            </div>
        `;

                // Append the new stock item
                stockItemsContainer.insertAdjacentHTML('beforeend', stockItemHTML);

                // Attach listeners to the newly added stock ID input
                const newStockIdInput = stockItemsContainer.querySelector(
                    '.stock-item:last-child .stock-id');
                attachStockIdListeners(newStockIdInput);

                // Attach event listener for the "Remove" button
                const removeButton = stockItemsContainer.querySelector(
                    '.stock-item:last-child .remove-stock-item');
                removeButton.addEventListener('click', function() {
                    this.closest('.stock-item').remove();
                });
            });
        });

        // Function to fetch and display the stock description
        function fetchStockDescription(stockId, stockDescriptionDisplay) {
            if (stockId) {
                fetch(`/stock-description?stock_id=${stockId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.description) {
                            stockDescriptionDisplay.textContent =
                                `Description: ${data.description}`; // Display stock description
                        } else {
                            stockDescriptionDisplay.textContent = 'Description not found'; // No description found
                        }
                    })
                    .catch(() => {
                        stockDescriptionDisplay.textContent = 'Error fetching description'; // Handle errors
                    });
            } else {
                stockDescriptionDisplay.textContent = ''; // Clear display if stock ID is empty
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('stock-form');
            const submitButton = document.getElementById('submit-button');

            form.addEventListener('submit', function(event) {
                // Disable the submit button
                submitButton.disabled = true;

                // Optionally, change the button text to indicate submission
                submitButton.textContent = 'Submitting...';

                // Allow form submission
                form.submit();

                // If the request fails (e.g., using AJAX), you can re-enable the button:
                // submitButton.disabled = false;
                // submitButton.textContent = 'Submit';
            });
        });
    </script>
@endsection
