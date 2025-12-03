<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
{
    $users = User::all();

    // Group users by 'address' or 'city' column (adjust column name)
    $usersByPlace = User::selectRaw('address, COUNT(*) as total')
        ->groupBy('address')
        ->pluck('total', 'address');

    return view('dashboard.admin', [
        'users' => $users,
        'usersByPlace' => $usersByPlace,
        // include your other counts…
    ]);
}

}
