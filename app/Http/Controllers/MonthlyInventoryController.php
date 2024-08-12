<?php

namespace App\Http\Controllers;

use App\Models\MonthlyInventory;
use App\Models\InventoryItem;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MonthlyInventoryController extends Controller
{
    public function index()
    {
        $inventories = MonthlyInventory::with('items', 'client')->get();
        return response()->json($inventories);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'month' => 'required|string|max:255',
            'drn' => 'nullable|string|max:255',
            'resident_name' => 'nullable|string|max:255',
            'houseparent_name' => 'nullable|string|max:255',
            'items' => 'array',
            'items.*.name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string|max:255',
            'items.*.qty' => 'nullable|integer',
            'items.*.brand' => 'nullable|string|max:255',
            'items.*.size' => 'nullable|string|max:255',
            'items.*.color' => 'nullable|string|max:255',
            'items.*.old' => 'nullable|string|max:255',
            'items.*.new' => 'nullable|string|max:255',
            'items.*.remarks' => 'nullable|string|max:255',
        ]);

        try {
            $inventory = MonthlyInventory::updateOrCreate(
                [
                    'client_id' => $validatedData['client_id'],
                    'month' => $validatedData['month']
                ],
                $validatedData
            );

            foreach ($validatedData['items'] as $itemData) {
                $inventory->items()->updateOrCreate(['name' => $itemData['name']], $itemData);
            }

            Log::info("Successfully saved Monthly Inventory", $inventory->toArray());
            return response()->json($inventory->load('items'), 201);
        } catch (\Exception $e) {
            Log::error("Error storing Monthly Inventory", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $validatedData
            ]);

            return response()->json(['message' => 'Failed to store inventory', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($client_id)
    {
        $client = Client::with('monthlyInventories')->find($client_id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $inventory = MonthlyInventory::where('client_id', $client_id)->with('items')->first();

        return response()->json([
            'inventory' => $inventory,
            'client' => $client,
        ]);
    }

    public function update(Request $request, $client_id)
    {
        $validatedData = $request->validate([
            'month' => 'required|string|max:255',
            'drn' => 'nullable|string|max:255',
            'resident_name' => 'nullable|string|max:255',
            'houseparent_name' => 'nullable|string|max:255',
            'items' => 'array',
            'items.*.name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string|max:255',
            'items.*.qty' => 'nullable|integer',
            'items.*.brand' => 'nullable|string|max:255',
            'items.*.size' => 'nullable|string|max:255',
            'items.*.color' => 'nullable|string|max:255',
            'items.*.old' => 'nullable|string|max:255',
            'items.*.new' => 'nullable|string|max:255',
            'items.*.remarks' => 'nullable|string|max:255',
        ]);

        try {
            $inventory = MonthlyInventory::updateOrCreate(
                [
                    'client_id' => $client_id,
                    'month' => $validatedData['month']
                ],
                $validatedData
            );

            foreach ($validatedData['items'] as $itemData) {
                $inventory->items()->updateOrCreate(['name' => $itemData['name']], $itemData);
            }

            Log::info("Successfully updated Monthly Inventory", $inventory->toArray());
            return response()->json($inventory->load('items'), 200);
        } catch (\Exception $e) {
            Log::error("Error updating Monthly Inventory", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $validatedData
            ]);

            return response()->json(['message' => 'Failed to update inventory', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $inventory = MonthlyInventory::find($id);
        if ($inventory) {
            $inventory->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
