<?php

namespace App\Http\Controllers;

use App\Models\TrainingNeedsAssessment;
use App\Models\Client;
use App\Models\EducationDetail;
use App\Models\TrainingDetail;
use App\Models\TrainingSectorDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrainingNeedsAssessmentController extends Controller
{
    public function show($client_id)
    {
        $client = Client::find($client_id);

        if (!$client) {
            Log::warning("Client with ID {$client_id} not found");
            return response()->json(['message' => 'Client not found'], 404);
        }

        $report = TrainingNeedsAssessment::with([
            'educationDetails',
            'trainingDetails',
            'trainingSectorDetails'
        ])->where('client_id', $client_id)->first();

        return response()->json([
            'report' => $report,
            'client' => $client,
        ]);
    }

    public function storeOrUpdate(Request $request, $client_id)
{
    // Validate input data
    $validatedData = $request->validate([
        'education' => 'nullable|array',
        'education.*.level' => 'required|string|max:255',  // Ensure level is required
        'education.*.year_or_grade' => 'nullable|string|max:255',
        'trainings' => 'nullable|array',
        'trainings.*.title' => 'nullable|string|max:255',
        'trainings.*.duration' => 'nullable|string|max:255',
        'trainings.*.location_outside' => 'nullable|string|max:255',
        'trainings.*.location_inside' => 'nullable|string|max:255',
        'social_worker' => 'nullable|string|max:255',
        'houseparent' => 'nullable|string|max:255',
        'father' => 'nullable|string|max:255',
        'mother' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'center_duration' => 'nullable|string|max:255',
        'for_the' => 'nullable|string|max:255',
        'date_of_admission' => 'nullable|date',
        'training_sectors' => 'nullable|array',
        'training_sectors.*.sector' => 'required|string|max:255',
        'training_sectors.*.name' => 'required|string|max:255',
        'training_sectors.*.rank' => 'nullable|integer',
        'training_sectors.*.remarks' => 'nullable|string'
    ]);

    try {
        // Ensure the client exists
        $client = Client::find($client_id);
        if (!$client) {
            Log::warning("Client with ID {$client_id} not found");
            return response()->json(['message' => 'Client not found'], 404);
        }

        // Create or update the Training Needs Assessment report
        $report = TrainingNeedsAssessment::updateOrCreate(
            ['client_id' => $client_id],
            [
                'social_worker' => $validatedData['social_worker'],
                'houseparent' => $validatedData['houseparent'],
                'father' => $validatedData['father'],
                'mother' => $validatedData['mother'],
                'address' => $validatedData['address'],
                'center_duration' => $validatedData['center_duration'],
                'for_the' => $validatedData['for_the'],
                'date_of_admission' => $validatedData['date_of_admission'],
            ]
        );

        // Clear previous education, training, and sector details
        $report->educationDetails()->delete();
        $report->trainingDetails()->delete();
        $report->trainingSectorDetails()->delete();

        // Insert education details
        if (isset($validatedData['education']) && is_array($validatedData['education'])) {
            foreach ($validatedData['education'] as $education) {
                $report->educationDetails()->create([
                    'education_level' => $education['level'],
                    'year_or_grade' => $education['year_or_grade'] ?? null,
                ]);
            }
        }

        // Insert training details
        if (isset($validatedData['trainings']) && is_array($validatedData['trainings'])) {
            foreach ($validatedData['trainings'] as $training) {
                $report->trainingDetails()->create([
                    'title' => $training['title'],
                    'duration' => $training['duration'] ?? null,
                    'location_outside' => $training['location_outside'] ?? null,
                    'location_inside' => $training['location_inside'] ?? null,
                ]);
            }
        }

        // Insert sector details
        if (isset($validatedData['training_sectors']) && is_array($validatedData['training_sectors'])) {
            foreach ($validatedData['training_sectors'] as $sector) {
                $report->trainingSectorDetails()->create([
                    'sector' => $sector['sector'],
                    'name' => $sector['name'],
                    'rank' => $sector['rank'] ?? null,
                    'remarks' => $sector['remarks'] ?? null,
                ]);
            }
        }

        Log::info("Successfully stored/updated Training Needs Assessment for client ID {$client_id}");
        return response()->json($report, 201);

    } catch (\Exception $e) {
        Log::error("Error storing/updating Training Needs Assessment for client ID {$client_id}", [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json(['message' => 'Failed to store/update report', 'error' => $e->getMessage()], 500);
    }
}
}