@php   
$setting_info = \App\Helper\GeneralHelper::setting_info('Company');
$social_info = \App\Helper\GeneralHelper::setting_info('Social');

$social_facebook = $social_info['SOCIAL_FACEBOOK']['vValue'];
$social_twitter = $social_info['SOCIAL_TWITTER']['vValue'];
$social_linkedin = $social_info['SOCIAL_LINKEDIN']['vValue'];
$social_insrtagram = $social_info['SOCIAL_INSTAGRAM']['vValue'];
$social_youtube = $social_info['SOCIAL_YOUTUBE']['vValue'];
// dd($social_info);
// $msg = '';
@endphp
<!DOCTYPE html>
<html>

<head>
  <title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
  <style type="text/css">
  </style>
</head>

<body style="background-color: #F5F5F5; margin: 0 !important; padding: 0 !important; font-family: 'Roboto', sans-serif;">
    <div style="background: #fff; margin: 100px auto; max-width: 800px;">
        <table style="width: 100%; border: 2px solid #2B7090;" border="0">
            <tbody>
                <tr>
                    <td style="text-align: center; padding: 30px 0px">
                        <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('uploads/front/logo.png')}}" alt=""></a>
                    </td>
                </tr>
                <tr>
                    <td>
                        {!! $msg !!}
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <h3 style="color: #2B7090;">Follow Us On</h3>
                        <ul style="display: inline-flex; margin: 0 auto; justify-content: center !important; align-items: center; padding-left: 0px; gap: 20px;">
                            @if ($social_twitter !== '')
                                {{-- <li style="list-style-type: none; width: 40px; height: 40px; border-radius: 50%; display: flex; justify-content: center; align-items: center;"><a href="{{$social_twitter}}" target="_blank"><img style="height: 30px; width: 30px; display: flex; align-items:center" src="{{asset('uploads/social/twitter.png')}}" alt=""></a></li> --}}
                            @endif
                            @if ($social_linkedin !== '')
                                <li style="list-style-type: none; width: 40px; height: 40px; border-radius: 50%; display: flex; justify-content: center; align-items: center;"><a href="{{$social_linkedin}}" target="_blank"><img style="height: 30px; width: 30px; display: flex; align-items:center" src="{{asset('uploads/social/linkedin.png')}}" alt=""></a></li>
                            @endif
                            @if ($social_facebook !== '')
                                {{-- <li style="list-style-type: none; width: 40px; height: 40px; border-radius: 50%; display: flex; justify-content: center; align-items: center;"><a href="{{$social_facebook}}" target="_blank"><img style="height: 30px; width: 30px; display: flex; align-items:center" src="{{asset('uploads/social/fb.png')}}" alt=""></a></li> --}}
                            @endif
                            @if ($social_youtube !== '')
                                <li style="list-style-type: none; width: 40px; height: 40px; border-radius: 50%; display: flex; justify-content: center; align-items: center;"><a href="{{$social_youtube}}" target="_blank"><img style="height: 30px; width: 30px; display: flex; align-items:center" src="{{asset('uploads/social/YouTube.png')}}" alt=""></a></li>
                            @endif
                            @if ($social_insrtagram !== '')
                                <li style="list-style-type: none; width: 40px; height: 40px; border-radius: 50%; display: flex; justify-content: center; align-items: center;"><a href="{{$social_insrtagram}}" target="_blank"><img style="height: 30px; width: 30px; display: flex; align-items:center" src="{{asset('uploads/social/insta.png')}}" alt=""></a></li>
                            @endif
                        </ul>
                    </td>
                </tr>

                <table style="border: 0px; border-spacing: 0px; width: 800px;border: 2px solid #2B7090;">
                    <tbody>
                        <!-- <tr>
                            <td style="background-color: #2B7090;">
                                <p style="text-align: center; color: white; margin: 10px 0px 0px;">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color: #2B7090; padding: 0px 30px;">
                                <p style="text-align: center; color: white; margin: 5px 0px 10px;">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Est fuga quam dolorem sint facilis vitae quae illum that the right.,</p>
                            </td>
                        </tr>
 -->
                        <tr style="margin-top: 5px;">
                            <td style="background-color: #2B7090; border-top: 2px solid #FFCA03;">
                                <p style="text-align: center; color: white;">Copyright {{date('Y')}} {{$setting_info['COMPANY_NAME']['vValue']}}. All Rights Reserved.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </tbody>
        </table>
    </div>
</body>
</html>