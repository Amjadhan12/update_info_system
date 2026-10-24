@extends('layouts.admin')
@section('title', 'Sale List')

@if (Auth::user()->language == 'Pashto')
    @section('body')
        <style>

        </style>
        <main class="p-3">
            <div class="container-flued">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-sm  mb-5 bg-white rounded">
                            <div class="card-header bg-primary">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="text-white"><i class="fa fa-eye"></i> د خرید لیست</h4>
                                        
                                    </div>
                                    <div class="col-6">
                                        <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
                                            <a class="btn btn-primary" href="{{ route('purchase.create') }}"><i
                                                    class="fa fa-plus" title="New Purchase"></i> نوی</a>
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
                                                <th>بیل نمبر</th>
                                                <th>شرکت</th>
                                                <th>مجموعه</th>
                                                <th>نیټه</th>
                                                <th>وضاحت</th>
                                                <th>عملیه</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($purchases as $purchase)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $purchase->bill_id }}</td>
                                                    <td>{{ $purchase->supplier_name }}</td>
                                                    <td>{{ $purchase->amount }}
                                                        {{ App\Models\Currency::find($purchase->currency_id)->name }}
                                                    </td>
                                                    <td>{{ $purchase->purchase_date }}</td>
                                                    <td>{{ $purchase->details }}</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm btn-print"
                                                            data-id='{{ $purchase->bill_id }}' title="Print!"><i
                                                                class="fa fa-print"></i>

                                                        </button>
                                                        <a href="{{ route('purchase.edit', $purchase->bill_id) }}"
                                                            class="btn btn-primary btn-sm" title="Edit!"><i
                                                                class="fa fa-edit"></i></a>
                                                        <button class="btn btn-danger btn-sm btn-delete"
                                                            data-id='{{ $purchase->bill_id }}' title="Delete!"><i
                                                                class="fa fa-trash"></i>

                                                        </button>

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
        <!-- Modal -->
        <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">چاپول</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="print_div">

                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection
@else
@section('body')
    <style>

    </style>
    <main class="p-3">
        <div class="container-flued">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm  mb-5 bg-white rounded">
                        <div class="card-header bg-primary">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="text-white"><i class="fa fa-eye"></i> purchase List</h4>
                                </div>
                                <div class="col-6">
                                    <div class="btn-group float-end" role="group" aria-label="Basic outlined example">
                                        <a class="btn btn-primary" href="{{ route('purchase.create') }}"><i
                                                class="fa fa-plus" title="New Purchase"></i> New Purchase</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped table-hover table-bordered data_table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No#</th>
                                            <th>‌Bill No</th>
                                            <th>company</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Details</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($purchases as $purchase)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $purchase->bill_id }}</td>
                                                    <td>{{ $purchase->supplier_name }}</td>
                                                    <td>{{ $purchase->amount }}
                                                        {{ App\Models\Currency::find($purchase->currency_id)->name }}
                                                    </td>
                                                    <td>{{ $purchase->purchase_date }}</td>
                                                    <td>{{ $purchase->details }}</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm btn-print"
                                                            data-id='{{ $purchase->bill_id }}' title="Print!"><i
                                                                class="fa fa-print"></i>

                                                        </button>
                                                        <a href="{{ route('purchase.edit', $purchase->bill_id) }}"
                                                            class="btn btn-primary btn-sm" title="Edit!"><i
                                                                class="fa fa-edit"></i></a>
                                                        <button class="btn btn-danger btn-sm btn-delete"
                                                            data-id='{{ $purchase->bill_id }}' title="Delete!"><i
                                                                class="fa fa-trash"></i>

                                                        </button>

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
    <!-- Modal -->
    <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Print</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="print_div">

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@endif

@section('pageJs')

    <script>
        $(document).ready(function() {
            $(".nav-link").removeClass('active');
            $("#nav_Purchase").addClass("active");



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
                        $('#delete-form').attr('action', "/purchase/" + id);
                        $("#delete-form").submit();
                    } else {
                        swal("Cancelled", "Not Deleted!", "error");
                        return false;
                    }
                });
            });




            $(".btn-print").click(function() {
                var bill_no = $(this).attr('data-id');
                $.ajax({
                    url: "{{ url('/purchasePrint') }}",
                    type: 'GET',
                    data: {
                        "id": bill_no
                    },
                    success: function(data) {
                        // console.log(data);
                        $(".print_div").html(data);

                        var mode = 'iframe';
                        var close = mode == 'popup';
                        var options = {
                            mode: mode,
                            popClose: close
                        };
                        $('div.print_div').printArea(options);
                    },
                    error: function() {
                        // swal("Warrning", "Error Occured", "error");
                    }
                });
            });
        });
    </script>

@endsection
