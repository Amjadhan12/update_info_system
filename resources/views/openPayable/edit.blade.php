@extends('layouts.admin')
@section('title', 'Edit Open Payable')

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
                                <h4 class="text-white"><i class="fa fa-plus"></i> د شرکت په لومړني قرض کې تغیر</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('openPayable.update', $openPayable) }}" method="post" id="frm">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="row">
                                        <div class="mb-3 pb-1 col-md-6">
                                            <div class="form-group">
                                                <label for='supplier_id'>شرکت<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="supplier_id" name="supplier_id" class="select2" autofocus
                                                    style="width: 100%;">
                                                    <option value="{{ $openPayable->supplier_id }}">
                                                        {{ $openPayable->supplier->name }}</option>
                                                    @foreach ($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 pb-1 col-md-6">
                                            <div class="form-group">
                                                <label for='currency_id'>کرنسي<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="currency_id" name="currency_id" class="select2"
                                                    style="width: 100%;">
                                                    <option value="{{ $openPayable->currency_id }}">
                                                        {{ $openPayable->currency->name }}</option>
                                                    @foreach ($currencies as $currency)
                                                        <option value="{{ $currency->id }}">{{ $currency->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="amount" name="amount"
                                                value="{{ $openPayable->amount }}" class="form-control" required>
                                            <label class="form-label" for="amount">د قرض اندازه<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="date" name="date" class="form-control date"
                                                value="{{ $openPayable->date }}" required>
                                            <label class="form-label" for="date">نیټه<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <textarea name="details" id="details"
                                                class="form-control">{{ $openPayable->details }}</textarea>
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
                                <h4 class="text-white"><i class="fa fa-plus"></i> Edit Open Payable</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('openPayable.update', $openPayable) }}" method="post" id="frm">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="row">
                                        <div class="mb-3 pb-1 col-md-6">
                                            <div class="form-group">
                                                <label for='supplier_id'>Supplier<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="supplier_id" name="supplier_id" class="select2" autofocus
                                                    style="width: 100%;">
                                                    <option value="{{ $openPayable->supplier_id }}">
                                                        {{ $openPayable->supplier->name }}</option>
                                                    @foreach ($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 pb-1 col-md-6">
                                            <div class="form-group">
                                                <label for='currency_id'>Currency<strong
                                                        class="text-danger">*</strong></label>
                                                <select id="currency_id" name="currency_id" class="select2"
                                                    style="width: 100%;">
                                                    <option value="{{ $openPayable->currency_id }}">
                                                        {{ $openPayable->currency->name }}</option>
                                                    @foreach ($currencies as $currency)
                                                        <option value="{{ $currency->id }}">{{ $currency->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="amount" name="amount"
                                                value="{{ $openPayable->amount }}" class="form-control" required>
                                            <label class="form-label" for="amount">Payable Amount<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="date" name="date" class="form-control date"
                                                value="{{ $openPayable->date }}" required>
                                            <label class="form-label" for="date">Payment Date<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <textarea name="details" id="details"
                                                class="form-control">{{ $openPayable->details }}</textarea>
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
            $("#nav_opening").addClass("active");

        });
    </script>

@endsection
