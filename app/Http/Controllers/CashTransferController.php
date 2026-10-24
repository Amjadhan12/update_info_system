<?php

namespace App\Http\Controllers;

use App\Models\CashAccount;
use App\Models\CashTransfer;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cashTransfers = cashTransfer::get();
        $cashAccounts = CashAccount::get();
        $currencies = Currency::get();
        return view("cashTransfer.index", compact('cashTransfers', 'cashAccounts', "currencies"));
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
        $data['user_id'] = Auth::id();
        $data['curRate'] = Currency::find($request->currency_id)->rate;
        cashTransfer::create($data);
        return redirect()->route('cashTransfer.index')
            ->with('msg', 'Cash Transfer saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CashTransfer  $cashTransfer
     * @return \Illuminate\Http\Response
     */
    public function show(CashTransfer $cashTransfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CashTransfer  $cashTransfer
     * @return \Illuminate\Http\Response
     */
    public function edit(CashTransfer $cashTransfer)
    {
        $currencies = Currency::where('id', '!=', $cashTransfer->currency_id)->get();
        $cashAccounts=CashAccount::get();
        return view("cashTransfer.edit", compact("cashAccounts","cashTransfer", "currencies"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CashTransfer  $cashTransfer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CashTransfer $cashTransfer)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['curRate'] = Currency::find($request->currency_id)->rate;
        $cashTransfer->update($data);
        return redirect()->route('cashTransfer.index')
            ->with('msg', 'ژash Transfer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CashTransfer  $cashTransfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(CashTransfer $cashTransfer)
    {
        //
    }
}
