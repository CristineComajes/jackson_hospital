@extends('layouts.dashboard')

@section('title', 'Frontdesk Dashboard')

@section('content')
   
<!-- ✅ WELCOME BANNER -->
<h1>Welcome, {{ $user->username ?? 'Guest' }}</h1>

<!-- TOP CARDS -->
<div class="row mb-4">

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border border-success bg-white text-dark">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h6 class="text-dark">Appointments</h6>
                    <h3 class="fw-bold">{{ $appointments->count() }}</h3>
                </div>
                <div>
                    <span class="badge bg-success text-white">+5%</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border border-success bg-white text-dark">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h6 class="text-dark">Medications</h6>
                    <h3 class="fw-bold">{{ $medications->count() }}</h3>
                </div>
                <div>
                    <span class="badge bg-success text-white">+10%</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border border-success bg-white text-dark">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h6 class="text-dark">Doctors</h6>
                    <h3 class="fw-bold">{{ $doctors->count() }}</h3>
                </div>
                <div>
                    <span class="badge bg-success text-white">+5%</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border border-success bg-white text-dark">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <h6 class="text-dark">Patients</h6>
                    <h3 class="fw-bold">{{ $patients->count() }}</h3>
                </div>
                <div>
                    <span class="badge bg-success text-white">+6%</span>
                </div>
            </div>
        </div>
    </div>

</div>


<!-- YEAR FILTER -->
<div class="row mb-3">
    <div class="col-md-3">
        <label for="filterYear" class="form-label fw-bold">Select Year:</label>
        <select id="filterYear" class="form-select">
            @for($y = now()->year; $y >= 2020; $y--)
                <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
    </div>
</div>

<!-- CHARTS -->
<div class="row mb-4">
    <!-- Doughnut Chart: Appointment Status -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-1" style="height: 520px;">
                <h5 class="fw-bold mb-2">Appointments by Status</h5>
                <canvas id="statusDoughnutChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Line Chart: Appointments per Month -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-1">
                <h5 class="fw-bold mb-2">Appointments per Month</h5>
                <canvas id="appointmentsLineChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>


{{-- Top 5 new appointments --}}
@php
use Carbon\Carbon;
@endphp

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Latest Appointments</h5>
                <a href="{{ route('appointments.index') }}" class="btn btn-light btn-sm">View All</a>
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments->sortByDesc('created_at')->take(5) as $appt)
                                <tr>
                                    <td>{{ $appt->patient->first_name ?? 'N/A' }} {{ $appt->patient->last_name ?? '' }}</td>
                                    <td>{{ $appt->doctor->first_name ?? 'N/A' }} {{ $appt->doctor->last_name ?? '' }}</td>
                                    <td>{{ Carbon::parse($appt->appointment_date)->format('M d, Y') }}</td>
                                    <td>{{ Carbon::parse($appt->appointment_time)->format('h:i A') }}</td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'Pending' => 'bg-warning text-dark',
                                                'Approved' => 'bg-success text-white',
                                                'Cancelled' => 'bg-danger text-white',
                                            ];
                                        @endphp
                                        <span class="badge {{ $statusColors[$appt->status] ?? 'bg-secondary text-white' }}">
                                            {{ $appt->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                            @if($appointments->count() == 0)
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No appointments found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {

    // Prepare data from Blade
    let appointmentsStatus = @json($appointments->groupBy('status')->map->count());
    let appointmentsByMonth = @json($appointments->groupBy(function($appt) {
        return \Carbon\Carbon::parse($appt->appointment_date)->format('n'); // 1-12
    })->map->count());

    const statusColors = {
        'Pending': 'rgba(255, 216, 108, 0.9)',
        'Approved': 'rgba(10, 134, 21, 0.7)',
        'Cancelled': 'rgba(255, 99, 132, 0.7)'
    };

    // 🔵 Doughnut Chart
    const statusChart = new Chart(document.getElementById('statusDoughnutChart'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(appointmentsStatus),
            datasets: [{
                data: Object.values(appointmentsStatus),
                backgroundColor: Object.keys(appointmentsStatus).map(k => statusColors[k] || 'rgba(201,203,207,0.7)'),
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'left', labels: { font: { size: 12 } } }
            }
        }
    });

    // 🔵 Line Chart
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    const monthlyData = months.map((_, i) => appointmentsByMonth[i+1] || 0);

    const lineChart = new Chart(document.getElementById('appointmentsLineChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Appointments',
                data: monthlyData,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });

    // 🔹 Year filter: reload page with year query
    document.getElementById('filterYear').addEventListener('change', function() {
        const selectedYear = this.value;
        const url = new URL(window.location.href);
        url.searchParams.set('year', selectedYear);
        window.location.href = url.toString();
    });

});
</script>


@endsection
