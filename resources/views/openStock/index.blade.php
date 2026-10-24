@extends('layouts.admin')
@section('title', 'Open Stock')

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
                                <h4 class="text-white"><i class="fa fa-plus"></i> د موجود لومړني جنسونه</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('openStock.store') }}" method="post" id="frm">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="pb-1">
                                                <div class="form-group">
                                                    <label for='currency_id'>کرنسي<strong
                                                            class="text-danger">*</strong></label>
                                                    <select id="currency_id" name="currency_id" class="select2 form-control"
                                                        style="width: 100%;">
                                                        @foreach ($currencies as $currency)
                                                            <option value="{{ $currency->id }}">{{ $currency->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3 pb-1">
                                                <div class="form-group">
                                                    <label for='stock_id'>سټاک<strong
                                                            class="text-danger">*</strong></label>
                                                    <select id="stock_id" name="stock_id" class="select2 form-control"
                                                        style="width: 100%;">
                                                        @foreach ($stocks as $stock)
                                                            <option value="{{ $stock->id }}">{{ $stock->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group pb-2">
                                        <label for='item_id'>جنس<strong class="text-danger">*</strong></label>
                                        <select id="item_id" name="item_id" class="select2" autofocus
                                            style="width: 100%;">
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-group mb-2">
                                        <select class="form-control" name="unit_id" id="unit_id" title="Item Unit">
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-text">X</span>
                                        <div class="form-outline">
                                            <input type="text" id="unit_size" name="unit_size" class="form-control"
                                                value="1" required>
                                            <label class="form-label" for="qty">Unit Size<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="qty" name="qty" class="form-control"
                                                value="{{ old('qty') }}" required>
                                            <label class="form-label" for="qty">موجود تعداد<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3 pb-1">
                                            <div class="form-outline">
                                                <input type="text" id="pprice" name="pprice" class="form-control"
                                                    value="0.00" required>
                                                <label class="form-label" for="pprice">د خریداری قیمت<strong
                                                        class="text-danger">*</strong></label>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3 pb-1">
                                            <div class="form-outline">
                                                <input type="text" id="sprice" name="sprice" class="form-control"
                                                    value="0.00" required>
                                                <label class="form-label" for="sprice">د خرڅلاو قیمت<strong
                                                        class="text-danger">*</strong></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="sprice" name="date" class="form-control date"
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
                                        <button class="btn btn-primary" id="submit" type="submit"><i
                                                class="fa fa-save"></i>
                                            ثبتول</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card shadow-sm  mb-5 bg-white rounded">
                            <div class="card-header bg-primary bg-gradient">
                                <h4 class="text-white"><i class="fa fa-list"></i> لیست</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive p-1">
                                    <table class="table table-striped table-hover table-bordered data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>شماره</th>
                                                <th>جنس</th>
                                                <th>تعداد</th>
                                                <th>د خریداری قیمت</th>
                                                <th>د خرڅلاو قیمت</th>
                                                <th>سټاک</th>
                                                <th>وضاحت</th>
                                                <th>عملیه</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($openStocks as $openStock)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $openStock->item->name }}</td>
                                                    <td>{{ $openStock->qty }}</td>
                                                    <td>{{ $openStock->pprice }} {{ $openStock->currency->name }}</td>
                                                    <td>{{ $openStock->sprice }}</td>
                                                    <td>{{ $openStock->stock->name }}</td>
                                                    <td>{{ $openStock->details }}</td>
                                                    <td>
                                                        <a href="{{ route('openStock.edit', $openStock) }}"
                                                            class="btn btn-info btn-sm" title="Edit!"><i
                                                                class="fa fa-edit"></i></a>
                                                        @if (Auth::user()->user_type == 'Admin')
                                                            <button class="btn btn-danger btn-sm btn-delete"
                                                                data-id='{{ $openStock->id }}' title="Delete!"><i
                                                                    class="fa fa-trash"></i>

                                                            </button>
                                                        @endif
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
                                <h4 class="text-white"><i class="fa fa-plus"></i> Opening Stock</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('openStock.store') }}" method="post" id="frm">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="pb-1">
                                                <div class="form-group">
                                                    <label for='currency_id'>Currency<strong
                                                            class="text-danger">*</strong></label>
                                                    <select id="currency_id" name="currency_id" class="select2 form-control"
                                                        style="width: 100%;">
                                                        @foreach ($currencies as $currency)
                                                            <option value="{{ $currency->id }}">{{ $currency->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3 pb-1">
                                                <div class="form-group">
                                                    <label for='stock_id'>Stock<strong
                                                            class="text-danger">*</strong></label>
                                                    <select id="stock_id" name="stock_id" class="select2 form-control"
                                                        style="width: 100%;">
                                                        @foreach ($stocks as $stock)
                                                            <option value="{{ $stock->id }}">{{ $stock->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group pb-2">
                                        <label for='item_id'>Select Item<strong class="text-danger">*</strong></label>
                                        <select id="item_id" name="item_id" class="select2" autofocus
                                            style="width: 100%;">
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-group mb-2">
                                        <select class="form-control" name="unit_id" id="unit_id" title="Item Unit">
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-text">X</span>
                                        <div class="form-outline">
                                            <input type="text" id="unit_size" name="unit_size" class="form-control"
                                                value="1" required>
                                            <label class="form-label" for="qty">Unit Size<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="qty" name="qty" class="form-control"
                                                value="{{ old('qty') }}" required>
                                            <label class="form-label" for="qty">Current Qty<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3 pb-1">
                                            <div class="form-outline">
                                                <input type="text" id="pprice" name="pprice" class="form-control"
                                                    value="0.00" required>
                                                <label class="form-label" for="pprice">Purchase Cost<strong
                                                        class="text-danger">*</strong></label>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3 pb-1">
                                            <div class="form-outline">
                                                <input type="text" id="sprice" name="sprice" class="form-control"
                                                    value="0.00" required>
                                                <label class="form-label" for="sprice">Sale Price<strong
                                                        class="text-danger">*</strong></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="sprice" name="date" class="form-control date"
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
                                        <button class="btn btn-primary" id="submit" type="submit"><i
                                                class="fa fa-save"></i>
                                            Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card shadow-sm  mb-5 bg-white rounded">
                            <div class="card-header bg-primary bg-gradient">
                                <h4 class="text-white"><i class="fa fa-list"></i> Open Stock List</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive p-1">
                                    <table class="table table-striped table-hover table-bordered data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>S.No</th>
                                                <th>Item Name</th>
                                                <th>Qty</th>
                                                <th>Cost</th>
                                                <th>Sale Price</th>
                                                <th>Stock</th>
                                                <th>Details</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($openStocks as $openStock)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $openStock->item->name }}</td>
                                                    <td>{{ $openStock->qty / $openStock->unit_size }}
                                                        {{ $openStock->unit->name }}</td>
                                                    <td>{{ round($openStock->pprice * $openStock->unit_size, 1) }}
                                                        {{ $openStock->currency->name }}</td>
                                                    <td>{{ round($openStock->sprice * $openStock->unit_size, 1) }}</td>
                                                    <td>{{ $openStock->stock->name }}</td>
                                                    <td>{{ $openStock->details }}</td>
                                                    <td>
                                                        <a href="{{ route('openStock.edit', $openStock) }}"
                                                            class="btn btn-info btn-sm" title="Edit!"><i
                                                                class="fa fa-edit"></i></a>
                                                        @if (Auth::user()->user_type == 'Admin')
                                                            <button class="btn btn-danger btn-sm btn-delete"
                                                                data-id='{{ $openStock->id }}' title="Delete!"><i
                                                                    class="fa fa-trash"></i>

                                                            </button>
                                                        @endif
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
            $("#nav_opening").addClass("active");

            $("#item_code").keypress(function(e) {
                if (e.which == '10' || e.which == '13') {
                    $("#qty").focus();
                }
            });

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
                        $('#delete-form').attr('action', "/openStock/" + id);
                        $("#delete-form").submit();
                    } else {
                        swal("Cancelled", "Not Deleted!", "error");
                        return false;
                    }
                });
            });

            $("#frm").submit(function() {
                var item_id = $("#item_id").val();
                if (item_id == "") {
                    showWarning("Select item!");
                    return false;
                }
            })
        });
    </script>

@endsection
