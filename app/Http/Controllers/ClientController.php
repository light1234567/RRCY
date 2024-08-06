<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Fetch all clients
    public function index()
    {
        $clients = Client::all();
        return response()->json($clients);
    }

    // Fetch all clients with related admissions, distinguishing marks, and documents
    public function fetchAllClientsData()
    {
        $clients = Client::with(['admissions.distinguishingMarks', 'admissions.documents'])->get();
        return response()->json($clients);
    }

    // Fetch a single client by ID
    public function show($id)
    {
        $client = Client::with(['admissions.distinguishingMarks', 'admissions.documents'])->find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        return response()->json($client);
    }

    // Delete a client by ID
    public function destroy($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $client->delete();

        return response()->json(['message' => 'Client deleted successfully'], 200);
    }
}