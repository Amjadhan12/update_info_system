<?php

namespace App\Http\Controllers;

use App\Models\CashAccount;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Item;
use App\Models\OpenReceivable;
use App\Models\Received;
use App\Models\Sale;
use App\Models\SaleBill;
use App\Models\Setting;
use App\Models\Stock;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = DB::table("sales as s")
            ->join("sale_bills as sb", "s.bill_id", "sb.id")
            ->join("customers as cus", "sb.customer_id", "cus.id")
            ->select(DB::raw("sb.id as bill_id,sb.currency_id,curRate,IFNULL(SUM(price*qty-price*qty*s.discount/100),0) as amount, cus.name as customer_name, sb.date as sale_date,sb.details"))
            ->groupBy('s.bill_id')->orderBy('sb.id', 'desc')
            ->get();

        return view("sale.index", compact("sales"));
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
        return view("sale.create", compact("cashAccounts", "units", "customers", "currencies", "items", "stocks"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bill = new SaleBill();
        $bill->user_id = Auth::id();
        $bill->customer_id = $request->customer_id;
        $bill->currency_id = $request->currency_id;
        $bill->curRate = Currency::find($request->currency_id)->rate;
        $bill->discount = 0;
        $bill->date = $request->date;
        $bill->details = $request->details;
        $bill->save();
        if ($bill) {
            $item_ids = $request->itemId;
            $unit_ids = $request->unitId;
            $unit_sizes = $request->unitSize;
            $discounts = $request->discount;
            $prices = $request->price;
            $qtys = $request->qty;
            // $tot_qty = $request->tot_qty;
            // $tot_amount = $request->tot_amount;
            // $grandAmount = 0;
            // for ($a = 0; $a < count($item_ids); $a++) {
            //     $grandAmount += ($prices[$a] * $qtys[$a]);
            // }

            // $difference = 0;
            // if ($grandAmount > $tot_amount) {
            //     $dif = $grandAmount - $tot_amount;
            //     $difference = $dif / $tot_qty;
            // }
            for ($i = 0; $i < count($item_ids); $i++) {
                $price = $prices[$i] / $unit_sizes[$i];
                $qty = $qtys[$i] * $unit_sizes[$i];
                $sale = new Sale();
                $sale->bill_id = $bill->id;
                $sale->stock_id = $request->stock_id;
                $sale->item_id = $item_ids[$i];
                $sale->unit_id = $unit_ids[$i];
                $sale->unit_size = $unit_sizes[$i];
                $sale->qty = $qty;
                $sale->discount = $discounts[$i];
                $sale->price = $price;
                $sale->pprice = FunctionController::itemCost($item_ids[$i], $request->currency_id);
                $sale->save();
            }
            if ($request->paid) {
                $received = new Received();
                $received->customer_id = $request->customer_id;
                $received->cash_account_id = $request->cash_account_id;
                $received->currency_id = $request->currency_id;
                $received->curRate = Currency::find($request->currency_id)->rate;
                $received->rasid_no = "0";
                $received->amount = $request->paid;
                $received->date = $request->date;
                $received->details = "Cash Received in Bill No: " . $bill->id;
                $received->optional_bill = $bill->id;
                $received->user_id = Auth::id();
                $received->save();
            }
        }


        return redirect("/saleview")
            ->with('msg', 'Sale saved successfully!');
    }

    /**
     * Display the specified resource.
     * 
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $saleBill = SaleBill::find($id);
        $sales = Sale::where("bill_id", $id)->get();
        $stock_id = Sale::where("bill_id", $id)->first()->stock_id;
        $stk = Stock::find($stock_id);
        $customers = Customer::where('id', '!=', $saleBill->customer_id)->get();
        $currencies = Currency::where('id', '!=', $saleBill->currency_id)->get();
        $items = Item::get();
        $stocks = Stock::get();
        $units = Unit::get();

        $cashAccounts = CashAccount::get();
        $paidAmount = 0;
        $received = Received::where("optional_bill", $saleBill->id)->first();
        if ($received) {
            $paidAmount = $received->amount;
            $cashAccounts = CashAccount::where("id", "!=", $received->cash_account_id)->get();
        }


        return view("sale.edit", compact("received", "units", "cashAccounts", "customers", "currencies", "items", "stocks", "saleBill", "sales", "stk", "paidAmount"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bill = SaleBill::find($id);
        $bill->user_id = Auth::id();
        $bill->customer_id = $request->customer_id;
        $bill->currency_id = $request->currency_id;
        $bill->curRate = Currency::find($request->currency_id)->rate;
        $bill->discount = 0;
        $bill->date = $request->date;
        $bill->details = $request->details;
        $bill->save();
        if ($bill) {
            Sale::where("bill_id", $bill->id)->delete();
            $item_ids = $request->itemId;
            $unit_ids = $request->unitId;
            $unit_sizes = $request->unitSize;
            $prices = $request->price; 
            $discounts = $request->discount;
            $qtys = $request->qty;
            // $exp_dates = $request->exp_date;
            for ($i = 0; $i < count($item_ids); $i++) {
                $price = $prices[$i] / $unit_sizes[$i];
                $qty = $qtys[$i] * $unit_sizes[$i];

                $sale = new Sale();
                $sale->bill_id = $bill->id;
                $sale->stock_id = $request->stock_id;
                $sale->item_id = $item_ids[$i];
                $sale->unit_id = $unit_ids[$i];
                $sale->unit_size = $unit_sizes[$i];
                $sale->qty = $qty;
                $sale->discount = $discounts[$i];
                $sale->price = $price;
                $sale->pprice = FunctionController::itemCost($item_ids[$i], $request->currency_id);
                // $sale->exp_date = date("Y-m-d");
                $sale->save();
            }

            Received::where('optional_bill', $id)->delete();
            if ($request->paid > 0) {
                $received = new Received();
                $received->customer_id = $request->customer_id;
                $received->cash_account_id = $request->cash_account_id;
                $received->currency_id = $request->currency_id;
                $received->curRate = Currency::find($request->currency_id)->rate;
                $received->rasid_no = "0";
                $received->amount = $request->paid;
                $received->date = $request->date;
                $received->details = "Cash Received in Bill No: " . $bill->id;
                $received->optional_bill = $bill->id;
                $received->user_id = Auth::id();
                $received->save();
            }
        }


        return redirect("/saleview")
            ->with('msg', 'Sale updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = Sale::where("bill_id", $id)->delete();
        if ($sale) {
            $bill = SaleBill::find($id)->delete();
            if ($bill) {
                $receipt = Received::where('optional_bill', $id)->delete();
            }
        }

        return redirect()->route('sale.index')
            ->with('msg', 'Sale Deleted successfully!');
    }


    /**
     * return sale view page 
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function saleView()
    {
        $saleBill = SaleBill::orderBy('id', 'desc')->first();
        if ($saleBill) {
            $id = $saleBill->id;
            $items = Item::get();
            $customer = Customer::where('id', '!=', $saleBill->customer_id)->get();
            $stocks = Stock::get();
            $maxBill = $id;
            $sales = Sale::where("bill_id", $id)->get();

            $stock_id = Sale::where("bill_id", $id)->first()->stock_id;
            $stock = Stock::find($stock_id);
            $currency = Currency::find($saleBill->currency_id);

            $paidAmount = 0;
            $received = Received::where("optional_bill", $saleBill->id)->first();
            if ($received) {
                $paidAmount = $received->amount;
            }
            return view("sale.view", compact("received", "items", "customer", "stock", "maxBill", "saleBill", "sales", "currency", "paidAmount"));
        } else {
            return redirect()->route('sale.create')
                ->with('msg', 'No Record found in view!');
        }
    }
    public function salePrint(Request $request)
    {
        $id = $request->id;
        $saleBill = SaleBill::find($id);

        $items = Item::get();
        $customer = Customer::where('id', '!=', $saleBill->customer_id)->get();
        $stocks = Stock::get();
        $maxBill = $id;
        $sales = Sale::where("bill_id", $id)->get();

        $stock_id = Sale::where("bill_id", $id)->first()->stock_id;
        $stock = Stock::find($stock_id);
        $currency = Currency::find($saleBill->currency_id);
        $setting = Setting::orderBy("id", "desc")->first();

        $paidAmount = 0;
        $received = Received::where("optional_bill", $saleBill->id)->first();
        if ($received) {
            $paidAmount = $received->amount;
        }

        $openReceivable = OpenReceivable::where(['customer_id' => $saleBill->customer_id, 'currency_id' => $saleBill->currency_id])->sum('amount');
        $totSale = FunctionController::totSale($saleBill->customer_id, $saleBill->currency_id);
        $totReturn = FunctionController::totSaleReturn($saleBill->customer_id, $saleBill->currency_id);
        $totReturnCash = FunctionController::totSaleReturnCash($saleBill->customer_id, $saleBill->currency_id);
        $totReceived = Received::where(['customer_id' => $saleBill->customer_id, 'currency_id' => $saleBill->currency_id])->sum('amount');

        $totBalance = $openReceivable + $totSale + $totReturnCash - $totReturn - $totReceived;

        return view("sale.print", compact("setting", "customer", "stock", "maxBill", "saleBill", "sales", "currency", "paidAmount", "totBalance"));
    }


    public function getSaleBill(Request $request)
    {
        $id = $request->id;
        $saleBill = SaleBill::find($id);
        if ($saleBill) {
            $customer = Customer::find($saleBill->customer_id);
            // $stock = Stock::;
            $maxBill = $id;
            $sales = Sale::where("bill_id", $id)->get();

            $stock_id = Sale::where("bill_id", $id)->first()->stock_id;
            $stock = Stock::find($stock_id);

            $paidAmount = 0;
            $received = Received::where("optional_bill", $saleBill->id)->first();
            if ($received) {
                $paidAmount = $received->amount;
            }

            $tblData = "";
            $i = 1;
            foreach ($sales as $sale) {
                $amount = ($sale->qty * $sale->price) - ($sale->qty * $sale->price * $sale->discount / 100);
                $tblData .= "<tr class='dataTr'>";
                $tblData .= "<td>" . $i . "</td>";
                $tblData .= "<td>" . $sale->item->name . "</td>";
                $tblData .= "<td>" . $sale->unit->name . "</td>";
                $tblData .= "<td>" . $sale->price * $sale->unit_size . "</td>";
                $tblData .= "<td>" . $sale->discount . "</td>";
                $tblData .= "<td>" . $sale->qty / $sale->unit_size . "</td>";
                $tblData .= "<td>" . round($amount,1)  . "</td>";
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
                'paidAmount' => $paidAmount
            ];
        } else {

            $data = [
                'customer_name' => "",
                'stock_name' => "",
                'currency_name' => "",
                'sale_date' => "",
                'sale_details' => "",
                'sale_date' => "",
                'tblData' => "<tr><td class='text-center' colspan='7'>Not Found</td></tr>",
                'paidAmount' => ''
            ];
        }


        return $data;
    }
}
