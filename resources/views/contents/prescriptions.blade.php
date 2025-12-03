@extends('layouts.dashboard')

@section('title', 'Prescription Dashboard')

@section('content')
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold text-success">Prescription Dashboard</h1>
        <a href="{{ route('prescriptions.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i> Add Prescription
        </a>
    </div>

        <!-- Search & Filter Row -->
        <div class="d-flex mb-4 align-items-center" style="gap: 1rem; flex-wrap: wrap; max-width: 500px;">
            <!-- Search Bar -->
            <form action="{{ route('contents.prescriptions') }}" method="GET" class="d-flex flex-grow-1">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control"
                    placeholder="Search prescriptions by patient, doctor, medication, or status..."
                    value="{{ request('search') }}"
                >
                <button class="btn btn-success ms-2">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>



 <!-- Recent Prescriptions Table -->
<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Recent Prescriptions</h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0" id="prescriptionsTable">
            <thead class="table-light">
                <tr>
                    <th>Patient Name</th>
                    <th>Doctor</th>
                    <th>Medication</th>
                    <th>Frequency</th>
                    <th>Route</th>
                    <th>Date Requested</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prescriptions as $prescription)
                    <tr>
                        <td>{{ $prescription->patient->first_name ?? '' }} {{ $prescription->patient->last_name ?? '' }}</td>
                        <td>{{ $prescription->doctor->first_name ?? '' }} {{ $prescription->doctor->last_name ?? '' }}</td>
                        <td>{{ $prescription->medication->name ?? '' }}</td>
                        <td>{{ $prescription->frequency }}</td>
                        <td>{{ $prescription->route }}</td>
                        <td>{{ $prescription->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('prescriptions.edit', $prescription->id) }}" class="btn btn-sm btn-warning">
                                Edit
                            </a>
                            <button onclick="window.open('{{ route('contents.prescriptions.show', $prescription->id) }}','_blank')" class="btn btn-sm btn-primary">
                                Print
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No prescriptions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif
@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif

<!-- Table Search Script -->
<script>
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('prescriptionsTable').getElementsByTagName('tbody')[0];

    searchInput.addEventListener('keyup', function() {
        const filter = searchInput.value.toLowerCase();
        Array.from(table.rows).forEach(row => {
            const rowText = row.innerText.toLowerCase();
            row.style.display = rowText.includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection
