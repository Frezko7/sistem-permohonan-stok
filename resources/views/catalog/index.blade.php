@extends('layouts.app')

@section('header')
    <h1 class="text-center font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Katalog Stok') }}
    </h1>
@endsection

@section('content')
    <div class="container">
        <div class="row d-flex flex-wrap justify-content-between">
            @foreach ($stocks as $stock)
                <!-- Change col-md-6 to col-md-4 for 3 columns layout -->
                <div class="col-md-4 col-sm-12 mb-4">
                    <div class="card">
                        <!-- Image with stock description -->
                        <img src="{{ asset('storage/' . $stock->image) }}" class="card-img-top"
                            alt="{{ $stock->description }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $stock->description }}</h5>
                            <p class="card-text">Quantity: {{ $stock->quantity }}</p>
                            <a href="{{ route('stock.show', $stock->id) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
