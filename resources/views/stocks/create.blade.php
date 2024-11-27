@extends('layouts.app')

@section('content')
    <div class="container">
        <h1> Tambah Stok</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="p-4 sm:p-8 bg-secondary sm:rounded-lg bg-blue-100">
            <form action="{{ route('stocks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="description" class="form-label">Perihal Stok:</label>
                    <input type="text" name="description" id="description" class="form-input" required>
                </div>
                <div class="mb-4">
                    <label for="quantity" class="form-label">Kuantiti:</label>
                    <input type="number" name="quantity" id="quantity" class="form-input" required min="1">
                </div>
                <div class="mb-4">
                    <label for="image" class="form-label">Gambar Stok:</label>
                    <input type="file" name="image" id="image" class="form-input" accept="image/*">
                </div>
                <button type="submit" class="btn btn-success">Tambah Stok</button>
            </form>
        </div>
    </div>
@endsection
