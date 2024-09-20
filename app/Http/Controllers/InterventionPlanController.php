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
            'period' => 'required|string|max:15',
            'date_prepared' => 'required|date',
            'prepared_by' => 'nullable|string|max:50',
            'conformed_by' => 'nullable|string|max:50',
            //'noted_by' => 'nullable|string|max:50',
            'items' => 'required|array',
            'items.*.objectives' => 'required|string|max:50',
            'items.*.activities' => 'required|string|max:50',
            'items.*.time_frame' => 'required|string|max:20',
            'items.*.responsible_person' => 'required|string|max:50',
            'items.*.expected_outcome' => 'required|string|max:100',
            'items.*.remarks' => 'nullable|string|max:150',
        ]);         

        $plan = InterventionPlan::create($validatedData);
        foreach ($validatedData['items'] as $itemData) {
            $plan->items()->create($itemData);
        }

        return response()->json($plan, 201);
    }

    public function show($id)
    {
        $plan = InterventionPlan::with('items')->where('client_id', $id)->first();
        if ($plan) {
            return response()->json($plan);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $plan = InterventionPlan::find($id);
        if ($plan) {
            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'period' => 'required|string|max:100',
                'date_prepared' => 'required|date',
                'prepared_by' => 'nullable|string|max:100',
                'conformed_by' => 'nullable|string|max:100',
                'noted_by' => 'nullable|string|max:100',
                'items' => 'required|array',
                'items.*.objectives' => 'required|string|max:255',
                'items.*.activities' => 'required|string|max:255',
                'items.*.time_frame' => 'required|string|max:100',
                'items.*.responsible_person' => 'required|string|max:100',
                'items.*.expected_outcome' => 'required|string|max:255',
                'items.*.remarks' => 'nullable|string|max:255',
            ]);

            $plan->update($validatedData);
            $plan->items()->delete();
            foreach ($validatedData['items'] as $itemData) {
                $plan->items()->create($itemData);
            }

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

