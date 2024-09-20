<?php

namespace App\Http\Controllers;

use App\Models\LearnerAssessmentForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LearnerAssessmentFormController extends Controller
{
    public function storeOrUpdate(Request $request)
    {
        try {
            Log::info('Received form submission request.', ['data' => $request->all()]);

            // Validate the incoming request data
            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'school_year' => 'nullable|string|max:10',
                'grading_period' => 'nullable|string|max:10',
                'grade' => 'nullable|string|max:10',
                'date' => 'nullable|date',
                'recommendations' => 'nullable|string',
                'prepared_by' => 'nullable|string|max:50',
                'noted_by' => 'nullable|string|max:50',
            ]);            

            // Log the validated data
            Log::info('Validated form data:', $validatedData);

            // Create or update the main form
            $form = LearnerAssessmentForm::updateOrCreate(
                ['client_id' => $validatedData['client_id']],
                $validatedData
            );

            Log::info('Main form record created/updated.', ['form_id' => $form->id, 'client_id' => $validatedData['client_id']]);

            // Handle the assessments, ensuring defaults if null
            $readingData = $request->input('assessments.reading', []);
            $writingData = $request->input('assessments.writing', []);
            $numeracyData = $request->input('assessments.numeracy', []);
            $groupWorkData = $request->input('assessments.group_work', []);

            Log::info('Assessment data prepared for saving.', [
                'reading' => $readingData,
                'writing' => $writingData,
                'numeracy' => $numeracyData,
                'group_work' => $groupWorkData
            ]);

            // Save or update the assessments
            $form->readingAssessments()->updateOrCreate(
                ['learner_assessment_form_id' => $form->id],
                $readingData
            );
            Log::info('Reading assessment saved.', $readingData);

            $form->writingAssessments()->updateOrCreate(
                ['learner_assessment_form_id' => $form->id],
                $writingData
            );
            Log::info('Writing assessment saved.', $writingData);

            $form->numeracyAssessments()->updateOrCreate(
                ['learner_assessment_form_id' => $form->id],
                $numeracyData
            );
            Log::info('Numeracy assessment saved.', $numeracyData);

            $form->groupWorkAssessments()->updateOrCreate(
                ['learner_assessment_form_id' => $form->id],
                $groupWorkData
            );
            Log::info('Group work assessment saved.', $groupWorkData);

            Log::info('Form submitted successfully for client_id: ' . $validatedData['client_id']);
            return response()->json(['message' => 'Form submitted successfully!'], 200);
        } catch (\Exception $e) {
            Log::error('Error saving form: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'exception' => $e->getMessage()
            ]);
            return response()->json(['message' => 'An error occurred while saving the form.'], 500);
        }
    }

    public function show($client_id)
{
    try {
        Log::info('Fetching form for client_id: ' . $client_id);

        $form = LearnerAssessmentForm::with([
                'readingAssessments', 
                'writingAssessments', 
                'numeracyAssessments', 
                'groupWorkAssessments'
            ])
            ->where('client_id', $client_id)
            ->first();

        if (!$form) {
            Log::warning('Form not found for client_id: ' . $client_id);
            return response()->json(['message' => 'Form not found'], 404);
        }

        Log::info('Form fetched successfully for client_id: ' . $client_id, ['form' => $form]);
        return response()->json($form);
    } catch (\Exception $e) {
        Log::error('Error fetching form for client_id: ' . $client_id, [
            'error' => $e->getMessage(),
            'stack_trace' => $e->getTraceAsString()
        ]);
        return response()->json(['message' => 'An error occurred while fetching the form.'], 500);
    }
}


}
