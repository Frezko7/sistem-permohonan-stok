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

    <!-- Card for Approver's Information -->
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-success text-white">
        <h4>Maklumat Pelulus</h4>
    </div>
    <div class="card-body">
        <!-- Approver Name Dropdown -->
        <div class="mb-3">
            <label for="approver_name" class="form-label"><strong>Nama Pelulus:</strong></label>
            <select name="approver_name" id="approver_name" class="form-select" required>
                <option value="" selected disabled>Pilih Nama Pelulus</option>
                <option value="Puan Nur Faatihah binti Khairuddin">Puan Nur Faatihah binti Khairuddin</option>
                <option value="Cik Nurul Hidayah binti Ahmad Safari">Cik Nurul Hidayah binti Ahmad Safari</option>
            </select>
        </div>

        <!-- Approver Unit/Department Dropdown -->
        <div class="mb-3">
            <label for="approver_bahagian_unit" class="form-label"><strong>Bahagian/Unit Pelulus:</strong></label>
            <select name="approver_bahagian_unit" id="approver_bahagian_unit" class="form-select" required>
                <option value="" selected disabled>Pilih Bahagian/Unit</option>
                <option value="Unit Aset dan Perolehan">Unit Aset dan Perolehan</option>
            </select>
        </div>
    </div>
</div>


    <!-- Card for Pending Stock Requests -->
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h4>Senarai Permohonan Stok (Belum Diluluskan)</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
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

    <!-- Submit Buttons -->
    <div class="mt-4 text-end">
        <button type="submit" class="btn btn-success">Luluskan Semua</button>
        <a href="{{ route('stock_requests.index') }}" class="btn btn-secondary ms-2">Batal</a>
    </div>
</form>

    </div>
@endsection
