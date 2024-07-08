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
        $space = Space::findOrFail($id);
        return view('admin.spaces.edit', compact('space'));
    }

    public function update(Request $request, $space_id)
    {
        $request->validate([
            'space_name' => 'required|string|max:255',
            'space_type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|numeric',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $space = Space::findOrFail($space_id);
        $space->update($request->all());

        return redirect()->route('admin.spaces.index')->with('success', 'Space updated successfully.');
    }

    public function destroy($id)
    {
        $space = Space::findOrFail($id);
        $space->delete();

        return redirect()->route('admin.spaces.index')->with('success', 'Space deleted successfully.');
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
