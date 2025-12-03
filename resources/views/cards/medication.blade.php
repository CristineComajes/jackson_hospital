@extends('layouts.app') 

@section('title', 'Medications') 

@section('content') 
<link href="{{ asset('css/landing.css') }}" rel="stylesheet"> 

<style> 
/* Smaller cards */ 
.card { 
    font-size: 0.9rem; 
} 
.card-img-top { 
    max-height: 120px; 
    object-fit: contain; 
} 
.input-group .btn i { 
    font-size: 1rem; 
} 
</style> 

<div class="container"> 

    <!-- Search & Filter Bar --> 
    <form method="GET" action="{{ route('medications.index') }}" class="row mb-4 g-2 align-items-center"> 
        <div class="col-md-6"> 
            <input type="text" name="search" class="form-control" placeholder="Search medication name..." value="{{ request()->search }}"> 
        </div> 
        <div class="col-md-4"> 
            <select name="brand" class="form-select"> 
                <option value="">All Brands</option> 
                @foreach($brands as $brand) 
                    <option value="{{ $brand }}" {{ request()->brand == $brand ? 'selected' : '' }}>{{ $brand }}</option> 
                @endforeach 
            </select> 
        </div> 
        <div class="col-md-2"> 
            <button class="btn btn-success w-100" type="submit"> 
                <i class="bi bi-search"></i> Filter 
            </button> 
        </div> 
    </form> 

    <!-- Cards Grid --> 
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3"> 
        @forelse($medications as $med) 
            <div class="col"> 
                <div class="card h-100 shadow-sm border-success text-center"> 
                    @if($med->image) 
                        <img src="{{ $med->image }}" class="card-img-top mx-auto mt-3" alt="{{ $med->name }}"> 
                    @endif 
                    <div class="card-body"> 
                        <h6 class="card-title">{{ $med->name }}</h6> 
                        <p class="card-text"><strong>Price:</strong> ₱{{ number_format($med->price ?? 0, 2) }}</p> 
                        <p class="card-text"> 
                            <strong>Status:</strong> 
                            <span class="badge {{ $med->status === 'active' ? 'bg-success' : 'bg-secondary' }}"> 
                                {{ ucfirst($med->status) }} 
                            </span> 
                        </p> 
                    </div> 
                    <div class="card-footer bg-white"> 
                        @if($med->status === 'active') 
                            <button type="button" class="btn btn-success w-100 btn-sm" data-bs-toggle="modal" data-bs-target="#viewMed{{ $med->id }}"> 
                                View 
                            </button> 
                        @else 
                            <button class="btn btn-secondary w-100 btn-sm" disabled>Unavailable</button> 
                        @endif 
                    </div> 
                </div> 
            </div> 

            <!-- Modal --> 
            <div class="modal fade" id="viewMed{{ $med->id }}" tabindex="-1" aria-labelledby="viewMedLabel{{ $med->id }}" aria-hidden="true"> 
                <div class="modal-dialog modal-dialog-centered modal-lg"> 
                    <div class="modal-content"> 
                        <div class="modal-header"> 
                            <h5 class="modal-title" id="viewMedLabel{{ $med->id }}">{{ $med->name }}</h5> 
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
                        </div> 
                        <div class="modal-body"> 
                            <div class="row g-3"> 
                                <div class="col-md-5 text-center"> 
                                    @if($med->image) 
                                        <img src="{{ $med->image }}" class="img-fluid mb-3" alt="{{ $med->name }}"> 
                                    @endif 
                                </div> 
                                <div class="col-md-7"> 
                                    <p><strong>Brand:</strong> {{ $med->brand ?? 'N/A' }}</p> 
                                    <p><strong>Dosage:</strong> {{ $med->dosage ?? 'N/A' }}</p> 
                                    <p><strong>Form:</strong> {{ $med->form ?? 'N/A' }}</p> 
                                    <p><strong>Route:</strong> {{ $med->route ?? 'N/A' }}</p> 
                                    <p><strong>Stock:</strong> {{ $med->stock ?? '0' }}</p> 
                                    <p><strong>Status:</strong> {{ ucfirst($med->status) }}</p> 
                                    <p><strong>Price:</strong> ₱{{ number_format($med->price ?? 0, 2) }}</p> 
                                    <p><strong>Description:</strong> {{ $med->description ?? 'No description available.' }}</p> 
                                    <p class="text-danger fw-bold mt-2"> 
                                        Disclaimer: Go to <strong>Jackson Hospital Manager</strong> to order this medication. 
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
                <p class="text-muted">No medications found.</p> 
            </div> 
        @endforelse 
    </div> 

    <!-- Pagination Links --> 
   <!-- Pagination Links -->
<div class="mt-4 d-flex justify-content-center">
    {{ $medications->links('pagination::bootstrap-5') }}
</div>


</div> <!-- /.container --> 
@endsection
