<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jackson Hospital</title>

    <!-- Bootstrap CSS (via CDN or local asset) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome (for icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    
</head>
<body>

    <!-- ===========================
         Navbar (Optional Global)
    ============================ -->
    @include('partials.navbar') <!-- Create this file if you want reusable nav -->

    <!-- ===========================
         Main Content
    ============================ -->
    <main class="py-4">
        @yield('content') <!-- This is where child views inject their content -->
    </main>

    <!-- ===========================
         Footer (Optional Global)
    ============================ -->
    @include('partials.footer') <!-- Create this file if you want reusable footer -->

    <!-- Bootstrap JS (via CDN or local asset) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
