@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h2 class="text-xl">Edit Stock</h2>
    
    <form method="POST" action="{{ route('stocks.update', $stock->id) }}">
        @csrf
        @method('PUT') <!-- Method spoofing for PUT -->
        
        <div>
            <label for="description">Stock Description:</label>
            <input type="text" name="description" id="description" value="{{ $stock->description }}" required>
        </div>

        <div>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" value="{{ $stock->quantity }}" required>
        </div>

        <button type="submit">Update Stock</button>
    </form>

    <form method="POST" action="{{ route('stocks.destroy', $stock->id) }}">
        @csrf
        @method('DELETE') <!-- Method spoofing for DELETE -->
        <button type="submit" onclick="return confirm('Are you sure you want to delete this stock?')">Delete Stock</button>
    </form>
</div>
@endsection
