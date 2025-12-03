<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class NotificationController extends Controller
{
    public function index()
    {
        // Get newly added users (latest 10)
        $users = User::latest()->take(10)->get();

        return view('partials.notification.index', compact('users'));
    }
}
