<?php

namespace App\Http\Controllers;

use App\Models\CiclProgressNote;
use App\Models\Client;
use App\Models\Admission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CiclProgressNoteController extends Controller
{
    public function index()
    {
        $notes = CiclProgressNote::with('client', 'admission')->get();
        return response()->json($notes);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'admission_id' => 'required|exists:admissions,id',
            'intervention_period' => 'nullable|string|max:20',
            'problem_behavior_log' => 'nullable|string',
            'interventions_conducted' => 'nullable|string',
            'progress_notes' => 'nullable|string',
            'prepared_by' => 'nullable|string|max:50',
        ]);        

        try {
            // Use updateOrCreate to either update an existing record or create a new one
            $note = CiclProgressNote::updateOrCreate(
                [
                    'client_id' => $validatedData['client_id'],
                    'admission_id' => $validatedData['admission_id']
                ],
                $validatedData
            );

            Log::info("Successfully saved Progress Note", $note->toArray());
            return response()->json($note, 201);
        } catch (\Exception $e) {
            Log::error("Error storing Progress Note", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $validatedData
            ]);

            return response()->json(['message' => 'Failed to store note', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($client_id)
    {
        $client = Client::with('admissions')->find($client_id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $admission = $client->admissions->first();

        if (!$admission) {
            return response()->json(['message' => 'Admission not found'], 404);
        }

        $note = CiclProgressNote::where('client_id', $client_id)
            ->where('admission_id', $admission->id)
            ->first();

        return response()->json([
            'note' => $note,
            'client' => $client,
            'admission' => $admission,
        ]);
    }

    public function update(Request $request, $client_id)
    {
        $validatedData = $request->validate([
            'admission_id' => 'required|exists:admissions,id',
            'intervention_period' => 'nullable|string|max:20',
            'problem_behavior_log' => 'nullable|string',
            'interventions_conducted' => 'nullable|string',
            'progress_notes' => 'nullable|string',
            'prepared_by' => 'nullable|string|max:50',
        ]);        

        try {
            // Use updateOrCreate to either update an existing record or create a new one
            $note = CiclProgressNote::updateOrCreate(
                [
                    'client_id' => $client_id,
                    'admission_id' => $validatedData['admission_id']
                ],
                $validatedData
            );

            Log::info("Successfully updated/created Progress Note", $note->toArray());

            return response()->json($note, 200);
        } catch (\Exception $e) {
            Log::error("Error updating Progress Note", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $validatedData
            ]);

            return response()->json(['message' => 'Failed to update note', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $note = CiclProgressNote::find($id);
        if ($note) {
            $note->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
