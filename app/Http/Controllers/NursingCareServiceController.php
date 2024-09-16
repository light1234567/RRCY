<?php

namespace App\Http\Controllers;

use App\Models\NursingCareService;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NursingCareServiceController extends Controller
{
    public function storeOrUpdate(Request $request)
{
    Log::info('Store or Update method called', ['request_data' => $request->all()]);

    $validator = Validator::make($request->all(), [
        'client_id' => 'required|exists:clients,id',
        'date_of_admission' => 'required|date',
        'current_medical_status' => 'nullable|string|max:255',
        'temperature' => 'nullable|numeric',
        'pulse_rate' => 'nullable|integer',
        'respiratory_rate' => 'nullable|integer',
        'blood_pressure' => 'nullable|string|max:20',
        'height_cm' => 'nullable|numeric',
        'weight_kg' => 'nullable|numeric',
        'bmi' => 'nullable|numeric',
        'bmi_remarks' => 'nullable|string|max:100',
        'eyes_status' => 'nullable|string|max:100',
        'nails_status' => 'nullable|string|max:100',
        'ears_status' => 'nullable|string|max:100',
        'skin_status' => 'nullable|string|max:100',
        'mouth_teeth_status' => 'nullable|string|max:100',
        'hair_status' => 'nullable|string|max:100',
        'services_given' => 'nullable|string',
        'remarks' => 'nullable|string',
        'prepared_by' => 'nullable|string|max:100',
        'noted_by' => 'nullable|string|max:100',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);    

    if ($validator->fails()) {
        Log::error('Validation failed', ['errors' => $validator->errors()->toArray()]);
        return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
    }

    $validatedData = $validator->validated();

    // Handle image upload
    if ($request->hasFile('profile_image')) {
        try {
            $originalName = $request->file('profile_image')->getClientOriginalName();
            $path = $request->file('profile_image')->storeAs('profile_images', $originalName, 'public');
            $validatedData['profile_image'] = $path;
            Log::info('Profile image uploaded', ['path' => $path]);
        } catch (\Exception $e) {
            Log::error('Profile image upload failed', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Profile image upload failed', 'errors' => $e->getMessage()], 500);
        }
    }

    try {
        // Save or update the NursingCareService record
        if ($request->has('id') && $request->id) {
            $nursingCareService = NursingCareService::find($request->id);
            if ($nursingCareService) {
                if (isset($validatedData['profile_image'])) {
                    if ($nursingCareService->profile_image && Storage::disk('public')->exists($nursingCareService->profile_image)) {
                        Storage::disk('public')->delete($nursingCareService->profile_image);
                    }
                }

                $nursingCareService->update($validatedData);
                Log::info('NursingCareService record updated', ['nursingCareService' => $nursingCareService]);
                return response()->json($nursingCareService);
            } else {
                Log::error('NursingCareService not found for updating', ['id' => $request->id]);
                return response()->json(['message' => 'Not found'], 404);
            }
        } else {
            $nursingCareService = NursingCareService::create($validatedData);
            Log::info('NursingCareService record created', ['nursingCareService' => $nursingCareService]);
            return response()->json($nursingCareService, 201);
        }
    } catch (\Exception $e) {
        Log::error('Failed to save NursingCareService record', [
            'error_message' => $e->getMessage(),
            'stack_trace' => $e->getTraceAsString(),
        ]);
        return response()->json(['message' => 'Failed to save record', 'errors' => $e->getMessage()], 500);
    }
}





    public function show($id)
    {
        try {
            // Fetch the client with related admissions using eager loading
            $client = Client::with('admissions')->find($id);

            if (!$client) {
                Log::error('Client not found', ['client_id' => $id]);
                return response()->json(['message' => 'Client not found'], 404);
            }

            Log::info('Fetched Client:', ['client' => $client->toArray()]);

            // Attempt to find a NursingCareService for the client
            $nursingCareService = NursingCareService::where('client_id', $client->id)->first();

            if ($nursingCareService) {
                Log::info('Fetched NursingCareService:', ['nursingCareService' => $nursingCareService->toArray()]);
                return response()->json([
                    'client' => $client,
                    'assessment' => $nursingCareService,
                    'profile_image' => $client->profile_image,
                ]);
            } else {
                Log::warning('NursingCareService not found for client ID:', ['client_id' => $client->id]);
                return response()->json([
                    'client' => $client,
                    'assessment' => null,
                    'profile_image' => $client->profile_image,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error fetching client or nursing care service:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Server Error'], 500);
        }
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
