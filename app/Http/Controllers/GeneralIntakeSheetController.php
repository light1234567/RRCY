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
            'occupation' => 'required|string|max:255',
            'highest_educ_att' => 'required|string|max:255',
            'school_name' => 'required|string|max:255',
            'class_adviser' => 'required|string|max:255',
            'problem_presented' => 'required|string',
            'brief_physical_description' => 'required|string',
            'major_life_event' => 'required|string|max:255',
            'enduring_life_strain' => 'required|string|max:255',
            'life_transition' => 'required|string|max:255',
            'development_changes' => 'required|string|max:255',
            'normalization' => 'required|string|max:255',
            'behaviour_towards_incident' => 'required|string|max:255',
            'attachments' => 'required|string|max:255',
            'skills' => 'required|string|max:255',
            'resources' => 'required|string|max:255',
            'earnings_income' => 'required|string|max:255',
            'source_of_income_in_street' => 'required|string|max:255',
            'hrs_stay_in_street' => 'required|string|max:255',
            'length_stay_in_street' => 'required|string|max:255',
            'common_substance_used' => 'required|string|max:255',
            'initial_assessment' => 'required|string|max:255',
            'recommendations' => 'required|string|max:255',
            'vices' => 'required|string|max:255',
            'school_activities_achievement' => 'required|string|max:255',
            'occupation_of_mother' => 'required|string',
            'occupation_of_father' => 'required|string',
            'siblings' => 'required|string|max:255',
            'responsible_for_households_chores' => 'required|string',
            'water_source' => 'required|string|max:255',
            'house_made_of' => 'required|string|max:255',
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
                'date' => 'required|date',
                'occupation' => 'required|string|max:255',
                'highest_educ_att' => 'required|string|max:255',
                'school_name' => 'required|string|max:255',
                'class_adviser' => 'required|string|max:255',
                'problem_presented' => 'required|string',
                'brief_physical_description' => 'required|string',
                'major_life_event' => 'required|string|max:255',
                'enduring_life_strain' => 'required|string|max:255',
                'life_transition' => 'required|string|max:255',
                'development_changes' => 'required|string|max:255',
                'normalization' => 'required|string|max:255',
                'behaviour_towards_incident' => 'required|string|max:255',
                'attachments' => 'required|string|max:255',
                'skills' => 'required|string|max:255',
                'resources' => 'required|string|max:255',
                'earnings_income' => 'required|string|max:255',
                'source_of_income_in_street' => 'required|string|max:255',
                'hrs_stay_in_street' => 'required|string|max:255',
                'length_stay_in_street' => 'required|string|max:255',
                'common_substance_used' => 'required|string|max:255',
                'initial_assessment' => 'required|string|max:255',
                'recommendations' => 'required|string|max:255',
                'vices' => 'required|string|max:255',
                'school_activities_achievement' => 'required|string|max:255',
                'occupation_of_mother' => 'required|string',
                'occupation_of_father' => 'required|string',
                'siblings' => 'required|string|max:255',
                'responsible_for_households_chores' => 'required|string',
                'water_source' => 'required|string|max:255',
                'house_made_of' => 'required|string|max:255',
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
