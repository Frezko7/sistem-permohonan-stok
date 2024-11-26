@extends('layouts.app')

@section('header')
    <h1 class="text-center font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Katalog Stok') }}
    </h1>
@endsection

@section('content')
    <div class="container">
        <!-- Search Form -->
        <form action="{{ route('catalog.search') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="query" class="form-control" placeholder="Cari no.kod atau perihal stok"
                        value="{{ request('query') }}" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Cari</button>
                </div>
            </div>
        </form>

        <div class="row">
            @forelse ($stocks as $stock)
                <div class="col-md-3 mb-4">
                    <div class="card" style="width: 100%;">
                        <img src="{{ asset('storage/' . $stock->image) }}" class="card-img-top"
                            alt="{{ $stock->description }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $stock->description }}</h5>
                            <p class="card-text">No. Kod: {{ $stock->stock_id }}</p>
                            <a href="{{ route('stock.show', $stock->stock_id) }}" class="btn btn-primary mt-auto">Lihat
                                Butiran</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">Pencarian tidak ditemui "{{ request('query') }}"</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
