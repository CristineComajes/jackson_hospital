<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;

class AppointmentController extends Controller
{
public function index(Request $request)
{
    // Start query with patient relation
    $query = Appointment::with('patient');

    // Search by patient name (optional)
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->whereHas('patient', function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%");
        });
    }

    // Filter by status if selected
    if ($request->filled('status_filter')) {
        $query->where('status', $request->input('status_filter'));
    }

    // Fetch appointments ordered by date
    $appointments = $query->orderBy('appointment_date', 'asc')->get();

    // Fetch all patients for the modal dropdown
    $patients = Patient::all();

    // Fetch all doctors for the modal dropdown
    $doctors = Doctor::all();

    // Pass everything to the view
    return view('contents.appointments', compact('appointments', 'patients', 'doctors'));
}




    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('create.appointments', compact('patients','doctors'));
    }

    public function store(Request $request)
{
    try {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'services' => 'required',
            'remarks' => 'nullable|string',
            'status' => 'required|in:Pending,Approved,Completed,Cancelled',
        ]);

        Appointment::create($request->all());

        return redirect()->route('appointments.index')
                         ->with('success', 'Appointment added successfully!');
    } catch (\Exception $e) {
        return redirect()->back()
                         ->with('error', 'Something went wrong! '.$e->getMessage());
    }
}

public function manage(Request $request, Appointment $appointment)
{
    $request->validate([
        'status' => 'required|in:Approved,Cancelled',
        'remarks' => 'required|string',
    ]);

    try {
        $appointment->update([
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('appointments.index')
                         ->with('success', 'Appointment ' . strtolower($request->status) . ' successfully!');
    } catch (\Exception $e) {
        return redirect()->back()
                         ->with('error', 'Something went wrong! ' . $e->getMessage());
    }
}



    public function edit(Appointment $appointment)
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('appointments.edit', compact('appointment','patients','doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id'=>'required',
            'doctor_id'=>'required',
            'appointment_date'=>'required|date',
            'appointment_time'=>'required'
        ]);

        $appointment->update($request->all());
        return redirect()->route('appointments.index')->with('success','Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success','Appointment deleted successfully.');
    }
}
