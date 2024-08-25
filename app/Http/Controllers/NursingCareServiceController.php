<?php

namespace App\Http\Controllers;

use App\Models\NursingCareService;
use Illuminate\Http\Request;

class NursingCareServiceController extends Controller
{
    public function index()
    {
        return response()->json(NursingCareService::all());
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'client_id' => 'required|exists:clients,id',  // Make sure client_id is required
        'date_of_admission' => 'required|date',
        'current_medical_status' => 'nullable|string',
        'temperature' => 'nullable|numeric',
        'pulse_rate' => 'nullable|integer',
        'respiratory_rate' => 'nullable|integer',
        'blood_pressure' => 'nullable|string',
        'height_cm' => 'nullable|numeric',
        'weight_kg' => 'nullable|numeric',
        'bmi' => 'nullable|numeric',
        'bmi_remarks' => 'nullable|string',
        'eyes_status' => 'nullable|string',
        'nails_status' => 'nullable|string',
        'ears_status' => 'nullable|string',
        'skin_status' => 'nullable|string',
        'mouth_teeth_status' => 'nullable|string',
        'hair_status' => 'nullable|string',
        'services_given' => 'nullable|string',
        'remarks' => 'nullable|string',
        'prepared_by' => 'nullable|string',
        'noted_by' => 'nullable|string',
    ]);

    try {
        $nursingCareService = NursingCareService::create($data);
        return response()->json($nursingCareService, 201);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to create record', 'errors' => $e->getMessage()], 422);
    }
}



    public function show($id)
    {
        $nursingCareService = NursingCareService::find($id);
        if ($nursingCareService) {
            return response()->json($nursingCareService);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $nursingCareService = NursingCareService::find($id);
        if ($nursingCareService) {
            $data = $request->validate([
                'client_id' => 'nullable|exists:clients,id',
                'date_of_admission' => 'required|date',
                'current_medical_status' => 'nullable|string',
                'temperature' => 'nullable|numeric',
                'pulse_rate' => 'nullable|integer',
                'respiratory_rate' => 'nullable|integer',
                'blood_pressure' => 'nullable|string',
                'height_cm' => 'nullable|numeric',
                'weight_kg' => 'nullable|numeric',
                'bmi' => 'nullable|numeric',
                'bmi_remarks' => 'nullable|string',
                'eyes_status' => 'nullable|string',
                'nails_status' => 'nullable|string',
                'ears_status' => 'nullable|string',
                'skin_status' => 'nullable|string',
                'mouth_teeth_status' => 'nullable|string',
                'hair_status' => 'nullable|string',
                'services_given' => 'nullable|string',
                'remarks' => 'nullable|string',
                'prepared_by' => 'nullable|string',
                'noted_by' => 'nullable|string',
            ]);

            $nursingCareService->update($data);
            return response()->json($nursingCareService);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function destroy($id)
    {
        $nursingCareService = NursingCareService::find($id);
        if ($nursingCareService) {
            $nursingCareService->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
