<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Space;

class SpaceOwnerController extends Controller
{
    // Method to get chart data
    public function getChartData()
    {
        // Fetch data from the database, e.g., bookings per month for the space owner
        $spaces = Space::where('provider_id', auth()->id()) // Assuming you have owner_id to filter the spaces owned by the logged-in owner
                       ->with('bookings') // Assuming you have a relationship 'bookings' defined
                       ->get();

        // Process the data as needed for the chart
        $data = $spaces->map(function($space) {
            return [
                'spaceName' => $space->name,
                'bookingsCount' => $space->bookings->count(),
                // Add more metrics as needed
            ];
        });

        return response()->json($data);
    }
}
