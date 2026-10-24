<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Item;
use App\Models\OpenStock;
use App\Models\Purchase;
use App\Models\PurchaseReturnDetails;
use App\Models\Sale;
use App\Models\SaleReturnDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::orderBy('id', 'desc')->get();
        return view("item.index", compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = Item::orderBy('id', 'desc')->limit(10)->get();
        $currencies = Currency::get();
        return view("item.create", compact('items', "currencies"));
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
            // 'barcode' => 'required|max:255|unique:items',
            'name' => 'required|max:255|unique:items',
        ]);
        $data = $request->all();
        $data['curRate'] = Currency::find($request->currency_id)->rate;
        Item::create($data);
        return redirect()->route('item.create')
            ->with('msg', 'Item Saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $currencies = Currency::where('id', '!=', $item->currency_id)->get();
        return view("item.edit", compact("item", "currencies"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $validatedData = $request->validate([
            // 'barcode' => 'required|unique:items,barcode,' . $item->barcode,
            'name' => 'required|unique:items,name,' . $item->id,
        ]);
        $data = $request->all();
        $data['curRate'] = Currency::find($request->currency_id)->rate;
        $item->update($data);
        return redirect()->route('item.create')
            ->with('msg', 'Item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Item::find($id)->delete();
        return redirect()->route('item.create')
            ->with('msg', 'Item deleted successfully!');
    }

    public function getItem(Request $request)
    {
        $item = Item::where("name", $request->name)->first();
        if ($request->item_code) {
            $item = Item::where("barcode", $request->item_code)->first();
        }
        if ($request->item_id) {
            $item = Item::find($request->item_id);
        }

        $cost = $item->pprice;
        $price = $item->sprice;
        if ($request->currency_id) {
            $currency = Currency::find($request->currency_id);
            $price = $item->sprice / $item->curRate * $currency->rate;
            $cost = $item->pprice / $item->curRate * $currency->rate;
        }
        $qty = FunctionController::itemQty($item->id);
        return ['id' => $item->id, 'name' => $item->name, 'pprice' => round($cost, 2), 'sprice' => round($price, 2), 'qty' => $qty];
    }
    public function getItemByName(Request $request)
    {
        $itm_name = $request->itm_name;

        $item = Item::where("name", $itm_name)->first();
        return $item;
        // $itm_name = $request->itm_name; 

        // $item = Item::where("name", $itm_name)->first();
    
        // if ($item) {
        //     $qty = FunctionController::itemQty($item->id);  
        //     return response()->json([
        //         'id' => $item->id,  // Return the item ID
        //         'name' => $item->name,  // Return the item name
        //         'qty' => $qty  // Return the quantity
        //     ]);
        // } else {
        //     return response()->json(null);
        // }
    }


    public function getItemsByQty(Request $request)
    {
        $data_low = $request->data_low;
        $data_high = $request->data_high;
        $items = Item::get();
        $response = "";
        if ($data_low == 0 && $data_high == 0) {
            $i = 1;
            foreach ($items as $item) {
                $currentQty = FunctionController::itemQty($item->id);
                if ($currentQty == 0 && $data_low == 0 && $data_high == 0) {
                    $response .= "<tr><td>" . $i . "</td><td>" . $item->name . "</td><td>" . $item->pprice . "</td><td>" . $currentQty . "</td><td>" . $item->pprice * $currentQty . "</td></tr>";
                    $i++;
                }
            }
        } else if ($data_low == 0 && $data_high == 10) {
            $i = 1;
            foreach ($items as $item) {
                $currentQty = FunctionController::itemQty($item->id);
                if ($currentQty <= 10 && $currentQty > 0) {
                    $response .= "<tr><td>" . $i . "</td><td>" . $item->name . "</td><td>" . $item->pprice . "</td><td>" . $currentQty . "</td><td>" . $item->pprice * $currentQty . "</td></tr>";
                    $i++;
                }
            }
        } else if ($data_low == 10 && $data_high == 100) {
            $i = 1;
            foreach ($items as $item) {
                $currentQty = FunctionController::itemQty($item->id);
                if ($currentQty <= $data_high && $currentQty > $data_low) {
                    $response .= "<tr><td>" . $i . "</td><td>" . $item->name . "</td><td>" . $item->pprice . "</td><td>" . $currentQty . "</td><td>" . $item->pprice * $currentQty . "</td></tr>";
                    $i++;
                }
            }
        } else if ($data_low == 100) {
            $i = 1;
            foreach ($items as $item) {
                $currentQty = FunctionController::itemQty($item->id);
               if ($currentQty > $data_low) {
                    $response .= "<tr><td>" . $i . "</td><td>" . $item->name . "</td><td>" . $item->pprice . "</td><td>" . $currentQty . "</td><td>" . $item->pprice * $currentQty . "</td></tr>";
                    $i++;
                }
            }
        }
        return $response;
    }
}
