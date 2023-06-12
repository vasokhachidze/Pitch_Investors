@extends('layouts.app.front-app')
@section('title', 'Registeration - '.env('APP_NAME'))
@php
$general_favicon = \App\Helper\GeneralHelper::setting_info('Company');
$logo            = $general_favicon['COMPANY_LOGO']['vValue'];
$favicon         = $general_favicon['COMPANY_FAVICON']['vValue'];
@endphp
@section('custom-css')
<style>
    input:-webkit-autofill {
        -webkit-text-fill-color: white !important;
    }

    .login-page{
        background:none !important;
    }

    input:-webkit-autofill {
        -webkit-text-fill-color: #313538 !important;
        }
</style>
@endsection
@section('content')
    <section class="login-page">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="d-flex justify-content-center">
                <div class="loging-detail position-relative top-0 start-0" style="transform: translate(0, 0); background:#fff; border-bottom: 2px solid #2B7292; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
                    <div class="logo">
                        <a href="{{route('front.home')}}"><img src="{{ asset('/front/assets/images/lginLogo.svg') }}" class=""></a>
                    </div>
                    <div class="text-p">
                        <p class="text-start mb-0 mt-4" style="color: #2B7292; padding:0 12px; font-size:20px;">Registration</p>
                    </div>
                    <form id="frm" action="{{url('register_action')}}" method="Post">
                        @csrf
                        <div class="form-control m-0">
                            <label for="vEmail" style="color: #313538; font-weight:500; font-size:14px;" class="py-2">Email</label>
                            <input class="p-2" style="border: 1px solid #D1D7DC; color: #313538; font-size:14px;" type="text" name="vEmail" id="vEmail" required>
                            <div id="vEmail_error" class="error_show" style="font-size:14px;">Please Enter Email</div>
                            <div id="vEmail_valid_error" class="error_show" style="font-size:14px;">Please Enter Valid Email</div>
                        </div>
            
                        <div class="form-control m-0">
                            <label for="vPassword" style="color: #313538; font-weight:500; font-size:14px;" class="py-2">Password</label>
                            <input class="p-2" style="border: 1px solid #D1D7DC; color: #313538; font-size:14px;" type="password" id="vPassword" name="vPassword" required>
                            <div id="vPassword_error" class="error_show" style="font-size:14px;">Please Enter Password </div>
                            <div id="vPassword_minLength_error" class="error mt-1" style="color:red;display: none; font-size:14px;">Please enter
                                minimum 6 digit Password.</div>
                        </div>

                        <div class="form-control m-0">
                            <label for="vPassword_repeat" style="color: #313538; font-weight:500; font-size:14px;" class="py-2">Confirm Password</label>
                            <input class="p-2" style="border: 1px solid #D1D7DC; color: #313538; font-size:14px;" type="password" id="vPassword_repeat" name="vPassword_repeat" required>
                            <div id="vPassword_repeat_error" class="error_show" style="font-size:14px;">Please Enter Repeat Password </div>
                            <div id="vPassword_repeat_diff_error" class="error_show" style="font-size:14px;">The password and Repeat password does not match. </div>
                        </div>
                        
                        <div class="forget mt-2 d-flex justify-content-start" style="padding-left:12px; padding-bottom:12px;">
                            <input class="p-2" style="border: 1px solid #D1D7DC; color: #313538 font-size:14px;;" type="checkbox" id="terms_checkbox">
                            <a for="terms_checkbox" href="javascript:;" style="font-size:12px; padding-left:10px; color: #313538;">By joining I agree to receive emails from PitchInvestors</a>
                            <div id="checkbox_error" class="text-danger" style="display:none; font-size:14px;">Please agree to the terms and conditions</div>
                        </div>
                        
                        <div class="verify-button" id="submit">
                            <a href="javascript:;" class="submit" style="font-size:14px;">Register</a>
                        </div>
                        
                        <div class="forget mt-3">
                            <a href="{{ url('login') }}" style="color: #313538; font-size:14px; font-weight: 500;">Already have an Account?</a>
                            <span style="color: #69B965; font-size:14px; text-decoration:underline font-weight: 500;">Login Here</span>
                        </div>

                        <div class="text-center pt-3">
                            <span style="font-size:14px; text-decoration:underline; font-weight: 500;">
                                Forgot Password?
                            </span>
                        </div>
                    </form>
                </div>

                <div class="d-xl-block d-none">
                    <img src="{{ asset('/front/assets/images/login_image.png') }}" class="" style="pointer-events:none; top:30px;">
                </div>
            </div>
        </div>
    </section>
 @endsection
 @section('custom-js')
    <script>
      $(document).ready(function() {
      var error_msg = $('#error_msg').val();
      var success_msg = $('#success_msg').val();
      var Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
      });
      if(error_msg)
      {
         Toast.fire({
         icon: 'error',
         title: error_msg
         })
      }
      if(success_msg)
      { 
         Toast.fire({
         icon: 'success',
         title: success_msg
         })
      }
   });
    </script>
   <script type="text/javascript">
     $(document).on('click', '#submit', function() {
        vEmail = $("#vEmail").val();
        vPassword = $("#vPassword").val();
        vPassword_repeat = $("#vPassword_repeat").val();
        var error = false;

        <?php if (!isset($data->iUserId)) { ?>
        if (vEmail.length == 0) {
            $("#vEmail_error").show();
            $("#vEmail_valid_error").hide();
            error = true;
        } else {
            if (validateEmail(vEmail)) {
                $("#vEmail_valid_error").hide();
                $("#vEmail_error").hide();
            } else {
                $("#vEmail_valid_error").show();
                $("#vEmail_error").hide();
                error = true;
            }
        }
        <?php } ?>
        if (vPassword.length == 0) {
            $("#vPassword_error").show();
            error = true;
        } else {
            $("#vPassword_error").hide();
        }

        if (vPassword_repeat.length == 0) {
            $("#vPassword_repeat_error").show();
            error = true;
        } else {
            if(vPassword.length < 6) {
                $("#vPassword_minLength_error").show();
                error = true;
            }
            else {
                $("#vPassword_minLength_error").hide();
            }
            if (vPassword != vPassword_repeat) {
                $("#vPassword_repeat_diff_error").show();
                error = true;
            }
            else{
                $("#vPassword_repeat_diff_error").hide();
            }
            $("#vPassword_repeat_error").hide();
        }

        if($('#terms_checkbox').is(":checked")){

            $("#checkbox_error").hide();
        }else{
            $("#checkbox_error").show();
            error = true;
        }
        

        setTimeout(function() {
            if (error == true) {
                return false;
            } else {
                $("#frm").submit();
                return true;
            }
        }, 1000);
    }); 

    //Function for validate Email
    function validateEmail(sEmail) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(sEmail)) {
            return true;
        } else {
            return false;
        }
    }
    </script>
    <script>
        /* $(document).ready(function () {
            $(".owl-carousel").owlCarousel();
        }); */
    </script>
 @endsection