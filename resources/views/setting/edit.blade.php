@extends('layouts.admin')
@section("title","Edit Setting")

@section('body')
<style>

</style>
<main class="p-3">
    <div class="container-flued">
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm  mb-5 bg-white rounded">
                    <div class="card-header bg-primary bg-gradient">
                        <h4 class="text-white"><i class="fa fa-plus"></i> تغیرول</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('setting.update',$setting)}}" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for='title_en'>Title English<strong class="text-danger">*</strong></label>
                                <input id="title_en" type="text" class="form-control @error('title_en') is-invalid @enderror" name="title_en" value="{{ $setting->title_en }}" required autofocus autocomplete="off" tabindex="1">

                                @error('title_en')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for='title_pa'>په پښتو عنوان<strong class="text-danger">*</strong></label>
                                <input id="title_pa" type="text" class="form-control @error('title_pa') is-invalid @enderror" name="title_pa" value="{{ $setting->title_pa }}" required autocomplete="off" tabindex="2">

                                @error('title_pa')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for='phone1'>د موبايل شميره<strong class="text-danger">*</strong></label>
                                <input id="phone1" type="text" class="form-control @error('phone1') is-invalid @enderror" name="phone1" value="{{ $setting->phone1 }}" required autocomplete="off" tabindex="3">

                                @error('phone1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for='phone2'>دوهمه شميره</label>
                                <input id="phone2" type="text" class="form-control @error('phone2') is-invalid @enderror" name="phone2" value="{{ $setting->phone2 }}" autocomplete="off" tabindex="4">

                                @error('phone2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for='address'>ادرس</label>
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $setting->address }}" required autocomplete="off" tabindex="5">

                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                {{-- <label for='bill_text'></label> --}}
                                <input id="bill_text" type="hidden" class="form-control @error('bill_text') is-invalid @enderror" name="bill_text" value=".">

                                {{-- @error('bill_text')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror --}}
                            </div>
                            <div class="form-group">
                                <label for='image_path'>Logo<strong class="text-danger">*</strong></label>
                                <input id="image_path" type="file" class="form-control @error('image_path') is-invalid @enderror" name="image_path" tabindex="5">
                                <img src="{{$setting->imagePath()}}" style="height: 60px;">
                            </div>


                            <div class="form-group my-2">
                                <button type="submit" id="submit" class="btn btn-primary" tabindex="3"><i class="fa fa-save"></i>
                                    {{ __('ثبتول') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection


@section("pageJs")


<script>
    $(document).ready(function() {
        $(".nav-link").removeClass('active');
        $("#nav_add").addClass("active");

     

        $("#title_en").keypress(function(e) {
            if (e.which == '10' || e.which == '13') {
                e.preventDefault();
                $("#title_pa").focus();
            }
        });
        $("#title_pa").keypress(function(e) {
            if (e.which == '10' || e.which == '13') {
                e.preventDefault();
                $("#phone1").focus();
            }
        });
        $("#phone1").keypress(function(e) {
            if (e.which == '10' || e.which == '13') {
                e.preventDefault();
                $("#phone2").focus();
            }
        });
        $("#phone2").keypress(function(e) {
            if (e.which == '10' || e.which == '13') {
                e.preventDefault();
                $("#image_path").focus();
            }
        });
        $("#image_path").keypress(function(e) {
            if (e.which == '10' || e.which == '13') {
                e.preventDefault();
                $("#submit").focus();
            }
        });

    });
</script>

@endsection