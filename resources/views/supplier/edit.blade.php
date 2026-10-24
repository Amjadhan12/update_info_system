@extends('layouts.admin')
@section('title', 'Edit Supplier')

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
                            <h4 class="text-white"><i class="fa fa-plus"></i> د شرکت تغیر</h4>
                        </div>
                        <div class="card-body">



                            <form method="post" action="{{ route('supplier.update', $supplier) }}" id="frm">
                                @csrf
                                @method('put')
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input id="name" name="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ $supplier->name }}" autofocus required tabindex="1">
                                        <label class="form-label" for='name'>د شرکت نوم<strong
                                                class="text-danger">*</strong></label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input type="text" id="phone" name="phone" class="form-control"
                                            value="{{ $supplier->phone }}" required tabindex="2">
                                        <label class="form-label" for="phone">موبايل شميره<strong
                                                class="text-danger">*</strong></label>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <textarea name="details" id="details" class="form-control"
                                            tabindex="3">{{ $supplier->details }}</textarea>
                                        <label class="form-label" for="details">وضاحت</label>
                                    </div>
                                </div>
                                <div class="form-group my-2">
                                    <button class="btn btn-primary" id="submit" type="submit" tabindex="4"><i
                                            class="fa fa-save"></i> تغیر</button>
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
                            <h4 class="text-white"><i class="fa fa-plus"></i> Edit Supplier</h4>
                        </div>
                        <div class="card-body">



                            <form method="post" action="{{ route('supplier.update', $supplier) }}" id="frm">
                                @csrf
                                @method('put')
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input id="name" name="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ $supplier->name }}" autofocus required tabindex="1">
                                        <label class="form-label" for='name'>Supplier Name<strong
                                                class="text-danger">*</strong></label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <input type="text" id="phone" name="phone" class="form-control"
                                            value="{{ $supplier->phone }}" required tabindex="2">
                                        <label class="form-label" for="phone">Phone<strong
                                                class="text-danger">*</strong></label>
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">
                                        <textarea name="details" id="details" class="form-control"
                                            tabindex="3">{{ $supplier->details }}</textarea>
                                        <label class="form-label" for="details">Details</label>
                                    </div>
                                </div>
                                <div class="form-group my-2">
                                    <button class="btn btn-primary" id="submit" type="submit" tabindex="4"><i
                                            class="fa fa-save"></i> Update</button>
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
            $("#nav_add").addClass("active");
        });
    </script>

@endsection
