@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <div class="card">
            <div class="card-header text-center">
                <h2 class="mb-0">Maklumat Stok</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Stock ID -->
                        <div class="mb-3">
                            <h5>No. Kod Stok</h5>
                            <p class="card-text">{{ $stock->stock_id }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Stock Description -->
                        <div class="mb-3">
                            <h5>Perihal Stok</h5>
                            <p class="card-text">{{ $stock->description }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Available Quantity -->
                        <div class="mb-3">
                            <h5>Kuantiti Sedia Ada</h5>
                            <p class="card-text">{{ $stock->quantity }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted text-center">
                <a href="{{ route('catalog.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection
