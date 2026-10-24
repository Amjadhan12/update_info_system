@extends('layouts.admin')
@section('title', 'Sale Return')

@if (Auth::user()->language == 'Pashto')
    @section('body')

        <main class="p-3">
            <div class="container-flued">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card shadow-sm  mb-5 bg-white rounded">
                            <div class="card-header bg-primary bg-gradient">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-white"><i class="fa fa-plus"></i> د خرڅلاو واپسي</h4>
                                    </div>
                                    <div class="col-6">
                                        <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
                                            <a class="btn btn-info" href="{{ url('/salereturnview') }}"><i
                                                    class="fa fa-eye" title="Sale View"></i> کتل</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('saleReturn.store') }}" method="post" id="frm">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="row">

                                        <div class="col-md-3 mb-3 pb-1">
                                            <div class="form-group">
                                                <label for='customer_id'>مشتری<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="customer_id" name="customer_id" class="select2" autofocus
                                                    style="width: 100%;">
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->name }}
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
                                                    value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3 pb-1">
                                            <div class="form-outline">
                                                <textarea name="details" id="details" class="form-control"
                                                    rows="1">{{ old('details') }}</textarea>
                                                <label class="form-label" for="details">وضاحت</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3 pb-1">
                                            <div class="table-responsive">
                                                <table class="table-scroll table table-bordered">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th width="40">

                                                            </th>
                                                            <th>
                                                                <input id="item_name" list="item_names"
                                                                    style="width: 100%;">
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
                                                                <input id="sprice" style="width: 100%;">
                                                            </th>
                                                            <th>
                                                                <input id="qty" style="width: 100%;">
                                                            </th>
                                                            <th>

                                                                <button type="button" class="btn btn-success btn-sm"
                                                                    id="btn_add" style="width: 30%;"><i
                                                                        class="fa fa-plus" aria-hidden="true"></i>
                                                                    Add</button>

                                                                <button type="submit" id="btn_submit"
                                                                    class="btn btn-sm btn-primary" style="width: 65%;">
                                                                    Save(F4)</button>
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
                                                    </tbody>
                                                    <tfoot class="table-primary">
                                                        <tr>
                                                            <th></th>
                                                            <th>
                                                                <select id="cash_account_id" name="cash_account_id"
                                                                    class="select2" autofocus style="width: 100%;">
                                                                    @foreach ($cashAccounts as $cashAccount)
                                                                        <option value="{{ $cashAccount->id }}">
                                                                            {{ $cashAccount->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </th>
                                                            <th>
                                                                <select name="isCash" class="form-control form-control-sm"
                                                                    id="isCash" style="width: 100%;">
                                                                    <option value="1">نغد</option>
                                                                    <option value="0">په کهاته کې</option>
                                                                </select>
                                                            </th>
                                                            <th>
                                                                {{-- <button type="submit" id="btn_submit" class="btn btn-sm btn-primary"> Save(F4)</button> --}}
                                                            </th>
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
                            <div class="card-header bg-primary bg-gradient">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-white"><i class="fa fa-plus"></i> Sale Return</h4>
                                    </div>
                                    <div class="col-6">
                                        <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
                                            <a class="btn btn-info" href="{{ url('/salereturnview') }}"><i
                                                    class="fa fa-eye" title="Sale View"></i> View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('saleReturn.store') }}" method="post" id="frm">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="row">

                                        <div class="col-md-3 mb-3 pb-1">
                                            <div class="form-group">
                                                <label for='customer_id'>customer<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="customer_id" name="customer_id" class="select2" autofocus
                                                    style="width: 100%;">
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->name }}
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
                                                    value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3 pb-1">
                                            <div class="form-outline">
                                                <textarea name="details" id="details" class="form-control"
                                                    rows="1">{{ old('details') }}</textarea>
                                                <label class="form-label" for="details">Details</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3 pb-1">
                                            <div class="table-responsive">
                                                <table class="table-scroll table table-bordered">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th width="40">

                                                            </th>
                                                            <th>
                                                                <input id="item_name" list="item_names"
                                                                    style="width: 100%;">
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
                                                                <input id="sprice" style="width: 100%;">
                                                            </th>
                                                            <th>
                                                                <input id="qty" style="width: 100%;">
                                                            </th>
                                                            <th>

                                                                <button type="button" class="btn btn-success btn-sm"
                                                                    id="btn_add" style="width: 30%;"><i
                                                                        class="fa fa-plus" aria-hidden="true"></i>
                                                                    Add</button>

                                                                <button type="submit" id="btn_submit"
                                                                    class="btn btn-sm btn-primary" style="width: 65%;">
                                                                    Save(F4)</button>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>No#</th>
                                                            <th>Item</th>
                                                            <th class="text-center">Unit X Size</th>
                                                            <th>S.Price</th>
                                                            <th>Qty</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="body-half-screen" id="tbl_data">
                                                    </tbody>
                                                    <tfoot class="table-primary">
                                                        <tr>
                                                            <th></th>
                                                            <th>
                                                                <select id="cash_account_id" name="cash_account_id"
                                                                    class="select2" autofocus style="width: 100%;">
                                                                    @foreach ($cashAccounts as $cashAccount)
                                                                        <option value="{{ $cashAccount->id }}">
                                                                            {{ $cashAccount->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </th>
                                                            <th>
                                                                <select name="isCash" class="form-control form-control-sm"
                                                                    id="isCash" style="width: 100%;">
                                                                    <option value="1">Cash</option>
                                                                    <option value="0">Receivable</option>
                                                                </select>
                                                            </th>
                                                            <th>
                                                                {{-- <button type="submit" id="btn_submit" class="btn btn-sm btn-primary"> Save(F4)</button> --}}
                                                            </th>
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
            $("#nav_sale").addClass("active");
            $(":input").keypress(function(e) {
                if (e.which == '10' || e.which == '13') {
                    e.preventDefault();
                }
            });


            var formSubmitted = false;


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
                var sprice = itemPrimarySprice * size;
                $("#sprice").val(sprice);
            });
            var i = 1;

            function addToBill() {
                var item_name = $("#item_name").val();
                var item_id = $("#item_id").val();
                var discount = $("#discount").val();
                var sprice = $("#sprice").val();
                var qty = $("#qty").val();
                var unit_id = $("#unit_id").val();
                var unit_name = $("#unit_id option:selected").text();
                var unit_size = $("#unit_size").val();
                if (item_name == "") {
                    showWarning("Please Select Item!");
                    $("#item_name").focus();
                    return false;
                }


                if (sprice == "") {
                    showWarning("Fill Sale Price!");
                    $("#sprice").focus()
                    return false;
                }

                var tbl_data = "<tr class='dataTr' data-name='" + item_name + "' data-price='" + sprice +
                    "' data-unit='" + unit_id + "' data-unit-size='" + unit_size + "' data-qty='" + qty + "' data-id='" + item_id + "'>";
                tbl_data += "<td><input  type='checkbox'  class='hidden'>" + i + "</td>";
                tbl_data += "<td>" + item_name + "<input type='hidden' name='itemId[]' value=" + item_id + "></td>";
                tbl_data += "<td>" + unit_name + " X " + unit_size + "<input type='hidden' name='unitId[]' value=" +
                    unit_id +
                    "><input type='hidden' name='unitSize[]' value=" + unit_size +
                    "></td>";
                tbl_data += "<td>" + sprice + "<input type='hidden' name='price[]' value=" + sprice + "></td>";
                tbl_data += "<td>" + qty + "</td><input type='hidden' name='qty[]' value=" + qty + ">";
                tbl_data += "<td>" + Number(qty * sprice) + "</td>";
                tbl_data += "</tr>";

                $("#tbl_data").append(tbl_data);
                $("#item_name").val("");
                $("#item_id").val("");
                $("#sprice").val("");
                $("#qty").val("");
                $("#item_name").focus();
                i++;
                billTotal();
            }


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
                    e.preventDefault();
                }
            });
            $('#btn_submit').click(function(e) {
                frmSubmit(e);
            });

            function frmSubmit(e) {

                var my_table = document.getElementById('tbl_data');
                var rows = Number(my_table.rows.length);
                if (rows == 0) {
                    e.preventDefault();
                    showWarning("Please add items!" + rows);
                    return false;
                } else {
                    if (formSubmitted == false) {
                        $("#frm").submit();
                    }
                    formSubmitted = true;
                }
            }

            $(document).on("dblclick", ".dataTr", function() {
                $("#item_name").val($(this).attr('data-name'));
                $("#sprice").val($(this).attr('data-price'));
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
                $("#item_name").focus();
            }
        });

        window.onbeforeunload = function(e) {
            return "Please click 'Stay on this Page' if you did this unintentionally";
        };
    </script>

@endsection
