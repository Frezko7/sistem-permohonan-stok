
@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-4">Approve Stock Request</h1>
    
    <div class="mb-4">
        <p><strong>Stock ID:</strong> {{ $stockRequest->stock->id }}</p>
        <p><strong>Stock Description:</strong> {{ $stockRequest->stock->description }}</p>
        <p><strong>Date:</strong> {{ $stockRequest->request_date }}</p>
        <p><strong>Requested Quantity:</strong> {{ $stockRequest->requested_quantity }}</p>
        <p><strong>Available Quantity:</strong> {{ $stockRequest->stock->quantity }}</p>
    </div>
    
    <form action="{{ route('stock_requests.approve', $stockRequest->id) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="approved_quantity" class="block text-sm font-medium">Approved Quantity</label>
            <input type="number" name="approved_quantity" id="approved_quantity" class="input input-bordered w-full" 
                   min="1" max="{{ $stockRequest->requested_quantity }}" required>
            @error('approved_quantity')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-success">Approve</button>
        <a href="{{ route('stock_requests.index') }}" class="btn btn-secondary ml-2">Cancel</a>
    </form>
</div>
@endsection
