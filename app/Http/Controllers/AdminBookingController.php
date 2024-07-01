<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index()
    {
        // Logic to fetch and return bookings data
        return view('admin.bookings.index'); // Adjust this according to your view structure
    }
}
