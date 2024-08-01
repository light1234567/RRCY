<?php

// app/Http/Controllers/ClientController.php

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

    // Fetch a single client by ID
    public function show($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        return response()->json($client);
    }

    // Update a client's details
    public function updateStatus($id, Request $request)
    {
        $client = Client::findOrFail($id);
        $client->Status = $request->input('Status');
        $client->save();

        return response()->json(['message' => 'Client status updated successfully', 'client' => $client], 200);
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