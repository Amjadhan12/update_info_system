<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenseCategories=ExpenseCategory::get();
        return view("expenseCategory.index",compact("expenseCategories"));
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
            'name' => 'required|max:255|unique:expense_categories'
        ]);
        $data = $request->all();
        ExpenseCategory::create($data);
        return redirect()->route("expenseCategory.index")
            ->with('msg', 'Expense Category saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseCategory $expenseCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseCategory $expenseCategory)
    {
        return view("expenseCategory.edit", compact("expenseCategory"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:expense_categories,name,' . $expenseCategory->id,
        ]);
        $data = $request->all();
        $expenseCategory->update($data);
        return redirect()->route('expenseCategory.index')
            ->with('msg', 'Expense Category upadated successfully!');
    } 

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        //
    }


    public function getExpenseCategory(Request $request)
    {
        $expenseCategory=ExpenseCategory::where("name",$request->name)->first();
        return ['id'=>$expenseCategory->id,'name'=>$expenseCategory->name];
    }
}
