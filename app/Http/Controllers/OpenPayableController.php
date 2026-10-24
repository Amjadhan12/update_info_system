<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\OpenPayable;
use App\Models\Supplier;
use Illuminate\Http\Request;

class OpenPayableController extends Controller
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
        $openPayables = OpenPayable::get();

        return view("openPayable.index", compact("suppliers", "currencies", "openPayables"));
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
        OpenPayable::create($data);
        return redirect()->route('openPayable.index')
            ->with('msg', 'Open Payable Saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OpenPayable  $openPayable
     * @return \Illuminate\Http\Response
     */
    public function show(OpenPayable $openPayable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OpenPayable  $openPayable
     * @return \Illuminate\Http\Response
     */
    public function edit(OpenPayable $openPayable)
    { 
        $suppliers = Supplier::where('id', '!=', $openPayable->supplier_id)->get();
        $currencies = Currency::where('id', '!=', $openPayable->currency_id)->get();
        return view("openPayable.edit", compact("suppliers", "currencies", "openPayable"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OpenPayable  $openPayable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OpenPayable $openPayable)
    {
        $data = $request->all();
        $data['curRate']=Currency::find($request->currency_id)->rate;
        $openPayable->update($data);
        return redirect()->route('openPayable.index')
            ->with('msg', 'Open Payable updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OpenPayable  $openPayable
     * @return \Illuminate\Http\Response
     */
    public function destroy(OpenPayable $openPayable)
    {
        //
    }
}
