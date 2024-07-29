<?php

// app/Http/Controllers/ClientController.php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Existing method to fetch all clients
    public function index()
    {
        $clients = Client::all();
        return response()->json($clients);
    }

    // New method to fetch a single client by ID
    public function show($id)
    {
        $client = Client::find($id);
        if ($client) {
            return response()->json($client);
        }
        return response()->json(['message' => 'Client not found'], 404);
    }
}
