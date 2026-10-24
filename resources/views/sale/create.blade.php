@extends('layouts.admin')
@section('title', 'Sale')

@if (Auth::user()->language == 'Pashto')
    @section('body')
        <style>
            .table-scroll {
                width: 100%;
                display: block;
                empty-cells: show;

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
                display: block;
                position: relative;
                width: 100%;
                overflow-y: scroll;
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
                            <div class="card-header bg-primary bg-gradient">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-white"><i class="fa fa-plus"></i> خرڅلاو</h4>
                                    </div>
                                    <div class="col-6">
                                        <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
                                            <a class="btn btn-success" href="{{ route('sale.index') }}"><i
                                                    class="fa fa-list" title="Sale List"></i> لیست</a>
                                            <a class="btn btn-info" href="{{ url('/saleview') }}"><i
                                                    class="fa fa-eye" title="Sale View"></i> کتل</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('sale.store') }}" method="post" id="frm">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="text-danger" id="prevBalance"></h5>
                                        </div>
                                        <!-- <div class="col-12">
                                            <h5 class="text-danger" id="itemQty"></h5>
                                        </div> -->
                                        <div class="col-md-3 mb-3 pb-1">
                                            <div class="form-group">
                                                <label for='customer_id'>مشتری<strong class="text-danger">*</strong>
                                                    <b class="text-primary" style="cursor: pointer"
                                                        id="btn_customer">New</b>
                                                </label>
                                                <select id="customer_id" name="customer_id" class="select2"
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
                                                            <div class="col-12">
                                                            <h5 class="text-danger" id="itemQty">QTY</h5>
                                                             </div>
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
                                                                <input id="sprice" class="number"
                                                                    style="width: 100%;">
                                                            </th>
                                                            <th>
                                                                <input id="discount" class="number"
                                                                    style="width: 100%;" value="0">
                                                            </th>
                                                            <th>
                                                                <input id="qty" class="number" style="width: 100%;"
                                                                    value="1">
                                                            </th>
                                                            <th>
                                                                <button type="button" class="btn btn-success btn-sm"
                                                                    id="btn_add" style="width: 30%;"><i
                                                                        class="fa fa-plus" aria-hidden="true"></i>
                                                                    اضافه</button>

                                                                <button type="submit" id="btn_submit"
                                                                    class="btn btn-sm btn-primary" style="width: 65%;">
                                                                    ثبتول(F4)</button>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>شماره </th>
                                                            <th>جنس</th>
                                                            <th class="text-center">Unit X Size</th>
                                                            <th>قیمت</th>
                                                            <th>تخفیف %</th>
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
                                                                د جنس تعداد: <b id="itemQty"></b>
                                                            </th>
                                                            <th>
                                                                <select id="cash_account_id" name="cash_account_id"
                                                                    class="select2" autofocus style="width: 100%;">
                                                                    @foreach ($cashAccounts as $cashAccount)
                                                                        <option value="{{ $cashAccount->id }}">
                                                                            {{ $cashAccount->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </th>
                                                            <th>تعداد:<input type="text" id="tot_qty" name="tot_qty"
                                                                    readonly placeholder="Total Qty"></th>
                                                            <th>مجموعه:<input type="text" class="number"
                                                                    id="tot_amount" name="tot_amount" title="Total Amount"
                                                                    placeholder="Total Amount">
                                                            </th>
                                                            <th>وصول:<input type="text" class="number" name="paid"
                                                                    id="paid" placeholder="Paid Amount" title="Paid Amount">
                                                            </th>
                                                            <th id="removeDis">
                                                                {{-- <button type="submit" id="btn_submit"
                                                            class="btn btn-sm btn-primary"> Save(F4)</button> --}}
                                                            </th>
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
        <!-- Modal -->
        <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">نوی مشتری</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body table-responsive">
                        <form action="{{ route('customer.store') }}" method="post" id="frm">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <input type="hidden" name="redirect_to" value="sale.create">
                            <div class="mb-3 pb-1">
                                <div class="form-outline">
                                    <input id="name" name="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" autofocus required>
                                    <label class="form-label" for='name'>د مشتری نوم<strong
                                            class="text-danger">*</strong></label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 pb-1">
                                <div class="form-outline">
                                    <input type="text" id="phone" name="phone" class="form-control"
                                        value="{{ old('phone') }}" required>
                                    <label class="form-label" for="phone">شماره<strong
                                            class="text-danger">*</strong></label>
                                </div>
                            </div>
                            <div class="mb-3 pb-1">
                                <div class="form-outline">
                                    <input type="text" id="address" name="address" class="form-control"
                                        value="{{ old('address') }}" required>
                                    <label class="form-label" for="address">ادرس<strong
                                            class="text-danger">*</strong></label>
                                </div>
                            </div>
                            <div class="mb-3 pb-1">
                                <div class="form-outline">
                                    <textarea name="details" id="details"
                                        class="form-control">{{ old('details') }}</textarea>
                                    <label class="form-label" for="details">وضاحت</label>
                                </div>
                            </div>
                            <div class="form-group my-2">
                                <button class="btn btn-primary" id="submit" type="submit"><i class="fa fa-save"></i>
                                    ثبتول</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@else
    @section('body')
        <style>
            .table-scroll {
                width: 100%;
                display: block;
                empty-cells: show;

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
                display: block;
                position: relative;
                width: 100%;
                overflow-y: scroll;
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
                            <div class="card-header bg-primary bg-gradient">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-white"><i class="fa fa-plus"></i> Sale Invoice</h4>
                                    </div>
                                    <div class="col-6">
                                        <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
                                            <a class="btn btn-success" href="{{ route('sale.index') }}"><i
                                                    class="fa fa-list" title="Sale List"></i> List</a>
                                            <a class="btn btn-info" href="{{ url('/saleview') }}"><i
                                                    class="fa fa-eye" title="Sale View"></i> View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('sale.store') }}" method="post" id="frm">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="text-danger" id="prevBalance"></h5>
                                        </div>
                                        <!-- <div class="col-12">
                                            <h5 class="text-danger" id="qty"></h5>
                                        </div> -->
                                        <div class="col-md-3 mb-3 pb-1">
                                            <div class="form-group">
                                                <label for='customer_id'>customer<strong class="text-danger">*</strong>
                                                    <b class="text-primary" style="cursor: pointer"
                                                        id="btn_customer">New</b>
                                                </label>
                                                <select id="customer_id" name="customer_id" class="select2"
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
                                                <label for='stock_id'>Stock<strong
                                                        class="text-danger">*</strong></label>
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
                                                            <div class="col-12">
                                                            <h5 class="text-danger" id="itemQty">QTY</h5>
                                                             </div>
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
                                                                <input id="sprice" class="number"
                                                                    style="width: 100%;">
                                                            </th>
                                                            <th>
                                                                <input id="discount" class="number"
                                                                    style="width: 100%;" value="0">
                                                            </th>
                                                            <th>
                                                                <input id="qty" class="number" style="width: 100%;"
                                                                    value="1">
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
                                                            <th>Dis %</th>
                                                            <th>Qty</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="body-half-screen" id="tbl_data">
                                                    </tbody>
                                                    <tfoot class="table-primary">
                                                        <tr>
                                                            <th></th>
                                                            <!-- <th>
                                                                Item Qty: <b id="itemQty"></b>
                                                            </th> -->
                                                            <th>
                                                                <select id="cash_account_id" name="cash_account_id"
                                                                    class="select2" autofocus style="width: 100%;">
                                                                    @foreach ($cashAccounts as $cashAccount)
                                                                        <option value="{{ $cashAccount->id }}">
                                                                            {{ $cashAccount->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </th>
                                                            <th>Qty:<input type="text" id="tot_qty" name="tot_qty" readonly
                                                                    placeholder="Total Qty"></th>
                                                            <th>Tot:<input type="text" class="number"
                                                                    id="tot_amount" name="tot_amount" title="Total Amount"
                                                                    placeholder="Total Amount">
                                                            </th>
                                                            <th>Paid:<input type="text" class="number" name="paid"
                                                                    id="paid" placeholder="Paid Amount" title="Paid Amount">
                                                            </th>
                                                            <th id="removeDis">
                                                                {{-- <button type="submit" id="btn_submit"
                                                            class="btn btn-sm btn-primary"> Save(F4)</button> --}}
                                                            </th>
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
        <!-- Modal -->
        <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Customer</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body table-responsive">
                        <form action="{{ route('customer.store') }}" method="post" id="frm">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <input type="hidden" name="redirect_to" value="sale.create">
                            
                            <div class="mb-3 pb-1">
                                <div class="form-outline">
                                    <input id="name" name="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" autofocus required>
                                    <label class="form-label" for='name'>Customer Name<strong
                                            class="text-danger">*</strong></label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 pb-1">
                                <div class="form-outline">
                                    <input type="text" id="phone" name="phone" class="form-control"
                                        value="{{ old('phone') }}" required>
                                    <label class="form-label" for="phone">Phone<strong
                                            class="text-danger">*</strong></label>
                                </div>
                            </div>
                            <div class="mb-3 pb-1">
                                <div class="form-outline">
                                    <input type="text" id="address" name="address" class="form-control"
                                        value="{{ old('address') }}" required>
                                    <label class="form-label" for="address">Address<strong
                                            class="text-danger">*</strong></label>
                                </div>
                            </div>
                            <div class="mb-3 pb-1">
                                <div class="form-outline">
                                    <textarea name="details" id="details"
                                        class="form-control">{{ old('details') }}</textarea>
                                    <label class="form-label" for="details">Details</label>
                                </div>
                            </div>
                            <div class="form-group my-2">
                                <button class="btn btn-primary" id="submit" type="submit"><i class="fa fa-save"></i>
                                    Save</button>
                            </div>
                        </form>
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
            $("#nav_sale").addClass("active");
            $(":input").keypress(function(e) {
                if (e.which == '10' || e.which == '13') {
                    e.preventDefault();
                }
            });

            $("#btn_customer").click(function() {
                $("#customerModal").modal("show");
            })
            var formSubmitted = false;



            $("#btn_add").click(function() {
                addToBill();
            });
            $("#btn_add").keypress(function(e) {
                if (e.which == '10' || e.which == '13') {
                    addToBill();
                }
            });
            $("#qty").keypress(function(e) {
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
                var curQty = Number($("#itemQty").html());
                var unit_id = $("#unit_id").val();
                var unit_name = $("#unit_id option:selected").text();
                var unit_size = $("#unit_size").val();
                if (qty > curQty) {
                    showWarning("Item Qty is less than selected qty!")
                    return false;
                }
                // if (qty > curQty) {
                //     showWarning("Item Qty is less than selected qty!")
                //     return true;
                // }

                if (item_name == "") {
                    showWarning("Please Select Item!");
                    $("item_name").focus();
                    return false;
                }
                if (item_id == "") {
                    // showWarning("Item Not Found!");
                    $("item_id").focus()
                    return false;
                }

                if (sprice == "") {
                    showWarning("Fill Sale Price!");
                    $("sprice").focus()
                    return false;
                }

                if (unit_size == "") {
                    showWarning("Fill unit size!");
                    $("unit_size").focus()
                    return false;
                }

                var tbl_data = "<tr class='dataTr'  data-name='" + item_name + "' data-discount='" + discount +
                    "' data-unit='" + unit_id + "' data-unit-size='" + unit_size + "' data-price='" + sprice +
                    "' data-qty='" + qty + "' data-id='" + item_id + "'>";
                tbl_data += "<td><input  type='checkbox'  class='hidden'>" + i + "</td>";
                tbl_data += "<td>" + item_name + "<input type='hidden' name='itemId[]' value=" + item_id + "></td>";
                tbl_data += "<td>" + unit_name + " X " + unit_size + "<input type='hidden' name='unitId[]' value=" +
                    unit_id +
                    "><input type='hidden' name='unitSize[]' value=" + unit_size +
                    "></td>";
                tbl_data += "<td>" + sprice + "<input type='hidden' name='price[]' value=" + sprice + "></td>";
                tbl_data += "<td>" + discount + "<input type='hidden' name='discount[]' value=" + discount +
                    "></td>";
                tbl_data += "<td>" + qty + "</td><input type='hidden' name='qty[]' value=" + qty + ">";
                tbl_data += "<td>" + Number((qty * sprice) - (qty * sprice * discount / 100)) + "</td>";
                tbl_data += "</tr>";

                $("#tbl_data").append(tbl_data);
                $("#item_name").val("");
                $("#item_id").val("");
                $("#discount").val("0");
                $("#sprice").val("");
                $("#qty").val("1");
                $("#item_name").focus();
                i++;
                billTotal();
            }


            function billTotal() {
                var my_table = document.getElementById('tbl_data');
                var total = 0;
                var totQty = 0;
                for (var a = 0; a < my_table.rows.length; a++) {
                    totQty += Number(my_table.rows[a].cells[5].innerHTML);
                    total += Number(my_table.rows[a].cells[6].innerHTML);
                }

                $("#tot_amount").val(total);
                $("#tot_qty").val(totQty);
               // $("#paid").val(total);
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
                $("#discount").val($(this).attr('data-discount'));
                $("#sprice").val($(this).attr('data-price'));
                $("#qty").val($(this).attr('data-qty'));
                $("#item_id").val($(this).attr('data-id'));
                $("#unit_id").val($(this).attr('data-unit'));
                $("#unit_size").val($(this).attr('data-unit-size'));
                $("#item_code").focus();
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

        $("#customer_id").change(function() {
            let id = $(this).val();
            $.ajax({
                url: "{{ url('customerPrevBalance') }}/" + id,
                method: 'get',
                data: {},
                success: function(data) {
                    console.log(data);
                    $("#prevBalance").html(data);
                }
            })
        })
//         $(document).ready(function() {
//     // When the item name is entered or changed
//     $("#item_name").on('input', function() {
//         let itemName = $(this).val(); // Get the item name

//         if (itemName) {
//             // Send an AJAX request to fetch the item details, including its quantity
//             $.ajax({
//                 url: "{{ url('getItemByName') }}",  
//                 method: 'GET',
//                 data: { itm_name: itemName }, 
//                 success: function(data) {
//                     if (data) {
                       
//                         let qty = data.qty || 0; 
//                         $("#qtyqty").html("Quantity: " + qty); 
//                         $("#item_id").val(data.id); 
//                     } else {
                     
//                         $("#qtyqty").html("Quantity: 0");
//                         $("#item_id").val('');  // Clear the item ID
//                     }
//                 },
//                 error: function() {
//                     // In case of an error, set quantity to 0
//                     $("#qtyqty").html("Quantity: 0");
//                 }
//             });
//         } else {
//             $("#qtyqty").html("Quantity: 0");
//             $("#item_id").val('');  // Clear the item ID
//         }
//     });
// });
    </script>
@endsection
