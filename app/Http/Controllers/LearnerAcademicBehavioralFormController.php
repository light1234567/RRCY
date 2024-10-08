<?php

namespace App\Http\Controllers;

use App\Models\LearnerAcademicBehavioralForm;
use App\Models\Client;
use Illuminate\Http\Request;

class LearnerAcademicBehavioralFormController extends Controller
{
    public function show($client_id)
    {
        $client = Client::find($client_id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $form = LearnerAcademicBehavioralForm::where('client_id', $client_id)->first();

        return response()->json([
            'form' => $form,
            'client' => $client,
        ]);
    }

    public function storeOrUpdate(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'month' => 'nullable|string|max:10',
            'school_year' => 'nullable|string|max:10',
            'learner_name' => 'nullable|string|max:50',
            'grade' => 'nullable|string|max:20',
            'lrn' => 'nullable|string|max:20',
            'status' => 'nullable|string|max:20',
            'skills' => 'nullable|array',
            'observation_feedback' => 'nullable|string',
            'category_adviser_signature' => 'nullable|string|max:150',
            'educational_section_head_signature' => 'nullable|string|max:150',
        ]);        

        $form = LearnerAcademicBehavioralForm::updateOrCreate(
            [
                'client_id' => $validatedData['client_id'],
            ],
            $validatedData
        );

        return response()->json($form, 201);
    }
}
