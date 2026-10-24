<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Customer;
use App\Models\OpenReceivable;
use App\Models\Received;
use App\Models\SaleReturn;
use Illuminate\Http\Request;
use DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::get();
        return view("customer.index", compact("customers"));
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
            'name' => 'required|max:255|unique:customers'
        ]);
        $data = $request->all();
        customer::create($data);
        return redirect()->route($request->redirect_to)
            ->with('msg', 'customer saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view("customer.edit", compact("customer"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:customers,name,' . $customer->id,
        ]);
        $data = $request->all();
        $customer->update($data);
        return redirect()->route('customer.index')
            ->with('msg', 'customer upadated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function getCustomer(Request $request)
    {
        $customer = Customer::where("name", $request->name)->first();
        return ['id' => $customer->id, 'name' => $customer->name];
    }



    public function account()
    {
        $customers = Customer::get();
        $currencies = Currency::get();
        return view("customer.account", compact("customers", "currencies"));
    }

    public function unpaidCustomer()
    {
        $customers = Customer::get();
        $currencies = Currency::get();
        return view("customer.unpaidCustomer", compact("customers", "currencies"));
    }

    public function accountShow(Request $request, $id)
    {
        $currency_id = $request->currency_id;
        $currency = Currency::find($currency_id);
        $customer = Customer::find($id);
        $openReceivables = OpenReceivable::where(["customer_id" => $id, 'currency_id' => $currency_id])->get();
        $sales = DB::table("sales as s")
            ->join("sale_bills as sb", "s.bill_id", "sb.id")
            ->select(DB::raw("sb.id as bill_id,SUM(price*qty-price*qty*s.discount/100) as amount,  sb.created_at,sb.details"))
            ->where(["sb.customer_id" => $id, "sb.currency_id" => $currency_id])
            ->groupBy('s.bill_id')->orderBy('sb.id', 'desc')->get();
        // $returns = SaleReturn::where(["customer_id" => $id, 'currency_id' => $currency_id])->get();
        $returns = DB::table("sale_return_details as srd")
            ->join("sale_returns as sr", "srd.sale_return_id", "sr.id")
            ->join("customers as cus", "sr.customer_id", "cus.id")
            ->join("currencies as cur", "sr.currency_id", "cur.id")
            ->select(DB::raw("sr.id as id,SUM(price*qty) as amount, cus.name as customer_name,cur.name as currency_name, sr.date as sale_return_date,sr.details,sr.created_at"))
            ->groupBy('srd.sale_return_id')->orderBy('sr.id', 'desc')
            ->where(["sr.customer_id" => $id, 'sr.currency_id' => $currency_id])
            ->get();
        $cashReturns = DB::table("sale_return_details as srd")
            ->join("sale_returns as sr", "srd.sale_return_id", "sr.id")
            ->join("customers as cus", "sr.customer_id", "cus.id")
            ->join("currencies as cur", "sr.currency_id", "cur.id")
            ->select(DB::raw("sr.id as id,SUM(price*qty) as amount, cus.name as customer_name,cur.name as currency_name, sr.date as sale_return_date,sr.details,sr.created_at"))
            ->groupBy('srd.sale_return_id')->orderBy('sr.id', 'desc')
            ->where(["sr.customer_id" => $id, 'sr.currency_id' => $currency_id, 'isCash' => 1])
            ->get();

        $receiveds = Received::where(["customer_id" => $id, 'currency_id' => $currency_id])->get();

        return view("customer.check_result", compact("openReceivables", "sales", "returns", "cashReturns", "receiveds", "customer", "currency"));
    }


    public function customerBalance($customer_id)
    {
        $currencies = Currency::get();
        $customer = Customer::find($customer_id);

        $data = $customer->name . " (";
        foreach ($currencies as $currency) {
            $openReceivable = OpenReceivable::where(['customer_id' => $customer_id, 'currency_id' => $currency->id])->sum('amount');
            $totSale = FunctionController::totSale($customer_id, $currency->id);
            $totReturn = FunctionController::totSaleReturn($customer_id, $currency->id);
            $totReturnCash = FunctionController::totSaleReturnCash($customer_id, $currency->id);
            $totReceived = Received::where(['customer_id' => $customer_id, 'currency_id' => $currency->id])->sum('amount');

            $balance = $openReceivable + $totSale + $totReturnCash - $totReturn - $totReceived . $currency->name . ' ';
            $data .= $balance;
        }

        return $data . ')';
    }
}
