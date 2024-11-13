@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $stock->name }}</h1>
        <img src="{{ asset('images/' . $stock->image) }}" class="img-fluid" alt="{{ $stock->name }}">
        <p>{{ $stock->description }}</p>
        <p>Quantity Available: {{ $stock->quantity }}</p>
        <p>Status: {{ $stock->status }}</p>
    </div>
@endsection
