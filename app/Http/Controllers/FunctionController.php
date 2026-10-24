<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Item;
use App\Models\OpenStock;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetails;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\SaleReturnDetails;
use App\Models\Stock;
use App\Models\StockTransfer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class FunctionController extends Controller
{
    public static function totSale($customer, $currency, $from = "", $to = "")
    {
        $sales = DB::table("sales as s")
            ->join("sale_bills as sb", "s.bill_id", "sb.id")
            ->select(DB::raw("IFNULL(SUM(price*qty-price*qty*s.discount/100),0) as amount"))
            ->where(['sb.customer_id' => $customer, 'sb.currency_id' => $currency])->first();
        if ($customer == 0) {
            $sales = DB::table("sales as s")
                ->join("sale_bills as sb", "s.bill_id", "sb.id")
                ->select(DB::raw("IFNULL(SUM(price*qty-price*qty*s.discount/100),0) as amount"))
                ->where(['sb.currency_id' => $currency])->first();
        }
        $totSales = 0;
        if ($sales) {
            $totSales = $sales->amount;
        }

        return $totSales;
    }
    public static function totSaleReturn($customer, $currency, $from = "", $to = "")
    {
        $returns = DB::table("sale_return_details as srd")
            ->join("sale_returns as sr", "srd.sale_return_id", "sr.id")
            ->select(DB::raw("IFNULL(SUM(price*qty),0) as amount"))
            ->where(['sr.customer_id' => $customer, 'sr.currency_id' => $currency])->first();
        if ($customer == 0) {
            $returns = DB::table("sale_return_details as srd")
                ->join("sale_returns as sr", "srd.sale_return_id", "sr.id")
                ->select(DB::raw("IFNULL(SUM(price*qty),0) as amount"))
                ->where(['sr.currency_id' => $currency])->first();
        }
        $totReturn = 0;
        if ($returns) {
            $totReturn = $returns->amount;
        }

        return $totReturn;
    }
    public static function totSaleReturnCash($customer, $currency, $from = "", $to = "")
    {
        $returns = DB::table("sale_return_details as srd")
            ->join("sale_returns as sr", "srd.sale_return_id", "sr.id")
            ->select(DB::raw("IFNULL(SUM(price*qty),0) as amount"))
            ->where(['sr.customer_id' => $customer, 'sr.currency_id' => $currency, 'sr.isCash' => 1])->first();
        if ($customer == 0) {
            $returns = DB::table("sale_return_details as srd")
                ->join("sale_returns as sr", "srd.sale_return_id", "sr.id")
                ->select(DB::raw("IFNULL(SUM(price*qty),0) as amount"))
                ->where(['sr.currency_id' => $currency, 'sr.isCash' => 1])->first();
        }
        $totReturn = 0;
        if ($returns) {
            $totReturn = $returns->amount;
        }

        return $totReturn;
    }

    public static function totPurchase($supplier, $currency, $from = "", $to = "")
    {
        $purchases = DB::table("purchases as p")
            ->join("purchase_bills as pb", "p.bill_id", "pb.id")
            ->select(DB::raw("IFNULL(SUM(pprice*qty),0) as amount"))
            ->where(['pb.supplier_id' => $supplier, 'pb.currency_id' => $currency])
            ->first();
        if ($supplier == 0) {
            $purchases = DB::table("purchases as p")
                ->join("purchase_bills as pb", "p.bill_id", "pb.id")
                ->select(DB::raw("IFNULL(SUM(pprice*qty),0) as amount"))
                ->where('pb.currency_id', $currency)
                ->first();
        }
        $totPurchases = 0;
        if ($purchases) {
            $totPurchases = $purchases->amount;
        }

        return $totPurchases;
    }
    public static function totPurchaseReturn($supplier, $currency, $from = "", $to = "")
    {
        $returns = DB::table("purchase_return_details as prd")
            ->join("purchase_returns as pr", "prd.purchase_return_id", "pr.id")
            ->select(DB::raw("IFNULL(SUM(price*qty),0) as amount"))
            ->where(['pr.supplier_id' => $supplier, 'pr.currency_id' => $currency])->first();
        if ($supplier == 0) {
            $returns = DB::table("purchase_return_details as prd")
                ->join("purchase_returns as pr", "prd.purchase_return_id", "pr.id")
                ->select(DB::raw("IFNULL(SUM(price*qty),0) as amount"))
                ->where(['pr.currency_id' => $currency])->first();
        }
        $totReturn = 0;
        if ($returns) {
            $totReturn = $returns->amount;
        }

        return $totReturn;
    }
    public static function totPurchaseReturnCash($supplier, $currency, $from = "", $to = "")
    {
        $returns = DB::table("purchase_return_details as prd")
            ->join("purchase_returns as pr", "prd.purchase_return_id", "pr.id")
            ->select(DB::raw("IFNULL(SUM(price*qty),0) as amount"))
            ->where(['pr.supplier_id' => $supplier, 'pr.currency_id' => $currency, 'pr.isCash' => 1])->first();
        if ($supplier == 0) {
            $returns = DB::table("purchase_return_details as prd")
                ->join("purchase_returns as pr", "prd.purchase_return_id", "pr.id")
                ->select(DB::raw("IFNULL(SUM(price*qty),0) as amount"))
                ->where(['pr.currency_id' => $currency, 'pr.isCash' => 1])->first();
        }
        $totReturn = 0;
        if ($returns) {
            $totReturn = $returns->amount;
        }

        return $totReturn;
    }

    public static function itemQty($item)
    {
        $item = Item::find($item);
        $open = OpenStock::where('item_id', $item->id)->sum('qty');
        $purchase = Purchase::where('item_id', $item->id)->sum('qty');
        $purchaseReturn = PurchaseReturnDetails::where('item_id', $item->id)->sum('qty');
        $saled = Sale::where('item_id', $item->id)->sum('qty');
        $saleReturn = SaleReturnDetails::where('item_id', $item->id)->sum('qty');
        $currentQty = $purchase + $open + $saleReturn - $saled - $purchaseReturn;
        return $currentQty;
    }
    public static function itemsQtySpecific($qty, $low, $state = "Less")
    {
        $items = Item::get();
        $itemsQty = 0;
        foreach ($items as $item) {
            $open = OpenStock::where('item_id', $item->id)->sum('qty');
            $purchase = Purchase::where('item_id', $item->id)->sum('qty');
            $purchaseReturn = PurchaseReturnDetails::where('item_id', $item->id)->sum('qty');
            $saled = Sale::where('item_id', $item->id)->sum('qty');
            $saleReturn = SaleReturnDetails::where('item_id', $item->id)->sum('qty');
            $currentQty = $purchase + $open + $saleReturn - $saled - $purchaseReturn;
            if ($state == "Less" && $currentQty <= $qty && $qty == 0) {
                $itemsQty++;
            } else if ($state == "Less" && $currentQty <= $qty && $currentQty > $low) {
                $itemsQty++;
            } else if ($state == "Greater" && $currentQty > $qty) {
                $itemsQty++;
            }
        }
        return $itemsQty;
    }
    public static function itemQtyStock($item_id, $stock_id)
    {
        $item = Item::find($item_id);
        $stock = Stock::find($stock_id);
        $open = OpenStock::where(['item_id' => $item->id, 'stock_id' => $stock->id])->sum('qty');
        $purchase = Purchase::where(['item_id' => $item->id, 'stock_id' => $stock->id])->sum('qty');
        $purchaseReturn = PurchaseReturnDetails::where(['item_id' => $item->id, 'stock_id' => $stock->id])->sum('qty');
        $saled = Sale::where(['item_id' => $item->id, 'stock_id' => $stock->id])->sum('qty');
        $saleReturn = SaleReturnDetails::where(['item_id' => $item->id, 'stock_id' => $stock->id])->sum('qty');

        $transferIn = StockTransfer::where(['item_id' => $item->id, 'to_stock_id' => $stock->id])->sum('qty');
        $transferOut = StockTransfer::where(['item_id' => $item->id, 'from_stock_id' => $stock->id])->sum('qty');
        $currentQty = $purchase + $open  + $saleReturn - $saled - $purchaseReturn + $transferIn - $transferOut;
        return $currentQty;
    }

    //find item price
    public static function itemPrice($item, $currency)
    {
        $item = Item::find($item);
        $currency = Currency::find($currency);
        $price = $item->sprice / $item->curRate * $currency->rate;
        return round($price, 2);
    }
    //find item purchase cost
    public static function itemCost($item, $currency)
    {
        $item = Item::find($item);
        $currency = Currency::find($currency);
        $cost = $item->pprice / $item->curRate * $currency->rate;
        return round($cost, 2);
    }
    //find item expire date
    public static function itemExpDate($item)
    {
        $purchase = Purchase::where('item_id', $item)->orderBy('id', 'desc')->first();
        $exp_date = date('y-m-d');
        if ($purchase) {
            $exp_date = $purchase->exp_date;
        } else {
            $opening = OpenStock::where('item_id', $item)->orderBy('id', 'desc')->first();
            if ($opening) {
                $exp_date = $opening->date;
            } else {
                $exp_date = date('y-m-d');
            }
        }

        // $start_date = Carbon::createFromFormat('Y-m-d', $exp_date);
        // $end_date = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        // $different_days = $start_date->diffInDays($end_date);
        // $data = "";
        // if ($start_date > $end_date) {
        //     if ($different_days > 90) {
        //         $data = "<h3 class='badge bg-success'>" . $different_days . " days</h3>";
        //     } else {
        //         $data = "<h3 class='badge bg-warning text-dark'>Warning : " . $different_days . " days</h3>";
        //     }
        // } else {
        //     $data = "<h3 class='badge bg-danger'>Expired : " . $different_days . " days ago!</h3>";
        // }
        return $exp_date;
    }



    public static function purchaseGraph()
    {
        $year = date("Y");
        $purchase = array();
        for ($a = 0; $a < 12; $a++) {
            $m = $a + 1;
            $from = $year . '-' . $m . '-01';
            $to = $year . '-' . $m . '-31';
            $data = DB::table("purchases as p")
                ->join("purchase_bills as pb", "p.bill_id", "pb.id")
                ->select(DB::raw("IFNULL(SUM(pprice*qty),0) AS total"))
                ->whereBetween('pb.date', [$from, $to])
                ->first()->total;
            if ($data) {
                $purchase[$a] = round($data, 2);
            } else {
                $purchase[$a] = 0;
            }
        }

        return json_encode($purchase);
    }

    public static function saleGraph()
    {
        $year = date("Y");
        $sale = array();
        for ($a = 0; $a < 12; $a++) {
            $m = $a + 1;
            $from = $year . '-' . $m . '-01';
            $to = $year . '-' . $m . '-31';
            $data = DB::table("sales as s")
                ->join("sale_bills as sb", "s.bill_id", "sb.id")
                ->select(DB::raw("IFNULL(SUM(price*qty),0) AS total"))
                ->whereBetween('sb.date', [$from, $to])
                ->first()->total;
            if ($data) {
                $sale[$a] = round($data, 2);
            } else {
                $sale[$a] = 0;
            }
        }

        return json_encode($sale);
    }

    public static function expenseGraph()
    {
        $year = date("Y");
        $exp = array();
        $from = $year . '-01-01';
        $to = $year . '-12-31';
        $categories = ExpenseCategory::get();
        $a = 0;
        foreach ($categories as $category) {
            $data = DB::table("expenses")
                ->select(DB::raw("IFNULL(SUM(amount),0) AS total"))
                ->where("expense_category_id", $category->id)
                ->whereBetween('date', [$from, $to])
                ->first()->total;
            if ($data) {
                $exp[$a] = round($data, 2);
            } else {
                $exp[$a] = 0;
            }
            $a++;
        }


        return json_encode($exp);
    }



    //today results
    public static function todayProfit($date = "")
    {
        if ($date == "") {
            $date = date('Y-m-d');
        }

        $sales = DB::table("sales as s")
            ->join("sale_bills as sb", "s.bill_id", "sb.id")
            ->join("customers as cus", "sb.customer_id", "cus.id")
            ->select(DB::raw("sb.id as bill_id,sb.currency_id,curRate,IFNULL(SUM(price*qty-price*qty*s.discount/100),0) as amount, cus.name as customer_name, sb.date as sale_date,sb.details"))
            ->groupBy('s.bill_id')->orderBy('sb.id', 'desc')
            ->where("sb.date", $date)
            ->get();

        $totAmount = 0;
        $totProfit = 0;
        foreach ($sales as $sale) {
            $totAmount += $sale->amount;

            $sells = Sale::where('bill_id', $sale->bill_id)->get();
            $profit = 0;
            foreach ($sells as $sell) {
                $cost = $sell->pprice;
                $price = $sell->price - $sell->price * $sell->discount / 100;
                $profit += round((($price - $cost) * $sell->qty) / $sale->curRate, 2);
            }

            $totProfit += $profit;
        }

        return ['totalSale' => round($totAmount, 1), 'profit' => round($totProfit, 1)];
    }

    //today purchases
    public static function todayPurchase($date = "")
    {
        if ($date == "") {
            $date = date('Y-m-d');
        }

        $purchases = DB::table("purchases as p")
            ->join("purchase_bills as pb", "p.bill_id", "pb.id")
            ->select(DB::raw("pb.id as bill_id,pb.currency_id,curRate,IFNULL(SUM(pprice*qty),0) as amount"))
            ->groupBy('p.bill_id')->orderBy('pb.id', 'desc')
            ->where("pb.date", $date)
            ->get();

        $totAmount = 0;
        foreach ($purchases as $purchase) {
            $totAmount += ($purchase->amount / $purchase->curRate);
        }
        return round($totAmount, 0);
    }
    //today purchases
    public static function todayExpense($date = "")
    {
        if ($date == "") {
            $date = date('Y-m-d');
        }

        $expenses = Expense::where('date', $date)->get();

        $totAmount = 0;
        foreach ($expenses as $expense) {
            $totAmount += ($expense->amount / $expense->curRate);
        }
        return round($totAmount, 0);
    }
}
