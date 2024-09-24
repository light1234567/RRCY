<?php

namespace App\Http\Controllers;

use App\Models\SHP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SHPController extends Controller
{
    // Store or update SHP data
    public function storeSHP(Request $request)
{
    try {
        Log::info('Received request to store or update SHP.', [
            'client_id' => $request->input('client_id'),
            'name' => $request->input('name')
        ]);

        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'name' => 'nullable|string|max:50',
        ]);

        Log::info('Validated data for storing SHP:', $validatedData);

        // Use updateOrCreate to either create or update the SHP entry
        $shp = SHP::updateOrCreate(
            ['client_id' => $validatedData['client_id']],
            ['name' => $validatedData['name']]
        );

        Log::info('SHP stored or updated successfully.', [
            'client_id' => $shp->client_id,
            'name' => $shp->name
        ]);

        return response()->json([
            'message' => 'SHP saved successfully',
            'shp' => $shp,
        ], 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Validation error:', $e->errors());
        return response()->json(['errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        Log::error('Error storing SHP:', [
            'error' => $e->getMessage(),
            'client_id' => $request->input('client_id')
        ]);
        return response()->json(['message' => 'Failed to store SHP', 'error' => $e->getMessage()], 500);
    }
}


    // Fetch SHP for a specific client
    public function getSHP($clientId)
    {
        Log::info('Fetching SHP for client_id:', ['client_id' => $clientId]);

        $shp = SHP::where('client_id', $clientId)->first();

        if (!$shp) {
            Log::warning('SHP not found for client_id:', ['client_id' => $clientId]);
            return response()->json(['message' => 'SHP not found'], 404);
        }

        Log::info('Fetched SHP for client_id:', [
            'client_id' => $clientId,
            'name' => $shp->name
        ]);

        return response()->json([
            'shp' => $shp->name,
        ], 200);
    }
}
