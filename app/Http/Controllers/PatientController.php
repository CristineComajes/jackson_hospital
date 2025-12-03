<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Carbon\Carbon;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('contact_number', 'like', "%$search%");
            });
        }

        $patients = $query->get();

        return view('contents.patients', compact('patients'));
    }

    public function create()
    {
        return view('create.patients');
    }

    public function store(Request $request)
{
    try {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'age' => 'required|integer',
            'sex' => 'required|string',
            'gender' => 'required|string',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|unique:patients,email',
            'address' => 'required|string|max:500',
            'username' => 'required|string|unique:patients,username',
            'password' => 'required|confirmed|min:6',
            'height' => 'required|numeric',
            'Weight' => 'required|numeric',
            'BMI' => 'required|numeric',
            'insurance_provider' => 'required|string',
            'policy_number' => 'required|string|max:50'
        ]);

        // Save patient
        $patient = new \App\Models\Patient();
        foreach($request->only($patient->getFillable()) as $key => $value) {
            if ($key === 'password') {
                $patient->$key = bcrypt($value);
            } else {
                $patient->$key = $value;
            }
        }
        $patient->save();

        return redirect()->back()->with('success', 'Patient registered successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error saving patient: ' . $e->getMessage());
    }
}

    public function update(Request $request, Patient $patient)
{
    // Validate input
    $request->validate([
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'suffix' => 'nullable|string|max:50',
        'dob' => 'required|date',
        'gender' => 'required|string|max:20',
        'sex' => 'required|string|max:1',
        'bloodtype' => 'nullable|string|max:5',
        'contact_number' => 'nullable|string|max:20',
        'email' => "required|email|unique:patients,email,{$patient->id}",
        'address' => 'nullable|string|max:500',
        'height' => 'nullable|numeric|min:0',
        'Weight' => 'nullable|numeric|min:0',
        'BMIStatus' => 'nullable|string|max:50',
        'health' => 'nullable|string',
        'insurance_provider' => 'nullable|string|max:255',
        'policy_number' => 'nullable|string|max:50',
    ]);

    // Parse DOB safely
    $dob = Carbon::parse($request->dob);

    // Calculate age: always non-negative integer
    $age = intval(max(0, now()->diffInYears($dob)));

    // Calculate BMI only if height and weight are valid
    $BMI = 0;
    if ($request->height > 0 && $request->Weight > 0) {
        $BMI = round($request->Weight / (($request->height / 100) ** 2), 1);
    }

    // Update patient safely
    $patient->update([
        'first_name' => $request->first_name,
        'middle_name' => $request->middle_name,
        'last_name' => $request->last_name,
        'suffix' => $request->suffix,
        'dob' => $dob->format('Y-m-d'),
        'age' => $age,
        'gender' => $request->gender,
        'sex' => $request->sex,
        'bloodtype' => $request->bloodtype,
        'contact_number' => $request->contact_number,
        'email' => $request->email,
        'address' => $request->address,
        'height' => $request->height ?? 0,
        'Weight' => $request->Weight ?? 0,
        'BMI' => $BMI,
        'BMIStatus' => $request->BMIStatus,
        'health' => $request->health,
        'insurance_provider' => $request->insurance_provider,
        'policy_number' => $request->policy_number,
    ]);

    return redirect()->back()->with('success', 'Patient updated successfully!');
}




    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }
}
