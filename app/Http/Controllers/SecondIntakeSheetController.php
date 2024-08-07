<?php

namespace App\Http\Controllers;

use App\Models\SecondIntakeSheet;
use Illuminate\Http\Request;

class SecondIntakeSheetController extends Controller
{
    public function index()
    {
        $sheets = SecondIntakeSheet::all();
        return response()->json($sheets);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'nullable|date',
            'occupation' => 'nullable|string|max:255',
            'highest_educ_att' => 'nullable|string|max:255',
            'school_name' => 'nullable|string|max:255',
            'class_adviser' => 'nullable|string|max:255',
            'vices' => 'nullable|array',
            'school_activities_achievement' => 'nullable|string',
            'occupation_of_mother' => 'nullable|string|max:255',
            'occupation_of_father' => 'nullable|string|max:255',
            'siblings' => 'nullable|array',
            'responsible_for_households_chores' => 'nullable|string|max:255',
            'detention_days' => 'nullable|string|max:255',
            'community' => 'nullable|array',
            'house_made_of' => 'nullable|string|max:255',
        ]);

        $sheet = SecondIntakeSheet::create($validatedData);
        return response()->json($sheet, 201);
    }

    public function show($id)
    {
        $sheet = SecondIntakeSheet::find($id);
        if ($sheet) {
            return response()->json($sheet);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $sheet = SecondIntakeSheet::find($id);
        if ($sheet) {
            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'date' => 'nullable|date',
                'occupation' => 'nullable|string|max:255',
                'highest_educ_att' => 'nullable|string|max:255',
                'school_name' => 'nullable|string|max:255',
                'class_adviser' => 'nullable|string|max:255',
                'vices' => 'nullable|array',
                'school_activities_achievement' => 'nullable|string',
                'occupation_of_mother' => 'nullable|string|max:255',
                'occupation_of_father' => 'nullable|string|max:255',
                'siblings' => 'nullable|array',
                'responsible_for_households_chores' => 'nullable|string|max:255',
                'detention_days' => 'nullable|string|max:255',
                'community' => 'nullable|array',
                'house_made_of' => 'nullable|string|max:255',
            ]);

            $sheet->update($validatedData);
            return response()->json($sheet);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function destroy($id)
    {
        $sheet = SecondIntakeSheet::find($id);
        if ($sheet) {
            $sheet->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
