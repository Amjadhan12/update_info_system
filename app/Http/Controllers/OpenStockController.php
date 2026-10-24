<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Item;
use App\Models\OpenStock;
use App\Models\Stock;
use App\Models\Unit;
use Illuminate\Http\Request;

class OpenStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::orderBy('id', 'desc')->get();
        $currencies = Currency::get();
        $stocks = Stock::get();
        $units = Unit::get();
        $openStocks = OpenStock::get();
        return view("openStock.index", compact('items', "currencies", "stocks", "openStocks", "units"));
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
        $data = $request->all();
        $data['curRate'] = Currency::find($request->currency_id)->rate;
        $data['pprice'] = $request->pprice / $request->unit_size;
        $data['sprice'] = $request->sprice / $request->unit_size;
        $data['qty'] = $request->qty * $request->unit_size;
        $open = OpenStock::create($data);
        if ($open) {
            $item = Item::find($request->item_id);
            $item->pprice = $request->pprice / $request->unit_size;
            $item->currency_id = $request->currency_id;
            $item->curRate = Currency::find($request->currency_id)->rate;
            $item->sprice = $request->sprice / $request->unit_size;
            $item->save();
        }
        return redirect()->route('openStock.index')
            ->with('msg', 'Open Stock Saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OpenStock  $openStock
     * @return \Illuminate\Http\Response
     */
    public function show(OpenStock $openStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OpenStock  $openStock
     * @return \Illuminate\Http\Response
     */
    public function edit(OpenStock $openStock)
    {
        $currencies = Currency::where('id', '!=', $openStock->currency_id)->get();
        $stocks = Stock::where('id', '!=', $openStock->stock_id)->get();
        $units = Unit::where('id', '!=', $openStock->unit_id)->get();
        $items = Item::where('id', '!=', $openStock->item_id)->get();
        return view("openStock.edit", compact("items", "currencies", "stocks", "openStock", "units"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OpenStock  $openStock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OpenStock $openStock)
    {
    //    print_r($request->all());die; 
        $data = $request->all();
        $data['curRate'] = Currency::find($request->currency_id)->rate;
        $data['pprice'] = $request->pprice / $request->unit_size;
        $data['sprice'] = $request->sprice / $request->unit_size;
        $data['qty'] = $request->qty * $request->unit_size;
        $openStock->update($data);
        if ($openStock) {
            $item = Item::find($request->item_id);
            $item->pprice = $request->pprice / $request->unit_size;
            $item->currency_id = $request->currency_id;
            $item->curRate = Currency::find($request->currency_id)->rate;
            $item->sprice = $request->sprice / $request->unit_size;
            $item->save();
        }
        return redirect()->route('openStock.index')
            ->with('msg', 'Open Stock updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OpenStock  $openStock
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // echo $id;die;/
        OpenStock::find($id)->delete();
        return redirect()->route('openStock.index')
            ->with('msg', 'Open Stock deleted successfully!');
    }
}
