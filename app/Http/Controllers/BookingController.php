<?php

// app/Http/Controllers/BookingController.php

namespace App\Http\Controllers;

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
            'space_id' => 'required|exists:spaces,id',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'place_name' => 'required|string|max:255',
        ]);

        Booking::create([
            'space_id' => $request->input('space_id'),
            'location' => $request->input('location'),
            'date' => $request->input('date'),
            'place_name' => $request->input('place_name'),
        ]);

        return redirect()->route('dashboard')->with('status', 'Booking successful!');
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
}
