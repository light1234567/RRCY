<?php

namespace App\Http\Controllers;

use App\Models\DataPrivacyConsent;
use Illuminate\Http\Request;

class DataPrivacyConsentController extends Controller
{
    public function index()
    {
        $consents = DataPrivacyConsent::all();
        return response()->json($consents);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'date' => 'nullable|date',
            'guardian_signature' => 'nullable|string|max:50',
        ]);        

        $consent = DataPrivacyConsent::create($validatedData);
        return response()->json($consent, 201);
    }

    public function show($client_id)
    {
        $consent = DataPrivacyConsent::where('client_id', $client_id)->first();
        if ($consent) {
            return response()->json($consent);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
    

    public function update(Request $request, $id)
    {
        $consent = DataPrivacyConsent::find($id);
        if ($consent) {
            $validatedData = $request->validate([
                'client_id' => 'nullable|exists:clients,id',
                'date' => 'nullable|date',
                'guardian_signature' => 'nullable|string|max:50',
            ]);            

            $consent->update($validatedData);
            return response()->json($consent);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function destroy($id)
    {
        $consent = DataPrivacyConsent::find($id);
        if ($consent) {
            $consent->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
