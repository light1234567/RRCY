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
    public function saveForm(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'client.child_status' => 'required|string|max:255',
            'client.first_name' => 'required|string|max:255',
            'client.middle_name' => 'nullable|string|max:255',
            'client.last_name' => 'required|string|max:255',
            'client.suffix' => 'string|max:10',
            'client.sex' => 'required|string|max:10',
            'client.date_of_birth' => 'required|date',
            'client.place_of_birth' => 'required|string|max:255',
            'client.province' => 'required|string|max:255',
            'client.city' => 'required|string|max:255',
            'client.barangay' => 'required|string|max:255',
            'client.street' => 'nullable|string|max:255',
            'client.religion' => 'nullable|string|max:255',
            'distinguishing_marks.tattoo_scars' => 'nullable|string|max:255',
            'distinguishing_marks.height' => 'nullable|numeric',
            'distinguishing_marks.weight' => 'nullable|numeric',
            'distinguishing_marks.colour_of_eye' => 'nullable|string|max:255',
            'distinguishing_marks.skin_colour' => 'nullable|string|max:255',
            'admission.case_status' => 'required|string|max:255',
            'admission.committing_court' => 'required|string|max:255',
            'admission.crim_case_number' => 'required|string|max:255',
            'admission.offense_committed' => 'required|string|max:255',
            'admission.date_admitted' => 'required|date',
            'admission.days_in_jail' => 'required|integer',
            'admission.days_in_detention_center' => 'required|integer',
            'admission.action_taken' => 'required|string|max:255',
            'admission.general_impression' => 'required|string|max:255',
            'documents_submitted.documents' => 'array',
            'documents_submitted.documents.*' => 'string|max:255',
            'documents_submitted.others' => 'nullable|string|max:255',
        ]);

        try {
            // Create the client
            $client = Client::create($validated['client']);

            // Add the client_id to the admission data
            $admissionData = $validated['admission'];
            $admissionData['client_id'] = $client->id;

            // Create the admission record
            $admission = Admission::create($admissionData);

            // Add the admission_id to the distinguishing marks data
            $distinguishingMarksData = $validated['distinguishing_marks'];
            $distinguishingMarksData['admission_id'] = $admission->id;

            // Create the distinguishing marks record
            DistinguishingMark::create($distinguishingMarksData);

            // Concatenate documents into a single string
            $documents = !empty($validated['documents_submitted']['documents'])
                ? implode(', ', array_diff($validated['documents_submitted']['documents'], ['Others']))
                : '';

            // If 'Others' is specified, add it to the documents string
            if (!empty($validated['documents_submitted']['others'])) {
                $documents .= ($documents ? ', ' : '') . $validated['documents_submitted']['others'];
            }

            // Create the documents submitted record
            DocumentSubmitted::create([
                'admission_id' => $admission->id,
                'document_name' => $documents,
                'submitted' => true,
            ]);

            return response()->json(['message' => 'Form saved successfully!'], 200);
        } catch (\Exception $e) {
            Log::error('Failed to save form: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to save form. Please try again.'], 500);
        }
    }

    public function getAllData()
    {
        $clients = Client::with([
            'admissions.distinguishingMarks',
            'admissions.documents'
        ])->get();
        return response()->json($clients);
    }
    
public function getAdmissionByClientId($client_id)
{
    $admission = Admission::where('client_id', $client_id)->first();

    if (!$admission) {
        return response()->json(['message' => 'Admission not found'], 404);
    }

    return response()->json($admission);
}

}