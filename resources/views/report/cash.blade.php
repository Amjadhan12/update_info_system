@extends('layouts.admin')
@section('title', 'Summery Report')

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
                            <h4 class="text-white"><i class="fas fa-file-alt"></i> د نغدو راپور</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group py-2">
                                <label for='currency_id'>کرنسي<strong class="text-danger">*</strong></label>
                                <select id="currency_id" class="select2" autofocus style="width: 100%;">
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
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
                            <div class="form-group py-2">
                                <button class="btn btn-primary" id="btn_show">کتل</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card shadow-sm  mb-5 bg-white rounded">
                        <div class="card-header bg-primary bg-gradient">
                            <h4 class="text-white"><i class="fa fa-list"></i>راپور</h4>
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
                            <h4 class="text-white"><i class="fas fa-file-alt"></i> Cash Flow Report</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group py-2">
                                <label for='currency_id'>Currency<strong class="text-danger">*</strong></label>
                                <select id="currency_id" class="select2" autofocus style="width: 100%;">
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
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
                            <div class="form-group py-2">
                                <button class="btn btn-primary" id="btn_show">Show</button>
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

            $(document).on("click", "#btn_show", function() {
                $.ajax({
                    url: "/ajax/report/cash",
                    type: 'GET',
                    data: {
                        "fromDate": $("#fromDate").val(),
                        "toDate": $("#toDate").val(),
                        "currency_id": $("#currency_id").val()

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
