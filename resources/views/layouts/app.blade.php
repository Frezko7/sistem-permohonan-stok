<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header  class="bg-white shadow">
        @include('layouts.navigation')
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        </div>
        @yield('header') <!-- This will be filled by the specific page -->
    </header>

    <main>
        @yield('content') <!-- This will be filled by the specific page -->
    </main>

    @include('layouts.footer')

    <!-- Add your JavaScript here -->
</body>
</html>
