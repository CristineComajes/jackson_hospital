<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\Medication;

class DashboardController extends Controller
{
    // Main dashboard entry: redirect based on role
    public function index(Request $request)
    {
        $user = $request->session()->get('user');
        

        if (!$user) {
            return redirect()->route('login');
        }

        switch (strtolower($user->role)) {
            case 'admin':
                return redirect()->route('dashboard.admin');
            case 'doctor':
                return redirect()->route('dashboard.doctor');
            case 'patient':
                return redirect()->route('dashboard.patient');
            case 'frontdesk':
                return redirect()->route('dashboard.frontdesk');
            case 'pharmacist':
                return redirect()->route('dashboard.pharmacist');
            default:
                abort(403, 'Unauthorized');
        }
    }


    private function loadCommonData()
    {
        $patientsPerMonth = Patient::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $patientsByPlace = Patient::selectRaw('address, COUNT(*) as total')
            ->groupBy('address')
            ->pluck('total', 'address');

        return [
            'users' => User::all(),
                'patients' => Patient::all(),
                'doctors' => Doctor::all(),
                'appointments' => Appointment::all(),
                'prescriptions' => Prescription::all(),
                'medications' => Medication::all(),
                'patientsPerMonth' => $patientsPerMonth,
                'patientsByPlace' => $patientsByPlace,
            ];

            
        }


    // Doctor dashboard
            public function doctor(Request $request)
        {
            $user = $request->session()->get('user');

            if (!$user || strtolower($user->role) !== 'doctor') {
                abort(403, 'Unauthorized');
            }

            // Load shared dashboard data (patients, prescriptions, meds, etc.)
            $data = $this->loadCommonData();
            $data['user'] = $user;

            // 🔍 Identify the doctor using the EMAIL of logged-in user
            $doctor = \App\Models\Doctor::where('email', $user->email)->first();

            if (!$doctor) {
                // If no doctor record found for this email
                $data['appointments'] = collect();
                $data['upcomingPending'] = collect();
                $data['recentApproved'] = collect();
                $data['blockedDates'] = collect();

                return view('dashboard.doctor', $data)
                    ->with('error', 'No doctor profile found for this account.');
            }

            // 📌 ALL Appointments for this doctor
            $appointments = \App\Models\Appointment::where('doctor_id', $doctor->id)->get();

            // 📌 Upcoming Pending Appointments
            $upcomingPending = \App\Models\Appointment::where('doctor_id', $doctor->id)
                ->where('status', 'Pending')
                ->whereDate('appointment_date', '>=', now())
                ->orderBy('appointment_date', 'asc')
                ->get();

            // 📌 Recently Approved Appointments
            $recentApproved = \App\Models\Appointment::where('doctor_id', $doctor->id)
                ->where('status', 'Approved')
                ->orderBy('appointment_date', 'desc')
                ->get();

            // 📌 Dates disabled on calendar (doctor’s booked schedule)
            $blockedDates = \App\Models\Appointment::where('doctor_id', $doctor->id)
                ->pluck('appointment_date');

            // Add to data array so the Blade receives it
            $data['appointments'] = $appointments;
            $data['upcomingPending'] = $upcomingPending;
            $data['recentApproved'] = $recentApproved;
            $data['blockedDates'] = $blockedDates;

            

            return view('dashboard.doctor', $data);
        }

// Admin dashboard
   public function admin(Request $request)
{
    $user = $request->session()->get('user');
    if (!$user || strtolower($user->role) !== 'admin') abort(403, 'Unauthorized');

    $year = $request->get('year', date('Y'));

    // Patients per month
    $patientsPerMonth = Patient::whereYear('created_at', $year)
        ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    // Ensure Jan-Dec always show
    $allMonths = range(1,12);
    $patientsPerMonth = collect($allMonths)->mapWithKeys(function($m) use ($patientsPerMonth) {
        return [$m => $patientsPerMonth->get($m, 0)];
    });

    // Patients by place filtered by year
    $patientsByPlace = Patient::whereYear('created_at', $year)
        ->selectRaw('address, COUNT(*) as total')
        ->groupBy('address')
        ->pluck('total', 'address');

    $data = $this->loadCommonData();
    $data['user'] = $user;
    $data['patientsPerMonth'] = $patientsPerMonth;
    $data['patientsByPlace'] = $patientsByPlace;
    $data['year'] = $year;

    return view('dashboard.admin', $data);
}




  // Patient dashboard
public function patient(Request $request)
{
    $user = $request->session()->get('user');

    if (!$user || strtolower($user->role) !== 'patient') {
        abort(403, 'Unauthorized');
    }

    $data = $this->loadCommonData();
    $data['user'] = $user; // this contains username from users table

    // Load only the patient record linked by user id
    $data['patient'] = Patient::where('id', $user->id)->first(); // if your patient.id matches user.id
    $data['appointments'] = Appointment::where('patient_id', $user->id)->get();
    $data['prescriptions'] = Prescription::where('patient_id', $user->id)->get();

    return view('dashboard.patient', $data);
}


    // Frontdesk dashboard
    public function frontdesk(Request $request)
    {
        $user = $request->session()->get('user');

        if (!$user || strtolower($user->role) !== 'frontdesk') {
            abort(403, 'Unauthorized');
        }

        $data = $this->loadCommonData();
        $data['user'] = $user;

        return view('dashboard.frontdesk', $data);
    }

    // Pharmacisist dashboard
    
    // Pharmacist dashboard
public function pharmacist(Request $request)
{
    $user = $request->session()->get('user');

    if (!$user || strtolower($user->role) !== 'pharmacist') {
        abort(403, 'Unauthorized');
    }

    $year = $request->get('year', date('Y')); // optional year filter

    // Load shared data
    $data = $this->loadCommonData();
    $data['user'] = $user;

    // Prescriptions per month (Jan-Dec) for selected year
    $prescriptionsPerMonth = Prescription::whereYear('created_at', $year)
        ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    // Fill missing months with 0
    $allMonths = range(1,12);
    $prescriptionsPerMonth = collect($allMonths)->mapWithKeys(function($m) use ($prescriptionsPerMonth) {
        return [$m => $prescriptionsPerMonth->get($m, 0)];
    });

    // Medications stock data
    $medications = Medication::all();
    $medicationsNames = $medications->pluck('name');
    $medicationsStock = $medications->pluck('stock');

    $data['prescriptionsPerMonth'] = $prescriptionsPerMonth;
    $data['medicationsNames'] = $medicationsNames;
    $data['medicationsStock'] = $medicationsStock;
    $data['year'] = $year;

    return view('dashboard.pharmacist', $data);
}

    // Patients tab
public function patientsContent(Request $request) {
    $user = $request->session()->get('user');
    if (!$user) abort(403, 'Unauthorized');

    $patients = Patient::all();
    return view('contents.patients', compact('user', 'patients'));
}

// Appointments tab
public function appointmentsContent(Request $request) {
    $user = $request->session()->get('user');
    if (!$user) abort(403, 'Unauthorized');

    $appointments = Appointment::all();
    return view('contents.appointments', compact('user', 'appointments'));
}

// Medications tab
public function medicationsContent(Request $request) {
    $user = $request->session()->get('user');
    if (!$user) abort(403, 'Unauthorized');

    $medications = Medication::all();
    return view('contents.medications', compact('user', 'medications'));
}

// History tab
public function historyContent(Request $request) {
    $user = $request->session()->get('user');
    if (!$user) abort(403, 'Unauthorized');

    $prescriptions = Prescription::all();
    return view('contents.history', compact('user', 'prescriptions'));
}

}
