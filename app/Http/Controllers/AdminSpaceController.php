<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Space;

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
            'description' => 'nullable|string',
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
        // Logic to prepare data or load necessary views for creating a space
        return view('admin.spaces.create'); // Adjust this according to your view structure
    }
}
