@extends('layouts.dashboard')

@section('title', 'Medications')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold text-success">Medications</h1>
        <!-- Add Medication Button -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMedicationModal">
            Add Medication
        </button>
    </div>

    <!-- Search Bar -->
<form action="{{ route('medications.index') }}" method="GET" class="d-flex mb-4" style="max-width: 400px;">
    <input 
        type="text" 
        name="search" 
        class="form-control"
        placeholder="Search medication by name, type, or description..."
        value="{{ request('search') }}"
    >

    <button class="btn btn-success ms-2">
        <i class="bi bi-search"></i>
    </button>
</form>


   <!-- Medications Table -->
<div class="card border-success">
    <div class="card-body">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-success text-center">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Route</th>
                    <th>Dosage</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Picture</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medications as $medication)
                <tr class="text-center">
                    <td>{{ $medication->id }}</td>
                    <td>{{ $medication->name }}</td>
                    <td>{{ $medication->route }}</td>
                    <td>{{ $medication->dosage }}</td>
                    <td>{{ $medication->stock }}</td>
                    <td>{{ number_format($medication->price, 2) }}</td>
                    <td>
                        @if($medication->picture)
                            <img src="{{ asset('storage/' . $medication->picture) }}" alt="Medication Image" width="50" height="50" class="rounded">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <!-- View button -->
                        <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#viewMedicationModal{{ $medication->id }}">
                            View
                        </button>

                        <!-- Edit button -->
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editMedicationModal{{ $medication->id }}">
                            Edit
                        </button>


                        <!-- Medication View Modal -->
                        <div class="modal" id="viewMedicationModal{{ $medication->id }}" tabindex="-1" aria-labelledby="viewMedicationLabel{{ $medication->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content border-success">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title" id="viewMedicationLabel{{ $medication->id }}">Medication Details</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Name:</strong> {{ $medication->name }}</p>
                                        <p><strong>Route:</strong> {{ $medication->route }}</p>
                                        <p><strong>Dosage:</strong> {{ $medication->dosage }}</p>
                                        <p><strong>Stock:</strong> {{ $medication->stock }}</p>
                                        <p><strong>Price:</strong> {{ number_format($medication->price, 2) }}</p>
                                        <p><strong>Picture:</strong></p>
                                        @if($medication->picture)
                                            <img src="{{ asset('storage/' . $medication->picture) }}" alt="Medication Image" class="img-fluid rounded">
                                        @else
                                            <span>N/A</span>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Medication View Modal -->

                        <!-- Medication Edit Modal -->
                        <div class="modal" id="editMedicationModal{{ $medication->id }}" tabindex="-1" aria-labelledby="editMedicationLabel{{ $medication->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content border-success">

                                    <form action="{{ route('medications.update', $medication->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-warning text-dark">
                                            <h5 class="modal-title" id="editMedicationLabel{{ $medication->id }}">Edit Medication</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="name" class="form-label">Medication Name</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $medication->name }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="type" class="form-label">Route</label>
                                                    <input type="text" name="type" class="form-control" value="{{ $medication->route }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="dosage" class="form-label">Dosage</label>
                                                    <input type="text" name="dosage" class="form-control" value="{{ $medication->dosage }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="stock" class="form-label">Stock</label>
                                                    <input type="number" name="stock" class="form-control" value="{{ $medication->stock }}" min="0" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="price" class="form-label">Price</label>
                                                    <input type="number" name="price" class="form-control" value="{{ $medication->price }}" min="0" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="picture" class="form-label">Picture</label>
                                                    <input type="file" name="picture" class="form-control" accept="image/*">
                                                    @if($medication->picture)
                                                        <small>Current: {{ $medication->picture }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-warning">Update</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Edit Modal -->

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


  <!-- Add Medication Modal -->
<div class="modal" id="addMedicationModal" tabindex="-1" aria-labelledby="addMedicationLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-success">
            <form action="{{ route('medications.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="addMedicationLabel">Add Medication</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Medication Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" name="brand" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="dosage" class="form-label">Dosage</label>
                            <input type="text" name="dosage" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="form" class="form-label">Form</label>
                            <input type="text" name="form" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="route" class="form-label">Route</label>
                            <input type="text" name="route" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" name="price" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Available">Available</option>
                                <option value="Unavailable">Unavailable</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label for="picture" class="form-label">Picture</label>
                            <input type="file" name="picture" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>
@endsection

@section('scripts')
<script>
    // Disable backdrop (no blur/dark overlay) for all modals
    var modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal) {
        modal.addEventListener('show.bs.modal', function (event) {
            var bsModal = bootstrap.Modal.getOrCreateInstance(modal, {
                backdrop: false
            });
        });
    });
</script>

<script>
    // Success alert
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    @endif

    // Error alert (from validation or session error)
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK'
        });
    @endif

    // Validation errors from $errors
    @if($errors->any())
        let errorText = '';
        @foreach($errors->all() as $error)
            errorText += '{{ $error }}\n';
        @endforeach

        Swal.fire({
            icon: 'error',
            title: 'Validation Error!',
            text: errorText,
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK'
        });
    @endif
</script>

@endsection
