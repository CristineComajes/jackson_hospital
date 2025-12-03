<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\Medication;
use App\Models\Doctor;

class DoctorDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // logged in user

        if (!$user) {
            abort(403, 'Unauthorized: Please log in.');
        }

        // Check if this user exists in doctors table
        $doctor = Doctor::where('email', $user->email)->first();

        if (!$doctor) {
            abort(403, 'Unauthorized: You are not registered as a doctor.');
        }

        // --- FETCH DATA ---

        $patients = Patient::all();
        $appointments = Appointment::all();
        $prescriptions = Prescription::all();
        $medications = Medication::all();

        $upcomingPending = Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->where('status', 'Pending')
            ->whereDate('appointment_date', '>=', now())
            ->orderBy('appointment_date', 'asc')
            ->get();

        $recentApproved = Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->where('status', 'Approved')
            ->orderBy('appointment_date', 'desc')
            ->limit(3)
            ->get();

        $blockedDates = Appointment::where('doctor_id', $doctor->id)
            ->pluck('appointment_date');

        return view('dashboard.doctor', compact(
            'doctor',
            'patients',
            'appointments',
            'prescriptions',
            'medications',
            'upcomingPending',
            'recentApproved',
            'blockedDates'
        ));
    }
}
