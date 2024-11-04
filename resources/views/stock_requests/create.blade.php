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
            <input type="text" class="form-control" id="user_name" name="user_name" value="{{ Auth::user()->name }}" readonly>
        </div>

        <!-- Display Bahagian/Unit -->
        <div class="mb-3">
            <label for="bahagian_unit" class="form-label">Bahagian/Unit</label>
            <input type="text" class="form-control" id="bahagian_unit" name="bahagian_unit" value="{{ Auth::user()->bahagian_unit }}" readonly>
        </div>

        <!-- Display Phone Number -->
        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ Auth::user()->phone_number }}" readonly>
        </div>

        <!-- Stock Selection -->
        <div class="mb-3">
            <label for="stock_id" class="form-label">Select Stock</label>
            <select class="form-select" id="stock_id" name="stock_id" required>
                @foreach($stocks as $stock)
                    <option value="{{ $stock->id }}">{{ $stock->description }} (Available: {{ $stock->quantity }})</option>
                @endforeach
            </select>
        </div>

        <!-- Requested Quantity -->
        <div class="mb-3">
            <label for="requested_quantity" class="form-label">Requested Quantity</label>
            <input type="number" class="form-control" id="requested_quantity" name="requested_quantity" required>
        </div>

        <!-- Catatan (Notes) -->
        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Request</button>
    </form>
</div>
@endsection
