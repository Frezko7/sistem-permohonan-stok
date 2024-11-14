@extends('layouts.app')

@section('header')
    <h1 class="text-center font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Katalog Stok') }}
    </h1>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($stocks as $stock)
                <div class="col-md-3 col-sm-12 mb-4">
                    <div class="card" style="width: 100%;"> <!-- Ensures cards fill the column width -->
                        <img src="{{ asset('storage/' . $stock->image) }}" class="card-img-top"
                            alt="{{ $stock->description }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $stock->description }}</h5>
                            <p class="card-text">No. Kod: {{ $stock->id }}</p>
                            <a href="{{ route('stock.show', $stock->id) }}" class="btn btn-primary mt-auto">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
