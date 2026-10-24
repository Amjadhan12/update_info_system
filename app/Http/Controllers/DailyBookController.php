<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\DailyBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = Currency::get();
        $dailyBooks = DailyBook::orderBy('id','desc')->paginate(500);
        return view("dailyBook.index", compact("dailyBooks","currencies"));
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
        $data['curRate']=Currency::find($request->currency_id)->rate;
        DailyBook::create($data);
        return redirect()->route('dailyBook.index')
            ->with('msg', 'Record saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DailyBook  $dailyBook
     * @return \Illuminate\Http\Response
     */
    public function show(DailyBook $dailyBook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DailyBook  $dailyBook
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyBook $dailyBook)
    {
        $currencies = Currency::where('id', '!=', $dailyBook->currency_id)->get();
        return view("dailyBook.edit", compact("dailyBook","currencies"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DailyBook  $dailyBook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyBook $dailyBook)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['curRate']=Currency::find($request->currency_id)->rate;
        $dailyBook->update($data);
        return redirect()->route('dailyBook.index')
            ->with('msg', 'Record updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DailyBook  $dailyBook
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyBook $dailyBook)
    {
        //
    }


    public function dailyBookShow(Request $request)
    {
        $from=$request->fromDate;
        $to=$request->toDate;

        $dailyBooks=DailyBook::whereBetween('date',[$from,$to])->get();

        return view("dailyBook.show",compact('from','to','dailyBooks'));
    }
}
