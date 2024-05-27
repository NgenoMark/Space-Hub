<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LockScreenController extends Controller
{
    public function show(){
        session(['locked' => true]);
        return view('lock');
    }

    public function unlock(Request $request){

        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();
        if(Hash::check($request->password, $user->password)){
            // Redirect back to
            session(['locked' => false]);
            return redirect()->intended('/dashboard');
        }


        return back()->withErrors(['password' => 'The password is incorrect.']);


    }
}