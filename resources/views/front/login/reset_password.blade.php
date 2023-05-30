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
    </style>
@endsection
@section('content')
    <section class="login-page">
        <div class="loging-detail">
            <div class="logo">
                <a href="{{ route('front.home') }}"><img src="{{ asset('uploads/front/white-logo.png') }}" alt=""></a>
            </div>
            <div class="text-p">
                <p>Reset Password</p>
            </div>
            <form id="frm" action="{{ url('reset-password') }}" method="Post">
                @csrf
				<input type="hidden" name="auth" id="auth" value="{{$code}}">
                <div class="form-control">
                    <input type="password" class="form-control" id="vPassword" name="vPassword" minlength="6"
                        placeholder="Enter New Password">
                    <div id="vPassword_error" class="error mt-1" style="color:red;display: none;">Please Enter New Password
                    </div>
                    <div id="vPassword_minLength_error" class="error mt-1" style="color:red;display: none;">Please enter
                        minimum 6 digit Password.</div>
                </div>
                <div class="form-control">
                    <input type="password" class="form-control" id="vConfirmPassword" name="vConfirmPassword" minlength="6"
                        placeholder="Enter Confirm Password">
                    <div id="vConfirmPassword_error" class="error mt-1" style="color:red;display: none;">Please Enter
                        Confirm Password</div>
                    <div id="vConfirmPassword_match_error" class="error mt-1" style="color:red;display: none;">Password and
                        Confirm Password does not match.</div>
                    <div id="vConfirmPassword_minLength_error" class="error mt-1" style="color:red;display: none;">Please
                        enter minimum 6 digit Password.</div>
                </div>
                <div class="verify-button" id="submit">
                    <a href="javascript:;" class="submit">Save</a>
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
