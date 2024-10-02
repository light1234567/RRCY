<?php

namespace App\Http\Controllers;

use App\Models\RtcProvince;
use Illuminate\Http\Request;

class RtcController extends Controller
{
    /**
     * Fetch all provinces with their related RTC branches.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRtcBranches()
    {
        // Fetch provinces with their related branches using Eloquent ORM
        $provinces = RtcProvince::with('branches')->get();

        // Return the data as a JSON response
        return response()->json($provinces);
    }
}
