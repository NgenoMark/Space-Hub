<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;


class SuperAdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('superadmin', compact('users'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user){

        // Validate the request
        // We use the validate method to ensure the request contains valid data. The unique rule is updated to exclude the current user's ID.
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => [
                'required',
                Rule::in(['client', 'admin', 'superadmin']) // Replace with your actual roles
            ],
        ]);

        // Update the user with the validated data
        $user->update($request->only(['name', 'email', 'role']));

        return redirect()->route('superadmin')
                        ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('superadmin')
                         ->with('success', 'User deleted successfully');
    }
}
