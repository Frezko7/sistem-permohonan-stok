@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h2 class="text-xl mb-4">Edit Stock</h2>

        <form method="POST" action="{{ route('stocks.update', $stock->stock_id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Method spoofing for PUT -->

            <div class="mb-3">
                <label for="description" class="form-label">Perihal Stok:</label>
                <input type="text" name="description" id="description" value="{{ $stock->description }}"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Kuantiti:</label>
                <input type="number" name="quantity" id="quantity" value="{{ $stock->quantity }}" class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Gambar Stok (optional):</label>
                <input type="file" name="image" id="image" class="form-control">
                @if ($stock->image)
                    <p class="mt-2">Current Image:</p>
                    <img src="{{ asset('storage/' . $stock->image) }}" alt="Stock Image" class="img-thumbnail"
                        width="150">
                @else
                    <p class="mt-2">No image available</p>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Kemaskini Stok</button>
        </form>
    </div>
@endsection
