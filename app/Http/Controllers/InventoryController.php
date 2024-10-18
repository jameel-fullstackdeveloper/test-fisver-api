<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $items = Inventory::all();
        return view('inventory.index', compact('items'));
    }

    public function create()
    {
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required',
            'item_code' => 'required|unique:inventories',
            'quantity' => 'required|integer|min:0',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
        ]);

        Inventory::create($request->all());

        return redirect()->route('inventory.index')
                         ->with('success', 'Item added successfully.');
    }

    public function edit(Inventory $inventory)
    {
        return view('inventory.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'item_name' => 'required',
            'item_code' => 'required|unique:inventories,item_code,' . $inventory->id,
            'quantity' => 'required|integer|min:0',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
        ]);

        $inventory->update($request->all());

        return redirect()->route('inventory.index')
                         ->with('success', 'Item updated successfully.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('inventory.index')
                         ->with('success', 'Item deleted successfully.');
    }
}
