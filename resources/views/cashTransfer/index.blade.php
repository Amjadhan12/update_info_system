@extends('layouts.admin')
@section('title', 'Cash Transfer')

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
                                <h4 class="text-white"><i class="fa fa-plus"></i> د نغدو انتقال</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('cashTransfer.store') }}" method="post" id="frm">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="row">
                                        <div class="col-md-6 pb-1">
                                            <div class="form-group">
                                                <label for='from_account_id'>له حساب څخه<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="from_account_id" name="from_account_id" class="select2"
                                                    autofocus style="width: 100%;">
                                                    @foreach ($cashAccounts as $cashAccount)
                                                        <option value="{{ $cashAccount->id }}">{{ $cashAccount->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pb-1">
                                            <div class="form-group">
                                                <label for='to_account_id'>حساب ته<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="to_account_id" name="to_account_id" class="select2"
                                                    autofocus style="width: 100%;">
                                                    @foreach ($cashAccounts as $cashAccount)
                                                        <option value="{{ $cashAccount->id }}">{{ $cashAccount->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-group">
                                            <label for='currency_id'>کرنسي<strong class="text-danger">*</strong></label>
                                            <select id="currency_id" name="currency_id" class="select2"
                                                style="width: 100%;">
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
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
                                <h4 class="text-white"><i class="fa fa-list"></i> د نغدو د انتقال لیست</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive p-1">
                                    <table class="table table-bordered table-striped table-hover data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>شماره</th>
                                                <th>له حساب څخه</th>
                                                <th>حساب ته </th>
                                                <th>اندازه</th>
                                                <th>نیټه</th>
                                                <th>وضاحت</th>
                                                <th>عملیه</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cashTransfers as $cashTransfer)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ App\Models\CashAccount::find($cashTransfer->from_account_id)->name }}
                                                    </td>
                                                    <td>{{ App\Models\CashAccount::find($cashTransfer->to_account_id)->name }}
                                                    </td>
                                                    <td>{{ $cashTransfer->amount }}
                                                        {{ $cashTransfer->currency->name }}</td>
                                                    <td>{{ $cashTransfer->date }}</td>
                                                    <td>{{ $cashTransfer->details }}</td>
                                                    <td>
                                                        <a href="{{ route('cashTransfer.edit', $cashTransfer) }}"
                                                            class="btn btn-info btn-sm" title="Edit!"><i
                                                                class="fa fa-edit"></i></a>
                                                        <!-- <button class="btn btn-danger btn-sm btn-delete" data-id='{{ $cashTransfer->id }}' title="Delete!"><i class="fa fa-trash"></i>

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
                                <h4 class="text-white"><i class="fa fa-plus"></i> Cash Transfer</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('cashTransfer.store') }}" method="post" id="frm">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="row">
                                        <div class="col-md-6 pb-1">
                                            <div class="form-group">
                                                <label for='from_account_id'>From Cash Account<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="from_account_id" name="from_account_id" class="select2"
                                                    autofocus style="width: 100%;">
                                                    @foreach ($cashAccounts as $cashAccount)
                                                        <option value="{{ $cashAccount->id }}">
                                                            {{ $cashAccount->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pb-1">
                                            <div class="form-group">
                                                <label for='to_account_id'>From Cash Account<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="to_account_id" name="to_account_id" class="select2"
                                                    autofocus style="width: 100%;">
                                                    @foreach ($cashAccounts as $cashAccount)
                                                        <option value="{{ $cashAccount->id }}">
                                                            {{ $cashAccount->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-group">
                                            <label for='currency_id'>Currency<strong
                                                    class="text-danger">*</strong></label>
                                            <select id="currency_id" name="currency_id" class="select2"
                                                style="width: 100%;">
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="amount" name="amount" class="form-control" required>
                                            <label class="form-label" for="amount">Cash Amount<strong
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
                                <h4 class="text-white"><i class="fa fa-list"></i> Expenses List</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive p-1">
                                    <table class="table table-bordered table-striped table-hover data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>S.No</th>
                                                <th>From Account</th>
                                                <th>To Account </th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Details</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cashTransfers as $cashTransfer)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ App\Models\CashAccount::find($cashTransfer->from_account_id)->name }}
                                                    </td>
                                                    <td>{{ App\Models\CashAccount::find($cashTransfer->to_account_id)->name }}
                                                    </td>
                                                    <td>{{ $cashTransfer->amount }}
                                                        {{ $cashTransfer->currency->name }}</td>
                                                    <td>{{ $cashTransfer->date }}</td>
                                                    <td>{{ $cashTransfer->details }}</td>
                                                    <td>
                                                        <a href="{{ route('cashTransfer.edit', $cashTransfer) }}"
                                                            class="btn btn-info btn-sm" title="Edit!"><i
                                                                class="fa fa-edit"></i></a>
                                                        <!-- <button class="btn btn-danger btn-sm btn-delete" data-id='{{ $cashTransfer->id }}' title="Delete!"><i class="fa fa-trash"></i>

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
                        $('#delete-form').attr('action', "/cashTransfer/" + id);
                        $("#delete-form").submit();
                    } else {
                        swal("Cancelled", "Not Deleted!", "error");
                        return false;
                    }
                });
            });

            $("#frm").submit(function(e) {
                var from = $("#from_account_id").val();
                var to = $("#to_account_id").val();
                console.log(from);
                console.log(to);
                if (from == to) {
                    showWarning("Please different accounts!");
                    return false;
                }
            });
        });
    </script>

@endsection
