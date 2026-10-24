<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use App\Models\CashAccount;
use App\Models\CashTransfer;
use App\Models\Currency;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Received;
use Illuminate\Http\Request;
use DB;


class CashAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cashAccounts = CashAccount::get();
        return view("cashAccount.index", compact("cashAccounts"));
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
            'name' => 'required|max:255|unique:cash_accounts'
        ]);
        $data = $request->all();
        CashAccount::create($data);
        return redirect()->route("cashAccount.index")
            ->with('msg', 'Cash Account saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CashAccount  $cashAccount
     * @return \Illuminate\Http\Response
     */
    public function show(CashAccount $cashAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CashAccount  $cashAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(CashAccount $cashAccount)
    {
        return view("cashAccount.edit", compact("cashAccount"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CashAccount  $cashAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CashAccount $cashAccount)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:cash_accounts,name,' . $cashAccount->id,
        ]);
        $data = $request->all();
        $cashAccount->update($data);
        return redirect()->route('cashAccount.index')
            ->with('msg', 'Cash Account upadated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CashAccount  $cashAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(CashAccount $cashAccount)
    {
        //
    }


    public function getCashAccount(Request $request)
    {
        $cashAccount = CashAccount::where("name", $request->cashAccountName)->first();
        return ['id' => $cashAccount->id, 'name' => $cashAccount->name];
    }



    public function account()
    {
        $cashAccounts = CashAccount::get();
        $currencies = Currency::get();
        return view("cashAccount.account", compact("cashAccounts", "currencies"));
    }

    public function accountShow(Request $request, $id)
    {
        $currency_id = $request->currency_id;
        $currency = Currency::find($currency_id);
        $cashAccount = CashAccount::find($id);

        $cashes = Cash::where(["cash_account_id" => $id, 'currency_id' => $currency_id])->get();
        $receiveds = Received::where(["cash_account_id" => $id, 'currency_id' => $currency_id])->get();
        $payments = Payment::where(["cash_account_id" => $id, 'currency_id' => $currency_id])->get();
        $expenses = Expense::where(["cash_account_id" => $id, 'currency_id' => $currency_id])->get();
        $transferIns = CashTransfer::where(["to_account_id" => $id, 'currency_id' => $currency_id])->get();
        $transferOuts = CashTransfer::where(["from_account_id" => $id, 'currency_id' => $currency_id])->get();
        $cashSaleReturns = DB::table("sale_return_details as srd")
            ->join("sale_returns as sr", "srd.sale_return_id", "sr.id")
            ->join("customers as cus", "sr.customer_id", "cus.id")
            ->join("currencies as cur", "sr.currency_id", "cur.id")
            ->select(DB::raw("sr.id as id,SUM(price*qty) as amount, cus.name as customer_name,cur.name as currency_name, sr.date as sale_return_date,sr.details,sr.created_at"))
            ->groupBy('srd.sale_return_id')->orderBy('sr.id', 'desc')
            ->where(["sr.cash_account_id" => $id, 'sr.currency_id' => $currency_id, 'isCash' => 1])
            ->get();
        $cashPurchaseReturns = DB::table("purchase_return_details as prd")
            ->join("purchase_returns as pr", "prd.purchase_return_id", "pr.id")
            ->join("suppliers as sup", "pr.supplier_id", "sup.id")
            ->join("currencies as cur", "pr.currency_id", "cur.id")
            ->select(DB::raw("pr.id as id,SUM(price*qty) as amount, sup.name as supplier_name,cur.name as currency_name, pr.date as purchase_return_date,pr.details,pr.created_at"))
            ->where(["pr.cash_account_id" => $id, 'pr.currency_id' => $currency_id, "pr.isCash" => 1])
            ->groupBy('pr.id')->get();


        return view("cashAccount.check_result", compact("cashPurchaseReturns","cashSaleReturns","cashes", "receiveds", "payments", "expenses", "transferIns", "transferOuts", "currency", "cashAccount"));
    }
}
