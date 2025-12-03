@extends('layouts.dashboard')

@section('title', 'Patients Directory')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold text-success">Hospital Patient Directory</h1>

        <a href="{{ route('create.patients') }}" id="addPatientBtn" class="btn btn-success shadow-sm ms-3">
            <i class="bi bi-plus-circle me-1"></i> Add Patient
        </a>
    </div>

    <p class="mb-4 text-muted">
        This page lists all registered patients in the system.
    </p>

    <div>
         <!-- 🔍 SEARCH BAR ADDED HERE -->
        <form action="{{ route('patients.index') }}" method="GET" class="d-flex" style="width: 350px;">
            <input type="text" name="search" class="form-control"
                   placeholder="Search patient..."
                   value="{{ request('search') }}">
            <button class="btn btn-success ms-2"><i class="bi bi-search"></i></button>
        </form>
        <!-- END SEARCH BAR -->

</div>
<br>
    <!-- Patients Table -->
    <div class="card shadow-lg mb-4 rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-success text-white">
                        <tr>
                            <th class="py-3 px-4">Name</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Contact</th>
                            <th class="py-3">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($patients as $patient)
                            <tr class="align-middle">
                                <td class="px-4">
                                    <i class="bi bi-person-fill me-2 text-success"></i>
                                    {{ $patient->first_name }} {{ $patient->last_name }}
                                </td>
                                <td>{{ $patient->email }}</td>
                                <td>{{ $patient->contact_number ?? 'N/A' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1" title="View Record" 
                                        onclick="showCard({{ $patient->id }}, false)">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <button class="btn btn-sm btn-outline-success" title="Edit Record" 
                                        onclick="showCard({{ $patient->id }}, true)">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-secondary fst-italic">
                                    <i class="bi bi-person-x me-2"></i> No patient records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    @if(method_exists($patients, 'links'))
        <div class="mt-3">
            {{ $patients->links() }}
        </div>
    @endif

</div>

{{-- Overlay --}}
<div id="overlay" onclick="hideCardAll()" style="display:none;"></div>

{{-- Pop-out Cards --}}
@foreach($patients as $patient)
<div id="card{{ $patient->id }}" class="popout-card shadow-lg border border-success" style="display:none;">
    <div class="d-flex justify-content-between align-items-start border-bottom pb-2 mb-2">
        <h5 class="fw-bold">{{ $patient->first_name }} {{ $patient->last_name }}'s Record</h5>
        <button onclick="hideCard({{ $patient->id }})" class="btn btn-sm btn-outline-secondary">&times;</button>
    </div>

    {{-- View Mode --}}
    <div class="view-mode" id="view{{ $patient->id }}">
        <div class="row">
            <div class="col-md-6 mb-2"><strong>Full Name:</strong> {{ $patient->first_name }} {{ $patient->middle_name }} {{ $patient->last_name }}</div>
            <div class="col-md-6 mb-2"><strong>Email:</strong> {{ $patient->email }}</div>
            <div class="col-md-6 mb-2"><strong>Contact Number:</strong> {{ $patient->contact_number ?? 'N/A' }}</div>
            <div class="col-md-6 mb-2"><strong>Address:</strong> {{ $patient->address }}</div>
            <div class="col-md-6 mb-2"><strong>Date of Birth:</strong> {{ $patient->dob }}</div>
            <div class="col-md-6 mb-2"><strong>Age:</strong> {{ $patient->age }}</div>
            <div class="col-md-6 mb-2"><strong>Gender:</strong> {{ $patient->gender }}</div>
            <div class="col-md-6 mb-2"><strong>Blood Type:</strong> {{ $patient->bloodtype }}</div>
            <div class="col-md-6 mb-2"><strong>Weight:</strong> {{ $patient->Weight }} kg</div>
            <div class="col-md-6 mb-2"><strong>BMI:</strong> {{ $patient->BMI }}</div>
            <div class="col-md-6 mb-2"><strong>BMI Status:</strong> {{ $patient->BMIStatus }}</div>
            <div class="col-12 mb-2"><strong>Health Notes:</strong> {{ $patient->health }}</div>
            <div class="col-md-6 mb-2"><strong>Insurance Provider:</strong> {{ $patient->insurance_provider }}</div>
            <div class="col-md-6 mb-2"><strong>Policy Number:</strong> {{ $patient->policy_number }}</div>
        </div>

        <div class="mt-3 d-flex justify-content-end">
            <button class="btn btn-success" onclick="toggleEdit({{ $patient->id }})">Edit</button>
            <button class="btn btn-secondary ms-2" onclick="hideCard({{ $patient->id }})">Close</button>
        </div>
    </div>

    {{-- Edit Mode --}}
    <div class="edit-mode" id="edit{{ $patient->id }}" style="display:none;">
        <form method="POST" action="{{ route('patients.update', $patient->id) }}">
            @csrf
            @method('PUT')

            <div class="card shadow border border-success p-4 bg-light edit-card">
                <h5 class="fw-bold text-success mb-4">Update Patient Information</h5>

                <div class="row">
                    {{-- Personal Info --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-success">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $patient->first_name) }}" class="form-control border-success" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-success">Middle Name</label>
                        <input type="text" name="middle_name" value="{{ old('middle_name', $patient->middle_name) }}" class="form-control border-success">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-success">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $patient->last_name) }}" class="form-control border-success" required>
                    </div>
                   <div class="col-md-6 mb-3">
                    <label for="suffix" class="form-label">Suffix</label>
                    <select name="suffix" id="suffix" class="form-control">
                        <option value="">-- Select --</option>
                        <option value="Jr." {{ old('suffix', $patient->suffix) == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                        <option value="Sr." {{ old('suffix', $patient->suffix) == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                        <option value="II" {{ old('suffix', $patient->suffix) == 'II' ? 'selected' : '' }}>II</option>
                        <option value="III" {{ old('suffix', $patient->suffix) == 'III' ? 'selected' : '' }}>III</option>
                        <option value="IV" {{ old('suffix', $patient->suffix) == 'IV' ? 'selected' : '' }}>IV</option>
                    </select>
                </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label text-success">Date of Birth</label>
                        <input type="date" name="dob" value="{{ old('dob', \Carbon\Carbon::parse($patient->dob)->format('Y-m-d')) }}" class="form-control border-success" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-success">Age</label>
                        <input type="text" name="age" value="{{ $patient->age }}" class="form-control border-success" readonly>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-success">Gender</label>
                        <select name="gender" class="form-select border-success">
                            <option value="Male" {{ $patient->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $patient->gender == 'Female' ? 'selected' : '' }}>Female</option>

                        <option value="Transgender" {{ $patient->gender == 'Transgender' ? 'selected' : '' }}>Transgender</option>
                        <option value="Non-binary" {{ $patient->gender == 'Non-binary' ? 'selected' : '' }}>Non-Binary</option>
                        <option value="Genderfluid" {{ $patient->gender == 'Genderfluid' ? 'selected' : '' }}>Genderfluid</option>
                        <option value="Cisgender" {{ $patient->gender == 'Cisgender' ? 'selected' : '' }}>Cisgender</option>
                        <option value="Androgynous">Androgynous</option>
                        <option value="Prefer not to say">Prefer not to say</option>
                       
                       
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-success">Sex</label>
                        <select name="sex" class="form-select border-success">
                            <option value="M" {{ $patient->sex == 'M' ? 'selected' : '' }}>M</option>
                            <option value="F" {{ $patient->sex == 'F' ? 'selected' : '' }}>F</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-success">Blood Type</label>
                     <select name="bloodtype" id="bloodtype" class="form-control">
                        <option value="">Select Blood Type</option>
                        <option value="A+" {{ $patient->bloodtype == 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="A-" {{ $patient->bloodtype == 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B+" {{ $patient->bloodtype == 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="B-" {{ $patient->bloodtype == 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="AB+" {{ $patient->bloodtype == 'AB+' ? 'selected' : '' }}>AB+</option>
                        <option value="AB-" {{ $patient->bloodtype == 'AB-' ? 'selected' : '' }}>AB-</option>
                        <option value="O+" {{ $patient->bloodtype == 'O+' ? 'selected' : '' }}>O+</option>
                        <option value="O-" {{ $patient->bloodtype == 'O-' ? 'selected' : '' }}>O-</option>
                        <option value="Unknown" {{ $patient->bloodtype == 'Unknown' ? 'selected' : '' }}>Unknown</option>
            </select>
                    </div>

                    {{-- Contact Info --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-success">Contact Number</label>
                        <input type="text" name="contact_number" value="{{ $patient->contact_number }}" class="form-control border-success">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-success">Email</label>
                        <input type="email" name="email" value="{{ $patient->email }}" class="form-control border-success">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-success">Address</label>
                        <input type="text" name="address" value="{{ $patient->address }}" class="form-control border-success">
                    </div>

                    {{-- Health Info --}}

                            <div class="col-md-4 mb-3">
                    <label class="form-label text-success">Weight (kg)</label>
                    <input type="number" name="Weight" value="{{ $patient->Weight }}" class="form-control border-success">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label text-success">Height (cm)</label>
                    <input type="number" name="Height" value="{{ $patient->height }}" class="form-control border-success">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label text-success">BMI</label>
                    <input type="number" name="BMI" value="{{ $patient->BMI }}" class="form-control border-success" readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label text-success">BMI Status</label>
                    <input type="text" name="BMIStatus" value="{{ $patient->BMIStatus }}" class="form-control border-success" readonly>
                </div>

                    <div class="col-12 mb-3">
                        <label class="form-label text-success">Health Notes</label>
                        <textarea name="health" class="form-control border-success" rows="3">{{ $patient->health }}</textarea>
                    </div>

                    {{-- Insurance Info --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-success">Insurance Provider</label>
                        <input type="text" name="insurance_provider" value="{{ $patient->insurance_provider }}" class="form-control border-success">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-success">Policy Number</label>
                        <input type="text" name="policy_number" value="{{ $patient->policy_number }}" class="form-control border-success">
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-success me-2">Update Patient</button>
                    <button type="button" class="btn btn-secondary" onclick="cancelEdit({{ $patient->id }})">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach


<style>
#overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(4px);
    background-color: rgba(0,0,0,0.2);
    z-index: 1040;
}

.popout-card {
    position: fixed;
    top: 5%;
    left: 50%;
    transform: translateX(-50%);
    width: 95%;          /* big width */
    max-width: 1200px;   /* maximum width */
    max-height: 90vh;    /* scrollable if content is big */
    overflow-y: auto;
    background-color: #e6f5ea; /* light green background */
    border-radius: 0.75rem;
    z-index: 1050;
    padding: 1.5rem;
}

.edit-mode .edit-card {
    width: 90%;           /* bigger width */
    max-width: 1000px;    /* maximum width */
    height: auto;
    max-height: 90vh;     /* fit in viewport */
    overflow-y: auto;
    background-color: #e6f5ea; /* light green */
    border-radius: 0.75rem;
}
.edit-mode .form-control, .edit-mode .form-select, .edit-mode textarea {
    background-color: #fff;
}
.edit-mode .form-label {
    font-weight: 500;
}
@media (max-width: 768px) {
    .edit-mode .edit-card {
        width: 95%;
    }
}
</style>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('addPatientBtn').addEventListener('click', function(e) {
        e.preventDefault(); // prevent default navigation

        Swal.fire({
            title: 'Patient Registration Policy',
            html: `
                <p>Please read the following policy before continuing:</p>
                <ul style="text-align: left;">
                    <li>All patient information must be accurate and complete.</li>
                    <li>Health information is confidential and protected under HIPAA.</li>
                    <li>Patients must provide consent for medical record storage.</li>
                    <li>Insurance details must be valid and current.</li>
                </ul>
            `,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Agree',
            cancelButtonText: 'Cancel',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('create.patients') }}";
            }
        });
    });
});

function showCard(id, edit=false) {
    document.getElementById('overlay').style.display = 'block';
    const card = document.getElementById('card'+id);
    card.style.display = 'block';
}

function hideCard(id) {
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('card'+id).style.display = 'none';
}

function hideCardAll() {
    document.querySelectorAll('.popout-card').forEach(card => card.style.display = 'none');
    document.getElementById('overlay').style.display = 'none';
}

function toggleView(id){
    document.getElementById('view'+id).style.display = 'block';
}

function toggleEdit(id){
    document.getElementById('view'+id).style.display = 'none';
    document.getElementById('edit'+id).style.display = 'block';
}

function cancelEdit(id){
    document.getElementById('edit'+id).style.display = 'none';
    document.getElementById('view'+id).style.display = 'block';
}
document.addEventListener('DOMContentLoaded', function () {
    const dobInput = document.querySelector('input[name="dob"]');
    const ageInput = document.querySelector('input[name="age"]');

    function calculateAge(dobValue) {
        if (!dobValue) return '';

        const dob = new Date(dobValue);
        const today = new Date();

        const diffTime = today - dob;
        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

        if (diffDays < 30) {
            return diffDays + (diffDays === 1 ? ' day' : ' days');
        }

        const diffMonths = (today.getFullYear() - dob.getFullYear()) * 12 + (today.getMonth() - dob.getMonth());
        if (diffMonths < 12) {
            return diffMonths + (diffMonths === 1 ? ' month' : ' months');
        }

        let diffYears = today.getFullYear() - dob.getFullYear();
        if (today.getMonth() < dob.getMonth() || (today.getMonth() === dob.getMonth() && today.getDate() < dob.getDate())) {
            diffYears--;
        }
        return diffYears + (diffYears === 1 ? ' year' : ' years');
    }

    // Initial calculation on page load
    ageInput.value = calculateAge(dobInput.value);

    // Recalculate when DOB changes
    dobInput.addEventListener('change', function() {
        ageInput.value = calculateAge(this.value);
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const weightInput = document.querySelector('input[name="Weight"]');
    const heightInput = document.querySelector('input[name="Height"]'); // make sure the name is correct
    const bmiInput = document.querySelector('input[name="BMI"]');
    const bmiStatusInput = document.querySelector('input[name="BMIStatus"]');

    function calculateBMI() {
        const weight = parseFloat(weightInput.value);
        const heightCm = parseFloat(heightInput.value);
        if (!weight || !heightCm) {
            bmiInput.value = '';
            bmiStatusInput.value = '';
            return;
        }

        const heightM = heightCm / 100;
        const bmi = weight / (heightM * heightM);
        const roundedBMI = Math.round(bmi * 10) / 10; // one decimal
        bmiInput.value = roundedBMI;

        let status = '';
        if (roundedBMI < 18.5) {
            status = 'Underweight';
        } else if (roundedBMI < 25) {
            status = 'Normal';
        } else if (roundedBMI < 30) {
            status = 'Overweight';
        } else {
            status = 'Obese';
        }

        bmiStatusInput.value = status;
    }

    // Calculate BMI on input change
    weightInput.addEventListener('input', calculateBMI);
    heightInput.addEventListener('input', calculateBMI);
});

@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 1500
    }).then(() => {
        location.reload(); // refresh page to show updated data
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: "{{ session('error') }}",
        confirmButtonText: 'OK'
    });
@endif

@if ($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        html: `
            <ul style="text-align:left;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        `,
        confirmButtonText: 'Fix Issues'
    });
@endif
</script>

@endsection
