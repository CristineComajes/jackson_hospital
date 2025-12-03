@extends('layouts.app')

@section('title', 'Find a Doctor')

@section('content')
<div class="container mt-4">

    <h3>Find a Doctor</h3>

    <form method="GET" action="{{ route('doctor.search') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name or specialty" value="{{ request('search') }}">
            <button class="btn btn-success" type="submit"><i class="bi bi-search"></i> Search</button>
        </div>
    </form>

    @if($doctors->isEmpty())
        <p class="text-muted">No doctors found.</p>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($doctors as $doctor)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $doctor->name }}</h5>
                            <p class="card-text"><strong>Specialty:</strong> {{ $doctor->specialty }}</p>
                            <p class="card-text"><strong>Contact:</strong> {{ $doctor->contact }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
