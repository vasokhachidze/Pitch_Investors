<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <link href="{{asset('admin/assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
  <link href="{{asset('admin/assets/css/icheck-bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('admin/assets/css/adminlte.min.css')}}" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  @include('layouts.admin.css')
  <!-- Styles -->
    @yield('custom-css')
    <meta name="facebook-domain-verification" content="wre2525cxtikqjswcy7suyze1ahqil" />
    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '917637702837002');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=917637702837002&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  @yield('content')
</div>

<!-- /.login-box -->

<!-- jQuery -->
@include('layouts.admin.js')
@include('layouts.admin.toast')
@yield('custom-js')
</body>
</html>
