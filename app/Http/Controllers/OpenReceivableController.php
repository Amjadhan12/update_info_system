<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Customer;
use App\Models\OpenReceivable;
use Illuminate\Http\Request;

class OpenReceivableController extends Controller
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
        $openReceivables = OpenReceivable::get();

        return view("openReceivable.index", compact("customers", "currencies", "openReceivables"));
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
        OpenReceivable::create($data);
        return redirect()->route('openReceivable.index')
            ->with('msg', 'Open Receivable Saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OpenReceivable  $openReceivable
     * @return \Illuminate\Http\Response
     */
    public function show(OpenReceivable $openReceivable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OpenReceivable  $openReceivable
     * @return \Illuminate\Http\Response
     */
    public function edit(OpenReceivable $openReceivable)
    {
        $customers = Customer::where('id', '!=', $openReceivable->customer_id)->get();
        $currencies = Currency::where('id', '!=', $openReceivable->currency_id)->get();
        return view("openReceivable.edit", compact("customers", "currencies", "openReceivable"));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OpenReceivable  $openReceivable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OpenReceivable $openReceivable)
    {
        $data = $request->all();
        $data['curRate']=Currency::find($request->currency_id)->rate;
        $openReceivable->update($data);
        return redirect()->route('openReceivable.index')
            ->with('msg', 'Open Receivable updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OpenReceivable  $openReceivable
     * @return \Illuminate\Http\Response
     */
    public function destroy(OpenReceivable $openReceivable)
    {
        //
    }
}
