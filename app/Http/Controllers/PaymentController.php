<?php

namespace App\Http\Controllers;

use App\Models\CashAccount;
use App\Models\Currency;
use App\Models\Payment; 
use App\Models\Supplier;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::get();
        $currencies = Currency::get();
        $payments = Payment::orderBy('id','desc')->get();
        $cashAccounts = CashAccount::get();
        return view("payment.index", compact("cashAccounts","suppliers", "currencies", "payments"));
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
        $data['curRate']=Currency::find($request->currency_id)->rate;
        Payment::create($data);
        return redirect()->route('payment.index')
            ->with('msg', 'Payment Saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    { 
        $suppliers = Supplier::where('id', '!=', $payment->supplier_id)->get();
        $currencies = Currency::where('id', '!=', $payment->currency_id)->get();
        $cashAccounts = CashAccount::where('id', '!=', $payment->cash_account_id)->get();
        return view("payment.edit", compact("cashAccounts","suppliers", "currencies", "payment"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $data = $request->all();
        $data['curRate']=Currency::find($request->currency_id)->rate;
        $payment->update($data);
        return redirect()->route('payment.index')
            ->with('msg', 'Payment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
