@extends('layouts.admin')
@section('title', 'Edit Open Stock')

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
                                <h4 class="text-white"><i class="fa fa-plus"></i> په سټاک کې د لومړني موجود اجناسو
                                    ثبتول
                                </h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('openStock.update', $openStock) }}" method="post" id="frm">
                                    @csrf
                                    @method("put")
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                                    <div class="row">
                                        <div class="col-6 pb-1">
                                            <div class="pb-1">
                                                <div class="form-group">
                                                    <label for='currency_id'>کرنسي<strong
                                                            class="text-danger">*</strong></label>
                                                    <select id="currency_id" name="currency_id" class="select2"
                                                        autofocus style="width: 100%;">
                                                        <option value="{{ $openStock->currency_id }}">
                                                            {{ $openStock->currency->name }}</option>
                                                        @foreach ($currencies as $currency)
                                                            <option value="{{ $currency->id }}">{{ $currency->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 pb-1">
                                            <div class="pb-1">
                                                <div class="form-group">
                                                    <label for='stock_id'>سټاک<strong
                                                            class="text-danger">*</strong></label>
                                                    <select id="stock_id" name="stock_id" class="select2"
                                                        style="width: 100%;">
                                                        <option value="{{ $openStock->stock_id }}">
                                                            {{ $openStock->stock->name }}
                                                        </option>
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
                                        <label for='item_id'>جنس انتخاب کړئ<strong class="text-danger">*</strong></label>
                                        <select id="item_id" name="item_id" class="select2" autofocus
                                            style="width: 100%;">
                                            <option value="{{ $openStock->item_id }}">{{ $openStock->item->name }}
                                            </option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-group mb-2">
                                        <select class="form-control" name="unit_id" id="unit_id" title="د جنس واحد">
                                            <option value="{{ $openStock->unit_id }}">{{ $openStock->unit->name }}
                                            </option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-text">X</span>
                                        <div class="form-outline">
                                            <input type="text" id="unit_size" name="unit_size" class="form-control"
                                                value="{{ $openStock->unit_size }}" required>
                                            <label class="form-label" for="qty">ډ واحد اندازه<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="qty" name="qty" class="form-control"
                                                value="{{ $openStock->qty }}" required>
                                            <label class="form-label" for="qty">موجود تعداد<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3 pb-1">
                                            <div class="form-outline">
                                                <input type="text" id="pprice" name="pprice" class="form-control"
                                                    value="{{ $openStock->pprice }}" required>
                                                <label class="form-label" for="pprice">د خریداری قیمت<strong
                                                        class="text-danger">*</strong></label>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3 pb-1">
                                            <div class="form-outline">
                                                <input type="text" id="sprice" name="sprice" class="form-control"
                                                    value="{{ $openStock->sprice }}" required>
                                                <label class="form-label" for="sprice">د خرڅلاو قیمت<strong
                                                        class="text-danger">*</strong></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="sprice" name="date" class="form-control date"
                                                value="{{ $openStock->date }}" required>
                                            <label class="form-label" for="date">نیټه<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <textarea name="details" id="details"
                                                class="form-control">{{ $openStock->details }}</textarea>
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
                                <h4 class="text-white"><i class="fa fa-plus"></i> Edit Opening Stock</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('openStock.update', $openStock) }}" method="post" id="frm">
                                    @csrf
                                    @method("put")
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                                    <div class="row">
                                        <div class="col-6 pb-1">
                                            <div class="pb-1">
                                                <div class="form-group">
                                                    <label for='currency_id'>Currency<strong
                                                            class="text-danger">*</strong></label>
                                                    <select id="currency_id" name="currency_id" class="select2"
                                                        autofocus style="width: 100%;">
                                                        <option value="{{ $openStock->currency_id }}">
                                                            {{ $openStock->currency->name }}</option>
                                                        @foreach ($currencies as $currency)
                                                            <option value="{{ $currency->id }}">{{ $currency->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 pb-1">
                                            <div class="pb-1">
                                                <div class="form-group">
                                                    <label for='stock_id'>Stock<strong
                                                            class="text-danger">*</strong></label>
                                                    <select id="stock_id" name="stock_id" class="select2"
                                                        style="width: 100%;">
                                                        <option value="{{ $openStock->stock_id }}">
                                                            {{ $openStock->stock->name }}
                                                        </option>
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
                                            <option value="{{ $openStock->item_id }}">{{ $openStock->item->name }}
                                            </option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-group mb-2">
                                        <select class="form-control" name="unit_id" id="unit_id" title="Item Unit">
                                            <option value="{{ $openStock->unit_id }}">{{ $openStock->unit->name }}
                                            </option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="input-group-text">X</span>
                                        <div class="form-outline">
                                            <input type="text" id="unit_size" name="unit_size" class="form-control"
                                                value="{{ $openStock->unit_size }}" required>
                                            <label class="form-label" for="qty">Unit Size<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="qty" name="qty" class="form-control"
                                                value="{{ $openStock->qty / $openStock->unit_size }}" required>
                                            <label class="form-label" for="qty">Current Qty<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3 pb-1">
                                            <div class="form-outline">
                                                <input type="text" id="pprice" name="pprice" class="form-control"
                                                    value="{{ round($openStock->pprice * $openStock->unit_size, 1) }}"
                                                    required>
                                                <label class="form-label" for="pprice">Purchase Cost<strong
                                                        class="text-danger">*</strong></label>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3 pb-1">
                                            <div class="form-outline">
                                                <input type="text" id="sprice" name="sprice" class="form-control"
                                                    value="{{ round($openStock->sprice * $openStock->unit_size, 1) }}"
                                                    required>
                                                <label class="form-label" for="sprice">Sale Price<strong
                                                        class="text-danger">*</strong></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="sprice" name="date" class="form-control date"
                                                value="{{ $openStock->date }}" required>
                                            <label class="form-label" for="date">Date<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <textarea name="details" id="details"
                                                class="form-control">{{ $openStock->details }}</textarea>
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
        });
    </script>

@endsection
