<?php

namespace App\Http\Controllers;

use App\Models\PerformanceObservationReport;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Log;

class PerformanceObservationReportController extends Controller
{
    // Fetch report data for a client
    public function index($clientId)
    {
        Log::info("Fetching report for client ID: $clientId");

        $report = PerformanceObservationReport::where('client_id', $clientId)->first();

        if ($report) {
            Log::info("Report found for client ID: $clientId");
            return response()->json($report);
        } else {
            Log::warning("Report not found for client ID: $clientId");
            return response()->json(['message' => 'Report not found'], 404);
        }
    }

    // Store or Update report data
    public function storeOrUpdate(Request $request, $clientId = null)
{
    Log::info("Store or update report request received for client ID: $clientId", ['request_data' => $request->all()]);

    // Validation
    $validated = $request->validate([
        'client_id' => 'required|exists:clients,id',
        'period' => 'nullable|string',
        'assessment_date' => 'nullable|date',
        'trainings_attended' => 'nullable|string',
        'general_remarks' => 'nullable|string',
        'prepared_by_one' => 'nullable|string',
        'prepared_by_two' => 'nullable|string',
        
        // Validating JSON fields
        'sections' => 'nullable|array',
        'sections.*.title' => 'nullable|string',
        'sections.*.sub_total' => 'nullable|numeric',
        'sections.*.remarks' => 'nullable|string',
        'sections.*.indicators' => 'nullable|array',
        'sections.*.indicators.*.self_rating' => 'nullable|numeric|min:0|max:4',
        'sections.*.indicators.*.mdo_rating' => 'nullable|numeric|min:0|max:4',
        'trainings' => 'nullable|array',
        'trainings.*.title' => 'nullable|string',
        'trainings.*.date_of_attendance' => 'nullable|date',
        'trainings.*.status' => 'nullable|string',
    ]);

    // Check if a report exists for the client
    $report = PerformanceObservationReport::where('client_id', $clientId)->first();

    if ($report) {
        // If the report exists, update it
        Log::info("Updating report for client ID: $clientId");
        $report->update($validated);
        return response()->json(['message' => 'Report updated successfully']);
    } else {
        // If no report exists, create a new one
        Log::info("Creating a new report for client ID: $clientId", ['validated_data' => $validated]);
        PerformanceObservationReport::create($validated);
        return response()->json(['message' => 'Report created successfully']);
    }
}

public function show($clientId)
{
    Log::info("Fetching report for client ID: $clientId");

    // Fetch the report and the client
    $report = PerformanceObservationReport::where('client_id', $clientId)->first();
    $client = Client::find($clientId);

    // Check if the report exists
    if ($report) {
        Log::info("Report found for client ID: $clientId");

        // Ensure the trainings array is returned as part of the report
        return response()->json([
            'report' => $report,
            'client' => $client,
            'trainings' => $report->trainings  // This will include the trainings array
        ]);
    } else {
        Log::warning("Report not found for client ID: $clientId");
        return response()->json(['message' => 'Report not found', 'client' => $client], 404);
    }
}



    // Delete report
    public function destroy($clientId)
    {
        Log::info("Deleting report for client ID: $clientId");

        $report = PerformanceObservationReport::where('client_id', $clientId)->first();

        if ($report) {
            $report->delete();
            Log::info("Report deleted for client ID: $clientId");
            return response()->json(['message' => 'Report deleted successfully']);
        } else {
            Log::warning("Report not found for client ID: $clientId during deletion");
            return response()->json(['message' => 'Report not found'], 404);
        }
    }
}
