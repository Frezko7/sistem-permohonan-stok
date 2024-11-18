<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


</head>

<body>
    <header class="bg-white shadow">
        @include('layouts.navigation')
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        </div>
        @yield('header') <!-- This will be filled by the specific page -->
    </header>

    <main>

        <!-- Add background class here -->
        <div class="min-h-screen bg-cover bg-center"
            style="background-image: url('{{ asset('path/to/your/background.jpg') }}');">
            @yield('content') <!-- Content section -->
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer footer-center bg-base-300 text-base-content p-4">
        <aside>
            <p>Copyright © {{ date('Y') }} - All right reserved by ACME Industries Ltd</p>
        </aside>
    </footer>


    <!-- Add your JavaScript here -->
</body>

</html>
