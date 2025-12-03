@extends('layouts.dashboard')

@section('title', 'Add Prescription')

@section('content')
<div class="container-fluid py-4">

    <h1 class="h2 fw-bold text-success mb-4">Add New Prescription</h1>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $user = session('user'); // current logged-in user from session
        $userEmail = $user->email ?? '';
        $matchedPatient = $patients->firstWhere('email', $userEmail);
        $matchedDoctor = $doctors->firstWhere('email', $userEmail);
    @endphp

    <form action="{{ route('prescriptions.store') }}" method="POST" >
        @csrf

        <!-- Patient -->
        <div class="mb-3">
            <label class="form-label">Patient</label>
            @if($matchedPatient)
                <input type="text" class="form-control" value="{{ $matchedPatient->first_name }} {{ $matchedPatient->last_name }}" readonly>
                <input type="hidden" name="patient_id" value="{{ $matchedPatient->id }}">
            @else
                <select name="patient_id" class="form-select" required>
                    <option value="">Select Patient</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">
                            {{ $patient->first_name }} {{ $patient->last_name }}
                        </option>
                    @endforeach
                </select>
            @endif
        </div>

        <!-- Doctor -->
        <div class="mb-3">
            <label class="form-label">Doctor</label>
            @if($matchedDoctor)
                <input type="text" class="form-control" value="{{ $matchedDoctor->first_name }} {{ $matchedDoctor->last_name }}" readonly>
                <input type="hidden" name="doctor_id" value="{{ $matchedDoctor->id }}">
            @else
                <select name="doctor_id" class="form-select" required>
                    <option value="">Select Doctor</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">
                            {{ $doctor->first_name }} {{ $doctor->last_name }}
                        </option>
                    @endforeach
                </select>
            @endif
        </div>

        <!-- Medication -->
        <div class="mb-3">
            <label for="medication_id" class="form-label">Medication</label>
            <select name="medication_id" id="medication_id" class="form-select" required>
                <option value="">Select Medication</option>
                @foreach($medications as $medication)
                    <option value="{{ $medication->id }}">{{ $medication->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Dosage -->
        <div class="mb-3">
            <label for="dosage" class="form-label">Dosage</label>
            <input type="text" name="dosage" id="dosage" class="form-control" required>
        </div>

        <!-- Frequency -->
        <div class="mb-3">
            <label for="frequency" class="form-label">Frequency</label>
            <input type="text" name="frequency" id="frequency" class="form-control" required>
        </div>

        <!-- Route -->
        <div class="mb-3">
            <label for="route" class="form-label">Route</label>
            <select name="route" id="route" class="form-select" required>
                <option value="">Select Route</option>
                <option value="PO">Oral (PO)</option>
                <option value="IV">Intravenous (IV)</option>
                <option value="IM">Intramuscular (IM)</option>
                <option value="SC">Subcutaneous (SC)</option>
                <option value="Topical">Topical</option>
                <option value="INH">Inhalation (INH)</option>
                <option value="PR">Rectal (PR)</option>
                <option value="SL">Sublingual (SL)</option>
                <option value="OU">Ophthalmic (OU)</option>
                <option value="AU">Otic (AU)</option>
            </select>
        </div>


        <!-- Date Prescribed -->
        <div class="mb-3">
            <label for="date_prescribed" class="form-label">Date Prescribed</label>
            <input type="date" name="date_prescribed" id="date_prescribed" class="form-control" required>
        </div>

        <!-- Doctor Signature (optional) -->
        <div class="mb-3">
            <label for="doctor_signature" class="form-label">Doctor Signature (optional)</label>
            <input type="text" name="doctor_signature" id="doctor_signature" class="form-control" placeholder="Sign here">
        </div>

        <!-- Buttons -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Save Prescription</button>
            <button type="button" class="btn btn-primary" onclick="window.print()">Print</button>
        </div>
    </form>
</div>

<!-- Include SweetAlert2 via CDN -->
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


@endsection
