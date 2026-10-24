@extends('layouts.admin')
@section('title', 'Edit Receipt')

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
                                <h4 class="text-white"><i class="fa fa-plus"></i> د مشتری په وصولی کې تغیر</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('received.update', $received) }}" method="post" id="frm">
                                    @csrf
                                    @method("put")
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="row">
                                        <div class="pb-1 col-md-6">
                                            <div class="form-group">
                                                <label for='customer_id'>مشتری<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="customer_id" name="customer_id" class="select2" autofocus
                                                    style="width: 100%;">
                                                    <option value="{{ $received->customer_id }}">
                                                        {{ $received->customer->name }}
                                                    </option>
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
                                                    <option value="{{ $received->currency_id }}">
                                                        {{ $received->currency->name }}
                                                    </option>
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
                                                <option value="{{ $received->cash_account_id }}">
                                                    {{ $received->cashAccount->name }}</option>
                                                @foreach ($cashAccounts as $cashAccount)
                                                    <option value="{{ $cashAccount->id }}">{{ $cashAccount->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="amount" name="amount" class="form-control"
                                                value="{{ $received->amount }}" required>
                                            <label class="form-label" for="amount">د وصولی اندازه<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="rasid_no" name="rasid_no"
                                                value="{{ $received->rasid_no }}" class="form-control" required>
                                            <label class="form-label" for="rasid_no">رسید نمبر<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="date" name="date" class="form-control date"
                                                value="{{ $received->date }}" required>
                                            <label class="form-label" for="date">نیټه<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <textarea name="details" id="details"
                                                class="form-control">{{ $received->details }}</textarea>
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
                                <h4 class="text-white"><i class="fa fa-plus"></i> Edit Receipt</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('received.update', $received) }}" method="post" id="frm">
                                    @csrf
                                    @method("put")
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="row">
                                        <div class="pb-1 col-md-6">
                                            <div class="form-group">
                                                <label for='customer_id'>customer<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="customer_id" name="customer_id" class="select2" autofocus
                                                    style="width: 100%;">
                                                    <option value="{{ $received->customer_id }}">
                                                        {{ $received->customer->name }}
                                                    </option>
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
                                                    <option value="{{ $received->currency_id }}">
                                                        {{ $received->currency->name }}
                                                    </option>
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
                                                <option value="{{ $received->cash_account_id }}">
                                                    {{ $received->cashAccount->name }}</option>
                                                @foreach ($cashAccounts as $cashAccount)
                                                    <option value="{{ $cashAccount->id }}">{{ $cashAccount->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="amount" name="amount" class="form-control"
                                                value="{{ $received->amount }}" required>
                                            <label class="form-label" for="amount">Receipt Amount<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="rasid_no" name="rasid_no"
                                                value="{{ $received->rasid_no }}" class="form-control" required>
                                            <label class="form-label" for="rasid_no">Rasid No<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="date" name="date" class="form-control date"
                                                value="{{ $received->date }}" required>
                                            <label class="form-label" for="date">Receipt Date<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <textarea name="details" id="details"
                                                class="form-control">{{ $received->details }}</textarea>
                                            <label class="form-label" for="details">Details</label>
                                        </div>
                                    </div>
                                    <div class="form-group my-2">
                                        <button class="btn btn-primary" id="submit" type="submit"><i
                                                class="fa fa-save"></i>
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
            $("#nav_sale").addClass("active");
        });
    </script>

@endsection
