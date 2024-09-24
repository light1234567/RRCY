<?php

namespace App\Http\Controllers;

use App\Models\SecondIntakeSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SecondIntakeSheetController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->has('client_id')) {
                // Search second intake sheets by client_id if provided
                $sheets = SecondIntakeSheet::where('client_id', $request->client_id)->get();
            } elseif ($request->has('admission_id')) {
                // Search second intake sheets by admission_id if provided
                $sheets = SecondIntakeSheet::where('admission_id', $request->admission_id)->get();
            } else {
                $sheets = SecondIntakeSheet::all();
            }

            return response()->json($sheets);
        } catch (\Exception $e) {
            Log::error("Error fetching second intake sheets: " . $e->getMessage());
            return response()->json(['message' => 'Server Error'], 500);
        }
    }

    public function store(Request $request)
    {
        Log::info('Storing new second intake sheet. Request data:', $request->all());

        try {
            // Validate request data
            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'general_intake_id' => 'nullable|exists:general_intake_sheets,id',
                'date' => 'nullable|date',
                'vices' => 'nullable|array',
                'school_activities_achievement' => 'nullable|string',
                'occupation_of_mother' => 'nullable|string|max:50', 
                'occupation_of_father' => 'nullable|string|max:50', 
                'siblings' => 'nullable|array',
                'responsible_for_households_chores' => 'nullable|string|max:50', 
                'detention_days' => 'nullable|string|max:20', 
                'community' => 'nullable|array',
                'house_made_of' => 'nullable|string|max:100',
            ]);            

            Log::info('Validated data for second intake sheet:', $validatedData);

            // Store the second intake sheet
            $sheet = SecondIntakeSheet::create($validatedData);

            Log::info('Second intake sheet created successfully:', $sheet->toArray());

            return response()->json($sheet, 201);
        } catch (\Exception $e) {
            Log::error("Error storing second intake sheet: " . $e->getMessage());
            return response()->json(['message' => 'Server Error'], 500);
        }
    }

    public function show($id)
{
    try {
        // Fetch the second intake sheet using general_intake_id
        $sheet = SecondIntakeSheet::where('general_intake_id', $id)->first();
        if ($sheet) {
            Log::info('Second intake sheet found:', $sheet->toArray());
            return response()->json($sheet);
        }
        Log::warning('Second intake sheet not found with general_intake_id: ' . $id);
        return response()->json(['message' => 'Not found'], 404);
    } catch (\Exception $e) {
        Log::error("Error fetching second intake sheet: " . $e->getMessage());
        return response()->json(['message' => 'Server Error'], 500);
    }
}


public function update(Request $request, $id)
{
    Log::info('Updating second intake sheet with ID: ' . $id);

    try {
        // Find the second intake sheet by the correct ID
        $sheet = SecondIntakeSheet::find($id);
        if ($sheet) {
            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'general_intake_id' => 'nullable|exists:general_intake_sheets,id',
                'date' => 'nullable|date',
                'vices' => 'nullable|array',
                'school_activities_achievement' => 'nullable|string',
                'occupation_of_mother' => 'nullable|string|max:50', 
                'occupation_of_father' => 'nullable|string|max:50', 
                'siblings' => 'nullable|array',
                'responsible_for_households_chores' => 'nullable|string|max:50', 
                'detention_days' => 'nullable|string|max:20', 
                'community' => 'nullable|array',
                'house_made_of' => 'nullable|string|max:100',
            ]); 

            Log::info('Validated data for update:', $validatedData);

            // Update the second intake sheet
            $sheet->update($validatedData);

            Log::info('Second intake sheet updated successfully:', $sheet->toArray());

            return response()->json($sheet);
        }

        Log::warning('Second intake sheet not found for update with ID: ' . $id);
        return response()->json(['message' => 'Not found'], 404);
    } catch (\Exception $e) {
        Log::error("Error updating second intake sheet: " . $e->getMessage());
        return response()->json(['message' => 'Server Error'], 500);
    }
}


    public function destroy($id)
    {
        try {
            $sheet = SecondIntakeSheet::find($id);
            if ($sheet) {
                $sheet->delete();
                Log::info('Second intake sheet deleted successfully with ID: ' . $id);
                return response()->json(['message' => 'Deleted successfully']);
            }
            Log::warning('Second intake sheet not found for deletion with ID: ' . $id);
            return response()->json(['message' => 'Not found'], 404);
        } catch (\Exception $e) {
            Log::error("Error deleting second intake sheet: " . $e->getMessage());
            return response()->json(['message' => 'Server Error'], 500);
        }
    }
}
