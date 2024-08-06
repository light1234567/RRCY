<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\RrcyForm;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function index($clientId)
    {
        $checklist = Checklist::where('client_id', $clientId)->get();
        $rrForms = RrcyForm::where('client_id', $clientId)->get();

        return response()->json([
            'checklist' => $checklist,
            'rrForms' => $rrForms
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'checklist' => 'required|array',
            'checklist.*.client_id' => 'required|exists:clients,id',
            'checklist.*.document' => 'required|string|max:255',
            'checklist.*.yes' => 'boolean',
            'checklist.*.no' => 'boolean',
            'checklist.*.remarks' => 'nullable|string',
            'rrForms' => 'required|array',
            'rrForms.*.client_id' => 'required|exists:clients,id',
            'rrForms.*.form' => 'required|string|max:255',
            'rrForms.*.yes' => 'boolean',
            'rrForms.*.no' => 'boolean',
            'rrForms.*.remarks' => 'nullable|string',
        ]);

        $checklistData = $validatedData['checklist'];
        $rrFormsData = $validatedData['rrForms'];

        foreach ($checklistData as $item) {
            Checklist::updateOrCreate(
                ['client_id' => $item['client_id'], 'document' => $item['document']],
                ['yes' => $item['yes'], 'no' => $item['no'], 'remarks' => $item['remarks']]
            );
        }

        foreach ($rrFormsData as $item) {
            RrcyForm::updateOrCreate(
                ['client_id' => $item['client_id'], 'form' => $item['form']],
                ['yes' => $item['yes'], 'no' => $item['no'], 'remarks' => $item['remarks']]
            );
        }

        return response()->json(['message' => 'Data saved successfully'], 201);
    }

    public function update(Request $request, $clientId, $document)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'document' => 'required|string|max:255',
            'yes' => 'boolean',
            'no' => 'boolean',
            'remarks' => 'nullable|string',
        ]);

        $checklist = Checklist::where('client_id', $clientId)->where('document', $document)->first();
        if ($checklist) {
            $checklist->update($validatedData);
            return response()->json($checklist);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function destroy($clientId, $document)
    {
        $checklist = Checklist::where('client_id', $clientId)->where('document', $document)->first();
        if ($checklist) {
            $checklist->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
