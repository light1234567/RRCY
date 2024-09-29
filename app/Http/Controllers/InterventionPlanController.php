<?php

namespace App\Http\Controllers;

use App\Models\InterventionPlan;
use Illuminate\Http\Request;

class InterventionPlanController extends Controller
{
    public function index()
    {
        $plans = InterventionPlan::all();
        return response()->json($plans);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'period' => 'nullable|string|max:15',
            'date_prepared' => 'nullable|date',
            'prepared_by' => 'nullable|string|max:50',
            'conformed_by' => 'nullable|string|max:50',
            'items' => 'nullable|array', // Expect an array for items
            'items.*.objectives' => 'nullable|string|max:50',
            'items.*.activities' => 'nullable|string|max:50',
            'items.*.time_frame' => 'nullable|string|max:20',
            'items.*.responsible_person' => 'nullable|string|max:50',
            'items.*.expected_outcome' => 'nullable|string|max:100',
            'items.*.remarks' => 'nullable|string|max:150',
        ]);

        // Store items as JSON
        $plan = InterventionPlan::create($validatedData);

        return response()->json($plan, 201);
    }

    public function update(Request $request, $id)
    {
        $plan = InterventionPlan::find($id);

        if ($plan) {
            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'period' => 'nullable|string|max:15',
                'date_prepared' => 'nullable|date',
                'prepared_by' => 'nullable|string|max:50',
                'conformed_by' => 'nullable|string|max:50',
                'items' => 'nullable|array',
                'items.*.objectives' => 'nullable|string|max:50',
                'items.*.activities' => 'nullable|string|max:50',
                'items.*.time_frame' => 'nullable|string|max:20',
                'items.*.responsible_person' => 'nullable|string|max:50',
                'items.*.expected_outcome' => 'nullable|string|max:100',
                'items.*.remarks' => 'nullable|string|max:150',
            ]);

            // Update plan and store items as JSON
            $plan->update($validatedData);

            return response()->json($plan);
        }

        return response()->json(['message' => 'Not found'], 404);
    }

    public function show($id)
    {
        $plan = InterventionPlan::with('client')->find($id);
        if ($plan) {
            return response()->json($plan);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function destroy($id)
    {
        $plan = InterventionPlan::find($id);
        if ($plan) {
            $plan->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
