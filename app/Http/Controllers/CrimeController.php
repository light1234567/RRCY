<?php

namespace App\Http\Controllers;

use App\Models\CrimeCategory;
use Illuminate\Http\Request;

class CrimeController extends Controller
{
    /**
     * Fetch all categories with their related crimes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCrimes()
    {
        // Fetch categories with their related crimes using Eloquent ORM
        $categories = CrimeCategory::with('crimes')->get();

        // Return the data as a JSON response
        return response()->json($categories);
    }
}
