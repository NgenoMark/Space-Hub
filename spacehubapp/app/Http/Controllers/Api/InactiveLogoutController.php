<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InactiveLogoutController extends Controller
{
    public function logout(Request $request)
    {
        try {
            Log::info('Logout attempt started.');
            if (Auth::check()) {
                Log::info('User is authenticated, logging out.');
                Auth::logout();
                Log::info('User logged out successfully.');
                return response()->json(['message' => 'User inactive, logging out.'], 200);
            } else {
                Log::warning('User is not authenticated.');
                return response()->json(['message' => 'User is not authenticated.'], 401);
            }
        } catch (\Exception $e) {
            Log::error('Logout failed: ' . $e->getMessage());
            return response()->json(['message' => 'Logout failed.', 'error' => $e->getMessage()], 500);
        }
    }
}
