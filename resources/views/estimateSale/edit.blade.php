@extends('layouts.admin')
@section('title', 'Edit Sale')

@if (Auth::user()->language == 'Pashto')
    @section('body')

        <main class="p-3">
            <div class="container-flued">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-sm  mb-5 bg-white rounded">
                            <div class="card-header bg-danger">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-white"><i class="fa fa-edit"></i> د مشتری په ارډر کې تغیر</h4>
                                    </div>
                                    <div class="col-6">
                                        <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
                                            <a class="btn btn-info" href="{{ url('/estimatesaleview') }}"><i
                                                    class="fa fa-eye" title="Sale View"></i> View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('estimateSale.update', $saleBill->id) }}" method="post" id="frm">
                                    @csrf
                                    @method("put")
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="row">

                                        <div class="col-md-3 mb-3 pb-1">
                                            <div class="form-group">
                                                <label for='customer_id'>مشتری<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="customer_id" name="customer_id" class="select2" autofocus
                                                    style="width: 100%;">
                                                    <option value="{{ $saleBill->customer_id }}">
                                                        {{ $saleBill->customer->name }}
                                                    </option>

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
                                                <select id="currency_id" name="currency_id" class="select2" autofocus
                                                    style="width: 100%;">
                                                    <option value="{{ $saleBill->currency_id }}">
                                                        {{ $saleBill->currency->name }}
                                                    </option>
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
                                                    value="{{ $saleBill->date }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3 pb-1">
                                            <div class="form-outline">
                                                <textarea name="details" id="details" class="form-control"
                                                    rows="1">{{ $saleBill->details }}</textarea>
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
                                                                <input id="sprice" style="width: 100%;">
                                                            </th>
                                                            <th>
                                                                <input id="discount" style="width: 100%;" value="0">
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
                                                            <th>No#</th>
                                                            <th>جنس</th>
                                                            <th>د خرڅلاو قیمت</th>
                                                            <th>Dis %</th>
                                                            <th>تعداد</th>
                                                            <th>مجموعه</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="body-half-screen" id="tbl_data">
                                                        @foreach ($sales as $sale)
                                                            <tr class='dataTr' data-name='{{ $sale->item->name }}'
                                                                data-discount='{{ $sale->discount }}'
                                                                data-price='{{ $sale->price }}'
                                                                data-qty='{{ $sale->qty }}'
                                                                data-id='{{ $sale->item_id }}'>
                                                                <td><input type='checkbox'
                                                                        class='hidden'>{{ $loop->iteration }}</td>
                                                                <td>{{ $sale->item->name }}<input type='hidden'
                                                                        name='itemId[]' value="{{ $sale->item_id }}">
                                                                </td>
                                                                <td>{{ $sale->price }} <input type='hidden'
                                                                        name='price[]' value="{{ $sale->price }}"></td>
                                                                <td>{{ $sale->discount }}<input type='hidden'
                                                                        name='discount[]' value="{{ $sale->discount }}">
                                                                </td>
                                                                <td>{{ $sale->qty }}</td><input type='hidden'
                                                                    name='qty[]' value="{{ $sale->qty }}">
                                                                <td>{{ $sale->qty * $sale->price - ($sale->qty * $sale->price * $sale->discount) / 100 }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot class="table-primary">
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
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
                            <div class="card-header bg-danger">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-white"><i class="fa fa-edit"></i> Edit Estimate Sale Invoice
                                        </h4>
                                    </div>
                                    <div class="col-6">
                                        <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
                                            <a class="btn btn-info" href="{{ url('/estimatesaleview') }}"><i
                                                    class="fa fa-eye" title="Sale View"></i> View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('estimateSale.update', $saleBill->id) }}" method="post" id="frm">
                                    @csrf
                                    @method("put")
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="row">

                                        <div class="col-md-3 mb-3 pb-1">
                                            <div class="form-group">
                                                <label for='customer_id'>customer<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="customer_id" name="customer_id" class="select2" autofocus
                                                    style="width: 100%;">
                                                    <option value="{{ $saleBill->customer_id }}">
                                                        {{ $saleBill->customer->name }}
                                                    </option>

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
                                                <select id="currency_id" name="currency_id" class="select2" autofocus
                                                    style="width: 100%;">
                                                    <option value="{{ $saleBill->currency_id }}">
                                                        {{ $saleBill->currency->name }}
                                                    </option>
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
                                                    value="{{ $saleBill->date }}">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3 pb-1">
                                            <div class="form-outline">
                                                <textarea name="details" id="details" class="form-control"
                                                    rows="1">{{ $saleBill->details }}</textarea>
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
                                                                <input id="sprice" style="width: 100%;">
                                                            </th>
                                                            <th>
                                                                <input id="discount" style="width: 100%;" value="0">
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
                                                            <th>S.Price</th>
                                                            <th>Dis %</th>
                                                            <th>Qty</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="body-half-screen" id="tbl_data">
                                                        @foreach ($sales as $sale)
                                                            <tr class='dataTr' data-name='{{ $sale->item->name }}'
                                                                data-discount='{{ $sale->discount }}'
                                                                data-price='{{ $sale->price }}'
                                                                data-qty='{{ $sale->qty }}'
                                                                data-id='{{ $sale->item_id }}'>
                                                                <td><input type='checkbox'
                                                                        class='hidden'>{{ $loop->iteration }}</td>
                                                                <td>{{ $sale->item->name }}<input type='hidden'
                                                                        name='itemId[]' value="{{ $sale->item_id }}">
                                                                </td>
                                                                <td>{{ $sale->price }} <input type='hidden'
                                                                        name='price[]' value="{{ $sale->price }}"></td>
                                                                <td>{{ $sale->discount }}<input type='hidden'
                                                                        name='discount[]' value="{{ $sale->discount }}">
                                                                </td>
                                                                <td>{{ $sale->qty }}</td><input type='hidden'
                                                                    name='qty[]' value="{{ $sale->qty }}">
                                                                <td>{{ $sale->qty * $sale->price - ($sale->qty * $sale->price * $sale->discount) / 100 }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot class="table-primary">
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
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
            $("#nav_sale").addClass("active");
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

            var i = 1;

            function addToBill() {
                var item_name = $("#item_name").val();
                var item_id = $("#item_id").val();
                var discount = $("#discount").val();
                var sprice = $("#sprice").val();
                var qty = $("#qty").val();
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

                if (sprice == "") {
                    showWarning("Fill Sale Price!");
                    $("sprice").focus()
                    return false;
                }

                var tbl_data = "<tr class='dataTr' data-name='" + item_name + "' data-discount='" + discount +
                    "' data-price='" + sprice + "' data-qty='" + qty + "' data-id='" + item_id + "'>";
                tbl_data += "<td><input  type='checkbox'  class='hidden'>" + i + "</td>";
                tbl_data += "<td>" + item_name + "<input type='hidden' name='itemId[]' value=" + item_id + "></td>";
                tbl_data += "<td>" + sprice + "<input type='hidden' name='price[]' value=" + sprice + "></td>";
                tbl_data += "<td>" + discount + "<input type='hidden' name='discount[]' value=" + discount +
                    "></td>";
                tbl_data += "<td>" + qty + "</td><input type='hidden' name='qty[]' value=" + qty + ">";
                tbl_data += "<td>" + Number((qty * sprice) - (qty * sprice * discount / 100)) + "</td>";
                tbl_data += "</tr>";

                $("#tbl_data").append(tbl_data);
                $("#item_name").val("");
                $("#item_id").val("");
                $("#item_id").val("");
                $("#discount").val("");
                $("#sprice").val("");
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
                $("#discount").val($(this).attr('data-discount'));
                $("#sprice").val($(this).attr('data-price'));
                $("#qty").val($(this).attr('data-qty'));
                $("#item_id").val($(this).attr('data-id'));
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
