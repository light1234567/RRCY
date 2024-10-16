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
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'as_of_date' => 'nullable|date',
            'progress_notes' => 'nullable|string',
            'prepared_by' => 'nullable|string|max:50',
            'approved_by' => 'nullable|string|max:50',
            'items' => 'required|array', // Ensure the items are an array
            'items.*.objectives' => 'nullable|string',
            'items.*.activities' => 'nullable|string',
            'items.*.responsible_person' => 'nullable|string|max:50',
            'items.*.time_frame' => 'nullable|string|max:20',
            'items.*.expected_output' => 'nullable|string',
            'items.*.progress' => 'nullable|string',
        ]);

        try {
            $plan = PsychologicalInterventionPlan::create([
                'client_id' => $validatedData['client_id'],
                'as_of_date' => $validatedData['as_of_date'],
                'progress_notes' => $validatedData['progress_notes'],
                'prepared_by' => $validatedData['prepared_by'],
                'approved_by' => $validatedData['approved_by'],
                'items' => json_encode($validatedData['items']), // Store items as JSON
            ]);

            return response()->json($plan, 201);
        } catch (\Exception $e) {
            Log::error('Error storing Psychological Intervention Plan: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to save the plan.'], 500);
        }
    }

    public function show($id)
    {
        $plan = PsychologicalInterventionPlan::where('client_id', $id)->first();

        if ($plan) {
            $plan->items = json_decode($plan->items, true); // Decode JSON items to array
            return response()->json($plan);
        } else {
            return response()->json(['message' => 'Plan not found.'], 404);
        }
    }

    public function destroy($id)
    {
        $plan = PsychologicalInterventionPlan::find($id);
        if ($plan) {
            $plan->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'as_of_date' => 'nullable|date',
            'progress_notes' => 'nullable|string',
            'prepared_by' => 'nullable|string|max:50',
            'approved_by' => 'nullable|string|max:50',
            'items' => 'required|array', // Ensure the items are an array
            'items.*.objectives' => 'nullable|string',
            'items.*.activities' => 'nullable|string',
            'items.*.responsible_person' => 'nullable|string|max:50',
            'items.*.time_frame' => 'nullable|string|max:20',
            'items.*.expected_output' => 'nullable|string',
            'items.*.progress' => 'nullable|string',
        ]);

        try {
            $plan = PsychologicalInterventionPlan::where('client_id', $id)->firstOrFail();

            $plan->update([
                'as_of_date' => $validatedData['as_of_date'],
                'progress_notes' => $validatedData['progress_notes'],
                'prepared_by' => $validatedData['prepared_by'],
                'approved_by' => $validatedData['approved_by'],
                'items' => json_encode($validatedData['items']), // Update items as JSON
            ]);

            return response()->json($plan);
        } catch (\Exception $e) {
            Log::error('Error updating Psychological Intervention Plan: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update the plan.'], 500);
        }
    }
}
