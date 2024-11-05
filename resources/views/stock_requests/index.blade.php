@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-4">Stock Requests</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">

            <div class="mb-4">
                <a href="{{ route('stock_requests.report') }}" class="btn btn-primary" target="_blank">Generate PDF Report</a>
            </div>
            
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No.Kod</th>
                        <th>Perihal Stok</th>
                        <th>Nama Pemohon</th>
                        <th>Bahagian/Unit</th>
                        <th>Phone Number</th>
                        <th>Kuantiti Dimohon</th>
                        <th>Baki Sedia Ada</th>
                        <th>Status</th>
                        @if (auth()->user()->usertype === 'admin')
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stockRequests as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>{{ $request->stock->id }}</td>
                            <td>{{ $request->stock->description }}</td>
                            <td>{{ $request->user->name }}</td>
                            <td>{{ $request->user->bahagian_unit ?? '-' }}</td>
                            <td>{{ $request->user->phone_number ?? '-' }}</td>
                            <td>{{ $request->requested_quantity }}</td>
                            <td>{{ $request->stock->quantity }}</td>
                            <td>
                                <span
                                    class="badge {{ $request->status === 'pending' ? 'badge-warning' : ($request->status === 'approved' ? 'badge-success' : 'badge-error') }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </td>
                            @if (auth()->user()->usertype === 'admin')
                                <td>
                                    @if ($request->status === 'pending')
                                        <a href="{{ route('stock_requests.showApprovalForm', $request) }}"
                                            class="btn btn-success btn-sm"
                                            onclick="return confirm('Are you sure you want to approve this request?')">Approve</a>
                                        <a href="{{ route('stock_requests.reject', $request) }}"
                                            class="btn btn-error btn-sm"
                                            onclick="return confirm('Are you sure you want to reject this request?')">Reject</a>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
