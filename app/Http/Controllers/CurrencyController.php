<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = Currency::get();
        return view("currency.index", compact("currencies"));
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
            'name' => 'required|max:255|unique:currencies'
        ]);
        $data = $request->all();
        Currency::create($data);
        return redirect()->route("currency.index")
            ->with('msg', 'Currency saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        return view("currency.edit", compact("currency"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        // $validatedData = $request->validate([
        //     'name' => 'required|unique:currencies,name,' . $currency->id,
        // ]);
        $data = $request->all();
        $currency->update($data);
        return redirect()->route('currency.index')
            ->with('msg', 'Currency updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Currency::find($id)->delete();

        // return redirect()->route('currency.index')
        //     ->with('msg', 'Currency deleted successfully!');
    }


    public function getCurrency(Request $request)
    {
        $currency = Currency::where("name", $request->curName)->first();
        return ['id' => $currency->id, 'name' => $currency->name, 'curRate' => $currency->rate];
    }
}
