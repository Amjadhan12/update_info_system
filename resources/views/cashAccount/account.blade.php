@extends('layouts.admin')
@section('title', 'Cash Accounts')

@if (Auth::user()->language == 'Pashto')
    @section('body')
        <style>

        </style>
        <main class="p-3">
            <div class="container-flued">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-sm  mb-5 bg-white rounded">
                            <div class="card-header bg-primary bg-gradient">
                                <h4 class="text-white"><i class="fa fa-list"></i> د نغدو حساب</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive p-1">
                                    <table class="table table-bordered table-sm table-striped table-hover data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>ID</th>
                                                <th>د حساب نوم</th>
                                                <th>لومړني اندازه</th>
                                                <th>د مشتریانو وصولی</th>
                                                <th>د خرڅلاو نغدو واپسي</th>
                                                <th>د شرکت وصولی</th>
                                                <th>د خریداری نغدو واپسي</th>
                                                <th>مصارف</th>
                                                <th>بل حساب ته انتقال</th>
                                                <th>دې حساب ته انتقال</th>
                                                <th>نتیجه</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl_data">
                                            <?php
                                            $grandAmount = 0;
                                            ?>
                                            @foreach ($cashAccounts as $cashAccount)

                                                <tr class="data_tr" data-id="{{ $cashAccount->id }}">
                                                    <td>{{ $cashAccount->id }}</td>
                                                    <td>{{ $cashAccount->name }}</td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $cash = App\Models\Cash::where(['cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            echo $cash . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $received = App\Models\Received::where(['cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            echo $received . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $cashSaleReturn = DB::table('sale_return_details as srd')
                                                                ->join('sale_returns as sr', 'srd.sale_return_id', 'sr.id')
                                                                ->select(DB::raw('IFNULL(SUM(price*qty),0) as amount'))
                                                                ->where(['sr.cash_account_id' => $cashAccount->id, 'sr.currency_id' => $currency->id, 'sr.isCash' => 1])
                                                                ->first()->amount;
                                                            echo $cashSaleReturn . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $payment = App\Models\Payment::where(['cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            echo $payment . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $cashPurchaseReturn = DB::table('purchase_return_details as prd')
                                                                ->join('purchase_returns as pr', 'prd.purchase_return_id', 'pr.id')
                                                                ->select(DB::raw('IFNULL(SUM(price*qty),0) as amount'))
                                                                ->where(['pr.cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id, 'pr.isCash' => 1])
                                                                ->first()->amount;
                                                            echo $cashPurchaseReturn . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $expenses = App\Models\Expense::where(['cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            echo $expenses . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $transferIn = App\Models\CashTransfer::where(['to_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            echo $transferIn . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $transferOut = App\Models\CashTransfer::where(['from_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            echo $transferOut . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $cash = App\Models\Cash::where(['cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            $received = App\Models\Received::where(['cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            $payment = App\Models\Payment::where(['cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            $expenses = App\Models\Expense::where(['cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            $transferIn = App\Models\CashTransfer::where(['to_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            $transferOut = App\Models\CashTransfer::where(['from_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            $cashSaleReturn = DB::table('sale_return_details as srd')
                                                                ->join('sale_returns as sr', 'srd.sale_return_id', 'sr.id')
                                                                ->select(DB::raw('IFNULL(SUM(price*qty),0) as amount'))
                                                                ->where(['sr.cash_account_id' => $cashAccount->id, 'sr.currency_id' => $currency->id, 'sr.isCash' => 1])
                                                                ->first()->amount;
                                                            $cashPurchaseReturn = DB::table('purchase_return_details as prd')
                                                                ->join('purchase_returns as pr', 'prd.purchase_return_id', 'pr.id')
                                                                ->select(DB::raw('IFNULL(SUM(price*qty),0) as amount'))
                                                                ->where(['pr.cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id, 'pr.isCash' => 1])
                                                                ->first()->amount;
                                                            
                                                            echo $cash + $received - $payment - $expenses + $transferIn - $transferOut + $cashPurchaseReturn - $cashSaleReturn . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Modal -->
        <div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Select Currency</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body table-responsive">
                        <div class="form-group mb-3">
                            <label for="currency_id">کرنسي انتخاب کړئ</label>
                            <select name="currency_id" id="currency_id" class="form-control">
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" id="btn_check">کتل</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="accountShowModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">د نغدو حساب کتل</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body table-responsive">
                        <div class="print_div"></div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@else
    @section('body')
        <style>

        </style>
        <main class="p-3">
            <div class="container-flued">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-sm  mb-5 bg-white rounded">
                            <div class="card-header bg-primary bg-gradient">
                                <h4 class="text-white"><i class="fa fa-list"></i> Cash Account</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive p-1">
                                    <table class="table table-bordered table-sm table-striped table-hover data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>ID</th>
                                                <th>Account Name</th>
                                                <th>Open Cash</th>
                                                <th>Receipts</th>
                                                <th>Cash Return(Sale)</th>
                                                <th>Payments</th>
                                                <th>Cash Return(Purchase)</th>
                                                <th>Expenses</th>
                                                <th>Transfer In</th>
                                                <th>Transfer Out</th>
                                                <th>Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl_data">
                                            <?php
                                            $grandAmount = 0;
                                            ?>
                                            @foreach ($cashAccounts as $cashAccount)

                                                <tr class="data_tr" data-id="{{ $cashAccount->id }}">
                                                    <td>{{ $cashAccount->id }}</td>
                                                    <td>{{ $cashAccount->name }}</td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $cash = App\Models\Cash::where(['cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            echo $cash . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $received = App\Models\Received::where(['cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            echo $received . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $cashSaleReturn = DB::table('sale_return_details as srd')
                                                                ->join('sale_returns as sr', 'srd.sale_return_id', 'sr.id')
                                                                ->select(DB::raw('IFNULL(SUM(price*qty),0) as amount'))
                                                                ->where(['sr.cash_account_id' => $cashAccount->id, 'sr.currency_id' => $currency->id, 'sr.isCash' => 1])
                                                                ->first()->amount;
                                                            echo $cashSaleReturn . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $payment = App\Models\Payment::where(['cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            echo $payment . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $cashPurchaseReturn = DB::table('purchase_return_details as prd')
                                                                ->join('purchase_returns as pr', 'prd.purchase_return_id', 'pr.id')
                                                                ->select(DB::raw('IFNULL(SUM(price*qty),0) as amount'))
                                                                ->where(['pr.cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id, 'pr.isCash' => 1])
                                                                ->first()->amount;
                                                            echo $cashPurchaseReturn . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $expenses = App\Models\Expense::where(['cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            echo $expenses . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $transferIn = App\Models\CashTransfer::where(['to_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            echo $transferIn . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $transferOut = App\Models\CashTransfer::where(['from_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            echo $transferOut . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $cash = App\Models\Cash::where(['cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            $received = App\Models\Received::where(['cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            $payment = App\Models\Payment::where(['cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            $expenses = App\Models\Expense::where(['cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            $transferIn = App\Models\CashTransfer::where(['to_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            $transferOut = App\Models\CashTransfer::where(['from_account_id' => $cashAccount->id, 'currency_id' => $currency->id])->sum('amount');
                                                            $cashSaleReturn = DB::table('sale_return_details as srd')
                                                                ->join('sale_returns as sr', 'srd.sale_return_id', 'sr.id')
                                                                ->select(DB::raw('IFNULL(SUM(price*qty),0) as amount'))
                                                                ->where(['sr.cash_account_id' => $cashAccount->id, 'sr.currency_id' => $currency->id, 'sr.isCash' => 1])
                                                                ->first()->amount;
                                                            $cashPurchaseReturn = DB::table('purchase_return_details as prd')
                                                                ->join('purchase_returns as pr', 'prd.purchase_return_id', 'pr.id')
                                                                ->select(DB::raw('IFNULL(SUM(price*qty),0) as amount'))
                                                                ->where(['pr.cash_account_id' => $cashAccount->id, 'currency_id' => $currency->id, 'pr.isCash' => 1])
                                                                ->first()->amount;
                                                            
                                                            echo $cash + $received - $payment - $expenses + $transferIn - $transferOut + $cashPurchaseReturn - $cashSaleReturn . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Modal -->
        <div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Select Currency</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body table-responsive">
                        <div class="form-group mb-3">
                            <label for="currency_id">Select Currency</label>
                            <select name="currency_id" id="currency_id" class="form-control">
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" id="btn_check">Check</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="accountShowModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cash Account Statement</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body table-responsive">
                        <div class="print_div"></div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

@endif

@section('pageJs')

    <script>
        $(document).ready(function() {
            $(".nav-link").removeClass('active');
            $("#nav_account").addClass("active");
            var account_id = 0;
            $(document).on("dblclick", ".data_tr", function() {
                account_id = $(this).attr("data-id");
                $("#accountModal").modal("show");
            });
            $(document).on("click", "#btn_check", function() {
                $.ajax({
                    url: "{{ url('/account/cashAccount') }}" + "/" + account_id,
                    type: 'GET',
                    data: {
                        "currency_id": $("#currency_id").val(),
                        'id': account_id
                    },
                    success: function(data) {
                        $(".print_div").html(data)
                        $("#accountShowModal").modal("show");
                    },
                    error: function() {
                        swal("Warrning", "Error occured!", "error");
                    }
                });
            });
        });
    </script>

@endsection
