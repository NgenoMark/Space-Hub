<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        // Your code to handle the request and return a response
        return view('warehouses.index'); // Make sure you have this view
    }
}
