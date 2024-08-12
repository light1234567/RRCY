<?php
namespace App\Http\Controllers;

use App\Models\AnecdotalReport;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AnecdotalReportController extends Controller
{
    public function index()
    {
        $reports = AnecdotalReport::with('client')->get();
        return response()->json($reports);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date',
            'drn' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'physical' => 'nullable|string',
            'emotional' => 'nullable|string',
            'behavioral' => 'nullable|string',
            'spiritual' => 'nullable|string',
            'recommendation' => 'nullable|string',
            'noted_by' => 'nullable|string|max:255',
            'approved_by' => 'nullable|string|max:255',
            'prepared_by' => 'nullable|string|max:255',
            'house_parents' => 'nullable|string|max:255',
            'house_parents_signature' => 'nullable|image|max:10240', // Validate image and size up to 10MB
            'residents' => 'nullable|string|max:255',
            'residents_signature' => 'nullable|image|max:10240', // Validate image and size up to 10MB
        ]);

        try {
            // Handle file uploads
            if ($request->hasFile('house_parents_signature')) {
                $validatedData['house_parents_signature'] = $request->file('house_parents_signature')->store('signatures', 'public');
            }

            if ($request->hasFile('residents_signature')) {
                $validatedData['residents_signature'] = $request->file('residents_signature')->store('signatures', 'public');
            }

            $report = AnecdotalReport::updateOrCreate(
                [
                    'client_id' => $validatedData['client_id'],
                    'date' => $validatedData['date'],
                ],
                $validatedData
            );

            Log::info("Successfully saved Anecdotal Report", $report->toArray());
            return response()->json($report, 201);
        } catch (\Exception $e) {
            Log::error("Error storing Anecdotal Report", [
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

        $report = AnecdotalReport::where('client_id', $client_id)->first();

        if ($report) {
            // Add full URLs for the signatures if they exist
            if ($report->house_parents_signature) {
                $report->house_parents_signature = Storage::url($report->house_parents_signature);
            }
            if ($report->residents_signature) {
                $report->residents_signature = Storage::url($report->residents_signature);
            }
        }

        return response()->json([
            'report' => $report,
            'client' => $client,
        ]);
    }

    public function update(Request $request, $client_id)
    {
        Log::info('Updating Anecdotal Report', $request->all());

        $validatedData = $request->validate([
            'date' => 'required|date',
            'drn' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'physical' => 'nullable|string',
            'emotional' => 'nullable|string',
            'behavioral' => 'nullable|string',
            'spiritual' => 'nullable|string',
            'recommendation' => 'nullable|string',
            'noted_by' => 'nullable|string|max:255',
            'approved_by' => 'nullable|string|max:255',
            'prepared_by' => 'nullable|string|max:255',
            'house_parents' => 'nullable|string|max:255',
            'house_parents_signature' => 'nullable|image|max:10240', // Validate image and size up to 10MB
            'residents' => 'nullable|string|max:255',
            'residents_signature' => 'nullable|image|max:10240', // Validate image and size up to 10MB
        ]);

        try {
            // Handle file uploads
            if ($request->hasFile('house_parents_signature')) {
                $validatedData['house_parents_signature'] = $request->file('house_parents_signature')->store('signatures', 'public');
            }

            if ($request->hasFile('residents_signature')) {
                $validatedData['residents_signature'] = $request->file('residents_signature')->store('signatures', 'public');
            }

            $report = AnecdotalReport::updateOrCreate(
                [
                    'client_id' => $client_id,
                    'date' => $validatedData['date'],
                ],
                $validatedData
            );

            Log::info("Successfully updated Anecdotal Report", $report->toArray());

            return response()->json($report, 200);
        } catch (\Exception $e) {
            Log::error("Error updating Anecdotal Report", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $validatedData
            ]);

            return response()->json(['message' => 'Failed to update report', 'error' => $e->getMessage()], 500);
        }
    }
    

    public function destroy($id)
    {
        $report = AnecdotalReport::find($id);
        if ($report) {
            $report->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
