@extends('layouts.admin')
@section('title', 'Receipt')

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
                                <h4 class="text-white"><i class="fa fa-plus"></i> د مشتری نوې وصولی</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('received.store') }}" method="post" id="frm">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="row">
                                        <div class="pb-1 col-md-6">
                                            <div class="form-group">
                                                <label for='customer_id'>مشتری<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="customer_id" name="customer_id" class="select2" autofocus
                                                    style="width: 100%;">
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="pb-1 col-md-6">
                                            <div class="form-group">
                                                <label for='currency_id'>کرنسي<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="currency_id" name="currency_id" class="select2" autofocus
                                                    style="width: 100%;">
                                                    @foreach ($currencies as $currency)
                                                        <option value="{{ $currency->id }}">{{ $currency->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-group">
                                            <label for='cash_account_id'>د نغدو حساب<strong
                                                    class="text-danger">*</strong></label>
                                            <select id="cash_account_id" name="cash_account_id" class="select2"
                                                autofocus style="width: 100%;">
                                                @foreach ($cashAccounts as $cashAccount)
                                                    <option value="{{ $cashAccount->id }}">{{ $cashAccount->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="amount" name="amount" class="form-control" required>
                                            <label class="form-label" for="amount">د وصولی اندازه<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="rasid_no" name="rasid_no" class="form-control"
                                                required>
                                            <label class="form-label" for="rasid_no">رسید نمبر<strong
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
                                <h4 class="text-white"><i class="fa fa-list"></i> د مشتری د وصولی لیست</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive p-1">
                                    <table class="table table-striped table-hover table-bordered data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>شماره</th>
                                                <th>مشتری</th>
                                                <th>د نغدو حساب</th>
                                                <th>د وصولی اندازه</th>
                                                <th>رسید نمبر</th>
                                                <th>نیټه</th>
                                                <th>وضاحت</th>
                                                <th>عملیه</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($receiveds as $received)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $received->customer->name }}</td>
                                                    <td>{{ $received->cashAccount->name }}</td>
                                                    <td>{{ $received->amount }} {{ $received->currency->name }}</td>
                                                    <td>{{ $received->rasid_no }}</td>
                                                    <td>{{ $received->date }}</td>
                                                    <td>{{ $received->details }}</td>
                                                    <td>
                                                        <a href="{{ route('received.edit', $received) }}"
                                                            class="btn btn-info btn-sm" title="Edit!"><i
                                                                class="fa fa-edit"></i></a>
                                                        <!-- <button class="btn btn-danger btn-sm btn-delete" data-id='{{ $received->id }}' title="Delete!"><i class="fa fa-trash"></i>

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
                                <h4 class="text-white"><i class="fa fa-plus"></i> New Receipt</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('received.store') }}" method="post" id="frm">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="row">
                                        <div class="pb-1 col-md-6">
                                            <div class="form-group">
                                                <label for='customer_id'>customer<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="customer_id" name="customer_id" class="select2" autofocus
                                                    style="width: 100%;">
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="pb-1 col-md-6">
                                            <div class="form-group">
                                                <label for='currency_id'>Currency<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="currency_id" name="currency_id" class="select2" autofocus
                                                    style="width: 100%;">
                                                    @foreach ($currencies as $currency)
                                                        <option value="{{ $currency->id }}">{{ $currency->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-group">
                                            <label for='cash_account_id'>Cash Account<strong
                                                    class="text-danger">*</strong></label>
                                            <select id="cash_account_id" name="cash_account_id" class="select2"
                                                autofocus style="width: 100%;">
                                                @foreach ($cashAccounts as $cashAccount)
                                                    <option value="{{ $cashAccount->id }}">{{ $cashAccount->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="amount" name="amount" class="form-control" required>
                                            <label class="form-label" for="amount">Receipt Amount<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="rasid_no" name="rasid_no" class="form-control"
                                                required>
                                            <label class="form-label" for="rasid_no">Rasid No<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="date" name="date" class="form-control date"
                                                value="{{ date('Y-m-d') }}" required>
                                            <label class="form-label" for="date">Receipt Date<strong
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
                                <h4 class="text-white"><i class="fa fa-list"></i> Receipts List</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive p-1">
                                    <table class="table table-striped table-hover table-bordered data_table">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>S.No</th>
                                                <th>Customer</th>
                                                <th>Cash Account</th>
                                                <th>Amount</th>
                                                <th>Rasid No</th>
                                                <th>Date</th>
                                                <th>Details</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($receiveds as $received)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $received->customer->name }}</td>
                                                    <td>{{ $received->cashAccount->name }}</td>
                                                    <td>{{ $received->amount }} {{ $received->currency->name }}</td>
                                                    <td>{{ $received->rasid_no }}</td>
                                                    <td>{{ $received->date }}</td>
                                                    <td>{{ $received->details }}</td>
                                                    <td>
                                                        <a href="{{ route('received.edit', $received) }}"
                                                            class="btn btn-info btn-sm" title="Edit!"><i
                                                                class="fa fa-edit"></i></a>
                                                        <!-- <button class="btn btn-danger btn-sm btn-delete" data-id='{{ $received->id }}' title="Delete!"><i class="fa fa-trash"></i>

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
            $("#nav_sale").addClass("active");

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
                        $('#delete-form').attr('action', "/received/" + id);
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
