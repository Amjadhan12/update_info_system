<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Item;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\PurchaseBill;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = DB::table("purchases as p")
            ->join("purchase_bills as pb", "p.bill_id", "pb.id")
            ->join("suppliers as sup", "pb.supplier_id", "sup.id")
            ->select(DB::raw("pb.id as bill_id,pb.currency_id,SUM(pprice*qty) as amount, sup.name as supplier_name, pb.date as purchase_date,pb.details"))
            ->groupBy('p.bill_id')->orderBy('pb.id', 'desc')
            ->get();
            return view("purchase.index", compact("purchases"));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::get();
        $currencies = Currency::get();
        $items = Item::get();
        $units = Unit::get();
        $stocks = Stock::get();
        return view("purchase.create", compact("suppliers", "currencies", "items", "stocks", "units"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bill = new PurchaseBill();
        $bill->user_id = Auth::id();
        $bill->supplier_id = $request->supplier_id;
        $bill->currency_id = $request->currency_id;
        $bill->curRate = Currency::find($request->currency_id)->rate;
        $bill->date = $request->date;
        $bill->details = $request->details;
        $bill->save();
        if ($bill) {
            $item_ids = $request->itemId;
            $unit_ids = $request->unitId;
            $unit_sizes = $request->unitSize;
            $pprices = $request->pprice;
            $sprices = $request->sprice;
            $qtys = $request->qty;
            // $exp_dates = $request->exp_date;
            for ($i = 0; $i < count($item_ids); $i++) {
                $pprice = ($pprices[$i] / $unit_sizes[$i]);
                $sprice = ($sprices[$i] / $unit_sizes[$i]);
                $qty = ($qtys[$i] * $unit_sizes[$i]);
                $item = Item::find($item_ids[$i]);
                $oldQty = FunctionController::itemQty($item->id);
                $newCost = 0;
                if ($oldQty <= 0) {
                    $newCost = $pprice;
                } else {
                    $oldAmount = $oldQty * $item->pprice / $item->curRate;
                    $newAmount = $pprice * $qty / Currency::find($request->currency_id)->rate;
                    $newCost = ($oldAmount + $newAmount) / ($oldQty + $qty);
                }

                $item->pprice = $newCost * Currency::find($request->currency_id)->rate;
                $item->currency_id = $request->currency_id;
                $item->curRate = Currency::find($request->currency_id)->rate;
                $item->sprice = $sprice;
                $item->save();

                $purchase = new purchase();
                $purchase->bill_id = $bill->id;
                $purchase->stock_id = $request->stock_id;
                $purchase->item_id = $item_ids[$i];
                $purchase->unit_id = $unit_ids[$i];
                $purchase->unit_size = $unit_sizes[$i];
                $purchase->qty = $qty;
                $purchase->pprice = $pprice;
                $purchase->sprice = $sprice;
                // $purchase->exp_date = $exp_dates[$i];
                $purchase->save();
            }
        }


        return redirect("/purchaseview")
            ->with('msg', 'Purchase saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchaseBill = PurchaseBill::find($id);
        $purchases = Purchase::where("bill_id", $id)->get();
        $stock_id = Purchase::where("bill_id", $id)->first()->stock_id;
        $stk = Stock::find($stock_id);
        $suppliers = Supplier::where('id', '!=', $purchaseBill->supplier_id)->get();
        $currencies = Currency::where('id', '!=', $purchaseBill->currency_id)->get();
        $items = Item::get();
        $units = Unit::get();
        $stocks = Stock::get();
        return view("purchase.edit", compact("suppliers", "currencies", "items", "stocks", "purchaseBill", "purchases", "stk", "units"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bill = PurchaseBill::find($id);
        $bill->user_id = Auth::id();
        $bill->supplier_id = $request->supplier_id;
        $bill->currency_id = $request->currency_id;
        $bill->curRate = Currency::find($request->currency_id)->rate;
        $bill->date = $request->date;
        $bill->details = $request->details;
        $bill->save();
        if ($bill) {
            Purchase::where("bill_id", $bill->id)->delete();
            $item_ids = $request->itemId;
            $unit_ids = $request->unitId;
            $unit_sizes = $request->unitSize;
            $pprices = $request->pprice;
            $sprices = $request->sprice;
            $qtys = $request->qty;
            // $exp_dates = $request->exp_date;
            for ($i = 0; $i < count($item_ids); $i++) {
                $pprice = $pprices[$i] / $unit_sizes[$i];
                $sprice = $sprices[$i] / $unit_sizes[$i];
                $qty = $qtys[$i] * $unit_sizes[$i];

                $item = Item::find($item_ids[$i]);
                $oldQty = FunctionController::itemQty($item->id);
                $oldAmount = $oldQty * $item->pprice / $item->curRate;
                $newAmount = $pprice * $qty / Currency::find($request->currency_id)->rate;
                $newCost = ($oldAmount + $newAmount) / ($oldQty + $qty);
              
                $item->pprice = $newCost * Currency::find($request->currency_id)->rate;
                $item->currency_id = $request->currency_id;
                $item->curRate = Currency::find($request->currency_id)->rate;
                $item->sprice = $sprice;
                $item->save();

                $purchase = new purchase();
                $purchase->bill_id = $bill->id;
                $purchase->stock_id = $request->stock_id;
                $purchase->item_id = $item_ids[$i];
                $purchase->unit_id = $unit_ids[$i];
                $purchase->unit_size = $unit_sizes[$i];
                $purchase->qty = $qty;
                $purchase->pprice = $pprice;
                $purchase->sprice = $sprice;
                // $purchase->exp_date = $exp_dates[$i];
                $purchase->save();
            }
        }


        return redirect("/purchaseview")
            ->with('msg', 'Purchase updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }


    /**
     * return purchase view page 
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function purchaseView()
    {
        $pur = PurchaseBill::orderBy('id', 'desc')->first();
        if ($pur) {
            $id = $pur->id;
            $purchaseBill = PurchaseBill::find($id);
            $items = Item::get();
            $supplier = Supplier::where('id', '!=', $purchaseBill->supplier_id)->get();
            $stocks = Stock::get();
            $maxBill = $id;
            $purchases = Purchase::where("bill_id", $id)->get();

            $stock_id = Purchase::where("bill_id", $id)->first()->stock_id;
            $stock = Stock::find($stock_id);
            $currency = Currency::find($purchaseBill->currency_id);
            return view("purchase.view", compact("items", "supplier", "stock", "maxBill", "purchaseBill", "purchases", "currency"));
        } else {
            return redirect()->route('purchase.create')
                ->with('msg', 'No Record found in view!');
        }
    }
    public function purchasePrint(Request $request)
    {
        $id = $request->id;
        $purchaseBill = PurchaseBill::find($id);

        $items = Item::get();
        $supplier = Supplier::where('id', '!=', $purchaseBill->supplier_id)->get();
        $stocks = Stock::get();
        $maxBill = $id;
        $purchases = Purchase::where("bill_id", $id)->get();

        $stock_id = Purchase::where("bill_id", $id)->first()->stock_id;
        $stock = Stock::find($stock_id);
        $currency = Currency::find($purchaseBill->currency_id);
        $setting = Setting::orderBy("id", "desc")->first();
        return view("purchase.print", compact("setting", "supplier", "stock", "maxBill", "purchaseBill", "purchases", "currency"));
    }


    public function getPurchaseBill(Request $request)
    {
        $id = $request->id;
        $purchaseBill = PurchaseBill::find($id);
        if ($purchaseBill) {
            $supplier = Supplier::find($purchaseBill->supplier_id);
            // $stock = Stock::;
            $maxBill = $id;
            $purchases = Purchase::where("bill_id", $id)->get();

            $stock_id = Purchase::where("bill_id", $id)->first()->stock_id;
            $stock = Stock::find($stock_id);

            $tblData = "";




            $i = 1;
            foreach ($purchases as $purchase) {
                $tblData .= "<tr class='dataTr'>";
                $tblData .= "<td>" . $i . "</td>";
                $tblData .= "<td>" . $purchase->item->name . "</td>";
                $tblData .= "<td>" . $purchase->exp_date . "</td>";
                $tblData .= "<td>" . $purchase->pprice . "</td>";
                $tblData .= "<td>" . $purchase->sprice . "</td>";
                $tblData .= "<td>" . $purchase->qty . "</td>";
                $tblData .= "<td>" . $purchase->pprice * $purchase->qty . "</td>";
                $tblData .= "</tr>";
                $i++;
            }

            $data = [
                'supplier_name' => $purchaseBill->supplier->name,
                'stock_name' => $stock->name,
                'currency_name' => $purchaseBill->currency->name,
                'purchase_date' => $purchaseBill->date,
                'purchase_details' => $purchaseBill->details,
                'purchase_date' => $purchaseBill->date,
                'tblData' => $tblData
            ];
        } else {

            $data = [
                'supplier_name' => "",
                'stock_name' => "",
                'currency_name' => "",
                'purchase_date' => "",
                'purchase_details' => "",
                'purchase_date' => "",
                'tblData' => "<tr><td class='text-center' colspan='7'>Not Found</td></tr>"
            ];
        }


        return $data;
    }
}
