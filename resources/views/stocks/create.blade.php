@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Stock</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('stocks.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="description" class="form-label">Description</label>
            <input type="text" name="description" id="description" class="form-input" required>
        </div>
        <div class="mb-4">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-input" required min="1">
        </div>
        <button type="submit" class="btn btn-success">Add Stock</button>
    </form>
    
</div>
@endsection
