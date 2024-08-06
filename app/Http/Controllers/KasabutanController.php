<?php

namespace App\Http\Controllers;

use App\Models\Kasabutan;
use Illuminate\Http\Request;

class KasabutanController extends Controller
{
    public function index()
    {
        $kasabutans = Kasabutan::all();
        return response()->json($kasabutans);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'client_resident' => 'required',
            'parent_guardian' => 'required',
            'case_manager' => 'required',
        ]);

        $kasabutan = Kasabutan::create($validatedData);
        return response()->json($kasabutan, 201);
    }

    public function show($id)
    {
        $kasabutan = Kasabutan::find($id);
        if ($kasabutan) {
            return response()->json($kasabutan);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $kasabutan = Kasabutan::find($id);
        if ($kasabutan) {
            $validatedData = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'client_resident' => 'required',
                'parent_guardian' => 'required',
                'case_manager' => 'required',
            ]);

            $kasabutan->update($validatedData);
            return response()->json($kasabutan);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function destroy($id)
    {
        $kasabutan = Kasabutan::find($id);
        if ($kasabutan) {
            $kasabutan->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
