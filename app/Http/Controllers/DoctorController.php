<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class DoctorController extends Controller
{
    public function index(Request $request)
    {
        // Start a query
        $query = Doctor::query();

        // Filter by search name if provided
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->search.'%')
                  ->orWhere('middle_name', 'like', '%'.$request->search.'%')
                  ->orWhere('last_name', 'like', '%'.$request->search.'%');
            });
        }

        // Filter by specialization if provided
        if ($request->filled('specialization')) {
            $query->where('specialization', $request->specialization);
        }

        // Paginate results
        $doctors = $query->paginate(10)->withQueryString();

        // Get unique specializations for filter dropdown
        $specializations = Doctor::select('specialization')
                                 ->distinct()
                                 ->pluck('specialization');

        return view('cards.doctors', compact('doctors', 'specializations'));
    }



public function store(Request $request)
{
    $request->validate([
        
        'first_name'      => 'required|string|max:255',
        'middle_name'     => 'nullable|string|max:255',
        'last_name'       => 'required|string|max:255',
        'specialization'  => 'required|string|max:255',
        'license_number'  => 'required|string|max:100',
        'contact_number'  => 'required|string|max:20',
        'email'           => 'required|email|unique:doctors,email|unique:users,email',
        'username'        => 'required|string|unique:doctors,username|unique:users,username',
        'password'        => 'required|string|min:6',
        'picture'         => 'nullable|image|mimes:jpeg,png,jpg,gif',
    ]);

    // Handle picture upload
    $picturePath = null;
    if ($request->hasFile('picture')) {
        $picturePath = $request->file('picture')->store('doctor_pictures', 'public');
    }

    // Create Doctor
    Doctor::create([
        'first_name'      => $request->first_name,
        'middle_name'     => $request->middle_name,
        'last_name'       => $request->last_name,
        'specialization'  => $request->specialization,
        'license_number'  => $request->license_number,
        'contact_number'  => $request->contact_number,
        'email'           => $request->email,
        'username'        => $request->username,
        'password'        => Hash::make($request->password),
        'picture'         => $picturePath,
    ]);

    // Create User record
   User::create([
    'name'            => $request->first_name . ' ' . ($request->middle_name ?? '') . ' ' . $request->last_name,
    'first_name'      => $request->first_name,
    'middle_name'     => $request->middle_name,
    'last_name'       => $request->last_name,
    'email'           => $request->email,
    'username'        => $request->username,
    'password'        => Hash::make($request->password),
    'role'            => 'doctor',
    'contactnumtxt'   => $request->contact_number,
]);


    // Return with success message
    return redirect()->route('contents.doctors')->with('success', 'Doctor registered successfully!');
}


    public function view(Request $request)
    {
        // Start a query
        $query = Doctor::query();

        // Filter by search name if provided
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->search.'%')
                  ->orWhere('middle_name', 'like', '%'.$request->search.'%')
                  ->orWhere('last_name', 'like', '%'.$request->search.'%');
            });
        }

        // Filter by specialization if provided
        if ($request->filled('specialization')) {
            $query->where('specialization', $request->specialization);
        }

        // Paginate results
        $doctors = $query->paginate(10)->withQueryString();

        // Get unique specializations for filter dropdown
        $specializations = Doctor::select('specialization')
                                 ->distinct()
                                 ->pluck('specialization');

        return view('contents.doctors', compact('doctors', 'specializations'));
    }

     public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);

        return view('contents.doctors.edit', compact('doctor'));
    }
public function update(Request $request, $id)
{
    $doctor = Doctor::findOrFail($id);
    $user   = User::where('username', $doctor->username)->first();

    $request->validate([
        'first_name'      => 'required|string|max:255',
        'middle_name'     => 'nullable|string|max:255',
        'last_name'       => 'required|string|max:255',
        'specialization'  => 'required|string|max:255',
        'license_number'  => 'required|string|max:100',
        'contact_number'  => 'required|string|max:20',
        'email'           => 'required|email|unique:doctors,email,' . $doctor->id
                                               . '|unique:users,email,' . ($user->id ?? 'null'),
        'username'        => 'required|string|unique:doctors,username,' . $doctor->id
                                               . '|unique:users,username,' . ($user->id ?? 'null'),
        'password'        => 'nullable|string|min:6',
        'picture'         => 'nullable|image|mimes:jpeg,png,jpg,gif',
    ]);

    // Handle profile picture
    if ($request->hasFile('picture')) {

        // Delete old picture
        if ($doctor->picture && Storage::disk('public')->exists($doctor->picture)) {
            Storage::disk('public')->delete($doctor->picture);
        }

        $picturePath = $request->file('picture')->store('doctor_pictures', 'public');
    } else {
        $picturePath = $doctor->picture;
    }

    // Update Doctor record
    $doctor->update([
        'first_name'      => $request->first_name,
        'middle_name'     => $request->middle_name,
        'last_name'       => $request->last_name,
        'specialization'  => $request->specialization,
        'license_number'  => $request->license_number,
        'contact_number'  => $request->contact_number,
        'email'           => $request->email,
        'username'        => $request->username,
        'password'        => $request->password
                                ? Hash::make($request->password)
                                : $doctor->password, // keep old password
        'picture'         => $picturePath,
    ]);

    // Update User table (sync)
    if ($user) {
        $user->update([
            'name'            => $request->first_name . ' ' . ($request->middle_name ?? '') . ' ' . $request->last_name,
            'first_name'      => $request->first_name,
            'middle_name'     => $request->middle_name,
            'last_name'       => $request->last_name,
            'email'           => $request->email,
            'username'        => $request->username,
            'password'        => $request->password
                                    ? Hash::make($request->password)
                                    : $user->password,
            'contactnumtxt'   => $request->contact_number,
        ]);
    }

    return redirect()
        ->route('contents.doctors')
        ->with('success', 'Doctor information updated successfully.');
}

   
}
