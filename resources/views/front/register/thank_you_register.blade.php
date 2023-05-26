@extends('layouts.app.front-app')
@section('title', 'Thank you for Registeration - '.env('APP_NAME'))
@php
$general_favicon = \App\Helper\GeneralHelper::setting_info('Company');
$logo            = $general_favicon['COMPANY_LOGO']['vValue'];
$favicon         = $general_favicon['COMPANY_FAVICON']['vValue'];
@endphp
@section('custom-css')
@endsection
@section('content')
    <section class="login-page">
        <div class="loging-detail">
            <div class="logo">
                <a href="{{route('front.home')}}"><img src="{{asset('uploads/front/white-logo.png')}}" alt=""></a>
            </div>
            <div class="text-p">
                <p>Thank you for Registration!</p>
                <h6><p>Please check your Mail and Activate your account.</p></h6>
            </div>
        </div>
    </section>
 @endsection
 @section('custom-js')
 @endsection