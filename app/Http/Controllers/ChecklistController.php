<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChecklistController extends Controller
{
    public function index($clientId)
{
    Log::info("Fetching checklist for client ID: $clientId");

    try {
        $checklist = Checklist::where('client_id', $clientId)->first();

        if (!$checklist) {
            // Optionally create a blank checklist if none exists
            $checklist = Checklist::create([
                'client_id' => $clientId,
                'admitting_officer' => '',
                'documents' => json_encode([]), // Empty JSON for documents
                'rrcy_forms' => json_encode([]), // Empty JSON for forms
            ]);
        }

        // Decode JSON fields to ensure they are returned as arrays
        $checklist->documents = json_decode($checklist->documents, true);
        $checklist->rrcy_forms = json_decode($checklist->rrcy_forms, true);

        return response()->json($checklist);
    } catch (\Exception $e) {
        Log::error('Error fetching checklist: ' . $e->getMessage());
        return response()->json(['message' => 'Error fetching checklist', 'error' => $e->getMessage()], 500);
    }
}



public function store(Request $request)
{
    $validatedData = $request->validate([
        'client_id' => 'required|exists:clients,id',
        'admitting_officer' => 'nullable|string|max:50', 
        'case_manager' => 'nullable|string|max:50', 
        'documents' => 'nullable|array',
        'documents.*.document' => 'nullable|string|max:50', 
        'documents.*.yes' => 'nullable|boolean',
        'documents.*.no' => 'nullable|boolean',
        'documents.*.remarks' => 'nullable|string|max:150', 
        'documents.*.subItems' => 'nullable|array',
        'documents.*.subItems.*.document' => 'nullable|string|max:150', 
        'documents.*.subItems.*.yes' => 'nullable|boolean',
        'documents.*.subItems.*.no' => 'nullable|boolean',
        'documents.*.subItems.*.remarks' => 'nullable|string|max:150', 
        'rrcy_forms' => 'nullable|array',
        'rrcy_forms.*.form' => 'nullable|string|max:150', 
        'rrcy_forms.*.yes' => 'nullable|boolean',
        'rrcy_forms.*.no' => 'nullable|boolean',
        'rrcy_forms.*.remarks' => 'nullable|string|max:150', 
    ]);

    // Handling of the documents and their sub-items
    $documents = array_map(function($document) {
        if (isset($document['subItems']) && is_array($document['subItems'])) {
            // Encode sub-items
            $document['subItems'] = $document['subItems'];
        }
        return $document;
    }, $validatedData['documents'] ?? []);

    // Store the checklist in the database
    $checklist = Checklist::updateOrCreate(
        ['client_id' => $validatedData['client_id']],
        [
            'admitting_officer' => $validatedData['admitting_officer'],
            'case_manager' => $validatedData['case_manager'],
            'documents' => json_encode($documents),  // Store as JSON
            'rrcy_forms' => json_encode($validatedData['rrcy_forms']),
        ]
    );

    return response()->json(['message' => 'Checklist saved successfully', 'checklist' => $checklist], 201);
}


    public function update(Request $request, $clientId)
    {
        $checklist = Checklist::where('client_id', $clientId)->first();

        if (!$checklist) {
            return response()->json(['message' => 'Checklist not found'], 404);
        }

        $validatedData = $request->validate([
            'admitting_officer' => 'nullable|string|max:255',
            'case_manager' => 'nullable|string|max:255',
            'documents' => 'nullable|array',
            'rrcy_forms' => 'nullable|array',
        ]);

        $checklist->update([
            'admitting_officer' => $validatedData['admitting_officer'] ?? $checklist->admitting_officer,
            'case_manager' => $validatedData['case_manager'] ?? $checklist->case_manager,
            'documents' => $validatedData['documents'] ? json_encode($validatedData['documents']) : $checklist->documents,
            'rrcy_forms' => $validatedData['rrcy_forms'] ? json_encode($validatedData['rrcy_forms']) : $checklist->rrcy_forms,
        ]);

        return response()->json(['message' => 'Checklist updated successfully']);
    }

    public function destroy($clientId)
    {
        $checklist = Checklist::where('client_id', $clientId)->first();

        if (!$checklist) {
            return response()->json(['message' => 'Checklist not found'], 404);
        }

        $checklist->delete();

        return response()->json(['message' => 'Checklist deleted successfully']);
    }
}
