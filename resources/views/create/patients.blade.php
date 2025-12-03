@extends('layouts.dashboard')

@section('title', 'Add Patient')

@section('content')
<div class="main-content">
    <h2 class="mb-4">Patient Registration</h2>

    <form id="patientForm" action="{{ route('patients.store') }}" method="POST">
        @csrf

        <!-- PERSONAL INFORMATION SECTION -->
        <div class="mb-4 p-3" style="background-color: white; border-radius: 8px;">
            <h4 class="text-success fw-bold mb-3">Personal Information</h4>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" id="first_name" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" id="middle_name" class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="last_name" id="last_name" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label for="suffix" class="form-label">Suffix</label>
                    <select name="suffix" id="suffix" class="form-control">
                        <option value="">-- Select --</option>
                        <option value="Jr.">Jr.</option>
                        <option value="Sr.">Sr.</option>
                        <option value="II">II</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                    <input type="date" name="dob" id="dob" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label for="age" class="form-label">Age <span class="text-danger">*</span></label>
                    <input type="text" name="age" id="age" class="form-control" required readonly>
                </div>
                <div class="col-md-3">
                    <label for="sex" class="form-label">Sex <span class="text-danger">*</span></label>
                    <select name="sex" id="sex" class="form-control" required>
                        <option value="">Select Sex</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                    <select name="gender" id="gender" class="form-control" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Transgender">Transgender</option>
                        <option value="Non-binary">Non-Binary</option>
                        <option value="Genderfluid">Genderfluid</option>
                        <option value="Cisgender">Cisgender</option>
                        <option value="Androgynous">Androgynous</option>
                        <option value="Prefer not to say">Prefer not to say</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- CONTACT DETAILS SECTION -->
        <div class="mb-4 p-3" style="background-color: white; border-radius: 8px;">
            <h4 class="text-success fw-bold mb-3">Contact Details</h4>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="contact_number" class="form-label">Contact Number <span class="text-danger">*</span></label>
                    <input type="text" name="contact_number" id="contact_number" class="form-control" placeholder="63..." required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                    <input type="text" name="address" id="address" class="form-control" required>
                </div>
            </div>
        </div>


       <!-- HEALTH INFORMATION SECTION -->
<div class="mb-4 p-3" style="background-color: white; border-radius: 8px;">
    <h4 class="text-success fw-bold mb-3">Health Information</h4>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="height" class="form-label">Height (cm) <span class="text-danger">*</span></label>
            <input type="number" name="height" id="height" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label for="Weight" class="form-label">Weight (kg) <span class="text-danger">*</span></label>
            <input type="number" name="Weight" id="weight" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label for="BMI" class="form-label">BMI <span class="text-danger">*</span></label>
            <input type="number" step="0.1" name="BMI" id="bmi" class="form-control" required readonly>
        </div>
        <div class="col-md-3">
            <label for="BMIStatus" class="form-label">BMI Indicator</label>
            <input type="text" name="BMIStatus" id="BMIStatus" class="form-control" readonly>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="bloodtype" class="form-label">Blood Type</label>
            <select name="bloodtype" id="bloodtype" class="form-control">
                <option value="">Select Blood Type</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
        </div>
    </div>
</div>

<!-- INSURANCE INFORMATION SECTION -->
<div class="mb-4 p-3" style="background-color: white; border-radius: 8px;">
    <h4 class="text-success fw-bold mb-3">Insurance Information</h4>
    <div class="row mb-3 align-items-center">
        <div class="col-md-6 mb-3 mb-md-0">
            <label for="insuranceDropdown" class="form-label">Insurance Provider <span class="text-danger">*</span></label>
            <div class="dropdown">
                <button class="btn btn-white border w-100 text-start dropdown-toggle" type="button" id="insuranceDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Select Insurance
                </button>
                <ul class="dropdown-menu w-100" aria-labelledby="insuranceDropdown">
                    <li><a class="dropdown-item" href="#" onclick="selectInsurance('PhilHealth')">PhilHealth</a></li>
                    <li><a class="dropdown-item" href="#" onclick="selectInsurance('Private Insurance')">Private Insurance</a></li>
                    <li><a class="dropdown-item" href="#" onclick="selectInsurance('None')">None</a></li>
                </ul>
            </div>
            <input type="hidden" name="insurance_provider" id="insuranceInput" required>
        </div>
        <div class="col-md-6">
            <label for="policy_number" class="form-label">Policy Number <span class="text-danger">*</span></label>
            <input type="text" name="policy_number" id="policy_number" class="form-control" required>
        </div>
    </div>
