@extends('layouts.dashboard')

@section('title', 'Pharmacist Dashboard')

@section('content')


<!-- ✅ WELCOME BANNER -->
    <h1>Welcome, {{ $user->username ?? 'Guest' }}</h1>

 <div class="row mb-4">

    <!-- New Patients Card -->
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border border-success">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">New Patients</h6>
                    <h3 class="fw-bold">{{ $patients->count() }}</h3>
                </div>
                <span class="badge bg-success">+12%</span>
            </div>
        </div>
    </div>

    <!-- Prescriptions Card -->
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border border-warning">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Prescriptions</h6>
                    <h3 class="fw-bold">{{ $prescriptions->count() }}</h3>
                </div>
                <span class="badge bg-warning text-dark">+5%</span>
            </div>
        </div>
    </div>

    <!-- Medications Card -->
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm border border-info">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Medications</h6>
                    <h3 class="fw-bold">{{ $medications->count() }}</h3>
                </div>
                <span class="badge bg-info">+10%</span>
            </div>
        </div>
    </div>

</div>

<div class="row mb-4">

   <div class="row mb-4">

    <!-- Prescriptions Bar Chart -->
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm border border-warning h-90">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-muted">Prescriptions Active Per Month</h6>
                    <select id="prescriptionYear" class="form-select w-auto">
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" @if($year == $y) selected @endif>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex-grow-1">
                    <canvas id="prescriptionsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Medications Pie Chart -->
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm border border-info h-100 px">
            <div class="card-body d-flex flex-column" >
                <h6 class="text-muted mb-3">Medications Stock</h6>
                <div class="flex-grow-1 d-flex align-items-center justify-content-center" style=" width: 100%; height: 150px;">
                    <canvas id="medicationsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

</div>

{{-- Recents --}}
<div class="row mb-4">

    <!-- Recent Medications Table (Left) -->
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted mb-3">Recent Medications</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Stock</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medications->sortByDesc('created_at')->take(5) as $med)
                            <tr>
                                <td>{{ $med->name }}</td>
                                <td>{{ $med->stock }}</td>
                                <td>{{ $med->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Prescriptions Table (Right) -->
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted mb-3">Recent Prescriptions</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Medication</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prescriptions->sortByDesc('created_at')->take(5) as $pres)
                            <tr>
                                <td>{{ $pres->patient->first_name ?? 'N/A' }} {{ $pres->patient->last_name ?? '' }}</td>
                                <td>{{ $pres->doctor->first_name ?? 'N/A' }} {{ $pres->doctor->last_name ?? '' }}</td>
                                <td>{{ $pres->medication->name ?? 'N/A' }}</td>
                                <td>{{ $pres->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>



<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // -----------------------------
    // Prescriptions Bar Chart
    // -----------------------------
    const prescriptionsCtx = document.getElementById('prescriptionsChart').getContext('2d');
    let prescriptionsChart = new Chart(prescriptionsCtx, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
                label: 'Active Prescriptions',
                data: @json($prescriptionsPerMonth->values()),
                backgroundColor: 'rgba(255, 193, 7, 0.7)',
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Year filter change
    document.getElementById('prescriptionYear').addEventListener('change', function() {
        let year = this.value;
        fetch(`/dashboard/prescriptions/monthly?year=${year}`)
            .then(res => res.json())
            .then(data => {
                prescriptionsChart.data.datasets[0].data = data;
                prescriptionsChart.update();
            });
    });

    // -----------------------------
    // Medications Pie Chart
    // -----------------------------
    const medicationsCtx = document.getElementById('medicationsChart').getContext('2d');
    let medicationsChart = new Chart(medicationsCtx, {
        type: 'pie',
        data: {
            labels: @json($medicationsNames),
            datasets: [{
                label: 'Stock',
                data: @json($medicationsStock),
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(201, 203, 207, 0.7)'
                ],
                borderColor: 'white',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.raw}`;
                        }
                    }
                }
            }
        }
    });
</script>



    
@endsection
