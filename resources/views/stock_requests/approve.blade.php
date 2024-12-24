@extends('layouts.app')

@section('header')
    <h2 class="text-center mt-4">
        {{ __('Pengesahan Permohonan Stok') }}
    </h2>
@endsection

@section('content')
    <div class="container mt-5">

        <!-- User Information -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4>Maklumat Pemohon</h4>
            </div>
            <div class="card-body">
                <p><strong>Nama:</strong> {{ $stockRequest->user->name }}</p>
                <p><strong>Bahagian/Unit:</strong> {{ $stockRequest->user->bahagian_unit ?? '-' }}</p>
                <p><strong>No. Telefon:</strong> {{ $stockRequest->user->phone_number ?? '-' }}</p>
            </div>
        </div>

        <!-- Approval Form for Pending Stock Requests -->
        <form action="{{ route('stock_requests.approve_all') }}" method="POST">
            @csrf
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h4>Senarai Permohonan Stok (Belum Diluluskan)</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>No. Kod</th>
                                <th>Perihal Stok</th>
                                <th>Tarikh</th>
                                <th>Kuantiti Dimohon</th>
                                <th>Kuantiti Diluluskan</th>
                                <th>Tarikh Diluluskan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userStockRequests as $request)
                                @if ($request->status === 'pending')
                                    <tr>
                                        <td>{{ $request->group_id }}</td>
                                        <td>{{ $request->stock_id }}</td>
                                        <td>{{ $request->stock->description }}</td>
                                        <td>{{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y') }}</td>
                                        <td>{{ $request->requested_quantity }}</td>
                                        <td>
                                            <input type="number" name="approved_quantities[{{ $request->id }}]"
                                                class="form-control" min="1"
                                                max="{{ $request->requested_quantity }}" required>
                                        </td>
                                        <td>
                                            <!-- Input for the approval date -->
                                            <input type="date" name="approved_dates[{{ $request->id }}]"
                                                class="form-control"
                                                value="{{ old('approved_dates.' . $request->id, now()->format('Y-m-d')) }}"
                                                required>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-success">Luluskan Semua</button>
                <a href="{{ route('stock_requests.index') }}" class="btn btn-secondary ms-2">Batal</a>
            </div>
        </form>
    </div>
@endsection
