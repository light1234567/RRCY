<?php

namespace App\Http\Controllers;

use App\Models\Talambuhay;
use Illuminate\Http\Request;

class TalambuhayController extends Controller
{
    public function index()
    {
        $talambuhay = Talambuhay::all();
        return response()->json($talambuhay);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'about_my_family' => 'nullable|string',
            'about_my_self' => 'nullable|string',
            'about_my_case' => 'nullable|string',
            'talambuhay_case_manager' => 'nullable|string|max:50',
            'date' => 'nullable|date',
        ]);

        $talambuhay = Talambuhay::create($validatedData);
        return response()->json($talambuhay, 201);
    }

    public function showByClientId($clientId)
    {
        $talambuhay = Talambuhay::where('client_id', $clientId)->first();
        if ($talambuhay) {
            return response()->json($talambuhay);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
    

    public function updateByClientId(Request $request, $clientId)
{
    // Find Talambuhay record by client_id
    $talambuhay = Talambuhay::where('client_id', $clientId)->first();

    // Check if the record exists
    if ($talambuhay) {
        // Validate the request data
        $validatedData = $request->validate([
            'about_my_family' => 'nullable|string',
            'about_my_self' => 'nullable|string',
            'about_my_case' => 'nullable|string',
            'talambuhay_case_manager' => 'nullable|string|max:50',
            'date' => 'nullable|date',
        ]);

        // Update the existing Talambuhay record
        $talambuhay->update($validatedData);

        // Return the updated record
        return response()->json($talambuhay);
    }

    // If the record does not exist, return a 404 error
    return response()->json(['message' => 'Not found'], 404);
}


    public function destroy($id)
    {
        $talambuhay = Talambuhay::find($id);
        if ($talambuhay) {
            $talambuhay->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
?>
