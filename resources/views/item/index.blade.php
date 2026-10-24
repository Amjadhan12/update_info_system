@extends('layouts.adminFast')
@section('title', 'Items')

@if (Auth::user()->language == 'Pashto')
    @section('body')
        <style>

        </style>
        <main class="p-3">
            <div class="container-flued">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card shadow-sm  mb-5 bg-white rounded">
                            <div class="card-header bg-primary bg-gradient">
                                <h4 class="text-white"><i class="fa fa-list"></i> د جنسونه لیست</h4>
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
