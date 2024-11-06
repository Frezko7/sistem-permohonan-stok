@extends('layouts.app')

@section('header')
    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Request Stock') }}
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

        <form action="{{ route('stock_requests.store') }}" method="POST" class="bg-base-200 p-6 rounded-lg shadow-md">
            @csrf

            <!-- Display User Name -->
            <div class="mb-4">
                <label for="user_name" class="label"><span class="label-text">Name</span></label>
                <input type="text" class="input input-bordered w-full" id="user_name" name="user_name" value="{{ Auth::user()->name }}" readonly>
            </div>

            <!-- Display Bahagian/Unit -->
            <div class="mb-4">
                <label for="bahagian_unit" class="label"><span class="label-text">Bahagian/Unit</span></label>
                <input type="text" class="input input-bordered w-full" id="bahagian_unit" name="bahagian_unit" value="{{ Auth::user()->bahagian_unit }}" readonly>
            </div>

            <!-- Display Phone Number -->
            <div class="mb-4">
                <label for="phone_number" class="label"><span class="label-text">Phone Number</span></label>
                <input type="text" class="input input-bordered w-full" id="phone_number" name="phone_number" value="{{ Auth::user()->phone_number }}" readonly>
            </div>

            <!-- Stock ID Input with Autocomplete -->
            <div class="mb-4 position-relative">
                <label for="stock_id" class="label"><span class="label-text">Enter Stock ID</span></label>
                <input type="text" class="input input-bordered w-full" id="stock_id" name="stock_id" placeholder="Enter the stock ID" autocomplete="off" required>

                <!-- Dropdown for suggestions -->
                <ul id="stockSuggestions" class="list-group position-absolute w-full bg-base-100 shadow-lg" style="z-index: 1000; display: none;">
                </ul>
            </div>

            <!-- Requested Quantity -->
            <div class="mb-4">
                <label for="requested_quantity" class="label"><span class="label-text">Requested Quantity</span></label>
                <input type="number" class="input input-bordered w-full" id="requested_quantity" name="requested_quantity" required>
            </div>

            <!-- Requested Date -->
            <div class="mb-4">
                <label for="request_date" class="label"><span class="label-text">Request Date</span></label>
                <input type="date" name="request_date" id="request_date" class="input input-bordered w-full">
            </div>

            <!-- Catatan (Notes) -->
            <div class="mb-4">
                <label for="catatan" class="label"><span class="label-text">Catatan</span></label>
                <textarea class="textarea textarea-bordered w-full" id="catatan" name="catatan" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit Request</button>
        </form>
    </div>

    <script>
        document.getElementById('stock_id').addEventListener('input', function() {
            const search = this.value;
            if (search.length > 0) {
                fetch(`{{ route('stocks.search') }}?search=${search}`)
                    .then(response => response.json())
                    .then(data => {
                        const suggestionsList = document.getElementById('stockSuggestions');
                        suggestionsList.innerHTML = '';

                        if (data.length > 0) {
                            suggestionsList.style.display = 'block';
                            data.forEach(stock => {
                                const listItem = document.createElement('li');
                                listItem.classList.add('list-group-item', 'cursor-pointer', 'hover:bg-gray-200', 'p-2');
                                listItem.textContent = `ID: ${stock.id} - ${stock.description}`;
                                listItem.onclick = () => {
                                    document.getElementById('stock_id').value = stock.id;
                                    suggestionsList.style.display = 'none';
                                };
                                suggestionsList.appendChild(listItem);
                            });
                        } else {
                            suggestionsList.style.display = 'none';
                        }
                    });
            } else {
                document.getElementById('stockSuggestions').style.display = 'none';
            }
        });
    </script>
@endsection
