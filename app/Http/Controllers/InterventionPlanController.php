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
            'period' => 'required|string|max:255',
            'date_prepared' => 'required|date',
        ]);

        $plan = InterventionPlan::create($validatedData);
        return response()->json($plan, 201);
    }

    public function show($id)
    {
        $plan = InterventionPlan::find($id);
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
                'period' => 'required|string|max:255',
                'date_prepared' => 'required|date',
            ]);

            $plan->update($validatedData);
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
