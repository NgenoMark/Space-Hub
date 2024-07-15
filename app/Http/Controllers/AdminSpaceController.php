<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Space;
use Illuminate\Support\Facades\Auth;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminSpaceController extends Controller
{


    public function getBookingAnalysisData()
    {
        try {
            // Fetching unique space names and their booking counts
            $bookingData = Booking::selectRaw('space_name, count(*) as booking_count')
                ->groupBy('space_name')
                ->get();
    
            // Separate space names and booking counts into separate arrays
            $spaceNames = $bookingData->pluck('space_name')->toArray();
            $bookingCounts = $bookingData->pluck('booking_count')->toArray();
    
            return response()->json([
                'spaceNames' => $spaceNames,
                'bookingCounts' => $bookingCounts,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

public function incomeGraphData()
{
    $bookings = Booking::select(DB::raw('DATE(start_date) as date'), DB::raw('SUM(total_price) as total_income'))
                    ->where('status', 'Accepted')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();

    $labels = $bookings->pluck('date')->map(function ($date) {
        return Carbon::parse($date)->format('M d'); // Format date for display
    });

    $incomeData = $bookings->pluck('total_income');

    return response()->json([
        'labels' => $labels,
        'incomeData' => $incomeData,
    ]);
}

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
    
        // Delete related bookings
        $space->bookings()->delete();
    
        // Delete the space
        $space->delete();
    
        return redirect()->route('admin.spaces.index')->with('success', 'Space and related bookings deleted successfully.');
    }
    

    public function create()
    {
        return view('admin.spaces.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'space_name' => 'required|string|max:255',
            'space_type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('spaces', 'public');
                $images[] = $path;
            }
        }

        Space::create([
            'space_name' => $request->space_name,
            'space_type' => $request->space_type,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'description' => $request->description,
            'price' => $request->price,
            'provider_id' => Auth::id(),
            'images' => $images,
        ]);

        return redirect()->route('admin.spaces.index')->with('success', 'Space created successfully.');
    }
    
}
