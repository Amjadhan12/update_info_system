@extends('layouts.admin')
@section('title', 'Supplier Account')

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
                            <h4 class="text-white"><i class="fa fa-list"></i> د شرکت کهاته</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-bordered table-sm table-striped table-hover data_table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>شماره</th>
                                            <th>شرکت</th>
                                            <th>لومړني قرض</th>
                                            <th>مجموعه خرید</th>
                                            <th>مجموعه واپسي</th>
                                            <th>وصولی</th>
                                            <th>باقي</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbl_data">
                                        <?php
                                        $grandAmount = 0;
                                        ?>
                                        @foreach ($suppliers as $supplier)

                                            <tr class="data_tr" data-id="{{ $supplier->id }}">
                                                <td>{{ $supplier->id }}</td>
                                                <td>{{ $supplier->name }}</td>
                                                <td>
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $openPayable = App\Models\OpenPayable::where(['supplier_id' => $supplier->id, 'currency_id' => $currency->id])->sum('amount');
                                                        echo $openPayable . ' ' . $currency->name . '<br>';
                                                        ?>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $totPurchase = App\Http\Controllers\FunctionController::totPurchase($supplier->id, $currency->id);
                                                        echo $totPurchase . ' ' . $currency->name . '<br>';
                                                        ?>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $totReturn = App\Http\Controllers\FunctionController::totPurchaseReturn($supplier->id, $currency->id);
                                                        echo $totReturn . ' ' . $currency->name . '<br>';
                                                        ?>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $totPayment = App\Models\Payment::where(['supplier_id' => $supplier->id, 'currency_id' => $currency->id])->sum('amount');
                                                        echo $totPayment . ' ' . $currency->name . '<br>';
                                                        ?>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $openPayable = App\Models\OpenPayable::where(['supplier_id' => $supplier->id, 'currency_id' => $currency->id])->sum('amount');
                                                        $totPurchase = App\Http\Controllers\FunctionController::totPurchase($supplier->id, $currency->id);
                                                        $totReturn = App\Http\Controllers\FunctionController::totPurchaseReturn($supplier->id, $currency->id);
                                                        $totReturnCash = App\Http\Controllers\FunctionController::totPurchaseReturnCash($supplier->id, $currency->id);
                                                        $totPayment = App\Models\Payment::where(['supplier_id' => $supplier->id, 'currency_id' => $currency->id])->sum('amount');
                                                        
                                                        echo $openPayable + $totPurchase + $totReturnCash - $totReturn - $totPayment . ' ' . $currency->name . '<br>';
                                                        ?>
                                                    @endforeach
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-primary">
                                        <tr>
                                            <th></th>
                                            <th>مجموعه</th>
                                            <th id="totOpen">
                                                @foreach ($currencies as $currency)
                                                    <?php
                                                    $openPayable = App\Models\OpenPayable::where('currency_id', $currency->id)->sum('amount');
                                                    echo $openPayable . ' ' . $currency->name . '<br>';
                                                    ?>
                                                @endforeach
                                            </th>
                                            <th id="totPurchase">
                                                @foreach ($currencies as $currency)
                                                    <?php
                                                    $totPurchase = App\Http\Controllers\FunctionController::totPurchase(0, $currency->id);
                                                    echo $totPurchase . ' ' . $currency->name . '<br>';
                                                    ?>
                                                @endforeach
                                            </th>
                                            <th id="totReturn">
                                                @foreach ($currencies as $currency)
                                                    <?php
                                                    $totReturn = App\Http\Controllers\FunctionController::totPurchaseReturn(0, $currency->id);
                                                    echo $totReturn . ' ' . $currency->name . '<br>';
                                                    ?>
                                                @endforeach
                                            </th>
                                            <th id="totPayment">
                                                @foreach ($currencies as $currency)
                                                    <?php
                                                    $totPayment = App\Models\Payment::where('currency_id', $currency->id)->sum('amount');
                                                    echo $totPayment . ' ' . $currency->name . '<br>';
                                                    ?>
                                                @endforeach
                                            </th>
                                            <th id="totBalance">
                                                @foreach ($currencies as $currency)
                                                    <?php
                                                    $openPayable = App\Models\OpenPayable::where(['currency_id' => $currency->id])->sum('amount');
                                                    $totPurchase = App\Http\Controllers\FunctionController::totPurchase(0, $currency->id);
                                                    $totReturn = App\Http\Controllers\FunctionController::totPurchaseReturn(0, $currency->id);
                                                    $totPayment = App\Models\Payment::where(['currency_id' => $currency->id])->sum('amount');
                                                    
                                                    echo $openPayable + $totPurchase - $totReturn - $totPayment . ' ' . $currency->name . '<br>';
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
                    <h5 class="modal-title" id="exampleModalLabel">کرنسي</h5>
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
    <div class="modal fade" id="accountShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">د شرکت کهاته</h5>
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
                            <h4 class="text-white"><i class="fa fa-list"></i> Supplier Account</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-bordered table-sm table-striped table-hover data_table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>ID</th>
                                            <th>Supplier Name</th>
                                            <th>Open Amount</th>
                                            <th>Total Purchase</th>
                                            <th>Purchase Return</th>
                                            <th>Payment</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbl_data">
                                        <?php
                                        $grandAmount = 0;
                                        ?>
                                        @foreach ($suppliers as $supplier)

                                            <tr class="data_tr" data-id="{{ $supplier->id }}">
                                                <td>{{ $supplier->id }}</td>
                                                <td>{{ $supplier->name }}</td>
                                                <td>
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $openPayable = App\Models\OpenPayable::where(['supplier_id' => $supplier->id, 'currency_id' => $currency->id])->sum('amount');
                                                        echo $openPayable . ' ' . $currency->name . '<br>';
                                                        ?>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $totPurchase = App\Http\Controllers\FunctionController::totPurchase($supplier->id, $currency->id);
                                                        echo $totPurchase . ' ' . $currency->name . '<br>';
                                                        ?>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $totReturn = App\Http\Controllers\FunctionController::totPurchaseReturn($supplier->id, $currency->id);
                                                        echo $totReturn . ' ' . $currency->name . '<br>';
                                                        ?>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $totPayment = App\Models\Payment::where(['supplier_id' => $supplier->id, 'currency_id' => $currency->id])->sum('amount');
                                                        echo $totPayment . ' ' . $currency->name . '<br>';
                                                        ?>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($currencies as $currency)
                                                        <?php
                                                        $openPayable = App\Models\OpenPayable::where(['supplier_id' => $supplier->id, 'currency_id' => $currency->id])->sum('amount');
                                                        $totPurchase = App\Http\Controllers\FunctionController::totPurchase($supplier->id, $currency->id);
                                                        $totReturn = App\Http\Controllers\FunctionController::totPurchaseReturn($supplier->id, $currency->id);
                                                        $totReturnCash = App\Http\Controllers\FunctionController::totPurchaseReturnCash($supplier->id, $currency->id);
                                                        $totPayment = App\Models\Payment::where(['supplier_id' => $supplier->id, 'currency_id' => $currency->id])->sum('amount');
                                                        
                                                        echo $openPayable + $totPurchase + $totReturnCash - $totReturn - $totPayment . ' ' . $currency->name . '<br>';
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
                                                    $openPayable = App\Models\OpenPayable::where('currency_id', $currency->id)->sum('amount');
                                                    echo $openPayable . ' ' . $currency->name . '<br>';
                                                    ?>
                                                @endforeach
                                            </th>
                                            <th id="totPurchase">
                                                @foreach ($currencies as $currency)
                                                    <?php
                                                    $totPurchase = App\Http\Controllers\FunctionController::totPurchase(0, $currency->id);
                                                    echo $totPurchase . ' ' . $currency->name . '<br>';
                                                    ?>
                                                @endforeach
                                            </th>
                                            <th id="totReturn">
                                                @foreach ($currencies as $currency)
                                                    <?php
                                                    $totReturn = App\Http\Controllers\FunctionController::totPurchaseReturn(0, $currency->id);
                                                    echo $totReturn . ' ' . $currency->name . '<br>';
                                                    ?>
                                                @endforeach
                                            </th>
                                            <th id="totPayment">
                                                @foreach ($currencies as $currency)
                                                    <?php
                                                    $totPayment = App\Models\Payment::where('currency_id', $currency->id)->sum('amount');
                                                    echo $totPayment . ' ' . $currency->name . '<br>';
                                                    ?>
                                                @endforeach
                                            </th>
                                            <th id="totBalance">
                                                @foreach ($currencies as $currency)
                                                    <?php
                                                    $openPayable = App\Models\OpenPayable::where(['currency_id' => $currency->id])->sum('amount');
                                                    $totPurchase = App\Http\Controllers\FunctionController::totPurchase(0, $currency->id);
                                                    $totReturn = App\Http\Controllers\FunctionController::totPurchaseReturn(0, $currency->id);
                                                    $totPayment = App\Models\Payment::where(['currency_id' => $currency->id])->sum('amount');
                                                    
                                                    echo $openPayable + $totPurchase - $totReturn - $totPayment . ' ' . $currency->name . '<br>';
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
                    <h5 class="modal-title" id="exampleModalLabel">Select Supplier Account</h5>
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
    <div class="modal fade" id="accountShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Supplier Account</h5>
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
            var supplier_id = 0;
            $(document).on("dblclick", ".data_tr", function() {
                supplier_id = $(this).attr("data-id");
                $("#accountModal").modal("show");
            });
            $(document).on("click", "#btn_check", function() {
                $.ajax({
                    url: "{{ url('/account/supplier') }}" + "/" + supplier_id,
                    type: 'GET',
                    data: {
                        "currency_id": $("#currency_id").val(),
                        'id': supplier_id
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

            $(document).on("click", ".purchase", function() {
                var bill_no = $(this).attr('data-id');

                $.ajax({
                    url: "{{ url('/purchasePrint') }}",
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
