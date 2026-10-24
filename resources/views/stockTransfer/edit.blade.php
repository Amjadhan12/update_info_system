@extends('layouts.admin')
@section('title', 'Stock Transfer')

@if (Auth::user()->language == 'Pashto')
@section('body')
    <style>

    </style>
    <main class="p-3">
        <div class="container-flued">
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm  mb-5 bg-white rounded">
                        <div class="card-header bg-primary bg-gradient">
                            <h4 class="text-white"><i class="fa fa-plus"></i> د جنس انتقال له یو سټاک څخه بل سټاک ته
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('stockTransfer.update', $stockTransfer) }}" method="post" id="frm">
                                @csrf
                                @method("put")
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                                <div class="pb-1">
                                    <div class="form-group">
                                        <label for='item_id'>جنس<strong class="text-danger">*</strong></label>
                                        <select id="item_id" name="item_id" class="select2" autofocus
                                            style="width: 100%;">
                                            <option value="{{ $stockTransfer->item_id }}">{{ $stockTransfer->item->name }}
                                            </option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3 pb-1">
                                    <div class="col-6 form-group">
                                        <label for="">له</label>
                                        <select name="from_stock_id" id="from_stock_id" class="form-control">
                                            <option value="{{ $stockTransfer->from_stock_id }}">
                                                {{ App\Models\Stock::find($stockTransfer->from_stock_id)->name }}</option>
                                            @foreach ($stocks as $stock)
                                                <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="">ته</label>
                                        <select name="to_stock_id" id="to_stock_id" class="form-control">
                                            <option value="{{ $stockTransfer->to_stock_id }}">
                                                {{ App\Models\Stock::find($stockTransfer->to_stock_id)->name }}</option>
                                            @foreach ($stocks as $stock)
                                                <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input type="text" id="qty" name="qty" class="form-control"
                                            value="{{ $stockTransfer->qty }}" required>
                                        <label class="form-label" for="qty">تعداد<strong
                                                class="text-danger">*</strong></label>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input type="text" id="date" name="date" class="form-control date"
                                            value="{{ $stockTransfer->date }}" required>
                                        <label class="form-label" for="date">نیټه<strong
                                                class="text-danger">*</strong></label>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <textarea name="details" id="details"
                                            class="form-control">{{ $stockTransfer->details }}</textarea>
                                        <label class="form-label" for="details">وضاحت</label>
                                    </div>
                                </div>
                                <div class="form-group my-2">
                                    <button class="btn btn-primary" id="submit" type="submit"><i class="fa fa-save"></i>
                                        تغیر</button>
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
    <style>

    </style>
    <main class="p-3">
        <div class="container-flued">
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm  mb-5 bg-white rounded">
                        <div class="card-header bg-primary bg-gradient">
                            <h4 class="text-white"><i class="fa fa-plus"></i> Stock Transfer</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('stockTransfer.update', $stockTransfer) }}" method="post" id="frm">
                                @csrf
                                @method("put")
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                                <div class="pb-1">
                                    <div class="form-group">
                                        <label for='item_id'>item<strong class="text-danger">*</strong></label>
                                        <select id="item_id" name="item_id" class="select2" autofocus
                                            style="width: 100%;">
                                            <option value="{{ $stockTransfer->item_id }}">{{ $stockTransfer->item->name }}
                                            </option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3 pb-1">
                                    <div class="col-6 form-group">
                                        <label for="">From</label>
                                        <select name="from_stock_id" id="from_stock_id" class="form-control">
                                            <option value="{{ $stockTransfer->from_stock_id }}">
                                                {{ App\Models\Stock::find($stockTransfer->from_stock_id)->name }}</option>
                                            @foreach ($stocks as $stock)
                                                <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="">To</label>
                                        <select name="to_stock_id" id="to_stock_id" class="form-control">
                                            <option value="{{ $stockTransfer->to_stock_id }}">
                                                {{ App\Models\Stock::find($stockTransfer->to_stock_id)->name }}</option>
                                            @foreach ($stocks as $stock)
                                                <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input type="text" id="qty" name="qty" class="form-control"
                                            value="{{ $stockTransfer->qty }}" required>
                                        <label class="form-label" for="qty">Item Qty<strong
                                                class="text-danger">*</strong></label>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input type="text" id="date" name="date" class="form-control date"
                                            value="{{ $stockTransfer->date }}" required>
                                        <label class="form-label" for="date">Date<strong
                                                class="text-danger">*</strong></label>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <textarea name="details" id="details"
                                            class="form-control">{{ $stockTransfer->details }}</textarea>
                                        <label class="form-label" for="details">Details</label>
                                    </div>
                                </div>
                                <div class="form-group my-2">
                                    <button class="btn btn-primary" id="submit" type="submit"><i class="fa fa-save"></i>
                                        Update</button>
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
            $("#nav_stock").addClass("active");
        });
    </script>

@endsection
