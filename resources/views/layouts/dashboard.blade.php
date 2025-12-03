<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* ===========================
   BODY & BACKGROUND
=========================== */
body {
    overflow-x: hidden;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background: 
        linear-gradient(rgba(255,255,255,0.8), rgba(255,255,255,0.8)),
        url('{{ asset('images/hero.jpg') }}') no-repeat center center fixed;
    background-size: cover;
    transition: background-color 0.3s, color 0.3s;
}

body.dark-mode {
    background-color: #fff; /* keep body light */
    color: #000;
}


    .page-transition {
        opacity: 0;
        transform: translateY(10px);
        transition: opacity .5s ease, transform .5s ease;
    }
    .page-transition.show {
        opacity: 1;
        transform: translateY(0);
    }


/* ===========================
   DARK MODE GLOBAL STYLING
   (only sidebar and navbar)
=========================== */
body.dark-mode .sidebar {
    background-color: #000;
    color: #fff;
    box-shadow: none;
}

body.dark-mode .sidebar a {
    color: #fff;
}

body.dark-mode .sidebar a.active {
    background-color: rgba(0, 255, 0, 0.2);
}

body.dark-mode .navbar,
body.dark-mode .dropdown-menu {
    background-color: #000 !important;
}

body.dark-mode .dropdown-item {
    color: #fff !important;
}

/* ===========================
   SIDEBAR
=========================== */
.sidebar {
    width: 250px;
    background-color: #fff;
    color: #000;
    min-height: 100vh;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    transition: background-color 0.3s, color 0.3s;
}

.sidebar a {
    color: #000;
    text-decoration: none;
    margin-bottom: 0.5rem;
    transition: background-color 0.2s;
}

.sidebar a:hover {
    background-color: rgba(0,128,0,0.2);
    border-radius: 5px;
}

.sidebar a.active {
    background-color: rgba(0,128,0,0.1);
    border-radius: 5px;
}

.sidebar hr {
    border-color: rgba(0,0,0,0.1);
}

.sidebar img.logo {
    height: 40px;
    width: auto;
    margin-right: 0.5rem;
}

/* ===========================
   MAIN CONTENT
=========================== */
.page-content {
    flex-grow: 1;
    min-height: 100vh;
    padding: 2rem;
    border-radius: 10px;
    margin: 1rem;
    transition: background-color 0.3s, color 0.3s;
    position: relative;
}

/* ===========================
   MODAL
=========================== */


/* ===========================
   CARDS
=========================== */
.card {
    background-color: rgba(255,255,255,0.8);
    border-radius: 10px;
    padding: 1rem;
    margin-bottom: 1rem;
    transition: background-color 0.3s, color 0.3s;
}

/* Keep cards light in dark mode */
body.dark-mode .card {
    background-color: rgba(255,255,255,0.8);
    color: #000;
}

/* ===========================
   NAVBAR
=========================== */
.navbar, .dropdown-menu {
    background-color: #fff !important;
    transition: background-color 0.3s;
}

/* ===========================
   RESPONSIVE
=========================== */
@media (max-width: 768px) {
    .sidebar {
        width: 200px;
    }
    .page-content {
        margin: 0.5rem;
        padding: 1rem;
    }
}
</style>



</head>
<body>
 @include('partials.navbardash') <!-- Top navbar -->
<div class="d-flex">
    @include('partials.sidebar') <!-- white sidebar -->

    <div class="flex-grow-1 p-4">
        <div class="main-content">
            @yield('content')
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const modals = document.querySelectorAll('.modal');
const pageContent = document.querySelector('.page-content');

modals.forEach(modal => {
    modal.addEventListener('show.bs.modal', () => {
        pageContent.classList.add('modal-blur');
    });
    modal.addEventListener('hidden.bs.modal', () => {
        pageContent.classList.remove('modal-blur');
    });
});
</script>

</body>
</html>
