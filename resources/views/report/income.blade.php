@extends('layouts.admin')
@section('title', 'Income Statement')

@if (Auth::user()->language == 'Pashto')
@section('body')
    <main class="app-content">
        <div class="row">
            <div class="col-lg-4">
                <div class="tile">
                    <div class="tile-title-w-btn">
                        <h3 class="title">مالی راپور</h3>
                        <!-- <div class="btn-group" role="group">
                            <a class="btn btn-outline-primary" href="{{ route('item.create') }}">
                                <i class="fa fa-plus"></i> New Item
                            </a>
                        </div> -->
                    </div>
                    <hr />
                    <div class="tile-body">
                        <div class="form-group">
                            <label for='fromDate'>له نیټې<strong class="text-danger">*</strong></label>
                            <input id="fromDate" type="text" class="form-control date" value="{{ date('Y-m-d') }}"
                                autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="toDate">تر نیټې پورې<strong class="text-danger">*</strong></label>
                            <input id="toDate" type="text" class="form-control date" value="{{ date('Y-m-d') }}"
                                autocomplete="off">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" id="btn_show">کتل</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 tile">
                <div class="print_div" style="direction: rtl;">

                </div>
                <div class="tile-footer">
                    <button class="btn btn-primary" id="btn_print"><i class="fa fa-print"></i> چاپول</button>
                </div>
            </div>
        </div>
    </main>

@endsection
@else
@section('body')
    <main class="app-content">
        <div class="row">
            <div class="col-lg-4">
                <div class="tile">
                    <div class="tile-title-w-btn">
                        <h3 class="title">مالی راپور</h3>
                        <!-- <div class="btn-group" role="group">
                            <a class="btn btn-outline-primary" href="{{ route('item.create') }}">
                                <i class="fa fa-plus"></i> New Item
                            </a>
                        </div> -->
                    </div>
                    <hr />
                    <div class="tile-body">
                        <div class="form-group">
                            <label for='fromDate'>له نیټې<strong class="text-danger">*</strong></label>
                            <input id="fromDate" type="text" class="form-control date" value="{{ date('Y-m-d') }}"
                                autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="toDate">تر نیټې پورې<strong class="text-danger">*</strong></label>
                            <input id="toDate" type="text" class="form-control date" value="{{ date('Y-m-d') }}"
                                autocomplete="off">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" id="btn_show">ښودل</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 tile">
                <div class="print_div" style="direction: rtl;">

                </div>
                <div class="tile-footer">
                    <button class="btn btn-primary" id="btn_print"><i class="fa fa-print"></i> چاپول</button>
                </div>
            </div>
        </div>
    </main>

@endsection
@endif

@section('pageJs')
    <script type="text/javascript">
        $(".app-menu").removeClass("active");
        $("#nav_report").addClass("active");
        $("#nav_reporti").addClass("is-expanded");
        $("#nav_sub_report_financial").addClass("active");


        $(document).on("click", "#btn_show", function() {

            $.ajax({
                url: "/ajax/report/income",
                type: 'GET',
                data: {
                    "fromDate": $("#fromDate").val(),
                    "toDate": $("#toDate").val(),

                },
                success: function(data) {
                    $(".print_div").html(data)
                },
                error: function() {
                    swal("Warrning", "مشکل رامنځ ته شو!", "error");
                }
            });
        })
    </script>
@endsection
