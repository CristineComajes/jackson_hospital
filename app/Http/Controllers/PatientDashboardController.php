<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Medication; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PatientDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Find patient linked to this user
        $patient = Patient::where('user_id', $userId)->first();

        if (!$patient) {
            return redirect()->route('login')->with('error', 'Patient is not on file.');
        }

        // All appointments
        $appointments = Appointment::where('patient_id', $patient->id)->get();

        // Upcoming appointments
        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->where('appointment_date', '>=', now())
            ->orderBy('appointment_date', 'asc')
            ->get();

        // Doctors
        $doctorIds = $appointments->pluck('doctor_id')->unique()->toArray();
        $doctors = count($doctorIds) > 0
            ? Doctor::whereIn('id', $doctorIds)->get()
            : collect();

        // Medications
        $medications = Medication::where('patient_id', $patient->id)->get();

        // Appointments per doctor for Chart.js
        $appointmentsPerDoctor = Appointment::where('patient_id', $patient->id)
            ->select('doctor_id', DB::raw('count(*) as total'))
            ->groupBy('doctor_id')
            ->get()
            ->map(function($item) {
                $doctor = Doctor::find($item->doctor_id);
                return [
                    'doctor_name' => $doctor ? $doctor->name : 'Unknown',
                    'total' => $item->total
                ];
            });

        return view('dashboard.patient', compact(
            'patient',
            'appointments',
            'upcomingAppointments',
            'doctors',
            'medications',
            'appointmentsPerDoctor'
        ));
    }
}
