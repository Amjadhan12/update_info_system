@extends('layouts.admin')
@section('title', 'Setting')

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
                                    <h4 class="text-white"><i class="fa fa-plus"></i> نوی یوزر</h4>
                                </div>
                                <div class="card-body">
                                    <form method="post" id="frm" action="{{ route('user.store') }}">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                        <div class="form-group">
                                            <label for='name'>نوم<strong class="text-danger">*</strong></label>
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}" required autocomplete="off" autofocus
                                                tabindex="1">

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
                                                value="{{ old('email') }}" required autocomplete="off" tabindex="2">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for='user_type'>د یوزر ډول<strong
                                                    class="text-danger">*</strong></label>
                                            <select name="user_type" id="user_type" class="form-control" tabindex="3">
                                                <option value="Admin">Admin</option>
                                                <option value="User">User</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for='password'>پاسورډ<strong class="text-danger">*</strong></label>
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                value="{{ old('password') }}" required autocomplete="off" tabindex="4">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for='password_confirmation'>تایید پاسورډ<strong
                                                    class="text-danger">*</strong></label>
                                            <input id="password_confirmation" type="password"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                name="password_confirmation" value="{{ old('password_confirmation') }}"
                                                required autocomplete="off" tabindex="5">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group py-2">
                                            <button type="submit" id="submit" class="btn btn-primary"><i
                                                    class="fa fa-save" tabindex="6"></i>
                                                {{ __('ثبتول') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card shadow-sm  mb-5 bg-white rounded">
                                <div class="card-header bg-primary bg-gradient">
                                    <h4 class="text-white"><i class="fa fa-list"></i> Users</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive p-1">
                                        <table class="table table-bordered table-striped table-hover data_table">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>User Type</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td>{{ $user->id }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->user_type }}</td>

                                                        <td>
                                                            <a href="{{ route('user.edit', $user) }}"
                                                                class="btn btn-info btn-sm" title="Edit!"><i
                                                                    class="fa fa-edit"></i></a>
                                                            <!-- <button class="btn btn-danger btn-sm btn-delete" data-id='{{ $user->id }}' title="Delete!"><i class="fa fa-trash"></i> -->

                                                            </button>
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
                                    <h4 class="text-white"><i class="fa fa-plus"></i> New User</h4>
                                </div>
                                <div class="card-body">
                                    <form method="post" id="frm" action="{{ route('user.store') }}">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                        <div class="form-group">
                                            <label for='name'>User Name<strong class="text-danger">*</strong></label>
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}" required autocomplete="off" autofocus
                                                tabindex="1">

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
                                                value="{{ old('email') }}" required autocomplete="off" tabindex="2">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for='user_type'>User Type<strong
                                                    class="text-danger">*</strong></label>
                                            <select name="user_type" id="user_type" class="form-control" tabindex="3">
                                                <option value="Admin">Admin</option>
                                                <option value="User">User</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for='password'>Password<strong class="text-danger">*</strong></label>
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                value="{{ old('password') }}" required autocomplete="off" tabindex="4">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for='password_confirmation'>Confirm Password<strong
                                                    class="text-danger">*</strong></label>
                                            <input id="password_confirmation" type="password"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                name="password_confirmation" value="{{ old('password_confirmation') }}"
                                                required autocomplete="off" tabindex="5">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group py-2">
                                            <button type="submit" id="submit" class="btn btn-primary"><i
                                                    class="fa fa-save" tabindex="6"></i>
                                                {{ __('Save') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card shadow-sm  mb-5 bg-white rounded">
                                <div class="card-header bg-primary bg-gradient">
                                    <h4 class="text-white"><i class="fa fa-list"></i> Users</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive p-1">
                                        <table class="table table-bordered table-striped table-hover data_table">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>User Type</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td>{{ $user->id }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->user_type }}</td>

                                                        <td>
                                                            <a href="{{ route('user.edit', $user) }}"
                                                                class="btn btn-info btn-sm" title="Edit!"><i
                                                                    class="fa fa-edit"></i></a>
                                                            <!-- <button class="btn btn-danger btn-sm btn-delete" data-id='{{ $user->id }}' title="Delete!"><i class="fa fa-trash"></i> -->

                                                            </button>
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
                        $('#delete-form').attr('action', "/user/" + id);
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
