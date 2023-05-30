@php 
$general_favicon = \App\Helper\GeneralHelper::setting_info('Company');
$favicon         = $general_favicon['COMPANY_FAVICON']['vValue'];
$logo            = $general_favicon['COMPANY_LOGO']['vValue'];
$footer_logo     = $general_favicon['COMPANY_FOOTER_LOGO']['vValue'];
$general_info    = \App\Helper\GeneralHelper::setting_info('Appearance');
$url   = Request::segment(1);
$url1  = Request::segment(0);
$user_session = !empty(Session::has('user.iUserId')) ? session('user') : '';
$no_header_footer_url = ['login','register','forgotpassword','sign_up_thank_you'];


@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('uploads/logo/'.$favicon)}}">
    <title>@yield('title')</title>
    @include('layouts.front.css')
    @yield('custom-css')
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JWVRW3MK7F"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-JWVRW3MK7F');
    </script>
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
<body>
    <script src="{{asset('admin/assets/js/jquery.min.js')}}"></script>
    <div>
        @if(!empty(Session::get('error')))
            <input type="hidden" id="error_msg" value="{{Session::get('error')}}">
        @endif
        @if(!empty(Session::get('success')))
            <input type="hidden" id="success_msg" value="{{Session::get('success')}}">
        @endif
        @if (!in_array($url, $no_header_footer_url)) 
            @include('layouts.front.header')        
        @endif
        @yield('content')

        @if (!in_array($url, $no_header_footer_url)) 
            @include('layouts.front.footer')
        @endif
    </div>
    @include('layouts.front.js')
    @include('layouts.front.toast')
    @yield('custom-js')
    <script>
        $(document).on('click','.search',function(){
            // search code
        });
    </script>
</body>
</html>
