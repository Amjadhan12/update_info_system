@extends('layouts.admin')
@section('title', 'Edit Purchase')

@if (Auth::user()->language == 'Pashto')
    @section('body')

        <main class="p-3">
            <div class="container-flued">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-sm  mb-5 bg-white rounded">
                            <div class="card-header bg-success bg-gradient">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-white"><i class="fa fa-edit"></i> د خریداری په واپسي کې تغیر
                                        </h4>
                                    </div>
                                    <div class="col-6">
                                        <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
                                            <a class="btn btn-info" href="{{ url('/purchasereturnview') }}"><i
                                                    class="fa fa-eye" title="Purchase View"></i> کتل</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('purchaseReturn.update', $purchaseBill->id) }}" method="post"
                                    id="frm">
                                    @csrf
                                    @method("put")
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="row">

                                        <div class="col-md-3 mb-3 pb-1">
                                            <div class="form-group">
                                                <label for='supplier_id'>شرکت<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="supplier_id" name="supplier_id" class="select2"
                                                    style="width: 100%;">
                                                    <option value="{{ $purchaseBill->supplier_id }}">
                                                        {{ $purchaseBill->supplier->name }}</option>
                                                    @foreach ($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3 pb-1">
                                            <div class="form-group">
                                                <label for='currency_id'>کرنسي<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="currency_id" name="currency_id" class="select2"
                                                    style="width: 100%;">
                                                    <option value="{{ $purchaseBill->currency_id }}">
                                                        {{ $purchaseBill->currency->name }}</option>
                                                    @foreach ($currencies as $currency)
                                                        <option value="{{ $currency->id }}">{{ $currency->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3 pb-1">
                                            <div class="form-group">
                                                <label for='stock_id'>سټاک<strong class="text-danger">*</strong></label>
                                                <select id="stock_id" name="stock_id" class="select2"
                                                    style="width: 100%;">
                                                    <option value="{{ $stk->id }}">{{ $stk->name }}</option>
                                                    @foreach ($stocks as $stock)
                                                        <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3 pb-1">
                                            <div class="form-group">
                                                <label for='date'>نیټه<strong class="text-danger">*</strong></label>
                                                <input id="date" name="date" type="text" class="form-control date" required
                                                    value="{{ $purchaseBill->date }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3 pb-1">
                                            <div class="form-outline">
                                                <textarea name="details" id="details" class="form-control"
                                                    rows="1">{{ $purchaseBill->details }}</textarea>
                                                <label class="form-label" for="details">وضاحت</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3 pb-1">
                                            <div class="table-responsive">
                                                <table class="table-scroll table table-bordered">
                                                    <thead class="table-success">
                                                        <tr>
                                                            <th width="40"></th>
                                                            <th>
                                                                <input id="item_name" list="item_names" style="width: 100%;"
                                                                    autofocus>
                                                                <datalist id="item_names">
                                                                    @foreach ($items as $item)
                                                                        <option value="{{ $item->name }}">
                                                                    @endforeach
                                                                </datalist>
                                                                <input type="hidden" id="item_id">
                                                            </th>
                                                            <th>
                                                                <select id="unit_id" title="Item Unit"
                                                                    style="width: 48%; padding: 5px 0px;" title="Item Unit">
                                                                    @foreach ($units as $unit)
                                                                        <option value="{{ $unit->id }}">
                                                                            {{ $unit->name }}</option>
                                                                    @endforeach
                                                                </select>X
                                                                <input type="text" id="unit_size" value="1"
                                                                    style="width: 40%;" title="Unit Size">
                                                            </th>
                                                            <th>
                                                                <input id="pprice" style="width: 100%;">
                                                            </th>
                                                            <th>
                                                                <input id="qty" style="width: 100%;">
                                                            </th>
                                                            <th>
                                                                <button type="button" class="btn btn-success btn-sm"
                                                                    id="btn_add" style="width: 100%;"><i
                                                                        class="fa fa-plus" aria-hidden="true"></i>
                                                                    اضافه</button>
                                                            </th>
                                                        </tr>
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
                                                            <tr class='dataTr' data-name='{{ $purchase->item->name }}'
                                                                data-cost='{{ $purchase->price * $purchase->unit_size }}'
                                                                data-qty='{{ $purchase->qty / $purchase->unit_size }}'
                                                                data-id='{{ $purchase->item_id }}'
                                                                data-unit='{{ $purchase->unit_id }}'
                                                                data-unit-size='{{ $purchase->unit_size }}'>
                                                                <td><input type='checkbox'
                                                                        class='hidden'>{{ $loop->iteration }}</td>
                                                                <td>{{ $purchase->item->name }}<input type='hidden'
                                                                        name='itemId[]' value="{{ $purchase->item_id }}">
                                                                </td>
                                                                <td>{{ $purchase->unit->name . ' X ' . $purchase->unit_size }}<input
                                                                        type='hidden' name='unitId[]'
                                                                        value="{{ $purchase->unit_id }}">
                                                                    <input type='hidden' name='unitSize[]'
                                                                        value="{{ $purchase->unit_size }}">
                                                                </td>
                                                                <td>{{ $purchase->price * $purchase->unit_size }} <input
                                                                        type='hidden' name='price[]'
                                                                        value="{{ $purchase->price }}">
                                                                </td>
                                                                <td>{{ $purchase->qty / $purchase->unit_size }}</td>
                                                                <input type='hidden' name='qty[]'
                                                                    value="{{ $purchase->qty }}">
                                                                <td>{{ $purchase->qty * $purchase->price }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot class="table-primary">
                                                        <tr>
                                                            <th></th>
                                                            <th>
                                                                <select name="cash_account_id" class="select2"
                                                                    id="cash_account_id" style="width: 100%;">
                                                                    <option value="{{ $purchaseBill->cash_account_id }}">
                                                                        {{ $purchaseBill->cashAccount->name }}</option>
                                                                    @foreach ($accounts as $account)
                                                                        <option value="{{ $account->id }}">
                                                                            {{ $account->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </th>
                                                            <th>
                                                                <select name="isCash" class="form-control form-control-sm"
                                                                    id="isCash" style="width: 100%;">
                                                                    @if ($purchaseBill->isCash == 1)
                                                                        <option value="1">نغد</option>
                                                                        <option value="0">په کهاته کې</option>
                                                                    @else
                                                                        <option value="0">په کهاته کې</option>
                                                                        <option value="1">نغد</option>
                                                                    @endif
                                                                </select>
                                                            </th>
                                                            <th><button type="submit" class="btn btn-sm btn-primary">
                                                                    ثبتول(F4)</button></th>
                                                            <th>مجموعي تعداد:<span id="tot_qty"
                                                                    style="font-weight: bolder;"></span></th>
                                                            <th>مجموعه:<span id="tot_amount"
                                                                    style="font-weight: bolder;"></span></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
                            <div class="card-header bg-success bg-gradient">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-white"><i class="fa fa-edit"></i> Edit Purchase Return</h4>
                                    </div>
                                    <div class="col-6">
                                        <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
                                            <a class="btn btn-info" href="{{ url('/purchasereturnview') }}"><i
                                                    class="fa fa-eye" title="Purchase View"></i> View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('purchaseReturn.update', $purchaseBill->id) }}" method="post"
                                    id="frm">
                                    @csrf
                                    @method("put")
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="row">

                                        <div class="col-md-3 mb-3 pb-1">
                                            <div class="form-group">
                                                <label for='supplier_id'>Supplier<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="supplier_id" name="supplier_id" class="select2"
                                                    style="width: 100%;">
                                                    <option value="{{ $purchaseBill->supplier_id }}">
                                                        {{ $purchaseBill->supplier->name }}</option>
                                                    @foreach ($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3 pb-1">
                                            <div class="form-group">
                                                <label for='currency_id'>Currency<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="currency_id" name="currency_id" class="select2"
                                                    style="width: 100%;">
                                                    <option value="{{ $purchaseBill->currency_id }}">
                                                        {{ $purchaseBill->currency->name }}</option>
                                                    @foreach ($currencies as $currency)
                                                        <option value="{{ $currency->id }}">{{ $currency->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3 pb-1">
                                            <div class="form-group">
                                                <label for='stock_id'>Stock<strong class="text-danger">*</strong></label>
                                                <select id="stock_id" name="stock_id" class="select2"
                                                    style="width: 100%;">
                                                    <option value="{{ $stk->id }}">{{ $stk->name }}</option>
                                                    @foreach ($stocks as $stock)
                                                        <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3 pb-1">
                                            <div class="form-group">
                                                <label for='date'>Date<strong class="text-danger">*</strong></label>
                                                <input id="date" name="date" type="text" class="form-control date" required
                                                    value="{{ $purchaseBill->date }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3 pb-1">
                                            <div class="form-outline">
                                                <textarea name="details" id="details" class="form-control"
                                                    rows="1">{{ $purchaseBill->details }}</textarea>
                                                <label class="form-label" for="details">Details</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3 pb-1">
                                            <div class="table-responsive">
                                                <table class="table-scroll table table-bordered">
                                                    <thead class="table-success">
                                                        <tr>
                                                            <th width="40"></th>
                                                            <th>
                                                                <input id="item_name" list="item_names" style="width: 100%;"
                                                                    autofocus>
                                                                <datalist id="item_names">
                                                                    @foreach ($items as $item)
                                                                        <option value="{{ $item->name }}">
                                                                    @endforeach
                                                                </datalist>
                                                                <input type="hidden" id="item_id">
                                                            </th>
                                                            <th>
                                                                <select id="unit_id" title="Item Unit"
                                                                    style="width: 48%; padding: 5px 0px;" title="Item Unit">
                                                                    @foreach ($units as $unit)
                                                                        <option value="{{ $unit->id }}">
                                                                            {{ $unit->name }}</option>
                                                                    @endforeach
                                                                </select>X
                                                                <input type="text" id="unit_size" value="1"
                                                                    style="width: 40%;" title="Unit Size">
                                                            </th>
                                                            <th>
                                                                <input id="pprice" style="width: 100%;">
                                                            </th>
                                                            <th>
                                                                <input id="qty" style="width: 100%;">
                                                            </th>
                                                            <th>
                                                                <button type="button" class="btn btn-success btn-sm"
                                                                    id="btn_add" style="width: 100%;"><i
                                                                        class="fa fa-plus" aria-hidden="true"></i>
                                                                    Add</button>
                                                            </th>
                                                        </tr>
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
                                                            <tr class='dataTr' data-name='{{ $purchase->item->name }}'
                                                                data-cost='{{ $purchase->price * $purchase->unit_size }}'
                                                                data-qty='{{ $purchase->qty / $purchase->unit_size }}'
                                                                data-id='{{ $purchase->item_id }}'
                                                                data-unit='{{ $purchase->unit_id }}'
                                                                data-unit-size='{{ $purchase->unit_size }}'>
                                                                <td><input type='checkbox'
                                                                        class='hidden'>{{ $loop->iteration }}</td>
                                                                <td>{{ $purchase->item->name }}<input type='hidden'
                                                                        name='itemId[]' value="{{ $purchase->item_id }}">
                                                                </td>
                                                                <td>{{ $purchase->unit->name . ' X ' . $purchase->unit_size }}<input
                                                                        type='hidden' name='unitId[]'
                                                                        value="{{ $purchase->unit_id }}">
                                                                    <input type='hidden' name='unitSize[]'
                                                                        value="{{ $purchase->unit_size }}">
                                                                </td>
                                                                <td>{{ $purchase->price * $purchase->unit_size }} <input
                                                                        type='hidden' name='price[]'
                                                                        value="{{ $purchase->price }}">
                                                                </td>
                                                                <td>{{ $purchase->qty / $purchase->unit_size }}</td>
                                                                <input type='hidden' name='qty[]'
                                                                    value="{{ $purchase->qty }}">
                                                                <td>{{ $purchase->qty * $purchase->price }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot class="table-primary">
                                                        <tr>
                                                            <th></th>
                                                            <th>
                                                                <select name="cash_account_id" class="select2"
                                                                    id="cash_account_id" style="width: 100%;">
                                                                    <option value="{{ $purchaseBill->cash_account_id }}">
                                                                        {{ $purchaseBill->cashAccount->name }}</option>
                                                                    @foreach ($accounts as $account)
                                                                        <option value="{{ $account->id }}">
                                                                            {{ $account->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </th>
                                                            <th>
                                                                <select name="isCash" class="form-control form-control-sm"
                                                                    id="isCash" style="width: 100%;">
                                                                    @if ($purchaseBill->isCash == 1)
                                                                        <option value="1">Cash</option>
                                                                        <option value="0">Payable</option>
                                                                    @else
                                                                        <option value="0">Payable</option>
                                                                        <option value="1">Cash</option>
                                                                    @endif
                                                                </select>
                                                            </th>
                                                            <th><button type="submit" class="btn btn-sm btn-primary">
                                                                    Save(F4)</button></th>
                                                            <th>Total Qty:<span id="tot_qty"
                                                                    style="font-weight: bolder;"></span></th>
                                                            <th>Total Amount:<span id="tot_amount"
                                                                    style="font-weight: bolder;"></span></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
            $(":input").keypress(function(e) {
                if (e.which == '10' || e.which == '13') {
                    e.preventDefault();
                }
            });


            $("#btn_add").click(function() {
                addToBill();
            });
            $("#btn_add").keypress(function(e) {
                if (e.which == '10' || e.which == '13') {
                    addToBill();
                }
            });
            $("#unit_size").blur(function(e) {
                var size = $(this).val();
                var pprice = itemPrimaryPprice * size;
                $("#pprice").val(pprice);
            });

            var i = 1;

            function addToBill() {
                var item_name = $("#item_name").val();
                var item_id = $("#item_id").val();
                var price = $("#pprice").val();
                var qty = $("#qty").val();
                var unit_id = $("#unit_id").val();
                var unit_name = $("#unit_id option:selected").text();
                var unit_size = $("#unit_size").val();
                if (item_name == "") {
                    showWarning("Please Select Item!");
                    $("item_name").focus();
                    return false;
                }
                if (item_id == "") {
                    showWarning("Item Not Found!");
                    $("item_id").focus()
                    return false;
                }
                if (price == "") {
                    showWarning("Fill Purchase Return price!");
                    $("#pprice").focus()
                    return false;
                }
                if (unit_size == "") {
                    showWarning("Fill unit size!");
                    $("unit_size").focus()
                    return false;
                }


                var tbl_data = "<tr class='dataTr' data-name='" + item_name + "' data-cost='" + pprice +
                    "' data-unit='" + unit_id + "' data-unit-size='" + unit_size + "' data-qty='" + qty +
                    "' data-id='" + item_id + "'>";
                tbl_data += "<td><input  type='checkbox'  class='hidden'>" + i + "</td>";
                tbl_data += "<td>" + item_name + "<input type='hidden' name='itemId[]' value=" + item_id + "></td>";
                tbl_data += "<td>" + unit_name + " X " + unit_size + "<input type='hidden' name='unitId[]' value=" +
                    unit_id +
                    "><input type='hidden' name='unitSize[]' value=" + unit_size +
                    "></td>";
                tbl_data += "<td>" + price + "<input type='hidden' name='price[]' value=" + price + "></td>";
                tbl_data += "<td>" + qty + "</td><input type='hidden' name='qty[]' value=" + qty + ">";
                tbl_data += "<td>" + Number(qty * price) + "</td>";
                tbl_data += "</tr>";

                $("#tbl_data").append(tbl_data);
                $("#item_name").val("");
                $("#item_id").val("");
                $("#pprice").val("");
                $("#qty").val("");
                $("#item_name").focus();
                i++;
                billTotal();
            }

            billTotal();

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

            $('body').keydown(function(e) {
                if (e.keyCode === 115) {
                    frmSubmit(e);
                }
            });

            function frmSubmit(e) {
                if ($("#supplier_id").val() == "") {
                    showWarning("Please select supplier!");
                    $("#supplier_name").focus();
                    return false;
                }
                if ($("#currency_id").val() == "") {
                    showWarning("Please select Currency!");
                    $("#currency_name").focus();
                    return false;
                }
                if ($("#stock_id").val() == "") {
                    showWarning("Please select stock!");
                    $("#stock_name").focus();
                    return false;
                }
                var my_table = document.getElementById('tbl_data');
                var rows = Number(my_table.rows.length);
                if (rows == 0) {
                    e.preventDefault();
                    showWarning("Please add items!" + rows);
                    return false;
                } else {

                    $("#frm").submit();

                }
            }

            $(document).on("dblclick", ".dataTr", function() {
                $("#item_name").val($(this).attr('data-name'));
                $("#pprice").val($(this).attr('data-cost'));
                console.log($(this).attr('data-cost'));
                $("#qty").val($(this).attr('data-qty'));
                $("#item_id").val($(this).attr('data-id'));
                $("#unit_id").val($(this).attr('data-unit'));
                $("#unit_size").val($(this).attr('data-unit-size'));
                $("#qty").focus();
                $(this).remove();
                billTotal();
            })


            $(document).on("click", ".dataTr", function() {
                if ($(this).children('td').children("input[type='checkbox']").is(':checked') == false) {
                    $(".dataTr").removeClass('selected_row');
                    $("input[type='checkbox']").prop('checked', false);
                    $(this).children('td').children("input[type='checkbox']").prop('checked', true);
                    $(this).addClass("selected_row");
                } else {
                    $(this).children('td').children("input[type='checkbox']").prop('checked', false);
                    $(this).removeClass("selected_row");
                }
            })
        });
        $('body').keydown(function(e) {
            if (e.keyCode === 46 && confirm("Are you sure?") == true) {
                var tableRef = document.getElementById('tbl_data');
                var tableRows = tableRef.rows;
                var checkedIndexes = [];
                for (var i = 0; i < tableRows.length; i++) {
                    var checkboxSelected = tableRows[i].cells[0].children[0].checked;
                    if (checkboxSelected) {
                        checkedIndexes.push(i);
                    }
                }

                for (var k = checkedIndexes.length - 1; k >= 0; k--) {
                    tableRef.deleteRow(checkedIndexes[k]);
                }
                billTotal();
                $("#txt_code").focus();
            }
        });

        window.onbeforeunload = function(e) {
            return "Please click 'Stay on this Page' if you did this unintentionally";
        };
    </script>

@endsection
