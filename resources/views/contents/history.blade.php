@extends('layouts.dashboard')

@section('title', 'History')

@section('content')

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 text-gray-800 fw-bold">Patient Medical History</h1>
        
        {{-- Button to create a new record --}}
        <a href="#" class="btn btn-success shadow-sm">
            <i class="bi bi-file-earmark-plus me-1"></i> New Record
        </a>
    </div>

    <p class="mb-4 text-muted">
        Search and manage detailed medical records for all patients.
    </p>

    <!-- Search Bar -->
    <form action="{{ route('doctor.history') }}" method="GET" class="mb-4">
        <div class="input-group input-group-lg shadow-sm rounded-pill" style="max-width: 550px;">
            <input 
                type="text" 
                name="search" 
                class="form-control border-0 rounded-start-pill" 
                placeholder="Search by patient name, diagnosis, or date..."
                value="{{ request('search') }}"
                style="padding-left: 1.5rem;"
            >
            <button class="btn btn-outline-success border-0 rounded-end-pill" type="submit">
                <i class="bi bi-search"></i> Search
            </button>
        </div>
    </form>


    
    {{-- Placeholder for pagination --}}
    @if(isset($records) && method_exists($records, 'links'))
        <div class="mt-3">
            {{ $records->links() }}
        </div>
    @endif
</div>

@endsection