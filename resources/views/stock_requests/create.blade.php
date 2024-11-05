@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Request Stock</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('stock_requests.store') }}" method="POST">
            @csrf

            <!-- Display User Name -->
            <div class="mb-3">
                <label for="user_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="user_name" name="user_name" value="{{ Auth::user()->name }}"
                    readonly>
            </div>

            <!-- Display Bahagian/Unit -->
            <div class="mb-3">
                <label for="bahagian_unit" class="form-label">Bahagian/Unit</label>
                <input type="text" class="form-control" id="bahagian_unit" name="bahagian_unit"
                    value="{{ Auth::user()->bahagian_unit }}" readonly>
            </div>

            <!-- Display Phone Number -->
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number"
                    value="{{ Auth::user()->phone_number }}" readonly>
            </div>

            <!-- Stock ID Input with Autocomplete -->
            <div class="mb-3 position-relative">
                <label for="stock_id" class="form-label">Enter Stock ID</label>
                <input type="text" class="form-control" id="stock_id" name="stock_id" placeholder="Enter the stock ID"
                    autocomplete="off" required>

                <!-- Dropdown for suggestions -->
                <ul id="stockSuggestions" class="list-group position-absolute w-100" style="z-index: 1000; display: none;">
                </ul>
            </div>

            <!-- Requested Quantity -->
            <div class="mb-3">
                <label for="requested_quantity" class="form-label">Requested Quantity</label>
                <input type="number" class="form-control" id="requested_quantity" name="requested_quantity" required>
            </div>

            <!-- Requested Date -->
            <div>
                <label for="request_date">Request Date:</label>
                <input type="date" name="request_date" id="request_date" class="form-control">
            </div>

            <!-- Catatan (Notes) -->
            <div class="mb-3">
                <label for="catatan" class="form-label">Catatan</label>
                <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
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
                                listItem.classList.add('list-group-item');
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
