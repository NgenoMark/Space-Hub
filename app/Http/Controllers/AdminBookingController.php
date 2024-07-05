<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking; // Ensure this line is present


class AdminBookingController extends Controller
{
    public function index()
    {
        // Logic to fetch and return bookings data
        $bookings = Booking::all(); // Example query, adjust as per your logic

        return view('admin.bookings.index'); // Adjust this according to your view structure
    }

    public function edit($id)
{
    $booking = Booking::findOrFail($id);
    return view('admin.bookings.edit', compact('booking'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'booking_date' => 'required|date',
        'status' => 'required|string',
        'total_price' => 'required|numeric',
        'full_name' => 'required|string|max:100',
        'email' => 'required|email|max:255',
        'phone_number' => 'required|string|max:20',
    ]);

    $booking = Booking::findOrFail($id);
    $booking->update($request->all());

    return redirect()->route('admin.bookings.list')->with('success', 'Booking updated successfully.');
}

public function updateStatus(Request $request, Booking $booking)
{
    // Validate the request
    $request->validate([
        'status' => ['required', 'in:Pending,Confirmed,Cancelled'],
    ]);

    // Update the booking status
    $booking->status = $request->status;
    $booking->save();

    // Return a JSON response indicating success
    return response()->json(['success' => true]);
}


    
}
