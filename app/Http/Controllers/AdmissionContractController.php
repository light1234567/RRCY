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
            'client_id' => 'nullable|exists:clients,id',
            'signed_day' => 'nullable|integer|min:1|max:32', 
            'signed_month' => 'nullable|string|max:10', 
            'parent_custodian_name' => 'nullable|string|max:50', 
            'lgu_worker_name' => 'nullable|string|max:50',
            'rrcy_officer' => 'nullable|string|max:50', 
            'houseparent_on_duty' => 'nullable|string|max:50', 
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
                'client_id' => 'nullable|exists:clients,id',
                'signed_day' => 'nullable|integer|min:1|max:32',
                'signed_month' => 'nullable|string|max:10', 
                'parent_custodian_name' => 'nullable|string|max:50', 
                'lgu_worker_name' => 'nullable|string|max:50',
                'rrcy_officer' => 'nullable|string|max:50', 
                'houseparent_on_duty' => 'nullable|string|max:50', 
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
?>
