@extends('layouts.dashboard')

@section('title', 'Upcoming Appointments')

@section('content')



<div class="container-fluid py-4">

        <!-- Header Row -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 fw-bold text-success">Upcoming Appointments</h1>

            <!-- New Appointment Button -->
            <a href="#" class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#scheduleAppointmentModal">
                <i class="bi bi-plus-circle me-1"></i> Add Appointment
            </a>
        </div>

        <p class="mb-4 text-muted">
            Review and manage all scheduled patient appointments.
        </p>

        <!-- Search & Filter Row -->
        <div class="d-flex mb-4 align-items-center" style="gap: 1rem; flex-wrap: wrap; max-width: 500px;">
            <!-- Search Bar -->
            <form action="{{ route('appointments.index') }}" method="GET" class="d-flex flex-grow-1">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control"
                    placeholder="Search appointments by patient, date, or status..."
                    value="{{ request('search') }}"
                >
                <button class="btn btn-success ms-2">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <!-- Status Filter -->
            <form action="{{ route('appointments.index') }}" method="GET">
                <select name="status_filter" class="form-select" onchange="this.form.submit()">
                    <option value="" {{ request('status_filter') == '' ? 'selected' : '' }}>All Status</option>
                    <option value="Pending" {{ request('status_filter') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Approved" {{ request('status_filter') == 'Approved' ? 'selected' : '' }}>Approved</option>
                    <option value="Completed" {{ request('status_filter') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Cancelled" {{ request('status_filter') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </form>
        </div>



        <!-- Appointments Table -->
        <div class="card shadow-lg mb-4 rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-success text-white">
                            <tr>
                                <th class="py-3 px-4">Patient</th>
                                <th class="py-3">Date</th>
                                <th class="py-3">Time</th>
                                <th class="py-3">Status</th>
                                <th class="py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appointments as $appointment)
                            <tr class="align-middle">
                                <td class="px-4">
                                    <i class="bi bi-person-fill me-2 text-success"></i>
                                    {{ $appointment->patient->first_name ?? 'N/A' }} {{ $appointment->patient->last_name ?? '' }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                                <td>
                                    <span class="badge text-white px-3 py-2 rounded-pill 
                                        @if($appointment->status == 'Pending') bg-warning 
                                        @elseif($appointment->status == 'Approved') bg-success
                                        @elseif($appointment->status == 'Completed') bg-info
                                        @else bg-secondary
                                        @endif">
                                        {{ $appointment->status }}
                                    </span>
                                </td>
                                <td>
                                    {{-- Manage Button --}}
                                    <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#manageModal{{ $appointment->id }}">
                                        <i class="bi bi-three-dots"></i> Manage
                                    </button>
                    <!-- Manage Modal -->
                    <div class="modal fade" id="manageModal{{ $appointment->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('appointments.manage', $appointment->id) }}" method="POST">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Manage Appointment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select name="status" class="form-select" required>
                                                <option value="" disabled selected>-- Choose Status --</option>
                                                <option value="Approved">Approve</option>
                                                <option value="Cancelled">Cancel</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="remarks" class="form-label">Remarks</label>
                                            <textarea name="remarks" class="form-control" required>{{ old('remarks', $appointment->remarks) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Save</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted fst-italic">
                                    <i class="bi bi-calendar-x me-2"></i> No upcoming appointments found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal for Adding Appointment -->
<div class="modal fade" id="scheduleAppointmentModal" tabindex="-1" aria-labelledby="scheduleAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="scheduleAppointmentModalLabel">
                    <i class="bi bi-calendar-plus me-2"></i> Schedule New Appointment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form Start -->
            <form action="{{ route('appointments.store') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <!-- Patient Selection -->
                    <div class="mb-3">
                        <label for="patient_id" class="form-label">Select Patient</label>
                        <select name="patient_id" id="patient_id" class="form-select" required>
                            <option value="" disabled selected>-- Choose Patient --</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">
                                    {{ $patient->first_name }} {{ $patient->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Appointment Date -->
                    <div class="mb-3">
                        <label for="appointment_date" class="form-label">Date</label>
                        <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>
                    </div>

                    <!-- Appointment Time -->
                    <div class="mb-3">
                        <label for="appointment_time" class="form-label">Time</label>
                        <input type="time" name="appointment_time" id="appointment_time" class="form-control" required>
                    </div>
                    
                    {{-- Appointment Services --}}
                    <div class="mb-3">
                        <label for="services" class="form-label">Services</label>
                        <select name="services" id="services" class="form-select" required>
                            <option value="" disabled selected>-- Choose Service --</option>
                            <option value="Check-up">General Check-up</option>
                            <option value="Consultation">Consultation</option>
                            <option value="Surgery">Office Visit</option>
                            <option value="Surgery">Follow Up</option>
                            <option value="Surgery">Outpatient Stay</option>
                            <option value="Surgery">Inpatient Stay</option>
                            <option value="Surgery">Prescription Pick Up</option>
                        </select>
                    </div>

                    {{-- Preferred Doctor --}}
                    <div class="mb-3">
                        <label for="doctor_id" class="form-label">Preferred Doctor</label>
                        <select name="doctor_id" id="doctor_id" class="form-select" required>
                            <option value="" disabled selected>-- Choose Doctor --</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->first_name }} {{ $doctor->last_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Reason for Appointment -->
                    <div>
                        <label for="appointment_Remarks" class="form-label"> Remarks </label>
                        <textarea name="remarks" id="remarks" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="Pending">Pending</option>
                            <option value="Approved">Approved</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Appointment</button>
                </div>
            </form>
            <!-- Form End -->

        </div>
    </div>
</div>

<script>
function showTab(tabId) {
    const tabs = document.querySelectorAll('.tab-content');
    tabs.forEach(tab => tab.style.display = 'none');
    document.getElementById(tabId).style.display = 'block';

    
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ session('error') }}",
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK'
        });
    @endif
});
</script>



@endsection
