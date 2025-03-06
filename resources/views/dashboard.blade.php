@extends('layouts.app') <!-- This will extend your layout -->

@section('header')
    <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if (auth()->user()->isAdmin())
                <!-- Admin content -->
                 
                    <!-- Dashboard Boxes -->
                    <div class="row mt-4">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $userCount }}</h3>
                                    <p>Pengguna Berdaftar</p>
                                </div>
                                <div class="icon">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $totalRequests }}</h3>
                                    <p>Permohonan</p>
                                </div>
                                <div class="icon">
                                    <i class="bi bi-bag"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totalStock }}</h3>
                                    <p>Stok</p>
                                </div>
                                <div class="icon">
                                    <i class="bi bi-boxes"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ $userCount }}</h3>
                                    <p>Kategori</p>
                                </div>
                                <div class="icon">
                                    <i class="bi bi-border-all"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Approved Stock Requests -->
                @if (auth()->user()->usertype === 'applicant')

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg bg-blue-100">
                        <h2 class="text-xl font-semibold mb-8">Status Permohonan</h2>

                        @if ($requests->isEmpty())
                            <p>Tiada permohonan stok.</p>
                        @else
                            <table class="table table-zebra w-full">
                                <thead>
                                    <tr>
                                        <th>Nama Pemohon</th>
                                        <th>Tarikh Permohonan</th>
                                        <th>Status</th>
                                        <th>Perakuan Penerimaan</th>
                                        <th>Borang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $groupedRequests = $requests->groupBy('group_id'); // Group requests by group_id
                                    @endphp

                                    @foreach ($groupedRequests as $groupId => $group)
                                        <tr>
                                            <!-- Nama Pemohon (from the first request in the group) -->
                                            <td>{{ $group->first()->user->name }}</td>

                                            <!-- Tarikh Permohonan (from the first request in the group) -->
                                            <td>{{ $group->first()->date }}</td>

                                            <!-- Status -->
                                            <td>
                                                <span
                                                    class="badge {{ $group->first()->status === 'pending' ? 'badge-warning' : 'badge-success' }}">
                                                    {{ ucfirst($group->first()->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($group->first()->status === 'approved')
                                                    <a href="{{ route('stock_requests.receive', ['groupId' => $groupId]) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-pencil-alt"></i> Sahkan
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('stock_requests.view', ['groupId' => $groupId]) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('stock_requests.report', ['groupId' => $groupId]) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <i class="fas fa-file-pdf"></i> Pdf
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
