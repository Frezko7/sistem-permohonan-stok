@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="my-4">Kemaskini Kuantiti Diterima</h2>

        @if ($stockRequests->isEmpty())
            <p>Tiada stok untuk dikemaskini.</p>
        @else
            <form action="{{ route('stock_requests.update_received_quantities', $groupId) }}" method="POST">
                @csrf
                @method('PUT')
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No. Kod</th>
                            <th>Perihal Stok</th>
                            <th>Kuantiti Diluluskan</th>
                            <th>Kuantiti Diterima</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stockRequests as $stockRequest)
                            <tr>
                                <td>{{ $stockRequest->stock_id }}</td>
                                <td>{{ $stockRequest->stock->description }}</td>
                                <td>{{ $stockRequest->approved_quantity }}</td>
                                <td>
                                    <input type="number" name="received_quantities[{{ $stockRequest->id }}]"
                                        class="form-control" min="0" max="{{ $stockRequest->approved_quantity }}"
                                        value="{{ old('received_quantities.' . $stockRequest->id, $stockRequest->received_quantity) }}"
                                        required>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Date Received field -->
                <div class="mb-3">
                    <label for="date_received" class="form-label">Tarikh Diterima</label>
                    <input type="date" name="date_received" id="date_received" class="form-control"
                        value="{{ old('date_received', now()->toDateString()) }}">
                </div>

                <!-- Catatan (Notes) field -->
                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea name="catatan" id="catatan" class="form-control" rows="3">{{ old('catatan') }}</textarea>
                </div>



                <button type="submit" class="btn btn-success">Kemaskini Kuantiti Diterima</button>
            </form>
        @endif
    </div>
@endsection
