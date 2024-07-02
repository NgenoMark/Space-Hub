<?php

// app/Http/Controllers/BookingController.php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth; // Correct import for Auth
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Space;

class BookingController extends Controller
{
    // Display a listing of the bookings for a specific space
    public function index(Space $space)
    {
        $bookings = $space->bookings;
        return view('bookings.index', compact('bookings'));
    }

    // Show the form for creating a new booking
    public function create(Space $space)
    {
        return view('bookings.create', compact('space'));
    }

    // Store a newly created booking in storage
    public function store(Request $request)
    {
        $request->validate([
            'space_id' => 'required|exists:spaces,space_id',
            'user_id' => 'required|exists:users,id',
            'booking_date' => 'required|date',
            'total_price' => 'required|numeric',
            'status' => 'required|string',
        ]);

        Booking::create([
            'space_id' => $request->space_id,
            'user_id' => $request->user_id,
            'booking_date' => $request->booking_date,
            'total_price' => $request->total_price,
            'status' => $request->status,
        ]);

        return redirect()->route('/dashboard')->with('success', 'Space booked successfully!');
    }

    public function list(Request $request)
    {
        $user = Auth::user();
        $spaces = Space::where('provider_id', $user->id)->pluck('space_id');

        $bookings = Booking::whereIn('space_id', $spaces)->get();

        $view = view('bookings.list', compact('bookings'))->render();

        if ($request->ajax()) {
            return response()->json(['view' => $view]);
        }

        return view('bookings.index', compact('bookings'));
    }

    public function uindex()
    {
        $bookings = Booking::all(); // Fetch all bookings from the database
    
        return view('bookings.index', compact('bookings'));
    }
    

    // Other methods like store, update, delete can be added as per your application needs


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,accepted,denied',
        ]);
    
        \Log::info('Request to update status for booking ID: ' . $id);
        \Log::info($request->all());
    
        try {
            $booking = Booking::findOrFail($id);
            $booking->status = $request->status;
            $booking->save();
    
            return response()->json(['success' => true, 'status' => $booking->status]);
        } catch (\Exception $e) {
            \Log::error('Failed to update status for booking ID: ' . $id, ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to update status.'], 500);
        }
    }
    
    


    // Show the form for editing the specified booking
    public function edit(Booking $booking)
    {
        return view('bookings.edit', compact('booking'));
    }

    // Update the specified booking in storage
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'place_name' => 'required|string|max:255',
        ]);

        $booking->update([
            'location' => $request->input('location'),
            'date' => $request->input('date'),
            'place_name' => $request->input('place_name'),
        ]);

        return redirect()->route('bookings.index', $booking->space_id)->with('status', 'Booking updated successfully!');
    }

    // Remove the specified booking from storage
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index', $booking->space_id)->with('status', 'Booking deleted successfully!');
    }

    public function book(Request $request)
    {
        \Log::info($request->all()); // Log the request data
        $validated = $request->validate([
            'space_id' => 'required|exists:spaces,space_id',
            'user_id' => 'required|exists:users,id',
            'location' => 'required|string|max:255',
            'booking_date' => 'required|date',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|string|max:20',
        ]);

        $booking = Booking::create($validated);

        if ($booking) {
            return redirect()->route('dashboard')->with('success', 'Booking created successfully!');
        } else {
            return back()->withInput()->with('error', 'Failed to create booking.');
        }
    }

    
}


