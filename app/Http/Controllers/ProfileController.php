<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Profile page (view only)
    public function index()
    {
        return view('partials.sidebar.profile'); // This is your profile display page
    }

    // Show profile edit form
    public function edit()
    {
        return view('partials.sidebar.profile'); 
    }

    // Update profile
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'username'   => 'required|string|max:255|unique:users,username,' . $user->id,
            'password'   => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'username'   => $request->username,
            'password'   => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('sidebar.view-profile')->with('success', 'Profile updated successfully!');
    }
}
