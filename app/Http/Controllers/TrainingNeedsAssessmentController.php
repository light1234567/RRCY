<?php

namespace App\Http\Controllers;

use App\Models\TrainingNeedsAssessment;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrainingNeedsAssessmentController extends Controller
{
    /**
     * Display the specified resource.
     * 
     * @param  int  $client_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($client_id)
{
    Log::info("Fetching Training Needs Assessment for client ID {$client_id}");

    // Fetch client details
    $client = Client::find($client_id);

    if (!$client) {
        Log::warning("Client with ID {$client_id} not found");
        return response()->json(['message' => 'Client not found'], 404);
    }

    // Fetch the report, which includes education_details, training_details, and training_sector_details as JSON
    $report = TrainingNeedsAssessment::where('client_id', $client_id)->first();

    if (!$report) {
        Log::warning("Training Needs Assessment for client ID {$client_id} not found");
        return response()->json(['message' => 'Training Needs Assessment not found'], 404);
    }

    Log::info("Successfully fetched Training Needs Assessment for client ID {$client_id}");

    return response()->json([
        'report' => $report,  // Contains the JSON fields for education_details, training_details, etc.
        'client' => $client,
    ], 200);
}


    /**
     * Store or update the resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $client_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeOrUpdate(Request $request, $client_id)
{
    // Validate input data
    $validatedData = $request->validate([
        'social_worker' => 'nullable|string|max:50',
        'houseparent' => 'nullable|string|max:50',
        'father' => 'nullable|string|max:50',
        'mother' => 'nullable|string|max:50',
        'address' => 'nullable|string|max:150',
        'center_duration' => 'nullable|string|max:20',
        'period' => 'nullable|string|max:10',
        'date_of_admission' => 'nullable|date',
        'date' => 'nullable|date',
        'training_details' => 'nullable|array',
        'training_sector_details' => 'nullable|array',
        'education_details' => 'nullable|array',
    ]);

    try {
        // Find or create a new report for the client
        $report = TrainingNeedsAssessment::updateOrCreate(
            ['client_id' => $client_id],
            [
                'social_worker' => $validatedData['social_worker'] ?? null,
                'houseparent' => $validatedData['houseparent'] ?? null,
                'father' => $validatedData['father'] ?? null,
                'mother' => $validatedData['mother'] ?? null,
                'address' => $validatedData['address'] ?? null,
                'center_duration' => $validatedData['center_duration'] ?? null,
                'period' => $validatedData['period'] ?? null,
                'date_of_admission' => $validatedData['date_of_admission'] ?? null,
                'date' => $validatedData['date'] ?? null,
                'training_details' => $validatedData['training_details'] ?? [], // Store as JSON
                'training_sector_details' => $validatedData['training_sector_details'] ?? [], // Store as JSON
                'education_details' => $validatedData['education_details'] ?? [], // Store as JSON
            ]
        );

        return response()->json($report, 201);

    } catch (\Exception $e) {
        Log::error("Error storing/updating Training Needs Assessment for client ID {$client_id}", [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json(['message' => 'Failed to store/update report', 'error' => $e->getMessage()], 500);
    }
}

    /**
     * Delete the specified resource.
     * 
     * @param  int  $client_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($client_id)
    {
        Log::info("Deleting Training Needs Assessment for client ID {$client_id}");

        try {
            $report = TrainingNeedsAssessment::where('client_id', $client_id)->first();

            if (!$report) {
                Log::warning("Training Needs Assessment for client ID {$client_id} not found");
                return response()->json(['message' => 'Report not found'], 404);
            }

            $report->delete();

            Log::info("Successfully deleted Training Needs Assessment for client ID {$client_id}");
            return response()->json(['message' => 'Report deleted successfully'], 200);

        } catch (\Exception $e) {
            Log::error("Error deleting Training Needs Assessment for client ID {$client_id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['message' => 'Failed to delete report', 'error' => $e->getMessage()], 500);
        }
    }
}
