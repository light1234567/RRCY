<?php

namespace App\Http\Controllers;

use App\Models\Brgy;
use App\Models\CityMuni;
use App\Models\Province;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getProvinces()
    {
        return response()->json(Province::all());
    }

    public function getCityMunis($provincePsgc)
    {
        // Assuming the first 4 characters of psgc represent the province
        $provincePrefix = substr($provincePsgc, 0, 4);
        return response()->json(
            CityMuni::where('psgc', 'like', $provincePrefix . '%')->get()
        );
    }

    public function getBarangays($cityMuniPsgc)
    {
        // Assuming the first 6 characters of psgc represent the city/municipality
        $cityMuniPrefix = substr($cityMuniPsgc, 0, 6);
        return response()->json(
            Brgy::where('psgc', 'like', $cityMuniPrefix . '%')->get()
        );
    }
}
