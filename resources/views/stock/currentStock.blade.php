@extends('layouts.adminFast')
@section('title', 'Current Stock')

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
                            <div class="row">
                                <h4 class="text-white"><i class="fa fa-list"></i> موجوده سټاک</h4>
                            </div>
                        </div>
                        <div class="card-body px-5">
                            <div class="row">
                                <div class="form-group col-8 col-md-6">
                                    <select class="form-control" id="stock_id">
                                        <option value="">- سټاک -</option>
                                        @foreach ($stocks as $stock)
                                            <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-4 col-md-6">
                                    <button class="btn btn-primary" id="btn_show_stock">کتل</button>
                                </div>
                            </div>
                            <a href="{{ url('currentStock/minusStock') }}" class="btn btn-primary">منفی</a>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm table-hover data_table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th colspan="8">په دې صفحه کې ټول قیمتونه په لومړۍ کرنسۍ ښودل
                                                کیږی({{ App\Models\Currency::first()->name }})</th>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            {{-- <th>Item Code</th> --}}
                                            <th>جنس</th>
                                            <th>ایکسپاير</th>
                                            <th>د خريد قیمت</th>
                                            <th>د خرڅلاو قیمت </th>
                                            <th>موجود تعداد</th>
                                            <th>د خرید مجموعه</th>
                                            <th>د خرڅلاو مجموعه</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbl_data">
                                        <?php
                                        $grandQty = 0;
                                        $grandAmount = 0;
                                        $grandAmountPrice = 0;
                                        $grandCost = 0;
                                        $grandPrice = 0;
                                        ?>
                                        @foreach ($items as $item)
                                            <?php
                                            
                                            $currentQty = App\Http\Controllers\FunctionController::itemQty($item->id);
                                            $cost = $item->pprice / $item->curRate;
                                            $price = $item->sprice / $item->curRate;
                                            $exp_date = App\Http\Controllers\FunctionController::itemExpDate($item->id);
                                            
                                            $grandCost += $cost;
                                            $grandPrice += $price;
                                            $grandQty += $currentQty;
                                            $grandAmount += $currentQty * $cost;
                                            $grandAmountPrice += $currentQty * $price;
                                            
                                            ?>
                                            <tr class="data_tr" data-id="{{ $item->id }}">
                                                <td>{{ $loop->iteration }}</td>
                                                {{-- <td>{{$item->barcode}}</td> --}}
                                                <td>{{ $item->name }}</td>
                                                <td>{!! $exp_date !!}</td>
                                                <td>{{ $cost }}</td>
                                                <td>{{ $price }}</td>
                                                <td>
                                                    {{ $currentQty }}
                                                </td>
                                                <td>
                                                    {{ $currentQty * $cost }}
                                                </td>
                                                <td>
                                                    {{ $currentQty * $price }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-primary" id="tbl_footer">
                                        <tr>
                                            <th></th>
                                            {{-- <th></th> --}}
                                            <th></th>
                                            <th>مجموعه</th>
                                            <th>{{ $grandCost }}</th>
                                            <th>{{ $grandPrice }}</th>
                                            <th>{{ $grandQty }}</th>
                                            <th>{{ $grandAmount }}</th>
                                            <th>{{ $grandAmountPrice }}</th>
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
                            <div class="row">
                                <h4 class="text-white"><i class="fa fa-list"></i> Current Stock</h4>
                            </div>
                        </div>
                        <div class="card-body px-5">
                            <div class="row">
                                <div class="form-group col-8 col-md-6">
                                    <select class="form-control" id="stock_id">
                                        <option value="">- Select Stock -</option>
                                        @foreach ($stocks as $stock)
                                            <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-4 col-md-6">
                                    <button class="btn btn-primary" id="btn_show_stock">View</button>
                                </div>
                            </div>
                            <a href="{{ url('currentStock/minusStock') }}" class="btn btn-primary">Minus Stock</a>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm table-hover data_table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th colspan="9">All Rates in this page are by primary currency ({{App\Models\Currency::first()->name}})</th>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>Item Code</th>
                                            <th>Item Name</th>
                                            <th>ٍExpire Date</th>
                                            <th>Cost</th>
                                            <th>S.Price</th>
                                            <th>Current Qty</th>
                                            <th>Cost Amount</th>
                                            <th>Price Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbl_data">
                                        <?php
                                        $grandQty = 0;
                                        $grandAmount = 0;
                                        $grandAmountPrice = 0;
                                        $grandCost = 0;
                                        $grandPrice = 0;
                                        ?>
                                        @foreach ($items as $item)
                                            <?php
                                            
                                            $currentQty = App\Http\Controllers\FunctionController::itemQty($item->id);
                                            $cost = $item->pprice / $item->curRate;
                                            $price = $item->sprice / $item->curRate;
                                            $exp_date = App\Http\Controllers\FunctionController::itemExpDate($item->id);
                                            
                                            $grandCost += $cost;
                                            $grandPrice += $price;
                                            $grandQty += $currentQty;
                                            $grandAmount += $currentQty * $cost;
                                            $grandAmountPrice += $currentQty * $price;
                                            
                                            ?>
                                            <tr class="data_tr" data-id="{{ $item->id }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->barcode }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{!! $exp_date !!}</td>
                                                <td>{{ $cost }}</td>
                                                <td>{{ $price }}</td>
                                                <td>
                                                    {{ $currentQty }}
                                                </td>
                                                <td>
                                                    {{ $currentQty * $cost }}
                                                </td>
                                                <td>
                                                    {{ $currentQty * $price }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-primary" id="tbl_footer">
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Grand Total</th>
                                            <th>{{ $grandCost }}</th>
                                            <th>{{ $grandPrice }}</th>
                                            <th>{{ $grandQty }}</th>
                                            <th>{{ $grandAmount }}</th>
                                            <th>{{ $grandAmountPrice }}</th>
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


@endsection
@endif

@section('pageJs')

    <script>
        $(document).ready(function() {
            $(".nav-link").removeClass('active');
            $("#nav_stock").addClass("active");

            $("input").focus();


            $("#btn_show_stock").click(function() {
                var stock_id = $("#stock_id").val();
                if (stock_id != "") {
                    window.location.href = "{{ url('currentStock/stock') }}/" + stock_id;
                } else {
                    showWarning("Please select stock!");
                }
            });

        });
    </script>

@endsection
