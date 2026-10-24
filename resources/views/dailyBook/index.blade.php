@extends('layouts.admin')
@section('title', 'Daily Book')

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
                                <h4 class="text-white"><i class="fa fa-plus"></i> روزنامچه</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('dailyBook.store') }}" method="post" id="frm">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="title" name="title" class="form-control" autofocus
                                                required>
                                            <label class="form-label" for="title">عنوان<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-2 pb-1 col-md-6">
                                            <div class="form-group">
                                                <label for='currency_id'>کرنسي<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="currency_id" name="currency_id" class="select2"
                                                    style="width: 100%;">
                                                    @foreach ($currencies as $currency)
                                                        <option value="{{ $currency->id }}">{{ $currency->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-2 pb-1 col-md-6">
                                            <div class="form-group">
                                                <label for='isCredit'>حالت<strong class="text-danger">*</strong></label>
                                                <select id="isCredit" name="isCredit" class="form-control">
                                                    <option value="1">Credit</option>
                                                    <option value="0">Debit</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="amount" name="amount" class="form-control" required>
                                            <label class="form-label" for="amount">اندازه<strong
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
                                <h4 class="text-white"><i class="fa fa-list"></i> روزنامچه</h4>
                            </div>
                            <div class="card-body">
                                <div class="row border mx-3 p-3">
                                    <h4>Filter</h4>
                                    <div class="col-md-4">
                                        <div class="form-outline">
                                            <input type="text" id="fromDate" name="fromDate" class="form-control date"
                                                value="{{ date('Y-m-01') }}" required>
                                            <label class="form-label" for="fromDate">Date<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-outline">
                                            <input type="text" id="toDate" name="toDate" class="form-control date"
                                                value="{{ date('Y-m-d') }}" required>
                                            <label class="form-label" for="todate">Date<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-primary" id="btn_show">کتل</button>
                                    </div>
                                </div>
                                <div class="table-responsive p-1">
                                    <table class="table table-bordered table-striped table-hover data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>شماره</th>
                                                <th>عنوان</th>
                                                <th>حالت</th>
                                                <th>اندازه</th>
                                                <th>نیټه</th>
                                                <th>وضاحت</th>
                                                <th>عملیه</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dailyBooks as $dailyBook)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $dailyBook->title }}</td>
                                                    <td>
                                                        @if ($dailyBook->isCredit == 1) Credit @else Debit @endif
                                                    </td>
                                                    <td>{{ $dailyBook->amount }} {{ $dailyBook->currency->name }}</td>
                                                    <td>{{ $dailyBook->date }}</td>
                                                    <td>{{ $dailyBook->details }}</td>
                                                    <td>
                                                        <a href="{{ route('dailyBook.edit', $dailyBook) }}"
                                                            class="btn btn-info btn-sm" title="Edit!"><i
                                                                class="fa fa-edit"></i></a>
                                                        <!-- <button class="btn btn-danger btn-sm btn-delete" data-id='{{ $dailyBook->id }}' title="Delete!"><i class="fa fa-trash"></i>

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
                            <div class="card-footer">
                                {{ $dailyBooks->links() }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>

        <!-- Modal -->
        <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">روزنامچه</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body table-responsive">
                        <div class="print_div"></div>
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

                    <div class="col-md-4">
                        <div class="card shadow-sm  mb-5 bg-white rounded">
                            <div class="card-header bg-primary bg-gradient">
                                <h4 class="text-white"><i class="fa fa-plus"></i> Daily Book New Record</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('dailyBook.store') }}" method="post" id="frm">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="title" name="title" class="form-control" autofocus
                                                required>
                                            <label class="form-label" for="title">Title<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-2 pb-1 col-md-6">
                                            <div class="form-group">
                                                <label for='currency_id'>Currency<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="currency_id" name="currency_id" class="select2"
                                                    style="width: 100%;">
                                                    @foreach ($currencies as $currency)
                                                        <option value="{{ $currency->id }}">{{ $currency->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-2 pb-1 col-md-6">
                                            <div class="form-group">
                                                <label for='isCredit'>State<strong class="text-danger">*</strong></label>
                                                <select id="isCredit" name="isCredit" class="form-control">
                                                    <option value="1">Credit</option>
                                                    <option value="0">Debit</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="amount" name="amount" class="form-control" required>
                                            <label class="form-label" for="amount">Amount<strong
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
                                <h4 class="text-white"><i class="fa fa-list"></i> Daily Book</h4>
                            </div>
                            <div class="card-body">
                                <div class="row border mx-3 p-3">
                                    <h4>Filter</h4>
                                    <div class="col-md-4">
                                        <div class="form-outline">
                                            <input type="text" id="fromDate" name="fromDate" class="form-control date"
                                                value="{{ date('Y-m-01') }}" required>
                                            <label class="form-label" for="fromDate">Date<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-outline">
                                            <input type="text" id="toDate" name="toDate" class="form-control date"
                                                value="{{ date('Y-m-d') }}" required>
                                            <label class="form-label" for="todate">Date<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-primary" id="btn_show">Show</button>
                                    </div>
                                </div>
                                <div class="table-responsive p-1">
                                    <table class="table table-bordered table-striped table-hover data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>S.No</th>
                                                <th>Tile</th>
                                                <th>State</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Details</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($dailyBooks as $dailyBook)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $dailyBook->title }}</td>
                                                    <td>
                                                        @if ($dailyBook->isCredit == 1) Credit @else Debit @endif
                                                    </td>
                                                    <td>{{ $dailyBook->amount }} {{ $dailyBook->currency->name }}</td>
                                                    <td>{{ $dailyBook->date }}</td>
                                                    <td>{{ $dailyBook->details }}</td>
                                                    <td>
                                                        <a href="{{ route('dailyBook.edit', $dailyBook) }}"
                                                            class="btn btn-info btn-sm" title="Edit!"><i
                                                                class="fa fa-edit"></i></a>
                                                        <!-- <button class="btn btn-danger btn-sm btn-delete" data-id='{{ $dailyBook->id }}' title="Delete!"><i class="fa fa-trash"></i>

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
                            <div class="card-footer">
                                {{ $dailyBooks->links() }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>

        <!-- Modal -->
        <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Daily Book</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body table-responsive">
                        <div class="print_div"></div>
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
            $("#nav_capital").addClass("active");

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
                        $('#delete-form').attr('action', "/dailyBook/" + id);
                        $("#delete-form").submit();
                    } else {
                        swal("Cancelled", "Not Deleted!", "error");
                        return false;
                    }
                });
            });


            $(document).on("click", "#btn_show", function() {
                $.ajax({
                    url: "/ajax/report/dailyBook",
                    type: 'GET',
                    data: {
                        "fromDate": $("#fromDate").val(),
                        "toDate": $("#toDate").val(),
                    },
                    success: function(data) {
                        $("#showModal").modal("show");
                        $(".print_div").html(data)
                    },
                    error: function() {
                        swal("Warrning", "Error Occured!", "error");
                    }
                });
            })
        });
    </script>

@endsection
