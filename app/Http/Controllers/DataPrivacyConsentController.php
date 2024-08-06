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
            'client_id' => 'required|exists:clients,id',
            'client_signature' => 'required|string|max:255',
            'date' => 'required|date',
            'guardian_signature' => 'required|string|max:255',
        ]);

        $consent = DataPrivacyConsent::create($validatedData);
        return response()->json($consent, 201);
    }

    public function show($id)
    {
        $consent = DataPrivacyConsent::find($id);
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
                'client_id' => 'required|exists:clients,id',
                'client_signature' => 'required|string|max:255',
                'date' => 'required|date',
                'guardian_signature' => 'required|string|max:255',
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
