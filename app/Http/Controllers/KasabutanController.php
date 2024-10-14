<?php

namespace App\Http\Controllers;

use App\Models\Kasabutan;
use Illuminate\Http\Request;

class KasabutanController extends Controller
{
    public function index()
    {
        $kasabutans = Kasabutan::all();
        return response()->json($kasabutans);
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'client_id' => 'nullable|exists:clients,id',
        'client_resident' => 'nullable|string|max:50', 
        'parent_guardian' => 'nullable|string|max:50', 
        'first_kasabutan_case_manager' => 'nullable|string|max:50', 
        'second_kasabutan_case_manager' => 'nullable|string|max:50',
    ]);

    // Check if the record with the given client_id exists
    if (isset($validatedData['client_id'])) {
        $kasabutan = Kasabutan::where('client_id', $validatedData['client_id'])->first();
        if ($kasabutan) {
            // If the record exists, update it
            $kasabutan->update($validatedData);
            return response()->json($kasabutan, 200); // OK status for update
        }
    }

    // If no record exists or client_id is null, create a new record
    $kasabutan = Kasabutan::create($validatedData);
    return response()->json($kasabutan, 201); // Created status for new record
}


    public function show($id)
    {
        $kasabutan = Kasabutan::find($id);
        if ($kasabutan) {
            return response()->json($kasabutan);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function showByClientId($client_id)
{
    $kasabutan = Kasabutan::where('client_id', $client_id)->first();
    if ($kasabutan) {
        return response()->json($kasabutan);
    }
    return response()->json(['message' => 'Not found'], 404);
}

    public function update(Request $request, $id)
    {
        $kasabutan = Kasabutan::find($id);
        if ($kasabutan) {
            $validatedData = $request->validate([
                'client_id' => 'nullable|exists:clients,id',
                'client_resident' => 'nullable|string|max:50', 
                'parent_guardian' => 'nullable|string|max:50', 
                'first_kasabutan_case_manager' => 'nullable|string|max:50', 
                'second_kasabutan_case_manager' => 'nullable|string|max:50',
            ]);

            $kasabutan->update($validatedData);
            return response()->json($kasabutan);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function destroy($id)
    {
        $kasabutan = Kasabutan::find($id);
        if ($kasabutan) {
            $kasabutan->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
