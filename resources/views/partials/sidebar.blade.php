<style>
/* Sidebar background color */
.sidebar {
    height: 100vh;
    background: #0a4d2c; /* dark green */
    color: white;
    position: fixed;
    top: 0;
    left: 0;
    width: 230px;
    padding-top: 20px;
}

.sidebar a {
    display: block;
    padding: 12px 20px;
    color: #d8e9dfff;
    text-decoration: none;
    font-weight: 500;
}

.sidebar a:hover {
    background: #4bb830ff;
    color: white;
}

/* Active sidebar link */
.sidebar a.active {
    background: #196b05ff;
    color: white;
}

.main-content {
    margin-left: 240px;
    padding: 25px;
}

.card-box {
    border-radius: 8px;
    padding: 20px;
    color: white;
}
</style>

<div class="sidebar">
    <hr>
    <ul class="nav flex-column mb-auto">

        @php
            $user = session('user'); // or auth()->user()
        @endphp

        <!-- Dashboard -->
        @php
            $dashboardRoute = match(strtolower($user->role ?? '')) {
                'admin' => 'dashboard.admin',
                'doctor' => 'dashboard.doctor',
                'pharmacist' => 'dashboard.pharmacist',
                'frontdesk' => 'dashboard.frontdesk',
                'patient' => 'dashboard.patient',
                default => 'dashboard.index',
            };
        @endphp
        <li>
            <a href="{{ route($dashboardRoute) }}" class="nav-link {{ request()->routeIs($dashboardRoute) ? 'active' : '' }}">
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
        </li>

        {{-- Admin sees everything --}}
        @if($user->role === 'admin' || $user->role === 'doctor' || $user->role === 'patient')
        <!-- Doctors -->
        <li>
            <a href="{{ route('contents.doctors') }}" class="nav-link {{ request()->routeIs('contents.doctors') ? 'active' : '' }}">
                <i class="bi bi-person-lines-fill me-2"></i> Doctors
            </a>
        </li>
        @endif

        @if(in_array($user->role, ['admin','doctor','pharmacist','frontdesk']))
        <!-- Patients -->
        <li>
            <a href="{{ route('contents.patients') }}" class="nav-link {{ request()->routeIs('contents.patients') ? 'active' : '' }}">
                <i class="bi bi-person-lines-fill me-2"></i> Patients
            </a>
        </li>
        @endif

        @if(in_array($user->role, ['admin','doctor','frontdesk','patient']))
        <!-- Appointments -->
        <li>
            <a href="{{ route('contents.appointments') }}" class="nav-link {{ request()->routeIs('contents.appointments') ? 'active' : '' }}">
                <i class="bi bi-calendar-check me-2"></i> Appointments
            </a>
        </li>
        @endif

        @if(in_array($user->role, ['admin','doctor','pharmacist']))
        <!-- Prescriptions -->
        <li>
            <a href="{{ route('contents.prescriptions') }}" class="nav-link {{ request()->routeIs('contents.prescriptions') ? 'active' : '' }}">
                <i class="bi bi-journal-medical me-2"></i> Prescriptions
            </a>
        </li>
        @endif

        @if(in_array($user->role, ['admin','doctor','pharmacist']))
        <!-- Medications -->
        <li>
            <a href="{{ route('contents.medications') }}" class="nav-link {{ request()->routeIs('contents.medications') ? 'active' : '' }}">
                <i class="bi bi-capsule me-2"></i> Medications
            </a>
        </li>
        @endif

        @if(in_array($user->role, ['admin','doctor','pharmacist','frontdesk','patient']))
        <!-- History -->
        <li>
            <a href="{{ route('contents.history') }}" class="nav-link {{ request()->routeIs('contents.history') ? 'active' : '' }}">
                <i class="bi bi-clock-history me-2"></i> History
            </a>
        </li>
        @endif

        <!-- Logout -->
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-link nav-link text-start" type="submit">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </form>
        </li>
    </ul>
    <hr>
</div>
