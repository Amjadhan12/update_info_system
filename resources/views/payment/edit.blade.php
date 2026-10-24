@extends('layouts.admin')
@section('title', 'Edit Payment')

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
                            <h4 class="text-white"><i class="fa fa-edit"></i> د شرکت په وصولی کې تغیر</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('payment.update', $payment) }}" method="post" id="frm">
                                @csrf
                                @method("put")
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <div class="row">

                                    <div class="pb-1 col-md-6">
                                        <div class="form-group">
                                            <label for='supplier_id'>شرکت<strong class="text-danger">*</strong></label>
                                            <select id="supplier_id" name="supplier_id" class="select2" autofocus
                                                style="width: 100%;">
                                                <option value="{{ $payment->supplier_id }}">{{ $payment->supplier->name }}
                                                </option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="pb-1 col-md-6">
                                        <div class="form-group">
                                            <label for='currency_id'>کرنسي<strong class="text-danger">*</strong></label>
                                            <select id="currency_id" name="currency_id" class="select2" autofocus
                                                style="width: 100%;">
                                                <option value="{{ $payment->currency_id }}">{{ $payment->currency->name }}
                                                </option>
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-group">
                                        <label for='cash_account_id'>د نغدو حساب<strong
                                                class="text-danger">*</strong></label>
                                        <select id="cash_account_id" name="cash_account_id" class="select2" autofocus
                                            style="width: 100%;">
                                            <option value="{{ $payment->cash_account_id }}">
                                                {{ $payment->cashAccount->name }}</option>
                                            @foreach ($cashAccounts as $cashAccount)
                                                <option value="{{ $cashAccount->id }}">{{ $cashAccount->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input type="text" id="amount" name="amount" class="form-control"
                                            value="{{ $payment->amount }}" required>
                                        <label class="form-label" for="amount">د وصولی اندازه<strong
                                                class="text-danger">*</strong></label>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input type="text" id="date" name="date" class="form-control date"
                                            value="{{ $payment->date }}" required>
                                        <label class="form-label" for="date">نیټه<strong
                                                class="text-danger">*</strong></label>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <textarea name="details" id="details"
                                            class="form-control">{{ $payment->details }}</textarea>
                                        <label class="form-label" for="details">وضاحت</label>
                                    </div>
                                </div>
                                <div class="form-group my-2">
                                    <button class="btn btn-primary" id="submit" type="submit"><i class="fa fa-save"></i>
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
                            <h4 class="text-white"><i class="fa fa-edit"></i> Edit Payment</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('payment.update', $payment) }}" method="post" id="frm">
                                @csrf
                                @method("put")
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <div class="row">

                                    <div class="pb-1 col-md-6">
                                        <div class="form-group">
                                            <label for='supplier_id'>Supplier<strong
                                                    class="text-danger">*</strong></label>
                                            <select id="supplier_id" name="supplier_id" class="select2" autofocus
                                                style="width: 100%;">
                                                <option value="{{ $payment->supplier_id }}">{{ $payment->supplier->name }}
                                                </option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
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
                                                <option value="{{ $payment->currency_id }}">{{ $payment->currency->name }}
                                                </option>
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-group">
                                        <label for='cash_account_id'>Cash Account<strong
                                                class="text-danger">*</strong></label>
                                        <select id="cash_account_id" name="cash_account_id" class="select2" autofocus
                                            style="width: 100%;">
                                            <option value="{{ $payment->cash_account_id }}">
                                                {{ $payment->cashAccount->name }}</option>
                                            @foreach ($cashAccounts as $cashAccount)
                                                <option value="{{ $cashAccount->id }}">{{ $cashAccount->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input type="text" id="amount" name="amount" class="form-control"
                                            value="{{ $payment->amount }}" required>
                                        <label class="form-label" for="amount">Payment Amount<strong
                                                class="text-danger">*</strong></label>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input type="text" id="date" name="date" class="form-control date"
                                            value="{{ $payment->date }}" required>
                                        <label class="form-label" for="date">Payment Date<strong
                                                class="text-danger">*</strong></label>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <textarea name="details" id="details"
                                            class="form-control">{{ $payment->details }}</textarea>
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
            $("#nav_purchase").addClass("active");
        });
    </script>

@endsection
