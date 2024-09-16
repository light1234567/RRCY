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
        'id' => 'nullable|exists:monthly_inventories,id',
        'client_id' => 'required|exists:clients,id',
        'month' => 'nullable|string|max:50',
        'drn' => 'nullable|string|max:50',
        'resident_name' => 'nullable|string|max:100',
        'houseparent_name' => 'nullable|string|max:100',
        'items' => 'required|array',
        'items.*.name' => 'required|string|max:100',
        'items.*.description' => 'nullable|string|max:100',
        'items.*.qty' => 'nullable|integer',
        'items.*.brand' => 'nullable|string|max:50',
        'items.*.size' => 'nullable|string|max:50',
        'items.*.color' => 'nullable|string|max:50',
        'items.*.old' => 'nullable|string|max:50',
        'items.*.new' => 'nullable|string|max:50',
        'items.*.remarks' => 'nullable|string|max:100',
    ]);    

    try {
        // Check if `id` is provided to determine if it is an update
        $inventory = $validatedData['id'] 
            ? MonthlyInventory::findOrFail($validatedData['id']) 
            : new MonthlyInventory();

        $inventory->fill([
            'client_id' => $validatedData['client_id'],
            'month' => $validatedData['month'],
            'drn' => $validatedData['drn'],
            'resident_name' => $validatedData['resident_name'],
            'houseparent_name' => $validatedData['houseparent_name'],
        ]);

        $inventory->save();

        // Sync items with the inventory
        $items = collect($validatedData['items'])->map(function($itemData) use ($inventory) {
            return new InventoryItem(array_merge($itemData, ['inventory_id' => $inventory->id]));
        });

        // Delete old items and save new ones
        $inventory->items()->delete();
        $inventory->items()->saveMany($items);

        Log::info("Successfully saved Monthly Inventory", $inventory->toArray());
        return response()->json($inventory->load('items'), $inventory->wasRecentlyCreated ? 201 : 200);
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
            'month' => 'nullable|string|max:255',
            'drn' => 'nullable|string|max:255',
            'drn' => 'nullable|string|max:50',
            'resident_name' => 'nullable|string|max:100',
            'houseparent_name' => 'nullable|string|max:100',
            'items' => 'required|array',
            'items.*.name' => 'required|string|max:100',
            'items.*.description' => 'nullable|string|max:100',
            'items.*.qty' => 'nullable|integer',
            'items.*.brand' => 'nullable|string|max:50',
            'items.*.size' => 'nullable|string|max:50',
            'items.*.color' => 'nullable|string|max:50',
            'items.*.old' => 'nullable|string|max:50',
            'items.*.new' => 'nullable|string|max:50',
            'items.*.remarks' => 'nullable|string|max:100',
        ]);

        try {
            $inventory = MonthlyInventory::updateOrCreate(
                [
                    'client_id' => $client_id,
                    'month' => $validatedData['month']
                ],
                $validatedData
            );

            // Handle item updates or creation
            foreach ($validatedData['items'] as $itemData) {
                $itemData['inventory_id'] = $inventory->id;
                InventoryItem::updateOrCreate(
                    ['id' => $itemData['id'] ?? null], // Only update if ID exists
                    $itemData
                );
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
            $inventory->items()->delete(); // Delete related items first
            $inventory->delete();
            return response()->json(['message' => 'Deleted successfully']);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
