<!DOCTYPE html>
<html>
<head>
    <title>Stock Requests Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Stock Requests Report</h1>
    <table>
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
                    <td>{{ ucfirst($request->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
