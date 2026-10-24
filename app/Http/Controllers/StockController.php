<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::get();
        return view("stock.index", compact("stocks"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:stocks'
        ]);
        $data = $request->all();
        Stock::create($data);
        return redirect()->route("stock.index")
            ->with('msg', 'stock saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response 
     */
    public function edit(Stock $stock)
    {
        return view("stock.edit", compact("stock"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:stocks,name,' . $stock->id,
        ]);
        $data = $request->all();
        $stock->update($data);
        return redirect()->route('stock.index')
            ->with('msg', 'stock upadated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }


    public function getStock(Request $request)
    {
        $stock = Stock::where("name", $request->name)->first();
        return ['id' => $stock->id, 'name' => $stock->name];
    }


    public function currentStock()
    {
        $items = Item::get();
        $stocks = Stock::get();
        return view("stock.currentStock", compact("items", "stocks"));
    }
    public function inStock($id)
    {
        $items = Item::get();
        $stocks = Stock::get();
        $stock = Stock::find($id);
        return view("stock.inStock", compact("items", "stocks", "stock"));
    }
    public function minusStock()
    {
        $items = Item::get();
        $stocks = Stock::get();
        return view("stock.minusStock", compact("items", "stocks"));
    }
}
