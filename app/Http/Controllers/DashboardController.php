<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Space;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth; // Correct import for Auth

class DashboardController extends Controller
{

    public function index()
    {
        $ownedSpacesCount = \App\Models\Space::where('provider_id', auth()->id())->count();
        $approvedBookingsCount = Booking::where('status', 'Accepted')->count();
        $totalIncome = Booking::where('status', 'Accepted')->sum('total_price');
        $incomeData = Booking::select('start_date', 'total_price')
                             ->where('status', 'Accepted')
                             ->orderBy('start_date')
                             ->get()
                             ->map(function ($booking) {
                                 return [
                                     'start_date' => $booking->start_date->format('Y-m-d'), // Ensure correct date format
                                     'total_price' => $booking->total_price,
                                 ];
                             });

        // Pass the data to the view
        return view('admin', compact('ownedSpacesCount', 'approvedBookingsCount', 'totalIncome', 'incomeData'));
    }
    }
    
