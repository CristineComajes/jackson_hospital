@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')

@section('content')

<!-- ✅ WELCOME BANNER -->
<h1>Welcome, {{ $user->username ?? 'Guest' }}</h1>

<!-- TOP CARDS -->
<div class="row mb-4">


   

    <div class="col-md-3 mb-3">
    <div class="card shadow-sm border-0 bg-success text-white">
        <div class="card-body d-flex justify-content-between">
            <div>
                <h6 class="text-white">Prescriptions</h6>
                <h3 class="fw-bold">{{ $prescriptions->count() }}</h3>
            </div>
            <div>
                <span class="badge bg-dark text-white">+5%</span>
            </div>
        </div>
    </div>
</div>



   <div class="col-md-3 mb-3">
    <div class="card shadow-sm border-0 bg-danger text-white">
        <div class="card-body d-flex justify-content-between">
            <div>
                <h6 class="text-white">Medications</h6>
                <h3 class="fw-bold">{{ $medications->count() }}</h3>
            </div>
            <div>
                <span class="badge bg-dark text-white">+10%</span>
            </div>
        </div>
    </div>
</div>

<div class="col-md-3 mb-3">
    <div class="card shadow-sm border-0 bg-warning text-dark">
        <div class="card-body d-flex justify-content-between">
            <div>
                <h6 class="text-dark">Doctors</h6>
                <h3 class="fw-bold">{{ $doctors->count() }}</h3>
            </div>
            <div>
                <span class="badge bg-dark text-white">+5%</span>
            </div>
        </div>
    </div>
</div>


   <div class="col-md-3 mb-3">
    <div class="card shadow-sm border-0 bg-primary text-white">
        <div class="card-body d-flex justify-content-between">
            <div>
                <h6 class="text-white">Total Users</h6>
                <h3 class="fw-bold">{{ $users->count() }}</h3>
            </div>
            <div>
                <span class="badge bg-dark text-white">+5%</span>
            </div>
        </div>
    </div>
</div>



<!-- YEAR FILTER -->
<form method="GET" class="mb-3">
    <label for="year" class="form-label fw-bold">Select Year:</label>
    <select name="year" id="year" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
        @for($y = date('Y'); $y >= date('Y') - 5; $y--)
            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
        @endfor
    </select>
</form>

<div class="row">
    <!-- Bar Chart: Patients per Month -->
    <div class="col-md-6">
        <div class="card shadow-sm mb-3">
            <div class="card-body" style="padding: 0.5rem; height: 350px;">
                <h5 class="fw-bold mb-2" style="font-size: 0.8rem;">Patients Per Month ({{ $year }})</h5>
                <canvas id="patientsPerMonthChart"></canvas>
            </div>
        </div>
    </div>

    

    <!-- Polar Area Chart: Patients by Place -->
    <div class="col-md-6">
        <div class="card shadow-sm mb-3">
            <div class="card-body" style="padding: 0.5rem; height: 350px;">
                <h5 class="fw-bold mb-2" style="font-size: 0.8rem;">Patients Across Places ({{ $year }})</h5>
                <canvas id="patientsByPlaceChart"></canvas>
            </div>
        </div>
    </div>
</div>
{{-- New Users --}}
@php
$roleColors = [
    'admin' => 'bg-danger',
    'doctor' => 'bg-success',
    'patient' => 'bg-info',
    'frontdesk' => 'bg-warning text-dark',
    'pharmacist' => 'bg-secondary'
];
@endphp

<h4 class="mt-4 mb-3">New Users</h4>

<div class="card shadow-sm mb-4">
    <div class="card-body p-3">
        <table class="table table-sm table-hover mb-0">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Created</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users->sortByDesc('created_at')->take(5) as $newUser)
                <tr>
                    <td>{{ $newUser->username }}</td>
                    <td>{{ $newUser->created_at->diffForHumans() }}</td>
                    <td>
                        <span class="badge {{ $roleColors[$newUser->role] ?? 'bg-primary' }}">
                            {{ ucfirst($newUser->role) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {

    // Bar Chart: Patients per Month
    new Chart(document.getElementById('patientsPerMonthChart'), {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
                label: "Patients",
                data: @json($patientsPerMonth->values()),
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 14 } } },
                x: { ticks: { font: { size: 14 } } }
            },
            plugins: { legend: { display: false } }
        }
    });

    // Polar Area Chart: Patients by Place
    new Chart(document.getElementById('patientsByPlaceChart'), {
        type: 'polarArea',
        data: {
            labels: @json($patientsByPlace->keys()),
            datasets: [{
                label: "Patients",
                data: @json($patientsByPlace->values()),
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ],
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'left', labels: { font: { size: 14 } } } }
        }
    });

});
</script>

@endsection
