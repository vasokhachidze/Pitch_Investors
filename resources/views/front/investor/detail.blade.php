@extends('layouts.app.front-app')
@section('title', 'Investors Detail - '.env('APP_NAME'))
@section('content')
@php

$session_data = session('user');
$chat_iSenderId = '';
$chat_iReceiverId = '';
$chat_vReceiverPersoneName = '';
$chat_connectionId = '';
$receiverPhoneNo = '';
$image = asset('uploads/default/no-profile.png');
$popup_vPhone = $popup_name = '';
if (!empty($session_data)) 
{
            $userToken = App\Helper\GeneralHelper::get_myAvailable_token($session_data['iUserId']);


$popup_vPhone = $session_data['vPhone'];
$popup_name = $session_data['vFirstName'] . ' ' . $session_data['vLastName'];
foreach ($connection_list as $main_key => $main_value) {
/* if ($main_value->iSenderId == $session_data['iUserId']) { */
if ($main_value->iReceiverId == $data->iUserId) {
$chat_iSenderId = $main_value->iSenderId;
$chat_iReceiverId = $main_value->iReceiverId;
$chat_vReceiverPersoneName = $main_value->receiverName;
if (!empty($main_value->receiverImage) && file_exists(public_path('uploads/user/'.$main_value->receiverImage))) {
$image = asset('uploads/user/'.$main_value->receiverImage);
}
$receiverPhoneNo = $main_value->vReceiverMobNo;
}
elseif ($main_value->iSenderId == $data->iUserId) {
$chat_iSenderId = $main_value->iSenderId;
$chat_iReceiverId = $main_value->iReceiverId;
$chat_vReceiverPersoneName = $main_value->senderName;
if (!empty($main_value->senderImage) && file_exists(public_path('uploads/user/'.$main_value->senderImage))) {
$image = asset('uploads/user/'.$main_value->senderImage);
}
$receiverPhoneNo = $main_value->vSenderMobNo;
}
$chat_connectionId = $main_value->iConnectionId;
}
}

$display_chat_btn = false;

/* change investment condition according data received from db */
// dd($investment_exist);
if (isset($investment_exist) && count($investment_exist) > 0) {
$display_chat_btn = true;
}
if (isset($investor_exist) && count($investor_exist) > 0) {
$display_chat_btn = true;
}
@endphp
<style type="text/css">
    #sendMail {
  cursor:pointer;
}

</style>
<!-- banner section start -->
<section class="bread-camp-detail lite-gray">
    <div class="container">
        <div class="bread-text-head">
            <h5><a href="{{ url('home') }}">Home </a>/<a href="{{ url('investor') }}"> Investors</a> /<a href="javascript:;"> {{$data->vInvestorProfileName}}</a></h5>
        </div>
    </div>
    </div>
