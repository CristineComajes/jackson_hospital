<style>
    /* Green button */
    .btn-gradient {
        background-color: #28a745; /* normal bootstrap green */
        color: white;
        border: none;
    }

    .btn-gradient:hover {
        background-color: #218838; /* darker green on hover */
        color: white;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <div>
            <!-- Logo + Home Icon -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" height="50" alt="Logo" class="me-2">
            Jackson Hospital

            
        </a>
            <!-- ✅ Top Bar -->
        <div class="top-bar text-center">
            <div class="container d-flex justify-content-end">
                <div class="me-3"><i class="bi bi-telephone"></i> +63 (966) 350 5597 </div>
                <div class="me-3"><i class="bi bi-envelope"></i> jacksonhospital@gmail.com</div>
                <div><i class="bi bi-geo-alt"></i> Matina Pangi Rd, Talomo, Davao City</div>
            </div>
        </div>
        </div>
        
        <!-- ✅ Top Bar -->


        <!-- Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav"></div>

        <!-- Right Buttons -->
        <div class="d-flex ms-3">
            <a href="{{ route('home') }}">
                <i class="bi bi-house-door-fill me-2" style="font-size: 1.5rem; color: #28a745;"></i>
            </a>

            <a href="#find-doctor" class="btn btn-gradient me-2">
                <i class="bi bi-search me-1"></i> Find a Doctor
            </a>

            @guest
                <!-- Show Login if guest -->
                <a href="{{ route('login') }}" class="btn btn-gradient">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                </a>
            @else
                <!-- Show Logout if authenticated -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-gradient">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            @endguest

        </div>

    </div>
    
</nav>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
