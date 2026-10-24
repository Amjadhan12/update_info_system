@extends('layouts.admin')
@section('title', 'Backup and Restore')

@if (Auth::user()->language == 'Pashto')
    @section('body')
        <style>
            /* Add any custom styles here */
        </style>
        <main class="p-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card shadow-sm mb-3 bg-white rounded">
                            <div class="card-header bg-primary">
                                <h4 class="text-white"><i class="fa fa-plus"></i> د بیک اپ جوړول</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('backup') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">بیک اپ جوړول</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card shadow-sm mb-3 bg-white rounded">
                            <div class="card-header bg-primary">
                                <h4 class="text-white"><i class="fa fa-upload"></i> بیک اپ بحالول</h4>
                            </div>
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @elseif(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <form action="{{ route('backup.restore') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label for="database">د ډیټابیس انتخاب</label>
                                        <select name="database" id="database" class="form-control">
                                            @foreach($databases as $database)
                                                <option value="{{ $database }}">{{ $database }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="backup_file">د بیک اپ فایل پورته کول</label>
                                        <input type="file" name="backup_file" id="backup_file" class="form-control" required>
                                    </div>

                                    <button type="submit" class="btn btn-success">بیک اپ بحالول</button>
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
            /* Add any custom styles here */
        </style>
        <main class="p-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card shadow-sm mb-3 bg-white rounded">
                            <div class="card-header bg-primary">
                                <h4 class="text-white"><i class="fa fa-plus"></i> Create Backup</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('backup') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Create Backup</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card shadow-sm mb-3 bg-white rounded">
                            <div class="card-header bg-primary">
                                <h4 class="text-white"><i class="fa fa-upload"></i> Restore Backup</h4>
                            </div>
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @elseif(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <form action="{{ route('backup.restore') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label for="database">Select Database</label>
                                        <select name="database" id="database" class="form-control">
                                            @foreach($databases as $database)
                                                <option value="{{ $database }}">{{ $database }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="backup_file">Upload Backup File</label>
                                        <input type="file" name="backup_file" id="backup_file" class="form-control" required>
                                    </div>

                                    <button type="submit" class="btn btn-success">Restore Backup</button>
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
            $("#nav_backup").addClass("active");
        });
    </script>
@endsection
