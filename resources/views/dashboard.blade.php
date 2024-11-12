@extends('layouts.app') <!-- This will extend your layout -->

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
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
                                <p>User Registrations</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Approved Stock Requests -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg bg-blue-100">
                    <h2 class="text-xl font-semibold mb-4">Permohonan Stok yang Diluluskan</h2>
                    @if ($approvedRequests->isEmpty())
                        <p>Tiada permohonan stok yang diluluskan.</p>
                    @else
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Perihal Stok</th>
                                    <th>Kuantiti Diluluskan</th>
                                    <th>Tarikh Diluluskan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($approvedRequests as $request)
                                    <tr>
                                        <td>{{ $request->id }}</td>
                                        <td>{{ $request->stock->description }}</td>
                                        <td>{{ $request->approved_quantity }}</td>
                                        <td>{{ \Carbon\Carbon::parse($request->updated_at)->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
