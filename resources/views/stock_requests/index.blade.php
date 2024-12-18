@extends('layouts.app')

@section('header')
    <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">
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
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Pemohon</th>
                        <th>Bahagian/Unit</th>
                        <th>Nombor Telefon</th>
                        <th>Status</th>
                        @if (auth()->user()->usertype === 'admin')
                            <th>Pengesahan/Laporan</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                        $displayedGroups = [];
                    @endphp

                    @foreach ($stockRequests as $request)
                        @if (!in_array($request->group_id, $displayedGroups))
                            @php
                                $displayedGroups[] = $request->group_id;
                            @endphp

                            <tr>
                                <td rowspan="{{ $stockRequests->where('group_id', $request->group_id)->count() }}">
                                    {{ $request->group_id }}
                                </td>
                                <td>{{ $request->user->name }}</td>
                                <td>{{ $request->user->bahagian_unit ?? '-' }}</td>
                                <td>{{ $request->user->phone_number ?? '-' }}</td>
                                <td>
                                    <span
                                        class="badge {{ $request->status === 'pending' ? 'badge-warning' : ($request->status === 'approved' ? 'badge-success' : 'badge-error') }}">
                                        @if ($request->status === 'approved')
                                            <i class="fas fa-check-circle"></i>
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
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to reject this request?')">Reject</a>
                                        @endif
                                        <a href="{{ route('stock_requests.report', ['userId' => $request->user->id]) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-file-pdf"></i> Pdf
                                        </a>

                                        {{-- Delete Button --}}
                                        @if ($request->status === 'approved')
                                            <form action="{{ route('stock_requests.destroy', $request) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this request?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
