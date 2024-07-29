<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Admission;
use App\Models\DistinguishingMark;
use App\Models\DocumentSubmitted;
use Illuminate\Support\Facades\Log;

class AdmissionController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'client.name' => 'required|string|max:255',
            'client.sex' => 'required|string|max:10',
            'client.address' => 'required|string|max:255',
            'client.date_of_birth' => 'required|date',
            'client.religion' => 'nullable|string|max:255',
            'client.occupation' => 'nullable|string|max:255',
            'admission.committing_court' => 'required|string|max:255',
            'admission.crim_case_number' => 'required|string|max:255',
            'admission.offense_committed' => 'required|string|max:255',
            'admission.date_admitted' => 'required|date',
            'admission.days_in_jail' => 'required|integer',
            'admission.days_in_detention_center' => 'required|integer',
            'admission.action_taken' => 'required|string|max:255',
            'admission.highest_educ_att' => 'nullable|string|max:255',
            'admission.school_name' => 'nullable|string|max:255',
            'admission.class_adviser' => 'nullable|string|max:255',
            'distinguishing_marks.tattoo_scars' => 'nullable|string|max:255',
            'distinguishing_marks.height' => 'required|numeric',
            'distinguishing_marks.weight' => 'required|numeric',
            'distinguishing_marks.colour_of_eye' => 'nullable|string|max:255',
            'distinguishing_marks.skin' => 'nullable|string|max:255',
            'documents.scsr' => 'boolean',
            'documents.courtOrder' => 'boolean',
            'documents.medicalCertificates' => 'boolean',
            'documents.consConsent' => 'boolean',
            'documents.schoolRecords' => 'boolean',
            'documents.others' => 'boolean',
        ]);

        // Create the client
        $client = Client::create($validatedData['client']);

        if (!$client) {
            return response()->json(['error' => 'Client creation failed'], 500);
        }

        // Add the client_id to the admission data
        $validatedData['admission']['client_id'] = $client->id;

        // Create the admission record
        $admission = Admission::create($validatedData['admission']);

        if (!$admission) {
            return response()->json(['error' => 'Admission creation failed'], 500);
        }

        // Add the admission_id and client_id to the distinguishing marks data
        $validatedData['distinguishing_marks']['admission_id'] = $admission->id;
        $validatedData['distinguishing_marks']['client_id'] = $client->id;

        // Create the distinguishing marks record
        $distinguishingMark = DistinguishingMark::create($validatedData['distinguishing_marks']);

        if (!$distinguishingMark) {
            return response()->json(['error' => 'Distinguishing marks creation failed'], 500);
        }

        // Create the documents submitted records
        foreach ($validatedData['documents'] as $documentType => $isSubmitted) {
            if ($isSubmitted) {
                $documentSubmitted = DocumentSubmitted::create([
                    'admission_id' => $admission->id,
                    'client_id' => $client->id,
                    $documentType => true,
                ]);

                if (!$documentSubmitted) {
                    return response()->json(['error' => 'Document submission creation failed'], 500);
                }
            }
        }

        return response()->json(['message' => 'Admission created successfully', 'admission' => $admission], 201);
    }
}
