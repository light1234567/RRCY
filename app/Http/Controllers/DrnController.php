<?php

namespace App\Http\Controllers;

use App\Models\Drn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DrnController extends Controller
{
    // Store or update the DRN data
    public function storeDrn(Request $request)
{
    try {
        Log::info('Received request to store or update DRN.', [
            'client_id' => $request->input('client_id'),
            'drn' => $request->input('drn')
        ]);

        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'drn' => 'nullable|string|max:50',
        ]);

        Log::info('Validated data for storing DRN:', $validatedData);

        // Create or update the DRN record
        $drn = Drn::updateOrCreate(
            ['client_id' => $validatedData['client_id']],
            ['drn' => $validatedData['drn']]
        );

        Log::info('DRN stored or updated successfully.', [
            'client_id' => $drn->client_id,
            'drn' => $drn->drn
        ]);

        return response()->json([
            'message' => 'DRN saved successfully',
            'drn' => $drn,
        ], 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Validation error:', $e->errors());
        return response()->json(['errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        Log::error('Error storing DRN:', $e->getMessage());
        return response()->json(['message' => 'Failed to store DRN'], 500);
    }
}


    // Fetch the DRN for a specific client
    public function getDrn($clientId)
    {
        Log::info('Fetching DRN for client_id:', ['client_id' => $clientId]);

        $drn = Drn::where('client_id', $clientId)->first();

        if (!$drn) {
            Log::warning('DRN not found for client_id:', ['client_id' => $clientId]);
            return response()->json(['message' => 'DRN not found'], 404);
        }

        Log::info('Fetched DRN for client_id:', [
            'client_id' => $clientId,
            'drn' => $drn->drn
        ]);

        return response()->json([
            'drn' => $drn->drn,
        ], 200);
    }
}
