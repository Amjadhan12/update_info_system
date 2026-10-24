@extends('layouts.admin')
@section('title', 'Customer Account')

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
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-white"><i class="fa fa-list"></i> د مشتریانو حسابونه</h4>
                                    </div>
                                    <div class="col-6">
                                        <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
                                            <a class="btn btn-info" href="{{ url('/unpaidCustomer') }}"><i
                                                    class="fa fa-eye" title="Balance Customers"></i> باقي مشتریان</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive p-1">
                                    <table class="table table-bordered table-sm table-striped table-hover data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>شماره</th>
                                                <th>د مشتری نوم</th>
                                                <th>لومړني قرض</th>
                                                <th>مجموعي خرڅلاو</th>
                                                <th>مجموعي واپسي</th>
                                                <th>وصولی</th>
                                                <th>بلانس</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl_data">
                                            <?php
                                            $grandAmount = 0;
                                            ?>
                                            @foreach ($customers as $customer)

                                                <tr class="data_tr" data-id="{{ $customer->id }}">
                                                    <td>{{ $customer->id }}</td>
                                                    <td>{{ $customer->name }}</td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $openReceivable = App\Models\OpenReceivable::where(['customer_id' => $customer->id, 'currency_id' => $currency->id])->sum('amount');
                                                            echo $openReceivable . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $totSale = App\Http\Controllers\FunctionController::totSale($customer->id, $currency->id);
                                                            echo $totSale . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $totReturn = App\Http\Controllers\FunctionController::totSaleReturn($customer->id, $currency->id);
                                                            echo $totReturn . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $totReceived = App\Models\Received::where(['customer_id' => $customer->id, 'currency_id' => $currency->id])->sum('amount');
                                                            echo $totReceived . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $openReceivable = App\Models\OpenReceivable::where(['customer_id' => $customer->id, 'currency_id' => $currency->id])->sum('amount');
                                                            $totSale = App\Http\Controllers\FunctionController::totSale($customer->id, $currency->id);
                                                            $totReturn = App\Http\Controllers\FunctionController::totSaleReturn($customer->id, $currency->id);
                                                            $totReturnCash = App\Http\Controllers\FunctionController::totSaleReturnCash($customer->id, $currency->id);
                                                            $totReceived = App\Models\Received::where(['customer_id' => $customer->id, 'currency_id' => $currency->id])->sum('amount');
                                                            
                                                            echo $openReceivable + $totSale + $totReturnCash - $totReturn - $totReceived . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-primary">
                                            <tr>
                                                <th></th>
                                                <th>Grand Total</th>
                                                <th id="totOpen">
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $openReceivable = App\Models\OpenReceivable::where(['currency_id' => $currency->id])->sum('amount');
                                                        echo $openReceivable . ' ' . $currency->name . '<br>';
                                                        ?>
                                                    @endforeach
                                                </th>
                                                <th id="totPurchase">
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $totSale = App\Http\Controllers\FunctionController::totSale(0, $currency->id);
                                                        echo $totSale . ' ' . $currency->name . '<br>';
                                                        ?>
                                                    @endforeach
                                                </th>
                                                <th id="totReturn">
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $totReturn = App\Http\Controllers\FunctionController::totSaleReturn(0, $currency->id);
                                                        echo $totReturn . ' ' . $currency->name . '<br>';
                                                        ?>
                                                    @endforeach
                                                </th>
                                                <th id="totPayment">
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $totReceived = App\Models\Received::where(['currency_id' => $currency->id])->sum('amount');
                                                        echo $totReceived . ' ' . $currency->name . '<br>';
                                                        ?>
                                                    @endforeach
                                                </th>
                                                <th id="totBalance">
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $openReceivable = App\Models\OpenReceivable::where(['currency_id' => $currency->id])->sum('amount');
                                                        $totSale = App\Http\Controllers\FunctionController::totSale(0, $currency->id);
                                                        $totReturn = App\Http\Controllers\FunctionController::totSaleReturn(0, $currency->id);
                                                        $totReceived = App\Models\Received::where(['currency_id' => $currency->id])->sum('amount');
                                                        
                                                        echo $openReceivable + $totSale - $totReturn - $totReceived . ' ' . $currency->name . '<br>';
                                                        ?>
                                                    @endforeach
                                                </th>
                                            </tr>
                                        </tfoot>
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
                        <h5 class="modal-title" id="exampleModalLabel">کرنسي انتخاب کړئ</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body table-responsive">
                        <div class="form-group mb-3">
                            <label for="currency_id">کرنسي</label>
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
                        <h5 class="modal-title" id="exampleModalLabel">Customer Account</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body table-responsive">
                        <div class="print_div"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">چاپول</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="print_bill">

                        </div>
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
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-white"><i class="fa fa-list"></i> Customer Account</h4>
                                    </div>
                                    <div class="col-6">
                                        <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
                                            <a class="btn btn-info" href="{{ url('/unpaidCustomer') }}"><i
                                                    class="fa fa-eye" title="Balance Customers"></i> Balance
                                                Customers</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive p-1">
                                    <table class="table table-bordered table-sm table-striped table-hover data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>ID</th>
                                                <th>Customer Name</th>
                                                <th>Open Amount</th>
                                                <th>Total Sale</th>
                                                <th>Sale Return</th>
                                                <th>Received</th>
                                                <th>Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl_data">
                                            <?php
                                            $grandAmount = 0;
                                            ?>
                                            @foreach ($customers as $customer)

                                                <tr class="data_tr" data-id="{{ $customer->id }}">
                                                    <td>{{ $customer->id }}</td>
                                                    <td>{{ $customer->name }}</td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $openReceivable = App\Models\OpenReceivable::where(['customer_id' => $customer->id, 'currency_id' => $currency->id])->sum('amount');
                                                            echo $openReceivable . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $totSale = App\Http\Controllers\FunctionController::totSale($customer->id, $currency->id);
                                                            echo $totSale . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $totReturn = App\Http\Controllers\FunctionController::totSaleReturn($customer->id, $currency->id);
                                                            echo $totReturn . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $totReceived = App\Models\Received::where(['customer_id' => $customer->id, 'currency_id' => $currency->id])->sum('amount');
                                                            echo $totReceived . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($currencies as $currency)
                                                            <?php
                                                            $openReceivable = App\Models\OpenReceivable::where(['customer_id' => $customer->id, 'currency_id' => $currency->id])->sum('amount');
                                                            $totSale = App\Http\Controllers\FunctionController::totSale($customer->id, $currency->id);
                                                            $totReturn = App\Http\Controllers\FunctionController::totSaleReturn($customer->id, $currency->id);
                                                            $totReturnCash = App\Http\Controllers\FunctionController::totSaleReturnCash($customer->id, $currency->id);
                                                            $totReceived = App\Models\Received::where(['customer_id' => $customer->id, 'currency_id' => $currency->id])->sum('amount');
                                                            
                                                            echo $openReceivable + $totSale + $totReturnCash - $totReturn - $totReceived . ' ' . $currency->name . '<br>';
                                                            ?>
                                                        @endforeach
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-primary">
                                            <tr>
                                                <th></th>
                                                <th>Grand Total</th>
                                                <th id="totOpen">
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $openReceivable = App\Models\OpenReceivable::where(['currency_id' => $currency->id])->sum('amount');
                                                        echo $openReceivable . ' ' . $currency->name . '<br>';
                                                        ?>
                                                    @endforeach
                                                </th>
                                                <th id="totPurchase">
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $totSale = App\Http\Controllers\FunctionController::totSale(0, $currency->id);
                                                        echo $totSale . ' ' . $currency->name . '<br>';
                                                        ?>
                                                    @endforeach
                                                </th>
                                                <th id="totReturn">
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $totReturn = App\Http\Controllers\FunctionController::totSaleReturn(0, $currency->id);
                                                        echo $totReturn . ' ' . $currency->name . '<br>';
                                                        ?>
                                                    @endforeach
                                                </th>
                                                <th id="totPayment">
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $totReceived = App\Models\Received::where(['currency_id' => $currency->id])->sum('amount');
                                                        echo $totReceived . ' ' . $currency->name . '<br>';
                                                        ?>
                                                    @endforeach
                                                </th>
                                                <th id="totBalance">
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $openReceivable = App\Models\OpenReceivable::where(['currency_id' => $currency->id])->sum('amount');
                                                        $totSale = App\Http\Controllers\FunctionController::totSale(0, $currency->id);
                                                        $totReturn = App\Http\Controllers\FunctionController::totSaleReturn(0, $currency->id);
                                                        $totReceived = App\Models\Received::where(['currency_id' => $currency->id])->sum('amount');
                                                        
                                                        echo $openReceivable + $totSale - $totReturn - $totReceived . ' ' . $currency->name . '<br>';
                                                        ?>
                                                    @endforeach
                                                </th>
                                            </tr>
                                        </tfoot>
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
                        <h5 class="modal-title" id="exampleModalLabel">Select Customer Account</h5>
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
                        <h5 class="modal-title" id="exampleModalLabel">Customer Account</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body table-responsive">
                        <div class="print_div"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Print</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="print_bill">

                        </div>
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
            var customer_id = 0;
            $(document).on("dblclick", ".data_tr", function() {
                customer_id = $(this).attr("data-id");
                $("#accountModal").modal("show");
            });
            $(document).on("click", "#btn_check", function() {
                $.ajax({
                    url: "{{ url('/account/customer') }}" + "/" + customer_id,
                    type: 'GET',
                    data: {
                        "currency_id": $("#currency_id").val(),
                        'id': customer_id
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

            $(document).on("dblclick", ".sale", function() {
                var bill_no = $(this).attr('data-id');
                $.ajax({
                    url: "{{ url('/salePrint') }}",
                    type: 'GET',
                    data: {
                        "id": bill_no
                    },
                    success: function(data) {
                        // console.log(data);
                        $(".print_bill").html(data);

                        var mode = 'iframe';
                        var close = mode == 'popup';
                        var options = {
                            mode: mode,
                            popClose: close
                        };
                        $('div.print_bill').printArea(options);
                    },
                    error: function() {
                        // swal("Warrning", "Error Occured", "error");
                    }
                });
            })

        });
    </script>

@endsection
