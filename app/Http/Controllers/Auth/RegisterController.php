<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate input
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create the user account
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // ---------------------------------------------------
        //  CREATE A NOTIFICATION ENTRY
        // ---------------------------------------------------

        Notification::create([
            'user_id' => $user->id,
            'title' => "New {$user->role} Registered",
            'message' => "{$user->name} has been registered as a {$user->role}.",
            'type' => $user->role,
            'link' => '/users/' . $user->id,
            'is_read' => 0,
        ]);


        // Auto-login
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    
}
