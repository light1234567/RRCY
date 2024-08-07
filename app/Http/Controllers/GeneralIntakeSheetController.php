<?php

namespace App\Http\Controllers;

use App\Models\GeneralIntakeSheet;
use Illuminate\Http\Request;

class GeneralIntakeSheetController extends Controller
{
    public function index()
    {
        $sheets = GeneralIntakeSheet::all();
        return response()->json($sheets);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date',
            'occupation' => 'nullable|string|max:255',
            'highest_educ_att' => 'nullable|string|max:255',
            'school_name' => 'nullable|string|max:255',
            'class_adviser' => 'nullable|string|max:255',
            'problem_presented' => 'nullable|string',
            'brief_physical_description' => 'nullable|string',
            'major_life_event' => 'nullable|array',
            'enduring_life_strain' => 'nullable|array',
            'life_transition' => 'nullable|array',
            'development_changes' => 'nullable|array',
            'normalization' => 'nullable|array',
            'behaviour_towards_incident' => 'nullable|array',
            'attachments' => 'nullable|array',
            'skills' => 'nullable|array',
            'resources' => 'nullable|array',
            'earnings_income' => 'nullable|string|max:255',
            'source_of_income_in_street' => 'nullable|array',
            'hrs_stay_in_street' => 'nullable|string|max:255',
            'length_stay_in_street' => 'nullable|string|max:255',
            'common_substance_used' => 'nullable|string|max:255',
            'initial_assessment' => 'nullable|string|max:255',
            'recommendations' => 'nullable|string|max:255',
            'prepared_by' => 'nullable|string|max:255',
            'reviewed_by' => 'nullable|string|max:255',
        ]);

        $sheet = GeneralIntakeSheet::create($validatedData);
        return response()->json($sheet, 201);
    }

    public function show($id)
    {
        $sheet = GeneralIntakeSheet::find($id);
        if ($sheet) {
            return response()->json($sheet);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $sheet = GeneralIntakeSheet::find($id);
        if ($sheet) {
            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'date' => 'nullable|date',
                'occupation' => 'nullable|string|max:255',
                'highest_educ_att' => 'nullable|string|max:255',
                'school_name' => 'nullable|string|max:255',
                'class_adviser' => 'nullable|string|max:255',
                'problem_presented' => 'nullable|string',
                'brief_physical_description' => 'nullable|string',
                'major_life_event' => 'nullable|array',
                'enduring_life_strain' => 'nullable|array',
                'life_transition' => 'nullable|array',
                'development_changes' => 'nullable|array',
                'normalization' => 'nullable|array',
                'behaviour_towards_incident' => 'nullable|array',
                'attachments' => 'nullable|array',
                'skills' => 'nullable|array',
                'resources' => 'nullable|array',
                'earnings_income' => 'nullable|string|max:255',
                'source_of_income_in_street' => 'nullable|array',
                'hrs_stay_in_street' => 'nullable|string|max:255',
                'length_stay_in_street' => 'nullable|string|max:255',
                'common_substance_used' => 'nullable|string|max:255',
                'initial_assessment' => 'nullable|string|max:255',
                'recommendations' => 'nullable|string|max:255',
                'prepared_by' => 'nullable|string|max:255',
                'reviewed_by' => 'nullable|string|max:255',
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
