<?php

namespace App\Http\Controllers;

use App\Models\Talambuhay;
use Illuminate\Http\Request;

class TalambuhayController extends Controller
{
    public function index()
    {
        $talambuhay = Talambuhay::all();
        return response()->json($talambuhay);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'about_my_family' => 'required|string',
            'about_my_self' => 'required|string',
            'about_my_case' => 'required|string',
            'case_manager' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $talambuhay = Talambuhay::create($validatedData);
        return response()->json($talambuhay, 201);
    }

    public function show($id)
    {
        $talambuhay = Talambuhay::find($id);
        if ($talambuhay) {
            return response()->json($talambuhay);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $talambuhay = Talambuhay::find($id);
        if ($talambuhay) {
            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'about_my_family' => 'required|string',
                'about_my_self' => 'required|string',
                'about_my_case' => 'required|string',
                'case_manager' => 'required|string|max:255',
                'date' => 'required|date',
            ]);

            $talambuhay->update($validatedData);
            return response()->json($talambuhay);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function destroy($id)
    {
        $talambuhay = Talambuhay::find($id);
        if ($talambuhay) {
            $talambuhay->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
