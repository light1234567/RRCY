<?php

namespace App\Http\Controllers;

use App\Models\PsychologicalInterventionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PsychologicalInterventionPlanController extends Controller
{
    public function store(Request $request)
    {
        Log::info("Creating or updating a Psychological Intervention Plan");

        // Validate the incoming request data
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'as_of_date' => 'nullable|date',
            'progress_notes' => 'nullable|string',
            'objectives' => 'nullable|string',
            'activities' => 'nullable|string',
            'responsible_person' => 'nullable|string|max:255',
            'time_frame' => 'nullable|string|max:255',
            'expected_output' => 'nullable|string',
            'progress' => 'nullable|string',
            'prepared_by' => 'nullable|string|max:255',
            'noted_by' => 'nullable|string|max:255',
        ]);

        try {
            // Check if a Psychological Intervention Plan already exists for the given client_id
            $plan = PsychologicalInterventionPlan::where('client_id', $request->client_id)->first();

            if ($plan) {
                // Update the existing plan
                $plan->update($validatedData);
                Log::info("Successfully updated Psychological Intervention Plan", $plan->toArray());
                return response()->json($plan, 200);
            } else {
                // Create a new plan
                $plan = PsychologicalInterventionPlan::create($validatedData);
                Log::info("Successfully created new Psychological Intervention Plan", $plan->toArray());
                return response()->json($plan, 201);
            }
        } catch (\Exception $e) {
            // Log the error with detailed information
            Log::error("Error creating or updating Psychological Intervention Plan", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $validatedData
            ]);

            // Return a JSON response with the error message
            return response()->json(['message' => 'Failed to create or update plan', 'error' => $e->getMessage()], 500);
        }
    }



public function show($id)
{
    Log::info("Fetching Psychological Intervention Plan for client_id: $id");

    try {
        $plan = PsychologicalInterventionPlan::with('client')->where('client_id', $id)->first();

        if ($plan) {
            $client = $plan->client;
            $admission = $client->admissions()->first();

            Log::info("Fetched plan data:", [
                'plan' => $plan->toArray(),
                'client' => $client->toArray(),
                'admission' => $admission ? $admission->toArray() : null,
            ]);

            return response()->json([
                'plan' => $plan,
                'client_name' => $client->first_name . ' ' . ($client->middle_name ? $client->middle_name . ' ' : '') . $client->last_name,
                'age' => \Carbon\Carbon::parse($client->date_of_birth)->age,
                'date_admitted' => $admission->date_admitted ?? null,
            ]);
        } else {
            Log::warning("No plan found for client_id: $id");
            return response()->json(['message' => 'Not found'], 404);
        }
    } catch (\Exception $e) {
        Log::error("Error fetching Psychological Intervention Plan for client_id: $id", [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        return response()->json(['message' => 'Failed to fetch plan'], 500);
    }
}




public function update(Request $request, $id)
{
    Log::info("Attempting to update Psychological Intervention Plan for client_id: $id");

    // Validate the incoming request data
    $validatedData = $request->validate([
        'as_of_date' => 'nullable|date',
        'progress_notes' => 'nullable|string',
        'objectives' => 'nullable|string',
        'activities' => 'nullable|string',
        'responsible_person' => 'nullable|string|max:255',
        'time_frame' => 'nullable|string|max:255',
        'expected_output' => 'nullable|string',
        'progress' => 'nullable|string',
        'prepared_by' => 'nullable|string|max:255',
        'noted_by' => 'nullable|string|max:255',
    ]);

    try {
        // Try to find the existing plan by client_id
        $plan = PsychologicalInterventionPlan::where('client_id', $id)->first();

        if ($plan) {
            // If the plan exists, update it
            $plan->update($validatedData);
            Log::info("Successfully updated Psychological Intervention Plan", $plan->toArray());
            return response()->json($plan, 200);
        } else {
            // If the plan does not exist, create a new one
            $validatedData['client_id'] = $id; // Ensure the client_id is set in the validated data
            $newPlan = PsychologicalInterventionPlan::create($validatedData);
            Log::info("Successfully created new Psychological Intervention Plan", $newPlan->toArray());
            return response()->json($newPlan, 201);
        }
    } catch (\Exception $e) {
        // Log the error with detailed information
        Log::error("Error creating or updating Psychological Intervention Plan", [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'data' => $validatedData
        ]);

        // Return a JSON response with the error message
        return response()->json(['message' => 'Failed to create or update plan', 'error' => $e->getMessage()], 500);
    }
}


}
