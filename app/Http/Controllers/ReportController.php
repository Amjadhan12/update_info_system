<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Item;
use App\Models\OpenPayable;
use App\Models\OpenReceivable;
use App\Models\OpenStock;
use App\Models\Supplier;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Received;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\Setting;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Helper method to get language
    private function getLanguage()
    {
        return Auth::user()->language ?? 'Pashto';
    }

    // Helper method to get localized text
    private function getText($pashto, $english)
    {
        return $this->getLanguage() == 'English' ? $english : $pashto;
    }

    //purchase report
    public function purchase()
    {
        $suppliers = Supplier::get();
        return view("report.purchase", compact("suppliers"));
    }
    
    public function purchaseShow(Request $request)
    {
        $from = $request->fromDate;
        $to =  $request->toDate;
        $supplier_id = $request->supplier_id;
        $isEnglish = ($this->getLanguage() == 'English');

        $supplierName = "";
        if ($supplier_id == 0) {
            $supplierName = $this->getText("ټول شرکتونه", "All Suppliers");
            $purchases = DB::table("purchases as p")
                ->join("purchase_bills as pb", "p.bill_id", "pb.id")
                ->join("suppliers as sup", "pb.supplier_id", "sup.id")
                ->select(DB::raw("pb.id as bill_id,pb.currency_id,SUM(pprice*qty) as amount, sup.name as supplier_name, pb.date as purchase_date,pb.details"))
                ->groupBy('p.bill_id')->orderBy('pb.id', 'desc')
                ->whereBetween('pb.date', [$from, $to])
                ->get();
            $totPurchase = DB::table("purchases as p")
                ->join("purchase_bills as pb", "p.bill_id", "pb.id")
                ->join("currencies as cur", "pb.currency_id", "cur.id")
                ->select(DB::raw("pb.currency_id,SUM(pprice*qty) as amount, cur.name as currency_name"))
                ->groupBy('pb.currency_id')->orderBy('pb.id', 'desc')
                ->whereBetween('pb.date', [$from, $to])
                ->get();
        } else {
            $supplierName = Supplier::find($supplier_id)->name;
            $purchases = DB::table("purchases as p")
                ->join("purchase_bills as pb", "p.bill_id", "pb.id")
                ->join("suppliers as sup", "pb.supplier_id", "sup.id")
                ->select(DB::raw("pb.id as bill_id,pb.currency_id,SUM(pprice*qty) as amount, sup.name as supplier_name, pb.date as purchase_date,pb.details"))
                ->groupBy('p.bill_id')->orderBy('pb.id', 'desc')
                ->whereBetween('pb.date', [$from, $to])
                ->where("pb.supplier_id", $supplier_id)
                ->get();
            $totPurchase = DB::table("purchases as p")
                ->join("purchase_bills as pb", "p.bill_id", "pb.id")
                ->join("currencies as cur", "pb.currency_id", "cur.id")
                ->select(DB::raw("pb.currency_id,SUM(pprice*qty) as amount, cur.name as currency_name"))
                ->groupBy('pb.currency_id')->orderBy('pb.id', 'desc')
                ->whereBetween('pb.date', [$from, $to])
                ->where("pb.supplier_id", $supplier_id)
                ->get();
        }

        $title = $this->getText("د خرید راپور", "Purchase Report");
        $fromLabel = $this->getText("له", "From");
        $toLabel = $this->getText("تر", "To");
        $noData = $this->getText("هیچ معلومات نشته!", "No data Available!");
        $totalLabel = $this->getText("مجموعه", "Total");
        $supplierLabel = $this->getText("شرکت", "Supplier");
        $billNoLabel = $this->getText("بیل نمبر", "Bill No");
        $detailsLabel = $this->getText("وضاحت", "Details");
        $dateLabel = $this->getText("نیټه", "Date");

        $data = "<h3 class='text-center'>($supplierName) $title</h3><p class='text-center'>$fromLabel ($from) $toLabel ($to)</p>";
        $data .= '<table class="table table-bordered table-sm"><thead class="table-primary"><tr>';
        $data .= "<th>#</th><th>$supplierLabel</th><th>$billNoLabel</th><th>$detailsLabel</th><th>$totalLabel</th><th>$dateLabel</th>";
        $data .= '</tr></thead><tbody>';

        $i = 1;

        foreach ($purchases as $purchase) {
            $data .= "<tr><td>" . $i . "</td>";
            $data .= "<td>" . $purchase->supplier_name . "</td>";
            $data .= "<td>" . $purchase->bill_id . "</td>";
            $data .= "<td>" . $purchase->details . "</td>";
            $data .= "<td>" . $purchase->amount . ' ' . Currency::find($purchase->currency_id)->name . "</td>";
            $data .= "<td>" . $purchase->purchase_date . "</td></tr>";
            $i++;
        }
        if ($i == 1) {
            $data .= "<tr><td colspan='6' class='text-center'>$noData</td></tr>";
        }
        $data .= "</tbody>";
        $data .= "<tfoot class='table-primary'><th></th><th></th><th></th><th>$totalLabel</th><th>";
        foreach ($totPurchase as $totPur) {
            $data .= $totPur->amount . ' ' . $totPur->currency_name . '<br>';
        }
        $data .= "</th><th></th></tfoot>";
        $data .= "</table>";
        return $data;
    }

    //purchase return report
    public function purchaseReturn()
    {
        $suppliers = Supplier::get();
        return view("report.purchaseReturn", compact("suppliers"));
    }
    
    public function purchaseReturnShow(Request $request)
    {
        $from = $request->fromDate;
        $to =  $request->toDate;
        $supplier_id = $request->supplier_id;
        $isEnglish = ($this->getLanguage() == 'English');

        $supplierName = "";
        if ($supplier_id == 0) {
            $supplierName = $this->getText("ټول شرکتونه", "All Suppliers");
            $returns = DB::table("purchase_return_details as prd")
                ->join("purchase_returns as pr", "prd.purchase_return_id", "pr.id")
                ->join("suppliers as sup", "pr.supplier_id", "sup.id")
                ->join("currencies as cur", "pr.currency_id", "cur.id")
                ->select(DB::raw("pr.id as id,SUM(price*qty) as amount, sup.name as supplier_name,cur.name as currency_name, pr.date as purchase_return_date,pr.details"))
                ->groupBy('pr.id')
                ->whereBetween("pr.date", [$from, $to])
                ->get();
            $totRetun = DB::table("purchase_return_details as prd")
                ->join("purchase_returns as pr", "prd.purchase_return_id", "pr.id")
                ->select(DB::raw("pr.currency_id,SUM(price*qty) as amount"))
                ->groupBy('pr.currency_id')
                ->whereBetween("pr.date", [$from, $to])
                ->get();
        } else {
            $supplierName = Supplier::find($supplier_id)->name;
            $returns = DB::table("purchase_return_details as prd")
                ->join("purchase_returns as pr", "prd.purchase_return_id", "pr.id")
                ->join("suppliers as sup", "pr.supplier_id", "sup.id")
                ->join("currencies as cur", "pr.currency_id", "cur.id")
                ->select(DB::raw("pr.id as id,SUM(price*qty) as amount, sup.name as supplier_name,cur.name as currency_name, pr.date as purchase_return_date,pr.details"))
                ->groupBy('pr.id')
                ->whereBetween("pr.date", [$from, $to])
                ->where("pr.supplier_id", $supplier_id)
                ->get();
            $totRetun = DB::table("purchase_return_details as prd")
                ->join("purchase_returns as pr", "prd.purchase_return_id", "pr.id")
                ->select(DB::raw("pr.currency_id,SUM(price*qty) as amount"))
                ->groupBy('pr.currency_id')
                ->whereBetween("pr.date", [$from, $to])
                ->where("pr.supplier_id", $supplier_id)
                ->get();
        }

        $title = $this->getText("د خریداری د واپسي راپور", "Purchase Return Report");
        $fromLabel = $this->getText("له", "From");
        $toLabel = $this->getText("تر", "To");
        $noData = $this->getText("هیچ معلومات نشته!", "No data Available!");
        $totalLabel = $this->getText("مجموعه", "Total");
        $supplierLabel = $this->getText("شرکت", "Supplier");
        $detailsLabel = $this->getText("وضاحات", "Details");
        $returnNoLabel = $this->getText("د واپسی نمبر", "Return No");
        $dateLabel = $this->getText("نیټه", "Date");

        $data = "<h3 class='text-center'>($supplierName) $title</h3><p class='text-center'>$fromLabel ($from) $toLabel ($to)</p>";
        $data .= '<table class="table table-bordered table-sm"><thead class="table-primary"><tr>';
        $data .= "<th>#</th>";
        $data .= "<th>$supplierLabel</th>";
        $data .= "<th>$detailsLabel</th>";
        $data .= "<th>$returnNoLabel</th>";
        $data .= "<th>$totalLabel</th>";
        $data .= "<th>$dateLabel</th>";
        $data .= '</tr></thead><tbody>';

        $i = 1;
        $totAmount = 0;
        foreach ($returns as $return) {
            $data .= "<tr><td>" . $i . "</td>";
            $data .= "<td>" . $return->supplier_name . "</td>";
            $data .= "<td>" . $return->details . "</td>";
            $data .= "<td>" . $return->id . "</td>";
            $data .= "<td>" . $return->amount . ' ' . $return->currency_name . "</td>";
            $data .= "<td>" . $return->purchase_return_date . "</td></tr>";
            $i++;
        }
        if ($i == 1) {
            $data .= "<tr><td colspan='6' class='text-center'>$noData</td></tr>";
        }
        $data .= "</tbody>";
        $data .= "<tfoot class='table-primary'><th></th><th></th><th></th>";
        $data .= "<th>$totalLabel</th><th>";
        foreach ($totRetun as $totRe) {
            $data .= $totRe->amount . ' ' . Currency::find($totRe->currency_id)->name . '<br>';
        }
        $data .= "</th><th></th></tfoot>";
        $data .= "</table>";
        return $data;
    }

    //payment report
    public function payment()
    {
        $suppliers = Supplier::get();
        return view("report.payment", compact("suppliers"));
    }
    
    public function paymentShow(Request $request)
    {
        $from = $request->fromDate;
        $to =  $request->toDate;
        $supplier_id = $request->supplier_id;
        $isEnglish = ($this->getLanguage() == 'English');

        $supplierName = "";
        if ($supplier_id == 0) {
            $supplierName = $this->getText("ټول شرکتونه", "All Suppliers");
            $payments = Payment::whereBetween("date", [$from, $to])->get();
            $totPayment = Payment::select(DB::raw("IFNULL(SUM(amount),0) as amount,currency_id"))
                ->whereBetween("date", [$from, $to])
                ->groupBy("currency_id")
                ->get();
        } else {
            $supplierName = Supplier::find($supplier_id)->name;
            $payments = Payment::where("supplier_id", $supplier_id)->whereBetween("date", [$from, $to])->get();
            $totPayment = Payment::select(DB::raw("IFNULL(SUM(amount),0) as amount,currency_id"))
                ->whereBetween("date", [$from, $to])
                ->where("supplier_id", $supplier_id)
                ->groupBy("currency_id")
                ->get();
        }

        $title = $this->getText("شرکت ته د وصولی راپور", "Payment Report");
        $fromLabel = $this->getText("له", "From");
        $toLabel = $this->getText("تر", "To");
        $noData = $this->getText("هیچ معلومات نشته!", "No data Available!");
        $totalLabel = $this->getText("مجموعه", "Total");
        $supplierLabel = $this->getText("شرکت", "Supplier");
        $detailsLabel = $this->getText("وضاحت", "Details");
        $amountLabel = $this->getText("مجموعه", "Amount");
        $dateLabel = $this->getText("نیټه", "Date");

        $data = "<h3 class='text-center'>($supplierName) $title</h3><p class='text-center'>$fromLabel ($from) $toLabel ($to)</p>";
        $data .= '<table class="table table-bordered table-sm"><thead class="table-primary"><tr>';
        $data .= "<th>#</th>";
        $data .= "<th>$supplierLabel</th>";
        $data .= "<th>$detailsLabel</th>";
        $data .= "<th>$amountLabel</th>";
        $data .= "<th>$dateLabel</th>";
        $data .= '</tr></thead><tbody>';

        $i = 1;
        $totAmount = 0;
        foreach ($payments as $payment) {
            $totAmount += $payment->amount;
            $data .= "<tr><td>" . $i . "</td>";
            $data .= "<td>" . $payment->supplier->name . "</td>";
            $data .= "<td>" . $payment->details . "</td>";
            $data .= "<td>" . $payment->amount . ' ' . $payment->currency->name . "</td>";
            $data .= "<td>" . $payment->date . "</td></tr>";
            $i++;
        }
        if ($i == 1) {
            $data .= "<tr><td colspan='5' class='text-center'>$noData</td></tr>";
        }
        $data .= "</tbody>";
        $data .= "<tfoot class='table-primary'><th></th><th></th>";
        $data .= "<th>$totalLabel</th><th>";
        foreach ($totPayment as $pay) {
            $data .= $pay->amount . ' ' . Currency::find($pay->currency_id)->name . '<br>';
        }
        $data .=  "</th><th></th></tfoot>";
        $data .= "</table>";
        return $data;
    }

    //sale report
    public function sale()
    {
        $customers = Customer::get();
        return view("report.sale", compact("customers"));
    }
    
    public function saleShow(Request $request)
    {
        $from = $request->fromDate;
        $to =  $request->toDate;
        $customer_id = $request->customer_id;
        $isEnglish = ($this->getLanguage() == 'English');

        $customerName = "";
        if ($customer_id == 0) {
            $customerName = $this->getText("ټول مشتریان", "All Customers");
            $sales = DB::table("sales as s")
                ->join("sale_bills as sb", "s.bill_id", "sb.id")
                ->join("customers as cus", "sb.customer_id", "cus.id")
                ->select(DB::raw("sb.id as bill_id,sb.currency_id,curRate,IFNULL(SUM(price*qty-price*qty*s.discount/100),0) as amount, cus.name as customer_name, sb.date as sale_date,sb.details"))
                ->groupBy('s.bill_id')->orderBy('sb.id', 'desc')
                ->whereBetween("sb.date", [$from, $to])
                ->get();
            $totSale = DB::table("sales as s")
                ->join("sale_bills as sb", "s.bill_id", "sb.id")
                ->select(DB::raw("currency_id,IFNULL(SUM(price*qty-price*qty*s.discount/100),0) as amount"))
                ->groupBy('sb.currency_id')
                ->whereBetween("sb.date", [$from, $to])
                ->get();
        } else {
            $customerName = Customer::find($customer_id)->name;
            $sales = DB::table("sales as s")
                ->join("sale_bills as sb", "s.bill_id", "sb.id")
                ->join("customers as cus", "sb.customer_id", "cus.id")
                ->select(DB::raw("sb.id as bill_id,sb.currency_id,curRate,IFNULL(SUM(price*qty-price*qty*s.discount/100),0) as amount, cus.name as customer_name, sb.date as sale_date,sb.details"))
                ->groupBy('s.bill_id')->orderBy('sb.id', 'desc')
                ->where('sb.customer_id', $customer_id)
                ->whereBetween("sb.date", [$from, $to])
                ->get();
            $totSale = DB::table("sales as s")
                ->join("sale_bills as sb", "s.bill_id", "sb.id")
                ->select(DB::raw("currency_id,IFNULL(SUM(price*qty-price*qty*s.discount/100),0) as amount"))
                ->groupBy('sb.currency_id')
                ->where('sb.customer_id', $customer_id)
                ->whereBetween("sb.date", [$from, $to])
                ->get();
        }

        $title = $this->getText("د خرڅلاو راپور", "Sales Report");
        $fromLabel = $this->getText("له", "From");
        $toLabel = $this->getText("تر", "To");
        $noData = $this->getText("هیچ معلومات نشته!", "No data Available!");
        $totalLabel = $this->getText("مجموعه", "Total");
        $profitLabel = $this->getText("ګټه", "Profit");
        $customerLabel = $this->getText("مشتری", "Customer");
        $billNoLabel = $this->getText("بیل نمبر", "Bill No");
        $detailsLabel = $this->getText("وضاحت", "Details");
        $dateLabel = $this->getText("نیټه", "Date");

        $data = "<h3 class='text-center'>($customerName) $title</h3><p class='text-center'>$fromLabel ($from) $toLabel ($to)</p>";
        $data .= '<table class="table table-bordered table-sm"><thead class="table-primary"><tr>';
        $data .= "<th>#</th>";
        $data .= "<th>$customerLabel</th>";
        $data .= "<th>$billNoLabel</th>";
        $data .= "<th>$detailsLabel</th>";
        $data .= "<th>$totalLabel</th>";
        $data .= "<th>$profitLabel</th>";
        $data .= "<th>$dateLabel</th>";
        $data .= '</tr></thead><tbody>';

        $i = 1;
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

            $data .= "<tr><td>" . $i . "</td>";
            $data .= "<td>" . $sale->customer_name . "</td>";
            $data .= "<td>" . $sale->bill_id . "</td>";
            $data .= "<td>" . $sale->details . "</td>";
            $data .= "<td>" . round($sale->amount, 2) . ' ' . Currency::find($sale->currency_id)->name . "</td>";
            $data .= "<td>" . $profit . ' ' . Currency::first()->name . "</td>";
            $data .= "<td>" . $sale->sale_date . "</td></tr>";
            $i++;
        }
        if ($i == 1) {
            $data .= "<tr><td colspan='7' class='text-center'>$noData</td></tr>";
        }
        $data .= "</tbody>";
        $data .= "<tfoot class='table-primary'><th></th><th></th><th></th><th>$totalLabel</th><th>";
        foreach ($totSale as $totSa) {
            $data .= round($totSa->amount, 2) . ' ' . Currency::find($totSa->currency_id)->name . '<br>';
        }
        $data .= "</th><th>" . $totProfit . ' ' . Currency::first()->name . "</th><th></th></tfoot>";
        $data .= "</table>";
        return $data;
    }

    //sale Return report
    public function saleReturn()
    {
        $customers = Customer::get();
        return view("report.saleReturn", compact("customers"));
    }
    
    public function saleReturnShow(Request $request)
    {
        $from = $request->fromDate;
        $to =  $request->toDate;
        $customer_id = $request->customer_id;
        $isEnglish = ($this->getLanguage() == 'English');

        $customerName = "";
        if ($customer_id == 0) {
            $customerName = $this->getText("ټول مشتریان", "All Customers");
            $returns = DB::table("sale_return_details as srd")
                ->join("sale_returns as sr", "srd.sale_return_id", "sr.id")
                ->join("customers as cus", "sr.customer_id", "cus.id")
                ->join("currencies as cur", "sr.currency_id", "cur.id")
                ->select(DB::raw("sr.id as id,SUM(price*qty) as amount, cus.name as customer_name,cur.name as currency_name, sr.date as sale_return_date,sr.details"))
                ->groupBy('srd.sale_return_id')->orderBy('sr.id', 'desc')
                ->whereBetween("sr.date", [$from, $to])
                ->get();
            $totRetun = DB::table("sale_return_details as srd")
                ->join("sale_returns as sr", "srd.sale_return_id", "sr.id")
                ->select(DB::raw("sr.currency_id,SUM(price*qty) as amount"))
                ->whereBetween("sr.date", [$from, $to])
                ->groupBy("sr.currency_id")
                ->get();
        } else {
            $customerName = Customer::find($customer_id)->name;
            $returns = DB::table("sale_return_details as srd")
                ->join("sale_returns as sr", "srd.sale_return_id", "sr.id")
                ->join("customers as cus", "sr.customer_id", "cus.id")
                ->join("currencies as cur", "sr.currency_id", "cur.id")
                ->select(DB::raw("sr.id as id,SUM(price*qty) as amount, cus.name as customer_name,cur.name as currency_name, sr.date as sale_return_date,sr.details"))
                ->groupBy('srd.sale_return_id')->orderBy('sr.id', 'desc')
                ->where("sr.customer_id", $customer_id)
                ->whereBetween("sr.date", [$from, $to])
                ->get();

            $totRetun = DB::table("sale_return_details as srd")
                ->join("sale_returns as sr", "srd.sale_return_id", "sr.id")
                ->select(DB::raw("sr.currency_id,SUM(price*qty) as amount"))
                ->where("sr.customer_id", $customer_id)
                ->whereBetween("sr.date", [$from, $to])
                ->groupBy("sr.currency_id")
                ->get();
        }

        $title = $this->getText("د خرڅلاو د واپسی راپور", "Sales Return Report");
        $fromLabel = $this->getText("له", "From");
        $toLabel = $this->getText("تر", "To");
        $noData = $this->getText("هیچ معلومات نشته!", "No data Available!");
        $totalLabel = $this->getText("مجموعه", "Total");
        $customerLabel = $this->getText("مشتری", "Customer");
        $detailsLabel = $this->getText("وضاحا", "Details");
        $returnNoLabel = $this->getText("د واپسي نمبر", "Return No");
        $dateLabel = $this->getText("نیټه", "Date");

        $data = "<h3 class='text-center'>($customerName) $title</h3><p class='text-center'>$fromLabel ($from) $toLabel ($to)</p>";
        $data .= '<table class="table table-bordered table-sm"><thead class="table-primary"><tr>';
        $data .= "<th>#</th>";
        $data .= "<th>$customerLabel</th>";
        $data .= "<th>$detailsLabel</th>";
        $data .= "<th>$returnNoLabel</th>";
        $data .= "<th>$totalLabel</th>";
        $data .= "<th>$dateLabel</th>";
        $data .= '</tr></thead><tbody>';

        $i = 1;
        $totAmount = 0;
        foreach ($returns as $return) {
            $totAmount += $return->amount;
            $data .= "<tr><td>" . $i . "</td>";
            $data .= "<td>" . $return->customer_name . "</td>";
            $data .= "<td>" . $return->details . "</td>";
            $data .= "<td>" . $return->id . "</td>";
            $data .= "<td>" . $return->amount . ' ' . $return->currency_name . "</td>";
            $data .= "<td>" . $return->sale_return_date . "</td></tr>";
            $i++;
        }
        if ($i == 1) {
            $data .= "<tr><td colspan='6' class='text-center'>$noData</td></tr>";
        }
        $data .= "</tbody>";
        $data .= "<tfoot class='table-primary'><th></th><th></th><th></th><th>$totalLabel</th><th>";
        foreach ($totRetun as $totRe) {
            $data .= $totRe->amount . ' ' . Currency::find($totRe->currency_id)->name . '<br>';
        }
        $data .= "</th><th></th></tfoot>";
        $data .= "</table>";
        return $data;
    }

    //sale Receipt report
    public function received()
    {
        $customers = Customer::get();
        return view("report.received", compact("customers"));
    }
    
    public function receivedShow(Request $request)
    {
        $from = $request->fromDate;
        $to =  $request->toDate;
        $customer_id = $request->customer_id;
        $isEnglish = ($this->getLanguage() == 'English');

        $customerName = "";
        if ($customer_id == 0) {
            $customerName = $this->getText("ټول مشتریان", "All Customers");
            $receiveds = Received::whereBetween("date", [$from, $to])->get();
            $totReceived = Received::select(DB::raw("IFNULL(SUM(amount),0) as amount,currency_id"))
                ->whereBetween("date", [$from, $to])
                ->groupBy("currency_id")
                ->get();
        } else {
            $customerName = Customer::find($customer_id)->name;
            $receiveds = Received::where("customer_id", $customer_id)->whereBetween("date", [$from, $to])->get();
            $totReceived = Received::select(DB::raw("IFNULL(SUM(amount),0) as amount,currency_id"))
                ->whereBetween("date", [$from, $to])
                ->where("customer_id", $customer_id)
                ->groupBy("currency_id")
                ->get();
        }

        $title = $this->getText("د مشتری د وصولی راپور", "Receipt Report");
        $fromLabel = $this->getText("له", "From");
        $toLabel = $this->getText("تر", "To");
        $noData = $this->getText("هیچ معلومات نشته!", "No data Available!");
        $totalLabel = $this->getText("مجموعه", "Total");
        $customerLabel = $this->getText("مشتری", "Customer");
        $receiptNoLabel = $this->getText("رسید نمبر", "Receipt No");
        $detailsLabel = $this->getText("وضاحت", "Details");
        $amountLabel = $this->getText("مجموعه", "Amount");
        $dateLabel = $this->getText("نیټه", "Date");

        $data = "<h3 class='text-center'>($customerName) $title</h3><p class='text-center'>$fromLabel ($from) $toLabel ($to)</p>";
        $data .= '<table class="table table-bordered table-sm"><thead class="table-primary"><tr>';
        $data .= "<th>#</th>";
        $data .= "<th>$customerLabel</th>";
        $data .= "<th>$receiptNoLabel</th>";
        $data .= "<th>$detailsLabel</th>";
        $data .= "<th>$amountLabel</th>";
        $data .= "<th>$dateLabel</th>";
        $data .= '</tr></thead><tbody>';

        $i = 1;
        $totAmount = 0;
        foreach ($receiveds as $received) {
            $totAmount += $received->amount;
            $data .= "<tr><td>" . $i . "</td>";
            $data .= "<td>" . $received->customer->name . "</td>";
            $data .= "<td>" . $received->rasid_no . "</td>";
            $data .= "<td>" . $received->details . "</td>";
            $data .= "<td>" . $received->amount . ' ' . Currency::find($received->currency_id)->name . "</td>";
            $data .= "<td>" . $received->date . "</td></tr>";
            $i++;
        }
        if ($i == 1) {
            $data .= "<tr><td colspan='6' class='text-center'>$noData</td></tr>";
        }
        $data .= "</tbody>";
        $data .= "<tfoot class='table-primary'><th></th><th></th><th></th><th>$totalLabel</th><th>";
        foreach ($totReceived as $totRec) {
            $data .= $totRec->amount . ' ' . Currency::find($totRec->currency_id)->name . '<br>';
        }
        $data .= "</th><th></th></tfoot>";
        $data .= "</table>";
        return $data;
    }

    //Expense report
    public function expense()
    {
        $expenseCategories = ExpenseCategory::get();
        return view("report.expense", compact("expenseCategories"));
    }
    
    public function expenseShow(Request $request)
    {
        $from = $request->fromDate;
        $to =  $request->toDate;
        $category_id = $request->category_id;
        $isEnglish = ($this->getLanguage() == 'English');

        $categoryName = "";
        if ($category_id == 0) {
            $categoryName = $this->getText("ټول ډولونه", "All Categories");
            $expenses = Expense::whereBetween("date", [$from, $to])->get();
            $totExpenses = Expense::select(DB::raw("IFNULL(SUM(amount),0) as amount,currency_id"))
                ->whereBetween("date", [$from, $to])
                ->groupBy("currency_id")
                ->get();
        } else {
            $categoryName = ExpenseCategory::find($category_id)->name;
            $expenses = Expense::where("expense_category_id", $category_id)->whereBetween("date", [$from, $to])->get();
            $totExpenses = Expense::select(DB::raw("IFNULL(SUM(amount),0) as amount,currency_id"))
                ->whereBetween("date", [$from, $to])
                ->where("expense_category_id", $category_id)
                ->groupBy("currency_id")
                ->get();
        }

        $title = $this->getText("د مصارفو راپور", "Expense Report");
        $fromLabel = $this->getText("له", "From");
        $toLabel = $this->getText("تر", "To");
        $noData = $this->getText("هیچ معلومات نشته!", "No data Available!");
        $totalLabel = $this->getText("مجموعه", "Total");
        $categoryLabel = $this->getText("د مصرف ډول", "Category");
        $detailsLabel = $this->getText("وضاحت", "Details");
        $amountLabel = $this->getText("مجموعه", "Amount");
        $dateLabel = $this->getText("نیټه", "Date");

        $data = "<h3 class='text-center'>($categoryName) $title</h3><p class='text-center'>$fromLabel ($from) $toLabel ($to)</p>";
        $data .= '<table class="table table-bordered table-sm"><thead class="table-primary"><tr>';
        $data .= "<th>#</th>";
        $data .= "<th>$categoryLabel</th>";
        $data .= "<th>$detailsLabel</th>";
        $data .= "<th>$amountLabel</th>";
        $data .= "<th>$dateLabel</th>";
        $data .= '</tr></thead><tbody>';

        $i = 1;
        $totAmount = 0;
        foreach ($expenses as $expense) {
            $totAmount += $expense->amount;
            $data .= "<tr><td>" . $i . "</td>";
            $data .= "<td>" . $expense->expenseCategory->name . "</td>";
            $data .= "<td>" . $expense->details . "</td>";
            $data .= "<td>" . $expense->amount . ' ' . Currency::find($expense->currency_id)->name . "</td>";
            $data .= "<td>" . $expense->date . "</td></tr>";
            $i++;
        }
        if ($i == 1) {
            $data .= "<tr><td colspan='5' class='text-center'>$noData</td></tr>";
        }
        $data .= "</tbody>";
        $data .= "<tfoot class='table-primary'><th></th><th></th><th>$totalLabel</th><th>";
        foreach ($totExpenses as $totExp) {
            $data .= $totExp->amount . ' ' . Currency::find($totExp->currency_id)->name . '<br>';
        }
        $data .= "</th><th></th></tfoot>";
        $data .= "</table>";
        return $data;
    }

    //Summary report
    public function summery()
    {
        return view("report.summery");
    }

    public function summeryShow(Request $request)
    {
        $from = $request->fromDate;
        $to =  $request->toDate;
        $includeExp =  $request->includeExp;
        $isEnglish = ($this->getLanguage() == 'English');

        $sales = DB::table("sales as s")
            ->join("sale_bills as sb", "s.bill_id", "sb.id")
            ->select(DB::raw("IFNULL(SUM((price*qty-price*qty*s.discount/100)/curRate),0) as amount"))
            ->whereBetween("sb.date", [$from, $to])
            ->first();
        $cogs = DB::table("sales as s")
            ->join("sale_bills as sb", "s.bill_id", "sb.id")
            ->select(DB::raw("IFNULL(SUM(pprice*qty/curRate),0) as amount"))
            ->whereBetween("sb.date", [$from, $to])
            ->first();

        $returns =  $totRetun = DB::table("sale_return_details as srd")
            ->join("sale_returns as sr", "srd.sale_return_id", "sr.id")
            ->select(DB::raw("sr.currency_id,SUM(price*qty) as amount"))
            ->whereBetween("sr.date", [$from, $to])
            ->first();

        $expenses = Expense::select(DB::raw("IFNULL(SUM(amount/curRate),0) as amount"))
            ->whereBetween("date", [$from, $to])->first();

        $netSales = $sales->amount - $returns->amount;
        $profit = $netSales - $cogs->amount;

        $title = $this->getText("خلص راپور", "Summary Report");
        $currencyName = Currency::first()->name;
        $descLabel = $this->getText("Desc", "Description");
        $amountLabel = $this->getText("مجموعه", "Amount");
        $totalSalesLabel = $this->getText("Total Sales", "Total Sales");
        $cogsLabel = $this->getText("Cost Of Good Sold", "Cost of Goods Sold");
        $profitLabel = $this->getText("Total Profit", "Total Profit");
        $expenseLabel = $this->getText("Expense", "Expense");
        $netLabel = $this->getText("Net Profit/Lost", "Net Profit/Loss");

        $data = "<h3 class='text-center'>$title (" . $from . ") - (" . $to . ")</h3>";
        $data .= "<table class='table table-bordered table-sm'><thead class='table-primary'><tr>";
        $data .= "<th>$descLabel</th>";
        $data .= "<th>$amountLabel(" . $currencyName . ")</th>";
        $data .= "</tr></thead><tbody>";

        $data .= "<tr><td>$totalSalesLabel</td><td>" . round($netSales, 2) . "</td></tr>";
        $data .= "<tr><td>$cogsLabel</td><td>" . round($cogs->amount, 2) . "</td></tr>";
        $data .= "<tr><td>$profitLabel</td><td>" . round($profit, 2) . "</td></tr>";
        $data .= "<tr><td>$expenseLabel</td><td>" . round($expenses->amount, 2) . "</td></tr>";
        $data .= "</tbody><tfoot class='table-primary'><tr><th>$netLabel</th><th>" . round($profit - $expenses->amount, 2) . "</th></tr>";
        $data .= "</tfoot></table>";

        return $data;
    }

    //Cash Flow report
    public function cash()
    {
        $currencies = Currency::get();
        return view("report.cash", compact("currencies"));
    }
    
    public function cashShow(Request $request)
    {
        $from = $request->fromDate;
        $to =  $request->toDate;
        $currency_id =  $request->currency_id;
        $currency = Currency::find($currency_id);

        $receiveds = Received::whereBetween("date", [$from, $to])->where('currency_id', $currency_id)->get();
        $payments = Payment::whereBetween("date", [$from, $to])->where('currency_id', $currency_id)->get();
        $expenses = Expense::whereBetween("date", [$from, $to])->where('currency_id', $currency_id)->get();
        $cashes = Cash::whereBetween("date", [$from, $to])->where('currency_id', $currency_id)->get();

        $purchaseCashReturns = DB::table("purchase_return_details as prd")
            ->join("purchase_returns as pr", "prd.purchase_return_id", "pr.id")
            ->join("suppliers as sup", "pr.supplier_id", "sup.id")
            ->join("currencies as cur", "pr.currency_id", "cur.id")
            ->select(DB::raw("pr.id as id,SUM(price*qty) as amount, sup.name as supplier_name,cur.name as currency_name, pr.date as purchase_return_date,pr.details,pr.created_at"))
            ->where(['pr.currency_id' => $currency_id, "pr.isCash" => 1])
            ->groupBy('pr.id')->get();
            
        $saleCashReturns = DB::table("sale_return_details as srd")
            ->join("sale_returns as sr", "srd.sale_return_id", "sr.id")
            ->join("customers as cus", "sr.customer_id", "cus.id")
            ->join("currencies as cur", "sr.currency_id", "cur.id")
            ->select(DB::raw("sr.id as id,SUM(price*qty) as amount, cus.name as customer_name,cur.name as currency_name, sr.date as sale_return_date,sr.details,sr.created_at"))
            ->groupBy('srd.sale_return_id')->orderBy('sr.id', 'desc')
            ->where(['sr.currency_id' => $currency_id, 'isCash' => 1])
            ->get();

        return view("report.cashShow", compact("from", "to", "receiveds", "payments", "expenses", "cashes", "currency", "purchaseCashReturns", "saleCashReturns"));
    }

    public function itemShow(Request $request)
    {
        $from = $request->fromDate;
        $to =  $request->toDate;
        $item_id =  $request->item_id;
        $item = Item::find($item_id);
        // This method is incomplete in original code
        return view("report.itemShow", compact("from", "to", "item"));
    }

    // public function asset()
    // {
    //     $setting = Setting::orderBy("id", "desc")->first();
    //     $items = Item::get();
    //     $suppliers = Supplier::get();
    //     $customers = Customer::get();
    //     $currencies = Currency::get();
    
    //     /*
    //     |--------------------------------------------------------------------------
    //     | Stock Amount
    //     |--------------------------------------------------------------------------
    //     */
    
    //     $stockAmount = 0;
    
    //     foreach ($items as $item) {
    
    //         $currentQty = FunctionController::itemQty($item->id);
    
    //         // Prevent division by zero
    //         if ((float) $item->curRate == 0) {
    //             continue;
    //         }
    
    //         $cost = $item->pprice / $item->curRate;
    
    //         $stockAmount += ($currentQty * $cost);
    //     }
    
    
    //     /*
    //     |--------------------------------------------------------------------------
    //     | Payables
    //     |--------------------------------------------------------------------------
    //     */
    
    //     $payables = 0;
    
    //     foreach ($currencies as $currency) {
    
    //         // Prevent division by zero
    //         if ((float) $currency->rate == 0) {
    //             continue;
    //         }
    
    //         $openPayable = OpenPayable::where([
    //             'currency_id' => $currency->id
    //         ])->sum('amount');
    
    //         $totPurchase = FunctionController::totPurchase(
    //             0,
    //             $currency->id
    //         );
    
    //         $totReturn = FunctionController::totPurchaseReturn(
    //             0,
    //             $currency->id
    //         );
    
    //         $totPayment = Payment::where([
    //             'currency_id' => $currency->id
    //         ])->sum('amount');
    
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | Cash Purchase Returns
    //         |--------------------------------------------------------------------------
    //         */
    
    //         $cashPurchaseReturns = DB::table("purchase_return_details as prd")
    //             ->join(
    //                 "purchase_returns as pr",
    //                 "prd.purchase_return_id",
    //                 "pr.id"
    //             )
    //             ->where([
    //                 'pr.currency_id' => $currency->id,
    //                 'pr.isCash' => 1
    //             ])
    //             ->sum(DB::raw('price * qty'));
    
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | Calculate Payable
    //         |--------------------------------------------------------------------------
    //         */
    
    //         $payableAmount =
    //             $openPayable +
    //             $totPurchase +
    //             $cashPurchaseReturns -
    //             $totReturn -
    //             $totPayment;
    
    //         $payables += $payableAmount / $currency->rate;
    //     }
    
    
    //     /*
    //     |--------------------------------------------------------------------------
    //     | Receivables
    //     |--------------------------------------------------------------------------
    //     */
    
    //     $receivables = 0;
    
    //     foreach ($currencies as $currency) {
    
    //         // Prevent division by zero
    //         if ((float) $currency->rate == 0) {
    //             continue;
    //         }
    
    //         $openReceivable = OpenReceivable::where([
    //             'currency_id' => $currency->id
    //         ])->sum('amount');
    
    //         $totSale = FunctionController::totSale(
    //             0,
    //             $currency->id
    //         );
    
    //         $totReturn = FunctionController::totSaleReturn(
    //             0,
    //             $currency->id
    //         );
    
    //         $totReceived = Received::where([
    //             'currency_id' => $currency->id
    //         ])->sum('amount');
    
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | Cash Sale Returns
    //         |--------------------------------------------------------------------------
    //         */
    
    //         $cashSaleReturns = DB::table("sale_return_details as srd")
    //             ->join(
    //                 "sale_returns as sr",
    //                 "srd.sale_return_id",
    //                 "sr.id"
    //             )
    //             ->where([
    //                 'sr.currency_id' => $currency->id,
    //                 'sr.isCash' => 1
    //             ])
    //             ->sum(DB::raw('price * qty'));
    
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | Calculate Receivable
    //         |--------------------------------------------------------------------------
    //         */
    
    //         $receivableAmount =
    //             $openReceivable +
    //             $totSale +
    //             $cashSaleReturns -
    //             $totReturn -
    //             $totReceived;
    
    //         $receivables += $receivableAmount / $currency->rate;
    //     }
    
    
    //     /*
    //     |--------------------------------------------------------------------------
    //     | Cash Capital
    //     |--------------------------------------------------------------------------
    //     */
    
    //     $cashCapital = 0;
    
    //     foreach ($currencies as $currency) {
    
    //         // Prevent division by zero
    //         if ((float) $currency->rate == 0) {
    //             continue;
    //         }
    
    //         $currency_id = $currency->id;
    
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | Received
    //         |--------------------------------------------------------------------------
    //         */
    
    //         $receiveds = Received::where(
    //             'currency_id',
    //             $currency_id
    //         )->sum("amount");
    
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | Payments
    //         |--------------------------------------------------------------------------
    //         */
    
    //         $payments = Payment::where(
    //             'currency_id',
    //             $currency_id
    //         )->sum("amount");
    
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | Expenses
    //         |--------------------------------------------------------------------------
    //         */
    
    //         $expenses = Expense::where(
    //             'currency_id',
    //             $currency_id
    //         )->sum("amount");
    
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | Cash
    //         |--------------------------------------------------------------------------
    //         */
    
    //         $cashes = Cash::where(
    //             'currency_id',
    //             $currency_id
    //         )->sum("amount");
    
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | Cash Sale Returns
    //         |--------------------------------------------------------------------------
    //         */
    
    //         $cashSaleReturns = DB::table("sale_return_details as srd")
    //             ->join(
    //                 "sale_returns as sr",
    //                 "srd.sale_return_id",
    //                 "sr.id"
    //             )
    //             ->where([
    //                 'sr.currency_id' => $currency_id,
    //                 'sr.isCash' => 1
    //             ])
    //             ->sum(DB::raw('price * qty'));
    
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | Cash Purchase Returns
    //         |--------------------------------------------------------------------------
    //         */
    
    //         $cashPurchaseReturns = DB::table("purchase_return_details as prd")
    //             ->join(
    //                 "purchase_returns as pr",
    //                 "prd.purchase_return_id",
    //                 "pr.id"
    //             )
    //             ->where([
    //                 'pr.currency_id' => $currency_id,
    //                 'pr.isCash' => 1
    //             ])
    //             ->sum(DB::raw('price * qty'));
    
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | Calculate Current Cash
    //         |--------------------------------------------------------------------------
    //         */
    
    //         $currentCash =
    //             $cashes +
    //             $receiveds -
    //             $payments -
    //             $expenses -
    //             $cashSaleReturns +
    //             $cashPurchaseReturns;
    
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | Convert To Main Currency
    //         |--------------------------------------------------------------------------
    //         */
    
    //         $cashCapital += $currentCash / $currency->rate;
    //     }
    
    
    //     /*
    //     |--------------------------------------------------------------------------
    //     | Return Asset Report
    //     |--------------------------------------------------------------------------
    //     */
    
    //     return view(
    //         "report.asset",
    //         compact(
    //             "setting",
    //             "stockAmount",
    //             "payables",
    //             "receivables",
    //             "cashCapital"
    //         )
    //     );
    // }
    


    public function asset()
    {
        $setting = Setting::orderBy("id", "desc")->first();
        $items = Item::get();
        $suppliers = Supplier::get();
        $customers = Customer::get();
        $currencies = Currency::get();

        $stockAmount = 0;
        foreach ($items as $item) {
            $currentQty = FunctionController::itemQty($item->id);
            $cost = $item->pprice / $item->curRate;
            $stockAmount += ($currentQty * $cost);
        }

        $payables = 0;
        foreach ($currencies as $currency) {
            $openPayable = OpenPayable::where(['currency_id' => $currency->id])->sum('amount');
            $totPurchase = FunctionController::totPurchase(0, $currency->id);
            $totReturn = FunctionController::totPurchaseReturn(0, $currency->id);
            $totPayment = Payment::where(['currency_id' => $currency->id])->sum('amount');
            
            $cashPurchaseReturns = DB::table("purchase_return_details as prd")
                ->join("purchase_returns as pr", "prd.purchase_return_id", "pr.id")
                ->join("suppliers as sup", "pr.supplier_id", "sup.id")
                ->join("currencies as cur", "pr.currency_id", "cur.id")
                ->select(DB::raw("pr.id as id,SUM(price*qty) as amount, sup.name as supplier_name,cur.name as currency_name, pr.date as purchase_return_date,pr.details,pr.created_at"))
                ->where(['pr.currency_id' => $currency->id, "pr.isCash" => 1])
                ->first();
                
            $cashPurchaseAmount = $cashPurchaseReturns ? $cashPurchaseReturns->amount : 0;
            $payables += ($openPayable + $totPurchase + $cashPurchaseAmount - $totReturn - $totPayment) / $currency->rate;
        }

        $receivables = 0;
        foreach ($currencies as $currency) {
            $openReceivable = OpenReceivable::where(['currency_id' => $currency->id])->sum('amount');
            $totSale = FunctionController::totSale(0, $currency->id);
            $totReturn = FunctionController::totSaleReturn(0, $currency->id);
            $totReceived = Received::where(['currency_id' => $currency->id])->sum('amount');

            $cashSaleReturns = DB::table("sale_return_details as srd")
                ->join("sale_returns as sr", "srd.sale_return_id", "sr.id")
                ->join("customers as cus", "sr.customer_id", "cus.id")
                ->join("currencies as cur", "sr.currency_id", "cur.id")
                ->select(DB::raw("sr.id as id,SUM(price*qty) as amount, cus.name as customer_name,cur.name as currency_name, sr.date as sale_return_date,sr.details,sr.created_at"))
                ->where(['sr.currency_id' => $currency->id, 'isCash' => 1])
                ->first();
                
            $cashSaleAmount = $cashSaleReturns ? $cashSaleReturns->amount : 0;
            $receivables += ($openReceivable + $totSale + $cashSaleAmount - $totReturn - $totReceived) / $currency->rate;
        }
        
        $cashCapital = 0;
        foreach ($currencies as $currency) {
            $currency_id = $currency->id;

            $receiveds = Received::where('currency_id', $currency_id)->sum("amount");
            $payments = Payment::where('currency_id', $currency_id)->sum("amount");
            $expenses = Expense::where('currency_id', $currency_id)->sum("amount");
            $cashes = Cash::where('currency_id', $currency_id)->sum("amount");

            $cashSaleReturns = DB::table("sale_return_details as srd")
                ->join("sale_returns as sr", "srd.sale_return_id", "sr.id")
                ->join("customers as cus", "sr.customer_id", "cus.id")
                ->join("currencies as cur", "sr.currency_id", "cur.id")
                ->select(DB::raw("sr.id as id,SUM(price*qty) as amount, cus.name as customer_name,cur.name as currency_name, sr.date as sale_return_date,sr.details,sr.created_at"))
                ->where(['sr.currency_id' => $currency_id, 'isCash' => 1])
                ->first();
                
            $cashSaleReturnAmount = $cashSaleReturns ? $cashSaleReturns->amount : 0;
            
            $cashPurchaseReturns = DB::table("purchase_return_details as prd")
                ->join("purchase_returns as pr", "prd.purchase_return_id", "pr.id")
                ->join("suppliers as sup", "pr.supplier_id", "sup.id")
                ->join("currencies as cur", "pr.currency_id", "cur.id")
                ->select(DB::raw("pr.id as id,SUM(price*qty) as amount, sup.name as supplier_name,cur.name as currency_name, pr.date as purchase_return_date,pr.details,pr.created_at"))
                ->where(['pr.currency_id' => $currency_id, "pr.isCash" => 1])
                ->first();
                
            $cashPurchaseReturnAmount = $cashPurchaseReturns ? $cashPurchaseReturns->amount : 0;

            $currentCash = $cashes + $receiveds - $payments - $expenses - $cashSaleReturnAmount + $cashPurchaseReturnAmount;
            $cashCapital += $currentCash / $currency->rate;
        }

        return view("report.asset", compact("setting", "stockAmount", "payables", "receivables", "cashCapital"));
    }

    //Item Report
    public function item()
    {
        $items = Item::get();
        $customers = Customer::get();
        $suppliers = Supplier::get();
        return view("report.item", compact("items", "customers", "suppliers"));
    }

    public function itemPurchaseShow(Request $request)
    {
        $item_id = $request->item_id;
        $supplier_id = $request->supplier_id;
        $from = $request->fromDate;
        $to =  $request->toDate;
        $isEnglish = ($this->getLanguage() == 'English');

        $supplierName = "";
        if ($supplier_id == 0) {
            $supplierName = $this->getText("ټول شرکتونه", "All Suppliers");
            $purchases = DB::table("purchases as p")
                ->join("purchase_bills as pb", "p.bill_id", "pb.id")
                ->join("suppliers as sup", "pb.supplier_id", "sup.id")
                ->join("items as i", "p.item_id", "i.id")
                ->select(DB::raw("pb.id as bill_id,pb.currency_id,p.pprice,p.qty,i.name as item_name, sup.name as supplier_name, pb.date as purchase_date,pb.details"))
                ->orderBy('pb.id', 'desc')
                ->whereBetween('pb.date', [$from, $to])
                ->where(['p.item_id' => $item_id])
                ->get();
        } else {
            $supplierName = Supplier::find($supplier_id)->name;
            $purchases = DB::table("purchases as p")
                ->join("purchase_bills as pb", "p.bill_id", "pb.id")
                ->join("suppliers as sup", "pb.supplier_id", "sup.id")
                ->join("items as i", "p.item_id", "i.id")
                ->select(DB::raw("pb.id as bill_id,pb.currency_id,p.pprice,p.qty,i.name as item_name, sup.name as supplier_name, pb.date as purchase_date,pb.details"))
                ->orderBy('pb.id', 'desc')
                ->whereBetween('pb.date', [$from, $to])
                ->where(["pb.supplier_id" => $supplier_id, 'p.item_id' => $item_id])
                ->get();
        }

        $title = $this->getText("د جنس له مخې د خریداری راپور", "Item Purchase Report");
        $fromLabel = $this->getText("له", "From");
        $toLabel = $this->getText("تر", "To");
        $noData = $this->getText("هیچ معلومات نشته!", "No data Available!");
        
        $supplierLabel = $this->getText("شرکت", "Supplier");
        $billNoLabel = $this->getText("بیل نمبر", "Bill No");
        $itemLabel = $this->getText("جنس", "Item");
        $qtyLabel = $this->getText("تعداد", "Quantity");
        $priceLabel = $this->getText("د خرید قیمت", "Purchase Price");
        $dateLabel = $this->getText("نیټه", "Date");

        $data = "<h3 class='text-center'>($supplierName) $title</h3><p class='text-center'>$fromLabel ($from) $toLabel ($to)</p>";
        $data .= '<table class="table table-bordered table-sm"><thead class="table-primary"><tr>';
        $data .= "<th>#</th>";
        $data .= "<th>$supplierLabel</th>";
        $data .= "<th>$billNoLabel</th>";
        $data .= "<th>$itemLabel</th>";
        $data .= "<th>$qtyLabel</th>";
        $data .= "<th>$priceLabel</th>";
        $data .= "<th>$dateLabel</th>";
        $data .= '</tr></thead><tbody>';

        $i = 1;

        foreach ($purchases as $purchase) {
            $data .= "<tr><td>" . $i . "</td>";
            $data .= "<td>" . $purchase->supplier_name . "</td>";
            $data .= "<td>" . $purchase->bill_id . "</td>";
            $data .= "<td>" . $purchase->item_name . "</td>";
            $data .= "<td>" . $purchase->qty . "</td>";
            $data .= "<td>" . $purchase->pprice . ' ' . Currency::find($purchase->currency_id)->name . "</td>";
            $data .= "<td>" . $purchase->purchase_date . "</td></tr>";
            $i++;
        }
        if ($i == 1) {
            $data .= "<tr><td colspan='8' class='text-center'>$noData</td></tr>";
        }
        $data .= "</tbody></table>";
        return $data;
    }
    
    public function itemSaleShow(Request $request)
    {
        $item_id = $request->item_id;
        $customer_id = $request->customer_id;
        $from = $request->fromDate;
        $to =  $request->toDate;
        $isEnglish = ($this->getLanguage() == 'English');

        $customerName = "";
        if ($customer_id == 0) {
            $customerName = $this->getText("ټول مشتریان", "All Customers");
            $sales = DB::table("sales as s")
                ->join("sale_bills as sb", "s.bill_id", "sb.id")
                ->join("customers as cus", "sb.customer_id", "cus.id")
                ->join("items as i", "s.item_id", "i.id")
                ->select(DB::raw("sb.id as bill_id,sb.currency_id,s.price,s.qty,i.name as item_name, cus.name as customer_name, sb.date as sale_date,sb.details"))
                ->orderBy('sb.id', 'desc')
                ->whereBetween("sb.date", [$from, $to])
                ->where(['s.item_id' => $item_id])
                ->get();
        } else {
            $customerName = Customer::find($customer_id)->name;
            $sales = DB::table("sales as s")
                ->join("sale_bills as sb", "s.bill_id", "sb.id")
                ->join("customers as cus", "sb.customer_id", "cus.id")
                ->join("items as i", "s.item_id", "i.id")
                ->select(DB::raw("sb.id as bill_id,sb.currency_id,s.price,s.qty,i.name as item_name, cus.name as customer_name, sb.date as sale_date,sb.details"))
                ->orderBy('sb.id', 'desc')
                ->whereBetween("sb.date", [$from, $to])
                ->where(['s.item_id' => $item_id, "sb.customer_id" => $customer_id])
                ->get();
        }

        $title = $this->getText("د جنس له مخې د خرڅلاو راپور", "Item Sales Report");
        $fromLabel = $this->getText("له", "From");
        $toLabel = $this->getText("تر", "To");
        $noData = $this->getText("هیچ معلومات نشته!", "No data Available!");
        
        $customerLabel = $this->getText("مشتری", "Customer");
        $billNoLabel = $this->getText("بیل نمبر", "Bill No");
        $itemLabel = $this->getText("جنس", "Item");
        $qtyLabel = $this->getText("تعداد", "Quantity");
        $priceLabel = $this->getText("قیمت", "Price");
        $dateLabel = $this->getText("نیټه", "Date");

        $data = "<h3 class='text-center'>($customerName) $title</h3><p class='text-center'>$fromLabel ($from) $toLabel ($to)</p>";
        $data .= '<table class="table table-bordered table-sm"><thead class="table-primary"><tr>';
        $data .= "<th>#</th>";
        $data .= "<th>$customerLabel</th>";
        $data .= "<th>$billNoLabel</th>";
        $data .= "<th>$itemLabel</th>";
        $data .= "<th>$qtyLabel</th>";
        $data .= "<th>$priceLabel</th>";
        $data .= "<th>$dateLabel</th>";
        $data .= '</tr></thead><tbody>';

        $i = 1;
        foreach ($sales as $sale) {
            $data .= "<tr><td>" . $i . "</td>";
            $data .= "<td>" . $sale->customer_name . "</td>";
            $data .= "<td>" . $sale->bill_id . "</td>";
            $data .= "<td>" . $sale->item_name . "</td>";
            $data .= "<td>" . $sale->qty . "</td>";
            $data .= "<td>" . $sale->price . ' ' . Currency::find($sale->currency_id)->name . "</td>";
            $data .= "<td>" . $sale->sale_date . "</td></tr>";
            $i++;
        }
        if ($i == 1) {
            $data .= "<tr><td colspan='7' class='text-center'>$noData</td></tr>";
        }
        $data .= "</tbody></table>";

        return $data;
    }

    public function expire()
    {
        return view("report.expire");
    }
    
    public function expireShow(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $isEnglish = ($this->getLanguage() == 'English');

        $items = Item::get();
        
        $title = $this->getText("د ایکسپایر راپور", "Expiry Report");
        $fromLabel = $this->getText("له", "From");
        $toLabel = $this->getText("تر", "To");
        $noData = $this->getText("هیچ معلومات نشته!", "No data Available!");
        
        $itemLabel = $this->getText("جنس", "Item");
        $expireLabel = $this->getText("Expire Date", "Expire Date");
        $qtyLabel = $this->getText("تعداد", "Quantity");

        $data = "<h3 class='text-center'>$title $fromLabel ($from) $toLabel ($to)</h3>";
        $data .= '<table class="table table-bordered table-sm"><thead class="table-primary"><tr>';
        $data .= "<th>#</th>";
        $data .= "<th>$itemLabel</th>";
        $data .= "<th>$expireLabel</th>";
        $data .= "<th>$qtyLabel</th>";
        $data .= '</tr></thead><tbody>';
        
        $i=1;
        foreach ($items as $item) {
            $qty = FunctionController::itemQty($item->id);
            if ($qty > 0) {
                $expDate=FunctionController::itemExpDate($item->id);

                if($expDate>=$from && $expDate<=$to){
                    $data.="<tr>";
                    $data.="<td>".$i."</td>";
                    $data.="<td>".$item->name."</td>";
                    $data.="<td>".$expDate."</td>";
                    $data.="<td>".$qty."</td>";
                    $data.="</tr>";
                    $i++;
                }
            }
        }
        
        if ($i == 1) {
            $data .= "<tr><td colspan='4' class='text-center'>$noData</td></tr>";
        }

        $data .= "</tbody></table>";

        return $data;
    }
}