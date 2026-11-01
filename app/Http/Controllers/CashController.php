<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use App\Models\CashAccount;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cashes = Cash::get();
        $cashAccounts = CashAccount::get();
        $currencies = Currency::get();
        return view("cash.index", compact('cashes', 'cashAccounts', "currencies"));
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
        Cash::create($data);
        return redirect()->route('cash.index')
            ->with('msg', 'cash saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cash  $cash
     * @return \Illuminate\Http\Response
     */
    public function show(Cash $cash)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cash  $cash
     * @return \Illuminate\Http\Response
     */
    public function edit(Cash $cash)
    {
        $currencies = Currency::where('id', '!=', $cash->currency_id)->get();
        $cashAccounts = CashAccount::where('id', '!=', $cash->cash_account_id)->get();
        return view("cash.edit", compact("cash", "cashAccounts", "currencies"));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cash  $cash
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cash $cash)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['curRate'] = Currency::find($request->currency_id)->rate;
        $cash->update($data);
        return redirect()->route('cash.index')
            ->with('msg', 'cash updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cash  $cash
     * @return \Illuminate\Http\Response
     */ 
    public function destroy(Cash $cash)
    {
        //
    }
}