</div>

<!-- ACCOUNT INFORMATION SECTION -->
        <div class="mb-4 p-3" style="background-color: white; border-radius: 8px;">
            <h4 class="text-success fw-bold mb-3">Account Information</h4>
            <div class="row mb-3">
               <div class="col-md-6">
                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                <input type="text" name="username" id="username" class="form-control" required readonly>
            </div>

                <div class="col-md-6">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>
            </div>
        </div>

<!-- SUBMIT BUTTONS -->
<div class="text-end">
    <button type="submit" class="btn btn-success btn-lg">Register Patient</button>
    <button type="button" class="btn btn-secondary btn-lg ms-2" id="cancelBtn">Cancel</button>
</div>
</form>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session("success") }}',
        confirmButtonColor: '#28a745'
    }).then(() => {
        window.location.href = "{{ route('patients.index') }}"; // redirect after success
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops!',
        text: '{{ session("error") }}',
        confirmButtonColor: '#d33'
    });
</script>
@endif

</div>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function selectInsurance(name) {
        document.getElementById('insuranceInput').value = name;
        document.getElementById('insuranceDropdown').textContent = name;
    }

    function calculateBMI() {
        const heightCm = parseFloat(document.getElementById('height').value);
        const weightKg = parseFloat(document.getElementById('weight').value);
        if (heightCm > 0 && weightKg > 0) {
            const heightM = heightCm / 100;
            const bmi = weightKg / (heightM * heightM);
            document.getElementById('bmi').value = bmi.toFixed(1);

            let indicator = '';
            if (bmi < 18.5) indicator = 'Underweight';
            else if (bmi <= 24.9) indicator = 'Normal weight';
            else if (bmi <= 29.9) indicator = 'Overweight';
            else indicator = 'Obesity';

            document.getElementById('BMIStatus').value = indicator;
        } else {
            document.getElementById('bmi').value = '';
            document.getElementById('BMIStatus').value = '';
        }
    }

    document.getElementById('height').addEventListener('input', calculateBMI);
    document.getElementById('weight').addEventListener('input', calculateBMI);

    // Age in years
    document.getElementById('dob').addEventListener('change', function() {
        const dob = new Date(this.value);
        if (!isNaN(dob)) {
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const m = today.getMonth() - dob.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) { age--; }
            document.getElementById('age').value = age;
        } else { document.getElementById('age').value = ''; }
    });

    // Username generation
    function generateUsername() {
        const firstName = document.getElementById('first_name').value.trim();
        const lastName = document.getElementById('last_name').value.trim();
        const dob = document.getElementById('dob').value;
        if (firstName && lastName && dob) {
            const dobFormatted = dob.replaceAll('-', '');
            document.getElementById('username').value = firstName.charAt(0).toLowerCase() + lastName.toLowerCase() + dobFormatted;
        }
    }

    document.getElementById('first_name').addEventListener('input', generateUsername);
    document.getElementById('last_name').addEventListener('input', generateUsername);
    document.getElementById('dob').addEventListener('change', generateUsername);

    // Cancel
    document.getElementById('cancelBtn').addEventListener('click', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Your changes will not be saved!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel',
            cancelButtonText: 'No, stay'
        }).then((result) => { if (result.isConfirmed) window.location.href = "{{ route('patients.index') }}"; });
    });

    // Form submit
    document.getElementById('patientForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let valid = true;
        this.querySelectorAll('[required]').forEach(f => { if (!f.value) valid = false; });
        if (!valid) { Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please fill all required fields!' }); return; }

        Swal.fire({
            title: 'Register this patient?',
            text: "Please confirm to save the patient information.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save',
            cancelButtonText: 'Cancel'
        }).then((result) => { if (result.isConfirmed) e.target.submit(); });
    });
</script>
@endsection
