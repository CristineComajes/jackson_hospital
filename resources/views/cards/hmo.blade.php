@extends('layouts.app')

@section('title', 'HMO & Insurance Services')

@section('content')
<!-- HMO Section with background -->
<div class="hmo-bg py-5" style="background-image: url('{{ asset('images/hero.jpg') }}'); background-size: cover; background-position: center;">
    <div class="container py-5 bg-white bg-opacity-50 backdrop-blur rounded shadow">
        <h2 class="text-success fw-bold mb-4 text-center">HMO & Insurance Services</h2>

        <div class="row g-3">
            @php
                $hmos = [
                    ['name' => 'PhilHealth', 'description' => 'Government health insurance'],
                    ['name' => 'Maxicare', 'description' => 'Private HMO provider'],
                    ['name' => 'Intellicare', 'description' => 'Comprehensive HMO services'],
                    ['name' => 'Pacific Cross', 'description' => 'Travel & medical insurance'],
                    ['name' => 'MediCard', 'description' => 'HMO with nationwide coverage'],
                    ['name' => 'CareHealth', 'description' => 'Health maintenance organization']
                ];
            @endphp

            @foreach($hmos as $hmo)
                <div class="col-md-4">
                    <div class="card shadow-sm h-100 text-center p-3 bg-white bg-opacity-75">
                        <h5 class="fw-bold">{{ $hmo['name'] }}</h5>
                        <p class="text-muted">{{ $hmo['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 text-center">
            <a href="{{ url('/') }}" class="btn btn-success">Back to Home</a>
        </div>
    </div>
</div>

<!-- Optional CSS for backdrop blur -->
<style>
.backdrop-blur {
    backdrop-filter: blur(8px);
}
</style>
@endsection
