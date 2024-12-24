<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Stock Request Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        .header {
            font-weight: bold;
            text-align: center;
        }

        .signature {
            padding-top: 30px;
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="header">
        <h4>BORANG PERMOHONAN STOK (INDIVIDU KEPADA STOR)</h4>
        <p>Pekeliling Perbendaharaan Malaysia, Lampiran B</p>
    </div>

    <table>
        <thead>
            <tr>
                <th colspan="4">Permohonan</th>
                <th colspan="3">Pegawai Pelulus</th>
                <th colspan="2">Perakuan Penerimaan</th>
            </tr>
            <tr>
                <td>No.Kod</td>
                <td>Perihal Stok</td>
                <td>Kuantiti Dimohon</td>
                <td>Catatan</td>
                <td>Baki Sedia Ada</td>
                <td>Kuantiti Diluluskan</td>
                <td>Catatan</td>
                <td>Kuantiti Diterima</td>
                <td>Catatan</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($stockRequests as $request)
                <tr>
                    <td>{{ $request->stock->stock_id }}</td>
                    <td>{{ $request->stock->description }}</td>
                    <td>{{ $request->requested_quantity }}</td>
                    <td>{{ $request->catatan }}</td>
                    <td>{{ $request->stock->quantity }}</td>
                    <td>{{ $request->approved_quantity }}</td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">
                    <strong>Pemohon:</strong><br><br>
                    <p>.....................................</p><br>
                    (Tandatangan)
                    <br>
                    Nama: {{ $request->user->name }}<br>
                    Jawatan: {{ $request->user->bahagian_unit }}<br>
                    Tarikh: {{ $request->date }}
                </td>
                <td colspan="3">
                    <strong>Pegawai Pelulus:</strong><br><br>
                    <p>.....................................</p><br>
                    (Tandatangan)
                    <br>
                    Nama: {{ auth()->user()->name }}<br>
                    Jawatan: {{ auth()->user()->bahagian_unit ?? 'N/A' }}<br>
                    Tarikh: {{ $request->date_approved }}
                </td>
                <td colspan="2">
                    <strong>Pemohon/Wakil:</strong><br><br>
                    <p>.....................................</p><br>
                    (Tandatangan)
                    <br>
                    Nama: <br>
                    Jawatan: <br>
                    Tarikh:
                </td>
            </tr>
        </tbody>
    </table>

    <br>
    <div class="header">
        <p>HARI PENGELUARAN STOK: ISNIN DAN SELASA</p>
        <p>HARI PENGHANTARAN BORANG: RABU HINGGA JUMAAT, 9.00 PAGI - 4.00 PETANG</p>
    </div>

</body>

</html>
