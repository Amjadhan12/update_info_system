@extends('layouts.admin')
@section('title', 'Expense Categories')

@if (Auth::user()->language == 'Pashto')
    @section('body')
        <style>

        </style>
        <main class="p-3">
            <div class="container-flued">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card shadow-sm  mb-3 bg-white rounded">
                            <div class="card-header bg-primary">
                                <h4 class="text-white"><i class="fa fa-plus"></i> د مصارفو نوی ډول</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('expenseCategory.store') }}" method="post" id="frm">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="name" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" autofocus required>
                                            <label class="form-label" for='name'>د مصارفو د ډول نوم<strong
                                                    class="text-danger">*</strong></label>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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
                        <div class="card shadow-sm  mb-3 bg-white rounded">
                            <div class="card-header bg-primary">
                                <h4 class="text-white"><i class="fa fa-list"></i> Categories List</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive p-1">
                                    <table class="table table-striped table-hover table-bordered data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>شماره</th>
                                                <th>د مصارفو د ډول نوم</th>
                                                <th>وضاحت</th>
                                                <th>عملیه</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($expenseCategories as $expenseCategory)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $expenseCategory->name }}</td>
                                                    <td>{{ $expenseCategory->details }}</td>
                                                    <td>
                                                        <a href="{{ route('expenseCategory.edit', $expenseCategory) }}"
                                                            class="btn btn-info btn-sm" title="Edit!"><i
                                                                class="fa fa-edit"></i></a>
                                                        <!-- <button class="btn btn-danger btn-sm btn-delete" data-id='{{ $expenseCategory->id }}' title="Delete!"><i class="fa fa-trash"></i>

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
                    <div class="col-md-8">
                        <div class="card shadow-sm  mb-5 bg-white rounded">
                            <div class="card-header bg-primary bg-gradient">
                                <h4 class="text-white"><i class="fa fa-list"></i> Items List</h4>
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
            $("#nav_expense").addClass("active");

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
                        $('#delete-form').attr('action', "/expenseCategory/" + id);
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
