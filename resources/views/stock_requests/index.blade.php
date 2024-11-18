@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Permohonan Stok') }}
    </h2>
@endsection

@section('content')
    <div class="container mx-auto mt-10">

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">

            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pemohon</th>
                        <th>Bahagian/Unit</th>
                        <th>Phone Number</th>
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
                            <td>{{ $request->user->name }}</td>
                            <td>{{ $request->user->bahagian_unit ?? '-' }}</td>
                            <td>{{ $request->user->phone_number ?? '-' }}</td>
                            <td>
                                <span
                                    class="badge {{ $request->status === 'pending' ? 'badge-warning' : ($request->status === 'approved' ? 'badge-success' : 'badge-error') }}">
                                    @if ($request->status === 'approved')
                                        <i class="fas fa-check-circle"></i> <!-- Green checklist icon for approved -->
                                    @else
                                        {{ ucfirst($request->status) }}
                                    @endif
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
                                    <a href="{{ route('stock_requests.report', ['id' => $request->id]) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="fas fa-file-pdf"></i> Pdf
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
