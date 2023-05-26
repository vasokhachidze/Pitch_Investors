@php 
$general_favicon = \App\Helper\GeneralHelper::setting_info('Company');
$favicon         = $general_favicon['COMPANY_FAVICON']['vValue'];
$general_info    = \App\Helper\GeneralHelper::setting_info('Appearance');
$url   = Request::segment(0);
$url1  = Request::segment(1);
$url2   = Request::segment(2);

@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('uploads/logo/'.$favicon)}}">
    <title>{{$general_info['CPANEL_TITLE']['vValue']}}</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    @include('layouts.admin.css')
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
<body class="hold-transition sidebar-mini">
    <script src="{{asset('admin/assets/js/jquery.min.js')}}"></script>
    <div class="wrapper">
        <!-- Header -->
        @include('layouts.admin.header')

        <!-- Sidebar -->
        @include('layouts.admin.left')

        <div class="content-wrapper">
            <!-- Content -->
            @yield('content')
        </div>

        <!-- Footer -->
        @include('layouts.admin.footer')
    </div>

    <!-- Scripts -->
    @include('layouts.admin.js')
    @include('layouts.admin.toast')
    @yield('custom-js')
    <!-- <script>
        ClassicEditor
            .create( document.querySelector( '#tDescription' ) )
            .catch( error => {
                console.error( error );
            } );
    </script> -->
</body>
</html>
