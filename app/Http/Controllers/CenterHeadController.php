<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CenterHead; // Make sure you have a CenterHead model

class CenterHeadController extends Controller
{
    // Method to get the center head's name
    public function getCenterHead()
    {
        // Fetch the center head (assuming there's only one record)
        $centerHead = CenterHead::first();

        // Return the center head as a JSON response
        return response()->json([
            'name' => $centerHead ? $centerHead->name : 'No Center Head Found'
        ]);
    }
}
