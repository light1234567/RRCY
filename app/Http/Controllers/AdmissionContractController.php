<?php

namespace App\Http\Controllers;

use App\Models\AdmissionContract;
use Illuminate\Http\Request;

class AdmissionContractController extends Controller
{
    public function index()
    {
        $admissionContracts = AdmissionContract::all();
        return response()->json($admissionContracts);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'admission_id' => 'required|exists:admissions,id',
            'client_id' => 'required|exists:clients,id',
            'signed_date' => 'required|date',
            'parent_custodian_signature' => 'required|string|max:255',
            'lgu_worker_name' => 'required|string|max:255',
            'rrcy_officer' => 'required|string|max:255',
            'houseparent_on_duty' => 'required|string|max:255',
        ]);

        $admissionContract = AdmissionContract::create($validatedData);
        return response()->json($admissionContract, 201);
    }

    public function show($id)
    {
        $admissionContract = AdmissionContract::find($id);
        if ($admissionContract) {
            return response()->json($admissionContract);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $admissionContract = AdmissionContract::find($id);
        if ($admissionContract) {
            $validatedData = $request->validate([
                'admission_id' => 'required|exists:admissions,id',
                'client_id' => 'required|exists:clients,id',
                'signed_date' => 'required|date',
                'parent_custodian_signature' => 'required|string|max:255',
                'lgu_worker_name' => 'required|string|max:255',
                'rrcy_officer' => 'required|string|max:255',
                'houseparent_on_duty' => 'required|string|max:255',
            ]);

            $admissionContract->update($validatedData);
            return response()->json($admissionContract);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function destroy($id)
    {
        $admissionContract = AdmissionContract::find($id);
        if ($admissionContract) {
            $admissionContract->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
