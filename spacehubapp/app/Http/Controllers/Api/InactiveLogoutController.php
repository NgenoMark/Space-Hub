<?php

// app/Http/Controllers/Api/InactiveLogoutController.php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InactiveLogoutController extends Controller
{
    public function logout(Request $request)
    {
        // Save session data before logging out
        $userData = $request->session()->all();
        $request->session()->put('user_data', $userData);

        Auth::logout();
        return response()->json(['message' => 'User inactive, logging out.']);
    }
}


