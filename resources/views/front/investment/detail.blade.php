@extends('layouts.app.front-app')
@section('title', 'Investment Detail - ' . env('APP_NAME'))
@php
$session_data = session('user');
// dd($session_data);
$chat_iSenderId = '';
$chat_iReceiverId = '';
$chat_vReceiverPersoneName = '';
$chat_connectionId = '';
$receiverPhoneNo = '';

$popup_vPhone = $popup_name = '';
$image = asset('uploads/default/no-profile.png');
if (!empty($session_data)) 
{
    $popup_vPhone = $session_data['vPhone'];
    $popup_name = $session_data['vFirstName'] . ' ' . $session_data['vLastName'];
    foreach ($connection_list as $main_key => $main_value) {
        /* if ($main_value->iSenderId == $session_data['iUserId']) { */
        if ($main_value->iReceiverId == $data->iUserId) {
            $chat_iSenderId = $main_value->iSenderId;
            $chat_iReceiverId = $main_value->iReceiverId;
            $chat_vReceiverPersoneName = $main_value->receiverName;
            if (!empty($main_value->receiverImage) && file_exists(public_path('uploads/user/' . $main_value->receiverImage))) {
                $image = asset('uploads/user/' . $main_value->receiverImage);
            }
            $receiverPhoneNo = $main_value->vReceiverMobNo;
        } elseif ($main_value->iSenderId == $data->iUserId) {
            $chat_iSenderId = $main_value->iSenderId;
            $chat_iReceiverId = $main_value->iReceiverId;
            $chat_vReceiverPersoneName = $main_value->senderName;
            if (!empty($main_value->senderImage) && file_exists(public_path('uploads/user/' . $main_value->senderImage))) {
                $image = asset('uploads/user/' . $main_value->senderImage);
            }
            $receiverPhoneNo = $main_value->vSenderMobNo;
        }
        $chat_connectionId = $main_value->iConnectionId;
    }
        $userToken = App\Helper\GeneralHelper::get_myAvailable_token($session_data['iUserId']);

}

$display_chat_btn = false;
// dd($investor_exist);
if (isset($investor_exist) && count($investor_exist) > 0) {
    $display_chat_btn = true;
}
if (isset($advisor_exist) && count($advisor_exist) > 0) {
    $display_chat_btn = true;
}
// $display_chat_btn = false;
@endphp
@section('content')
<style type="text/css">

  #sendMail {
        cursor:pointer;
    }
 
