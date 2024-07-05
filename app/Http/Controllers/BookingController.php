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

    // Store a newly created booking in storage
    public function store(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'space_id' => 'required|exists:spaces,id',
            'full_name' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|email',
            'date' => 'required|date',
        ]);
    
        // Create a new booking instance
        $booking = new Booking();
        $booking->space_id = $validatedData['space_id'];
        $booking->full_name = $validatedData['full_name'];
        $booking->phone_number = $validatedData['phone_number'];
        $booking->email = $validatedData['email'];
        $booking->booking_date = $validatedData['date'];
        $booking->status = 'Pending'; // Set status to Pending for new bookings
        
        // Save the booking
        $booking->save();
    
        // Optionally, you can redirect the user after successful booking
        return redirect()->route('bookings.index')->with('success', 'Booking created successfully!');
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
        // Validation
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'booking_date' => 'required|date', // Validate booking date
            // Add more fields and validation rules as needed
        ]);

        // Create booking
        $booking = new Booking();
        $booking->space_id = $space_id;
        $booking->full_name = $request->input('full_name');
        $booking->email = $request->input('email');
        $booking->phone_number = $request->input('phone_number');
        $booking->booking_date = $request->input('booking_date'); // Capture booking date
        $booking->status = 'Pending'; // Set initial status

        // Save booking
        $booking->save();

        // Redirect to bookings index page with success message
        return redirect()->route('bookings.index')->with('success', 'Booking submitted successfully!');
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


