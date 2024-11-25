@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Maklumat Stok</h1>
        <p>No. Kod {{ $stock->stock_id }}</p>
        <p>Perihal Stok: {{ $stock->description }}</p>
        <p>Quantity Available: {{ $stock->quantity }}</p>
    </div>
@endsection
