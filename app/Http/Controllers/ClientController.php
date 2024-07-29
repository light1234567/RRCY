<?php

// app/Http/Controllers/ClientController.php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return response()->json($clients);
    }

    public function show($id)
    {
        return Client::find($id);
    }

    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        $client->update($request->all());
        return $client;
    }

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
