<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Space;


class SearchController extends Controller
{
    public function search(Request $request)
    {
        $location = $request->input('location');
        $capacity = $request->input('capacity');
        $price_min = $request->input('price_min');
        $price_max = $request->input('price_max');

        $spaces = Space::where('location', 'like', '%' . $location . '%')
            ->where('capacity', '>=', $capacity)
            ->whereBetween('price', [$price_min, $price_max])
            ->get();

        return response()->json($spaces);
    }
}

