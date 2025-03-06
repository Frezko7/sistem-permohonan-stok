@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="my-4">Perakuan Penerimaan</h2>

        @if ($stockRequests->isEmpty())
            <p>Tiada stok untuk dikemaskini.</p>
        @else
            <form action="{{ route('stock_requests.update_received_quantities', $groupId) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Maklumat Penerima</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="received_name" class="form-label">Nama Penerima:</label>
                        <input type="text" class="form-control border-primary" id="received_name" name="received_name"
                            placeholder="Masukkan nama penerima">
                    </div>
                    <div class="form-group">
                        <label for="received_bahagian_unit" class="form-label">Bahagian/Unit Penerima:</label>
                        <select class="form-control border-primary" id="received_bahagian_unit" name="received_bahagian_unit">
                        <option value="" disabled selected>{{ __('Pilih Bahagian/Unit') }}</option>
                        <option value="Bahagian Khidmat Pengurusan">--Bahagian Khidmat Pengurusan--</option>
                        <option value="Unit Pentadbiran">Unit Pentadbiran</option>
                        <option value="Unit Majlis Keraian">Unit Majlis Keraian</option>
                        <option value="Unit Teknologi Maklumat">Unit Teknologi Maklumat</option>
                        <option value="Unit Aset dan Perolehan">Unit Aset dan Perolehan</option>
                        <option value="Unit Sumber Manusia">Unit Sumber Manusia</option>
                        <option value="Unit Kewangan">Unit Kewangan</option>
                        <option value="Bahagian Pembangunan">--Bahagian Pembangunan--</option>
                        <option value="Unit Pembangunan Fizikal">Unit Pembangunan Fizikal</option>
                        <option value="Unit Pembangunan Masyarakat">Unit Pembangunan Masyarakat</option>
                        <option value="Bahagian Pengurusan Tanah">--Bahagian Pengurusan Tanah--</option>
                        <option value="Unit Pembangunan Tanah">Unit Pembangunan Tanah</option>
                        <option value="Unit Pelupusan Tanah">Unit Pelupusan Tanah</option>
                        <option value="Unit Pendaftaran">Unit Pendaftaran</option>
                        <option value="Unit Hasil">Unit Hasil</option>
                        <option value="Unit Penguatkuasaan">Unit Penguatkuasaan</option>
                        <option value="Unit Teknikal">Unit Teknikal</option>
                        <option value="Pejabat Pegawai Daerah">--Pejabat Pegawai Daerah--</option>
                        <option value="Unit Perundangan">Unit Perundangan</option>
                        <option value="Unit Integriti">Unit Integriti</option>
                        </select>
                    </div>
                </div>

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



                <button type="submit" class="btn btn-success">Sahkan</button>
            </form>
        @endif
    </div>
@endsection
