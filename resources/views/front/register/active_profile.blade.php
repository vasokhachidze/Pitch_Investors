@extends('layouts.app.front-app')
@section('title', 'Thank you for Registering - '.env('APP_NAME'))
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
                <img src="{{asset('uploads/front/white-logo.png')}}" alt="">
            </div>
            <div class="text-p">
                <p>Thank you...</p>
                <h6><p>Your account is now activated. Please Login...</p></h6>
                <div class="verify-button">
                  <a class="submit" href="{{ url('login') }}">Login</a>
              </div>
            </div>
        </div>
    </section>
 @endsection
 @section('custom-js')
 @endsection