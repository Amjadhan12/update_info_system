<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Customer;
use App\Models\EstimateSale;
use App\Models\EstimateSaleBill;
use App\Models\Item;
use App\Models\Setting;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstimateSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        return view("estimateSale.create", compact("customers", "currencies", "items", "stocks"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bill = new EstimateSaleBill();
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
            $discounts = $request->discount;
            $prices = $request->price;
            $qtys = $request->qty;
            // $exp_dates = $request->exp_date;
            for ($i = 0; $i < count($item_ids); $i++) {
                $sale = new EstimateSale();
                $sale->bill_id = $bill->id;
                $sale->stock_id = $request->stock_id;
                $sale->item_id = $item_ids[$i];
                $sale->qty = $qtys[$i];
                $sale->discount = $discounts[$i];
                $sale->price = $prices[$i];
                $sale->pprice = FunctionController::itemCost($item_ids[$i], $request->currency_id);
                // $sale->exp_date = date("Y-m-d");
                $sale->save();
            }
        }


        return redirect("/estimatesaleview")
            ->with('msg', 'Sale saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EstimateSale  $estimateSale
     * @return \Illuminate\Http\Response
     */
    public function show(EstimateSale $estimateSale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EstimateSale  $estimateSale
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $saleBill = EstimateSaleBill::find($id);
        $sales = EstimateSale::where("bill_id", $id)->get();
        $stock_id = EstimateSale::where("bill_id", $id)->first()->stock_id;
        $stk = Stock::find($stock_id);
        $customers = Customer::where('id', '!=', $saleBill->customer_id)->get();
        $currencies = Currency::where('id', '!=', $saleBill->currency_id)->get();
        $items = Item::get();
        $stocks = Stock::get();
        return view("estimateSale.edit", compact("customers", "currencies", "items", "stocks", "saleBill", "sales", "stk"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EstimateSale  $estimateSale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bill = EstimateSaleBill::find($id);
        $bill->user_id = Auth::id();
        $bill->customer_id = $request->customer_id;
        $bill->currency_id = $request->currency_id;
        $bill->curRate = Currency::find($request->currency_id)->rate;
        $bill->discount = 0;
        $bill->date = $request->date;
        $bill->details = $request->details;
        $bill->save();
        if ($bill) {
            EstimateSale::where("bill_id", $bill->id)->delete();
            $item_ids = $request->itemId;
            $prices = $request->price;
            $discounts = $request->discount;
            $qtys = $request->qty;
            // $exp_dates = $request->exp_date;
            for ($i = 0; $i < count($item_ids); $i++) {

                $sale = new EstimateSale();
                $sale->bill_id = $bill->id;
                $sale->stock_id = $request->stock_id;
                $sale->item_id = $item_ids[$i];
                $sale->qty = $qtys[$i];
                $sale->discount = $discounts[$i];
                $sale->price = $prices[$i];
                // $sale->exp_date = date("Y-m-d");
                $sale->save();
            }
        }


        return redirect("/estimatesaleview")
            ->with('msg', 'Sale updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EstimateSale  $estimateSale
     * @return \Illuminate\Http\Response
     */
    public function destroy(EstimateSale $estimateSale)
    {
        //
    }



    public function saleView()
    {
        $saleBill = EstimateSaleBill::orderBy('id', 'desc')->first();
        if ($saleBill) {
            $id = $saleBill->id;
            $items = Item::get();
            $customer = Customer::where('id', '!=', $saleBill->customer_id)->get();
            $stocks = Stock::get();
            $maxBill = $id;
            $sales = EstimateSale::where("bill_id", $id)->get();

            $stock_id = EstimateSale::where("bill_id", $id)->first()->stock_id;
            $stock = Stock::find($stock_id);
            $currency = Currency::find($saleBill->currency_id);
            return view("estimateSale.view", compact("items", "customer", "stock", "maxBill", "saleBill", "sales", "currency"));
        } else {
            return redirect()->route('estimateSale.create')
                ->with('msg', 'No Record found in view!');
        }
    }
    public function salePrint(Request $request)
    {
        $id = $request->id;
        $saleBill = EstimateSaleBill::find($id);

        $items = Item::get();
        $customer = Customer::where('id', '!=', $saleBill->customer_id)->get();
        $stocks = Stock::get();
        $maxBill = $id;
        $sales = EstimateSale::where("bill_id", $id)->get();

        $stock_id = EstimateSale::where("bill_id", $id)->first()->stock_id;
        $stock = Stock::find($stock_id);
        $currency = Currency::find($saleBill->currency_id);
        $setting = Setting::orderBy("id", "desc")->first();
        return view("estimateSale.print", compact("setting", "customer", "stock", "maxBill", "saleBill", "sales", "currency"));
    }


    public function getSaleBill(Request $request)
    {
        $id = $request->id;
        $saleBill = EstimateSaleBill::find($id);
        if ($saleBill) {
            $customer = Customer::find($saleBill->customer_id);
            // $stock = Stock::;
            $maxBill = $id;
            $sales = EstimateSale::where("bill_id", $id)->get();

            $stock_id = EstimateSale::where("bill_id", $id)->first()->stock_id;
            $stock = Stock::find($stock_id);

            $tblData = "";
            $i = 1;
            foreach ($sales as $sale) {
                $amount = ($sale->qty * $sale->price) - ($sale->qty * $sale->price * $sale->discount / 100);
                $tblData .= "<tr class='dataTr'>";
                $tblData .= "<td>" . $i . "</td>";
                $tblData .= "<td>" . $sale->item->name . "</td>";
                $tblData .= "<td>" . $sale->price . "</td>";
                $tblData .= "<td>" . $sale->discount . "</td>";
                $tblData .= "<td>" . $sale->qty . "</td>";
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
                'tblData' => $tblData
            ];
        } else {

            $data = [
                'customer_name' => "",
                'stock_name' => "",
                'currency_name' => "",
                'sale_date' => "",
                'sale_details' => "",
                'sale_date' => "",
                'tblData' => "<tr><td class='text-center' colspan='7'>Not Found</td></tr>"
            ];
        }


        return $data;
    }
}
