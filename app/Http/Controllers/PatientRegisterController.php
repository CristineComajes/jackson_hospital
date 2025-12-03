<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientRegisterController extends Controller
{
    public function create()
    {
        return view('patient.register'); // Your Blade file
    }

    public function store(Request $request)
    {
        try {
            // Validation
            $request->validate([
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'required|string|max:255',
                'suffix' => 'nullable|string|max:10',
                'dob' => 'required|date|before_or_equal:today',
                'age' => 'required|integer',
                'gender' => 'required|string',
                'contact_number' => 'required|string|max:20|unique:patients,contact_number',
                'email' => 'required|email|unique:patients,email',
                'address' => 'required|string|max:500',
                'username' => 'required|string|unique:patients,username|max:255',
                'password' => 'required|string|confirmed|min:6',
                'height' => 'nullable|numeric',
                'Weight' => 'nullable|numeric',
                'BMI' => 'nullable|numeric',
                'BMIStatus' => 'nullable|string',
                'bloodtype' => 'nullable|string',
                'sex' => 'nullable|string',
                'insurance_provider' => 'nullable|string',
                'policy_number' => 'nullable|string',
            ]);

            // Save patient
            $patient = new Patient();
            $patient->first_name = $request->first_name;
            $patient->middle_name = $request->middle_name;
            $patient->last_name = $request->last_name;
            $patient->suffix = $request->suffix;
            $patient->dob = $request->dob;
            $patient->age = $request->age;
            $patient->gender = $request->gender;
            $patient->contact_number = $request->contact_number;
            $patient->email = $request->email;
            $patient->address = $request->address;
            $patient->username = $request->username;
            $patient->password = bcrypt($request->password); // Hash password
            $patient->height = $request->height;
            $patient->Weight = $request->Weight;
            $patient->BMI = $request->BMI;
            $patient->BMIStatus = $request->BMIStatus;
            $patient->bloodtype = $request->bloodtype;
            $patient->sex = $request->sex;
            $patient->insurance_provider = $request->insurance_provider;
            $patient->policy_number = $request->policy_number;
            $patient->save();

             // Redirect to login page with success message
        return redirect()->route('login')->with('success', 'Patient registered successfully! You can now login.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
