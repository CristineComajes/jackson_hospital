<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Medication;

class PrescriptionController extends Controller
{
    // Display all prescriptions
public function index(Request $request)
{
    $search = $request->input('search');

    $prescriptions = Prescription::with(['patient','doctor','medication'])
        ->when($search, function ($query, $search) {
            $query->whereHas('patient', fn($q) => $q->where('first_name', 'like', "%$search%")
                                                    ->orWhere('last_name', 'like', "%$search%"))
                  ->orWhereHas('doctor', fn($q) => $q->where('first_name', 'like', "%$search%")
                                                     ->orWhere('last_name', 'like', "%$search%"))
                  ->orWhereHas('medication', fn($q) => $q->where('name', 'like', "%$search%"))
                  ->orWhere('status', 'like', "%$search%");
        })
        ->get();

    return view('contents.prescriptions', compact('prescriptions'));
}



    // Show form to create a new prescription
    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $medications = Medication::all();

        return view('create.prescriptions', compact('patients','doctors','medications'));
    }

    // Store a new prescription
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'medication_id' => 'required',
            'dosage' => 'required',
            'frequency' => 'required',
            'route' => 'required',
            'date_prescribed' => 'required|date',
            'doctor_signature' => 'nullable|string',
        ]);

        Prescription::create($request->all());

        return redirect()->route('contents.prescriptions')
                         ->with('success', 'Prescription created successfully.');
    }

    // Show form to edit an existing prescription
    public function edit(Prescription $prescription)
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $medications = Medication::all();

        return view('prescriptions.edit', compact('prescription','patients','doctors','medications'));
    }

    // Update an existing prescription
    public function update(Request $request, Prescription $prescription)
    {
        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'medication_id' => 'required',
            'dosage' => 'required',
            'frequency' => 'required',
            'route' => 'required',
            'date_prescribed' => 'required|date',
            'doctor_signature' => 'nullable|string',
        ]);

        $prescription->update($request->all());

        return redirect()->route('contents.prescriptions')
                         ->with('success', 'Prescription updated successfully.');
    }

    // Delete a prescription
    public function destroy(Prescription $prescription)
    {
        $prescription->delete();

        return redirect()->route('contents.prescriptions')
                         ->with('success', 'Prescription deleted successfully.');
    }

    // Show a single prescription
    public function show(Prescription $prescription)
    {
        $prescription->load(['patient','doctor','medication']); // eager load relations
        return view('contents.prescriptions', compact('prescription'));
    }
}
