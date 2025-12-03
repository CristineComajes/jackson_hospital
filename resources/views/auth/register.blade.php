@extends('layouts.app')

@section('title', 'Patient Registration')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .fade-section { animation: fadeSlide 12s infinite alternate ease-in-out; }
    @keyframes fadeSlide { 0%, 45% { opacity:1; transform:translateX(0);} 25%,100%{opacity:0; transform:translateX(-20px);} }
    .carousel-inner img { object-fit: cover; height: 100%; }
    .register-card { max-width: 1200px; width: 100%; overflow: hidden; border: none; border-radius: 1rem; }
    .info-section { background: linear-gradient(135deg,#a7f3d0,#60a5fa); color:black; position:relative; min-height:650px;}
    .overlay { position:absolute; inset:0; background: rgba(255,255,255,0.2); }
    .right-section { padding:3rem 3rem 2.5rem 3rem; min-height:650px; }
    .progress { height:8px; margin-bottom:25px; }
    .progress-bar { background-color:#198754; transition: width 0.4s ease; }
    .form-step { display:none; }
    .form-step.active { display:block; }
    .form-control, .form-select { height:45px; border-radius:0.5rem; }
    .btn { height:45px; border-radius:0.5rem; }
    @media (max-width: 992px) { .info-section { display:none; } .right-section { padding:2rem; } .register-card { max-width:600px; } }
</style>

@if($errors->any())
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        html: '{!! implode("<br>", $errors->all()) !!}',
        confirmButtonColor: '#d33'
    });
</script>
@endif

@if(session('error'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session("error") }}',
        confirmButtonColor: '#d33'
    });
</script>
@endif

@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session("success") }}',
        confirmButtonColor: '#198754'
    });
</script>
@endif

<section class="login-section d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="card shadow-lg register-card">
        <div class="row g-0">
            <!-- Left Section -->
            <div class="col-lg-5 position-relative info-section d-flex flex-column justify-content-center align-items-center text-center p-5">
                <div id="infoContent" class="w-100 fade-section">
                    <h2 class="fw-bold">Welcome to Jackson Hospital</h2>
                    <p class="mt-3">Delivering compassionate care powered by modern healthcare technology. Your health is our mission.</p>
                </div>
                <div class="overlay"></div>
            </div>

            <!-- Right Section -->
            <div class="col-lg-7 bg-white right-section">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" height="55">
                    <h3 class="mt-2 text-success fw-bold">Create Patient Account</h3>
                    <p class="text-muted small">Complete the steps below to register as a patient</p>
                </div>

                <div class="progress">
                    <div class="progress-bar" id="progressBar" style="width: 33%;"></div>
                </div>

                <form method="POST" action="{{ route('patient.store') }}" id="multiStepForm">
                    @csrf

                    <!-- STEP 1 -->
                    <div class="form-step active">
                        <h5 class="mb-3 fw-bold text-success">Step 1: General Info</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">First Name *</label>
                                <input type="text" name="first_name" class="form-control" required value="{{ old('first_name') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Middle Name</label>
                                <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Last Name *</label>
                                <input type="text" name="last_name" class="form-control" required value="{{ old('last_name') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Suffix</label>
                                <select name="suffix" class="form-select">
                                    <option value="">-- Select --</option>
                                    <option value="Jr." {{ old('suffix')=='Jr.'?'selected':'' }}>Jr.</option>
                                    <option value="Sr." {{ old('suffix')=='Sr.'?'selected':'' }}>Sr.</option>
                                    <option value="II" {{ old('suffix')=='II'?'selected':'' }}>II</option>
                                    <option value="III" {{ old('suffix')=='III'?'selected':'' }}>III</option>
                                    <option value="IV" {{ old('suffix')=='IV'?'selected':'' }}>IV</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date of Birth *</label>
                                <input type="date" name="dob" id="dob" class="form-control" required onchange="handleDOBChange()" max="{{ date('Y-m-d') }}" value="{{ old('dob') }}">
                                <div id="dob-error" class="text-danger mt-1" style="display:none;">Please enter a valid date of birth.</div>
                                <input type="hidden" name="age" id="ageHidden" value="{{ old('age') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Age</label>
                                <input type="text" id="age" class="form-control" readonly value="{{ old('age')? old('age').' year'.(old('age')!=1?'s':'').' old':'' }}">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gender *</label>
                                <select name="gender" id="gender" class="form-select" required {{ old('gender')?'':'disabled' }}>
                                    <option value="">Select</option>
                                    <option value="Male" {{ old('gender')=='Male'?'selected':'' }}>Male</option>
                                    <option value="Female" {{ old('gender')=='Female'?'selected':'' }}>Female</option>
                                </select>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success w-100 next-step mt-3">Next</button>
                        <br>
                        <div> <center>
                            <p class="small">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-success text-decoration-none">Login</a>
            </p>
                        </center></div>
                    </div>

                    <!-- STEP 2 -->
                    <div class="form-step">
                        <h5 class="mb-3 fw-bold text-success">Step 2: Contact Info</h5>
                        <div class="mb-3">
                            <label class="form-label">Email Address *</label>
                            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact Number *</label>
                            <input type="text" name="contact_number" class="form-control" required placeholder="63XXXXXXXXXX" value="{{ old('contact_number') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address *</label>
                            <input type="text" name="address" class="form-control" required value="{{ old('address') }}">
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary prev-step">Back</button>
                            <button type="button" class="btn btn-success next-step">Next</button>
                        </div>
                    </div>

                    <!-- STEP 3 -->
                    <div class="form-step">
                        <h5 class="mb-3 fw-bold text-success">Step 3: Account Setup</h5>
                        <div class="mb-3">
                            <label class="form-label">Username *</label>
                            <input type="text" name="username" class="form-control" required value="{{ old('username') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password *</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm Password *</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary prev-step">Back</button>
                            <button type="submit" class="btn btn-success">Register</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById('dob').max = new Date().toISOString().split("T")[0];

