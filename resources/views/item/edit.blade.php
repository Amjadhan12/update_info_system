@extends('layouts.admin')
@section('title', 'Items')

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
                                <h4 class="text-white"><i class="fa fa-plus"></i> په جنس کې تغیر</h4>
                            </div>
                            <div class="card-body">

                                <form method="post" action="{{ route('item.update', $item) }}" id="frm">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    {{-- <div class="mb-3 pb-1">
                                <div class="form-outline">
                                    <input id="barcode" name="barcode" type="text" class="form-control @error('barcode') is-invalid @enderror" value="{{$item->barcode }}" autofocus required>
                                    <label class="form-label" for='barcode'>Item barcode<strong class="text-danger">*</strong></label>
                                    @error('barcode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="name" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ $item->name }}" autofocus required>
                                            <label class="form-label" for='name'>د جنس نوم<strong
                                                    class="text-danger">*</strong></label>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-group">
                                            <label for='currency_id'>کرنسي<strong class="text-danger">*</strong></label>
                                            <select id="currency_id" name="currency_id" class="select2"
                                                style="width: 100%;">
                                                <option value="{{ $item->currency_id }}">{{ $item->currency->name }}
                                                </option>
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3 pb-1">
                                            <div class="form-outline">
                                                <input type="text" id="pprice" name="pprice" min="0" class="form-control"
                                                    value="{{ $item->pprice }}" required>
                                                <label class="form-label" for="pprice">د خریداری قیمت</label>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3 pb-1">
                                            <div class="form-outline">
                                                <input type="text" id="sprice" name="sprice" min="0" class="form-control"
                                                    value="{{ $item->sprice }}" required>
                                                <label class="form-label" for="sprice">د خرڅلاو قیمت</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <textarea name="details" id="details"
                                                class="form-control">{{ $item->details }}</textarea>
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
                                <h4 class="text-white"><i class="fa fa-plus"></i> Edit Item</h4>
                            </div>
                            <div class="card-body">

                                <form method="post" action="{{ route('item.update', $item) }}" id="frm">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    {{-- <div class="mb-3 pb-1">
                                <div class="form-outline">
                                    <input id="barcode" name="barcode" type="text" class="form-control @error('barcode') is-invalid @enderror" value="{{$item->barcode }}" autofocus required>
                                    <label class="form-label" for='barcode'>Item barcode<strong class="text-danger">*</strong></label>
                                    @error('barcode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div> --}}
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="name" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ $item->name }}" autofocus required>
                                            <label class="form-label" for='name'>Item Name<strong
                                                    class="text-danger">*</strong></label>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-group">
                                            <label for='currency_id'>Currency<strong
                                                    class="text-danger">*</strong></label>
                                            <select id="currency_id" name="currency_id" class="select2"
                                                style="width: 100%;">
                                                <option value="{{ $item->currency_id }}">{{ $item->currency->name }}
                                                </option>
                                                @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mb-3 pb-1">
                                            <div class="form-outline">
                                                <input type="text" id="pprice" name="pprice" min="0" class="form-control"
                                                    value="{{ $item->pprice }}" required>
                                                <label class="form-label" for="pprice">Purchase Cost</label>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3 pb-1">
                                            <div class="form-outline">
                                                <input type="text" id="sprice" name="sprice" min="0" class="form-control"
                                                    value="{{ $item->sprice }}" required>
                                                <label class="form-label" for="sprice">Sale Price</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <textarea name="details" id="details"
                                                class="form-control">{{ $item->details }}</textarea>
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
        });
    </script>

@endsection
