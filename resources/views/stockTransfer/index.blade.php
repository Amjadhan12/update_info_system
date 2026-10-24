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
                            <form action="{{ route('stockTransfer.store') }}" method="post" id="frm">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                                <div class="pb-1">
                                    <div class="form-group">
                                        <label for='item_id'>جنس<strong class="text-danger">*</strong></label>
                                        <select id="item_id" name="item_id" class="select2" autofocus
                                            style="width: 100%;">
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
                                            @foreach ($stocks as $stock)
                                                <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="">ته</label>
                                        <select name="to_stock_id" id="to_stock_id" class="form-control">
                                            @foreach ($stocks as $stock)
                                                <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input type="text" id="qty" name="qty" class="form-control"
                                            value="{{ old('qty') }}" required>
                                        <label class="form-label" for="qty">تعداد<strong
                                                class="text-danger">*</strong></label>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input type="text" id="date" name="date" class="form-control date"
                                            value="{{ date('Y-m-d') }}" required>
                                        <label class="form-label" for="date">نیټه<strong
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
                <div class="col-md-8">
                    <div class="card shadow-sm  mb-5 bg-white rounded">
                        <div class="card-header bg-primary bg-gradient">
                            <h4 class="text-white"><i class="fa fa-list"></i> د انتقال لیست</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped table-hover table-bordered data_table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>شماره</th>
                                            <th>جنس</th>
                                            <th>تعداد</th>
                                            <th>له</th>
                                            <th>ته</th>
                                            <th>وضاحت</th>
                                            <th>عملیه</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stockTransfers as $stockTransfer)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $stockTransfer->item->name }}</td>
                                                <td>{{ $stockTransfer->qty }}</td>
                                                <td>{{ App\Models\Stock::find($stockTransfer->from_stock_id)->name }}
                                                </td>
                                                <td>{{ App\Models\Stock::find($stockTransfer->to_stock_id)->name }}</td>
                                                <td>{{ $stockTransfer->details }}</td>
                                                <td>
                                                    <a href="{{ route('stockTransfer.edit', $stockTransfer) }}"
                                                        class="btn btn-info btn-sm" title="Edit!"><i
                                                            class="fa fa-edit"></i></a>
                                                    <!-- <button class="btn btn-danger btn-sm btn-delete" data-id='{{ $stockTransfer->id }}' title="Delete!"><i class="fa fa-trash"></i>

                                                    </button> -->
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <form id="delete-form" action="" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
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

                <div class="col-md-4">
                    <div class="card shadow-sm  mb-5 bg-white rounded">
                        <div class="card-header bg-primary bg-gradient">
                            <h4 class="text-white"><i class="fa fa-plus"></i> Stock Transfer</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('stockTransfer.store') }}" method="post" id="frm">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                                <div class="pb-1">
                                    <div class="form-group">
                                        <label for='item_id'>item<strong class="text-danger">*</strong></label>
                                        <select id="item_id" name="item_id" class="select2" autofocus
                                            style="width: 100%;">
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
                                            @foreach ($stocks as $stock)
                                                <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="">To</label>
                                        <select name="to_stock_id" id="to_stock_id" class="form-control">
                                            @foreach ($stocks as $stock)
                                                <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input type="text" id="qty" name="qty" class="form-control"
                                            value="{{ old('qty') }}" required>
                                        <label class="form-label" for="qty">Item Qty<strong
                                                class="text-danger">*</strong></label>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input type="text" id="date" name="date" class="form-control date"
                                            value="{{ date('Y-m-d') }}" required>
                                        <label class="form-label" for="date">Date<strong
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
                <div class="col-md-8">
                    <div class="card shadow-sm  mb-5 bg-white rounded">
                        <div class="card-header bg-primary bg-gradient">
                            <h4 class="text-white"><i class="fa fa-list"></i> Transfer List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped table-hover table-bordered data_table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Item Name</th>
                                            <th>Qty</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Details</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stockTransfers as $stockTransfer)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $stockTransfer->item->name }}</td>
                                                <td>{{ $stockTransfer->qty }}</td>
                                                <td>{{ App\Models\Stock::find($stockTransfer->from_stock_id)->name }}</td>
                                                <td>{{ App\Models\Stock::find($stockTransfer->to_stock_id)->name }}</td>
                                                <td>{{ $stockTransfer->details }}</td>
                                                <td>
                                                    <a href="{{ route('stockTransfer.edit', $stockTransfer) }}"
                                                        class="btn btn-info btn-sm" title="Edit!"><i
                                                            class="fa fa-edit"></i></a>
                                                    <!-- <button class="btn btn-danger btn-sm btn-delete" data-id='{{ $stockTransfer->id }}' title="Delete!"><i class="fa fa-trash"></i>

                                                </button> -->
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <form id="delete-form" action="" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
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

            $(document).on("click", ".btn-delete", function() {
                var id = $(this).attr("data-id");
                swal({
                    title: "Are you sure want to delete?",
                    text: "...",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "yes!",
                    cancelButtonText: "no!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function(isConfirm) {
                    if (isConfirm) {
                        $('#delete-form').attr('action', "/stockTransfer/" + id);
                        $("#delete-form").submit();
                    } else {
                        swal("Cancelled", "Not Deleted!", "error");
                        return false;
                    }
                });
            });
        });
    </script>

@endsection
