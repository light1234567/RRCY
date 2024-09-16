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
    // Log the start of the form saving process with all incoming request data
    Log::info('Incoming request data: ', $request->all());

    try {
        // Validate the request data
        $validated = $request->validate([
            'client.child_status' => 'required|string|max:50',
            'client.first_name' => 'required|string|max:50',
            'client.middle_name' => 'nullable|string|max:50',
            'client.last_name' => 'required|string|max:50',
            'client.suffix' => 'nullable|string|max:10',
            'client.sex' => 'required|string|max:10',
            'client.date_of_birth' => 'required|date',
            'client.place_of_birth' => 'required|string|max:100',
            'client.province' => 'required|string|max:50',
            'client.city' => 'required|string|max:50',
            'client.barangay' => 'required|string|max:50',
            'client.street' => 'nullable|string|max:100',
            'client.religion' => 'nullable|string|max:100',
            'distinguishing_marks.tattoo_scars' => 'nullable|string|max:100',
            'distinguishing_marks.height' => 'nullable|numeric',
            'distinguishing_marks.weight' => 'nullable|numeric',
            'distinguishing_marks.colour_of_eye' => 'nullable|string|max:50',
            'distinguishing_marks.skin_colour' => 'nullable|string|max:50',
            'admission.case_status' => 'required|string|max:100',
            'admission.committing_court' => 'required|string|max:100',
            'admission.crim_case_number' => 'required|string|max:100',
            'admission.offense_committed' => 'required|string|max:100',
            'admission.date_admitted' => 'required|date',
            'admission.days_in_jail' => 'required|integer',
            'admission.days_in_detention_center' => 'required|integer',
            'admission.action_taken' => 'required|string|max:255',
            'admission.general_impression' => 'required|string',
            'documents_submitted.documents' => 'array',
            'documents_submitted.documents.*' => 'string|max:255',
            'documents_submitted.others' => 'nullable|string|max:50',
            'admission.referring_party_name' => 'nullable|string|max:100',
            'referring_party_signature' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'admission.admitting_officer' => 'nullable|string|max:100',
            'admission.designation_id_contact' => 'nullable|string|max:100',
            'admission.designation' => 'nullable|string|max:100',
            'admission.office_address' => 'nullable|string|max:100',
            'admission.date_time' => 'nullable|date',
            'admission.noted_by' => 'nullable|string|max:100',
        ]);        

        Log::info('Validation passed. Validated data: ', $validated);

        // Check if client_id is provided, update existing client or create a new one
        $client = $request->client_id 
            ? Client::find($request->client_id) 
            : new Client();

        if (!$client) {
            return response()->json(['error' => 'Client not found.'], 404);
        }

        // Update or create the client record
        $client->fill($validated['client']);
        $client->save();

        Log::info('Client record saved or updated: ', ['client_id' => $client->id]);

        // Prepare admission data and link it to the client
        $admissionData = $validated['admission'];
        $admissionData['client_id'] = $client->id;

        // Update or create the admission record
        $admission = $request->admission_id 
            ? Admission::where('id', $request->admission_id)->where('client_id', $client->id)->first()
            : new Admission();

        if (!$admission) {
            $admission = new Admission();
            $admission->fill($admissionData);
            $admission->save();
        } else {
            $admission->fill($admissionData);
            $admission->save();
        }

        Log::info('Admission record saved or updated: ', ['admission_id' => $admission->id]);

        // Handle signature file upload if exists
        if ($request->hasFile('referring_party_signature')) {
            Log::info('Uploading referring party signature.');

            $file = $request->file('referring_party_signature');

            // Check if the file is valid
            if ($file && $file->isValid()) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $signaturePath = $file->storeAs('signatures', $fileName, 'public'); // Save to public storage

                $admission->referring_party_signature = $signaturePath;
                $admission->save();

                Log::info('Referring party signature uploaded successfully: ', ['signature_path' => $signaturePath]);
            } else {
                Log::error('Referring party signature upload failed: Invalid file.');
                return response()->json(['error' => 'Invalid file upload'], 422);
            }
        }

        // Update or create distinguishing marks
        DistinguishingMark::updateOrCreate(
            ['admission_id' => $admission->id],
            $validated['distinguishing_marks']
        );
        Log::info('Distinguishing marks saved or updated for admission ID: ', ['admission_id' => $admission->id]);

        // Process submitted documents
        $documents = $validated['documents_submitted']['documents'] ?? [];
        $others = $validated['documents_submitted']['others'] ?? null;
        if ($others) {
            if (!in_array($others, $documents)) { // Check if "Others" is already in the array
                $documents[] = $others;
            }
        }
        Log::info('Documents to be saved for admission: ', ['documents' => $documents]);

        // Save or update the documents as a JSON array for the given admission_id
        DocumentSubmitted::updateOrCreate(
            ['admission_id' => $admission->id],
            ['document_name' => json_encode($documents), 'submitted' => true]
        );

        Log::info('Documents submitted record saved or updated for admission ID: ', ['admission_id' => $admission->id]);

        // Return success response
        Log::info('Form save process completed successfully.');
        return response()->json(['message' => 'Form saved successfully!'], 200);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Log validation errors
        Log::error('Validation failed: ', ['errors' => $e->errors()]);
        return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422);
    } catch (\Exception $e) {
        // Log any other errors
        Log::error('Error saving form: ' . $e->getMessage(), ['stack_trace' => $e->getTraceAsString()]);
        return response()->json(['error' => 'Failed to save form'], 500);
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