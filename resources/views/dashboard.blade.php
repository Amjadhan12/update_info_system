@extends('layouts.admin')
@section('title', 'Dashboard')

@if (Auth::user()->language == 'Pashto')
    @section('body')
        <main class="p-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <style>
                            .footer-hover {
                                background-color: rgba(0, 0, 0, 0.1);
                                -webkit-transition: all .3s ease-in-out;
                                transition: all .3s ease-in-out
                            }

                            .footer-hover:hover {
                                background-color: rgba(0, 0, 0, 0.2)
                            }

                            .text-black-40 {
                                color: rgba(0, 0, 0, 0.4)
                            }
                        </style>

                        <!-- Grid row -->
                        <div class="row">

                            <!-- Grid column -->
                            <div class="col-md-6 col-lg-3 mb-4">

                                <!-- Card -->
                                <div class="card bg-secondary">
                                    <div class="card-body d-flex text-light justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">
                                                @php
                                                    $currencies = App\Models\Currency::get();
                                                @endphp
                                                @foreach ($currencies as $currency)
                                                    <?php
                                                    $totPurchase = App\Http\Controllers\FunctionController::totPurchase(0, $currency->id);
                                                    
                                                    echo round($totPurchase, 1) . ' ' . $currency->name . '<br>';
                                                    ?>
                                                @endforeach
                                            </p>
                                            <p class="mb-0"> مجموعه خریداری</p>
                                        </div>
                                        <div>
                                            <i class="fa fa-cart-arrow-down fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                    <a href="{{ route('purchase.create') }}"
                                        class="card-footer footer-hover small text-center white-text border-0 p-2 text-light">نوی<i
                                            class="fas fa-arrow-circle-right pl-2"></i></a>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-6 col-lg-3 mb-4">

                                <!-- Card -->
                                <div class="card bg-warning text-light">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">
                                                @foreach ($currencies as $currency)
                                                    <?php
                                                    $totSale = App\Http\Controllers\FunctionController::totSale(0, $currency->id);
                                                    echo round($totSale, 1) . ' ' . $currency->name . '<br>';
                                                    ?>
                                                @endforeach
                                            </p>
                                            <p class="mb-0">مجموعه خرڅلاو</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-cart-plus fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                    <a href="{{ route('sale.create') }}"
                                        class="card-footer footer-hover small text-center border-0 p-2 text-light">نوی<i
                                            class="fas fa-arrow-circle-right pl-2"></i></a>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-6 col-lg-3 mb-4">

                                <!-- Card -->
                                <div class="card bg-info lighten-1 text-light">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">
                                                @foreach ($currencies as $currency)
                                                    <?php
                                                    $openPayable = App\Models\OpenPayable::where(['currency_id' => $currency->id])->sum('amount');
                                                    $totPurchase = App\Http\Controllers\FunctionController::totPurchase(0, $currency->id);
                                                    $totReturn = App\Http\Controllers\FunctionController::totPurchaseReturn(0, $currency->id);
                                                    $totPayment = App\Models\Payment::where(['currency_id' => $currency->id])->sum('amount');
                                                    
                                                    echo round($openPayable + $totPurchase - $totReturn - $totPayment, 1) . ' ' . $currency->name . '<br>';
                                                    ?>
                                                @endforeach
                                            </p>
                                            <p class="mb-0">د شرکتونه قرض</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-money-bill fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                    <a href="{{ route('payment.index') }}"
                                        class="card-footer footer-hover small text-center border-0 p-2 text-light">وصولی
                                        کول<i class="fas fa-arrow-circle-right pl-2 text-light"></i></a>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-6 col-lg-3 mb-4">

                                <!-- Card -->
                                <div class="card bg-danger accent-2 text-light">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">
                                                @foreach ($currencies as $currency)
                                                    <?php
                                                    $openReceivable = App\Models\OpenReceivable::where(['currency_id' => $currency->id])->sum('amount');
                                                    $totSale = App\Http\Controllers\FunctionController::totSale(0, $currency->id);
                                                    $totReturn = App\Http\Controllers\FunctionController::totSaleReturn(0, $currency->id);
                                                    $totReceived = App\Models\Received::where(['currency_id' => $currency->id])->sum('amount');
                                                    
                                                    echo round($openReceivable + $totSale - $totReturn - $totReceived, 1) . ' ' . $currency->name . '<br>';
                                                    ?>
                                                @endforeach
                                            </p>
                                            <p class="mb-0">په مشتریانو قرض</p>
                                        </div>
                                        <div>
                                            <i class="fa fa-users fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                    <a href="{{ route('received.index') }}"
                                        class="card-footer footer-hover small text-center text-light border-0 p-2">وصولی
                                        کول<i class="fas fa-arrow-circle-right pl-2"></i></a>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->

                        </div>
                        <!-- Grid row -->

                        {{-- todays content --}}
                        <!-- Grid row -->
                        <div class="row">

                            <!-- Grid column -->
                            <div class="col-md-6 col-lg-3 mb-4">

                                <!-- Card -->
                                <div class="card bg-info">
                                    <div class="card-body d-flex text-light justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">
                                                @php
                                                    $saleProfit = App\Http\Controllers\FunctionController::todayProfit();
                                                    echo $saleProfit['totalSale'] . ' ' . App\Models\Currency::first()->name;
                                                @endphp
                                            </p>
                                            <p class="mb-0"> د نن ورځې خرڅلاو</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-money-bill fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-6 col-lg-3 mb-4">

                                <!-- Card -->
                                <div class="card bg-primary text-light">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">
                                                @php
                                                    echo $saleProfit['profit'] . ' ' . App\Models\Currency::first()->name;
                                                @endphp
                                            </p>
                                            <p class="mb-0"> د نن ورځې ګټه</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-money-bill fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-6 col-lg-3 mb-4">

                                <!-- Card -->
                                <div class="card bg-success lighten-1 text-light">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">
                                                @php
                                                    $totPurchase = App\Http\Controllers\FunctionController::todayPurchase();
                                                    echo $totPurchase . ' ' . App\Models\Currency::first()->name;
                                                @endphp
                                            </p>
                                            <p class="mb-0">د نن ورځې خریداری</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-money-bill fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-6 col-lg-3 mb-4">

                                <!-- Card -->
                                <div class="card bg-secondary accent-2 text-light">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">
                                                @php
                                                $todayExpense = App\Http\Controllers\FunctionController::todayExpense();
                                                echo $todayExpense . ' ' . App\Models\Currency::first()->name;
                                            @endphp
                                            </p>
                                            <p class="mb-0">د نن  ورځې مصارف</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-money-bill fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->

                        </div>
                        <!-- Grid row -->
                    </div>

                    <div class="col-lg-3 col-md-6 col-12 mb-3">
                        <div class="list-group">
                            <a href="javascript:;" class="list-group-item list-group-item-action text-light bg-primary"
                                aria-current="true" style="font-weight: bold;">
                                <i class="fa fa-cart-arrow-down"></i> خریداری
                            </a>
                            <a href="{{ route('purchase.create') }}"
                                class="list-group-item list-group-item-action">نوې</a>
                            <!-- <a href="{{ route('purchase.index') }}" class="list-group-item list-group-item-action">Purchase List</a> -->
                            <a href="{{ url('purchaseview') }}" class="list-group-item list-group-item-action">کتل</a>
                            <a href="{{ route('purchaseReturn.create') }}"
                                class="list-group-item list-group-item-action">د
                                خریداری واپسي</a>
                            <a href="{{ route('payment.index') }}" class="list-group-item list-group-item-action">شرکت ته
                                وصولی</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12 mb-3">
                        <div class="list-group">
                            <a href="javascript:;" class="list-group-item list-group-item-action text-light bg-primary"
                                aria-current="true" style="font-weight: bold;">
                                <i class="fa fa-cart-plus"></i> خرڅلاو
                            </a>
                            <a href="{{ route('sale.create') }}" class="list-group-item list-group-item-action">نوی</a>
                            <!-- <a href="{{ route('sale.index') }}" class="list-group-item list-group-item-action">Sale List</a> -->
                            <a href="{{ url('saleview') }}" class="list-group-item list-group-item-action">کتل</a>
                            <a href="{{ route('saleReturn.create') }}" class="list-group-item list-group-item-action">د
                                خرڅلاو
                                واپسي</a>
                            <a href="{{ route('received.index') }}" class="list-group-item list-group-item-action">د
                                مشتری
                                وصولی</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12 mb-3">
                        <div class="list-group">
                            <a href="javascript:;" class="list-group-item list-group-item-action text-light bg-primary"
                                aria-current="true" style="font-weight: bold;">
                                <i class="fa fa-plus"></i> اضافه کول
                            </a>
                            <a href="{{ route('item.index') }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                جنسونه <span class="badge bg-dark rounded-pill">{{ App\Models\Item::count() }}</span>
                            </a>
                            <a href="{{ route('customer.index') }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                مشتری <span class="badge bg-dark rounded-pill">{{ App\Models\Customer::count() }}</span>
                            </a>
                            <a href="{{ route('supplier.index') }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                شرکت <span class="badge bg-dark rounded-pill">{{ App\Models\Supplier::count() }}</span>
                            </a>
                            <a href="{{ route('stock.index') }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                ګودامونه <span class="badge bg-dark rounded-pill">{{ App\Models\Stock::count() }}</span>
                            </a>
                            <!-- <a href="{{ route('currency.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                        Currencies <span class="badge bg-dark rounded-pill">{{ App\Models\Currency::count() }}</span>
                                                    </a> -->
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12 mb-3">
                        <div class="list-group">
                            <a href="javascript:;" class="list-group-item list-group-item-action text-light bg-primary"
                                aria-current="true" style="font-weight: bold;">
                                <i class="fa fa-plus"></i> جنسونه د تعداد له درکه
                            </a>
                            <button data-low="0" data-high="0"
                                class="btn-get-qty list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                صفر تعداد اجناس <span class="badge bg-danger rounded-pill">
                                    {{ App\Http\Controllers\FunctionController::itemsQtySpecific(0, 0, $state = 'Less') }}
                                </span>
                            </button>
                            <button data-low="0" data-high="10"
                                class="btn-get-qty list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                له لس څخه په کم تعداد اجناس <span class="badge bg-warning rounded-pill">
                                    {{ App\Http\Controllers\FunctionController::itemsQtySpecific(10, 0, $state = 'Less') }}
                                </span>
                            </button>
                            <button data-low="10" data-high="100"
                                class="btn-get-qty list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                له سل څخه په کم تعداد اجناس <span class="badge bg-primary rounded-pill">
                                    {{ App\Http\Controllers\FunctionController::itemsQtySpecific(100, 10, $state = 'Less') }}
                                </span>
                            </button>
                            <button data-low="100" data-high="0"
                                class="btn-get-qty list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                له سل څخه په زیات تعداد اجناس <span class="badge bg-success rounded-pill">
                                    {{ App\Http\Controllers\FunctionController::itemsQtySpecific(100, 0, $state = 'Greater') }}
                                </span>
                            </button>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 mb-3">
                        <div class="card shadow-sm bg-white rounded">
                            <div class="card-header bg-primary">
                                <h4 class="text-white"><i class="fas fa-chart-bar"></i> د روان کال خرید او خرڅلاو</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-3">
                        <div class="card shadow-sm bg-white rounded">
                            <div class="card-header bg-primary">
                                <h4 class="text-white"><i class="fas fa-chart-pie"></i> مصارف</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="expChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>

                </div>



            </div>
        </main>
        <!-- Modal -->
        <div class="modal fade" id="itemsQtyModel" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">د تعداد له مخې جنسونه</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body table-responsive">
                        <div class="print_div">
                            <table class='table table-bordered'>
                                <thead>
                                    <tr>
                                        <th class="text-center" colspan="5" id="data_header"></th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>جنس</th>
                                        <th>د خرید قیمت</th>
                                        <th>تعداد</th>
                                        <th>مجموعه</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_data_body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="btn_print"><i class="fa fa-print"></i> چاپول</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@else
    @section('body')
        <main class="p-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <style>
                            .footer-hover {
                                background-color: rgba(0, 0, 0, 0.1);
                                -webkit-transition: all .3s ease-in-out;
                                transition: all .3s ease-in-out
                            }

                            .footer-hover:hover {
                                background-color: rgba(0, 0, 0, 0.2)
                            }

                            .text-black-40 {
                                color: rgba(0, 0, 0, 0.4)
                            }
                        </style>

                        <!-- Grid row -->
                        <div class="row">

                            <!-- Grid column -->
                            <div class="col-md-6 col-lg-3 mb-4">

                                <!-- Card -->
                                <div class="card bg-secondary">
                                    <div class="card-body d-flex text-light justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">
                                                @php
                                                    $currencies = App\Models\Currency::get();
                                                @endphp
                                                @foreach ($currencies as $currency)
                                                    <?php
                                                    $totPurchase = App\Http\Controllers\FunctionController::totPurchase(0, $currency->id);
                                                    
                                                    echo round($totPurchase, 1) . ' ' . $currency->name . '<br>';
                                                    ?>
                                                @endforeach
                                            </p>
                                            <p class="mb-0"> Total Purchase</p>
                                        </div>
                                        <div>
                                            <i class="fa fa-cart-arrow-down fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                    <a href="{{ route('purchase.create') }}"
                                        class="card-footer footer-hover small text-center white-text border-0 p-2 text-light">Add
                                        new<i class="fas fa-arrow-circle-right pl-2"></i></a>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-6 col-lg-3 mb-4">

                                <!-- Card -->
                                <div class="card bg-warning text-light">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">
                                                @foreach ($currencies as $currency)
                                                    <?php
                                                    $totSale = App\Http\Controllers\FunctionController::totSale(0, $currency->id);
                                                    echo round($totSale, 1) . ' ' . $currency->name . '<br>';
                                                    ?>
                                                @endforeach
                                            </p>
                                            <p class="mb-0">Total Sales</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-cart-plus fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                    <a href="{{ route('sale.create') }}"
                                        class="card-footer footer-hover small text-center border-0 p-2 text-light">Add
                                        new<i class="fas fa-arrow-circle-right pl-2"></i></a>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-6 col-lg-3 mb-4">

                                <!-- Card -->
                                <div class="card bg-info lighten-1 text-light">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">
                                                @foreach ($currencies as $currency)
                                                    <?php
                                                    $openPayable = App\Models\OpenPayable::where(['currency_id' => $currency->id])->sum('amount');
                                                    $totPurchase = App\Http\Controllers\FunctionController::totPurchase(0, $currency->id);
                                                    $totReturn = App\Http\Controllers\FunctionController::totPurchaseReturn(0, $currency->id);
                                                    $totPayment = App\Models\Payment::where(['currency_id' => $currency->id])->sum('amount');
                                                    
                                                    echo round($openPayable + $totPurchase - $totReturn - $totPayment, 1) . ' ' . $currency->name . '<br>';
                                                    ?>
                                                @endforeach
                                            </p>
                                            <p class="mb-0">Payables</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-money-bill fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                    <a href="{{ route('payment.index') }}"
                                        class="card-footer footer-hover small text-center border-0 p-2 text-light">Add
                                        New<i class="fas fa-arrow-circle-right pl-2 text-light"></i></a>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-6 col-lg-3 mb-4">

                                <!-- Card -->
                                <div class="card bg-danger accent-2 text-light">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">
                                                @foreach ($currencies as $currency)
                                                    <?php
                                                    $openReceivable = App\Models\OpenReceivable::where(['currency_id' => $currency->id])->sum('amount');
                                                    $totSale = App\Http\Controllers\FunctionController::totSale(0, $currency->id);
                                                    $totReturn = App\Http\Controllers\FunctionController::totSaleReturn(0, $currency->id);
                                                    $totReceived = App\Models\Received::where(['currency_id' => $currency->id])->sum('amount');
                                                    
                                                    echo round($openReceivable + $totSale - $totReturn - $totReceived, 1) . ' ' . $currency->name . '<br>';
                                                    ?>
                                                @endforeach
                                            </p>
                                            <p class="mb-0">Receivables</p>
                                        </div>
                                        <div>
                                            <i class="fa fa-users fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                    <a href="{{ route('received.index') }}"
                                        class="card-footer footer-hover small text-center text-light border-0 p-2">Add
                                        new<i class="fas fa-arrow-circle-right pl-2"></i></a>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->

                        </div>
                        <!-- Grid row -->

                         {{-- todays content --}}
                        <!-- Grid row -->
                        <div class="row">

                            <!-- Grid column -->
                            <div class="col-md-6 col-lg-3 mb-4">

                                <!-- Card -->
                                <div class="card bg-info">
                                    <div class="card-body d-flex text-light justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">
                                                @php
                                                    $saleProfit = App\Http\Controllers\FunctionController::todayProfit();
                                                    echo $saleProfit['totalSale'] . ' ' . App\Models\Currency::first()->name;
                                                @endphp
                                            </p>
                                            <p class="mb-0"> Today's Sales</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-money-bill fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-6 col-lg-3 mb-4">

                                <!-- Card -->
                                <div class="card bg-primary text-light">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">
                                                @php
                                                    echo $saleProfit['profit'] . ' ' . App\Models\Currency::first()->name;
                                                @endphp
                                            </p>
                                            <p class="mb-0"> Today's Profit</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-money-bill fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-6 col-lg-3 mb-4">

                                <!-- Card -->
                                <div class="card bg-success lighten-1 text-light">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">
                                                @php
                                                    $totPurchase = App\Http\Controllers\FunctionController::todayPurchase();
                                                    echo $totPurchase . ' ' . App\Models\Currency::first()->name;
                                                @endphp
                                            </p>
                                            <p class="mb-0">Today's Purchases</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-money-bill fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-md-6 col-lg-3 mb-4">

                                <!-- Card -->
                                <div class="card bg-secondary accent-2 text-light">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="h2-responsive font-weight-bold mt-n2 mb-0">
                                                @php
                                                $todayExpense = App\Http\Controllers\FunctionController::todayExpense();
                                                echo $todayExpense . ' ' . App\Models\Currency::first()->name;
                                            @endphp
                                            </p>
                                            <p class="mb-0">Today's Expenses</p>
                                        </div>
                                        <div>
                                            <i class="fas fa-money-bill fa-4x text-black-40"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card -->

                            </div>
                            <!-- Grid column -->

                        </div>
                        <!-- Grid row -->
                    </div>

                    <div class="col-lg-3 col-md-6 col-12 mb-3">
                        <div class="list-group">
                            <a href="javascript:;" class="list-group-item list-group-item-action text-light bg-primary"
                                aria-current="true" style="font-weight: bold;">
                                <i class="fa fa-cart-arrow-down"></i> Purchase
                            </a>
                            <a href="{{ route('purchase.create') }}" class="list-group-item list-group-item-action">New
                                Purchase</a>
                            <!-- <a href="{{ route('purchase.index') }}" class="list-group-item list-group-item-action">Purchase List</a> -->
                            <a href="{{ url('purchaseview') }}" class="list-group-item list-group-item-action">Purchase
                                View</a>
                            <a href="{{ route('purchaseReturn.create') }}"
                                class="list-group-item list-group-item-action">Purchase
                                Return</a>
                            <a href="{{ route('payment.index') }}"
                                class="list-group-item list-group-item-action">Purchase
                                Payment</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12 mb-3">
                        <div class="list-group">
                            <a href="javascript:;" class="list-group-item list-group-item-action text-light bg-primary"
                                aria-current="true" style="font-weight: bold;">
                                <i class="fa fa-cart-plus"></i> Sale
                            </a>
                            <a href="{{ route('sale.create') }}" class="list-group-item list-group-item-action">New
                                Sale</a>
                            <!-- <a href="{{ route('sale.index') }}" class="list-group-item list-group-item-action">Sale List</a> -->
                            <a href="{{ url('saleview') }}" class="list-group-item list-group-item-action">Sale
                                View</a>
                            <a href="{{ route('saleReturn.create') }}"
                                class="list-group-item list-group-item-action">Sale
                                Return</a>
                            <a href="{{ route('received.index') }}" class="list-group-item list-group-item-action">Sale
                                Receipt</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12 mb-3">
                        <div class="list-group">
                            <a href="javascript:;" class="list-group-item list-group-item-action text-light bg-primary"
                                aria-current="true" style="font-weight: bold;">
                                <i class="fa fa-plus"></i> Add
                            </a>
                            <a href="{{ route('item.index') }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Items <span class="badge bg-dark rounded-pill">{{ App\Models\Item::count() }}</span>
                            </a>
                            <a href="{{ route('customer.index') }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Customers <span
                                    class="badge bg-dark rounded-pill">{{ App\Models\Customer::count() }}</span>
                            </a>
                            <a href="{{ route('supplier.index') }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Suppliers <span
                                    class="badge bg-dark rounded-pill">{{ App\Models\Supplier::count() }}</span>
                            </a>
                            <a href="{{ route('stock.index') }}"
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Stocks <span class="badge bg-dark rounded-pill">{{ App\Models\Stock::count() }}</span>
                            </a>
                            <!-- <a href="{{ route('currency.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                        Currencies <span class="badge bg-dark rounded-pill">{{ App\Models\Currency::count() }}</span>
                                                    </a> -->
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12 mb-3">
                        <div class="list-group">
                            <a href="javascript:;" class="list-group-item list-group-item-action text-light bg-primary"
                                aria-current="true" style="font-weight: bold;">
                                <i class="fa fa-plus"></i> Items From Qty
                            </a>
                            <button data-low="0" data-high="0"
                                class="btn-get-qty list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Items with Zero Qty <span class="badge bg-danger rounded-pill">
                                    {{ App\Http\Controllers\FunctionController::itemsQtySpecific(0, 0, $state = 'Less') }}
                                </span>
                            </button>
                            <button data-low="0" data-high="10"
                                class="btn-get-qty list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Items with less than 10 Qty <span class="badge bg-warning rounded-pill">
                                    {{ App\Http\Controllers\FunctionController::itemsQtySpecific(10, 0, $state = 'Less') }}
                                </span>
                            </button>
                            <button data-low="10" data-high="100"
                                class="btn-get-qty list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Items with less than 100 Qty <span class="badge bg-primary rounded-pill">
                                    {{ App\Http\Controllers\FunctionController::itemsQtySpecific(100, 10, $state = 'Less') }}
                                </span>
                            </button>
                            <button data-low="100" data-high="0"
                                class="btn-get-qty list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Items with Greater than 100 Qty <span class="badge bg-success rounded-pill">
                                    {{ App\Http\Controllers\FunctionController::itemsQtySpecific(100, 0, $state = 'Greater') }}
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-3">
                        <div class="card shadow-sm bg-white rounded">
                            <div class="card-header bg-primary">
                                <h4 class="text-white"><i class="fas fa-chart-bar"></i> Current Year Purchase & Sale</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mb-3">
                        <div class="card shadow-sm bg-white rounded">
                            <div class="card-header bg-primary">
                                <h4 class="text-white"><i class="fas fa-chart-pie"></i> Current year Expenses</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="expChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
        <!-- Modal -->
        <div class="modal fade" id="itemsQtyModel" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ّItems from qty</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body table-responsive">
                        <div class="print_div">
                            <table class='table table-bordered'>
                                <thead>
                                    <tr>
                                        <th class="text-center" colspan="5" id="data_header"></th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Item Name</th>
                                        <th>P.Price</th>
                                        <th>Qty</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_data_body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="btn_print"><i class="fa fa-print"></i> Print</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endif




