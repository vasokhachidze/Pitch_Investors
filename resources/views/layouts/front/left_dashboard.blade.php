@php
$session_data = (session('user') !== null )?session('user'):'';
$userData = '';
if ($session_data !== '') {
$userData = App\Helper\GeneralHelper::get_user_by_id($session_data['iUserId']);
}

$url = Request::segment(1);
$display_dashboard_left_page = 'style=display:none;';

$allow_dashboard_left_page = ['dashboard','investmentDashboard','advisorDashboard','investorDashboard','investor-add','investor-add1','investment-add', 'investment-add-new','advisor-add','editUser','changePassword','investment-edit','investor-edit','advisor-edit','investor-request','advisor-request','investment-request','business-instruction','premium-detail'];

if (in_array($url,$allow_dashboard_left_page)) {
$display_dashboard_left_page = 'style=display:block;';
}
@endphp
<div class="col-lg-3" {{$display_dashboard_left_page}}>
    <div class="lef-panal-side">
        <div class="row">
            
            <div class="col-lg-12 col-md-6">
                <div class="profile-box-warp active">
                    <div class="profile-box-detail">
                        <div class="btn-group dropstart my-change-dropdown" role="group">
                            <a type="button" class="btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="toggler-icon top-bar"></span>
                                <span class="toggler-icon middle-bar"></span>
                                <span class="toggler-icon bottom-bar"></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                <li><a href="{{ route('front.dashboard.editUser') }}" class="dropdown-item" type="button">Edit profile</a></li>
                                <li><a href="{{ route('front.dashboard.changePassword') }}" class="dropdown-item" type="button">Change Password</a></li>
                            </ul>
                        </div>
                        <div class="profile-icon">
                            @php
                            $image = asset('front/assets/images/defaultuser.png');
                            if (!empty($userData)) {
                            $vImage = $session_data['vImage'];
                            }
                            if (isset($vImage)) {
                            if ($vImage != '') {
                            $image = asset('uploads/user/' . $vImage);
                            }
                            }
                            @endphp
                            <img src="{{ $image }}" alt="">
                        </div>
                        @if (isset($userData->vFirstName) && isset($userData->vLastName))
                        <div class="profile-heading">
                            <a href="{{ route('front.dashboard.dashboard') }}">
                                <h1>{{ $userData->vFirstName . ' ' . $userData->vLastName }}</h1>
                            </a>
                        </div>
                        @endif
                        <div class="other-detail">
                            <ul>
                                <!-- 
                                    @if (isset($userData->vFirstName) && isset($userData->vLastName))
                                    <li>
                                        <a href="javascript:;"><i class="fal fa-user"></i><strong>{{ $userData->vFirstName . ' ' . $userData->vLastName }}</strong></a>
                                    </li>
                                    @endif 
                                -->
                                <li>
                                    <a class="user-id-login" href="javascript:;"><i class="fal fa-envelope"></i>
                                        @if ($userData !== '')
                                        @if (strlen($userData->vEmail) > 28)
                                        {{ substr($userData->vEmail, 0, 28) . '...' }}
                                        @else
                                        {{ $userData->vEmail }}
                                        @endif
                                        @endif
                                    </a>
                                </li>
                                @if ($userData !== '' && $userData->is_premium == 1)
                                <li>
                                    <a class="user-id-login" href="{{ url('/premium-detail') }}"><i title = "View Benefits" class="fal fa-info"></i>
                                    Premium Member
                                    </a>
                                    </li>
                                @endif
                                
                            </ul>
                        </div>
                        {{-- <div class="final-button">
                            <a href="#" class="btn btn-primary bg-gray"><i class="fal fa-wallet"></i>{{$userData->iTotalToken}} connection</a>
                         </div> --}}
                    </div>
                </div>
                <div class="accordion-item left-side-acc-rdion">
                    <h2 class="accordion-header" id="headingtwo">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsetwo" aria-expanded="true" aria-controls="collapseOne">
                            <div class="heading">
                                <span><b>Connection</b></span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapsetwo" class="accordion-collapse collapse show" aria-labelledby="headingtwo" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body" style="cursor:pointer;">
                            <div class="in-detail">

                                <a href="{{ route('front.dashboard.investmentDashboardTabview') }}">
                                    <div class="form-check">
                                        <label class="form-check-label" for="1" style="color: #f29d1c;cursor:pointer;"> Business Connection </label>
                                    </div>
                                </a>
                                <a href="{{ route('front.dashboard.advisorDashboardTabview') }}">
                                    <div class="form-check">
                                        <label class="form-check-label" for="2" style="color:#69B965;cursor:pointer;"> Advisor Connection </label>
                                    </div>
                                </a>
                                <a href="{{ route('front.dashboard.investorDashboardTabview') }}">
                                    <div class="form-check">
                                         <label class="form-check-label" for="3" style="color:#2B7090;cursor:pointer;"> Investor Connection </label>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="primary-chat">
            @if ($session_data !== '')
            @include('layouts.front.chat_inbox_connection_listing')
            @endif
            </div>
           
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.form-check-label').on('click',
        function () {
            $(this).addClass("show");
            
        });

</script>
