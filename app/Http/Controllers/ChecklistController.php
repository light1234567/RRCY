<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function index()
    {
        $checklists = Checklist::all();
        return response()->json($checklists);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'document' => 'required|string|max:255',
            'yes' => 'boolean',
            'no' => 'boolean',
            'remarks' => 'nullable|string',
        ]);

        $checklist = Checklist::create($validatedData);
        return response()->json($checklist, 201);
    }

    public function show($id)
    {
        $checklist = Checklist::find($id);
        if ($checklist) {
            return response()->json($checklist);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $checklist = Checklist::find($id);
        if ($checklist) {
            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'document' => 'required|string|max:255',
                'yes' => 'boolean',
                'no' => 'boolean',
                'remarks' => 'nullable|string',
            ]);

            $checklist->update($validatedData);
            return response()->json($checklist);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function destroy($id)
    {
        $checklist = Checklist::find($id);
        if ($checklist) {
            $checklist->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
