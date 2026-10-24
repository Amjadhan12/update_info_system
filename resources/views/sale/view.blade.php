@extends('layouts.admin')
@section('title', 'Sale View')

@if (Auth::user()->language == 'Pashto')
    @section('body')
        <style>
            .table-scroll {
                width: 100%;
                display: block;
                empty-cells: show;

                /* Decoration */
                border-spacing: 0;
                border: 1px solid;
            }

            .table-scroll thead,
            .table-scroll tfoot {
                background-color: #f1f1f1;
                position: relative;
                display: block;
                width: 100%;
                overflow-y: scroll;
            }

            .table-scroll tbody {
                /* Position */
                display: block;
                position: relative;
                width: 100%;
                overflow-y: scroll;
                /* Decoration */
                /*border-top: 1px solid rgba(0,0,0,0.2);*/
            }

            .table-scroll tr {
                width: 100%;
                display: flex;
            }

            .table-scroll td,
            .table-scroll th {
                flex-basis: 100%;
                flex-grow: 2;
                display: block;
                padding: 6px;
                text-align: left;
            }

            .table-scroll th {
                font-weight: bolder;
            }

            /* Other options */

            .body-half-screen {
                height: 40vh;
            }

        </style>
        <main class="p-3">
            <div class="container-flued">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-sm  mb-5 bg-white rounded">
                            <div class="card-header bg-info bg-gradient">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-white"><i class="fa fa-eye"></i> د خرڅلاو کتل</h4>
                                    </div>
                                    <div class="col-6">
                                        <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
                                            <a class="btn btn-success" href="{{ route('sale.index') }}"><i
                                                    class="fa fa-list" title="Sale List"></i> لیست</a>
                                            <a class="btn btn-primary" href="{{ route('sale.create') }}"><i
                                                    class="fa fa-plus" title="New Purchase"></i> نوی</a>

                                            <a class="btn btn-success" id="btn_edit"><i class="fa fa-edit"
                                                    title="Edit Sale"></i> تغیر</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- <form action="{{ route('sale.store') }}" method="post" id="frm"> -->

                                <div class="row">
                                    <div class="col-md-12 mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="bill_no" value="{{ $maxBill }}" max="{{ $maxBill }}"
                                                min="1" type="number" class="form-control" autofocus>
                                            <label class="form-label" for='bill_no'>بیل نمبر</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="customer_name" name="customer_name"
                                                value="{{ $saleBill->customer->name }}" type="text" class="form-control"
                                                readonly>
                                            <label class="form-label" for='customer_name'>مشتری<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="currency_name" name="currency_name"
                                                value="{{ $saleBill->currency->name }}" type="text" class="form-control"
                                                readonly>
                                            <label class="form-label" for='currency_name'>کرنسي<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="stock_name" name="stock_name" value="{{ $stock->name }}"
                                                type="text" class="form-control" readonly>
                                            <label class="form-label" for='stock_name'>سټاک<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="date" name="date" value="{{ $saleBill->date }}" type="text"
                                                class="form-control" readonly>
                                            <label class="form-label" for='date'>نیټه<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3 pb-1">
                                        <div class="form-outline">
                                            <textarea name="details" id="details" class="form-control" readonly
                                                rows="1">{{ $saleBill->details }}</textarea>
                                            <label class="form-label" for="details">وضاحت</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3 pb-1">
                                        <div class="table-responsive">
                                            <table class="table-scroll table table-bordered">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th>شماره</th>
                                                        <th>جنس</th>
                                                        <th class="text-center">Unit X Size</th>
                                                        <th>قیمت</th>
                                                        <th>تخفیف %</th>
                                                        <th>تعداد</th>
                                                        <th>مجموعه</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="body-half-screen" id="tbl_data">
                                                    @foreach ($sales as $sale)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $sale->item->name }}</td>
                                                            <td>{{ $sale->unit->name }} X
                                                                {{ $sale->unit_size }}
                                                            </td>
                                                            <td>{{ $sale->price * $sale->unit_size }}</td>
                                                            <td>{{ $sale->discount }}</td>
                                                            <td>{{ $sale->qty / $sale->unit_size }}</td>
                                                            <td>{{ round($sale->qty * $sale->price - ($sale->qty * $sale->price * $sale->discount) / 100, 1) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot class="table-primary">
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th><input type="text" id="cash_account_id"
                                                                placeholder="Cash Account" value="@if ($received){{ $received->cashAccount->name }}@endif"
                                                                readonly></th>
                                                        <th>وصولی:<input type="text" name="paid" id="paid"
                                                                placeholder="Paid Amount" value="{{ $paidAmount }}"
                                                                readonly>
                                                        </th>
                                                        <th><button type="button" id="btn-print"
                                                                class="btn btn-sm btn-info">
                                                                چاپول(CTRL+P)</button></th>
                                                        <th>مجموعي تعداد:<span id="tot_qty"
                                                                style="font-weight: bolder;"></span>
                                                        </th>
                                                        <th>مجموعه:<span id="tot_amount"
                                                                style="font-weight: bolder;"></span>
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- </form> -->
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">چاپول</h5>
                                    <button type="button" class="btn-close" data-mdb-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="print_div">

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    @endsection
@else
    @section('body')
        <style>
            .table-scroll {
                width: 100%;
                display: block;
                empty-cells: show;

                /* Decoration */
                border-spacing: 0;
                border: 1px solid;
            }

            .table-scroll thead,
            .table-scroll tfoot {
                background-color: #f1f1f1;
                position: relative;
                display: block;
                width: 100%;
                overflow-y: scroll;
            }

            .table-scroll tbody {
                /* Position */
                display: block;
                position: relative;
                width: 100%;
                overflow-y: scroll;
                /* Decoration */
                /*border-top: 1px solid rgba(0,0,0,0.2);*/
            }

            .table-scroll tr {
                width: 100%;
                display: flex;
            }

            .table-scroll td,
            .table-scroll th {
                flex-basis: 100%;
                flex-grow: 2;
                display: block;
                padding: 6px;
                text-align: left;
            }

            .table-scroll th {
                font-weight: bolder;
            }

            /* Other options */

            .body-half-screen {
                height: 40vh;
            }

        </style>
        <main class="p-3">
            <div class="container-flued">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-sm  mb-5 bg-white rounded">
                            <div class="card-header bg-info bg-gradient">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-white"><i class="fa fa-eye"></i> Sale View</h4>
                                    </div>
                                    <div class="col-6">
                                        <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
                                            <a class="btn btn-success" href="{{ route('sale.index') }}"><i
                                                    class="fa fa-list" title="Sale List"></i> List</a>
                                            <a class="btn btn-primary" href="{{ route('sale.create') }}"><i
                                                    class="fa fa-plus" title="New Purchase"></i> New</a>

                                            <a class="btn btn-success" id="btn_edit"><i class="fa fa-edit"
                                                    title="Edit Sale"></i> Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- <form action="{{ route('sale.store') }}" method="post" id="frm"> -->

                                <div class="row">
                                    <div class="col-md-12 mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="bill_no" value="{{ $maxBill }}" max="{{ $maxBill }}"
                                                min="1" type="number" class="form-control" autofocus>
                                            <label class="form-label" for='bill_no'>Sale Invoice No#</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="customer_name" name="customer_name"
                                                value="{{ $saleBill->customer->name }}" type="text"
                                                class="form-control" readonly>
                                            <label class="form-label" for='customer_name'>Select Customer<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="currency_name" name="currency_name"
                                                value="{{ $saleBill->currency->name }}" type="text"
                                                class="form-control" readonly>
                                            <label class="form-label" for='currency_name'>Select Currency<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="stock_name" name="stock_name" value="{{ $stock->name }}"
                                                type="text" class="form-control" readonly>
                                            <label class="form-label" for='stock_name'>Select Stock<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="date" name="date" value="{{ $saleBill->date }}" type="text"
                                                class="form-control" readonly>
                                            <label class="form-label" for='date'>Date<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3 pb-1">
                                        <div class="form-outline">
                                            <textarea name="details" id="details" class="form-control" readonly
                                                rows="1">{{ $saleBill->details }}</textarea>
                                            <label class="form-label" for="details">Details</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3 pb-1">
                                        <div class="table-responsive">
                                            <table class="table-scroll table table-bordered">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th>No#</th>
                                                        <th>Item</th>
                                                        <th class="text-center">Unit X Size</th>
                                                        <th>S.Price</th>
                                                        <th>Dis %</th>
                                                        <th>Qty</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="body-half-screen" id="tbl_data">
                                                    @foreach ($sales as $sale)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $sale->item->name }}</td>
                                                            <td>{{ $sale->unit->name }} X
                                                                {{ $sale->unit_size }}
                                                            </td>
                                                            <td>{{ $sale->price * $sale->unit_size }}</td>
                                                            <td>{{ $sale->discount }}</td>
                                                            <td>{{ $sale->qty / $sale->unit_size }}</td>
                                                            <td>{{ round($sale->qty * $sale->price - ($sale->qty * $sale->price * $sale->discount) / 100, 1) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot class="table-primary">
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th><input type="text" id="cash_account_id"
                                                                placeholder="Cash Account" value="@if ($received){{ $received->cashAccount->name }}@endif"
                                                                readonly></th>
                                                        <th>Paid:<input type="text" name="paid" id="paid"
                                                                placeholder="Paid Amount" value="{{ $paidAmount }}"
                                                                readonly>
                                                        </th>
                                                        <th><button type="button" id="btn-print"
                                                                class="btn btn-sm btn-info">
                                                                Print(CTRL+P)</button></th>
                                                        <th>Total Qty:<span id="tot_qty"
                                                                style="font-weight: bolder;"></span>
                                                        </th>
                                                        <th>Total Amount:<span id="tot_amount"
                                                                style="font-weight: bolder;"></span></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- </form> -->
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Print</h5>
                                    <button type="button" class="btn-close" data-mdb-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="print_div">

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    @endsection
@endif

@section('pageJs')

    <script>
        $(document).ready(function() {
            $(".nav-link").removeClass('active');
            $("#nav_sale").addClass("active");

            function billTotal() {
                var my_table = document.getElementById('tbl_data');
                var total = 0;
                var totQty = 0;
                for (var a = 0; a < my_table.rows.length; a++) {
                    totQty += Number(my_table.rows[a].cells[5].innerHTML);
                    total += Number(my_table.rows[a].cells[6].innerHTML);
                }

                $("#tot_amount").html(total);
                $("#tot_qty").html(totQty);
            }
            billTotal();


            function printBill() {
                var bill_no = $("#bill_no").val();

                $.ajax({
                    url: "{{ url('/salePrint') }}",
                    type: 'GET',
                    data: {
                        "id": bill_no
                    },
                    success: function(data) {
                        // console.log(data);
                        $(".print_div").html(data);

                        var mode = 'iframe';
                        var close = mode == 'popup';
                        var options = {
                            mode: mode,
                            popClose: close
                        };
                        $('div.print_div').printArea(options);
                    },
                    error: function() {
                        // swal("Warrning", "Error Occured", "error");
                    }
                });
            }

            $("#btn-print").click(function() {
                printBill();
            });
            $(window).keydown(function(event) {
                if ((event.ctrlKey && event.keyCode === 80) || event.keyCode == 114) {
                    event.preventDefault();
                    printBill();
                }
            });



            function loadSle() {
                var bill_no = $("#bill_no").val();


                $.ajax({
                    url: "{{ url('/getSaleBill') }}",
                    type: 'GET',
                    data: {
                        "id": bill_no
                    },
                    success: function(data) {
                        $("#customer_name").val(data['customer_name']);
                        $("#stock_name").val(data['stock_name']);
                        $("#currency_name").val(data['currency_name']);
                        $("#tbl_data").html(data['tblData']);
                        $("#details").val(data['sale_details']);
                        $("#date").val(data['sale_date']);
                        $("#paid").val(data['paidAmount']);
                        billTotal();
                    },
                    error: function() {
                        // swal("Warrning", "Error Occured", "error");
                    }
                });
            }

            $(document).on("keyup", "#bill_no", function() {
                loadSle();
            });
            $(document).on("change", "#bill_no", function() {
                loadSle();
            });


            $("#btn_edit").click(function() {
                var bill_id = $("#bill_no").val();
                window.location.href = "{{ url('/sale') }}/" + bill_id + "/edit";

            });
        });
    </script>

@endsection
