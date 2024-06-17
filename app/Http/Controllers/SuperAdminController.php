<?php

// app/Http/Controllers/SuperAdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SuperAdminController extends Controller
{
    public function index()
    {
        $users = User::all(); // Fetch all users
        return view('superadmin', compact('users')); // Pass users to the view
    }
}

