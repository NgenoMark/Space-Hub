<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Space;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;




class SpaceController extends Controller
{
    public function index()
    {
        $spaces = Space::all(); // Fetch all spaces
    
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
    public function update(Request $request, Space $space)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $space->update([
            'name' => $request->input('name'),
            'location' => $request->input('location'),
            'capacity' => $request->input('capacity'),
            'price' => $request->input('price'),
        ]);

        return redirect()->route('spaces.index')->with('status', 'Space updated successfully!');
    }

    // Remove the specified space from storage
    public function destroy(Space $space)
    {
        $space->delete();
        return redirect()->route('spaces.index')->with('status', 'Space deleted successfully!');
    }

    // Search for spaces based on criteria
    public function search(Request $request)
    {
        $location = $request->input('location');
        $capacity = $request->input('capacity');
        $price_min = $request->input('price_min');
        $price_max = $request->input('price_max');
    
        $query = Space::query();
    
        if ($location) {
            $query->where('location', 'like', "%{$location}%");
        }
    
        if ($capacity) {
            $query->where('capacity', '>=', $capacity);
        }
    
        if ($price_min) {
            $query->where('price', '>=', $price_min);
        }
    
        if ($price_max) {
            $query->where('price', '<=', $price_max);
        }
    
        $spaces = $query->get();
    
        return view('spaces.index', compact('spaces'));
    }
    

    // Show the form for booking a specific space
    public function showBookingForm()
    {
        $spaces = Space::all(); // Example query to fetch all spaces, adjust as per your actual data retrieval logic
    
        return view('spaces.booking_form', compact('spaces'));
    }

    
    

    // Book the specified space
    public function book(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'booking_date' => 'required|date',
        ]);
    
        Booking::create([
            'user_id' => auth()->id(),
            'space_id' => $space_id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'booking_date' => $request->booking_date,
            'location' => Space::find($id)->location,
            'status' => 'pending',
            'total_price' => Space::find($id)->price,
        ]);
    
        return redirect()->route('spaces.book')->with('success', 'Booking successfully created.');
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
