@extends('layouts.admin')
@section('title', 'Edit Cash')

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
                                <h4 class="text-white"><i class="fa fa-plus"></i> د نغدو د انتقال تغیر</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('cashTransfer.update', $cashTransfer) }}" method="post" id="frm">
                                    @csrf
                                    @method("put")
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="row">
                                        <div class="col-md-6 pb-1">
                                            <div class="form-group">
                                                <label for='from_account_id'>له حساب څخه<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="from_account_id" name="from_account_id" class="select2"
                                                    autofocus style="width: 100%;">
                                                    <option value="{{ $cashTransfer->from_account_id }}">
                                                        {{ App\Models\CashAccount::find($cashTransfer->from_account_id)->name }}
                                                    </option>
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
                                                    <option value="{{ $cashTransfer->to_account_id }}">
                                                        {{ App\Models\CashAccount::find($cashTransfer->to_account_id)->name }}
                                                    </option>
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
                                                <option value="{{ $cashTransfer->currency_id }}">
                                                    {{ $cashTransfer->currency->name }}</option>
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="amount" name="amount"
                                                value="{{ $cashTransfer->amount }}" class="form-control" required>
                                            <label class="form-label" for="amount">اندازه<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="date" name="date" class="form-control date"
                                                value="{{ $cashTransfer->date }}" required>
                                            <label class="form-label" for="date"> نیټه<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <textarea name="details" id="details"
                                                class="form-control">{{ $cashTransfer->details }}</textarea>
                                            <label class="form-label" for="details">وضاحت</label>
                                        </div>
                                    </div>
                                    <div class="form-group my-2">
                                        <button class="btn btn-primary" id="submit" type="submit"><i
                                                class="fa fa-save"></i>
                                            تغیر</button>
                                    </div>
                                </form>
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
                            <h4 class="text-white"><i class="fa fa-plus"></i> Edit Cash</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('cashTransfer.update', $cashTransfer) }}" method="post" id="frm">
                                @csrf
                                @method("put")
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <div class="row">
                                    <div class="col-md-6 pb-1">
                                        <div class="form-group">
                                            <label for='from_account_id'>From Cash Account<strong
                                                    class="text-danger">*</strong></label>
                                            <select id="from_account_id" name="from_account_id" class="select2"
                                                autofocus style="width: 100%;">
                                                <option value="{{ $cashTransfer->from_account_id }}">
                                                    {{ App\Models\CashAccount::find($cashTransfer->from_account_id)->name }}
                                                </option>
                                                @foreach ($cashAccounts as $cashAccount)
                                                    <option value="{{ $cashAccount->id }}">{{ $cashAccount->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pb-1">
                                        <div class="form-group">
                                            <label for='to_account_id'>From Cash Account<strong
                                                    class="text-danger">*</strong></label>
                                            <select id="to_account_id" name="to_account_id" class="select2" autofocus
                                                style="width: 100%;">
                                                <option value="{{ $cashTransfer->to_account_id }}">
                                                    {{ App\Models\CashAccount::find($cashTransfer->to_account_id)->name }}
                                                </option>
                                                @foreach ($cashAccounts as $cashAccount)
                                                    <option value="{{ $cashAccount->id }}">{{ $cashAccount->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-group">
                                        <label for='currency_id'>Currency<strong class="text-danger">*</strong></label>
                                        <select id="currency_id" name="currency_id" class="select2"
                                            style="width: 100%;">
                                            <option value="{{ $cashTransfer->currency_id }}">
                                                {{ $cashTransfer->currency->name }}</option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input type="text" id="amount" name="amount" value="{{ $cashTransfer->amount }}"
                                            class="form-control" required>
                                        <label class="form-label" for="amount">Cash Amount (+/-)<strong
                                                class="text-danger">*</strong></label>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input type="text" id="date" name="date" class="form-control date"
                                            value="{{ $cashTransfer->date }}" required>
                                        <label class="form-label" for="date"> Date<strong
                                                class="text-danger">*</strong></label>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <textarea name="details" id="details"
                                            class="form-control">{{ $cashTransfer->details }}</textarea>
                                        <label class="form-label" for="details">Details</label>
                                    </div>
                                </div>
                                <div class="form-group my-2">
                                    <button class="btn btn-primary" id="submit" type="submit"><i class="fa fa-save"></i>
                                        Update</button>
                                </div>
                            </form>
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
