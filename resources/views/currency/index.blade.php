@extends('layouts.admin')
@section('title', 'Currencies')

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
                                <h4 class="text-white"><i class="fa fa-plus"></i> نوې کرنسي</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('currency.store') }}" method="post" id="frm">
                                    @csrf
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="name" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" autofocus required>
                                            <label class="form-label" for='name'>د کرنسي نوم<strong
                                                    class="text-danger">*</strong></label>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="rate" name="rate" class="form-control"
                                                value="{{ old('rate') }}" required>
                                            <label class="form-label" for="rate">نرخ<strong
                                                    class="text-danger">*</strong></label>
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
                                <h4 class="text-white"><i class="fa fa-list"></i> د کرنسي لیست</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive p-1">
                                    <table class="table table-striped table-hover table-bordered data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>شماره</th>
                                                <th>د کرنسي نوم</th>
                                                <th>نرخ</th>
                                                <th>عملیه</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($currencies as $currency)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $currency->name }}</td>
                                                    <td>{{ $currency->rate }}</td>
                                                    <td>
                                                        <a href="{{ route('currency.edit', $currency) }}"
                                                            class="btn btn-info btn-sm" title="Edit!"><i
                                                                class="fa fa-edit"></i></a>
                                                        <!-- <button class="btn btn-danger btn-sm btn-delete" data-id='{{ $currency->id }}' title="Delete!"><i class="fa fa-trash"></i>

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
                        <div class="card shadow-sm  mb-3 bg-white rounded">
                            <div class="card-header bg-primary">
                                <h4 class="text-white"><i class="fa fa-plus"></i> New Currency</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('currency.store') }}" method="post" id="frm">
                                    @csrf
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="name" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" autofocus required>
                                            <label class="form-label" for='name'>Currency Name<strong
                                                    class="text-danger">*</strong></label>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="rate" name="rate" class="form-control"
                                                value="{{ old('rate') }}" required>
                                            <label class="form-label" for="rate">Rate<strong
                                                    class="text-danger">*</strong></label>
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
                        <div class="card shadow-sm  mb-3 bg-white rounded">
                            <div class="card-header bg-primary">
                                <h4 class="text-white"><i class="fa fa-list"></i> Currency List</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive p-1">
                                    <table class="table table-striped table-hover table-bordered data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>S.No</th>
                                                <th>Currency Name</th>
                                                <th>Rate</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($currencies as $currency)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $currency->name }}</td>
                                                    <td>{{ $currency->rate }}</td>
                                                    <td>
                                                        <a href="{{ route('currency.edit', $currency) }}"
                                                            class="btn btn-info btn-sm" title="Edit!"><i
                                                                class="fa fa-edit"></i></a>
                                                        <!-- <button class="btn btn-danger btn-sm btn-delete" data-id='{{ $currency->id }}' title="Delete!"><i class="fa fa-trash"></i>

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
                        $('#delete-form').attr('action', "/currency/" + id);
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
