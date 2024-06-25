<?php 
// app/Http/Controllers/SpaceController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Space;
use App\Models\Booking;

class SpaceController extends Controller
{
    // Display a listing of the spaces
    public function index()
    {
        $spaces = Space::all();
        return view('spaces.index', compact('spaces'));
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

    // Show the form for editing the specified space
    public function edit(Space $space)
    {
        return view('spaces.edit', compact('space'));
    }

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

    // Display bookings for a specific space
    public function bookings(Space $space)
    {
        $bookings = $space->bookings()->with('user')->get();
        return view('bookings.index', compact('bookings'));
    }
}
