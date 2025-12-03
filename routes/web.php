<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PatientRegisterController;
use App\Http\Controllers\PatientDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorDashboardController;
use App\Http\Controllers\NotificationController;

// ---------------------------
// PUBLIC ROUTES
// ---------------------------

// Welcome / Home page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Pharmaceuticals view
Route::get('/pharmaceuticals', function () {
    return view('cards.medication'); 
})->name('pharmaceuticals');

// Doctors view
Route::get('/doctors', [DoctorController::class, 'index'])->name('cards.doctors');
Route::get('/contents/doctors', [DoctorController::class, 'view'])->name('contents.doctors');


// HMO view
Route::get('/hmo', function () {
    return view('cards.hmo');
})->name('cards.hmo');

// Medication View
Route::get('/medications', [MedicationController::class, 'index'])->name('medications.index');

// Services
Route::get('/services', function () {
    return view('cards.services');
})->name('cards.services');

// Patient registration
Route::get('/patient/register', [PatientRegisterController::class, 'create'])->name('patient.create');
Route::post('/patient/register', [PatientRegisterController::class, 'store'])->name('patient.store');


// Notifications
Route::get('/notifications', [NotificationController::class, 'index'])
     ->name('notifications');

// ---------------------------
// AUTHENTICATION ROUTES
// ---------------------------

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/auth-login', [LoginController::class, 'login'])->name('auth.login');

// Register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Logout
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// ---------------------------
// DASHBOARDS
// ---------------------------

// Main dashboard entry (role-based)
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Doctor dashboard
Route::get('/dashboard/doctor', [DashboardController::class, 'doctor'])->name('dashboard.doctor');

// Admin dashboard
Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');

// Patient dashboard
Route::get('/dashboard/patient', [DashboardController::class, 'patient'])->name('dashboard.patient');

// Frontdesk dashboard
Route::get('/dashboard/frontdesk', [DashboardController::class, 'frontdesk'])->name('dashboard.frontdesk');

// Pharmacist dashboard
Route::get('/dashboard/pharmacist', [DashboardController::class, 'pharmacist'])->name('dashboard.pharmacist');

// ---------------------------
// CONTENT ROUTES (accessible by all roles)
// ---------------------------
Route::get('/contents/patients', [PatientController::class, 'index'])->name('contents.patients');
Route::get('/contents/appointments', [AppointmentController::class, 'index'])->name('contents.appointments');
Route::get('/contents/medications', [MedicationController::class, 'index'])->name('contents.medications');
Route::get('/contents/history', [LogController::class, 'history'])->name('contents.history');
Route::get('/contents/prescriptions', [PrescriptionController::class, 'index'])->name('contents.prescriptions');
Route::get('/contents/prescriptions/{prescription}', [PrescriptionController::class, 'show'])->name('contents.prescriptions.show');

// ---------------------------
// CREATE / CRUD ROUTES
// ---------------------------

// Patients
Route::get('/create/patients', [PatientController::class, 'create'])->name('create.patients');
Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');

// Appointments
Route::get('/create/appointments', [AppointmentController::class, 'create'])->name('create.appointments');
Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::post('/appointments/{appointment}/manage', [AppointmentController::class, 'manage'])->name('appointments.manage');

// Medications
Route::get('/create/medications', [MedicationController::class, 'create'])->name('create.medications');
Route::get('/medications', [MedicationController::class, 'index'])->name('medications.index');
Route::post('/medications', [MedicationController::class, 'store'])->name('medications.store');
Route::put('/medications/{medication}', [MedicationController::class, 'update'])->name('medications.update');


// Prescriptions
Route::get('/create/prescriptions', [PrescriptionController::class, 'create'])->name('prescriptions.create');
Route::post('/prescriptions', [PrescriptionController::class, 'store'])->name('prescriptions.store');
Route::get('/prescriptions/{prescription}/edit', [PrescriptionController::class, 'edit'])->name('prescriptions.edit');
Route::put('/prescriptions/{prescription}', [PrescriptionController::class, 'update'])->name('prescriptions.update');
Route::delete('/prescriptions/{prescription}', [PrescriptionController::class, 'destroy'])->name('prescriptions.destroy');

// Doctors

Route::post('/doctors/store', [DoctorController::class, 'store'])->name('doctors.store');
Route::get('/doctors/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctors.edit');
Route::put('/doctors/{doctor}', [DoctorController::class, 'update'])->name('doctors.update');
