<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Stock;
use App\Models\StockTransfer;
use App\Models\Unit;
use Illuminate\Http\Request;

class StockTransferController extends Controller
{
    public function index()
    {
        $stocks = Stock::all();
        $items = Item::all();
        $units = Unit::all(); // Include units for form rendering
        $stockTransfers = StockTransfer::with('fromStock', 'toStock', 'item', 'unit')->get();

        return view("stockTransfer.index", compact("stocks", "items", "units", "stockTransfers"));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'from_stock_id' => 'required|exists:stocks,id',
            'to_stock_id' => 'required|exists:stocks,id',
            'item_id' => 'required|exists:items,id',
            'qty' => 'required|integer|min:1',
            'date' => 'required|date',
            'details' => 'nullable|string',
            'user_id' => 'required|integer',
            'unit_id' => 'required|exists:units,id'
        ]);

        StockTransfer::create($data);

        return redirect()->route('stockTransfer.index')->with('msg', 'Stock Transfer Saved successfully!');
    }

    public function edit(StockTransfer $stockTransfer)
    {
        $items = Item::where('id', '!=', $stockTransfer->item_id)->orderBy('id', 'desc')->get();
        $stocks = Stock::all();
        $units = Unit::all(); // Add units for the edit form

        return view("stockTransfer.edit", compact('items', 'stocks', 'units', 'stockTransfer'));
    }

    public function update(Request $request, StockTransfer $stockTransfer)
    {
        $data = $request->validate([
            'from_stock_id' => 'required|exists:stocks,id',
            'to_stock_id' => 'required|exists:stocks,id',
            'item_id' => 'required|exists:items,id',
            'qty' => 'required|integer|min:1',
            'date' => 'required|date',
            'details' => 'nullable|string',
            'user_id' => 'required|integer',
            'unit_id' => 'required|exists:units,id'
        ]);

        $stockTransfer->update($data);

        return redirect()->route('stockTransfer.index')->with('msg', 'Stock Transfer updated successfully!');
    }

    public function destroy(StockTransfer $stockTransfer)
    {
        $stockTransfer->delete();

        return redirect()->route('stockTransfer.index')->with('msg', 'Stock Transfer deleted successfully!');
    }
}
