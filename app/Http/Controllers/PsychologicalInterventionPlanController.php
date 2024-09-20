<?php

namespace App\Http\Controllers;

use App\Models\PsychologicalInterventionPlan;
use App\Models\PsychologicalInterventionPlanItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PsychologicalInterventionPlanController extends Controller
{
    public function store(Request $request)
    {
        Log::info("Creating or updating a Psychological Intervention Plan");

        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'as_of_date' => 'nullable|date',
            'progress_notes' => 'nullable|string',
            'prepared_by' => 'nullable|string|max:50',
            'noted_by' => 'nullable|string|max:50',
            'items' => 'array',
            'items.*.objectives' => 'nullable|string',
            'items.*.activities' => 'nullable|string',
            'items.*.responsible_person' => 'nullable|string|max:50',
            'items.*.time_frame' => 'nullable|string|max:20',
            'items.*.expected_output' => 'nullable|string',
            'items.*.progress' => 'nullable|string',
        ]);        

        try {
            $plan = PsychologicalInterventionPlan::updateOrCreate(
                ['client_id' => $request->client_id],
                $validatedData
            );

            // Sync the related items
            if (isset($validatedData['items'])) {
                $itemData = [];
                foreach ($validatedData['items'] as $item) {
                    $itemData[] = [
                        'plan_id' => $plan->id,
                        'objectives' => $item['objectives'] ?? null,
                        'activities' => $item['activities'] ?? null,
                        'responsible_person' => $item['responsible_person'] ?? null,
                        'time_frame' => $item['time_frame'] ?? null,
                        'expected_output' => $item['expected_output'] ?? null,
                        'progress' => $item['progress'] ?? null,
                    ];
                }
                PsychologicalInterventionPlanItem::upsert($itemData, ['plan_id', 'objectives']);
            }

            return response()->json([
                'message' => 'Plan saved successfully.',
                'plan' => $plan
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to save Psychological Intervention Plan: " . $e->getMessage());
            return response()->json([
                'message' => 'Failed to save the plan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        Log::info("Fetching Psychological Intervention Plan for client: " . $id);

        $plan = PsychologicalInterventionPlan::with('items')->where('client_id', $id)->first();

        if ($plan) {
            return response()->json([
                'plan' => $plan
            ]);
        } else {
            return response()->json([
                'message' => 'Plan not found.'
            ], 404);
        }
    }


    public function update(Request $request, $id)
    {
        Log::info("Attempting to update Psychological Intervention Plan for client_id: $id");

        $validatedData = $request->validate([
            'as_of_date' => 'nullable|date',
            'progress_notes' => 'nullable|string',
            'prepared_by' => 'nullable|string|max:50',
            'noted_by' => 'nullable|string|max:50',
            'items' => 'array',
            'items.*.objectives' => 'nullable|string',
            'items.*.activities' => 'nullable|string',
            'items.*.responsible_person' => 'nullable|string|max:50',
            'items.*.time_frame' => 'nullable|string|max:50',
            'items.*.expected_output' => 'nullable|string',
            'items.*.progress' => 'nullable|string',
        ]); 

        try {
            $plan = PsychologicalInterventionPlan::where('client_id', $id)->firstOrFail();

            $plan->update($validatedData);

            $items = [];
            foreach ($validatedData['items'] as $itemData) {
                $items[] = new PsychologicalInterventionPlanItem($itemData);
            }
            $plan->items()->delete(); // Clear old items
            $plan->items()->saveMany($items); // Save new items

            Log::info("Successfully updated Psychological Intervention Plan", $plan->toArray());
            return response()->json($plan->load('items'), 200);
        } catch (\Exception $e) {
            Log::error("Error updating Psychological Intervention Plan", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $validatedData
            ]);

            return response()->json(['message' => 'Failed to update plan', 'error' => $e->getMessage()], 500);
        }
    }
}
