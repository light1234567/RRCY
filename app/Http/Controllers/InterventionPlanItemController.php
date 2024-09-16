<?php

namespace App\Http\Controllers;

use App\Models\InterventionPlanItem;
use Illuminate\Http\Request;

class InterventionPlanItemController extends Controller
{
    public function index()
    {
        $items = InterventionPlanItem::all();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'plan_id' => 'required|exists:intervention_plans,id',
            'objectives' => 'required|string|max:255',
            'activities' => 'required|string|max:255',
            'time_frame' => 'required|string|max:100', 
            'responsible_person' => 'required|string|max:100',
            'expected_outcome' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:255',
        ]);        

        $item = InterventionPlanItem::create($validatedData);
        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = InterventionPlanItem::find($id);
        if ($item) {
            return response()->json($item);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $item = InterventionPlanItem::find($id);
        if ($item) {
            $validatedData = $request->validate([
                'plan_id' => 'required|exists:intervention_plans,id',
                'objectives' => 'required|string|max:255',
                'activities' => 'required|string|max:255',
                'time_frame' => 'required|string|max:100', 
                'responsible_person' => 'required|string|max:100',
                'expected_outcome' => 'required|string|max:255',
                'remarks' => 'nullable|string|max:255',
            ]);

            $item->update($validatedData);
            return response()->json($item);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function destroy($id)
    {
        $item = InterventionPlanItem::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
