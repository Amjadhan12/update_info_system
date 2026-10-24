@extends('layouts.admin')
@section('title', 'Current Stock (-)')

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
                                    <h4 class="text-white"><i class="fa fa-list"></i> منفی سټاک (-)</h4>
                                </div>
                            </div>
                            <div class="card-body px-5">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm table-hover data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>#</th>
                                                {{-- <th>Item Code</th> --}}
                                                <th>جنس</th>
                                                <th>د خرید قیمت</th>
                                                <th>د خرڅلاو قیمت</th>
                                                <th>تعداد</th>
                                                <th>مجموعه</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl_data">
                                            <?php
                                    $grandQty = 0;
                                    $grandAmount = 0;
                                    $i=1;
                                    foreach($items as $item){

                                    $currentQty = App\Http\Controllers\FunctionController::itemQty($item->id);
                                    $cost = $item->pprice/$item->curRate;
                                    $price = $item->sprice/$item->curRate;
                                    if($currentQty<0){
                                    
                                    $grandQty += $currentQty;
                                    $grandAmount += ($currentQty * $cost);

                                    ?>
                                            <tr class="data_tr" data-id="{{ $item->id }}">
                                                <td>{{ $i }}</td>
                                                {{-- <td>{{$item->barcode}}</td> --}}
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $cost }}</td>
                                                <td>{{ $price }}</td>
                                                <td>
                                                    {{ $currentQty }}
                                                </td>
                                                <td>
                                                    {{ $currentQty * $cost }}
                                                </td>
                                            </tr>
                                            <?php
                                        $i++;
                                        }
                                    }
                                    ?>
                                        </tbody>
                                        <tfoot class="table-primary" id="tbl_footer">
                                            <tr>
                                                {{-- <th></th> --}}
                                                <th></th>
                                                <th>مجموعه</th>
                                                <th></th>
                                                <th></th>
                                                <th>{{ $grandQty }}</th>
                                                <th>{{ $grandAmount }}</th>
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
                                    <h4 class="text-white"><i class="fa fa-list"></i> Current Stock (-)</h4>
                                </div>
                            </div>
                            <div class="card-body px-5">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm table-hover data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>#</th>
                                                <th>Item Code</th>
                                                <th>Item Name</th>
                                                <th>Cost</th>
                                                <th>S.Price</th>
                                                <th>Current Qty</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl_data">
                                            <?php
                                    $grandQty = 0;
                                    $grandAmount = 0;
                                    $i=1;
                                    foreach($items as $item){

                                    $currentQty = App\Http\Controllers\FunctionController::itemQty($item->id);
                                    $cost = $item->pprice/$item->curRate;
                                    $price = $item->sprice/$item->curRate;
                                    if($currentQty<0){
                                    
                                    $grandQty += $currentQty;
                                    $grandAmount += ($currentQty * $cost);

                                    ?>
                                            <tr class="data_tr" data-id="{{ $item->id }}">
                                                <td>{{ $i }}</td>
                                                <td>{{ $item->barcode }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $cost }}</td>
                                                <td>{{ $price }}</td>
                                                <td>
                                                    {{ $currentQty }}
                                                </td>
                                                <td>
                                                    {{ $currentQty * $cost }}
                                                </td>
                                            </tr>
                                            <?php
                                        $i++;
                                        }
                                    }
                                    ?>
                                        </tbody>
                                        <tfoot class="table-primary" id="tbl_footer">
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th>Grand Total</th>
                                                <th></th>
                                                <th></th>
                                                <th>{{ $grandQty }}</th>
                                                <th>{{ $grandAmount }}</th>
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

        });
    </script>

@endsection
