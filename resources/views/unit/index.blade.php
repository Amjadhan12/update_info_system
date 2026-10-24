@extends('layouts.admin')
@section('title', 'Item Units')

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
                                <h4 class="text-white"><i class="fa fa-plus"></i> نوې واحد</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('unit.store') }}" method="post" id="frm">
                                    @csrf
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="name" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" autofocus required>
                                            <label class="form-label" for='name'>د واحد نوم<strong
                                                    class="text-danger">*</strong></label>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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
                                <h4 class="text-white"><i class="fa fa-list"></i> د جنس د واحداتو لیست</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive p-1">
                                    <table class="table table-striped table-hover table-bordered data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>شماره</th>
                                                <th>د جنس نوم</th>
                                                <th>عملیه</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($units as $unit)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $unit->name }}</td>
                                                    <td>
                                                        <a href="{{ route('unit.edit', $unit) }}"
                                                            class="btn btn-info btn-sm" title="Edit!"><i
                                                                class="fa fa-edit"></i></a>
                                                        {{-- <!-- <button class="btn btn-danger btn-sm btn-delete" data-id='{{ $unit->id }}' title="Delete!"><i class="fa fa-trash"></i>

                                                    </button> --> --}}
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
                                <h4 class="text-white"><i class="fa fa-plus"></i> New Item Unit</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('unit.store') }}" method="post" id="frm">
                                    @csrf
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="name" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" autofocus required>
                                            <label class="form-label" for='name'>Unit Name<strong
                                                    class="text-danger">*</strong></label>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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
                                <h4 class="text-white"><i class="fa fa-list"></i> Item Units List</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive p-1">
                                    <table class="table table-striped table-hover table-bordered data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>S.No</th>
                                                <th>Unit Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($units as $unit)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $unit->name }}</td>
                                                    <td>
                                                        <a href="{{ route('unit.edit', $unit) }}"
                                                            class="btn btn-info btn-sm" title="Edit!"><i
                                                                class="fa fa-edit"></i></a>
                                                        <!-- <button class="btn btn-danger btn-sm btn-delete" data-id='{{ $unit->id }}' title="Delete!"><i class="fa fa-trash"></i>

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
                        $('#delete-form').attr('action', "/unit/" + id);
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
