@extends('layouts.admin')
@section('title', 'Purchase')

@if (Auth::user()->language == 'Pashto')
    @section('body')

        <main class="p-3">
            <div class="container-flued">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-sm  mb-5 bg-white rounded">
                            <div class="card-header bg-info bg-gradient">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-white"><i class="fa fa-eye"></i> د خریداری د واپسي کتل</h4>
                                    </div>
                                    <div class="col-6">
                                        <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
                                            <a class="btn btn-primary" href="{{ route('purchaseReturn.create') }}"><i
                                                    class="fa fa-plus" title="New Purchase"></i> نوی</a>
                                            <a class="btn btn-success" id="btn_edit"><i class="fa fa-edit"
                                                    title="Edit Purchase"></i> تغیر</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- <form action="{{ route('purchase.store') }}" method="post" id="frm"> -->

                                <div class="row">
                                    <div class="col-md-12 mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="bill_no" value="{{ $maxBill }}" max="{{ $maxBill }}"
                                                min="1" type="number" class="form-control" autofocus>
                                            <label class="form-label" for='bill_no'>شماره#</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="supplier_name" name="supplier_name"
                                                value="{{ $purchaseBill->supplier->name }}" type="text"
                                                class="form-control" readonly>
                                            <label class="form-label" for='supplier_name'>شرکت<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="currency_name" name="currency_name"
                                                value="{{ $purchaseBill->currency->name }}" type="text"
                                                class="form-control" readonly>
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
                                            <input id="date" name="date" value="{{ $purchaseBill->date }}" type="text"
                                                class="form-control" readonly>
                                            <label class="form-label" for='date'>نیټه<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3 pb-1">
                                        <div class="form-outline">
                                            <textarea name="details" id="details" class="form-control" readonly
                                                rows="1">{{ $purchaseBill->details }}</textarea>
                                            <label class="form-label" for="details">وضاحت
                                            </label>
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
                                                        <th>تعداد</th>
                                                        <th>مجموعه</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="body-half-screen" id="tbl_data">
                                                    @foreach ($purchases as $purchase)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $purchase->item->name }}</td>
                                                            <td>{{ $purchase->unit->name }} X
                                                                {{ $purchase->unit_size }}
                                                            </td>
                                                            <td>{{ $purchase->price * $purchase->unit_size }}</td>
                                                            <td>{{ $purchase->qty / $purchase->unit_size }}</td>
                                                            <td>{{ round($purchase->qty * $purchase->price, 1) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot class="table-primary">
                                                    <tr>
                                                        <th></th>
                                                        <th>
                                                            {{ $purchaseBill->cashAccount->name }}
                                                        </th>
                                                        </th>
                                                        <th>
                                                            <select name="isCash" class="form-control form-control-sm"
                                                                id="isCash" style="width: 100%;" disabled>
                                                                @if ($purchaseBill->isCash == 1)
                                                                    <option value="1">Cash</option>
                                                                @else
                                                                    <option value="0">Payable</option>
                                                                @endif
                                                            </select>
                                                        </th>
                                                        <th><button type="button" id="btn-print"
                                                                class="btn btn-sm btn-info">
                                                                چاپول(CTRL+P)</button></th>
                                                        <th>مجموعي تعداد:<span id="tot_qty"
                                                                style="font-weight: bolder;"></span>
                                                        </th>
                                                        <th>مجموعه:<span id="tot_amount"
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
@else
    @section('body')

        <main class="p-3">
            <div class="container-flued">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-sm  mb-5 bg-white rounded">
                            <div class="card-header bg-info bg-gradient">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-white"><i class="fa fa-eye"></i> Purchase Return View</h4>
                                    </div>
                                    <div class="col-6">
                                        <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
                                            <a class="btn btn-primary" href="{{ route('purchaseReturn.create') }}"><i
                                                    class="fa fa-plus" title="New Purchase"></i> New</a>
                                            <a class="btn btn-success" id="btn_edit"><i class="fa fa-edit"
                                                    title="Edit Purchase"></i> Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- <form action="{{ route('purchase.store') }}" method="post" id="frm"> -->

                                <div class="row">
                                    <div class="col-md-12 mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="bill_no" value="{{ $maxBill }}" max="{{ $maxBill }}"
                                                min="1" type="number" class="form-control" autofocus>
                                            <label class="form-label" for='bill_no'>Purchase Invoice No#</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="supplier_name" name="supplier_name"
                                                value="{{ $purchaseBill->supplier->name }}" type="text"
                                                class="form-control" readonly>
                                            <label class="form-label" for='supplier_name'>Select Supplier<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="currency_name" name="currency_name"
                                                value="{{ $purchaseBill->currency->name }}" type="text"
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
                                            <input id="date" name="date" value="{{ $purchaseBill->date }}" type="text"
                                                class="form-control" readonly>
                                            <label class="form-label" for='date'>Date<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3 pb-1">
                                        <div class="form-outline">
                                            <textarea name="details" id="details" class="form-control" readonly
                                                rows="1">{{ $purchaseBill->details }}</textarea>
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
                                                        <th>Return Price</th>
                                                        <th>Qty</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="body-half-screen" id="tbl_data">
                                                    @foreach ($purchases as $purchase)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $purchase->item->name }}</td>
                                                            <td>{{ $purchase->unit->name }} X
                                                                {{ $purchase->unit_size }}
                                                            </td>
                                                            <td>{{ $purchase->price * $purchase->unit_size }}</td>
                                                            <td>{{ $purchase->qty / $purchase->unit_size }}</td>
                                                            <td>{{ round($purchase->qty * $purchase->price, 1) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot class="table-primary">
                                                    <tr>
                                                        <th></th>
                                                        <th>
                                                            {{ $purchaseBill->cashAccount->name }}
                                                        </th>
                                                        </th>
                                                        <th>
                                                            <select name="isCash" class="form-control form-control-sm"
                                                                id="isCash" style="width: 100%;" disabled>
                                                                @if ($purchaseBill->isCash == 1)
                                                                    <option value="1">Cash</option>
                                                                @else
                                                                    <option value="0">Payable</option>
                                                                @endif
                                                            </select>
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
            $("#nav_purchase").addClass("active");

            function billTotal() {
                var my_table = document.getElementById('tbl_data');
                var total = 0;
                var totQty = 0;
                for (var a = 0; a < my_table.rows.length; a++) {
                    totQty += Number(my_table.rows[a].cells[4].innerHTML);
                    total += Number(my_table.rows[a].cells[5].innerHTML);
                }

                $("#tot_amount").html(total);
                $("#tot_qty").html(totQty);
            }
            billTotal();


            function printBill() {
                var bill_no = $("#bill_no").val();

                $.ajax({
                    url: "{{ url('/purchaseReturnPrint') }}",
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



            function loadPurchase() {
                var bill_no = $("#bill_no").val();


                $.ajax({
                    url: "{{ url('/getPurchaseReturn') }}",
                    type: 'GET',
                    data: {
                        "id": bill_no
                    },
                    success: function(data) {
                        $("#supplier_name").val(data['supplier_name']);
                        $("#stock_name").val(data['stock_name']);
                        $("#currency_name").val(data['currency_name']);
                        $("#tbl_data").html(data['tblData']);
                        $("#details").val(data['purchase_details']);
                        $("#date").val(data['purchase_date']);
                        billTotal();
                    },
                    error: function() {
                        // swal("Warrning", "Error Occured", "error");
                    }
                });
            }

            $(document).on("keyup", "#bill_no", function() {
                loadPurchase();
            });
            $(document).on("change", "#bill_no", function() {
                loadPurchase();
            });


            $("#btn_edit").click(function() {
                var bill_id = $("#bill_no").val();
                window.location.href = "{{ url('/purchaseReturn') }}/" + bill_id + "/edit";

            });
        });
    </script>

@endsection
