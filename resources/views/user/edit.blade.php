@extends('layouts.admin')
@section('title', 'User')

@if (Auth::user()->language == 'Pashto')
@section('body')
    <style>

    </style>
    <main class="p-3">
        <div class="container-flued">
            <div class="row">
                @if (Auth::user()->user_type == 'Admin')
                    <div class="col-md-4">
                        <div class="card shadow-sm  mb-5 bg-white rounded">
                            <div class="card-header bg-primary bg-gradient">
                                <h4 class="text-white"><i class="fa fa-plus"></i> د یوزر تغیر</h4>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('user.update', $user) }}">
                                    @csrf
                                    @method('put')
                                    <div class="form-group">
                                        <label for='name'>نوم<strong class="text-danger">*</strong></label>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ $user->name }}" required>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for='email'>ایمیل<strong class="text-danger">*</strong></label>
                                        <input id="email" type="text"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ $user->email }}" required>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for='user_type'>د یوزر ډول<strong class="text-danger">*</strong></label>
                                        <select name="user_type" id="user_type" class="form-control">
                                            <option value="{{ $user->user_type }}">{{ $user->user_type }}</option>
                                            <option value="Admin">Admin</option>
                                            <option value="User">User</option>
                                        </select>
                                    </div>

                                    <div class="form-group my-2">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                            {{ __('تغیرو') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-12">
                        <div class="card m-5 p-3 m-5">
                            <h1 class="text-danger"><i class="fa fa-exclamation-circle"></i> Banned!</h1>
                            <p>The page you have requested is not Permited.</p>
                            <p><a class="btn btn-primary" href="javascript:window.history.back();">Go Back</a></p>
                        </div>
                    </div>
                @endif
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
                @if (Auth::user()->user_type == 'Admin')
                    <div class="col-md-4">
                        <div class="card shadow-sm  mb-5 bg-white rounded">
                            <div class="card-header bg-primary bg-gradient">
                                <h4 class="text-white"><i class="fa fa-plus"></i> Edit Setting</h4>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('user.update', $user) }}">
                                    @csrf
                                    @method('put')
                                    <div class="form-group">
                                        <label for='name'>Name<strong class="text-danger">*</strong></label>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ $user->name }}" required>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for='email'>Email<strong class="text-danger">*</strong></label>
                                        <input id="email" type="text"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ $user->email }}" required>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for='user_type'>User Type<strong class="text-danger">*</strong></label>
                                        <select name="user_type" id="user_type" class="form-control">
                                            <option value="{{ $user->user_type }}">{{ $user->user_type }}</option>
                                            <option value="Admin">Admin</option>
                                            <option value="User">User</option>
                                        </select>
                                    </div>

                                    <div class="form-group my-2">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                            {{ __('Update') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-12">
                        <div class="card m-5 p-3 m-5">
                            <h1 class="text-danger"><i class="fa fa-exclamation-circle"></i> Banned!</h1>
                            <p>The page you have requested is not Permited.</p>
                            <p><a class="btn btn-primary" href="javascript:window.history.back();">Go Back</a></p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>

@endsection
@endif

@section('pageJs')


    <script>
        $(document).ready(function() {
            $(".nav-link").removeClass('active');
            $("#nav_settings").addClass("active");
        });
    </script>

@endsection
