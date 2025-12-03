@extends('layouts.dashboard')

@section('title', 'Doctor Dashboard')

@section('content')

<style>
    .main-content {
        margin-left: 210px;
        padding: 25px;
    }

    .card-box {
        border-radius: 8px;
        padding: 20px;
        color: white;
    }
    
</style>



<!-- MAIN DASHBOARD SCREEN -->
<div class="main-content">
    


    <!-- ✅ WELCOME BANNER -->
    <h1>Welcome, {{ $user->username ?? 'Guest' }}</h1>

    <!-- TOP CARDS -->
    <div class="row mb-4">

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">New Patients</h6>
                        <h3 class="fw-bold">{{ $patients->count() }}</h3>
                    </div>
                    <div>
                        <span class="badge bg-success">+12%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">Appointments</h6>
                        <h3 class="fw-bold">{{ $appointments->count() }}</h3>
                    </div>
                    <div>
                        <span class="badge bg-danger">-3%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">Prescriptions</h6>
                        <h3 class="fw-bold">{{ $prescriptions->count() }}</h3>
                    </div>
                    <div>
                        <span class="badge bg-warning text-dark">+5%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">Medications</h6>
                        <h3 class="fw-bold">{{ $medications->count() }}</h3>
                    </div>
                    <div>
                        <span class="badge bg-info">+10%</span>
                    </div>
                </div>
            </div>
        </div>

    </div>


<!-- YEAR FILTER -->
<div class="mb-4 d-flex align-items-center">
    <label for="yearFilter" class="me-2 fw-bold">Filter by Year:</label>
    <select id="yearFilter" class="form-select w-auto">
        @php
            $currentYear = date('Y');
        @endphp
        @for ($year = $currentYear; $year >= $currentYear - 5; $year--)
            <option value="{{ $year }}">{{ $year }}</option>
        @endfor
    </select>
</div>


    <!-- CHARTS SECTION -->
    <div class="row">

        <!-- TRAFFIC SOURCES CHART -->
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="mb-3">Appointment Trend</h5>
                    <canvas id="appointmentChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- DOUGHNUT CHART -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="mb-3">Prescription Completion</h5>
                    <canvas id="completionChart" width="200" height="200"></canvas>
                </div>
            </div>
        </div>

        

    </div>


    <!-- BOTTOM SUMMARY BOXES -->
    <div class="row">

        <div class="col-md-3 mb-3">
            <div class="card card-box bg-danger shadow-sm">
                <h6>Income Target</h6>
                <h3>71%</h3>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-box bg-success shadow-sm">
                <h6>Expenses Target</h6>
                <h3>54%</h3>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-box bg-warning shadow-sm">
                <h6>Spendings</h6>
                <h3>32%</h3>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-box bg-info shadow-sm">
                <h6>Totals</h6>
                <h3>89%</h3>
            </div>
        </div>

    </div>

</div>


<!-- CHART.JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- BAR + LINE CHART -->
<script>
    const ctx = document.getElementById('appointmentChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [
                {
                    label: 'Appointments',
                    data: [12, 19, 15, 22, 28, 20],
                    backgroundColor: 'rgba(30, 130, 76, 0.7)',
                    borderRadius: 5
                },
                {
                    label: 'Follow-ups',
                    data: [5, 10, 8, 13, 17, 12],
                    borderColor: '#1f8f6e',
                    borderWidth: 3,
                    fill: false,
                    type: 'line'
                }
            ]
        }
    });
</script>


<!-- DOUGHNUT CHART -->
<script>
    const donut = document.getElementById('completionChart');

    new Chart(donut, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'Pending'],
            datasets: [{
                data: [75, 25],
                backgroundColor: ['#2ecc71', '#ecf0f1']
            }]
        }
    });
</script>

@endsection
