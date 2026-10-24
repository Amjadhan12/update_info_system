@extends('layouts.admin')
@section('title', 'Setting')

@section('body')
    <style>

    </style>
    <main class="p-3">
        <div class="container-flued">
            <div class="row">

                <div class="col-md-4">
                    <div class="card shadow-sm  mb-5 bg-white rounded">
                        <div class="card-header bg-primary bg-gradient">
                            <h4 class="text-white"><i class="fa fa-plus"></i> جوړښت</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('setting.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3 pb-1 ">
                                    <div class="form-outline">
                                        <input id="title_en" type="text"
                                            class="form-control @error('title_en') is-invalid @enderror" name="title_en"
                                            value="{{ old('title_en') }}" required autofocus autocomplete="off"
                                            tabindex="1">
                                        <label class="form-label" for='title_en'>Title English<strong
                                                class="text-danger">*</strong></label>
                                        @error('title_en')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 pb-1 ">
                                    <div class="form-outline">

                                        <input id="title_pa" type="text"
                                            class="form-control @error('title_pa') is-invalid @enderror" name="title_pa"
                                            value="{{ old('title_pa') }}" required autocomplete="off" tabindex="2">
                                        <label class="form-label" for='title_pa'>په پښتو عنوان<strong
                                                class="text-danger">*</strong></label>
                                        @error('title_pa')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 pb-1 ">
                                    <div class="form-outline">

                                        <input id="phone1" type="text"
                                            class="form-control @error('phone1') is-invalid @enderror" name="phone1"
                                            value="{{ old('phone1') }}" required autocomplete="off" tabindex="3">
                                        <label class="form-label" for='phone1'>د موبايل شميره<strong
                                                class="text-danger">*</strong></label>
                                        @error('phone1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 pb-1 ">
                                    <div class="form-outline">

                                        <input id="phone2" type="text"
                                            class="form-control @error('phone2') is-invalid @enderror" name="phone2"
                                            value="{{ old('phone2') }}" autocomplete="off" tabindex="4">
                                        <label class="form-label" for='phone2'>دوهمه شميره</label>
                                        @error('phone2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 pb-1 ">
                                    <div class="form-outline">

                                        <input id="address" type="text"
                                            class="form-control @error('address') is-invalid @enderror" name="address"
                                            value="{{ old('address') }}" required autocomplete="off" tabindex="5">
                                        <label class="form-label" for='address'>ادرس</label>
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 pb-1">
                                    <div class="form-outline">

                                        <input id="bill_text" type="hidden"
                                            class="form-control @error('bill_text') is-invalid @enderror" name="bill_text"
                                            value=".">
                                        {{-- <label class="form-label" for='bill_text'>‌Bill Text</label>
                                    @error('bill_text')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror --}}
                                    </div>
                                </div>
                                <div class="mb-3 pb-1 ">
                                    <div class="form-outline">
                                        <input id="image_path" type="file"
                                            class="form-control @error('image_path') is-invalid @enderror" name="image_path"
                                            value="{{ old('image_path') }}" tabindex="6">
                                        <label class="form-label" for='image_path'>Logo<strong
                                                class="text-danger">*</strong></label>
                                        @error('image_path')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="form-group my-2">
                                    <button type="submit" id="submit" class="btn btn-primary" tabindex="7"><i
                                            class="fa fa-save"></i>
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
                            <h4 class="text-white"><i class="fa fa-list"></i> جوړښت</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-bordered table-striped table-hover data_table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>شماره</th>
                                            <th>Title English</th>
                                            <th>په پښتو عنوان</th>
                                            <th>موبايل شميره</th>
                                            <th>دوهمه شميره</th>
                                            <th>ادرس</th>
                                            {{-- <th>‌Bill Text</th> --}}
                                            <th>Logo</th>
                                            <th>عملیه</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($settings as $setting)
                                            <tr>
                                                <td>{{ $setting->id }}</td>
                                                <td>{{ $setting->title_en }}</td>
                                                <td>{{ $setting->title_pa }}</td>
                                                <td>{{ $setting->phone1 }}</td>
                                                <td>{{ $setting->phone2 }}</td>
                                                <td>{{ $setting->address }}</td>
                                                {{-- <td>{{$setting->bill_text}}</td> --}}
                                                <td>
                                                    @if ($setting->image_path)
                                                        <img src="{{ $setting->imagePath() }}" style="height: 60px;">
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('setting.edit', $setting) }}"
                                                        class="btn btn-info btn-sm" title="Edit!"><i
                                                            class="fa fa-edit"></i></a>
                                                    <button class="btn btn-danger btn-sm btn-delete"
                                                        data-id='{{ $setting->id }}' title="Delete!"><i
                                                            class="fa fa-trash"></i>

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
            </div>
        </div>
    </main>

@endsection


@section('pageJs')

    <script>
        $(document).ready(function() {
            $(".nav-link").removeClass('active');
            $("#nav_add").addClass("active");

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
                        $('#delete-form').attr('action', "/setting/" + id);
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
