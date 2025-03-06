<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Sistem Permohonan Stok') }}</title>
    <link rel="icon" type="image/x-icon" href=" {{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.10-0/css/ionicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('Logo-Lambang-Jata-Selangor.ico') }}">

</head>

<body>
    <header class="py-3 mb-4 border-bottom">
        @include('layouts.navigation')
        <div class="container d-flex flex-wrap justify-content-center">
            <svg class="bi me-2" width="40" height="32">
                <use xlink:href="#bootstrap"></use>
            </svg>
            </a>
        </div>
        @yield('header') <!-- This will be filled by the specific page -->
    </header>

    <main>

        <!-- Add background class here -->
        <div class="min-h-screen bg-cover bg-center">
            @yield('content') <!-- Content section -->
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer bg-base-300 text-base-content p-4 flex justify-center items-center">
        <aside class="text-center">
            <p>Hak Cipta © {{ date('Y') }} - Pejabat Daerah Tanah Hulu Selangor</p>
        </aside>
    </footer>



    <!-- Add your JavaScript here -->
</body>

</html>
