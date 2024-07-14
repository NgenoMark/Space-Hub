<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Models\Space;


class UserController extends Controller
{


    /* public function index1()
    {
        $spaces = Space::all(); // Retrieve all spaces or based on the logged-in user
        return view('dashboard', compact('spaces'));
    }*/

    public function search(Request $request)
    {
        $location = $request->input('location');
        $capacity = $request->input('capacity');
        $price_min = $request->input('price_min');
        $price_max = $request->input('price_max');

        $spaces = Space::where('location', 'LIKE', "%$location%")
                        ->where('capacity', '>=', $capacity)
                        ->whereBetween('price', [$price_min, $price_max])
                        ->get();

        return response()->json($spaces);
    }

    public function book(Request $request)
    {

        \Log::info($request->all()); // Log the request data
        $request->validate([
            'space_id' => 'required|exists:spaces,space_id',
            'user_id' => 'required|exists:users,id',
            'location' => 'required|string|max:255',
            'booking_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'status' => 'required|string|max:20',
        ]);
    
        $booking = Booking::create([
            'space_id' => $request->space_id,
            'user_id' => $request->user_id,
            'location' => $request->location,
            'booking_date' => $request->booking_date,
            'total_price' => $request->price,
            'status' => $request->status,
        ]);
    
        if ($booking) {
            return redirect()->route('dashboard')->with('success', 'Booking created successfully!');
        } else {
            return back()->withInput()->with('error', 'Failed to create booking.');
        }
    }

    // Display a listing of the users
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Show the form for editing the specified user
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Update the specified user in storage
    public function update(Request $request, User $user)
    {
        \Log::info('Update method called for user: ' . $user->id);
        \Log::info('Request data: ', $request->all());

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'role' => 'required|string|max:255',
        ]);

        \Log::info('Validated data: ', $validatedData);

        $user->update($validatedData);

        \Log::info('User updated: ' . $user->id);

        return redirect()->route('superadmin')->with('success', 'User updated successfully.');
    }

    // Remove the specified user from storage
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('superadmin')->with('success', 'User deleted successfully.');
    }
}
