<?php

namespace App\Http\Controllers;

use App\Models\CashAccount;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Item;
use App\Models\SaleReturn;
use App\Models\SaleReturnDetails;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleReturnController extends Controller
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
        $customers = Customer::get();
        $currencies = Currency::get();
        $items = Item::get();
        $stocks = Stock::get();
        $cashAccounts = CashAccount::get();
        $units = Unit::get();
        return view("saleReturn.create", compact("cashAccounts","units", "customers", "currencies", "items", "stocks"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bill = new SaleReturn();
        $bill->user_id = Auth::id();
        $bill->cash_account_id = $request->cash_account_id;
        $bill->customer_id = $request->customer_id;
        $bill->currency_id = $request->currency_id;
        $bill->curRate = Currency::find($request->currency_id)->rate;
        $bill->date = $request->date;
        $bill->isCash = $request->isCash;
        $bill->details = $request->details;
        $bill->save();
        if ($bill) {
            $item_ids = $request->itemId;
            $unit_ids = $request->unitId;
            $unit_sizes = $request->unitSize;
            $prices = $request->price;
            $qtys = $request->qty;
            for ($i = 0; $i < count($item_ids); $i++) {
                $price = $prices[$i] / $unit_sizes[$i];
                $qty = $qtys[$i] * $unit_sizes[$i];
                $sale = new SaleReturnDetails();
                $sale->sale_return_id = $bill->id;
                $sale->stock_id = $request->stock_id;
                $sale->item_id = $item_ids[$i];
                $sale->unit_id = $unit_ids[$i];
                $sale->unit_size = $unit_sizes[$i];
                $sale->qty = $qty;
                $sale->price = $price;
                $sale->pprice = FunctionController::itemCost($item_ids[$i], $request->currency_id);
                $sale->save();
            }
        }


        return redirect("/salereturnview")
            ->with('msg', 'Sale Return saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SaleReturn  $saleReturn
     * @return \Illuminate\Http\Response
     */
    public function show(SaleReturn $saleReturn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaleReturn  $saleReturn
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $saleBill = SaleReturn::find($id);
        $sales = SaleReturnDetails::where("sale_return_id", $id)->get();
        $stock_id = SaleReturnDetails::where("sale_return_id", $id)->first()->stock_id;
        $stk = Stock::find($stock_id);
        $customers = Customer::where('id', '!=', $saleBill->customer_id)->get();
        $currencies = Currency::where('id', '!=', $saleBill->currency_id)->get();
        $items = Item::get();
        $stocks = Stock::get();
        $units = Unit::get();
        $cashAccounts = CashAccount::where('id', '!=', $saleBill->cash_account_id)->get();



        return view("saleReturn.edit", compact("cashAccounts","units", "customers", "currencies", "items", "stocks", "saleBill", "sales", "stk"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SaleReturn  $saleReturn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bill = SaleReturn::find($id);
        $bill->user_id = Auth::id();
        $bill->cash_account_id = $request->cash_account_id;
        $bill->customer_id = $request->customer_id;
        $bill->currency_id = $request->currency_id;
        $bill->curRate = Currency::find($request->currency_id)->rate;
        $bill->date = $request->date;
        $bill->isCash = $request->isCash;
        $bill->details = $request->details;
        $bill->save();
        if ($bill) {
            SaleReturnDetails::where("sale_return_id", $bill->id)->delete();
            $item_ids = $request->itemId;
            $unit_ids = $request->unitId;
            $unit_sizes = $request->unitSize;
            $prices = $request->price;
            $qtys = $request->qty;
            for ($i = 0; $i < count($item_ids); $i++) {
                $price = $prices[$i] / $unit_sizes[$i];
                $qty = $qtys[$i] * $unit_sizes[$i];
                $sale = new SaleReturnDetails();
                $sale->sale_return_id = $bill->id;
                $sale->stock_id = $request->stock_id;
                $sale->item_id = $item_ids[$i];
                $sale->unit_id = $unit_ids[$i];
                $sale->unit_size = $unit_sizes[$i];
                $sale->qty = $qty;
                $sale->price = $price;
                $sale->pprice = FunctionController::itemCost($item_ids[$i], $request->currency_id);
                $sale->save();
            }
        }


        return redirect("/salereturnview")
            ->with('msg', 'Sale return updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SaleReturn  $saleReturn
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleReturn $saleReturn)
    {
        //
    }




    public function returnView()
{
    $saleBill = SaleReturn::orderBy('id', 'desc')->first();

    if (!$saleBill) {
        return redirect()->route('saleReturn.create')
            ->with('msg', 'No Record found in view!');
    }

    $id = $saleBill->id;

    $items = Item::get();
    $customer = Customer::where('id', '!=', $saleBill->customer_id)->get();
    $stocks = Stock::get();
    $maxBill = $id;
    $sales = SaleReturnDetails::where("sale_return_id", $id)->get();

    // Default to null in case there's no SaleReturnDetails
    $stock = null;
    $firstSaleDetail = SaleReturnDetails::where("sale_return_id", $id)->first();

    if ($firstSaleDetail && $firstSaleDetail->stock_id) {
        $stock = Stock::find($firstSaleDetail->stock_id);
    }

    $currency = Currency::find($saleBill->currency_id);

    return view("saleReturn.view", compact(
        "items", "customer", "stock", "maxBill", "saleBill", "sales", "currency"
    ));
}

    public function saleReturnPrint(Request $request)
    {
        $id = $request->id;
        $saleBill = SaleReturn::find($id);

        $items = Item::get();
        $customer = Customer::where('id', '!=', $saleBill->customer_id)->get();
        $stocks = Stock::get();
        $maxBill = $id;
        $sales = SaleReturnDetails::where("sale_return_id", $id)->get();

        $stock_id = SaleReturnDetails::where("sale_return_id", $id)->first()->stock_id;
        $stock = Stock::find($stock_id);
        $currency = Currency::find($saleBill->currency_id);
        $setting = Setting::orderBy("id", "desc")->first();



        return view("saleReturn.print", compact("setting", "customer", "stock", "maxBill", "saleBill", "sales", "currency"));
    }


    public function getSaleReturn(Request $request)
    {
        $id = $request->id;
        $saleBill = SaleReturn::find($id);
        if ($saleBill) {
            $customer = Customer::find($saleBill->customer_id);
            // $stock = Stock::;
            $maxBill = $id;
            $sales = SaleReturnDetails::where("sale_return_id", $id)->get();

            $stock_id = SaleReturnDetails::where("sale_return_id", $id)->first()->stock_id;
            $stock = Stock::find($stock_id);

            $isCash="Receivable";
            if($saleBill->isCash==1){
                $isCash="Cash";
            }

            $tblData = "";
            $i = 1;
            foreach ($sales as $sale) {
                $amount = ($sale->qty * $sale->price);
                $tblData .= "<tr class='dataTr'>";
                $tblData .= "<td>" . $i . "</td>";
                $tblData .= "<td>" . $sale->item->name . "</td>";
                $tblData .= "<td>" . $sale->unit->name . "</td>";
                $tblData .= "<td>" . $sale->price*$sale->unit_size . "</td>";
                $tblData .= "<td>" . $sale->qty/$sale->unit_size . "</td>";
                $tblData .= "<td>" . $amount  . "</td>";
                $tblData .= "</tr>";
                $i++;
            }

            $data = [
                'customer_name' => $saleBill->customer->name,
                'stock_name' => $stock->name,
                'currency_name' => $saleBill->currency->name,
                'sale_date' => $saleBill->date,
                'sale_details' => $saleBill->details,
                'sale_date' => $saleBill->date,
                'tblData' => $tblData,
                'accountName' => $saleBill->cashAccount->name,
                'isCash' => $isCash,
            ];
        } else {
            $data = [
                'customer_name' => "",
                'stock_name' => "",
                'currency_name' => "",
                'sale_date' => "",
                'sale_details' => "",
                'sale_date' => "",
                'tblData' => "<tr><td class='text-center' colspan='6'>Not Found</td></tr>",
                'paidAmount' => '',
                'accountName' => '',
                'isCash' => '',
                
            ];
        }


        return $data;
    }
}
