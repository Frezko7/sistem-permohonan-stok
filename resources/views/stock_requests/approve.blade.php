@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Pengesahan Permohonan Stok') }}
    </h2>
@endsection

@section('content')
    <div class="container mx-auto mt-10">

        <!-- User Information -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Maklumat Pemohon</h2>
            <p><strong>Nama:</strong> {{ $stockRequest->user->name }}</p>
            <p><strong>Bahagian/Unit:</strong> {{ $stockRequest->user->bahagian_unit ?? '-' }}</p>
            <p><strong>No. Telefon:</strong> {{ $stockRequest->user->phone_number ?? '-' }}</p>
        </div>

        <!-- Approval Form for All Stock Requests -->
        <form action="{{ route('stock_requests.approve_all') }}" method="POST">
            @csrf
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">Senarai Permohonan Stok</h2>
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. Kod</th>
                            <th>Perihal Stok</th>
                            <th>Tarikh</th>
                            <th>Kuantiti Dimohon</th>
                            <th>Kuantiti Diluluskan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userStockRequests as $request)
                            @if ($request->status === 'pending')
                                <tr>
                                    <td>{{ $request->id }}</td>
                                    <td>{{ $request->stock->id }}</td>
                                    <td>{{ $request->stock->description }}</td>
                                    <td>{{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y') }}</td>
                                    <td>{{ $request->requested_quantity }}</td>
                                    <td>
                                        <input type="number" name="approved_quantities[{{ $request->id }}]"
                                            class="input input-bordered w-full" min="1"
                                            max="{{ $request->requested_quantity }}" required>
                                    </td>
                                </tr>
                            @else
                                <tr class="bg-gray-100">
                                    <td>{{ $request->id }}</td>
                                    <td>{{ $request->stock->id }}</td>
                                    <td>{{ $request->stock->description }}</td>
                                    <td>{{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y') }}</td>
                                    <td>{{ $request->requested_quantity }}</td>
                                    <td>
                                        <span class="text-green-600 font-semibold">Diluluskan</span>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-success">Luluskan Semua</button>
            <a href="{{ route('stock_requests.index') }}" class="btn btn-secondary ml-2">Batal</a>
        </form>
    </div>
@endsection
