<?php

namespace App\Http\Controllers;

use App\Models\CashAccount;
use App\Models\Currency;
use App\Models\Expense; 
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::get();
        $expenseCategories = ExpenseCategory::get();
        $currencies = Currency::get();
        $cashAccounts = CashAccount::get();
        return view("expense.index", compact("cashAccounts",'expenses', 'expenseCategories',"currencies"));
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
        Expense::create($data);
        return redirect()->route('expense.index')
            ->with('msg', 'Expense saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        $cashAccounts = CashAccount::where('id', '!=', $expense->cash_account_id)->get();
        $currencies = Currency::where('id', '!=', $expense->currency_id)->get();
        $expenseCategories = ExpenseCategory::where('id', '!=', $expense->expense_category_id)->get();
        return view("expense.edit", compact("cashAccounts","expense", "expenseCategories","currencies"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['curRate']=Currency::find($request->currency_id)->rate;
        $expense->update($data);
        return redirect()->route('expense.index')
            ->with('msg', 'Expense updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Expense::find($id)->delete();

        return redirect()->route('expense.index')
            ->with('msg', 'Expense deleted successfully!');
    }
}
