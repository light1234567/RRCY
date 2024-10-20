<?php

namespace App\Http\Controllers;

use App\Models\NursingCareService;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class NursingCareServiceController extends Controller
{
    public function storeOrUpdate(Request $request)
    {
        Log::info('Store or Update method called', ['request_data' => $request->all()]);
    
        // Validate request data
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'current_medical_status' => 'nullable|string|max:50',
            'selectedMonth' => 'nullable|string|max:15',
            'temperature' => 'nullable|numeric',
            'pulse_rate' => 'nullable|integer',
            'respiratory_rate' => 'nullable|integer',
            'blood_pressure' => 'nullable|string|max:20',
            'height_cm' => 'nullable|numeric',
            'weight_kg' => 'nullable|numeric',
            'bmi' => 'nullable|numeric',
            'bmi_remarks' => 'nullable|string|max:100',
            'eyes_status' => 'nullable|string|max:50',
            'nails_status' => 'nullable|string|max:50',
            'ears_status' => 'nullable|string|max:50',
            'skin_status' => 'nullable|string|max:50',
            'mouth_teeth_status' => 'nullable|string|max:50',
            'hair_status' => 'nullable|string|max:50',
            'services_given' => 'nullable|string',
            'remarks' => 'nullable|string',
            'f_prepared_by' => 'nullable|string|max:50',
            's_prepared_by' => 'nullable|string|max:50',
            't_prepared_by' => 'nullable|string|max:50',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
        ]);
    
        Log::info('Validated Client ID:', ['client_id' => $validatedData['client_id']]);
    
        try {
            // Check if an id is provided for updating
            if ($request->has('id') && $request->id) {
                $nursingCareService = NursingCareService::find($request->id);
                if ($nursingCareService) {
                    // Handle image upload and deletion of the existing image
                    if ($request->hasFile('profile_image')) {
                        // Delete the old image if it exists
                        if ($nursingCareService->profile_image) {
                            $oldImagePath = public_path('profile_images/' . $nursingCareService->profile_image);
                            if (File::exists($oldImagePath)) {
                                File::delete($oldImagePath);
                                Log::info('Old profile image deleted:', ['image' => $nursingCareService->profile_image]);
                            }
                        }
    
                        // Upload new image
                        $image = $request->file('profile_image');
                        $filename = $image->getClientOriginalName();
                        $folderPath = public_path('profile_images');
    
                        // Create folder if it doesn't exist
                        if (!file_exists($folderPath)) {
                            mkdir($folderPath, 0755, true);
                        }
    
                        // Move the uploaded image to the folder
                        $image->move($folderPath, $filename);
                        $validatedData['profile_image'] = $filename; // Store just the file name
                    }
    
                    // Update the nursing care service
                    $nursingCareService->update($validatedData);
                    Log::info('NursingCareService record updated', ['nursingCareService' => $nursingCareService]);
                    return response()->json($nursingCareService);
                } else {
                    Log::error('NursingCareService not found for updating', ['id' => $request->id]);
                    return response()->json(['message' => 'Not found'], 404);
                }
            } else {
                // Handle the image upload for new record
                if ($request->hasFile('profile_image')) {
                    $image = $request->file('profile_image');
                    $filename = $image->getClientOriginalName();
                    $folderPath = public_path('profile_images');
    
                    // Create folder if it doesn't exist
                    if (!file_exists($folderPath)) {
                        mkdir($folderPath, 0755, true);
                    }
    
                    // Move the uploaded image to the folder
                    $image->move($folderPath, $filename);
                    $validatedData['profile_image'] = $filename; // Store just the file name
                }
    
                // Create a new NursingCareService record
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
            $client = Client::with('admissions')->find($id);

            if (!$client) {
                Log::error('Client not found', ['client_id' => $id]);
                return response()->json(['message' => 'Client not found'], 404);
            }

            Log::info('Fetched Client:', ['client' => $client->toArray()]);

            $nursingCareService = NursingCareService::where('client_id', $client->id)->first();

            if ($nursingCareService) {
                Log::info('Fetched NursingCareService:', ['nursingCareService' => $nursingCareService->toArray()]);
                return response()->json([
                    'client' => $client,
                    'assessment' => $nursingCareService,
                ]);
            } else {
                Log::warning('NursingCareService not found for client ID:', ['client_id' => $client->id]);
                return response()->json([
                    'client' => $client,
                    'assessment' => null,
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

    public function getByClientId($clientId)
{
    try {
        // Fetch the NursingCareService entry by client_id
        $nursingCareService = NursingCareService::where('client_id', $clientId)->first();

        if (!$nursingCareService) {
            return response()->json(['message' => 'Nursing Care Service not found'], 404);
        }

        // Fetch the corresponding client
        $client = Client::find($clientId);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        return response()->json([
            'client' => $client,
            'profile_image' => $nursingCareService->profile_image
        ]);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Server Error'], 500);
    }
}

}
