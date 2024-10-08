<?php

namespace App\Http\Controllers;

use App\Models\GeneralIntakeSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GeneralIntakeSheetController extends Controller
{
    public function index(Request $request)
{
    try {
        if ($request->has('client_id')) {
            // Filter general intake sheets by client_id if provided
            $sheets = GeneralIntakeSheet::where('client_id', $request->client_id)->get();
        } else {
            // Return all general intake sheets if no client_id is provided
            $sheets = GeneralIntakeSheet::all();
        }

        return response()->json($sheets);
    } catch (\Exception $e) {
        Log::error("Error fetching general intake sheets: " . $e->getMessage());
        return response()->json(['message' => 'Server Error'], 500);
    }
}
    public function store(Request $request)
{
    // Log the start of the method and incoming request data
    Log::info('Storing or updating General Intake Sheet. Incoming request data:', $request->all());

    // Validate the incoming request data
    $validatedData = $request->validate([
        'client_id' => 'required|exists:clients,id',
        'date' => 'nullable|date',
        'occupation' => 'nullable|string|max:20',
        'highest_educ_att' => 'nullable|string|max:20',
        'school_name' => 'nullable|string|max:50',
        'class_adviser' => 'nullable|string|max:50',
        'problem_presented' => 'nullable|string|max:150',
        'brief_physical_description' => 'nullable|string|max:150',
        'major_life_event' => 'nullable|array',
        'enduring_life_strain' => 'nullable|array',
        'life_transition' => 'nullable|array',
        'development_changes' => 'nullable|array',
        'normalization' => 'nullable|array',
        'behaviour_towards_incident' => 'nullable|array',
        'attachments' => 'nullable|array',
        'skills' => 'nullable|array',
        'resources' => 'nullable|array',
        'earnings_income' => 'nullable|string|max:20',
        'source_of_income_in_street' => 'nullable|array',
        'hrs_stay_in_street' => 'nullable|string|max:10',
        'length_stay_in_street' => 'nullable|string|max:10',
        'common_substance_used' => 'nullable|string|max:20',
        'initial_assessment' => 'nullable|string',
        'recommendations' => 'nullable|string',
        'prepared_by' => 'nullable|string|max:50',
        'first_intake_case_manager' => 'nullable|string|max:50',
        'reviewed_by' => 'nullable|string|max:50',
    ]);    

    try {
        // Check if a General Intake Sheet already exists for this client
        $sheet = GeneralIntakeSheet::where('client_id', $validatedData['client_id'])->first();

        if ($sheet) {
            // If the sheet exists, update it
            $sheet->update($validatedData);
            Log::info('General Intake Sheet updated successfully:', $sheet->toArray());

            return response()->json($sheet, 200); // 200 OK
        } else {
            // If no sheet exists, create a new one
            $newSheet = GeneralIntakeSheet::create($validatedData);
            Log::info('General Intake Sheet created successfully:', $newSheet->toArray());

            return response()->json($newSheet, 201); // 201 Created
        }
    } catch (\Exception $e) {
        // Log any error that occurs during the process
        Log::error('Error occurred while creating or updating General Intake Sheet:', ['error' => $e->getMessage()]);

        return response()->json(['message' => 'Error creating or updating General Intake Sheet.'], 500);
    }
}

public function show($id)
{
    Log::info("Fetching General Intake Sheet with ID: " . $id);

    $sheet = GeneralIntakeSheet::find($id);
    if ($sheet) {
        Log::info("Found General Intake Sheet: " . json_encode($sheet));
        return response()->json($sheet);
    }

    Log::warning("General Intake Sheet not found with ID: " . $id);
    return response()->json(['message' => 'Not found'], 404);
}

    

public function update(Request $request, $id)
{
    $sheet = GeneralIntakeSheet::find($id);
    if ($sheet) {
        $validatedData = $request->validate([
        'client_id' => 'required|exists:clients,id',
        'date' => 'nullable|date',
        'occupation' => 'nullable|string|max:20',
        'highest_educ_att' => 'nullable|string|max:20',
        'school_name' => 'nullable|string|max:50',
        'class_adviser' => 'nullable|string|max:50',
        'problem_presented' => 'nullable|string|max:150',
        'brief_physical_description' => 'nullable|string|max:150',
        'major_life_event' => 'nullable|array',
        'enduring_life_strain' => 'nullable|array',
        'life_transition' => 'nullable|array',
        'development_changes' => 'nullable|array',
        'normalization' => 'nullable|array',
        'behaviour_towards_incident' => 'nullable|array',
        'attachments' => 'nullable|array',
        'skills' => 'nullable|array',
        'resources' => 'nullable|array',
        'earnings_income' => 'nullable|string|max:20',
        'source_of_income_in_street' => 'nullable|array',
        'hrs_stay_in_street' => 'nullable|string|max:10',
        'length_stay_in_street' => 'nullable|string|max:10',
        'common_substance_used' => 'nullable|string|max:20',
        'initial_assessment' => 'nullable|string',
        'recommendations' => 'nullable|string',
        'prepared_by' => 'nullable|string|max:50',
        'first_intake_case_manager' => 'nullable|string|max:50',
        'reviewed_by' => 'nullable|string|max:50',
            ]); 

            $sheet->update($validatedData);
            return response()->json($sheet);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function destroy($id)
    {
        $sheet = GeneralIntakeSheet::find($id);
        if ($sheet) {
            $sheet->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
