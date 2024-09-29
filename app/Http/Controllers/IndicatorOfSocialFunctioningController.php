<?php

namespace App\Http\Controllers;

use App\Models\IndicatorsOfSocialFunctioning;
use Illuminate\Http\Request;

class IndicatorOfSocialFunctioningController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $this->validateRequest($request);

        // Automatically calculate the score per area fields based on raw scores
        $validatedData = $this->calculateScorePerArea($validatedData);

        // Automatically calculate the general score as the average of all score per area fields
        $validatedData['general_score'] = $this->calculateGeneralScore($validatedData);

        $indicator = IndicatorsOfSocialFunctioning::create($validatedData);
        return response()->json($indicator, 201);
    }

    public function update(Request $request, $client_id, $admission_id)
{
    // Find the existing record based on client_id and admission_id
    $indicator = IndicatorsOfSocialFunctioning::where('client_id', $client_id)
        ->where('admission_id', $admission_id)
        ->first();

    $validatedData = $this->validateRequest($request);

    // Automatically calculate the score per area fields based on raw scores
    $validatedData = $this->calculateScorePerArea($validatedData);

    // Recalculate the general score
    $validatedData['general_score'] = $this->calculateGeneralScore($validatedData);

    if ($indicator) {
        $indicator->update($validatedData);
        return response()->json($indicator);
    } else {
        // If no record exists, create a new one
        $validatedData['client_id'] = $client_id;
        $validatedData['admission_id'] = $admission_id;
        $indicator = IndicatorsOfSocialFunctioning::create($validatedData);
        return response()->json($indicator, 201);
    }
}

    // Add this method to check for existing records
    public function checkExisting($client_id, $admission_id)
    {
        $indicator = IndicatorsOfSocialFunctioning::where('client_id', $client_id)
            ->where('admission_id', $admission_id)
            ->first();
    
        if ($indicator) {
            return response()->json($indicator);
        }
        return response()->json(null);
    }
    

    private function validateRequest(Request $request)
    {
        return $request->validate([
         'client_id' => 'required|exists:clients,id',
        'admission_id' => 'required|exists:admissions,id',
        'date_administered' => 'nullable|date',
        'physical_raw_score1' => 'nullable|numeric|min:0|max:3',
        'physical_score_per_area1' => 'nullable|numeric|min:0|max:5',  // Decimal score per area
        'physical_raw_score2' => 'nullable|numeric|min:0|max:3',
        'emotional_raw_score1' => 'nullable|numeric|min:0|max:3',
        'emotional_score_per_area1' => 'nullable|numeric|min:0|max:5',  // Decimal score per area
        'emotional_raw_score2' => 'nullable|numeric|min:0|max:3',
        'emotional_raw_score3' => 'nullable|numeric|min:0|max:3',
        'emotional_raw_score4' => 'nullable|numeric|min:0|max:3',
        'emotional_raw_score5' => 'nullable|numeric|min:0|max:3',
        'emotional_raw_score6' => 'nullable|numeric|min:0|max:3',
        'social_raw_score1' => 'nullable|numeric|min:0|max:3',
        'social_score_per_area1' => 'nullable|numeric|min:0|max:5',  // Decimal score per area
        'social_raw_score2' => 'nullable|numeric|min:0|max:3',
        'social_raw_score3' => 'nullable|numeric|min:0|max:3',
        'social_raw_score4' => 'nullable|numeric|min:0|max:3',
        'social_raw_score5' => 'nullable|numeric|min:0|max:3',
        'social_raw_score6' => 'nullable|numeric|min:0|max:3',
        'social_raw_score7' => 'nullable|numeric|min:0|max:3',
        'social_raw_score8' => 'nullable|numeric|min:0|max:3',
        'spiritual_raw_score1' => 'nullable|numeric|min:0|max:3',
        'spiritual_score_per_area1' => 'nullable|numeric|min:0|max:5',  // Decimal score per area
        'educational_raw_score' => 'nullable|numeric|min:0|max:3',
        'educational_score_per_area' => 'nullable|numeric|min:0|max:5',  // Decimal score per area
        'economic_raw_score' => 'nullable|numeric|min:0|max:3',
        'economic_score_per_area' => 'nullable|numeric|min:0|max:5',  // Decimal score per area
        'general_score' => 'nullable|numeric|min:0|max:5',  // Decimal general score
        'interpretation' => 'nullable|string',
        'prepared_by' => 'nullable|string|max:50',
        'indicators_case_manager' => 'nullable|string|max:50',
        'discussed_with' => 'nullable|string|max:50',
        ]);
    }

    private function calculateScorePerArea($data)
    {
        // Calculate Physical Score per Area
        if (isset($data['physical_raw_score1']) && isset($data['physical_raw_score2'])) {
            $data['physical_score_per_area1'] = ($data['physical_raw_score1'] + $data['physical_raw_score2']) / 2;
        }
    
        // Calculate Emotional Score per Area
        $emotionalScores = [
            $data['emotional_raw_score1'] ?? 0,
            $data['emotional_raw_score2'] ?? 0,
            $data['emotional_raw_score3'] ?? 0,
            $data['emotional_raw_score4'] ?? 0,
            $data['emotional_raw_score5'] ?? 0,
            $data['emotional_raw_score6'] ?? 0,
        ];
        $data['emotional_score_per_area1'] = array_sum($emotionalScores) / 6;
    
        // Calculate Social Score per Area
        $socialScores = [
            $data['social_raw_score1'] ?? 0,
            $data['social_raw_score2'] ?? 0,
            $data['social_raw_score3'] ?? 0,
            $data['social_raw_score4'] ?? 0,
            $data['social_raw_score5'] ?? 0,
            $data['social_raw_score6'] ?? 0,
            $data['social_raw_score7'] ?? 0,
            $data['social_raw_score8'] ?? 0,
        ];
        $data['social_score_per_area1'] = array_sum($socialScores) / 8;
    
        // Calculate Spiritual Score per Area
        if (isset($data['spiritual_raw_score1'])) {
            $data['spiritual_score_per_area1'] = $data['spiritual_raw_score1'] / 1;
        }
    
        // Calculate Educational Score per Area
        if (isset($data['educational_raw_score'])) {
            $data['educational_score_per_area'] = $data['educational_raw_score'] / 1;
        }
    
        // Calculate Economic Score per Area
        if (isset($data['economic_raw_score'])) {
            $data['economic_score_per_area'] = $data['economic_raw_score'] / 1;
        }
    
        return $data;
    }
    
    private function calculateGeneralScore($data)
    {
        $scores = [
            $data['physical_score_per_area1'] ?? 0,
            $data['emotional_score_per_area1'] ?? 0,
            $data['social_score_per_area1'] ?? 0,
            $data['spiritual_score_per_area1'] ?? 0,
            $data['educational_score_per_area'] ?? 0,
            $data['economic_score_per_area'] ?? 0,
        ];
    
        // Calculate the general score as the average of all score per area fields
        $total = array_sum($scores);
        $generalScore = $total / 6;
    
        return round($generalScore, 2); // Round to two decimal places
    }
    
    public function show($id)
{
    $indicator = IndicatorsOfSocialFunctioning::find($id);

    if (!$indicator) {
        return response()->json(['message' => 'Indicator not found'], 404);
    }

    return response()->json($indicator);
}


}
