<!DOCTYPE html>
<html>
<head>
    <title>Welcome to {{ config('app.name') }}</title>
</head>
<body>
    <h1>Hello, {{ $user->name }}!</h1>
    <p>Thank you for registering on {{ config('app.name') }}.</p>
    <p>We’re glad to have you with us!</p>
    <a href="{{ url('/') }}">Visit our website</a>
</body>
</html>
