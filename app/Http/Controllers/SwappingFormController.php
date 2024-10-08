<?php

namespace App\Http\Controllers;

use App\Models\SwappingForm;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SwappingFormController extends Controller
{
    public function index()
    {
        $forms = SwappingForm::with('client')->get();
        return response()->json($forms);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date_of_filing' => 'nullable|date',
            'requesting_party_name' => 'nullable|string|max:50',
            'requesting_party_position' => 'nullable|string|max:50',
            'accepted_by_position' => 'nullable|string|max:50',
            'requested_by_position' => 'nullable|string|max:50',
            'date_of_duty' => 'nullable|date',
            'time_of_duty' => 'nullable|date_format:H:i',
            'sod_name' => 'nullable|string|max:50',
            'sod_date_of_duty' => 'nullable|date',
            'sod_position' => 'nullable|string|max:50',
            'sod_shift_time' => 'nullable|string|max:20',
            'purpose' => 'nullable|string',
            'requested_by' => 'nullable|string|max:50',
            'accepted_by' => 'nullable|string|max:50',
            'swapping_shp' => 'nullable|string|max:50',
            'approved_by' => 'nullable|string|max:50',
        ]);        

        try {
            $form = SwappingForm::updateOrCreate(
                ['client_id' => $validatedData['client_id']],
                $validatedData
            );

            Log::info("Successfully saved Swapping Form", $form->toArray());
            return response()->json($form, 201);
        } catch (\Exception $e) {
            Log::error("Error storing Swapping Form", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $validatedData
            ]);

            return response()->json(['message' => 'Failed to store form', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($client_id)
    {
        $client = Client::find($client_id);
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $form = SwappingForm::where('client_id', $client_id)->first();

        return response()->json([
            'form' => $form,
            'client' => $client,
        ]);
    }

    public function update(Request $request, $client_id)
    {
        $validatedData = $request->validate([
            'date_of_filing' => 'nullable|date',
            'requesting_party_name' => 'nullable|string|max:50',
            'requesting_party_position' => 'nullable|string|max:50',
            'accepted_by_position' => 'nullable|string|max:50',
            'requested_by_position' => 'nullable|string|max:50',
            'date_of_duty' => 'nullable|date',
            'time_of_duty' => 'nullable|date_format:H:i',
            'sod_name' => 'nullable|string|max:50',
            'sod_date_of_duty' => 'nullable|date',
            'sod_position' => 'nullable|string|max:50',
            'sod_shift_time' => 'nullable|string|max:20',
            'purpose' => 'nullable|string',
            'requested_by' => 'nullable|string|max:50',
            'accepted_by' => 'nullable|string|max:50',
            'swapping_shp' => 'nullable|string|max:50',
            'noted_by' => 'nullable|string|max:50',
            'approved_by' => 'nullable|string|max:50',
        ]);
    
        try {
            Log::info("Validated data:", $validatedData); // Log validated data
    
            $form = SwappingForm::updateOrCreate(
                ['client_id' => $client_id],
                $validatedData
            );
    
            Log::info("Successfully updated Swapping Form", $form->toArray()); // Log success
            return response()->json($form, 200);
        } catch (\Exception $e) {
            Log::error("Error updating Swapping Form", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $validatedData
            ]);
    
            return response()->json(['message' => 'Failed to update form', 'error' => $e->getMessage()], 500);
        }
    }
    
    public function destroy($id)
    {
        $form = SwappingForm::find($id);
        if ($form) {
            $form->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
