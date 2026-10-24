@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Create Backup</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('backup.create.submit') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Create Backup</button>
        </form>
    </div>
@endsection
