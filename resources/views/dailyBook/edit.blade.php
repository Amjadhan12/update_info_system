@extends('layouts.admin')
@section('title', 'Edit Daily Book')
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
                                <h4 class="text-white"><i class="fa fa-plus"></i> په روزنامچه کې تغیر</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('dailyBook.update', $dailyBook) }}" method="post" id="frm">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="title" name="title" class="form-control"
                                                value="{{ $dailyBook->title }}" autofocus required>
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
                                                    <option value="{{ $dailyBook->currency_id }}">
                                                        {{ $dailyBook->currency->name }}
                                                    </option>
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
                                                    @if ($dailyBook->isCredit == 1)
                                                        <option value="1">Credit</option>
                                                        <option value="0">Debit</option>
                                                    @else
                                                        <option value="0">Debit</option>
                                                        <option value="1">Credit</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="amount" name="amount" class="form-control"
                                                value="{{ $dailyBook->amount }}" required>
                                            <label class="form-label" for="amount">اندازه<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="date" name="date" class="form-control date"
                                                value="{{ $dailyBook->date }}" required>
                                            <label class="form-label" for="date">نیټه<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <textarea name="details" id="details"
                                                class="form-control">{{ $dailyBook->details }}</textarea>
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
                                <h4 class="text-white"><i class="fa fa-plus"></i> Edit Daily Book</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('dailyBook.update', $dailyBook) }}" method="post" id="frm">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="title" name="title" class="form-control"
                                                value="{{ $dailyBook->title }}" autofocus required>
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
                                                    <option value="{{ $dailyBook->currency_id }}">
                                                        {{ $dailyBook->currency->name }}
                                                    </option>
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
                                                    @if ($dailyBook->isCredit == 1)
                                                        <option value="1">Credit</option>
                                                        <option value="0">Debit</option>
                                                    @else
                                                        <option value="0">Debit</option>
                                                        <option value="1">Credit</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="amount" name="amount" class="form-control"
                                                value="{{ $dailyBook->amount }}" required>
                                            <label class="form-label" for="amount">Amount<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="date" name="date" class="form-control date"
                                                value="{{ $dailyBook->date }}" required>
                                            <label class="form-label" for="date">Date<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <textarea name="details" id="details"
                                                class="form-control">{{ $dailyBook->details }}</textarea>
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
            $("#nav_capital").addClass("active");


        });
    </script>

@endsection
