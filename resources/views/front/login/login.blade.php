@extends('layouts.app.front-app')
@section('title', 'Login - '.env('APP_NAME'))
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
                    <p class="text-start mb-0" style="color: #2B7292; padding:0 12px; font-size:20px;">Log In</p>
                </div>
                
                <form id="frm" action="{{url('login_action')}}" method="Post" >
                    @csrf
                    <div class="form-control my-0">
                        <label for="vEmail" style="color: #313538; font-weight:500; font-size:14px;" class="py-2">Email</label>
                        <input style="border: 1px solid #D1D7DC; color: #313538; font-size:14px;" class="p-2" type="text" name="vEmail" id="vEmail" required>
                        <div id="vEmail_error" class="error_show" style="font-size:14px;">Please Enter Email</div>
                        <div id="vEmail_valid_error" class="error_show" style="font-size:14px;">Please Enter Valid Email</div>
                    </div>

                    <div class="form-control mt-0">
                        <label for="vPassword" style="color: #313538; font-weight:500; font-size:14px;" class="py-2">Password</label>
                        <input style="border: 1px solid #D1D7DC; color: #313538; font-size:14px;" class="p-2" type="password" id="vPassword" name="vPassword" required>
                        <div id="vPassword_error" class="error_show" style="font-size:14px;">Please Enter Password </div>
                        <div id="vPassword_minLength_error" class="error mt-1" style="color:red;display: none; font-size:14px;">Please enter
                            minimum 6 digit Password.</div>
                    </div>

                    <div class="verify-button mt-3" id="submit">
                        <a href="javascript:;" class="submit" style="font-size:14px;">Login Now</a>
                        {{-- <button class="submit">Submit</button> --}}
                    </div>

                    <div class="signup">
                        <p style="color:#313538; font-size:14px; font-weight: 500;">or <span><a style="color:#313538; text-decoration:underline; font-size:14px; font-weight: 500;" href="{{ url('register') }}">Sign up</a></span></p>
                    </div>

                    <div class="forget mt-3">
                        <a style="color:#313538; text-decoration:underline; font-size:14px; font-weight: 500;" href="{{ url('forgotpassword') }}">Forget Password?</a>
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

    $(document).on("keypress", "#vEmail,#vPassword", function(e) {
            if (e.which == "13") {
                submit_form();
            }
        });
     $(document).on('click', '#submit', function() {
            submit_form();
     });
   function submit_form() 
   {
        vEmail = $("#vEmail").val();
        vPassword = $("#vPassword").val();
        
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
            $("#vPassword_minLength_error").hide();
            error = true;
        } else {
            if(vPassword.length < 6) {
                    $("#vPassword_minLength_error").show();
                    error = true;
                } else {
                    $("#vPassword_minLength_error").hide();
                }
            $("#vPassword_error").hide();
        }

        setTimeout(function() {
            if (error == true) {
                return false;
            } else {
                $("#frm").submit();
                return true;
            }
        }, 1000);
    }

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
     /* 
    $(document).ready(function () {
        $(".owl-carousel").owlCarousel();
    });
     */
</script>
@endsection