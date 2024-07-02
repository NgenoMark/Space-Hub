<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Space;
use Illuminate\Support\Facades\Auth;


class AdminSpaceController extends Controller
{
    public function index()
    {
        // Retrieve spaces owned by the authenticated admin
        $spaces = Space::where('provider_id', auth()->id())->get();

        return view('admin.spaces.index', compact('spaces'));
    }

    public function edit($id)
    {
        // Find the space by ID and ensure it belongs to the authenticated admin
        $space = Space::where('id', $id)->where('provider_id', auth()->id())->firstOrFail();

        return view('admin.spaces.edit', compact('space'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'space_name' => 'required|string|max:100',
            'space_type' => 'required|string|max:50',
            'location' => 'required|string|max:50',
            'description' => 'nullable|string',
            'capacity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        // Find the space by ID and ensure it belongs to the authenticated admin
        $space = Space::where('id', $id)->where('provider_id', auth()->id())->firstOrFail();

        // Update the space with the new data
        $space->update($request->all());

        return redirect()->route('spaces.myspace')->with('success', 'Space updated successfully.');
    }

    public function create()
    {
        return view('admin.spaces.create');
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'space_name' => 'required|string|max:255',
            'space_type' => 'required|string|max:255',
            'location' => 'required|string|max:50',
            'description' => 'required|string',
            'capacity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);
    
        // Create a new Space instance and save to database
        $space = new Space();
        $space->space_name = $request->input('space_name');
        $space->space_type = $request->input('space_type');
        $space->location = $request->input('location');
        $space->description = $request->input('description');
        $space->price = $request->input('price');
        $space->capacity = $request->input('capacity');
        $space->provider_id = Auth::id(); // Set provider_id to the authenticated user's ID
        $space->save();
    
        // Redirect to the edit route with the newly created space ID
        //return redirect()->route('admin.spaces.edit', ['id' => $space->id])->with('success', 'Space created successfully!');
        return redirect()->route('admin.spaces.index');

    }    
}
