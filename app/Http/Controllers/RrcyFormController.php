<?php

namespace App\Http\Controllers;

use App\Models\RrcyForm;
use Illuminate\Http\Request;

class RrcyFormController extends Controller
{
    public function index()
    {
        $rrcyForms = RrcyForm::all();
        return response()->json($rrcyForms);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'form' => 'required|string|max:255',
            'yes' => 'boolean',
            'no' => 'boolean',
            'remarks' => 'nullable|string',
        ]);

        $rrcyForm = RrcyForm::create($validatedData);
        return response()->json($rrcyForm, 201);
    }

    public function show($id)
    {
        $rrcyForm = RrcyForm::find($id);
        if ($rrcyForm) {
            return response()->json($rrcyForm);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $rrcyForm = RrcyForm::find($id);
        if ($rrcyForm) {
            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'form' => 'required|string|max:255',
                'yes' => 'boolean',
                'no' => 'boolean',
                'remarks' => 'nullable|string',
            ]);

            $rrcyForm->update($validatedData);
            return response()->json($rrcyForm);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function destroy($id)
    {
        $rrcyForm = RrcyForm::find($id);
        if ($rrcyForm) {
            $rrcyForm->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
