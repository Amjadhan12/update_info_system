@extends('layouts.admin')
@section('title', 'Item Report')

@if (Auth::user()->language == 'Pashto')
@section('body')
    <style>
        th {
            font-weight: bolder !important;
        }

    </style>
    <main class="p-3">
        <div class="container-flued">
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm  mb-5 bg-white rounded">
                        <div class="card-header bg-primary bg-gradient">
                            <h4 class="text-white"><i class="fas fa-file-alt"></i> د جنس راپور</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group py-2">
                                <label for='item_id'>جنس<strong class="text-danger">*</strong></label>
                                <select id="item_id" class="select2" autofocus style="width: 100%;">
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group py-2">
                                <label for='fromDate'>له<strong class="text-danger">*</strong></label>
                                <input id="fromDate" type="text" class="form-control date" value="{{ date('Y-m-d') }}"
                                    autocomplete="off">
                            </div>
                            <div class="form-group py-2">
                                <label for="toDate">تر<strong class="text-danger">*</strong></label>
                                <input id="toDate" type="text" class="form-control date" value="{{ date('Y-m-d') }}"
                                    autocomplete="off">
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group py-2">
                                        <label for='supplier_id'>خريد<strong class="text-danger">*</strong></label>
                                        <select id="supplier_id" class="select2" autofocus style="width: 100%;">
                                            <option value="0">ټول</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group py-2">
                                        <button class="btn btn-primary" type="button" id="btn_show_purchase">
                                            کتل
                                        </button>
                                    </div>
                                </div>
                                <div class="col border-start">
                                    <div class="form-group py-2">
                                        <label for='customer_id'>خرڅلاو<strong class="text-danger">*</strong></label>
                                        <select id="customer_id" class="select2" autofocus style="width: 100%;">
                                            <option value="0">ټول</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group py-2">
                                        <button class="btn btn-primary" type="button" id="btn_show_sale">
                                            کتل
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card shadow-sm  mb-5 bg-white rounded">
                        <div class="card-header bg-primary bg-gradient">
                            <h4 class="text-white"><i class="fa fa-list"></i> راپور</h4>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <div class="print_div">

                            </div>

                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary" id="btn_print"><i class="fa fa-print"></i> چاپول</button>
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
        th {
            font-weight: bolder !important;
        }

    </style>
    <main class="p-3">
        <div class="container-flued">
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm  mb-5 bg-white rounded">
                        <div class="card-header bg-primary bg-gradient">
                            <h4 class="text-white"><i class="fas fa-file-alt"></i> Item Report</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group py-2">
                                <label for='item_id'>Select Item<strong class="text-danger">*</strong></label>
                                <select id="item_id" class="select2" autofocus style="width: 100%;">
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group py-2">
                                <label for='fromDate'>From<strong class="text-danger">*</strong></label>
                                <input id="fromDate" type="text" class="form-control date" value="{{ date('Y-m-d') }}"
                                    autocomplete="off">
                            </div>
                            <div class="form-group py-2">
                                <label for="toDate">To<strong class="text-danger">*</strong></label>
                                <input id="toDate" type="text" class="form-control date" value="{{ date('Y-m-d') }}"
                                    autocomplete="off">
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group py-2">
                                        <label for='supplier_id'>Purchase<strong class="text-danger">*</strong></label>
                                        <select id="supplier_id" class="select2" autofocus style="width: 100%;">
                                            <option value="0">All</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group py-2">
                                        <button class="btn btn-primary" type="button" id="btn_show_purchase">
                                            Show
                                        </button>
                                    </div>
                                </div>
                                <div class="col border-start">
                                    <div class="form-group py-2">
                                        <label for='customer_id'>Sale<strong class="text-danger">*</strong></label>
                                        <select id="customer_id" class="select2" autofocus style="width: 100%;">
                                            <option value="0">All</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group py-2">
                                        <button class="btn btn-primary" type="button" id="btn_show_sale">
                                            Show
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card shadow-sm  mb-5 bg-white rounded">
                        <div class="card-header bg-primary bg-gradient">
                            <h4 class="text-white"><i class="fa fa-list"></i> Report Result</h4>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <div class="print_div">

                            </div>

                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary" id="btn_print"><i class="fa fa-print"></i> Print</button>
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
            $("#nav_report").addClass("active");

            $(document).on("click", "#btn_show_purchase", function() {
                $.ajax({
                    url: "/ajax/report/itemPurchase",
                    type: 'GET',
                    data: {
                        "item_id": $("#item_id").val(),
                        "supplier_id": $("#supplier_id").val(),
                        "fromDate": $("#fromDate").val(),
                        "toDate": $("#toDate").val()
                    },
                    success: function(data) {
                        $(".print_div").html(data)
                    },
                    error: function() {
                        swal("Warrning", "Error occured!", "error");
                    }
                });
            })
            $(document).on("click", "#btn_show_sale", function() {
                $.ajax({
                    url: "/ajax/report/itemSale",
                    type: 'GET',
                    data: {
                        "item_id": $("#item_id").val(),
                        "customer_id": $("#customer_id").val(),
                        "fromDate": $("#fromDate").val(),
                        "toDate": $("#toDate").val()
                    },
                    success: function(data) {
                        $(".print_div").html(data)
                    },
                    error: function() {
                        swal("Warrning", "Error occured!", "error");
                    }
                });
            })
        });
    </script>

@endsection
