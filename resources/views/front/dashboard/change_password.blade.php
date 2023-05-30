@extends('layouts.app.front-app')
@section('title', 'Change Password '.env('APP_NAME'))
@section('custom-css')
<style>
    .changePasswordButtonDiv {
        margin-top: 2%;
    }
</style>
@endsection
@section('content')
@php
    // dd($session_data);
@endphp
<section class="my-dashbord">
    <div class="container">
        <div class="row">
            @include('layouts.front.left_dashboard')
            <div class="col-lg-9">
                <div class="right-panal-side">
                    @include('layouts.front.header_dashboard')
                    <div class="row mt-3 padding-no">
                        <div class="letest-activity">
                            <form action="{{url('change_password_store')}}" method="Post" id="frm-changePassword" class="">
                               @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Change Password</h4>
                                    </div>
                                    <div class="col-md-6 margin-bottom-five">
                                        <div class="form-input">
                                        <label for="vPassword">Enter New Password</label>
                                            <input type="password" class="form-control" id="vPassword" name="vPassword" minlength="6" placeholder="Enter New Password">
                                        </div>
                                        <div id="vPassword_error" class="error mt-1" style="color:red;display: none;">Please Enter New Password</div>
                                        <div id="vPassword_minLength_error" class="error mt-1" style="color:red;display: none;">Please enter minimum 6 digit Password.</div>
                                    </div>
                                    <div class="col-md-6 margin-bottom-five">
                                        <div class="form-input">
                                        <label for="vConfirmPassword">Enter Confirm Password</label>
                                            <input type="password" class="form-control" placeholder="Enter Confirm Password" id="vConfirmPassword" name="vConfirmPassword" minlength="6">
                                        </div>
                                        <div id="vConfirmPassword_error" class="error mt-1" style="color:red;display: none;">Please Enter Confirm Password</div>
                                        <div id="vConfirmPassword_match_error" class="error mt-1" style="color:red;display: none;">Password and Confirm Password does not match.</div>
                                        <div id="vConfirmPassword_minLength_error" class="error mt-1" style="color:red;display: none;">Please enter minimum 6 digit Password.</div>
                                    </div>
                                    <div class="col-md-12 changePasswordButtonDiv">
                                        <a href="javascript:;" id="changePasswordSubmit" class="btn btn-primary bg-green">Submit</a>
                                        <a href="{{url('dashboard')}}" class="btn btn-danger">Cancle</a>
                                    </div>
                                    <div class="col-md-4 offset-md-4">
                                        <a href="javascript:;" class="btn loading" style="display: none;"> 
                                            <h4 style="color: gray"><span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...</h4>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('custom-js')
<script>
    $(document).on('click','#changePasswordSubmit',function()
    {
        var vPassword    = $("#vPassword").val();
        var vConfirmPassword = $("#vConfirmPassword").val();
        var error     = false;
        if(vPassword.length == 0)
        {
            $("#vPassword_error").show();
            error = true;
        } 
        else
        {
            if(vPassword.length < 6)
            {
                $("#vPassword_minLength_error").show();
                error = true;
            }
            else
            {
                $("#vPassword_minLength_error").hide();
            }
            $("#vPassword_error").hide();
        }

        if(vConfirmPassword.length == 0){
            $("#vConfirmPassword_error").show();
            error = true;
        } 
        else
        {
            $("#vConfirmPassword_error").hide();
            if (vPassword == vConfirmPassword)
            {
                $("#vConfirmPassword_match_error").hide();
            }
            else
            {
                $("#vConfirmPassword_match_error").show();
                error = true;
            }
            if(vConfirmPassword.length < 6)
            {
                $("#vConfirmPassword_minLength_error").show();
                error = true;
            }
            else
            {
                $("#vConfirmPassword_minLength_error").hide();
            }

        }
        setTimeout(function(){
        if(error == true)
        {
            return false;
        }
        else
        {
            $("#frm-changePassword").submit();
            $('.changePasswordButtonDiv').hide();
            $('.loading').show();
            return true;
        }
        }, 1000);
    });
</script>
@endsection
