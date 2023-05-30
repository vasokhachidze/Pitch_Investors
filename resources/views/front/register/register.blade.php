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
</style>
@endsection
@section('content')
    <section class="login-page">
        <div class="loging-detail">
            <div class="logo">
                <a href="{{route('front.home')}}"><img src="{{asset('uploads/front/white-logo.png')}}" alt=""></a>
            </div>
            <div class="text-p">
                <p>Registration</p>
            </div>
            <form id="frm" action="{{url('register_action')}}" method="Post">
                @csrf
                <div class="form-control">
                    <input type="text" name="vEmail" id="vEmail" placeholder="Email" required>
                    <div id="vEmail_error" class="error_show">Please Enter Email</div>
                    <div id="vEmail_valid_error" class="error_show">Please Enter Valid Email</div>
                </div>
    
                <div class="form-control">
                    <input type="password" id="vPassword" name="vPassword" placeholder="Password" required>
                    <div id="vPassword_error" class="error_show">Please Enter Password </div>
                    <div id="vPassword_minLength_error" class="error mt-1" style="color:red;display: none;">Please enter
                        minimum 6 digit Password.</div>
                </div>

                <div class="form-control">
                    <input type="password" id="vPassword_repeat" name="vPassword_repeat" placeholder="Repeat Password" required>
                    <div id="vPassword_repeat_error" class="error_show">Please Enter Repeat Password </div>
                    <div id="vPassword_repeat_diff_error" class="error_show">The password and Repeat password does not match. </div>
                </div>
                
                <div class="forget">
                    <input type="checkbox" id="terms_checkbox">
                    <a for="terms_checkbox" href="javascript:;">By joining I agree to receive emails from PitchInvestors</a>
                    <div id="checkbox_error" class="text-danger" style="display:none;">Please agree to the terms and conditions</div>
                </div>
                
                <div class="verify-button" id="submit">
                    <a href="javascript:;" class="submit">Verify Email</a>
                </div>
                
                <div class="forget">
                    <a href="{{ url('login') }}">Already have an Account?</a>
                </div>
            </form>
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