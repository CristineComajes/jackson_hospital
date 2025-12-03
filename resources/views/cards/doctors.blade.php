@extends('layouts.app')

@section('title', 'Doctors')

@section('content')
<link href="{{ asset('css/landing.css') }}" rel="stylesheet">

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

<div class="container content-wrapper">

    <h2 class="mb-4">Doctors List</h2>

    <!-- Search & Filter Bar -->
    <form method="GET" action="{{ route('cards.doctors') }}" class="row mb-4 g-2 align-items-center">
        <div class="col-md-6">
            <input type="text" name="search" class="form-control" placeholder="Search doctor name..."
                   value="{{ request()->search }}">
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

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse($doctors as $doctor)
            <div class="col">
                <div class="card h-100 shadow-sm border-success card-doctor p-2">
                    @if($doctor->profile_picture)
                        <img src="{{ $doctor->profile_picture }}" class="mx-auto mt-2" alt="{{ $doctor->first_name }}">
                    @else
                        <img src="\images\doc4.jpg" class="mx-auto mt-2" alt="Default Doctor">
                    @endif
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

            <!-- Modal for doctor details -->
            <div class="modal fade" id="viewDoctor{{ $doctor->id }}" tabindex="-1" aria-labelledby="viewDoctorLabel{{ $doctor->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewDoctorLabel{{ $doctor->id }}">
                                {{ $doctor->first_name }} {{ $doctor->middle_name }} {{ $doctor->last_name }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row align-items-center">
                                <!-- Left: Picture -->
                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                    @if($doctor->profile_picture)
                                        <img src="{{ $doctor->profile_picture }}" class="img-fluid rounded-circle" alt="{{ $doctor->first_name }}">
                                    @else
                                        <img src="{{ asset('images/default-doctor.png') }}" class="img-fluid rounded-circle" alt="Default Doctor">
                                    @endif
                                </div>

                                <!-- Right: Info -->
                                <div class="col-md-8">
                                    <p><strong>Specialization:</strong> {{ $doctor->specialization ?? 'N/A' }}</p>
                                    <p><strong>License Number:</strong> {{ $doctor->license_number ?? 'N/A' }}</p>
                                    <p><strong>Email:</strong> {{ $doctor->email ?? 'N/A' }}</p>
                                    <p><strong>Contact:</strong> {{ $doctor->contact_number ?? 'N/A' }}</p>
                                    <p class="text-danger fw-bold mt-2">
                                        Disclaimer: For appointments, please contact Jackson Hospital.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
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

</div> <!-- /.container -->
@endsection
