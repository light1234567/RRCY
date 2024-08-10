<?php

namespace App\Http\Controllers;

use App\Models\InitialPsychologicalAssessment;
use App\Models\Client;
use App\Models\Admission;
use App\Models\GeneralIntakeSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InitialPsychologicalAssessmentController extends Controller
{
    public function index()
    {
        $assessments = InitialPsychologicalAssessment::with('client', 'admission')->get();
        return response()->json($assessments);
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'client_id' => 'required|exists:clients,id',
        'admission_id' => 'required|exists:admissions,id',
        'nickname' => 'nullable|string|max:255',
        'reason_for_referral' => 'nullable|string',
        'family_history' => 'nullable|string',
        'sexual_development' => 'nullable|string',
        'medical_history' => 'nullable|string',
        'school_history' => 'nullable|string',
        'social_history' => 'nullable|string',
        'personal_characteristics' => 'nullable|string',
        'review_systems' => 'nullable|string',
        'mental_status' => 'nullable|string',
        'assessment_interview' => 'nullable|string',
        'test_result' => 'nullable|string',
        'clinical_impression' => 'nullable|string',
        'plan_of_action' => 'nullable|string',
        'prepared_by' => 'nullable|string|max:255',
        'noted_by' => 'nullable|string|max:255',
    ]);

    try {
        // Use updateOrCreate to either update an existing record or create a new one
        $assessment = InitialPsychologicalAssessment::updateOrCreate(
            [
                'client_id' => $validatedData['client_id'],
                'admission_id' => $validatedData['admission_id']
            ],
            $validatedData
        );

        Log::info("Successfully saved Initial Psychological Assessment", $assessment->toArray());
        return response()->json($assessment, 201);
    } catch (\Exception $e) {
        Log::error("Error storing Initial Psychological Assessment", [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'data' => $validatedData
        ]);

        return response()->json(['message' => 'Failed to store assessment', 'error' => $e->getMessage()], 500);
    }
}

    public function show($client_id)
    {
        $client = Client::with('admissions')->find($client_id);
        $admission = $client->admissions->first();
    
        $generalIntake = GeneralIntakeSheet::where('client_id', $client_id)->first();
        $assessment = InitialPsychologicalAssessment::where('client_id', $client_id)
            ->where('admission_id', $admission->id)
            ->first();
    
        return response()->json([
            'assessment' => $assessment,
            'client' => $client,
            'admission' => $admission,
            'highest_educ_att' => $generalIntake ? $generalIntake->highest_educ_att : null,
        ]);
    }
    
    public function update(Request $request, $client_id)
{
    $validatedData = $request->validate([
        'admission_id' => 'required|exists:admissions,id',
        'nickname' => 'nullable|string|max:255',
        'reason_for_referral' => 'nullable|string',
        'family_history' => 'nullable|string',
        'sexual_development' => 'nullable|string',
        'medical_history' => 'nullable|string',
        'school_history' => 'nullable|string',
        'social_history' => 'nullable|string',
        'personal_characteristics' => 'nullable|string',
        'review_systems' => 'nullable|string',
        'mental_status' => 'nullable|string',
        'assessment_interview' => 'nullable|string',
        'test_result' => 'nullable|string',
        'clinical_impression' => 'nullable|string',
        'plan_of_action' => 'nullable|string',
        'prepared_by' => 'nullable|string|max:255',
        'noted_by' => 'nullable|string|max:255',
        'educational_attainment' => 'nullable|string|max:255', // Educational attainment from General Intake
    ]);

    try {
        // Update or create InitialPsychologicalAssessment
        $assessment = InitialPsychologicalAssessment::updateOrCreate(
            [
                'client_id' => $client_id,
                'admission_id' => $validatedData['admission_id']
            ],
            $validatedData
        );

        // Handle GeneralIntakeSheet
        $generalIntakeSheet = GeneralIntakeSheet::firstOrCreate(
            ['client_id' => $client_id],
            ['highest_educ_att' => $validatedData['educational_attainment']]
        );

        if (!$generalIntakeSheet->wasRecentlyCreated) {
            $generalIntakeSheet->update(['highest_educ_att' => $validatedData['educational_attainment']]);
        }

        Log::info("Successfully updated/created Initial Psychological Assessment and General Intake Sheet", [
            'assessment' => $assessment->toArray(),
            'generalIntakeSheet' => $generalIntakeSheet->toArray(),
        ]);

        return response()->json([
            'assessment' => $assessment,
            'generalIntakeSheet' => $generalIntakeSheet,
        ], 200);
    } catch (\Exception $e) {
        Log::error("Error updating Initial Psychological Assessment or General Intake Sheet", [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'data' => $validatedData
        ]);

        return response()->json(['message' => 'Failed to update assessment or educational attainment', 'error' => $e->getMessage()], 500);
    }
}


    public function destroy($id)
    {
        $assessment = InitialPsychologicalAssessment::find($id);
        if ($assessment) {
            $assessment->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
