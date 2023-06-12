@extends('layouts.app.front-app')
@section('title', 'Reset Password - ' . env('APP_NAME'))
@php
$general_favicon = \App\Helper\GeneralHelper::setting_info('Company');
$logo = $general_favicon['COMPANY_LOGO']['vValue'];
$favicon = $general_favicon['COMPANY_FAVICON']['vValue'];
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
                        <a href="{{ route('front.home') }}"><img src="{{ asset('/front/assets/images/lginLogo.svg') }}" class=""></a>
                    </div>

                    <div class="text-p">
                        <p class="text-start mb-0" style="color: #2B7292; padding:0 12px; font-size:20px;">Reset Password</p>
                    </div>

                    <form id="frm" action="{{ url('reset-password') }}" method="Post">
                        @csrf
                        <input type="hidden" name="auth" id="auth" value="{{$code}}">
                        <div class="form-control mb-0">
                            <label for="vEmail" style="color: #313538; font-weight:500; font-size:14px;" class="py-2">New Password</label>
                            <input style="border: 1px solid #D1D7DC; color: #313538; font-size:14px;" class="p-2" type="password" class="form-control" id="vPassword" name="vPassword" minlength="6">
                            <div id="vPassword_error" class="error mt-1" style="color:red;display: none;">Please Enter New Password</div>
                            <div id="vPassword_minLength_error" class="error mt-1" style="color:red;display: none;">Please enter minimum 6 digit Password.</div>
                        </div>

                        <div class="form-control mt-0">
                            <label for="vEmail" style="color: #313538; font-weight:500; font-size:14px;" class="py-2">Confirm Password</label>
                            <input style="border: 1px solid #D1D7DC; color: #313538; font-size:14px;" class="p-2" type="password" class="form-control" id="vConfirmPassword" name="vConfirmPassword" minlength="6">
                            <div id="vConfirmPassword_error" class="error mt-1" style="color:red;display: none;">Please Enter Confirm Password</div>
                            <div id="vConfirmPassword_match_error" class="error mt-1" style="color:red;display: none;">Password and Confirm Password does not match.</div>
                            <div id="vConfirmPassword_minLength_error" class="error mt-1" style="color:red;display: none;">Please enter minimum 6 digit Password.</div>
                        </div>

                        <div class="verify-button mt-3" id="submit">
                            <a href="javascript:;" class="submit" style="font-size:14px;">Save</a>
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
            if (error_msg) {
                Toast.fire({
                    icon: 'error',
                    title: error_msg
                })
            }
            if (success_msg) {
                Toast.fire({
                    icon: 'success',
                    title: success_msg
                })
            }
        });
    </script>
    <script type="text/javascript">
        $(document).on('click', '#submit', function() {
            var vPassword = $("#vPassword").val();
            var vConfirmPassword = $("#vConfirmPassword").val();
            var error = false;
            if (vPassword.length == 0) {
                $("#vPassword_error").show();
                error = true;
            } else {
                if (vPassword.length < 6) {
                    $("#vPassword_minLength_error").show();
                    error = true;
                } else {
                    $("#vPassword_minLength_error").hide();
                }
                $("#vPassword_error").hide();
            }

            if (vConfirmPassword.length == 0) {
                $("#vConfirmPassword_error").show();
                error = true;
            } else {
                $("#vConfirmPassword_error").hide();
                if (vPassword == vConfirmPassword) {
                    $("#vConfirmPassword_match_error").hide();
                } else {
                    $("#vConfirmPassword_match_error").show();
                    error = true;
                }
                if (vConfirmPassword.length < 6) {
                    $("#vConfirmPassword_minLength_error").show();
                    error = true;
                } else {
                    $("#vConfirmPassword_minLength_error").hide();
                }

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
    </script>
@endsection
