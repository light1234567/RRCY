<?php

namespace App\Http\Controllers;

use App\Models\IncidentReport;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IncidentReportController extends Controller
{
    public function index()
    {
        $reports = IncidentReport::with('client')->get();
        return response()->json($reports);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'drn' => 'nullable|string|max:25',
            'incident' => 'nullable|string',
            'date_of_incident' => 'nullable|date',
            'time_of_incident' => 'nullable|date_format:H:i',
            'involved' => 'nullable|string',
            'location' => 'nullable|string',
            'action_taken' => 'nullable|string',
            'agreements' => 'nullable|string',
            'corrective_measure' => 'nullable|string',
            'prepared_by' => 'nullable|string|max:50',
            'incident_report_shp' => 'nullable|string|max:50',
            'approved_by' => 'nullable|string|max:50',
        ]);        

        try {
            $report = IncidentReport::create($validatedData);

            Log::info("Successfully saved Incident Report", $report->toArray());
            return response()->json($report, 201);
        } catch (\Exception $e) {
            Log::error("Error storing Incident Report", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $validatedData
            ]);

            return response()->json(['message' => 'Failed to store report', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($client_id)
    {
        $client = Client::find($client_id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $report = IncidentReport::where('client_id', $client_id)->first();

        return response()->json([
            'report' => $report,
            'client' => $client,
        ]);
    }

    public function update(Request $request, $client_id)
{
    Log::info('Updating Incident Report', $request->all());

    // Validate the incoming request data
    $validatedData = $request->validate([
        'drn' => 'nullable|string|max:25',
        'incident' => 'nullable|string',
        'date_of_incident' => 'nullable|date',
        'time_of_incident' => 'nullable|date_format:H:i',
        'involved' => 'nullable|string',
        'location' => 'nullable|string',
        'action_taken' => 'nullable|string',
        'agreements' => 'nullable|string',
        'corrective_measure' => 'nullable|string',
        'prepared_by' => 'nullable|string|max:50',
        'incident_report_shp' => 'nullable|string|max:50',
        'approved_by' => 'nullable|string|max:50',
    ]);    

    try {
        $report = IncidentReport::updateOrCreate(
            [
                'client_id' => $client_id,
                'date_of_incident' => $validatedData['date_of_incident']
            ],
            $validatedData
        );

        Log::info("Successfully updated Incident Report", $report->toArray());
        return response()->json($report, 200);
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error("Validation failed", $e->errors());
        return response()->json([
            'message' => 'Validation error',
            'errors' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        Log::error("Error updating Incident Report", [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'data' => $validatedData
        ]);

        return response()->json(['message' => 'Failed to update report', 'error' => $e->getMessage()], 500);
    }
}


    public function destroy($id)
    {
        $report = IncidentReport::find($id);
        if ($report) {
            $report->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
