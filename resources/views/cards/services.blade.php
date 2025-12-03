@extends('layouts.app')

@section('title', 'Available Services')

@section('content')
<!-- Blur background container -->
<div class="services-bg py-5" style="background-image: url('{{ asset('/images/hero.jpg') }}'); background-size: cover; background-position: center;">
    <div class="container py-5 bg-white bg-opacity-50 backdrop-blur rounded shadow">
        <h2 class="text-success fw-bold mb-4 text-center">Available Services</h2>

        <div class="row g-4">
            @php
                $services = [
                    ['name' => 'Medical Records', 'icon' => 'bi-clipboard', 'description' => 'Access and manage your medical records easily.'],
                    ['name' => 'Finance & Billings', 'icon' => 'bi-cash-coin', 'description' => 'View and pay your hospital bills securely.'],
                    ['name' => 'HMO & Corporate Partners', 'icon' => 'bi-handshake', 'description' => 'Check our partner HMOs and corporate programs.'],
                    ['name' => 'Hospital Safety', 'icon' => 'bi-shield-check', 'description' => 'Ensuring a safe environment for patients and staff.'],
                    ['name' => 'Laboratory & Diagnostics', 'icon' => 'bi-eyedropper', 'description' => 'Comprehensive lab and diagnostic services.'],
                    ['name' => 'Nursing Service', 'icon' => 'bi-person-badge', 'description' => 'Professional nursing care around the clock.'],
                    ['name' => 'Care Centers', 'icon' => 'bi-house-heart', 'description' => 'Specialized care centers for specific medical needs.'],
                    ['name' => 'Out Patient Department', 'icon' => 'bi-person-walking', 'description' => 'Quick consultations and treatment without hospital admission.']
                ];
            @endphp

            @foreach($services as $service)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100 text-center p-3 bg-white bg-opacity-75">
                        <i class="bi {{ $service['icon'] }} display-4 text-success mb-3"></i>
                        <h5 class="fw-bold">{{ $service['name'] }}</h5>
                        <p class="text-muted">{{ $service['description'] }}</p>
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
