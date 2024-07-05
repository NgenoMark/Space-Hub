<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Space;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;



class SpaceController extends Controller
{
    // Display a listing of the spaces
    public function index()
    {
        $spaces = Space::all();
        return view('spaces.index', compact('spaces'));
    }


public function mySpaces()
{
    // Fetch spaces related to the authenticated user
    $spaces = Space::where('provider_id', Auth::id())->get();

    return view('admin.spaces.my-spaces', compact('spaces'));
}

public function edit($space_id)
{
    $space = Space::findOrFail($space_id);
    // Other logic for editing
    return view('admin.spaces.edit', compact('space'));
}

    // Show the form for creating a new space
    public function create()
    {
        return view('spaces.create');
    }
    

    

    // Store a newly created space in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        Space::create([
            'name' => $request->input('name'),
            'location' => $request->input('location'),
            'capacity' => $request->input('capacity'),
            'price' => $request->input('price'),
        ]);

        return redirect()->route('spaces.index')->with('status', 'Space created successfully!');
    }

    // Display the specified space
    public function show(Space $space)
    {
        return view('spaces.show', compact('space'));
    }

    /* Show the form for editing the specified space
    public function edit(Space $space)
    {
        return view('spaces.edit', compact('space'));
    } */

    // Update the specified space in storage
    // SpaceController update method
    public function update(Request $request, Space $space)
    {
        // Validate the update request
        $request->validate([
            'name' => 'required|string|max:255',
            'space_type' => 'required|string',
            'location' => 'required|string',
            'capacity' => 'required|integer',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            // Add more fields as needed
        ]);

        // Update the space using the corrected method signature
        $space->update([
            'name' => $request->name,
            'space_type' => $request->space_type,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'description' => $request->description,
            'price' => $request->price,
            // Update other fields as needed
        ]);

        // Update related bookings if necessary
        $space->bookings()->update([
            'space_name' => $space->name,
            'space_type' => $space->space_type,
            'location' => $space->location,
            // Update other related fields as needed
        ]);

        return redirect()->route('spaces.show', $space->id)->with('success', 'Space updated successfully!');
    }


    // Remove the specified space from storage
    public function destroy(Space $space)
    {
        // Ensure the authenticated user is the owner of the space
        if (Auth::id() !== $space->provider_id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the space
        $space->delete();

        return redirect()->route('dashboard')->with('success', 'Space deleted successfully!');
    }

    // Search for spaces based on criteria
    public function search(Request $request)
    {
        $location = $request->input('location');
        $capacity = $request->input('capacity');
        $priceMin = $request->input('price_min');
        $priceMax = $request->input('price_max');

        $query = Space::query();

        if ($location) {
            $query->where('location', 'like', '%' . $location . '%');
        }

        if ($capacity) {
            $query->where('capacity', '>=', $capacity);
        }

        if ($priceMin !== null) {
            $query->where('price', '>=', $priceMin);
        }

        if ($priceMax !== null) {
            $query->where('price', '<=', $priceMax);
        }

        $spaces = $query->get();

        return response()->json($spaces);
    }

    // Show the form for booking a specific space
    public function showBookingForm($id)
    {
        $space = Space::findOrFail($id);
        return view('spaces.book', compact('space'));
    }

    // Book the specified space
    public function book(Request $request, $id)
    {
        $request->validate([
            'booking_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $space = Space::findOrFail($id);

        // Save booking logic here

        return redirect()->route('dashboard')->with('success', 'Booking successful!');

        
    }

    public function mybooking()
{
    // Logic to fetch and display bookings related to the authenticated user
    // Example: Fetch bookings from the database and return a view
    $bookings = Booking::where('user_id', Auth::id())->get();
    return view('spaces.book', compact('bookings'));
}


    // Display bookings for a specific space
    public function bookings(Space $space)
    {
        $bookings = $space->bookings()->with('user')->get();
        return view('bookings.index', compact('bookings'));
    }
}
