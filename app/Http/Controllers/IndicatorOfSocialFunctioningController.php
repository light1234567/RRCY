<?php

namespace App\Http\Controllers;

use App\Models\IndicatorsOfSocialFunctioning;
use Illuminate\Http\Request;

class IndicatorsOfSocialFunctioningController extends Controller
{
    public function index()
    {
        $indicators = IndicatorsOfSocialFunctioning::all();
        return response()->json($indicators);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date_admission' => 'required|date',
            'date_administered' => 'required|date',
            'physical_raw_score1' => 'nullable|integer',
            'physical_score_per_area1' => 'nullable|integer',
            'physical_raw_score2' => 'nullable|integer',
            'physical_score_per_area2' => 'nullable|integer',
            'emotional_raw_score1' => 'nullable|integer',
            'emotional_score_per_area1' => 'nullable|integer',
            'emotional_raw_score2' => 'nullable|integer',
            'emotional_score_per_area2' => 'nullable|integer',
            'emotional_raw_score3' => 'nullable|integer',
            'emotional_score_per_area3' => 'nullable|integer',
            'emotional_raw_score4' => 'nullable|integer',
            'emotional_score_per_area4' => 'nullable|integer',
            'emotional_raw_score5' => 'nullable|integer',
            'emotional_score_per_area5' => 'nullable|integer',
            'emotional_raw_score6' => 'nullable|integer',
            'emotional_score_per_area6' => 'nullable|integer',
            'social_raw_score1' => 'nullable|integer',
            'social_score_per_area1' => 'nullable|integer',
            'social_raw_score2' => 'nullable|integer',
            'social_score_per_area2' => 'nullable|integer',
            'social_raw_score3' => 'nullable|integer',
            'social_score_per_area3' => 'nullable|integer',
            'social_raw_score4' => 'nullable|integer',
            'social_score_per_area4' => 'nullable|integer',
            'social_raw_score5' => 'nullable|integer',
            'social_score_per_area5' => 'nullable|integer',
            'social_raw_score6' => 'nullable|integer',
            'social_score_per_area6' => 'nullable|integer',
            'social_raw_score7' => 'nullable|integer',
            'social_score_per_area7' => 'nullable|integer',
            'social_raw_score8' => 'nullable|integer',
            'social_score_per_area8' => 'nullable|integer',
            'spiritual_raw_score1' => 'nullable|integer',
            'spiritual_score_per_area1' => 'nullable|integer',
            'educational_raw_score' => 'nullable|integer',
            'educational_score_per_area' => 'nullable|integer',
            'economic_raw_score' => 'nullable|integer',
            'economic_score_per_area' => 'nullable|integer',
            'general_score' => 'nullable|integer',
            'interpretation' => 'nullable|string',
            'prepared_by' => 'nullable|string|max:255',
            'discussed_with' => 'nullable|string|max:255',
        ]);

        $indicator = IndicatorsOfSocialFunctioning::create($validatedData);
        return response()->json($indicator, 201);
    }

    public function show($id)
    {
        $indicator = IndicatorsOfSocialFunctioning::find($id);
        if ($indicator) {
            return response()->json($indicator);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $indicator = IndicatorsOfSocialFunctioning::find($id);
        if ($indicator) {
            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'date_admission' => 'required|date',
                'date_administered' => 'required|date',
                'physical_raw_score1' => 'nullable|integer',
                'physical_score_per_area1' => 'nullable|integer',
                'physical_raw_score2' => 'nullable|integer',
                'physical_score_per_area2' => 'nullable|integer',
                'emotional_raw_score1' => 'nullable|integer',
                'emotional_score_per_area1' => 'nullable|integer',
                'emotional_raw_score2' => 'nullable|integer',
                'emotional_score_per_area2' => 'nullable|integer',
                'emotional_raw_score3' => 'nullable|integer',
                'emotional_score_per_area3' => 'nullable|integer',
                'emotional_raw_score4' => 'nullable|integer',
                'emotional_score_per_area4' => 'nullable|integer',
                'emotional_raw_score5' => 'nullable|integer',
                'emotional_score_per_area5' => 'nullable|integer',
                'emotional_raw_score6' => 'nullable|integer',
                'emotional_score_per_area6' => 'nullable|integer',
                'social_raw_score1' => 'nullable|integer',
                'social_score_per_area1' => 'nullable|integer',
                'social_raw_score2' => 'nullable|integer',
                'social_score_per_area2' => 'nullable|integer',
                'social_raw_score3' => 'nullable|integer',
                'social_score_per_area3' => 'nullable|integer',
                'social_raw_score4' => 'nullable|integer',
                'social_score_per_area4' => 'nullable|integer',
                'social_raw_score5' => 'nullable|integer',
                'social_score_per_area5' => 'nullable|integer',
                'social_raw_score6' => 'nullable|integer',
                'social_score_per_area6' => 'nullable|integer',
                'social_raw_score7' => 'nullable|integer',
                'social_score_per_area7' => 'nullable|integer',
                'social_raw_score8' => 'nullable|integer',
                'social_score_per_area8' => 'nullable|integer',
                'spiritual_raw_score1' => 'nullable|integer',
                'spiritual_score_per_area1' => 'nullable|integer',
                'educational_raw_score' => 'nullable|integer',
                'educational_score_per_area' => 'nullable|integer',
                'economic_raw_score' => 'nullable|integer',
                'economic_score_per_area' => 'nullable|integer',
                'general_score' => 'nullable|integer',
                'interpretation' => 'nullable|string',
                'prepared_by' => 'nullable|string|max:255',
                'discussed_with' => 'nullable|string|max:255',
            ]);

            $indicator->update($validatedData);
            return response()->json($indicator);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function destroy($id)
    {
        $indicator = IndicatorsOfSocialFunctioning::find($id);
        if ($indicator) {
            $indicator->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