@section('pageJs')
    <script src="{{ asset('plugin/charts/chart.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $(".nav-link").removeClass('active');


            var ctx = document.getElementById('myChart');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'oct', 'Nov',
                        'Dec'
                    ],
                    datasets: [{
                            label: 'Purchase',
                            data: {{ App\Http\Controllers\FunctionController::purchaseGraph() }},
                            backgroundColor: [
                                'rgba(255, 159, 64, 0.5)'
                            ],
                            borderColor: [
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        },
                        {
                            label: 'Sale',
                            data: {{ App\Http\Controllers\FunctionController::saleGraph() }},
                            backgroundColor: [
                                'rgba(0, 102, 255, 0.5)'
                            ],
                            borderColor: [
                                'rgba(0, 102, 255, 1)'
                            ],
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });


            @php
                $expCats = App\Models\ExpenseCategory::get();
            @endphp

            var ctx = document.getElementById('expChart');
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: [
                        @foreach ($expCats as $cat)
                            "{{ $cat->name }}",
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Purchase',
                        data: {{ App\Http\Controllers\FunctionController::expenseGraph() }},
                        backgroundColor: [

                            @foreach ($expCats as $cat)
                                random_rgba(),
                            @endforeach
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });


            function random_rgba() {
                var o = Math.round,
                    r = Math.random,
                    s = 255;
                return 'rgba(' + o(r() * s) + ',' + o(r() * s) + ',' + o(r() * s) + ',' + 0.5 + ')';
            }


            $(".btn-get-qty").click(function() {
                var data_low = $(this).attr('data-low');
                var data_high = $(this).attr('data-high');
                var header = $(this).html();
                $.ajax({
                    url: "{{ url('getItemsByQty') }}",
                    method: 'get',
                    data: {
                        'data_low': data_low,
                        'data_high': data_high
                    },
                    success: function(response) {
                        // console.log(response);
                        $("#itemsQtyModel").modal("show");
                        $("#data_header").html(header);
                        $("#tbl_data_body").html(response);
                    }
                });
            })

            // document.ready end
        });
    </script>
@endsection
