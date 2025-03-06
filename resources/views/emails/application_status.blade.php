<!DOCTYPE html>
<html>
<head>
    <title>Stock Application Status</title>
</head>
<body>
    <h1>Your Stock Application Status</h1>
    <p>Dear {{ $details['name'] }},</p>

<p>{{ $details['message'] }}</p>

<p><strong>Approved Stock Items:</strong></p>
<ul>
    @foreach ($details['stock_items'] as $stock)
        <li>{{ $stock }}</li>
    @endforeach
</ul>

<p>Thank you.</p>

<p>{{ config('app.name') }}</p>
</body>
</html>