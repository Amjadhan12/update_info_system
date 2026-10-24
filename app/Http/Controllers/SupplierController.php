<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\OpenPayable;
use App\Models\Payment;
use App\Models\PurchaseReturn;
use App\Models\Supplier;
use Illuminate\Http\Request;
use DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::get();
        return view("supplier.index", compact("suppliers"));
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
            'name' => 'required|max:255|unique:suppliers'
        ]);
        $data = $request->all();
        Supplier::create($data);
        return redirect()->route($request->redirect_to)
            ->with('msg', 'Supplier saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return view("supplier.edit", compact("supplier"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:suppliers,name,' . $supplier->id,
        ]);
        $data = $request->all();
        $supplier->update($data);
        return redirect()->route('supplier.index')
            ->with('msg', 'Supplier upadated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }


    public function getSupplier(Request $request)
    {
        $supplier = Supplier::where("name", $request->name)->first();
        return ['id' => $supplier->id, 'name' => $supplier->name];
    }

    public function account()
    {
        $suppliers = Supplier::get();
        $currencies = Currency::get();
        return view("supplier.account", compact("suppliers", "currencies"));
    }

    public function accountShow(Request $request, $id)
    {
        $currency_id = $request->currency_id;
        $currency = Currency::find($currency_id);
        $supplier = Supplier::find($id);
        $openPaybles = OpenPayable::where(["supplier_id" => $id, 'currency_id' => $currency_id])->get();
        $purchases = DB::table("purchases as p")
            ->join("purchase_bills as pb", "p.bill_id", "pb.id")
            ->select(DB::raw("pb.id as bill_id,SUM(pprice*qty) as amount,  pb.created_at,pb.details"))
            ->where(["pb.supplier_id" => $id, "pb.currency_id" => $currency_id])
            ->groupBy('p.bill_id')->orderBy('pb.id', 'desc')->get();
        // $returns = PurchaseReturn::where(["supplier_id" => $id, 'currency_id' => $currency_id])->get();
        $returns = DB::table("purchase_return_details as prd")
            ->join("purchase_returns as pr", "prd.purchase_return_id", "pr.id")
            ->join("suppliers as sup", "pr.supplier_id", "sup.id")
            ->join("currencies as cur", "pr.currency_id", "cur.id")
            ->select(DB::raw("pr.id as id,SUM(price*qty) as amount, sup.name as supplier_name,cur.name as currency_name, pr.date as purchase_return_date,pr.details,pr.created_at"))
            ->where(["pr.supplier_id" => $id, 'pr.currency_id' => $currency_id])
            ->groupBy('pr.id')->get();
        $cashReturns = DB::table("purchase_return_details as prd")
            ->join("purchase_returns as pr", "prd.purchase_return_id", "pr.id")
            ->join("suppliers as sup", "pr.supplier_id", "sup.id")
            ->join("currencies as cur", "pr.currency_id", "cur.id")
            ->select(DB::raw("pr.id as id,SUM(price*qty) as amount, sup.name as supplier_name,cur.name as currency_name, pr.date as purchase_return_date,pr.details,pr.created_at"))
            ->where(["pr.supplier_id" => $id, 'pr.currency_id' => $currency_id, "pr.isCash" => 1])
            ->groupBy('pr.id')->get();


        $payments = Payment::where(["supplier_id" => $id, 'currency_id' => $currency_id])->get();

        return view("supplier.check_result", compact("openPaybles", "purchases", "returns", "cashReturns", "payments", "supplier", "currency"));
    }
}
