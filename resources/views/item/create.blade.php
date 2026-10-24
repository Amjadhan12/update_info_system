@extends('layouts.adminFast')
@section('title', 'Items')

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
                                <h4 class="text-white"><i class="fa fa-plus"></i> نوی جنس</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('item.store') }}" method="post" id="frm">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    {{-- <div class="mb-3 pb-1">
                                <div class="form-outline">
                                    <input id="barcode" name="barcode" type="text" class="form-control @error('barcode') is-invalid @enderror" value="{{ old('barcode') }}" autofocus required>
                                    <label class="form-label" for='barcode'>Item barcode<strong class="text-danger">*</strong></label>
                                    @error('barcode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="name" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" autofocus required>
                                            <label class="form-label" for='name'>د جنس نوم<strong
                                                    class="text-danger">*</strong></label>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-group">
                                            <label for='currency_id'>کرنسي<strong class="text-danger">*</strong></label>
                                            <select id="currency_id" name="currency_id" class="select2 form-control"
                                                style="width: 100%;">
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3 pb-1">
                                            <div class="form-outline">
                                                <input type="text" id="pprice" name="pprice" class="form-control"
                                                    value="{{ old('pprice') }}" required>
                                                <label class="form-label" for="pprice">د خریداری قیمت<strong
                                                        class="text-danger">*</strong></label>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3 pb-1">
                                            <div class="form-outline">
                                                <input type="text" id="sprice" name="sprice" class="form-control"
                                                    value="{{ old('sprice') }}" required>
                                                <label class="form-label" for="sprice">د خرڅلاو قیمت<strong
                                                        class="text-danger">*</strong></label>
                                            </div>
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
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-white"><i class="fa fa-list"></i> وروستنی لس جنسونه</h4>
                                    </div>
                                    <div class="col-6">
                                        <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
                                            <a class="btn btn-success" href="{{ route('item.index') }}"><i
                                                    class="fa fa-list" title="Sale List"></i> ټول جنسونه</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive p-1">
                                    <table class="table table-striped table-hover table-bordered data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>شماره</th>
                                                {{-- <th>Code</th> --}}
                                                <th>د جنس نوم</th>
                                                <th>د خریداری قیمت</th>
                                                <th>د خرڅلاو قیمت</th>
                                                <th>وضاحت</th>
                                                <th>عملیه</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    {{-- <td>{{$item->barcode}}</td> --}}
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->pprice }} {{ $item->currency->name }}</td>
                                                    <td>{{ $item->sprice }}</td>
                                                    <td>{{ $item->details }}</td>
                                                    <td>
                                                        <a href="{{ route('item.edit', $item) }}"
                                                            class="btn btn-info btn-sm" title="Edit!"><i
                                                                class="fa fa-edit"></i></a>

                                                        @if (Auth::user()->user_type == 'Admin')
                                                            <button class="btn btn-danger btn-sm btn-delete"
                                                                data-id='{{ $item->id }}' title="Delete!"><i
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
                                <h4 class="text-white"><i class="fa fa-plus"></i> New Item</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('item.store') }}" method="post" id="frm">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    {{-- <div class="mb-3 pb-1">
                                <div class="form-outline">
                                    <input id="barcode" name="barcode" type="text" class="form-control @error('barcode') is-invalid @enderror" value="{{ old('barcode') }}" autofocus required>
                                    <label class="form-label" for='barcode'>Item barcode<strong class="text-danger">*</strong></label>
                                    @error('barcode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="name" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" autofocus required>
                                            <label class="form-label" for='name'>Item Name<strong
                                                    class="text-danger">*</strong></label>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-group">
                                            <label for='currency_id'>Currency<strong
                                                    class="text-danger">*</strong></label>
                                            <select id="currency_id" name="currency_id" class="select2 form-control"
                                                style="width: 100%;">
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3 pb-1">
                                            <div class="form-outline">
                                                <input type="text" id="pprice" name="pprice" class="form-control"
                                                    value="{{ old('pprice') }}" required>
                                                <label class="form-label" for="pprice">Purchase Cost<strong
                                                        class="text-danger">*</strong></label>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3 pb-1">
                                            <div class="form-outline">
                                                <input type="text" id="sprice" name="sprice" class="form-control"
                                                    value="{{ old('sprice') }}" required>
                                                <label class="form-label" for="sprice">Sale Price<strong
                                                        class="text-danger">*</strong></label>
                                            </div>
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
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-white"><i class="fa fa-list"></i> Last 10 Items</h4>
                                    </div>
                                    <div class="col-6">
                                        <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
                                            <a class="btn btn-success" href="{{ route('item.index') }}"><i
                                                    class="fa fa-list" title="Sale List"></i> Show all</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive p-1">
                                    <table class="table table-striped table-hover table-bordered data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>S.No</th>
                                                {{-- <th>Code</th> --}}
                                                <th>Item Name</th>
                                                <th>Cost</th>
                                                <th>Sale Price</th>
                                                <th>Details</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    {{-- <td>{{$item->barcode}}</td> --}}
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->pprice }} {{ $item->currency->name }}</td>
                                                    <td>{{ $item->sprice }}</td>
                                                    <td>{{ $item->details }}</td>
                                                    <td>
                                                        <a href="{{ route('item.edit', $item) }}"
                                                            class="btn btn-info btn-sm" title="Edit!"><i
                                                                class="fa fa-edit"></i></a>

                                                        @if (Auth::user()->user_type == 'Admin')
                                                            <button class="btn btn-danger btn-sm btn-delete"
                                                                data-id='{{ $item->id }}' title="Delete!"><i
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
            $("#nav_setting").addClass("active");

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
                        $('#delete-form').attr('action', "/item/" + id);
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
