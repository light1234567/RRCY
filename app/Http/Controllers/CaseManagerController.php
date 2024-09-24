<?php

namespace App\Http\Controllers;

use App\Models\CaseManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CaseManagerController extends Controller
{
    // Store or update the case manager data
    // Store or update the case manager data
    public function storeCaseManager(Request $request)
    {
        try {
            Log::info('Received request to store or update Case Manager.', [
                'client_id' => $request->input('client_id'),
                'name' => $request->input('name')  // Make sure the name field matches
            ]);
    
            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'name' => 'nullable|string|max:50',  // Validate the name field
            ]);
    
            Log::info('Validated data for storing Case Manager:', $validatedData);
    
            $caseManager = CaseManager::updateOrCreate(
                ['client_id' => $validatedData['client_id']],
                ['name' => $validatedData['name']]
            );
    
            Log::info('Case Manager stored or updated successfully.', [
                'client_id' => $caseManager->client_id,
                'name' => $caseManager->name
            ]);
    
            return response()->json([
                'message' => 'Case Manager saved successfully',
                'case_manager' => $caseManager,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error:', $e->errors());  // Log validation error details
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
    

    // Fetch the case manager for a specific client
    public function getCaseManager($clientId)
    {
        Log::info('Fetching Case Manager for client_id:', ['client_id' => $clientId]);  // Log client ID

        $caseManager = CaseManager::where('client_id', $clientId)->first();

        if (!$caseManager) {
            Log::warning('Case Manager not found for client_id:', ['client_id' => $clientId]);  // Log case manager not found
            return response()->json(['message' => 'Case Manager not found'], 404);
        }

        Log::info('Fetched Case Manager for client_id:', [
            'client_id' => $clientId,
            'name' => $caseManager->name
        ]);  // Log the fetched case manager

        return response()->json([
            'case_manager' => $caseManager->name,
        ], 200);
    }
}
