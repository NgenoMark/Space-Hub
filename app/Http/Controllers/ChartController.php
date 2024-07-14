<?php

// ChartController.php

namespace App\Http\Controllers;

use App\Models\Booking; // Adjust the model namespace as per your application
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function chartData()
    {
        // Example: Fetch data from the database
        $bookingsData = Booking::selectRaw('space_name, count(*) as total_bookings')
                             ->groupBy('space_name')
                             ->get();

        // Prepare data in a format suitable for Chart.js
        $labels = $bookingsData->pluck('space_name')->toArray();
        $data = $bookingsData->pluck('total_bookings')->toArray();

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }
}

