<?php 

// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected function authenticated(Request $request, $user)
    {
        // Restore session data after logging in
        if ($request->session()->has('user_data')) {
            $userData = $request->session()->get('user_data');
            $request->session()->put($userData);
            $request->session()->forget('user_data');
        }

        return redirect()->intended($this->redirectPath());
    }
}
