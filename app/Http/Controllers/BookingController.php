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
    /*public function index(Space $space)
    {
        $bookings = $space->bookings;
        return view('bookings.index', compact('bookings'));
    } */

    public function index()
    {
        $user = Auth::user();
        $bookings = Booking::where('user_id', $user->id)->get();
    
        return view('bookings.index', compact('bookings'));
    }

    // Show the form for creating a new booking
    public function create(Space $space)
    {
        return view('bookings.create', compact('space'));
    }

    public function cancel(Request $request, $booking_id)
{
    $booking = Booking::findOrFail($booking_id);

    // Ensure the logged-in user owns the booking
    if ($booking->user_id !== auth()->id()) {
        return redirect()->route('bookings.index')->with('error', 'Unauthorized access.');
    }

    // Update the status to 'Cancelled'
    $booking->status = 'Cancelled';
    $booking->save();

    return redirect()->route('bookings.index')->with('success', 'Booking cancelled successfully.');
}


    // Store a newly created booking in storage
    public function store(Request $request)
    {

        $user_id = Auth::id();

        // Validate the form data
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:15',
            'booking_date' => 'required|date',
            'space_id' => 'required|exists:spaces,space_id',
        ]);

        // Retrieve the space and its provider_id
        $space = Space::findOrFail($request->space_id);

        // Create a new booking
        $booking = new Booking();
        $booking->full_name = $request->full_name;
        $booking->email = $request->email;
        $booking->phone_number = $request->phone_number;
        $booking->booking_date = $request->booking_date;
        $booking->space_id = $space->space_id;
        $booking->provider_id = $space->provider_id;
        $booking->user_id = Auth::id();
        $booking->space_name = $space->space_name;
        $booking->location = $space->location;
        $booking->status = 'Pending';
        $booking->total_price = $space->price; // Automatically insert the space price

        // Save the booking to the database
        $booking->save();

        // Redirect back with a success message
        return redirect()->route('bookings.index')->with('success', 'Booking submitted successfully!');
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
            'status' => 'required|string|in:pending,accepted,denied,cancelled',
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

    // app/Http/Controllers/BookingController.php

// app/Http/Controllers/BookingController.php
public function showBookingForm($space_id)
{
    // For debugging: log the space_id instead of returning it
    \Log::info('The space ID is: ' . $space_id);

    // Fetch the space and return the booking form view
    $space = Space::findOrFail($space_id);
    return view('bookings.form', compact('space'));
}




    
public function submitBookingForm(Request $request, $space_id)
{
    $space = Space::find($space_id);
    $total_price = $space->price; // Assuming you have a price column in your spaces table

    Booking::create([
        'space_id' => $space->space_id,
        'space_name' => $space->space_name,
        'provider_id' => $space->provider_id,
        'user_id' => Auth::id(),
        'full_name' => Auth::user()->name,
        'phone_number' => $request->phone_number,
        'email' => $request->email,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'location' => $space->location,
        'status' => 'pending',
        'total_price' => $total_price,
    ]);

    return redirect()->route('bookings.index');
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