function handleDOBChange() {
    const dobInput = document.getElementById('dob');
    const genderSelect = document.getElementById('gender');
    const ageInput = document.getElementById('age');
    const ageHidden = document.getElementById('ageHidden');
    const dobError = document.getElementById('dob-error');
    const dob = new Date(dobInput.value);
    const today = new Date();

    if (dob > today || isNaN(dob)) {
        ageInput.value = "Invalid: Future date";
        ageHidden.value = "";
        genderSelect.disabled = true;
        dobError.style.display = "block";
        return;
    }

    dobError.style.display = "none";
    let ageYears = today.getFullYear() - dob.getFullYear();
    if (today.getMonth() < dob.getMonth() || (today.getMonth() === dob.getMonth() && today.getDate() < dob.getDate())) ageYears--;
    ageInput.value = `${ageYears} year${ageYears!==1?'s':''} old`;
    ageHidden.value = ageYears;
    genderSelect.disabled = false;
}

window.addEventListener('DOMContentLoaded', () => {
    if(document.getElementById('dob').value) handleDOBChange();
});

// Multi-step form logic
const steps = document.querySelectorAll(".form-step");
const nextBtns = document.querySelectorAll(".next-step");
const prevBtns = document.querySelectorAll(".prev-step");
const progressBar = document.getElementById("progressBar");
let currentStep = 0;

function validateStep(stepIndex) {
    const fields = steps[stepIndex].querySelectorAll("input[required], select[required]");
    let valid = true;
    fields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add("is-invalid");
            valid = false;
        } else {
            field.classList.remove("is-invalid");
        }
    });
    return valid;
}

nextBtns.forEach(btn => btn.addEventListener("click", () => {
    if(validateStep(currentStep)){
        steps[currentStep].classList.remove("active");
        currentStep++;
        steps[currentStep].classList.add("active");
        progressBar.style.width = ((currentStep+1)/steps.length)*100+"%";
    }
}));

prevBtns.forEach(btn => btn.addEventListener("click", () => {
    steps[currentStep].classList.remove("active");
    currentStep--;
    steps[currentStep].classList.add("active");
    progressBar.style.width = ((currentStep+1)/steps.length)*100+"%";
}));

document.addEventListener("input", function(e){
    if(e.target.classList.contains("is-invalid") && e.target.value.trim()!==""){
        e.target.classList.remove("is-invalid");
    }
});

// Full validation on submit
document.getElementById("multiStepForm").addEventListener("submit", function(e){
    const allFields = document.querySelectorAll("#multiStepForm input[required], #multiStepForm select[required]");
    let valid = true;

    allFields.forEach(field => {
        if (!field.value.trim()) { field.classList.add("is-invalid"); valid=false; } 
        else field.classList.remove("is-invalid");
    });

    if(!valid){
        e.preventDefault();
        Swal.fire({icon:'error',title:'Oops!',text:'Please complete all required fields before submitting.',confirmButtonColor:'#d33'});
    }
});
</script>

@endsection
