<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Space;

class SpaceOwnerController extends Controller
{
    // Method to get chart data (returns JSON)
    public function getChartData()
    {
        // Assuming the space owner is authenticated and we use their ID
        $spaces = Space::where('provider_id', auth()->id()) // Assuming provider_id is the field to filter the spaces
                       ->withCount('bookings') // Get the count of bookings for each space
                       ->get();

        // Prepare data for Chart.js
        $labels = $spaces->pluck('name'); // Space names
        $data = $spaces->pluck('bookings_count'); // Corresponding booking counts

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    // Method to render the chart view
    public function showChart()
    {
        return view('spaces.chart');
    }
}
