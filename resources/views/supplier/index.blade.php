@extends('layouts.admin')
@section('title', 'Suppliers')

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
                            <h4 class="text-white"><i class="fa fa-plus"></i> نوی شرکت</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('supplier.store') }}" method="post" id="frm">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" name="redirect_to" value="supplier.index">
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input id="name" name="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" autofocus required tabindex="1">
                                        <label class="form-label" for='name'>د شرکت نوم<strong
                                                class="text-danger">*</strong></label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input type="text" id="phone" name="phone" class="form-control"
                                            value="{{ old('phone') }}" required tabindex="2">
                                        <label class="form-label" for="phone">موبايل شميره<strong
                                                class="text-danger">*</strong></label>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <textarea name="details" id="details" class="form-control"
                                            tabindex="3">{{ old('details') }}</textarea>
                                        <label class="form-label" for="details">وضاحت</label>
                                    </div>
                                </div>
                                <div class="form-group my-2">
                                    <button class="btn btn-primary" id="submit" type="submit" tabindex="4"><i
                                            class="fa fa-save"></i> ثبتول</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card shadow-sm  mb-5 bg-white rounded">
                        <div class="card-header bg-primary bg-gradient">
                            <h4 class="text-white"><i class="fa fa-list"></i> د شرکتونه لیست</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped table-hover table-bordered data_table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>شماره</th>
                                            <th>د شرکت نوم</th>
                                            <th>موبايل شميره</th>
                                            <th>وضاحت</th>
                                            <th>عملیه</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suppliers as $supplier)
                                            <tr>
                                                <td>{{ $supplier->id }}</td>
                                                <td>{{ $supplier->name }}</td>
                                                <td>{{ $supplier->phone }}</td>
                                                <td>{{ $supplier->details }}</td>
                                                <td>
                                                    <a href="{{ route('supplier.edit', $supplier) }}"
                                                        class="btn btn-info btn-sm" title="Edit!"><i
                                                            class="fa fa-edit"></i></a>
                                                    <!-- <button class="btn btn-danger btn-sm btn-delete" data-id='{{ $supplier->id }}' title="Delete!"><i class="fa fa-trash"></i>

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
                            <h4 class="text-white"><i class="fa fa-plus"></i> New Supplier</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('supplier.store') }}" method="post" id="frm">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" name="redirect_to" value="supplier.index">
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input id="name" name="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" autofocus required tabindex="1">
                                        <label class="form-label" for='name'>Supplier Name<strong
                                                class="text-danger">*</strong></label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input type="text" id="phone" name="phone" class="form-control"
                                            value="{{ old('phone') }}" required tabindex="2">
                                        <label class="form-label" for="phone">Phone<strong
                                                class="text-danger">*</strong></label>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <textarea name="details" id="details" class="form-control"
                                            tabindex="3">{{ old('details') }}</textarea>
                                        <label class="form-label" for="details">Details</label>
                                    </div>
                                </div>
                                <div class="form-group my-2">
                                    <button class="btn btn-primary" id="submit" type="submit" tabindex="4"><i
                                            class="fa fa-save"></i> Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card shadow-sm  mb-5 bg-white rounded">
                        <div class="card-header bg-primary bg-gradient">
                            <h4 class="text-white"><i class="fa fa-list"></i> Suppiers List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped table-hover table-bordered data_table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>S.No</th>
                                            <th>Supplier Name</th>
                                            <th>Phone</th>
                                            <th>Details</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suppliers as $supplier)
                                            <tr>
                                                <td>{{ $supplier->id }}</td>
                                                <td>{{ $supplier->name }}</td>
                                                <td>{{ $supplier->phone }}</td>
                                                <td>{{ $supplier->details }}</td>
                                                <td>
                                                    <a href="{{ route('supplier.edit', $supplier) }}"
                                                        class="btn btn-info btn-sm" title="Edit!"><i
                                                            class="fa fa-edit"></i></a>
                                                    <!-- <button class="btn btn-danger btn-sm btn-delete" data-id='{{ $supplier->id }}' title="Delete!"><i class="fa fa-trash"></i>

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
            $("#nav_add").addClass("active");

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
                        $('#delete-form').attr('action', "/supplier/" + id);
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
