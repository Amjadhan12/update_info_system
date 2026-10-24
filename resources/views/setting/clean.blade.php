@extends('layouts.admin')
@section("title","Clean Database")

@section('body')
<style>

</style>
<main class="p-3">
    <div class="container-flued">
        <div class="row">
            @if(Auth::user()->user_type=='Admin')
            <div class="col-md-12">
                <div class="card shadow-sm  mb-5 bg-white rounded">
                    <div class="card-header bg-primary bg-gradient">
                        <h4 class="text-white"><i class="fa fa-plus"></i> Clean Database</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{url('/cleanRun')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- <div class="form-check mx-2">
                                        <input class="form-check-input" type="checkbox" value="1" id="checkAll" name="checkAll" />
                                        <label class="form-check-label" for="checkAll">
                                            Check All
                                        </label>
                                    </div>
                                    <hr> -->
                                </div>
                                <div class="col-md-6">
                                    <h4>Clean</h4>
                                    <hr>
                                    <div class="form-group py-2">
                                        <div class="form-check mx-2">
                                            <input class="form-check-input" type="checkbox" value="1" id="purchase" name="purchase" />
                                            <label class="form-check-label" for="purchase">
                                                Purchase
                                            </label>
                                        </div>
                                        <div class="form-check mx-2">
                                            <input class="form-check-input" type="checkbox" value="1" id="sale" name="sale" />
                                            <label class="form-check-label" for="sale">
                                                Sale
                                            </label>
                                        </div>
                                        <div class="form-check mx-2">
                                            <input class="form-check-input" type="checkbox" value="1" id="expense" name="expense" />
                                            <label class="form-check-label" for="expense">
                                                Expenses
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 border-start">
                                    <h4>Reserve</h4>
                                    <hr>
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="checkbox" value="1" id="supplierAccount" name="supplierAccount" checked />
                                        <label class="form-check-label" for="supplierAccount">
                                            Supplier Account
                                        </label>
                                    </div>
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="checkbox" value="1" id="customerAccount" name="customerAccount" checked />
                                        <label class="form-check-label" for="customerAccount">
                                            Customer Account
                                        </label>
                                    </div>
                                    <div class="form-check mx-2">
                                        <input class="form-check-input" type="checkbox" value="1" id="currentStock" name="currentStock" checked />
                                        <label class="form-check-label" for="currentStock">
                                            Current Stock
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-check mx-2">
                                <input class="form-check-input" type="checkbox" value="1" id="resetAll" name="resetAll" />
                                <label class="form-check-label" for="resetAll">
                                    Factory Reset
                                </label>
                            </div><hr>
                            <button type="submit" class="btn btn-primary my-2">Clean</button>
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


@section("pageJs")

<script>
    $(document).ready(function() {
        $(".nav-link").removeClass('active');
        $("#nav_settings").addClass("active");


        // $("#checkAll").click(function() {
        //     if ($(this).is(':checked') == false) {
        //         $("input[type='checkbox']").prop('checked', false);
        //     } else {
        //         $("input[type='checkbox']").prop('checked', true);
        //     }
        // })
        $("#resetAll").click(function() {
            if ($(this).is(':checked') == false) {
                $("input[type='checkbox']").removeAttr('disabled');
            } else {
                $("input[type='checkbox']").attr('disabled', "disabled");
                $(this).removeAttr('disabled');
            }
        })




    });

    window.onbeforeunload = function(e) {
        return "Please click 'Stay on this Page' if you did this unintentionally";
    };
</script>

@endsection