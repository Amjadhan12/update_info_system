<?php

namespace App\Http\Controllers;

use App\Models\CashAccount;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Received;
use Illuminate\Http\Request;

class ReceivedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::get();
        $currencies = Currency::get();
        $receiveds = Received::orderBy('id','desc')->get();
        $cashAccounts = CashAccount::get();
        return view("received.index", compact("cashAccounts","customers", "currencies", "receiveds"));
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
        Received::create($data);
        return redirect()->route('received.index')
            ->with('msg', 'Receipt Saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Received  $received
     * @return \Illuminate\Http\Response
     */
    public function show(Received $received)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Received  $received
     * @return \Illuminate\Http\Response
     */
    public function edit(Received $received)
    {
        $customers = Customer::where('id', '!=', $received->customer_id)->get();
        $currencies = Currency::where('id', '!=', $received->currency_id)->get();
        $cashAccounts = CashAccount::where('id', '!=', $received->cash_account_id)->get();
        return view("received.edit", compact("cashAccounts","customers", "currencies", "received"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Received  $received
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Received $received)
    {
        $data = $request->all();
        $data['curRate']=Currency::find($request->currency_id)->rate;
        $received->update($data);
        return redirect()->route('received.index')
            ->with('msg', 'received updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Received  $received
     * @return \Illuminate\Http\Response
     */
    public function destroy(Received $received)
    {
        //
    }
}