</section>
<!-- banner section end -->
<!-- detail-inner-section start -->
<section class="detail-inner-warp pb-5 lite-gray investor-detail">
    <div class="container">
        <div class="row sticky-detail">
            <div class="col-md-10">
                <div class="detail-heading">
                    <h2 class="mb-1">{{$data->vInvestorProfileName}}</h2>
                </div>
            </div>
            <div class="col-md-2">
                <div>
                    @if(isset($loginUserId))
                    @php
                    $availableProfile='';
                    $availableProfile2='';

                    if(count($inInvestmentCheckProfile) >0)
                    {
                    $availableProfile = 'Yes';
                    }
                    else{
                    $availableProfile='';
                    }
                    if(!empty($inAdvisorCheckProfile))
                    {
                    $availableProfile2 = 'Yes';
                    }
                    else
                    {
                    $availableProfile2='';
                    }

                    @endphp
                    @if($display_chat_btn && !$myOwnProfile)
                    <a href="javascript:;" class="btn btn-primary connection-btn-design chat-person-profile" data-isenderid="{{$chat_iSenderId}}" data-ireceiverid="{{$chat_iReceiverId}}" data-vreceivercontactpersonname="{{$chat_vReceiverPersoneName}}" data-vReceiverContactPersonPhoneNo="{{$receiverPhoneNo}}" data-iconnectionid="{{$chat_connectionId}}" data-current_chat_profile_image="{{$image}}">
                        Chat
                    </a>
                    @elseif(($availableProfile == 'Yes' || $availableProfile2 == 'Yes') && !$myOwnProfile)
                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleModal1" class="btn btn-primary1 connection-btn-design blue-btn">
                        Send Proposal
                    </a>
                    @elseif(!$myOwnProfile)
                    <a href="{{ url('dashboard') }}" class="btn btn-primary connection-btn-design">
                        Update Your Profile
                    </a>
                    @endif
                    @else
                    <a href="{{ url('login') }}" class="btn btn-primary1 connection-btn-design blue-btn">Send Proposal</a>
                    @endif
                </div>
            </div>
            <div class="col-md-12">
                <div class="social-info-detail">
                    <ul class="mb-0">
                        <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Email Verified"><i class="fal fa-envelope"></i>Email</a></li>
                        <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Phone Verified"><i class="far fa-phone-alt"></i>Phone</a></li>
                        {{-- <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Google Verified"><i class="fab fa-google-plus-g"></i> Google</a></li>
                            <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Not Linkdin Verified" class="disable"><i class="fab fa-linkedin"></i> Linkdin</a></li> --}}
                    </ul>
                </div>
            </div>
        </div>
        <div class="detail-warp-box">
            <div class="row">
                <div class="col-md-12">
                    <div class="detail-heading insight-name">
                        <p>{{strip_tags($data->tInvestorProfileDetail)}}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-4">
                    <div class="company-detail">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="other-info">
                                    <h2>Name, Phone, Email</h2>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="other-info-detail">
                                    <ul>
                                        <li class="name-phone-mail-detail">

                                            @if ($profileVisible)
                                            {{$data->vFirstName}}{{$data->vLastName}} ,
                                            {{$data->vPhone}} ,
                                            {{$data->vEmail}}
                                            @else
                                            <i class="far fa-clock"></i> Available after connect
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="company-detail ul-with-dot">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="other-info">
                                    <h2>Nationality </h2>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="options">                                   
                                   @empty($countries)  
                                       <p >{{'N/A'}}</p>                                  
                                    @else  
                                        @forelse($countries as $lvalue)                                     
                                            <p>
                                            @if ($data->iNationality == $lvalue->iCountryId)
                                            {{ $lvalue->vNationality }} @endif</p>
                                        @empty
                                         <p>{{'N/A'}}</p>     
                                        @endforelse
                                    @endempty  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="company-detail ul-with-dot">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="other-info">
                                    <h2>City </h2>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="options">                                   
                                    <p>@if(!empty($data->iCity)){{ $data->iCity }}@else {{ 'N/A' }} @endif</p>                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="company-detail">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="Business-Name">
                                    <h2>Company</h2>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="Business-Name-detail company-value-name">
                                    <ul>
                                        <li>
                                            @if ($profileVisible)
                                            {{$data->vProfileTitle}}
                                            @else
                                            <i class="far fa-clock"></i> Available after connect
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-md-12 mt-3">
                    <div class="company-detail">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="other-info">
                                    <h2>Professional Summary</h2>
                                </div>
                            </div>
                            <div class="col-md-9">
                                @php
                                $total_words_FactorsInBusiness = str_word_count($data->tFactorsInBusiness);
                                $desc1_FactorsInBusiness = $desc2_FactorsInBusiness = '';
                                if ($total_words_FactorsInBusiness > 20) {
                                $desc1_FactorsInBusiness = implode(' ', array_slice(explode(' ', $data->tFactorsInBusiness), 0, 20));
                                $desc2_FactorsInBusiness = implode(' ', array_slice(explode(' ', $data->tFactorsInBusiness), 21));
                                } else {
                                $desc1_FactorsInBusiness = $data->tFactorsInBusiness;
                                }
                                @endphp
                                <div class="options">
                                    <ul>
                                        <li>
                                            {{ $desc1_FactorsInBusiness }}
                                            @if ($total_words_FactorsInBusiness > 20)
                                            <span id="dots_FactorsInBusiness">...</span><span class="more_span" id="more_FactorsInBusiness">
                                                {{ $desc2_FactorsInBusiness }}</span><a onclick="read_more_less_text('dots_FactorsInBusiness','more_FactorsInBusiness','myBtn_FactorsInBusiness')" id="myBtn_FactorsInBusiness" class="text-green pointer_cursor">
                                                Read more</a>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12 mt-3">
                    <div class="company-detail">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="other-info">
                                    <h2>Investment Size</h2>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="options">
                                    <ul>
                                        <li>
                                            @if (!empty($data->vHowMuchInvest))
                                            {{ $data->vHowMuchInvest }}
                                            @else
                                            {{ 'N/A' }}
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="company-detail">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="other-info">
                                    <h2>Overall Rating</h2>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="options">
                                    <ul>
                                        <li class="rate"><i class="fas fa-star"></i>
                                            @if($data->vAverageRating == NULL || $data->vAverageRating == 0)
                                                {{'No Rating'}}
                                            @else
                                                {{$data->vAverageRating}}
                                            @endif </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="company-detail">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="other-info">
                                    <h2>Local Time</h2>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="options">
                                    <ul>
                                        <li><i class="far fa-clock"></i>{{ date('G:i:s T Y') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="company-detail">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="other-info">
                                    <h2>Status</h2>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="options status-green">
                                    <ul>
                                        <li><i class="fas fa-circle"></i> {{ $data->eStatus }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="company-detail ul-with-dot">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="other-info">
                                    <h2>Transaction Preference</h2>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="options">
                                    <ul>
                                        @if ($data->eAcquiringBusiness == 'Yes')
                                        <li>{{ 'Acquiring / Buying a Business' }}</li>
                                        @endif

                                        @if ($data->eInvestingInBusiness == 'Yes')
                                        <li>{{ 'Investing in a Business' }}</li>
                                        @endif

                                        @if ($data->eLendingToBusiness == 'Yes')
                                        <li>{{ 'Lending to a Business' }}</li>
                                        @endif

                                        @if ($data->eBuyingProperty == 'Yes')
                                        <li>{{ 'Buying Property' }}</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12 mt-3">
                    <div class="company-detail ul-with-dot">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="other-info">
                                    <h2>Sector Preference</h2>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="options">
                                    <ul>
                                        @php
                                        $nullValue2 = '';
                                        @endphp
                                        @foreach ($industries as $key => $ivalue)
                                        @if (!empty($ivalue->vIndustryName) && $ivalue->iInvestorProfileId == $data->iInvestorProfileId)
                                        {{-- {{ $nullValue2 = '' }} --}}
                                        <li>{{ $ivalue->vIndustryName }}</li>
                                        @else
                                        @php
                                        $nullValue2 = 'N/A';
                                        @endphp
                                        @endif
                                        @endforeach
                                        @if (!empty($nullValue2))
                                        {{ $nullValue2 }}
                                        @endif

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!----review form--->
            @if(isset($loginUserId))
            @php
            $availableProfile='';
            $availableProfile2='';

            if(count($inInvestmentCheckProfile) >0)
            {
            $availableProfile = 'Yes';
            }
            else{
            $availableProfile='';
            }
            if(!empty($inAdvisorCheckProfile))
            {
            $availableProfile2 = 'Yes';
            }
            else
            {
            $availableProfile2='';
            }

            @endphp
            @if ($display_chat_btn && !$myOwnProfile && (!$myOwnProfile))
                        <div class="col-md-12">
                                <div class="Seeking-detail mt-3">
                                    <div class="heading toggle-heading">
                                        <!-- <h2>Review</h2> -->
                                         <button id="buttonAddReview">Write Review</button>
                                    </div>
                                    <div id="review_AddBox_Div" style="display:none;"> 
                                    <form id="reviewfrm" action="{{ url('investor-review') }}" method="POST" enctype="multipart/form-data">
                                      <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="{{$data->vUniqueCode}}">
                                        <input type="hidden" id="iInvestorProfileId" name="iInvestorProfileId" value="{{$data->iInvestorProfileId}}">
                                        <input type="hidden" id="iUserId" name="iUserId" value="{{$session_data['iUserId']}}">
                                        <input type="hidden" name="star_rating" id="star_rating" value="@if(!empty($my_review_data->iRating)){{$my_review_data->iRating}}@endif" >
                                    @csrf

                                    <div id="full-stars-example">
                                         <div class="detail-form">
                                            <div class="row">
                                                <div class="col-md-12 mt-1">
                                                    <section class='rating-widget'>
                                                        <div class='rating-stars text-center'>
                                                            <ul id='stars' class="d-flex" style="float:unset;">
                                                                @if(!empty($my_review_data))
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <li class="star @if ($i <= $my_review_data->iRating) {{'selected'}} @endif" data-value="{{$i}}">
                                                                            <i class='fa fa-star fa-fw'></i>
                                                                        </li>
                                                                    @endfor       
                                                                @else
                                                                 <section class='rating-widget'>
                                                                    <div class='rating-stars text-center'>
                                                                        <ul id='stars' class="d-flex" style="float:unset;">
                                                                            <li class='star' title='Poor' data-value='1'>
                                                                                <i class='fa fa-star fa-fw'></i>
                                                                            </li>
                                                                            <li class='star' title='Fair' data-value='2'>
                                                                                <i class='fa fa-star fa-fw'></i>
                                                                            </li>
                                                                            <li class='star' title='Good' data-value='3'>
                                                                                <i class='fa fa-star fa-fw'></i>
                                                                            </li>
                                                                            <li class='star' title='Excellent' data-value='4'>
                                                                                <i class='fa fa-star fa-fw'></i>
                                                                            </li>
                                                                            <li class='star' title='WOW!!!' data-value='5'>
                                                                                <i class='fa fa-star fa-fw'></i>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class='success-box' style="display:none;">
                                                                        <div class='clearfix'></div>
                                                                        <div class='text-message'></div>
                                                                        <div class='clearfix'></div>
                                                                    </div>
                                                                </section>
                                                                @endif                                                           
                                                            </ul>
                                                        </div>
                                                    </section>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <label class="write-review-lable">Write a review</label>
                                                    <textarea class="form-control" name="vReview" id="vReview" placeholder="Write a Review">@if(isset($my_review_data->vReview)){{$my_review_data->vReview}}@endif</textarea>                                    
                                                </div>
                                                 <div class="row margin-left-button" id="submit">
                                                    <label class="save-detail mt-1"><a href="javascript:;" id="submit_review">@if(!empty($my_review_data)) {{'Edit'}} @else {{'Save'}} @endif</a></label>
                                                </div>
                                            </div>                   
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>

                @endif  
            @endif
            <!----review form--->
            <!---- view review -->
              @if(count($review_data) > 0)
                
                    <div class="col-md-12">
                        <div class="Seeking-detail mt-3">
                            <div class="heading toggle-heading">
                                <h2>Rating Overview</h2>
                                <button id="buttonReview">View Details</button>
                            </div>
                            <div id="review_Box_Div" style="display:none;">
                                @foreach ($review_data as $key => $review_value)
                                    @if (!empty($session_data))
                                        @if ($review_value->iUserId != $session_data['iUserId'])
                                            <div class="col-md-12">
                                                <div class="options">
                                                    {{ $review_value->vFirstName }} {{ $review_value->vLastName }}
                                                    <br>
                                                    <section class='rating-widget'>
                                                        <div class='rating-stars'>
                                                            <ul id='stars1'>
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <li class="star @if ($i <= $review_value->iRating) {{ 'selected' }} @endif" data-value='{{ $i }}'>
                                                                        <i class='fa fa-star fa-fw'></i>
                                                                    </li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                    </section><br>
                                                    <p class="review-output-text"> {{ $review_value->vReview }}</p>
                                                </div>
                                            </div>
                                            <hr>
                                        @endif
                                    @else
                                        <div class="col-md-12">
                                            <div class="options">
                                                {{ $review_value->vFirstName }} {{ $review_value->vLastName }}
                                                <section class='rating-widget'>
                                                    <div class='rating-stars'>
                                                        <ul id='stars1'>
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <li class="star @if ($i <= $review_value->iRating) {{ 'selected' }} @endif" data-value='{{ $i }}'>
                                                                    <i class='fa fa-star fa-fw'></i>
                                                                </li>
                                                            @endfor
                                                        </ul>
                                                    </div>
                                                </section><br>
                                                <p class="review-output-text"> {{ $review_value->vReview }}</p>
                                            </div>
                                        </div>
                                        <hr>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>                
                @endif
            <!---- view review end -->
            <!-- right-text -->
            <div class="col-xl-12 col-lg-12">
                <!-- other details -->
                <div class="row right-text mt-2">
                    {{-- <div class="col-lg-3 col-md-4 col-sm-6 pad-bottom">
                        <div class="company-detail">
                            <div class="rating">
                                <h2>Overall Rating</h2>
                            </div>
                            <div class="rating-detail">
                                <ul>
                                    <li class="rate"><i class="fas fa-star"></i> 8.5/10</li>
                                </ul>
                            </div>
                        </div>
                    </div> --}}
                </div>
                {{--<div class="col-lg-4 col-md-7 col-sm-6 pad-bottom">
                        <div class="company-detail">
                            <div class="User-info">
                                <h2>User Verification</h2>
                            </div>
                            <div class="User-info-detail">
                                <ul>
                                    <li><i class="fal fa-envelope"></i> {{ $data->vEmail }}</li>
                                    <li><i class="fal fa-phone-alt"></i> {{ $data->vPhone }}</li>
                                    <li><i class="fab fa-google-plus-g"></i> Google</li>
                                </ul>
                            </div>
                        </div>
                </div> --}}
                <div class="row right-text mt-2">
                    <div class="col-md-12">
                        <div class="investment-other-detail">
                        {{--<div class="Seeking-detail">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="heading">
                                            <h2>Investment Criteria</h2>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="options">
                                            <ul>
                                                <li>@if (!empty($data->vWhenInvest))
                                                        {{ $data->vWhenInvest }}    
                                                    @else   {{ 'N/A' }}
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
            <!-- <div class="Seeking-detail">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="heading">
                                <h2>Recent Activity</h2>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="options update-bar">
                                <ul>
                                    <li class="mb-4 border1">
                                        <p>Connected with 10+ businesses</p>
                                    </li>
                                    <li class="mb-4 border1">
                                        <p>Received 10+ proposals</p>
                                    </li>
                                    <li class="mb-4 border1">
                                        <p>5 days, 19 hours ago</p>
                                        <h6><span>Received a proposal from </span>Innovative food tech company focusing on packaged nutrition foods under its own brand. </h6>
                                    </li>
                                    <li class="mb-4 border1">
                                        <p>4 days, 10 hours ago</p>
                                        <h6><span>Received a proposal from </span> FINVEST - Sales Partner Opportunity</h6>
                                    </li>
                                    <li class="mb-4">
                                        <p>5 days, 5 hours ago</p>
                                        <h6><span>Received a proposal from </span> For Sale: Jaivik Bharat and PGS India certified organic Ratnagiri Alphonso Mango Farm.</h6>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> -->
            <!--  
                <div class="Seeking-detail">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="heading">
                                <h2>Preferences</h2>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="options">
                                <ul>
                                    <li>Preferences</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>-->
            <!-- <div class="Seeking-detail">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="heading">
                                <h2>Tags</h2>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="options">
                                <ul>
                                    <li class="light-grey">Investor, Food Investor, F & B Investor, Investor in Oman, Textile Investor, Industrial Investor, Food & Beverage Investor</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <!-- other etails end -->
    </div>
    <!-- right-text-end -->
    </div>
    </div>
    <form id="frm" action="{{ url('investor-token-store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="vUniqueCode" id="vUniqueCode" value="{{ $data->vUniqueCode }}">
        <div class="modal fade contact-business-model-frist" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body contact-business-model p-0">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="model-frist-image">
                                    <img src="{{ asset('front/assets/images/detail-model-1.png') }}" alt="">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="contace-business-model-detail">
                                    <h2>Contact Business</h2>
                                    <p>A small number of tokens will be deducted from your account as a connection fee.</p>

                                    {{-- <div>
                                                <label>Transaction Type</label>
                                                <div class="form-check mt-3">
                                                    <input class="form-check-input " name="transaction_type"
                                                        type="checkbox" value="eFullSaleBusiness" id="eFullSaleBusiness">
                                                    <label class="form-check-label" for="eFullSaleBusiness">
                                                        Full sale of business
                                                    </label>
                                                </div>

                                                <div class="form-check mt-3">
                                                    <input class="form-check-input" name="transaction_type"
                                                        type="checkbox" value="eLoanForBusiness" id="eLoanForBusiness">
                                                    <label class="form-check-label" for="eLoanForBusiness">
                                                        Loan for business
                                                    </label>
                                                </div>

                                                <div class="form-check mt-3">
                                                    <input class="form-check-input" name="transaction_type"
                                                        type="checkbox" value="ePartialSaleBusiness"
                                                        id="ePartialSaleBusiness">
                                                    <label class="form-check-label" for="ePartialSaleBusiness">
                                                        Sale of business/Investment
                                                    </label>
                                                </div>

                                                <div class="form-check mt-3">
                                                    <input class="form-check-input " name="transaction_type"
                                                        type="checkbox" value="eBailout" id="eBailout">
                                                    <label class="form-check-label" for="eBailout">
                                                        Distressed company looking for bailout
                                                    </label>
                                                </div>
                                                <div id="intrestedIn_error" class="error mt-1"
                                                    style="color:red;display: none;">Please Select type</div>
                                            </div> --}}

                                    <div>
                                        <input type="hidden" name="profileType" id="profileType">
                                        <input type="hidden" name="profileId" id="profileId">
                                        <input type="hidden" name="contactname" id="contactname">

                                        @if (!empty($inInvestmentCheckProfile))
                                        <div class="mb-2">
                                            <label class="fon-weight-bold">Investment Profile </label>
                                            @foreach ($inInvestmentCheckProfile as $key => $ivalue)
                                            <div class="form-check mt-3">
                                                <input class="form-check-input fillValue" name="profile_name" type="radio" value="{{ $ivalue->iUserId }}" id="investment_profile_name[{{$key}}]" data-name="{{ $ivalue->vBusinessProfileName }}" data-phone="{{ $ivalue->vPhone }}" data-type="Investment" data-profileid="{{ $ivalue->iInvestmentProfileId }}" data-contactname="{{ $ivalue->vFirstName }}">
                                                <label class="form-check-label" for="investment_profile_name[{{$key}}]">
                                                    {{ $ivalue->vBusinessProfileName }}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                        @if (!empty($inAdvisorCheckProfile))
                                        <div>
                                            <label class="fon-weight-bold"> Advisor Profile </label>
                                            <div class="form-check mt-3">
                                                <input class="form-check-input fillValue" name="profile_name" type="radio" value="{{ $inAdvisorCheckProfile->iUserId }}" id="advisor_profile_name" data-name="{{ $inAdvisorCheckProfile->vAdvisorProfileTitle }}" data-phone="{{ $inAdvisorCheckProfile->vPhone }}" data-type="Advisor" data-profileid="{{ $inAdvisorCheckProfile->iAdvisorProfileId }}" data-contactname="{{ $inAdvisorCheckProfile->vFirstName }}">
                                                <label class="form-check-label" for="advisor_profile_name">
                                                    {{ $inAdvisorCheckProfile->vAdvisorProfileTitle }}
                                                </label>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                   <!--  <div class="mt-2">
                                        <label for="fName">Full Name</label>
                                        <input type="text" name="fName" id="fName" class="form-control" value="{{$popup_name}}" placeholder="Please enter your name">
                                        <div id="fName_error" class="error mt-1" style="color:red;display: none;">Please enter your name</div>
                                    </div>

                                    <div class="mt-2">
                                        <label for="phone">Your Mobile Number</label>
                                        <input type="text" name="phone" id="phone" class="form-control numeric" value="{{$popup_vPhone}}" maxlength="10" placeholder="Please enter your phone number">
                                        <div id="phone_error" class="error mt-1" style="color:red;display: none;">Please enter your phone number</div>
                                    </div>

                                    <div class="mt-2">
                                        <label for="floatingTextarea2">Comments</label>
                                        <textarea class="form-control" name="comments" id="comments" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                                        <div id="comments_error" class="error mt-1" style="color:red;display: none;">Please leave a message to the business</div>
                                    </div>

                                    <div class="form-check mt-3">
                                        <input class="form-check-input accept" type="checkbox" value="Yes" name="term" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            I accept the <a href="#">Terms of Engagement</a>
                                        </label>
                                        <div id="accept_error" class="error mt-1" style="color:red;display: none;">Please accept the terms of engagement</div>
                                    </div> -->

                                    <!-- <div class="send-model-btn text-center">
                                                  <a href="javascript:;" class="submit">Send Now</a>
                                                </div> -->
                                    @if(!empty($userToken) && $userToken->iTotalToken == 0)
                                        <p class="mb-0" style="color: red;font-size: large;">You don't have sufficiant token</p>
                                        <a href="{{url('plan-listing')}}">Add Token</a>
                                    @else
                                    <div class="mt-2">
                                         <div class="alert alert-danger" id="myAlert">
                                          <strong>Info!</strong> after sending request it will deduct one connect from your account.
                                        </div>
                                    </div>
                                    <div class="send-model-btn text-center">
                                        <a href="javascript:;" class="submit">Send Now</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!---close model--->
    </div>
</section>

<!-- get-in touch section start -->
<section class="get-touch">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-4 respnsive-img">
                <div class="get-touch-img">
                    <img src="{{ asset('uploads/front/investment/men1.png') }}" alt="">
                </div>
            </div>
            <div class="col-lg-7 col-md-8 get-touch-message">
                <div class="get-message">
                    <h1>Subscribe to our Newsletter</h1>
                    <p>Sign up for our newsletter to receive updates and exclusive promotions.</p>
                    <div class="send-message">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Email" name="vEmail" id="vEmail"  aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="sendMail" >Send</span>
                        </div>
                        <div id="vEmail_error" class="error mt-1" style="color:red;display: none;">Please Enter Email </div>
                        <div id="vEmail_valid_error" class="error_show" style="color:red;display: none;">Please Enter Valid Email</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
 <div class="col-xl-4 col-lg-12 mt-2">
    <div class="row">
        <div class="modal fade contact-business-model-frist1 purchase-btn-popup" id="exampleModal12" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display:none;">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close closeModel" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body contact-business-model ">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="contace-business-model-detail" id="forVerifyPlanPayment">
                                    <h2>Subscribe to our Newsletter</h2>
                                    <p class="mb-0">A small number of tokens will be deducted from your account as a connection fee.</p>
                                                                           
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <!---close model--->
    </div>
<!-- grt-in touch section end -->
@endsection
@section('custom-js')
<script>
    $(document).on("input", ".numeric", function() {
        this.value = this.value.replace(/\D/g, '');
    });
     $(document).on('click','#sendMail',function() 
        {
            var error =false;

             var vEmail = $("#vEmail").val();
            if (vEmail.length == 0) {
                $("#vEmail").addClass('has-error');
                $("#vEmail_error").show();
                $("#vEmail_valid_error").hide();
                $("#vEmailError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                if (validateEmail(vEmail)) {
                    $("#vEmail_valid_error").hide();
                    $("#vEmail_error").hide();
                    $("#vEmail").removeClass('has-error');
                    $("#vEmailError").removeClass('fas fa-exclamation-circle');
                    $("#vEmailError").addClass('fas fa-check-circle');
                    
                } else {
                    $("#vEmail").addClass('has-error');
                    $("#vEmail_valid_error").show();
                    $("#vEmail_error").hide();
                    $("#vEmailError").removeClass('fas fa-check-circle');
                    $("#vEmailError").addClass('fas fa-exclamation-circle');
                    error = true;
                }
            }
            setTimeout(function() {
                if (error == true) {
                    return false;
                } else {
                   /*  $('#exampleModal12').css("display", "block");
                    $('#exampleModal12').css("opacity", "1");*/
                    //$("#frm").submit();
                    return true;
                }
            }, 1000);
        });

$(document).on('click','.closeModel',function() 
        {

              $('#exampleModal12').css("display", "none");
              $('#exampleModal12').css("opacity", "0");
        });
    $(document).on('click', '.submit', function() {
        var error = false;
        var intrestCheckbox = $(".intrestCheckbox:checkbox:checked").length;
       /* var fName = $("#fName").val();
        var phone = $("#phone").val();
        var comments = $("#comments").val();
        var accept = $(".accept:checkbox:checked").length;*/


        if (intrestCheckbox <= 0) {
            $("#intrestedIn_error").show();
        } else {
            $("#intrestedIn_error").hide();
        }
        /*if (fName.length == 0) {
            $("#fName_error").show();
            error = true;
        } else {
            $("#fName_error").hide();
        }
        if (phone.length == 0) {
            $("#phone_error").show();
            error = true;
        } else {
            $("#phone_error").hide();
        }
        if (comments.length == 0) {
            $("#comments_error").show();
            error = true;
        } else {
            $("#comments_error").hide();
        }
        if (accept <= 0) {
            $("#accept_error").show();
        } else {
            $("#accept_error").hide();
        }*/
        setTimeout(function() {
            if (error == true) {
                return false;
            } else {
                $("#frm").submit();
                return true;
            }
        }, 1000);
    });

    $(document).ready(function() {
        $('.fillValue').change(function() {
            var name = $(this).data("name");
            var phone = $(this).data("phone");
            var profileType = $(this).data("type");
            var contactname = $(this).data("contactname");
            var profileid = $(this).data("profileid");

            /* $('#fName').val(name); */
            $('#profileType').val(profileType);
            $('#profileId').val(profileid);
            $('#contactname').val(contactname);
            /* $('#phone').val(phone); */

        });
            $('#buttonAddReview').on('click', function(e){
                $("#review_AddBox_Div").toggle(700);
                $(this).toggleClass('class1')
            });
             $('#buttonReview').on('click', function(e){
                $("#review_Box_Div").toggle(700);
                $(this).toggleClass('class1')
            }); 
              /* 1. Visualizing things on Hover - See next part for action on click */
              $('#stars li').on('mouseover', function(){
                var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
               
                // Now highlight all the stars that's not after the current hovered star
                $(this).parent().children('li.star').each(function(e){
                  if (e < onStar) {
                    $(this).addClass('hover');
                  }
                  else {
                    $(this).removeClass('hover');
                  }
                });
                
              }).on('mouseout', function(){
                $(this).parent().children('li.star').each(function(e){
                  $(this).removeClass('hover');
                });
              });
                /* 2. Action to perform on click */
              $('#stars li').on('click', function(){
                var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                var stars = $(this).parent().children('li.star');
                
                for (i = 0; i < stars.length; i++) {
                  $(stars[i]).removeClass('selected');
                }
                
                for (i = 0; i < onStar; i++) {
                  $(stars[i]).addClass('selected');
                }
                
                // JUST RESPONSE (Not needed)
                var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
                var msg = "";
                if (ratingValue > 1) {
                    msg = "Thanks! You rated this " + ratingValue + " stars.";
                }
                else {
                    msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
                }
                $('#star_rating').val(ratingValue);
                // responseMessage(msg);                
              });  
    });
    $(document).on('click', '#submit_review', function() {
        setTimeout(function() {
            $("#reviewfrm").submit();
        }, 200);
    });
     function validateEmail(sEmail) {
            var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (filter.test(sEmail)) {
                return true;
            } else {
                return false;
            }
        }
</script>
@endsection