</style>

    <!-- banner section start -->
    <section class="bread-camp-detail lite-gray">
        <div class="container">
            <div class="bread-text-head">
                <h5><a href="{{ url('home') }}">Home </a>/<a href="{{ url('investment') }}"> Investments </a> /<a>
                        {{ $data->vBusinessProfileName }}</a></h5>
            </div>
        </div>
    </section>
    <!-- banner section end -->

    <!-- detail-inner-section start -->

    <section class="detail-inner-warp pb-5 lite-gray">
        <div class="container">
            <div class="row sticky-detail">
                <div class="col-md-10">
                    <div class="detail-heading">
                        <h2 class="mb-1">{{ $data->vBusinessProfileName }}</h2>
                    </div>
                    <div class="detail-heading">

                        <p class="mb-0" style="text-align: justify">
                            @php
                                $total_words = str_word_count($data->tBusinessProfileDetail);
                                $desc1 = $desc2 = '';
                                if ($total_words > 20) {
                                    $desc1 = implode(' ', array_slice(explode(' ', $data->tBusinessProfileDetail), 0, 20));
                                    $desc2 = implode(' ', array_slice(explode(' ', $data->tBusinessProfileDetail), 21));
                                } else {
                                    $desc1 = $data->tBusinessProfileDetail;
                                }
                            @endphp
                            {{ $desc1 }}
                            @if ($total_words > 20)
                                <span id="dots">...</span><span id="more"> {{ $desc2 }}</span><a onclick="myFunction()" id="myBtn" class="text-green pointer_cursor"> Read more</a>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div>
                        @if (isset($loginUserId))
                            @php
                                $availableProfile = '';
                                $availableProfile2 = '';
                                if (!empty($inInvestorCheckProfile)) {
                                    $availableProfile = 'Yes';
                                } else {
                                    $availableProfile = '';
                                }
                                if (!empty($inAdvisorCheckProfile)) {
                                    $availableProfile2 = 'Yes';
                                } else {
                                    $availableProfile2 = '';
                                }
                            @endphp
                            @if ($display_chat_btn && !$myOwnProfile)
                                <a href="javascript:;" class="btn btn-primary connection-btn-design chat-person-profile" data-isenderid="{{ $chat_iSenderId }}" data-ireceiverid="{{ $chat_iReceiverId }}" data-vreceivercontactpersonname="{{ $chat_vReceiverPersoneName }}" data-vReceiverContactPersonPhoneNo="{{ $receiverPhoneNo }}" data-iconnectionid="{{ $chat_connectionId }}" data-current_chat_profile_image="{{ $image }}">
                                    Chat
                                </a>
                            @elseif(($availableProfile == 'Yes' || $availableProfile2 == 'Yes') && !$myOwnProfile)
                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleModal1" class="btn btn-primary1 connection-btn-design yellow-btn">
                                    Contact Business
                                </a>
                            @elseif(!$myOwnProfile)
                                <a href="{{ url('dashboard') }}" class="btn btn-primary connection-btn-design">
                                    Update Your Profile
                                </a>
                            @endif
                        @else
                            <a href="{{ url('login') }}" class="btn btn-primary1 connection-btn-design yellow-btn">Contact
                                Business</a>
                        @endif
                        <!-- <a href="#" class="btn btn-primary new-btn-design">btn</a> -->
                    </div>
                </div>
            </div>
            <div class="detail-warp-box">

                <div class="row">
                    <div class="col-md-12">
                        @if (count($investmentBannerImg) > 0)
                        <div class="image-gallary">
                            <div class="image-large">
                                @php
                                    $first = '';
                                @endphp
                                @if (!empty($investmentBannerImg[0]->vImage))
                                    @php
                                        $first = 'uploads/investment/facility/' . $investmentBannerImg[0]->vImage;
                                    @endphp
                                @endif
                                <a data-fancybox="gallery" href="javascript:;">
                                    <img class="rounded" src="{{ asset($first) }}" />
                                </a>
                            </div>
                            @php
                                $display = 'none';
                                if (isset($investmentBannerImg[2])) {
                                    $display = 'block';
                                }
                            @endphp
                            <div class="image-small" style="display: {{ $display }};">
                                <div class="frist-img">
                                    @php
                                        $second = '';
                                    @endphp
                                    @if (!empty($investmentBannerImg[1]->vImage))
                                        @php
                                            $second = 'uploads/investment/facility/' . $investmentBannerImg[1]->vImage;
                                        @endphp
                                    @endif
                                    <a data-fancybox="gallery" href="javascript:;">
                                        <img class="rounded" src="{{ asset($second) }}" />
                                    </a>
                                </div>
                                <div class="overly-image">
                                    @php
                                        $third = '';
                                    @endphp
                                    @if (!empty($investmentBannerImg[2]->vImage))
                                        @php
                                            $third = 'uploads/investment/facility/' . $investmentBannerImg[2]->vImage;
                                        @endphp
                                    @endif
                                    <a data-fancybox="gallery" href="javascript:;">
                                        <img class="rounded" src="{{ asset($third) }}" />
                                    </a>
                                    {{-- <a href="" data-fancybox="gallery" class="overly-text">+2 more</a> --}}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-5 col-lg-5 col-md-5">
                        <div class="left-detail-part">
                            <div class="left-detail-warp">
                                <div class="detail-inner border-down">
                                    <h4>Established</h4>
                                    <h4>{{ $data->vBusinessEstablished }}</h4>
                                </div>
                                <div class="detail-inner border-down">
                                    <h4>Legal Entity</h4>
                                    <h4>
                                        @if ($data->eSoleProprietor == 'Yes')
                                            {{ 'Sole proprietor' }}
                                        @elseif($data->ePrivateCompany == 'Yes')
                                            {{ 'Private company' }}
                                        @elseif($data->eGeneralPartnership == 'Yes')
                                            {{ 'General partnership' }}
                                        @elseif($data->ePrivateLimitedCompany == 'Yes')
                                            {{ 'Public limited company' }}
                                        @elseif($data->eLLP == 'Yes')
                                            {{ 'Limited liability partnership (LLP)' }}
                                        @elseif($data->eSCorporation == 'Yes')
                                            {{ 'S corporation' }}`
                                        @elseif($data->eLLC == 'Yes')
                                            {{ 'Limited liability company (LLC)' }}
                                        @elseif($data->eCCorporation == 'Yes')
                                            {{ 'C corporation' }}
                                        @endif
                                    </h4>
                                    </li>
                                </div>

                                <div class="detail-inner border-down">
                                    <h4>Reported Sales</h4>
                                    <h4><span class="kes">KES</span>{{ $data->vMaxStakeSell }}</h4>
                                </div>

                                <div class="detail-inner border-down">
                                    <h4>Annual Revenue </h4>
                                    
                                    <h4><span class="kes">KES</span>{{ \App\Helper\GeneralHelper::rupees_format_thaousand_billion_million($data->vAverateMonthlySales) }}</h4>
                                </div>

                                <div class="detail-inner border-down">
                                    <h4>EBITDA Margin </h4>
                                    <h4>{{ $data->vProfitMargin }} %</h4>
                                </div>

                                <div class="detail-inner border-down">
                                    <h4>Industries </h4>
                                    <h4 class="yellow-color-common">
                                        @php
                                        $industry_tooltip = '';
                                        foreach ($industries as $key1 => $ivalue) 
                                        {
                                            if (count($industries)-1 > $key1) {
                                                $industry_tooltip.= $ivalue->vIndustryName.', ';
                                            }
                                            else{
                                                $industry_tooltip.= $ivalue->vIndustryName;
                                                }
                                         }
                                        @endphp

                                        @if (!empty($industries[0]->vIndustryName))
                                            {{ $industries[0]->vIndustryName }}
                                            @if (count($industries) > 1)
                                            <lable class='pointer_cursor' data-bs-toggle="tooltip" title="{{$industry_tooltip}}">
                                                + {{count($industries) - 1}} More
                                            </lable>                                                
                                            @endif
                                        @else
                                            {{ 'N/A' }}
                                        @endif

                                    </h4>
                                </div>
                                <div class="detail-inner border-down">
                                    <h4>Locations </h4>
                                    <div class="right-text yellow-color-common">
                                        <h6 class="mb-0">
                                            @php
                                            $location_tooltip = '';
                                            foreach ($location as $key1 => $lvalue) {
                                            if (count($location)-1 > $key1) {
                                                $location_tooltip.= $lvalue->vLocationName.', ';
                                            }
                                            else{
                                                $location_tooltip.= $lvalue->vLocationName;
                                            }
                                            }
                                            @endphp
                                            @if (!empty($location[0]->vLocationName))
                                            {{ $location[0]->vLocationName }}
                                            @if (count($location) > 1)
                                            <lable class='pointer_cursor' data-bs-toggle="tooltip" title="{{$location_tooltip}}">
                                                + {{count($location) - 1}} More
                                            </lable>
                                                <!-- + {{ count($location) - 1 }} More -->
                                            @endif
                                        @else
                                            {{ 'N/A' }}
                                        @endif</h6>
                                    </div>
                                </div>
                                <div class="detail-inner border-down">
                                    <h4>Local Time </h4>
                                    <h4>{{ date('G:i:s T') }}</h4>
                                </div>
                                <div class="detail-inner border-down">
                                    <h4>Listed By </h4>
                                    <h4>{{ $data->eBusinessProfile }}</h4>
                                </div>
                                <div class="detail-inner">
                                    <h4>Status</h4>
                                    <div class="right-text">
                                        <i class="fas fa-circle"></i>
                                        <span>{{ $data->eStatus }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-7 col-md-7">
                        <div class="company-detail">
                            <div class="rating">
                                <h2>Overall Rating</h2>
                            </div>
                            <div class="rating-detail-new">
                                <ul>
                                    <li class="rate"><i class="fas fa-star"></i></li>
                                    <li>
                                        <p>@if($data->vAverageRating == NULL || $data->vAverageRating == 0)
                                                {{'No Rating'}}
                                            @else
                                                {{$data->vAverageRating}}
                                            @endif </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="Seeking-detail mt-3">
                            <div class="heading">
                                <h2>Seeking Investment</h2>
                            </div>
                            <div class="options">
                                <ul>
                                    <li><label class="kes">KES</label> {{ \App\Helper\GeneralHelper::rupees_format_thaousand_billion_million($data->vInvestmentAmountStake) }}</li>
                                    <li class="mt-2">
                                        <p class="mb-0"><strong>Reason:</strong> Funds are required to set-up our business in a more popular location and expand our business. The valuation is based on our growth prospects.</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="company-detail mt-3">
                            <div class="Business-Name">
                                <h2>Business Name</h2>
                            </div>
                            <div class="Business-Name-detail">
                                <ul>
                                    <li>
                                        @if ($profileVisible)
                                            {{ $data->vBusinessName }}
                                        @else
                                           <i class="far fa-clock"></i> Available after connect
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="company-detail mt-3">
                            <div class="other-info">
                                <h2>Name, Phone, Email</h2>                                
                            </div>
                            <div class="other-info-detail">
                                <ul>
                                    <li class="name-phone-mail-detail">
                                        @if ($profileVisible)
                                           {{ $data->vFirstName }}{{ $data->vLastName }}, 
                                           {{ $data->vPhone }} ,
                                           {{ $data->vEmail }}
                                        @else
                                            <i class="far fa-clock"></i> Available after connect
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="company-detail mt-3">
                            <div class="other-info">
                                <h2>User Verification</h2>
                                <p style="display:none;">Available after connect</p>
                            </div>
                            <div class="social-info-detail">
                                <ul>
                                    <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Email Verified"><i class="fal fa-envelope"></i>Email</a></li>
                                    <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Phone Verified"><i class="far fa-phone-alt"></i>Phone</a></li>
                                    {{-- <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Google Verified"><i class="fab fa-google-plus-g"></i> Google</a></li>
                                    <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Not Linkdin Verified" class="disable"><i class="fab fa-linkedin"></i> Linkdin</a></li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    @if ($profileVisible)
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="left-detail-warp mt-4">
                                <div class="document-warp">
                                    @if (count($investmentDocuments) > 0)
                                        <h2>Documents</h2>
                                        <ul>
                                            @php
                                                $title = '';
                                                $i = 1;
                                            @endphp

                                            @foreach ($investmentDocuments as $key => $value)
                                                @if ($value->eType == 'business_proof')
                                                    <li>
                                                        <h6>{{ $title = 'Business Proof' }}</h6>
                                                        <a href="{{ asset('uploads/investment/business_proof') . '/' . $value->vImage }}" download>
                                                            <img src="{{ asset('uploads/front/investment/pdf.png') }}" alt="">Business
                                                            Proof {{ $key + 1 }}</a>
                                                    </li>
                                                @endif
                                                @if ($value->eType == 'yearly_sales_report')
                                                    <li>
                                                        <h6>{{ $title = 'Yearly Sales Report' }}</h6>
                                                        <a href="{{ asset('uploads/investment/yearly_sales_report') . '/' . $value->vImage }}" download>
                                                            <img src="{{ asset('uploads/front/investment/pdf.png') }}" alt="">Yearly Sales
                                                            Report {{ $i++ }}</a>
                                                    </li>
                                                @endif

                                                @if ($value->eType == 'NDA')
                                                    <li>
                                                        <h6>{{ $title = 'NDA' }}</h6>
                                                        <a href="{{ asset('uploads/investment/NDA') . '/' . $value->vImage }}" download>
                                                            <img src="{{ asset('uploads/front/investment/pdf.png') }}" alt="">NDA
                                                            {{ $i++ }}</a>
                                                    </li>
                                                @endif
                                                @if ($value->eType == 'fast_verification')
                                                    <li>
                                                        <h6>{{ $title = 'fast_verification' }}</h6>
                                                        <a href="{{ asset('uploads/investment/fast_verification') . '/' . $value->vImage }}" download>
                                                            <img src="{{ asset('uploads/front/investment/pdf.png') }}" alt="">fast_verification {{ $i++ }}</a>
                                                    </li>
                                                @endif
                                                @if ($value->eType != 'business_proof' || $value->eType != 'NDA' || $value->eType != 'yearly_sales_report' || $value->eType == 'fast_verification')
                                                    {{ $title = '' }}
                                                @endif
                                            @endforeach

                                            @if (!empty($title))
                                                {{ $title }}
                                            @endif

                                        </ul>
                                    @else
                                        {{ 'Document not found' }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="Seeking-detail mt-4">
                            <div class="heading">
                                <h2>Transaction Preference</h2>
                            </div>
                            <div class="options">
                                <ul>
                                    @if ($data->eFullSaleBusiness == 'Yes')
                                        <li>{{ 'Full sale of business' }}</li>
                                    @endif

                                    @if ($data->ePartialSaleBusiness == 'Yes')
                                        <li>{{ 'Partial sale of business/Investment' }}</li>
                                    @endif

                                    @if ($data->eLoanForBusiness == 'Yes')
                                        <li>{{ 'Loan for business' }}</li>
                                    @endif

                                    @if ($data->eBusinessAsset == 'Yes')
                                        <li>{{ 'Selling or leasing out business asset' }}</li>
                                    @endif

                                    @if ($data->eBailout == 'Yes')
                                        <li>{{ 'Distressed company looking for bailout' }}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="Seeking-detail mt-3">
                            <div class="heading">
                                <h2>Business Overview</h2>
                            </div>
                            @php
                                $total_words_businessHighLights = str_word_count($data->tBusinessHighLights);
                                $desc1_business_highLights = $desc2_business_highLights = '';
                                if ($total_words_businessHighLights > 20) {
                                    $desc1_business_highLights = implode(' ', array_slice(explode(' ', $data->tBusinessHighLights), 0, 20));
                                    $desc2_business_highLights = implode(' ', array_slice(explode(' ', $data->tBusinessHighLights), 21));
                                } else {
                                    $desc1_business_highLights = $data->tBusinessHighLights;
                                }
                            @endphp
                            <div class="options">
                                <ul>
                                    <li>
                                        {{ $desc1_business_highLights }}
                                        @if ($total_words_businessHighLights > 20)
                                            <span id="dots_businessHighLights">...</span><span class="more_span" id="more_businessHighLights">
                                                {{ $desc2_business_highLights }}</span><a onclick="read_more_less_text('dots_businessHighLights','more_businessHighLights','myBtn_businessHighLights')" id="myBtn_businessHighLights" class="text-green pointer_cursor">
                                                Read more</a>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="Seeking-detail mt-3">
                            <div class="heading">
                                <h2>Products & Services Overview</h2>
                            </div>
                            @php
                                $total_words_tListProductService = str_word_count($data->tListProductService);
                                $desc1_tListProductService = $desc2_tListProductService = '';
                                if ($total_words_tListProductService > 20) {
                                    $desc1_tListProductService = implode(' ', array_slice(explode(' ', $data->tListProductService), 0, 20));
                                    $desc2_tListProductService = implode(' ', array_slice(explode(' ', $data->tListProductService), 21));
                                } else {
                                    $desc1_tListProductService = $data->tListProductService;
                                }
                            @endphp
                            <div class="col-md-12">
                                <div class="options">
                                    <ul>
                                        <li>
                                            {!! $desc1_tListProductService !!}
                                            @if ($total_words_tListProductService > 20)
                                                <span id="dots_ListProductService">...</span><span class="more_span" id="more_ListProductService">
                                                    {!! $desc2_tListProductService !!}</span><a onclick="read_more_less_text('dots_ListProductService','more_ListProductService','myBtn_ListProductService')" id="myBtn_ListProductService" class="text-green pointer_cursor">
                                                    Read more</a>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="Seeking-detail mt-3">
                            <div class="heading">
                                <h2>Facilities Overview</h2>
                            </div>
                            @php
                                $total_words_tFacility = str_word_count($data->tFacility);
                                $desc1_tFacility = $desc2_tFacility = '';
                                if ($total_words_tFacility > 20) {
                                    $desc1_tFacility = implode(' ', array_slice(explode(' ', $data->tFacility), 0, 20));
                                    $desc2_tFacility = implode(' ', array_slice(explode(' ', $data->tFacility), 21));
                                } else {
                                    $desc1_tFacility = $data->tFacility;
                                }
                            @endphp
                            <div class="col-md-12">
                                <div class="options">
                                    <ul>
                                        <li>
                                            {!! $desc1_tFacility !!}
                                            @if ($total_words_tFacility > 20)
                                                <span id="dots_tFacility">...</span><span class="more_span" id="more_tFacility"> {!! $desc2_tFacility !!}</span><a onclick="read_more_less_text('dots_tFacility','more_tFacility','myBtn_tFacility')" id="myBtn_tFacility" class="text-green pointer_cursor"> Read
                                                    more</a>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!----review form--->
                @if (isset($loginUserId))
                @php
                    $availableProfile = '';
                    $availableProfile2 = '';
                    if (!empty($inInvestorCheckProfile)) {
                        $availableProfile = 'Yes';
                    } else {
                        $availableProfile = '';
                    }
                    if (!empty($inAdvisorCheckProfile)) {
                        $availableProfile2 = 'Yes';
                    } else {
                        $availableProfile2 = '';
                    }
                @endphp
                @if ($display_chat_btn && !$myOwnProfile && (!$myOwnProfile))                     
                            <div class="col-md-12">
                                <div class="Seeking-detail mt-3">
                                    <div class="heading toggle-heading">
                                        <!-- <h2>Review</h2> -->
                                         <button id = "buttonAddReview">Write Review</button>
                                    </div>
                                    <div id="review_AddBox_Div" style="display:none;"> 
                                    <form id="reviewfrm" action="{{ url('investment-review') }}" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="{{$data->vUniqueCode}}">
                                        <input type="hidden" id="iInvestmentProfileId" name="iInvestmentProfileId" value="{{$data->iInvestmentProfileId}}">
                                        <input type="hidden" id="iUserId" name="iUserId" value="{{$session_data['iUserId']}}">
                                        <input type="hidden" name="star_rating" id="star_rating" value="@if(!empty($my_review_data->iRating)){{$my_review_data->iRating}}@endif" >
                                    @csrf
                                    <div id="full-stars-example">
                                         <div class="detail-form">
                                            <div class="row">
                                                <div class="col-md-12 mt-2">
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
            <!---view review start--->
             @if(count($review_data) > 0)
                <div class="col-md-12">
                  <div class="Seeking-detail mt-3">
                    <div class="heading toggle-heading">
                        <h2 class="mb-0">Rating Overview</h2> 
                        <button id="buttonReview" >View Details</button>
                    </div>
                    <div id="review_Box_Div" style="display:none;">
                    @foreach ($review_data as $key => $review_value)
                        @if(!empty($session_data))
                            @if($review_value->iUserId != $session_data['iUserId']) 
                               <div class="col-md-12">
                                    <div class="options">
                                            {{$review_value->vFirstName}} {{$review_value->vLastName}}
                                            {{$review_value->iRating}}
                                            <br>                                                  
                                           <section class='rating-widget'>
                                                <div class='rating-stars'>
                                                    <ul id='stars1'>
                                                        @for ($i = 1; $i <= 5; $i++)
                                                        <li class="star @if($i <= $review_value->iRating){{'selected'}}@endif" data-value='{{$i}}'>
                                                            <i class='fa fa-star fa-fw'></i>
                                                        </li>
                                                        @endfor
                                                    </ul>
                                                </div>
                                            </section><br>
                                        <p class="review-output-text"> {{$review_value->vReview}}</p>                                         
                                    </div>
                                </div>
                                <hr>
                                @endif
                                @else
                                 <div class="col-md-6" >
                                    <div class="options">
                                     {{$review_value->vFirstName}} {{$review_value->vLastName}}
                                        <br>                                                    
                                       
                                       <section class='rating-widget'>
                                        <div class='rating-stars'>
                                            <ul id='stars1'>
                                                @for ($i = 1; $i <= 5; $i++)
                                                <li class="star @if($i <= $review_value->iRating){{'selected'}}@endif" data-value='{{$i}}'>
                                                    <i class='fa fa-star fa-fw'></i>
                                                </li>
                                                @endfor
                                            </ul>
                                        </div>
                                    </section><br>
                                    <p class="review-output-text"> {{$review_value->vReview}}</p>                                            
                                    </div>
                                </div><hr>
                              @endif
                            @endforeach
                        </div>
                      </div>
                    </div>
                @endif
            <!---view review end--->

                {{-- dashboard_left panel for chat window start --}}
                <div style="display: block">
                    @include('layouts.front.left_dashboard')
                </div>
                {{-- dashboard_left panel for chat window end --}}
                <!-- left-text -->
                <div class="col-xl-4 col-lg-12 mt-2">
                    <div class="row">

                        <form id="frm" action="{{ url('investment-token-store') }}" method="POST" enctype="multipart/form-data">
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
                                                <div class="col-lg-6">
                                                    <div class="model-frist-image">
                                                        <img src="{{ asset('front/assets/images/detail-model-1.png') }}" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="contace-business-model-detail">
                                                        <h2>Contact Business</h2>
                                                       
                                                        <p class="mb-0">A small number of tokens will be deducted from your account as a connection fee.</p>

                                                        <div>
                                                            <input type="hidden" name="profileType" id="profileType">
                                                            <input type="hidden" name="profileId" id="profileId">
                                                            <input type="hidden" name="profileDetail" id="profileDetail">
                                                            <input type="hidden" name="contactname" id="contactname">
                                                            @if (!empty($inInvestorCheckProfile))
                                                                <div class="mb-2 mt-2">
                                                                    <label class="fon-weight-bold">Investor Profile </label>
                                                                    <div class="form-check mt-3">

                                                                        <input class="form-check-input fillValue" id="investor_profile_name" name="profile_name" type="radio" value="{{ $inInvestorCheckProfile->iInvestorProfileId }}" data-name="{{ $inInvestorCheckProfile->vInvestorProfileName }}" data-phone="{{ $inInvestorCheckProfile->vPhone }}" data-type="Investor" data-profileid="{{ $inInvestorCheckProfile->iInvestorProfileId }}"
                                                                            data-contactname="{{ $inInvestorCheckProfile->vFirstName }}" data-profileDetail="{{ $inInvestorCheckProfile->tInvestorProfileDetail }}">
                                                                        <label class="form-check-label" for="investor_profile_name">
                                                                            {{ $inInvestorCheckProfile->vInvestorProfileName }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if (!empty($inAdvisorCheckProfile))
                                                                <div class="mb-2">
                                                                    <label class="fon-weight-bold">Advisor Profile </label>
                                                                    <div class="form-check mt-3">
                                                                        <input class="form-check-input fillValue" id="advisor_profile_name" name="profile_name" type="radio" value="{{ $inAdvisorCheckProfile->vAdvisorProfileTitle }}" data-name="{{ $inAdvisorCheckProfile->vAdvisorProfileTitle }}" data-phone="{{ $inAdvisorCheckProfile->vPhone }}" data-type="Advisor" data-profileid="{{ $inAdvisorCheckProfile->iAdvisorProfileId }}"
                                                                            data-contactname="{{ $inAdvisorCheckProfile->vFirstName }}" data-profileDetail="{{ $inAdvisorCheckProfile->tAdvisorProfileDetail }}">
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
                                                            <div id="fName_error" class="error mt-1" style="color:red;display: none;">Please enter your name
                                                            </div>
                                                        </div>

                                                        <div class="mt-2">
                                                            <label for="phone">Your Mobile Number</label>
                                                            <input type="text" name="phone" id="phone" class="form-control numeric" value="{{$popup_vPhone}}" maxlength="10" placeholder="Please enter your phone number">
                                                            <div id="phone_error" class="error mt-1" style="color:red;display: none;">Please enter your phone
                                                                number</div>
                                                        </div>

                                                        <div class="mt-2">
                                                            <label for="floatingTextarea2">Comments</label>
                                                            <textarea class="form-control" name="comments" id="comments" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                                                            <div id="comments_error" class="error mt-1" style="color:red;display: none;">Please leave a message to
                                                                the business</div>
                                                        </div>

                                                        <div class="form-check mt-3">
                                                            <input class="form-check-input accept" type="checkbox" value="Yes" name="term" id="flexCheckDefault">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                I accept the <a href="#">Terms of Engagement</a>
                                                            </label>
                                                            <div id="accept_error" class="error mt-1" style="color:red;display: none;">Please accept the terms of
                                                                engagement</div>
                                                        </div> -->
                                                        
                                                         @if(!empty($userToken) && $userToken->iTotalToken == 0)
                                                            <p class="mb-0" style="color: red;font-size: large;">You don't have sufficiant token</p>
                                                        @else
                                                        <div class="mt-2">
                                                            <div class="alert alert-danger" id="myAlert">
                                                              <strong>Info!</strong> after sending request it will deduct one connect from your account.
                                                            </div>
                                                        </div>
                                                        <div class="send-model-btn text-center">
                                                            <a href="javascript:;" id="sendConnection" class="submit">Send Now</a>
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
                </div>
                <!-- left-text-end -->
            </div>
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
                                <input type="text" class="form-control" id="vEmail" name="vEmail" placeholder="Email" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <!-- <span class="input-group-text" id="sendMail" data-bs-target="#exampleModal12" >Send</span> -->
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

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
                    /*$('#exampleModal12').css("display", "block");
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
            /* var intrestCheckbox = $(".intrestCheckbox:checkbox:checked").length; */
            /*var fName = $("#fName").val();
            var phone = $("#phone").val();
            var comments = $("#comments").val();
            var accept = $(".accept:checkbox:checked").length;*/


            /* if (intrestCheckbox <= 0) {
                $("#intrestedIn_error").show();
            } else {
                $("#intrestedIn_error").hide();
            } */
          /*  if (fName.length == 0) {
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
                error = true;
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
             //radiobutton  click fill detail

        $(document).ready(function() 
        {
            $('.fillValue').change(function() {
                var name = $(this).data("name");
                var phone = $(this).data("phone");
                var profileType = $(this).data("type");
                var contactname = $(this).data("contactname");
                var profileid = $(this).data("profileid");
                var profileDetail = $(this).data("profiledetail");
                console.log(profileDetail);
                /* $('#fName').val(name); */
                $('#profileType').val(profileType);
                $('#profileId').val(profileid);
                $('#profileDetail').val(profileDetail);
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
        $(document).on('click','.close-deal', function() {
            var loginUserId = $(this).data("id");
            var iProfileId = $(this).data("profile");
            var vUniqueCode = $('#vUniqueCode').val();

            $.ajax({
                url: "{{ url('close-deal') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    loginUserId: loginUserId,
                    iProfileId: iProfileId,
                    vUniqueCode: vUniqueCode
                },
                success: function(response) {
                         Toast.fire({
                        icon: 'success',
                        title: 'Deal successfully closed'
                        })
                        
                   
                }
            });
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



