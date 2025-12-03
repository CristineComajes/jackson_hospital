@extends('layouts.app')

@section('title', 'Login')

@section('content')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

@if($errors->any())
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        html: '{!! implode("<br>", $errors->all()) !!}',
        confirmButtonColor: '#d33'
    });
</script>
@endif

@if(session('error'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session("error") }}',
        confirmButtonColor: '#d33'
    });
</script>
@endif

@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session("success") }}',
        confirmButtonColor: '#198754'
    });
</script>
@endif

<!-- ✅ Full Background Carousel -->
<div id="hospitalCarousel" class="carousel slide position-fixed top-0 start-0 w-100 h-100" data-bs-ride="carousel">
    <div class="carousel-inner h-100">
        <div class="carousel-item active h-100">
            <img src="{{ asset('images/hero.jpg') }}" class="d-block w-100 h-100 object-fit-cover" alt="Hospital 1">
        </div>
        <div class="carousel-item h-100">
            <img src="{{ asset('images/hero1.jpg') }}" class="d-block w-100 h-100 object-fit-cover" alt="Hospital 2">
        </div>
        <div class="carousel-item h-100">
            <img src="{{ asset('images/hero2.jpg') }}" class="d-block w-100 h-100 object-fit-cover" alt="Hospital 3">
        </div>
    </div>
</div>

<!-- ✅ Dark overlay for readability -->
<div class="position-fixed top-0 start-0 w-100 h-100" style="background-color: rgba(0,0,0,0.5);"></div>

<!-- ✅ Login Section -->
<section class="login-section d-flex align-items-center justify-content-center vh-100 position-relative">
    <div class="card shadow-lg p-4 border-0" style="max-width: 400px; width: 100%; backdrop-filter: blur(8px); background-color: rgba(255,255,255,0.9);">
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" height="50">
            <h4 class="mt-2 text-success">Welcome Back</h4>
            <p class="text-muted small">Log in to access your dashboard</p>
        </div>

        <form method="POST" action="{{ route('auth.login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" id="email" class="form-control" required autofocus>
                @error('email')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <a href="#" class="text-decoration-none text-success small">Forgot password?</a>
            </div>

            <button type="submit" class="btn btn-success w-100">Login</button>
        </form>

        <div class="text-center mt-4">
            <p class="small">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-success text-decoration-none">Sign up</a>
            </p>
            <p class="small mt-2">
                <a href="{{ route('home') }}" class="text-decoration-none text-primary">&larr; Back to Homepage</a>
            </p>
        </div>
    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- ✅ SweetAlert for Login Errors -->
@if(session('error'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Login Failed',
        text: '{{ session("error") }}',
        confirmButtonText: 'OK'
    });
</script>
@endif

@endsection
