<?php

namespace App\Http\Controllers;

use App\Models\CiclSession;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CiclSessionController extends Controller
{
    public function index()
    {
        $sessions = CiclSession::with('client')->get();
        return response()->json($sessions);
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'client_id' => 'required|exists:clients,id',
        'drn' => 'nullable|string|max:255',
        'session' => 'nullable|string|max:255',
        'title' => 'nullable|string|max:255',
        'date_conducted' => 'nullable|date',
        'objective' => 'nullable|string',
        'methodology' => 'nullable|string',
        'highlight' => 'nullable|string',
        'outcome' => 'nullable|string',
        'noted_by' => 'nullable|string|max:255',
        'approved_by' => 'nullable|string|max:255',
    ]);

    try {
        // Check if a session already exists for the client
        $session = CiclSession::where('client_id', $validatedData['client_id'])->first();

        if ($session) {
            // If a session exists, update it instead of creating a new one
            $session->update($validatedData);
        } else {
            // Create a new session if none exists
            $session = CiclSession::create($validatedData);
        }

        Log::info("Successfully saved CICL session", $session->toArray());
        return response()->json($session, 201);
    } catch (\Exception $e) {
        Log::error("Error storing CICL session", [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'data' => $validatedData
        ]);

        return response()->json(['message' => 'Failed to store session', 'error' => $e->getMessage()], 500);
    }
}

    public function show($client_id)
    {
        $client = Client::find($client_id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $session = CiclSession::where('client_id', $client_id)->first();

        return response()->json([
            'session' => $session,
            'client' => $client,
        ]);
    }

    public function update(Request $request, $client_id)
{
    $validatedData = $request->validate([
        'drn' => 'nullable|string|max:255',
        'session' => 'nullable|string|max:255',
        'title' => 'nullable|string|max:255',
        'date_conducted' => 'nullable|date',
        'objective' => 'nullable|string',
        'methodology' => 'nullable|string',
        'highlight' => 'nullable|string',
        'outcome' => 'nullable|string',
        'noted_by' => 'nullable|string|max:255',
        'approved_by' => 'nullable|string|max:255',
    ]);

    try {
        // Find the session by client_id
        $session = CiclSession::where('client_id', $client_id)->first();

        // If the session exists, update it
        if ($session) {
            $session->update($validatedData);
        } else {
            // If no session exists for this client, create a new one
            $validatedData['client_id'] = $client_id;
            $session = CiclSession::create($validatedData);
        }

        Log::info("Successfully updated CICL session", $session->toArray());
        return response()->json($session, 200);
    } catch (\Exception $e) {
        Log::error("Error updating CICL session", [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'data' => $validatedData
        ]);

        return response()->json(['message' => 'Failed to update session', 'error' => $e->getMessage()], 500);
    }
}


    public function destroy($id)
    {
        $session = CiclSession::find($id);
        if ($session) {
            $session->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
