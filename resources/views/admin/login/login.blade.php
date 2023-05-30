@extends('layouts.admin.login_index')
@section('title', 'Login - '.env('APP_NAME'))
@section('content')
@php
   $setting_info = \App\Helper\GeneralHelper::setting_info('Company');
@endphp

<div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="{{url('/')}}" class="h1"><b><img src="{{asset('uploads/logo/logo.png')}}" alt="no Image" class="brand-image" style="width: 100%; height:auto;"></b></a>
    </div>
    <div class="card-body">
        <form action="{{url('admin/login/login_action')}}" method="post">
          @csrf
            <div class="input-group mb-3">
              <input type="email" name="email" class="form-control" placeholder="Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" name="password" class="form-control" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block submit">Sign In</a>
              </div>
            </div>
        </form>
      </div>
</div>
@endsection
@section('custom-css')
@endsection
@section('custom-js')

@endsection