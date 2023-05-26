@php
$url = Request::segment(1);
$allow_chat_script = ['dashboard','investmentDashboard','advisorDashboard','investorDashboard','investor-add','investment-add','advisor-add','editUser','changePassword','investment-edit','investor-edit','advisor-edit'];
@endphp
@if(empty($user_session))
s<!-- header start -->
<header class="fixed-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('uploads/logo/logo.png')}}" alt=""></a>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="toggler-icon top-bar"></span>
                    <span class="toggler-icon middle-bar"></span>
                    <span class="toggler-icon bottom-bar"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav  m-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link @if ($url == 'investment') active @endif" href="{{ url('investment') }}">Businesses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if ($url == 'advisor') active @endif" href="{{ url('advisor') }}">Advisors</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if ($url == 'investor') active @endif" href="{{ url('investor') }}">Investors</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if ($url == 'about-us') active @endif" href="{{url('about-us')}}" class=" @if ($url == 'pageSetting') active @endif">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if ($url == 'contact_us') active @endif" href="{{ url('contact_us') }}">Contact Us</a>
                        </li>
                    </ul>

                    <form class="d-flex">
                        <div class="head-search">
                             <input class="form-control me-2 h-100" name="keyword" id="keyword" type="search" placeholder="" aria-label="Search">
                            <i class="fas fa-search"></i>
                            <div class="profile_listing"></div>
                        </div>
                    </form>
                    @if ((!empty($user_session)))
                    <a class="btn login-btn ms-2" href="{{ url('logout') }}">Logout</a>
                    @else
                    <a class="btn login-btn ms-2" href="{{ url('login') }}">Login</a>
                    @endif
                </div>
            </div>
        </nav>
    </div>
</header>
<!-- header End -->
@else
<!-- new header start -->
@php
if (isset($user_session['iUserId'])) {
    $userData = App\Helper\GeneralHelper::get_user_by_id($user_session['iUserId']);
    $whereProfileExist = ['iUserId' => $user_session['iUserId']];
    $userInvestroProfileExist = App\Models\front\investor\Investor::get_by_iUserId($whereProfileExist);
    $userAdvisorProfileExist = App\Models\front\advisor\BusinessAdvisor::get_by_iUserId($whereProfileExist);
}
@endphp
<header class="fixed-top" style="display: block;">
    <div class="container">
        @include('layouts.front.chat_inbox_chat_box')
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('uploads/logo/logo.png')}}" alt=""></a>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="toggler-icon top-bar"></span>
                    <span class="toggler-icon middle-bar"></span>
                    <span class="toggler-icon bottom-bar"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav custom-nav-link-menu m-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link @if ($url == 'investment') active @endif" href="{{ url('investment') }}">Businesses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if ($url == 'advisor') active @endif" href="{{ url('advisor') }}">Advisors</a>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if ($url == 'investor') active @endif" href="{{ url('investor') }}">Investors</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if ($url == 'about-us') active @endif" href="{{url('about-us')}}" class=" @if ($url == 'pageSetting') active @endif">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if ($url == 'contact_us') active @endif" href="{{ url('contact_us') }}">Contact Us</a>
                        </li>
                    </ul>
                    <div class="serch-wrap">
                        <a href="#" class="serch-btn-2"> <i class="fa fa-search"></i></a>
                        <div class="serch-bg">
                            <input type="text" name="keyword" id="keyword" class="serch-txt form-control" placeholder="Search">
                            <div class="profile_listing"></div>
                            <a href="#" class="serch-btn"> <i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="notification-baar position-relative" id="mainNotification">

                        <span class="notification-dot-here" id="notificationDot"></span>
                        <a id="chat_exist_a" href="javascript:;"><i id="chat_exist_i" class='fas fa-bell fa-1x'></i></a> 
                        <div class="header_chat_list dropdown-menu dropdown-add-profile chat-dropdown chat_list_toggle" style="display: none;">
                            <div class="chat_sub_div">
                                @include('layouts.front.chat_inbox_connection_listing')
                            </div>
                        </div>
                    </div>
                    <div class="add-profile">
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false"><i class="fal fa-plus"></i>Add Profile</a>
                            <ul class="dropdown-menu dropdown-add-profile" aria-labelledby="dropdownMenuButton2">
                                <li><a class="dropdown-item " href="{{url('investment-add')}}">Add Business</a></li>
                                @if (empty($userAdvisorProfileExist))
                                    <li><a class="dropdown-item" href="{{url('advisor-add')}}">Add Advisor</a></li>
                                @endif
                                @if (empty($userInvestroProfileExist))
                                    <li><a class="dropdown-item border-bottom" href="{{url('investor-add')}}">Add Investor</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="my-profile">
                        <!-- user profile -->
                        <div class="profile">
                            <div class="dropdown">
                                <a class="dropdown-toggle profile-img" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    @php
                                        $image = asset('front/assets/images/defaultuser.png');
                                        $vImage=$user_session['vImage'];
                                        if(isset($vImage))
                                        {
                                            if($vImage != ""){
                                            $image = asset('uploads/user/'.$vImage);
                                            }
                                        }
                                    @endphp
                                    <img src="{{$image}}">
                                    @if(isset($userData->vFirstName) && !empty($userData->vFirstName))
                                        {{$userData->vFirstName}} {{$userData->vLastName}}
                                    @else
                                        {{$user_session['vEmail']}}
                                    @endif
                                    
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item border-bottom" href="{{ url('dashboard') }}">Dashboard</a></li>
                                    <li><a class="dropdown-item border-bottom" href="{{ url('editUser') }}">Edit Profile</a></li>
                                    <li><a class="dropdown-item border-bottom" href="{{ url('token-listing') }}">Token</a></li>
                                    <li><a class="dropdown-item border-bottom" href="{{ url('contract-listing') }}">Wallet</a></li>
                                    <li class="text-center mt-2 mb-2">
                                        @if ((isset($user_session['iUserId'])))
                                            <a class="log-out-btn btn-primary" href="{{ url('logout') }}">Logout</a>
                                        @else
                                            <a class="btn login-btn ms-2" href="{{ url('login') }}">Login</a>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
<!-- new header close -->
@endif
<script>
    $(".notification-baar").click(function (e) { 
        // $(".header_chat_list").toggle();
        // $(".header_chat_list").css("top", "35px");
    });
    $(".chat-peopel").click(function (e) { 
        // $(this).parent.hide();
    });
$("#keyword").on("keyup change", function() {
    var keyword = $(this).val();
    if (keyword.length == 0) {
        $('#keyword').val("");
    }
    $(".profile_listing").show();
    if (keyword.length >= 3) {
        $.ajax({
            url: "{{ url('searchProfile') }}",
            cors: true,
            type: "POST",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            data: {
                keyword: keyword
            },
            success: function(response) {
                if (response == 1) {
                    $(".profile_listing").html('No Data Found');
                    /*$(".profile_listing").hide();*/
                } else {
                    $(".profile_listing").html(response);
                }
            }
        })
    } else {
        $(".profile_listing").html('Enter minimum three character');
        $(".profile_listing").css("position", "relative");
    }
});
$(document).click(function() {
    $('.profile_listing').hide();
});
</script>