@extends('layouts.app.front-app')
@section('title', 'Forgot Password - '.env('APP_NAME'))
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
                <p>Forgot Password</p>
            </div>
            <form id="frm" action="{{url('forgotpassword_action')}}" method="Post">
                @csrf
                <div class="form-control">
                    <input type="text" name="vEmail" id="vEmail" placeholder="Enter Email" required>
                    <div id="vEmail_error" class="error_show">Please Enter Email</div>
                    <div id="vEmail_valid_error" class="error_show">Please Enter Valid Email</div>
                </div>
                <div class="verify-button" id="submit">
                    <a href="javascript:;" class="submit">Get Reset Link in Email</a>
                </div>
                <div class="forget">
                    <a href="{{ route('front.login.index') }}">Login</a>
                </div>
            </form>
        </div>
    </section>
@endsection
@section('custom-js')

    <script>
      $(document).ready(function() 
      {
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
    $(document).on('click','#submit',function()
    {
        vEmail = $("#vEmail").val();
        var error = false;
        if (vEmail.length == 0) 
        {
            $("#vEmail_error").show();
            $("#vEmail_valid_error").hide();
            error = true;
        } 
        else 
        {
            if (validateEmail(vEmail)) 
            {
                $("#vEmail_valid_error").hide();
                $("#vEmail_error").hide();
            } 
            else 
            {
                $("#vEmail_valid_error").show();
                $("#vEmail_error").hide();
                error = true;
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
    //Function for validate Email
    function validateEmail(sEmail) 
    {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(sEmail)) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }
</script>
@endsection