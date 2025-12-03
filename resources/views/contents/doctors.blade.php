@extends('layouts.dashboard')

@section('title', 'Doctors')

@section('content')

<style>
/* Cards styling */
.card-doctor {
    font-size: 0.9rem;
    text-align: center;
}

.card-doctor img {
    max-height: 120px;
    object-fit: cover;
    border-radius: 50%;
}

/* Content wrapper */
.content-wrapper {
    position: relative;
    padding: 2rem 0;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container content-wrapper">

    <h2 class="mb-4">Doctors List</h2>

    <!-- Add Doctor Button -->
    @if(session('user') && session('user')->role === 'admin')
        <div class="d-flex justify-content-end mb-3">
            <a href="#" 
               class="btn btn-success shadow-sm"
               data-bs-toggle="modal" 
               data-bs-target="#doctorRegistrationModal">
                <i class="bi bi-plus-circle me-1"></i> Add Doctor
            </a>
        </div>
    @endif

    <!-- Search & Filter Form -->
    <form method="GET" action="{{ route('contents.doctors') }}" class="row mb-4 g-2 align-items-center">
        <div class="col-md-6">
            <input type="text" name="search" class="form-control" placeholder="Search doctor name..." value="{{ request()->search }}">
        </div>
        <div class="col-md-4">
            <select name="specialization" class="form-select">
                <option value="">All Specializations</option>
                @foreach($specializations as $spec)
                    <option value="{{ $spec }}" {{ request()->specialization == $spec ? 'selected' : '' }}>
                        {{ $spec }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-success w-100" type="submit">Filter</button>
        </div>
    </form>

    <!-- Doctors Cards -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse($doctors as $doctor)
            <div class="col">
                <div class="card h-100 shadow-sm border-success card-doctor p-2">
                    <img src="{{ $doctor->profile_picture ? asset('storage/'.$doctor->profile_picture) : asset('images/doc4.jpg') }}" class="mx-auto mt-2" alt="{{ $doctor->first_name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $doctor->first_name }} {{ $doctor->middle_name }} {{ $doctor->last_name }}</h5>
                        <p class="card-text"><strong>Specialization:</strong> {{ $doctor->specialization ?? 'N/A' }}</p>
                    </div>
                    <div class="card-footer bg-white">
                        <button class="btn btn-success w-100 btn-sm" data-bs-toggle="modal" data-bs-target="#viewDoctor{{ $doctor->id }}">
                            View
                        </button>
                    </div>
                </div>
            </div>

            <!-- View Doctor Modal -->
            <div class="modal fade" id="viewDoctor{{ $doctor->id }}" tabindex="-1" aria-labelledby="viewDoctorLabel{{ $doctor->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewDoctorLabel{{ $doctor->id }}">
                                {{ $doctor->first_name }} {{ $doctor->middle_name }} {{ $doctor->last_name }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row align-items-center">
                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                    <img src="{{ $doctor->profile_picture ? asset('storage/'.$doctor->profile_picture) : asset('images/default-doctor.png') }}" class="img-fluid rounded-circle" alt="{{ $doctor->first_name }}">
                                </div>
                                <div class="col-md-8">
                                    <p><strong>Specialization:</strong> {{ $doctor->specialization ?? 'N/A' }}</p>
                                    <p><strong>License Number:</strong> {{ $doctor->license_number ?? 'N/A' }}</p>
                                    <p><strong>Email:</strong> {{ $doctor->email ?? 'N/A' }}</p>
                                    <p><strong>Contact:</strong> {{ $doctor->contact_number ?? 'N/A' }}</p>
                                    <p class="text-danger fw-bold mt-2">Disclaimer: For appointments, please contact Jackson Hospital.</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            @if(session('user') && session('user')->role === 'admin')
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editDoctor{{ $doctor->id }}" data-bs-dismiss="modal">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                            @endif
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Doctor Modal -->
            @if(session('user') && session('user')->role === 'admin')
                <div class="modal fade" id="editDoctor{{ $doctor->id }}" tabindex="-1" aria-labelledby="editDoctorLabel{{ $doctor->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content border-0 rounded-3">
                            <div class="modal-header" style="background:#1b8f3e; color:white;">
                                <h5 class="modal-title">Edit Doctor</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body" style="background:#e8f5e9;">
                                <form action="{{ route('doctors.update', $doctor->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">First Name</label>
                                            <input type="text" name="first_name" class="form-control shadow-sm" value="{{ old('first_name', $doctor->first_name) }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Middle Name</label>
                                            <input type="text" name="middle_name" class="form-control shadow-sm" value="{{ old('middle_name', $doctor->middle_name) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Last Name</label>
                                            <input type="text" name="last_name" class="form-control shadow-sm" value="{{ old('last_name', $doctor->last_name) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Specialization</label>
                                            <input type="text" name="specialization" class="form-control shadow-sm" value="{{ old('specialization', $doctor->specialization) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">License Number</label>
                                            <input type="text" name="license_number" class="form-control shadow-sm" value="{{ old('license_number', $doctor->license_number) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Contact Number</label>
                                            <input type="text" name="contact_number" class="form-control shadow-sm" value="{{ old('contact_number', $doctor->contact_number) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Email</label>
                                            <input type="email" name="email" class="form-control shadow-sm" value="{{ old('email', $doctor->email) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Username</label>
                                            <input type="text" name="username" class="form-control shadow-sm" value="{{ old('username', $doctor->username) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Password <small class="text-muted">(leave blank to keep)</small></label>
                                            <input type="password" name="password" class="form-control shadow-sm">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label fw-semibold">Upload New Picture</label>
                                            <input type="file" name="picture" class="form-control shadow-sm">
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn text-white" style="background:#1b8f3e;">Update Doctor</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        @empty
            <div class="col">
                <p class="text-muted">No doctors found.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center">
        {{ $doctors->links('pagination::bootstrap-5') }}
    </div>

</div>

<!-- Doctor Registration Modal -->
@if(session('user') && session('user')->role === 'admin')
<div class="modal fade" id="doctorRegistrationModal" tabindex="-1" aria-labelledby="doctorRegistrationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 rounded-3">
            <div class="modal-header" style="background:#1b8f3e; color:white;">
                <h5 class="modal-title">Register New Doctor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="background:#e8f5e9;">
                <form action="{{ route('doctors.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">First Name</label>
                            <input type="text" name="first_name" class="form-control shadow-sm" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control shadow-sm">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Last Name</label>
                            <input type="text" name="last_name" class="form-control shadow-sm" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Specialization</label>
                            <input type="text" name="specialization" class="form-control shadow-sm" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">License Number</label>
                            <input type="text" name="license_number" class="form-control shadow-sm" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control shadow-sm" placeholder="63XXXXXXXXXX" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control shadow-sm" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Username</label>
                            <input type="text" name="username" class="form-control shadow-sm" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control shadow-sm" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Upload Picture</label>
                            <input type="file" name="picture" class="form-control shadow-sm">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn text-white" style="background:#1b8f3e;">Save Doctor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<script>
@if ($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        html: `<ul style="text-align:left;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>`,
        confirmButtonColor: '#1b8f3e'
    });
@endif

@if (session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#1b8f3e'
    });
@endif
</script>

@endsection
