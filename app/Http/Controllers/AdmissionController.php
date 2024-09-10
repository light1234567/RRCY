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
    Log::info('Incoming request data: ', $request->all());

    // Validate the incoming request data
    $validated = $request->validate([
        'client.child_status' => 'required|string|max:255',
        'client.first_name' => 'required|string|max:255',
        'client.middle_name' => 'nullable|string|max:255',
        'client.last_name' => 'required|string|max:255',
        'client.suffix' => 'nullable|string|max:10',
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
        'admission.referring_party_name' => 'nullable|string|max:255',
        'referring_party_signature' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        'admission.admitting_officer' => 'nullable|string|max:255',
        'admission.designation_id_contact' => 'nullable|string|max:255',
        'admission.designation' => 'nullable|string|max:255',
        'admission.office_address' => 'nullable|string|max:255',
        'admission.date_time' => 'nullable|date',
        'admission.noted_by' => 'nullable|string|max:255',
    ]);

    Log::info('Validated data: ', $validated);

    // Replace NULL values with empty strings for optional fields like suffix
    $validated['client']['suffix'] = $validated['client']['suffix'] ?? '';

    // Check if the client with the same first name, last name, and date admitted exists
    $clientExists = Client::where('first_name', $validated['client']['first_name'])
        ->where('last_name', $validated['client']['last_name'])
        ->whereHas('admissions', function ($query) use ($validated) {
            $query->where('date_admitted', $validated['admission']['date_admitted']);
        })
        ->exists();

    Log::info('Client exists: ', ['exists' => $clientExists]);

    if ($clientExists) {
        return response()->json(['error' => 'Client with the same first name, last name, and date admitted already exists.'], 400);
    }

    try {
        // Create the client record
        $client = Client::create($validated['client']);
        Log::info('Client created: ', ['client_id' => $client->id]);

        // Prepare the admission data
        $admissionData = $validated['admission'];
        $admissionData['client_id'] = $client->id;

        Log::info('Prepared admission data: ', $admissionData);

        // Handle the referring party signature file if uploaded
        if ($request->hasFile('referring_party_signature')) {
            $file = $request->file('referring_party_signature');
            
            // Get the original filename
            $originalFileName = $file->getClientOriginalName();
            
            // Optionally, you can add a timestamp or unique identifier to avoid overwriting files with the same name
            $fileName = time() . '_' . $originalFileName;
            
            // Store the file with the original file name in the "signatures" directory
            $signaturePath = $file->storeAs('signatures', $fileName, 'public');
            
            // Store the file path in the database
            $admissionData['referring_party_signature'] = $signaturePath;
        
            Log::info('Signature uploaded with original name: ', ['signature_path' => $signaturePath]);
        }
        

        // Create the admission record
        $admission = Admission::create($admissionData);
        Log::info('Admission created: ', ['admission_id' => $admission->id]);

        // Check if the admission fields were actually saved
        $savedAdmission = Admission::find($admission->id);
        Log::info('Saved Admission Details', [
            'referring_party_name' => $savedAdmission->referring_party_name,
            'admitting_officer' => $savedAdmission->admitting_officer,
            'designation_id_contact' => $savedAdmission->designation_id_contact,
            'designation' => $savedAdmission->designation,
            'office_address' => $savedAdmission->office_address,
            'date_time' => $savedAdmission->date_time,
        ]);

        // Create distinguishing marks records
        $distinguishingMarksData = $validated['distinguishing_marks'];
        $distinguishingMarksData['admission_id'] = $admission->id;
        DistinguishingMark::create($distinguishingMarksData);
        Log::info('Distinguishing marks created: ', $distinguishingMarksData);

        // Process submitted documents
        $documents = !empty($validated['documents_submitted']['documents'])
            ? implode(', ', array_diff($validated['documents_submitted']['documents'], ['Others']))
            : '';

        // If 'Others' is specified, append it to the documents string
        if (!empty($validated['documents_submitted']['others'])) {
            $documents .= ($documents ? ', ' : '') . $validated['documents_submitted']['others'];
        }

        Log::info('Processed documents: ', ['documents' => $documents]);

        // Create the documents submitted record
        DocumentSubmitted::create([
            'admission_id' => $admission->id,
            'document_name' => $documents,
            'submitted' => true,
        ]);

        Log::info('Documents submitted: ', ['admission_id' => $admission->id, 'documents' => $documents]);

        return response()->json(['message' => 'Form saved successfully!'], 200);
    } catch (\Exception $e) {
        Log::error('Failed to save form: ', ['error' => $e->getMessage()]);
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
    public function getClientsByName(Request $request)
    {
        $first_name = $request->query('first_name');
        $last_name = $request->query('last_name');
        $date_of_birth = $request->query('date_of_birth'); // Added date_of_birth to query parameters
    
        // Check if required query parameters are provided
        if (!$first_name || !$last_name || !$date_of_birth) {
            return response()->json(['error' => 'Missing first_name, last_name, or date_of_birth query parameter'], 400);
        }
    
        // Fetch clients with the same first name, last name, and date of birth, and eager load related admissions and associated distinguishingMarks and documents
        $clients = Client::where('first_name', $first_name)
                         ->where('last_name', $last_name)
                         ->where('date_of_birth', $date_of_birth)
                         ->with([
                             'admissions.distinguishingMarks',
                             'admissions.documents'
                         ])
                         ->get();
    
        return response()->json($clients);
    }
    
    
    
    }
