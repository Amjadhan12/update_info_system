<?php

namespace App\Http\Controllers;

use App\Models\CashAccount;
use App\Models\Currency;
use App\Models\Item;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetails;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\AcceptHeader;

class PurchaseReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $stocks = Stock::get();
        $accounts = CashAccount::get();
        $units = Unit::get();
        return view("purchaseReturn.create", compact("accounts", "units", "suppliers", "currencies", "items", "stocks"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bill = new PurchaseReturn();
        $bill->user_id = Auth::id();
        $bill->cash_account_id     = $request->cash_account_id;
        $bill->supplier_id = $request->supplier_id;
        $bill->currency_id = $request->currency_id;
        $bill->curRate = Currency::find($request->currency_id)->rate;
        $bill->isCash = $request->isCash;
        $bill->date = $request->date;
        $bill->details = $request->details;
        $bill->save();
        if ($bill) {
            $item_ids = $request->itemId;
            $unit_ids = $request->unitId;
            $unit_sizes = $request->unitSize;
            $prices = $request->price;
            $qtys = $request->qty;
            // $exp_dates = $request->exp_date;
            for ($i = 0; $i < count($item_ids); $i++) {
                $price = $prices[$i] / $unit_sizes[$i];
                $qty = $qtys[$i] * $unit_sizes[$i];

                $return = new PurchaseReturnDetails();
                $return->purchase_return_id = $bill->id;
                $return->stock_id = $request->stock_id;
                $return->item_id = $item_ids[$i];
                $return->unit_id = $unit_ids[$i];
                $return->unit_size = $unit_sizes[$i];
                $return->qty = $qty;
                $return->price = $price;
                $return->pprice = $price;
                $return->save();
            }
        }


        return redirect("/purchasereturnview")
            ->with('msg', 'Purchase saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseReturn $purchaseReturn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchaseBill = PurchaseReturn::find($id);
        $purchases = PurchaseReturnDetails::where("purchase_return_id", $id)->get();
        $stock_id = PurchaseReturnDetails::where("purchase_return_id", $id)->first()->stock_id;
        $stk = Stock::find($stock_id);
        $suppliers = Supplier::where('id', '!=', $purchaseBill->supplier_id)->get();
        $currencies = Currency::where('id', '!=', $purchaseBill->currency_id)->get();
        $items = Item::get();
        $stocks = Stock::get();
        $units = Unit::get();
        $accounts = CashAccount::where("id", "!=", $purchaseBill->cash_account_id)->get();
        return view("purchaseReturn.edit", compact("accounts", "units", "suppliers", "currencies", "items", "stocks", "purchaseBill", "purchases", "stk"));
    }

    /** 
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bill = PurchaseReturn::find($id);
        $bill->user_id = Auth::id();
        $bill->cash_account_id = $request->cash_account_id;
        $bill->supplier_id = $request->supplier_id;
        $bill->currency_id = $request->currency_id;
        $bill->curRate = Currency::find($request->currency_id)->rate;
        $bill->isCash = $request->isCash;
        $bill->date = $request->date;
        $bill->details = $request->details;
        $bill->save();
        if ($bill) {
            PurchaseReturnDetails::where("purchase_return_id", $bill->id)->delete();
            $item_ids = $request->itemId;
            $unit_ids = $request->unitId;
            $unit_sizes = $request->unitSize;
            $prices = $request->price;
            $qtys = $request->qty;
            // $exp_dates = $request->exp_date;
            for ($i = 0; $i < count($item_ids); $i++) {
                $price = $prices[$i] / $unit_sizes[$i];
                $qty = $qtys[$i] * $unit_sizes[$i];

                $return = new PurchaseReturnDetails();
                $return->purchase_return_id = $bill->id;
                $return->stock_id = $request->stock_id;
                $return->item_id = $item_ids[$i];
                $return->unit_id = $unit_ids[$i];
                $return->unit_size = $unit_sizes[$i];
                $return->qty = $qty;
                $return->price = $price;
                $return->pprice = $price;
                $return->save();
            }
        }


        return redirect("/purchasereturnview")
            ->with('msg', 'Purchase saved successfully!');
    }

    /** 
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseReturn  $purchaseReturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseReturn $purchaseReturn)
    {
        //
    }


    public function purchaseReturnView()
    {
        $pur = PurchaseReturn::orderBy('id', 'desc')->first();
        if ($pur) {
            $id = $pur->id;
            $purchaseBill = PurchaseReturn::find($id);
            $items = Item::get();
            $supplier = Supplier::where('id', '!=', $purchaseBill->supplier_id)->get();
            $stocks = Stock::get();
            $maxBill = $id;
            $purchases = PurchaseReturnDetails::where("purchase_return_id", $id)->get();

            $stock_id = PurchaseReturnDetails::where("purchase_return_id", $id)->first()->stock_id;
            $stock = Stock::find($stock_id);
            $currency = Currency::find($purchaseBill->currency_id);
            return view("purchaseReturn.view", compact("items", "supplier", "stock", "maxBill", "purchaseBill", "purchases", "currency"));
        } else {
            return redirect()->route('purchase.create')
                ->with('msg', 'No Record found in view!');
        }
    }
    public function purchasePrint(Request $request)
    {
        $id = $request->id;
        $purchaseBill = PurchaseReturn::find($id);

        $items = Item::get();
        $supplier = Supplier::where('id', '!=', $purchaseBill->supplier_id)->get();
        $stocks = Stock::get();
        $maxBill = $id;
        $purchases = PurchaseReturnDetails::where("purchase_return_id", $id)->get();

        $stock_id = PurchaseReturnDetails::where("purchase_return_id", $id)->first()->stock_id;
        $stock = Stock::find($stock_id);
        $currency = Currency::find($purchaseBill->currency_id);
        $setting = Setting::orderBy("id", "desc")->first();
        return view("purchaseReturn.print", compact("setting", "supplier", "stock", "maxBill", "purchaseBill", "purchases", "currency"));
    }


    public function getPurchaseReturn(Request $request)
    {
        $id = $request->id;
        $purchaseBill = PurchaseReturn::find($id);
        if ($purchaseBill) {
            $supplier = Supplier::find($purchaseBill->supplier_id);
            // $stock = Stock::;
            $maxBill = $id;
            $purchases = PurchaseReturnDetails::where("purchase_return_id", $id)->get();

            $stock_id = PurchaseReturnDetails::where("purchase_return_id", $id)->first()->stock_id;
            $stock = Stock::find($stock_id);

            $tblData = "";

            $i = 1;
            foreach ($purchases as $purchase) {
                $tblData .= "<tr class='dataTr'>";
                $tblData .= "<td>" . $i . "</td>";
                $tblData .= "<td>" . $purchase->item->name . "</td>";
                $tblData .= "<td>" . $purchase->unit->name . ' X ' . $purchase->unit_size . "</td>";
                $tblData .= "<td>" . $purchase->price * $purchase->unit_size . "</td>";
                $tblData .= "<td>" . $purchase->qty / $purchase->unit_size . "</td>";
                $tblData .= "<td>" . round($purchase->price * $purchase->qty, 1) . "</td>";
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
