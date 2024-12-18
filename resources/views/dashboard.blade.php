@extends('layouts.app') <!-- This will extend your layout -->

@section('header')
    <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
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

                <!-- Approved Stock Requests -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg bg-blue-100">
                    <h2 class="text-xl font-semibold mb-8">Status Permohonan</h2>

                    @if ($requests->isEmpty())
                        <p>Tiada permohonan stok.</p>
                    @else
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tarikh Permohonan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $groupedRequests = $requests->groupBy('group_id');
                                @endphp
                                @foreach ($groupedRequests as $groupId => $group)
                                    <tr>
                                        <td rowspan="{{ $group->count() }}">{{ $groupId }}</td>
                                        <td rowspan="{{ $group->count() }}">{{ $group->first()->date }}</td>
                                        <td rowspan="{{ $group->count() }}">
                                            <span
                                                class="badge {{ $group->first()->status === 'pending' ? 'badge-warning' : 'badge-success' }}">
                                                {{ ucfirst($group->first()->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @foreach ($group->slice(1) as $request)
                                        <tr>
                                            <!-- Rows for additional data within the same group -->
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
