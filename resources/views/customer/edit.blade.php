@extends('layouts.admin')
@section('title', 'Edit Customer')

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
                                <h4 class="text-white"><i class="fa fa-plus"></i> د مشتری تغیر</h4>
                            </div>
                            <div class="card-body">



                                <form method="post" action="{{ route('customer.update', $customer) }}" id="frm">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="name" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ $customer->name }}" autofocus required>
                                            <label class="form-label" for='name'>د مشتری نوم<strong
                                                    class="text-danger">*</strong></label>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="phone" name="phone" class="form-control"
                                                value="{{ $customer->phone }}" required>
                                            <label class="form-label" for="phone">د موبايل شماره<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="address" name="address" class="form-control"
                                                value="{{ $customer->address }}" required>
                                            <label class="form-label" for="address">ادرس<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <textarea name="details" id="details"
                                                class="form-control">{{ $customer->details }}</textarea>
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
                                <h4 class="text-white"><i class="fa fa-plus"></i> Edit Customer</h4>
                            </div>
                            <div class="card-body">



                                <form method="post" action="{{ route('customer.update', $customer) }}" id="frm">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input id="name" name="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ $customer->name }}" autofocus required>
                                            <label class="form-label" for='name'>Customer Name<strong
                                                    class="text-danger">*</strong></label>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="phone" name="phone" class="form-control"
                                                value="{{ $customer->phone }}" required>
                                            <label class="form-label" for="phone">Phone<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <input type="text" id="address" name="address" class="form-control"
                                                value="{{ $customer->address }}" required>
                                            <label class="form-label" for="address">Address<strong
                                                    class="text-danger">*</strong></label>
                                        </div>
                                    </div>
                                    <div class="mb-3 pb-1">
                                        <div class="form-outline">
                                            <textarea name="details" id="details"
                                                class="form-control">{{ $customer->details }}</textarea>
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
            $("#nav_add").addClass("active");
        });
    </script>

@endsection
