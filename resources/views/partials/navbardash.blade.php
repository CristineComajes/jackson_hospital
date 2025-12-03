<!-- resources/views/partials/navbardash.blade.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">

        <!-- Sidebar toggle for smaller screens -->
        <button class="btn btn-outline-secondary me-2 d-lg-none" type="button" 
            data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" 
            aria-controls="sidebarOffcanvas">
            ☰
        </button>

        @php
            $user = session('user'); // or auth()->user()
            $dashboardRoute = match(strtolower($user->role ?? '')) {
                'admin' => 'dashboard.admin',
                'doctor' => 'dashboard.doctor',
                'patient' => 'dashboard.patient',
                'frontdesk' => 'dashboard.frontdesk',
                default => 'dashboard.index',
            };
        @endphp

        <!-- Brand / Dashboard Title -->
        <a class="navbar-brand fw-bold" href="{{ route($dashboardRoute) }}">Dashboard</a>

        <!-- Right Section -->
        <div class="d-flex ms-auto align-items-center">

            <!-- 🔔 NOTIFICATION BUTTON -->
            <div class="dropdown me-3">
                <button class="btn btn-light position-relative" id="notifDropdown" 
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell-fill"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        3
                    </span>
                </button>

                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notifDropdown" style="width: 260px;">
                    <li class="dropdown-header fw-bold">Notifications</li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item">New user registered</a></li>
                    <li><a class="dropdown-item">Backup completed</a></li>
                    <li><a class="dropdown-item">New appointment created</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a href="{{ route('notifications') }}" class="dropdown-item text-center text-primary">View all</a></li>
                </ul>
            </div>

            <!-- 🌗 DARK/LIGHT MODE TOGGLE -->
            <button id="themeToggle" class="btn btn-outline-primary me-3">
                <i class="bi bi-sun-fill" id="themeIcon"></i>
            </button>

        <!-- USER DROPDOWN -->
        <div class="dropdown">
            <a class="btn btn-light dropdown-toggle" href="#" id="userDropdown" 
            data-bs-toggle="dropdown" aria-expanded="false">
                {{ session('user')->name ?? auth()->user()->name ?? 'User' }}
            </a>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item" type="submit">Logout</button>
                    </form>
                </li>
            </ul>
        </div>


    </div>
</nav>

<!-- DARK MODE SCRIPT -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        let theme = localStorage.getItem("theme") || "light";
        const body = document.body;
        const themeToggle = document.getElementById("themeToggle");
        const themeIcon = document.getElementById("themeIcon");

        function applyTheme() {
            if (theme === "dark") {
                body.classList.add("dark-mode");
                themeIcon.classList.remove("bi-sun-fill");
                themeIcon.classList.add("bi-moon-stars-fill");
            } else {
                body.classList.remove("dark-mode");
                themeIcon.classList.remove("bi-moon-stars-fill");
                themeIcon.classList.add("bi-sun-fill");
            }
        }

        applyTheme();

        themeToggle.addEventListener("click", () => {
            theme = theme === "light" ? "dark" : "light";
            localStorage.setItem("theme", theme);
            applyTheme();
        });
    });
</script>
