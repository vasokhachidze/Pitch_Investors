@extends('layouts.app.front-app')
@section('title', 'Home ' . env('APP_NAME'))
<style>
    #transparent-bg{
	position: fixed; 
	top: 0%; 
	left: 0%; 
	width: 100%; 
	height: 100%; 
	background:#000;
	-moz-opacity: 0.30; 
	opacity: .30; 
	filter: alpha(opacity=30);
	z-index: 1000; 
	-webkit-animation: animateBackground 1s;
	animation: animateBackground 1s ;
}
.contace-business-model-detail {
    padding:15px !important;
}
.sub-label {
    /* Other styling... */
    text-align: right;
    clear: both;
    float:left;
    margin-right:15px;
    margin-top:7px;
}
.rounded-pill {
    width: 85% !important;
}
.send-model-btn {
    margin-bottom : 20px;
}
#sendConnection {
    
    border-radius: 25px;
}
.contact-business-model-frist .modal-dialog{
  max-width: 680px !important;
}
#exampleModal10 .modal-dialog{
  max-width: 680px !important;
}

.remove_nav .owl-nav{
    display:none !important; 
}

.remove_nav .owl-dots{
    display:block !important; 
    padding-top:10px; 
}

.remove_nav .owl-dot span{
    background-color:#2B7090 !important;
    width:16px !important;
    height:16px !important;
}
.catergorie-list{
    position: relative;
}

@media only screen and (max-width: 600px) {
    .catergorie-list::before{
        content:'';
        position:absolute;
        width:1px;
        height:65%;
        background-color:#2B7090;
        bottom:1;
        transform:rotate(64deg);
        transform-origin: bottom center;
    }

    .catergorie-list::after{
        content:'';
        position:absolute;
        width:1px;
        height:65%;
        background-color:#2B7090;
        bottom:1;
        transform:rotate(-64deg);
        transform-origin: bottom center;
    }
}

@media only screen and (max-width: 2500px) {
    .catergorie-list::before{
        content:'';
        position:absolute;
        width:1px;
        height:65%;
        background-color:#2B7090;
        bottom:1;
        transform:rotate(60deg);
        transform-origin: bottom center;
    }

    .catergorie-list::after{
        content:'';
        position:absolute;
        width:1px;
        height:65%;
        background-color:#2B7090;
        bottom:1;
        transform:rotate(-60deg);
        transform-origin: bottom center;
    }

    .testmonail-item::before{
        display:none !important;
    }

    .testmonail-item{
        background: #FFFFFF;
        border-bottom: 2px solid #2B7292;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
}
</style>
@section('content')
<div id="transparent-bg" style="display: none;"></div>
    <!-- {{ asset('uploads/front/count/green-count.jpg') }} -->
    <!-- banner start -->
    <div class="banner-slider-wrapper old-slider-home">
        <div class="banner-slider owl-carousel owl-theme" data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-in-sine">
            @foreach ($banner as $key => $vbanner)
                @php
                    $Bannerimage = asset('uploads/default/no-image.png');
                    if (isset($vbanner)) {
                        if ($vbanner->vBannerImage != '') {
                            $Bannerimage = asset('uploads/banner/' . $vbanner->vBannerImage);
                        }
                    }
                @endphp
                <div class="item">
                    <div class="main-banner mb-0" style="background-image:url('{{ $Bannerimage }}');">
                        <div style="padding-left:100px;">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 me-auto">
                                    <div class="left-text" data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-in-sine">
                                        <h1>{{ $vbanner->vBannerTitle }}</h1>
                                        <h4 class="pb-2">Welcome to PitchInvestors, the leading platform</h4>

                                        <p style="text-align: justify; font-size: 14px;"> {{ $vbanner->vSubTitle }}</p>

                                        <div class="" style="background-color:#66BA62; width: 255px; height:45px;">
                                            <a class="w-100 h-100 signup d-flex align-items-center justify-content-center text-white" style="color:#313538; font-size:18px; font-weight: 500;" href="{{ url('register') }}">Sign Up Now</a>
                                        </div>

                                        <!-- <div class="topbtn-group">
                                            <ul class="m-0 p-0 list-unstyled">
                                                <li>
                                                    <a href="{{ url('investment') }}" class="yellow-btn">
                                                        Investments
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="{{ url('advisor') }}" class="green-btn">
                                                        Advisors
                                                    </a>
                                                </li>
                                                
                                                <li>
                                                    <a href="{{ url('investor') }}" class="blue-btn">
                                                        Investors
                                                    </a>
                                                </li>
                                            </ul>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="banner-slider-wrapper new-responsive-add">
        <div class="banner-slider owl-carousel owl-theme" data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-in-sine">
            @foreach ($banner as $key => $vbanner)
                @php
                    $Bannerimage = asset('uploads/default/no-image.png');
                    if (isset($vbanner)) {
                        if ($vbanner->vBannerImage != '') {
                            $Bannerimage = asset('uploads/banner/' . $vbanner->vBannerImage);
                        }
                    }
                @endphp
                <div class="item">
                    <div class="main-banner" style="padding-top:49px; height:85% !important;">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 me-auto p-0">
                                    <div class="main-image-banner">
                                        <img src="{{ $Bannerimage }}" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 me-auto">
                                    <div class="left-text" data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-in-sine">
                                        <h1>{{ $vbanner->vBannerTitle }}.</h1>
                                        <p style="text-align: justify; font-size: 14px;"> {{ $vbanner->vSubTitle }}.</p>

                                        <div class="d-flex justify-content-center" style="background-color:#66BA62; width: 255px; height:45px;">
                                            <a class="w-100 h-100 signup d-flex align-items-center justify-content-center text-white" style="color:#313538; font-size:18px; font-weight: 500;" href="{{ url('register') }}">Sign Up Now</a>
                                        </div>

                                        <!-- <div class="topbtn-group">
                                            <ul class="m-0 p-0 list-unstyled">
                                                <li>
                                                    <a href="{{ url('investment') }}" class="yellow-btn">
                                                        Investments
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('advisor') }}" class="green-btn">
                                                        Advisors
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ url('investor') }}" class="blue-btn">
                                                        Investors
                                                    </a>
                                                </li>
                                            </ul>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </a>
    <!-- banner End -->
    <!-- banner second start-->
    <section class="banner-second right-shape pt-3" style="background: #F0F0F0;">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 text-center m-auto" data-aos="fade-down" data-aos-duration="800">
                    <h2>
                        Explore our pre-approved investors and get in touch today
                    </h2>

                    <p>The first step in getting investors is letting them know about your business. Explore a list of pre-approved investors who have been carefully vetted and are looking for opportunities to invest in businesses that align with their goals and criteria.
                    </p>
                </div>
            </div>
            <!-- mid-counter section -->
            <div class="mid-counter-main mb-4">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 align-self-end">
                        <div class="min-count-wrapper p-4 py-5 d-flex justify-content-center" style="background: #FFFFFF; border-bottom: 2px solid #2B7292; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
                            <div class="right-desc">
                                <h3 class="yellow-color text-center">{{ $investment_count[0]->total_investment }} +</h3>

                                <p class="text-center">
                                    Investments to choose from
                                </p>

                                <div class="left-img-1 text-center" data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-in-sine">
                                    <img style="width:100px; height:100px;" src="{{ asset('/front/assets/images/explore_icon_one.svg') }}" >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 align-self-end">
                        <div class="min-count-wrapper p-4 py-5 d-flex justify-content-center" style="background: #FFFFFF; border-bottom: 2px solid #2B7292; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
                            <div class="right-desc">
                                <h3 class="yellow-color text-center">{{ $investor_count[0]->total_investor }} +</h3>

                                <p class="text-center">
                                    Investors on our website
                                </p>

                                <div class="left-img-1 text-center" data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-in-sine">
                                    <img style="width:100px; height:100px;" src="{{ asset('/front/assets/images/explore_icon_third.svg') }}" >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 align-self-end">
                        <div class="min-count-wrapper p-4 py-5 d-flex justify-content-center" style="background: #FFFFFF; border-bottom: 2px solid #2B7292; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
                            <div class="right-desc">
                                <h3 class="yellow-color text-center">{{ $advisor_count[0]->total_advisor }} +</h3>

                                <p class="text-center">
                                    Advisors to choose from
                                </p>

                                <div class="left-img-1 text-center" data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-in-sine">
                                    <img style="width:100px; height:100px;" src="{{ asset('/front/assets/images/explore_icon_second.svg') }}" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 text-end m-auto pt-sm-5" data-aos="fade-down" data-aos-duration="800">
                    <a href="{{ url('investor') }}" class="green-btn">
                        Explore Investors
                    </a>
                </div>
            </div>
            <!-- mid-counter End -->
        </div>

        <div class="col-xl-4 col-lg-12 mt-2">
            <div class="row">
                <input type="hidden" name="vUniqueCode" id="vUniqueCode" value="">
                <div class="modal  contact-business-model-frist" id="exampleModal10" style = "display:none;" tabindex="-1" aria-labelledby="exampleModalLabel" >
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close closeModel" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body contact-business-model p-0">
                                <div class="row">                                                
                                    <div class="col-lg-12">                                                    
                                        <div class="contace-business-model-detail">
                                            <h2 style="text-align:center">Get Access to Exclusive Investment Opportunities!</h2>                                                       
                                            <p class="mb-2" style="text-align:center">Join our investment community and stay up-to-date on the latest investment opportunities, news, and events. Sign up today to get exclusive insights and resources to help you make informed investment decisions</p>   
                                            <div style="margin-top:40px">
                                                <div class="mb-2 mt-2">                                                                    
                                                    <div class="form-check mt-3">
                                                        <label class="fon-weight-bold sub-label">Name </label>
                                                        <input class="form-control rounded-pill" id="name" name="name" type="text" placeholder="Name" onkeyup="if($(this).val() != ''){ $('#sub_name').hide()}">
                                                        <span id="sub_name" style="color: red;margin-left:57px;display:none"></span>
                                                    </div>
                                                </div>                                                        
                                                <div class="mb-2 mt-4">                                                                    
                                                    <div class="form-check mt-3">
                                                        <label class="fon-weight-bold sub-label">Email </label>
                                                        <input class="form-control rounded-pill" id="email" name="email" type="text"placeholder="Email" onkeyup="if($(this).val() != ''){ $('#sub_email').hide()}">
                                                        <span id="sub_email" style="color: red;margin-left:57px;display:none"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="vEmail_error" class="error mt-1" style="color:red;display: none;">Please Enter Email </div>
                                            <div id="vEmail_valid_error" class="error_show" style="color:red;display: none;">Please Enter Valid Email</div>
                                            <div class="send-model-btn text-center">
                                                <a href="javascript:;" onclick="subscribe()" id="sendConnection" class="submit">Subscribe</a>
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
        </div>
    </section>
    <!-- why choose section -->
    <section class="pt-xl-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 order-xl-1 order-2 pt-xl-0 pt-4">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <h2 style="color: #2B7090; font-weight:500;" class="d-flex align-items-center">
                                <div class="green_block me-3" style="width: 30px; height:30px; background: #66BA62;"></div>
                                Why Choose Pitchinvestors
                            </h2>
                        </div>

                        <div class="col-12">
                            <h4 style="font-size: 19px;">Preapproved and Confirmed Businesses</h4>

                            <p style="font-size: 15px;">Our platform ensures that all businesses listed on PitchInvestors are thoroughly vetted, preapproved, and confirmed on the ground. This means that you can trust that the businesses you find on our platform have gone through a rigorous screening process, giving you confidence in their credibility and potential.</p>
                        </div>

                        <div class="col-12">
                            <h4 style="font-size: 19px;">Access to a Wide Network of Investors</h4>

                            <p style="font-size: 15px;">By listing your business on PitchInvestors, you gain access to a diverse community of investors actively seeking investment opportunities. Our platform connects you with potential investors who are interested in supporting and growing businesses like yours, increasing your chances of securing funding.</p>
                        </div>

                        <div class="col-12">
                            <h4 style="font-size: 19px;">Expert Guidance and Support</h4>

                            <p style="font-size: 15px;">We provide valuable resources, guidance, and tools to help you refine your business pitch and effectively communicate the potential of your venture to investors. Our team is dedicated to supporting you throughout the process, offering insights and advice to enhance your chances of success</p>
                        </div>

                        <div class="col-12">

                        <h4 style="font-size: 19px;">Increased Visibility and Exposure</h4>

                        <p style="font-size: 15px;">By showcasing your business on PitchInvestors, you gain greater visibility and exposure to a targeted audience of investors specifically looking for investment opportunities. This exposure can significantly expand your reach and increase your chances of attracting potential investors who align with your business goals.</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 order-xl-2 order-1">
                    <img class="w-100" src="{{ asset('/front/assets/images/comp.png') }}" >
                </div>
            </div>
        </div>
    </section>
    <!-- why choose section end -->

    <!-- banner secon end -->
    @if (count($investment_data) > 0)
        <!-- Business for sale slider -->
        <section class="business-slider-wrapper mini-sliders yellow-slider left-shape py-5 mb-0" style="background: #F0F0F0;">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 style="color: #2B7090; font-weight:500;" class="d-flex align-items-center mb-3">
                            <div class="green_block me-3" style="width: 30px; height:30px; background: #66BA62;"></div>
                            Investments
                        </h2>
                    </div>

                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <div class="business-for-sale-slider owl-carousel owl-theme remove_nav" data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-in-sine">
                            <!-- item-1 -->
                            @foreach ($investment_data as $key => $value)
                                @php
                                    $current_image = '';
                                    $current_image_status = '';
                                @endphp
                                @if (!empty($value->vImage) && file_exists(public_path('uploads/investment/profile/' . $value->vImage)))
                                    @php
                                        $current_image = 'uploads/investment/profile/' . $value->vImage;
                                    @endphp
                                @else
                                    @php
                                        $current_image_status = 'w-100';
                                        $current_image = 'uploads/no-image.png';
                                    @endphp
                                @endif

                                @php
                                    $locationName = 'N/A';
                                    foreach ($location_investment as $key_1 => $value_location) {
                                        foreach ($value_location as $key1 => $value1) {
                                            if ($value1->eLocationType == 'Sub County' && $value->iInvestmentProfileId == $value1->iInvestmentProfileId) {
                                                $locationName = $value1->vLocationName;
                                            }
                                        }
                                    }
                                @endphp
                                
                                <div class="item">
                                    <div class="row g-12">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            {{-- <div class="bussines-box-wrapper">
                                                <div class="box-header">
                                                    <h5 class="box-title">{{ $value->vBusinessName }}. </h5>
                                                    <div class="box-logo">
                                                        <img src="{{ asset($current_image) }}">
                                                    </div>
                                                    <p class="box-desc">
                                                        @if (!empty($value->tBusinessDetail))
                                                            {{ strip_tags($value->tBusinessDetail) }}
                                                        @else
                                                            {{ 'N/A' }}
                                                        @endif
                                                    </p>
                                                    <ul class="box-rating">
                                                        <li class="rating">
                                                            <p class="m-0"><i class="fas fa-star"></i>
                                                            @if ($value->vAverageRating == null || $value->vAverageRating == 0)
                                                                    {{'No Rating'}}
                                                                @else
                                                                    {{$value->vAverageRating}}
                                                                @endif
                                                            </p>
                                                        </li>
                                                        <li class="location">
                                                            <p class="m-0"><i class="fas fa-map-marker-alt"></i>
                                                                  @php
                                                                $nullValue = '';
                                                            @endphp
                                                            @foreach ($location_investment as $key => $lvalue)
                                                                @if (!empty($lvalue[0]->vLocationName) && $lvalue[0]->iInvestmentProfileId == $value->iInvestmentProfileId)
                                                                    {{ $lvalue[0]->vLocationName }}
                                                                    @if (count($lvalue) > 1)
                                                                        + {{ count($lvalue) - 1 }} More
                                                                    @endif
                                                                @else
                                                                    @php
                                                                        $nullValue = 'N/A';
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            @if (!empty($nullValue))
                                                                {{ $nullValue }}
                                                            @endif
                                                            </p>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="box-body yellow-1">
                                                    <p class="m-0">Financial Investment</p>
                                                    <h5 class="left-title">
                                                        @if (!empty($value->vInvestmentAmountStake))
                                                           {{ \App\Helper\GeneralHelper::rupees_format_thaousand_billion_million($value->vInvestmentAmountStake) }}
                                                        @else
                                                            {{ 'N/A' }}
                                                        @endif
                                                    </h5>
                                                </div>

                                                <div class="box-body yellow-2">
                                                    <p class="m-0">Run Rate Sales</p>
                                                    <h5 class="left-title">
                                                        @php
                                                        $avgSales= str_replace(',', '', $value->vAverateMonthlySales);
                                                        @endphp
                                                        @if (!empty($value->vAverateMonthlySales))
                                                            {{ \App\Helper\GeneralHelper::rupees_format_thaousand_billion_million($value->vAverateMonthlySales) }}
                                                        @else
                                                            {{ 'N/A' }}
                                                        @endif
                                                    </h5>
                                                </div>
                                                <div class="box-body yellow-3">
                                                    <p class="m-0">EBITDA Margin</p>
                                                    <h5 class="left-title">
                                                        @if (!empty($value->vProfitMargin))
                                                            {{ $value->vProfitMargin }} %
                                                        @else
                                                            {{ 'N/A' }}
                                                        @endif
                                                    </h5>
                                                </div>
                                            </div> --}}

                                            <div class="business-detail-box border-0">
                                                <img src="{{ asset('/front/assets/images/image_test.png') }}" style="pointer-events:none; top:30px; width: 100%;">
                                                <div class="frist-box" style="cursor: pointer;">
                                                    <!-- <div class="status-bar-name">
                                                        <a href=""><i class="fas fa-circle"></i> Serviced Apartment Investment Opportunity in Pune, India</a>
                                                    </div> -->
                                                    

                                                    <a class='detailPageLink' href="{{ route('front.investment.detail', $value->vUniqueCode) }}">
                                                        <h2 class="listing-titles mb-0 py-2" style="color: #2B7292; font-size: 20px; min-height:24px;">
                                                            @if (!empty($value->vBusinessProfileName))
                                                            {{(strlen($value->vBusinessProfileName) > 25) ? substr($value->vBusinessProfileName,0,25).'...' : $value->vBusinessProfileName}}
                                                            @else
                                                                {{ 'N/A' }}
                                                            @endif
                                                        </h2>
                                                    </a>

                                                    <span style="font-size:14px; font-weight:500;" class="d-block">
                                                        Name Placeholder
                                                    </span>

                                                    <span style="color: #2B7292; font-size:12px;" class="pb-2">
                                                        Computers and information System
                                                    </span>
                                                    <!-- <div class="social-info-detail detailPageLink" data-id="{{ route('front.investment.detail', $value->vUniqueCode) }}">
                                                        <ul>
                                                            <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Email Verified"><i class="fal fa-envelope"></i>Email</a></li>
                                                            <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Phone Verified"><i class="far fa-phone-alt"></i>Phone</a></li>
                                                            {{-- <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Google Verified"><i class="fab fa-google-plus-g"></i> Google</a></li>
                                                            <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Not Linkdin Verified" class="disable"><i class="fab fa-linkedin"></i> Linkdin</a></li> --}}
                                                        </ul>
                                                    </div>                     -->
                                                    <div class="new-box-detail-img detailPageLink" data-id="{{ route('front.investment.detail', $value->vUniqueCode) }}">
                                                        <p class="investment-detail-info-read {{$current_image_status}}" style="color: #313538;">
                                                            @if (!empty($value->tBusinessProfileDetail))
                                                                {{ strip_tags($value->tBusinessProfileDetail) }}
                                                            @else
                                                                {{ 'N/A' }}
                                                            @endif
                                                        </p>
                                                        @if ($current_image_status == '')
                                                            <div class="business-box-img">
                                                                <img src="{{ asset($current_image) }}" alt="">
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="pt-3">
                                                        <!-- if Pitchinvestors Valuation Certified -->
                                                        <div style="color: #3A945E; font-size:14px; font-weight:700;" class="d-flex align-items-center">
                                                            <img style="width:17px; height:17px;" src="{{ asset('/front/assets/images/pitch.svg') }}" alt="" class="me-2">
                                                            <span>Pitchinvestors Valuation Certified</span>
                                                        </div>

                                                        <!-- else -->
                                                        <div style="color: #9E9E9E;font-weight: 700; font-size: 12px;">Verification Pending</div>
                                                    </div>

                                                    <ul class="business-box-text detailPageLink" data-id="{{ route('front.investment.detail', $value->vUniqueCode) }}">
                                                        <!-- <li class="rating">
                                                            <p class="m-0"><i class="fas fa-star" style="color: var(--yellowcolor);"></i>
                                                                @if($value->vAverageRating == NULL || $value->vAverageRating == 0)
                                                                    {{'No Rating'}}
                                                                @else
                                                                    {{$value->vAverageRating}}
                                                                @endif 
                                                                </p>
                                                        </li> -->
                                                        <li class="location d-flex align-items-center justify-content-between w-100">
                                                                <span style="color: #313538; font-size:14px; font-weight:500;">Location</span>

                                                                <p class="m-0" style="color: #313538; font-size:14px; font-weight:500;"> {{$locationName}}</p>
                                                        </li>
                                                    </ul>
                                                    <div class="next-step-new detailPageLink" data-id="{{ route('front.investment.detail', $value->vUniqueCode) }}">
                                                        <ul>
                                                            <li class="second-box bg-transparent" style="padding:0 !important;">
                                                                <span style="color: #313538; font-size:14px; font-weight:500;">Business Valuation</span>

                                                                <h3 class="m-0" style="color: #313538; font-size:14px; font-weight:500;">
                                                                    @if (!empty($value->vAverateMonthlySales))
                                                                        <label class="kes m-0" style="color: #313538; font-size:14px; font-weight:500;">KES</label> {{ \App\Helper\GeneralHelper::rupees_format_thaousand_billion_million($value->vAverateMonthlySales) }}
                                                                    @else
                                                                        {{ 'N/A' }}
                                                                    @endif
                                                                </h3>
                                                            </li>
                                                            <li class="second-box bg-transparent mt-2" style="padding:0 !important;">
                                                                <span style="color: #313538; font-size:14px; font-weight:500;">Founding Amount (USD)</span>

                                                                <h5 class="kes m-0" style="color: #313538; font-size:14px; font-weight:500;">
                                                                    @if (!empty($value->vProfitMargin))
                                                                        {{ $value->vProfitMargin }} %
                                                                    @else
                                                                        {{ 'N/A' }}
                                                                    @endif
                                                                </h5>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="final-step-detail">
                                                        <ul>
                                                            <!-- <li class="second-box">
                                                                <p>Financial Investment </p>
                                                                <h3>
                                                                    @if (!empty($value->vInvestmentAmountStake))
                                                                        <label class="kes">KES</label> {{ \App\Helper\GeneralHelper::rupees_format_thaousand_billion_million($value->vInvestmentAmountStake) }}
                                                                    @else
                                                                        {{ 'N/A' }}
                                                                    @endif
                                                                </h3>
                                                            </li> -->
                                                            <!-- <li class="line"></li> -->
                                                            <li class="contact-btn investment_ajax_listing_button" style="width:100%; background: #69B965;">
                                                                <a href="{{ route('front.investment.detail', $value->vUniqueCode) }}">Contact Business</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <ul class="-box-wrapper">
                                                    {{-- <li class="second-box">
                                                        <p>Financial Investment </p>
                                                        <h3>
                                                            @if (!empty($value->vInvestmentAmountStake))
                                                                {{ \App\Helper\GeneralHelper::rupees_format_thaousand_billion_million($value->vInvestmentAmountStake) }}
                                                            @else
                                                                {{ 'N/A' }}
                                                            @endif
                                                        </h3>
                                                    </li> --}}
                                                    {{-- <li class="second-box">
                                                        <p>Annual Revenue </p>
                                                        <h5>
                                                            @if (!empty($value->vAverateMonthlySales))
                                                                {{ number_format($value->vAverateMonthlySales,) }}
                                                            @else
                                                                {{ 'N/A' }}
                                                            @endif
                                                        </h5>
                                                    </li> --}}
                                                    {{-- <li class="second-box">
                                                        <p>EBITDA Margin </p>
                                                        <h5>
                                                            @if (!empty($value->vProfitMargin))
                                                                {{ $value->vProfitMargin }} %
                                                            @else
                                                                {{ 'N/A' }}
                                                            @endif
                                                        </h5>
                                                    </li> --}}
                                                
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>{{-- END ITEM DIV --}}
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-7 col-md-7 col-sm-12">
                        <div class="box-height">
                            <div class="box-bussines-right">
                                <p style="text-align: justify; font-size: 15px;" class="mt-4">Are you a startup looking for investors to take your business to the next level? Are you looking for an investor to inject some capital to help the company stabilize? Are you looking to find a buyer for your business? </p>
                                <p style="text-align: justify; font-size: 15px;" class="mt-4">
                                    PitchInvestors connects you with a network of investors and advisors who are ready to support your growth and success. With PitchInvestors, you'll have access to the resources and expertise you need to take your business to the next level. Don't let a lack of capital or guidance hold you back any longer. Sign up today and start realizing your full potential by engaging with potential investors.
                                </p>
                            </div>

                            <div class="box-footer-wrapper">
                                <div class="d-md-block d-none">
                                    <div class="row">
                                        <div class="col-6">
                                            <h5 style="color: #4E4D50; font-weight: 600;">Startup</h5>
                                        </div>

                                        <div class="col-6">
                                            <h5 style="color: #4E4D50; font-weight: 600;">Growth</h5>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            Click here to find angel investors interested in startups with high growth potential.
                                        </div>

                                        <div class="col-6">
                                            Explore your funding options today and find the solution that best fits your needs. Take your business to the next level
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="text-center pt-3 col-6">
                                            <a style="color: #2B7090; text-decoration:underline;" href="#" class="box-view-btn">View More</a>
                                        </div>

                                        <div class="text-center pt-3 col-6">
                                            <a style="color: #2B7090; text-decoration:underline;" href="#" class="box-view-btn">View More</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-md-none d-block">
                                    <div class="row g-5">
                                        <div class="col-md-6">
                                            <div>
                                                <h5 style="color: #4E4D50; font-weight: 600;" class="d-md-none d-block">Startup</h5>
                                                <p style="text-align: justify; font-size: 15px;" class="m-0">Click here to find angel investors interested in startups with high growth potential.</p>
                                                <div class="text-center pt-3">
                                                    <a style="color: #2B7090; text-decoration:underline;" href="#" class="box-view-btn">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div>
                                                <h5 style="color: #4E4D50; font-weight: 600;" class="d-md-none d-block">Growth</h5>
                                                <p style="text-align: justify; font-size: 15px;" class="m-0">Explore your funding options today and find the solution that best fits your needs. Take your business to the next level</p>
                                                <div class="text-center pt-3">
                                                    <a style="color: #2B7090; text-decoration:underline;" href="#" class="box-view-btn">View More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Business for sale slider end-->
    @endif

    @if (count($advisor_data) > 0)
        <!-- Business Advisor -->
        <section class="business-slider-wrapper mini-sliders green-slider right-shape" data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-in-sine">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-7 col-sm-12">
                        <div class="col-md-12 align-self-center">
                            <div class="box-bussines-right">
                                <h5 class="left-title">Advisors</h5>
                                <p style="text-align: justify;" class="mt-4">Are you a small or medium-sized enterprise in need of financial advice and guidance? PitchInvestors offers a range of services and expertise, from business planning and budgeting to business valuation, audit and investment strategies. Find the right financial adviser for your business, take control of your financial future and position your company for long-term success. Click the link below to see a list of our financial advisors.
                                </p>
                                <!-- <p style="text-align: justify;" class="mt-4"> We invite you to sign up on our website to access a network of entrepreneurs and small business owners who are in need of financial advice and guidance. By creating a profile and listing your services, you will be able to reach a wider audience of potential clients and showcase your expertise and qualifications. Don't miss this opportunity to grow your business and make a positive impact on the financial success of small businesses. Sign up today!
                                </p>
                                <p style="text-align: justify;" class="mt-4">Are you a small or medium-sized enterprise in need of financial advice and guidance? If so, we encourage you to click on the link to access a network of experienced and qualified financial business advisers who can help you navigate the financial challenges and opportunities of running a business. Our platform offers a range of services and expertise, from business planning and budgeting to business valuation or audit and investment strategies. Find the right financial adviser for your business, take control of your financial future and position your company for long-term success. Click the link below to see a list of our financial advisors.</p> -->
                            </div>
                            <div class="box-footer-wrapper">
                                <a href="#" class="view-all">
                                    View all Advisors
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <div class="business-for-sale-slider owl-carousel owl-theme" data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-in-sine">
                            <!-- item-1 -->
                            @foreach ($advisor_data as $key => $value)
                                @php
                                    $current_image = '';
                                @endphp
                                @if (!empty($value->vImage))
                                    @php
                                        $current_image = 'uploads/business-advisor/profile/' . $value->vImage;
                                    @endphp
                                @else
                                    @php
                                        $current_image = 'uploads/default/no-image.png';
                                    @endphp
                                @endif
                                <div class="item">
                                    <div class="row g-5">
                                        {{-- <div class="col-md-7 align-self-center">
                                                <div class="box-bussines-right">
                                                    <h5 class="left-title">Business Advisor</h5>
                                                    <p class="mt-4">Do you have the passion to help SMEs grow? Do you have a 
                                                        degree in finance, CFA, CPA or any other finance certification? Do you 
                                                        know how to develop business plans, business valuation models, and other 
                                                        robust financial models? Sign up today and help SMEs grow as you earn something.
                                                    </p>
                                                    <p class="mt-4"> Do you need a business advisor, business plan, business valuation or
                                                        audit? Do you need someone to look into your books and advice on tax matters? Click
                                                        the link below to see a list of our financial advisors.
                                                    </p>
                                                </div>
                                                <div class="box-footer-wrapper">
                                                    <a href="#" class="view-all">
                                                        View all Advisors
                                                    </a>
                                                </div>
                                            </div> --}}
                                        {{--<div class="col-md-12">
                                                <div class="bussines-box-wrapper">
                                                    <div class="box-header">
                                                        <h5 class="box-title">
                                                            @if (!empty($value->vAdvisorProfileTitle))
                                                                {{ $value->vAdvisorProfileTitle }}
                                                            @else
                                                                {{ 'N/A' }}
                                                            @endif
                                                        </h5>
                                                        <div class="box-logo">
                                                            <img src="{{ asset($current_image) }}">
                                                        </div>
                                                        <p class="box-desc">
                                                            @if (!empty($value->tEducationDetail))
                                                                {{ strip_tags($value->tEducationDetail) }}
                                                            @else
                                                                {{ 'N/A' }}
                                                            @endif
                                                        </p>
        
                                                        <ul class="box-rating">
                                                            <li class="rating">
                                                                <p class="m-0"><i class="fas fa-star"></i>8.5</p>
                                                            </li>
                                                            <li class="location">
                                                                <p class="m-0"><i class="fas fa-map-marker-alt"></i>Maharashtra</p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="box-body green-1">
                                                        <p class="m-0">Investment Size</p>
                                                        <h5 class="left-title">
                                                            @if (!empty($value->vHowMuchInvest))
                                                                {{ strtolower(trans($value->vHowMuchInvest)) }}
                                                            @else
                                                                {{ 'N/A' }}
                                                            @endif
                                                        </h5>
                                                    </div>
                                                    <div class="box-body green-2">
                                                        <p class="m-0">Locations</p>
                                                        <h5 class="left-title">
                                                            @php
                                                                $nullValue = '';
                                                            @endphp
                                                            @foreach ($location_advisor as $key => $lvalue)
                                                                @if (!empty($lvalue[0]->vLocationName) && $lvalue[0]->iAdvisorProfileId == $value->iAdvisorProfileId)
                                                                    {{ $lvalue[0]->vLocationName }}
                                                                    @if (count($lvalue) > 1)
                                                                        + {{ count($lvalue) - 1 }} More
                                                                    @endif
                                                                @else
                                                                    @php
                                                                        $nullValue = 'N/A';
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            @if (!empty($nullValue))
                                                                {{ $nullValue }}
                                                            @endif
                                                        </h5>
                                                    </div>
                                                    <div class="box-body green-3">
                                                        <p class="m-0">Industries</p>
                                                        <h5 class="left-title">
                                                            @php
                                                                $nullValue2 = '';
                                                            @endphp
                                                            @foreach ($industries_advisor as $key => $ivalue)
                                                                @if (!empty($ivalue[0]->vIndustryName) && $ivalue[0]->iAdvisorProfileId == $value->iAdvisorProfileId)
                                                                    {{ $nullValue2 = '' }}
                                                                    {{ $ivalue[0]->vIndustryName }}
                                                                    @if (count($ivalue) > 1)
                                                                        + {{ count($ivalue) - 1 }} More
                                                                    @endif
                                                                @else
                                                                    @php
                                                                        $nullValue2 = 'N/A';
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            @if (!empty($nullValue2))
                                                                {{ $nullValue2 }}
                                                            @endif
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="business-detail-box">
                                            <div class="frist-box" style="cursor: pointer;">
                                                <a class="detailPageLink" href="{{ url('advisor-detail', $value->vUniqueCode) }}">
                                                    <h2>
                                                        @if (!empty($value->vAdvisorProfileTitle))
                                                            {{ strlen($value->vAdvisorProfileTitle) > 25 ? substr($value->vAdvisorProfileTitle, 0, 25) . '...' : $value->vAdvisorProfileTitle }}
                                                        @else
                                                            {{ 'N/A' }}
                                                        @endif
                                                    </h2>
                                                </a>
                                                <div class="social-info-detail detailPageLink" data-id="{{ url('advisor-detail', $value->vUniqueCode) }}">
                                                    <ul>
                                                        <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Email Verified"><i class="fal fa-envelope"></i>Email</a></li>
                                                        <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Phone Verified"><i class="far fa-phone-alt"></i>Phone</a></li>
                                                    </ul>
                                                </div>
                                                <div class="new-box-detail-img detailPageLink" data-id="{{ url('advisor-detail', $value->vUniqueCode) }}">
                                                    <p class="investment-detail-info-read">
                                                        @if (!empty($value->tAdvisorProfileDetail))
                                                            {{ strip_tags($value->tAdvisorProfileDetail) }}
                                                        @else
                                                            {{ 'N/A' }}
                                                        @endif
                                                    </p>
                                                    <div class="business-box-img">
                                                        @php
                                                            $current_image = '';
                                                        @endphp
                                                        @if (!empty($value->vImage) && file_exists(public_path('uploads/business-advisor/profile/' . $value->vImage)))
                                                            @php
                                                                $current_image = 'uploads/business-advisor/profile/' . $value->vImage;
                                                            @endphp
                                                        @else
                                                            @php
                                                                $current_image = 'uploads/default/no-image.png';
                                                            @endphp
                                                        @endif
                                                        <img src="{{ asset($current_image) }}" alt="{{ asset('uploads/business-advisor/profile/' . $value->vImage) }}">
                                                    </div>
                                                </div>

                                                <div class="frist-box-part detailPageLink" data-id="{{ url('advisor-detail', $value->vUniqueCode) }}">
                                                    <ul class="business-box-text mt-3">
                                                        <li class="rating">
                                                            <p class="m-0"><i class="fas fa-star" style="color: var(--yellowcolor);"></i>
                                                                @if ($value->vAverageRating == null || $value->vAverageRating == 0)
                                                                    {{ 'No Rating' }}
                                                                @else
                                                                    {{ $value->vAverageRating }}
                                                                @endif
                                                            </p>
                                                        </li>
                                                        <li class="location">
                                                            <p class="m-0"><i class="fas fa-map-marker-alt" style="color: #939292;"></i>{{ $locationName }}</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                
                                                <div class="next-step-new detailPageLink" data-id="{{ url('advisor-detail', $value->vUniqueCode) }}">
                                                    <ul>
                                                        <li class="second-box">
                                                            <p>Locations</p>
                                                            <h5>
                                                                @php
                                                                    $nullValue = '';
                                                                    $noLocation = 0;
                                                                    $tooltip = '';
                                                                @endphp
                                                                @foreach ($location_advisor as $key => $lvalue)
                                                                    @if (!empty($lvalue[0]->vLocationName) && $lvalue[0]->iAdvisorProfileId == $value->iAdvisorProfileId)
                                                                        @php
                                                                            $nullValue = '';
                                                                            $noLocation = 1;
                                                                        @endphp
                                                                        @if (count($lvalue) > 1)
                                                                            {{-- @if ($key > 0) --}}
                                                                            @php
                                                                                foreach ($lvalue as $key1 => $value1) {
                                                                                    if (count($lvalue) - 1 > $key1) {
                                                                                        $tooltip .= $value1->vLocationName . ', ';
                                                                                    } else {
                                                                                        $tooltip .= $value1->vLocationName;
                                                                                    }
                                                                                }
                                                                            @endphp
                                                                            @if ($value1->eLocationType == 'Sub County')
                                                                                {{ $value1->vLocationName }}
                                                                            @endif
                                                                            {{-- @endif --}}
                                                                            <label class='pointer_cursor' data-bs-toggle="tooltip" title="{{ $tooltip }}">
                                                                                + {{ count($lvalue) - 1 }} More
                                                                            </label>
                                                                        @endif
                                                                    @else
                                                                        @php
                                                                            $nullValue = 'N/A';
                                                                        @endphp
                                                                    @endif
                                                                @endforeach
                                                                @if ($nullValue == 'N/A' && $noLocation == 0)
                                                                    {{ $nullValue }}
                                                                @endif
                                                            </h5>
                                                        </li>

                                                        <li class="second-box">
                                                            <p>Industries </p>
                                                            <h5>
                                                                @php
                                                                    $nullValue2 = '';
                                                                    $noLocation = 0;
                                                                @endphp
                                                                @foreach ($industries_advisor as $key => $ivalue)
                                                                    @if (!empty($ivalue[0]->vIndustryName) && $ivalue[0]->iAdvisorProfileId == $value->iAdvisorProfileId)
                                                                        @php
                                                                            $nullValue = '';
                                                                            $noLocation = 1;
                                                                        @endphp
                                                                        {{ $ivalue[0]->vIndustryName }}
                                                                        @if (count($ivalue) > 1)
                                                                            @php
                                                                                foreach ($ivalue as $key1 => $value1) {
                                                                                    if (count($ivalue) - 1 > $key1) {
                                                                                        $tooltip .= $value1->vIndustryName . ', ';
                                                                                    } else {
                                                                                        $tooltip .= $value1->vIndustryName;
                                                                                    }
                                                                                }
                                                                            @endphp
                                                                            <label class='pointer_cursor' data-bs-toggle="tooltip" title="{{ $tooltip }}">
                                                                                + {{ count($ivalue) - 1 }} More
                                                                            </label>
                                                                        @endif
                                                                    @else
                                                                        @php
                                                                            $nullValue2 = 'N/A';
                                                                        @endphp
                                                                    @endif
                                                                @endforeach
                                                                @if ($nullValue == 'N/A' && $noLocation == 0)
                                                                    {{ $nullValue2 }}
                                                                @endif
                                                            </h5>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="final-step-detail">
                                                    <ul class="justify-content-start">
                                                        <!--  <li class="second-box">
                                                                    <p>Investment Size</p>
                                                                    <h3>
                                                                    @if (!empty($value->vHowMuchInvest))
                                                                        {{ strtolower(trans($value->vHowMuchInvest)) }}
                                                                            @else
                                                                               {{ 'N/A' }}
                                                                             @endif
                                                                   </h3>
                                                                </li>
                                                                <li class="line"></li> -->
                                                        <li class="contact-btn advisor_ajax_listing_button">
                                                            <a href="{{ url('advisor-detail', $value->vUniqueCode) }}">Send Proposal</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Business Advisor end-->
    @endif

    @if (count($investor_data) > 0)
        <!-- Business Investors slider -->
        <section class="business-slider-wrapper mini-sliders blue-slider left-shape" data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-in-sine">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <div class="business-for-sale-slider owl-carousel owl-theme">
                            <!-- item-1 -->
                            @foreach ($investor_data as $key => $value)
                                @php
                                    $current_image = '';
                                @endphp
                                @if (!empty($value->vImage))
                                    @php
                                        $current_image = 'uploads/investor/profile/' . $value->vImage;
                                    @endphp
                                @else
                                    @php
                                        $current_image = 'uploads/default/no-image.png';
                                    @endphp
                                @endif
                                <div class="item">
                                    {{-- <div class="row g-5">
                                        <div class="col-md-5">
                                            <div class="bussines-box-wrapper">
                                                <div class="box-header">
                                                    <h5 class="box-title">
                                                        @if (!empty($value->vProfileTitle))
                                                            {{ $value->vProfileTitle }}
                                                        @else
                                                            {{ 'N/A' }}
                                                        @endif
                                                    </h5>
                                                    <div class="box-logo">
                                                        <img src="{{ asset($current_image) }}">
                                                    </div>
                                                    <p class="box-desc">
                                                        @if (!empty($value->tAboutCompany))
                                                            {{ $value->tAboutCompany }}
                                                        @else
                                                            {{ 'N/A' }}
                                                        @endif
                                                    </p>
                                                    <ul class="box-rating">
                                                        <li class="rating">
                                                            <p class="m-0"><i class="fas fa-star"></i>8.5</p>
                                                        </li>
                                                        <li class="location">
                                                            <p class="m-0"><i class="fas fa-map-marker-alt"></i>Maharashtra</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="box-body blue-1">
                                                    <p class="m-0">Investment Size</p>
                                                    <h5 class="left-title">
                                                        @if (!empty($value->vHowMuchInvest))
                                                            {{ $value->vHowMuchInvest }}
                                                        @else
                                                            {{ 'N/A' }}
                                                        @endif
                                                    </h5>
                                                </div>
                                                <div class="box-body blue-2">
                                                    <p class="m-0">Locations</p>
                                                    <h5 class="left-title">
                                                        @php
                                                            $nullValue = '';
                                                            $noLocation = 0;
                                                        @endphp
                                                        @foreach ($location_investor as $key => $lvalue)
                                                            @if (!empty($lvalue[0]->vLocationName) && $lvalue[0]->iInvestorProfileId == $value->iInvestorProfileId)
                                                                @php
                                                                    $nullValue = '';
                                                                    $noLocation = 1;
                                                                @endphp
                                                                {{ $lvalue[0]->vLocationName }}
                                                                @if (count($lvalue) > 1)
                                                                    + {{ count($lvalue) - 1 }} More
                                                                @endif
                                                            @else
                                                                @php
                                                                    $nullValue = 'N/A';
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        @if ($nullValue == 'N/A' && $noLocation == 0)
                                                            {{ $nullValue }}
                                                        @endif
                                                    </h5>
                                                </div>
                                                <div class="box-body blue-3">
                                                    <p class="m-0">Industries</p>
                                                    <h5 class="left-title">
                                                        @php
                                                            $nullValue2 = '';
                                                            $noIndustry = 0;
                                                        @endphp
                                                        @foreach ($industries_investor as $key => $ivalue)
                                                            @if (!empty($ivalue[0]->vIndustryName) && $ivalue[0]->iInvestorProfileId == $value->iInvestorProfileId)
                                                                @php
                                                                    $nullValue2 = '';
                                                                    $noIndustry = 1;
                                                                @endphp
                                                                {{ $ivalue[0]->vIndustryName }}
                                                                @if (count($ivalue) > 1)
                                                                    + {{ count($ivalue) - 1 }} More
                                                                @endif
                                                            @else
                                                                @php
                                                                    $nullValue2 = 'N/A';
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        @if (!empty($nullValue2) && $noIndustry == 0)
                                                            {{ $nullValue2 }}
                                                        @endif
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="business-detail-box">
                                        <div class="inves-profile detailPageLink" data-id="{{ url('investor-detail', $value->vUniqueCode) }}" style="cursor: pointer;">
                                            <div class="invester-pro-pic">
                                                <img src="https://www.smergers.com/static/images/xuserimage.jpg.pagespeed.ic.rO7yBwOGY8.webp" alt="">
                                            </div>
                                            <div class="pro-detail-investor">
                                                <a class="detailPageLink" href="{{ url('investor-detail', $value->vUniqueCode) }}">
                                                    <i class="fas fa-circle"></i>
                                                    @if (!empty($value->vInvestorProfileName))
                                                        {{ strlen($value->vInvestorProfileName) > 25 ? substr($value->vInvestorProfileName, 0, 25) . '...' : $value->vInvestorProfileName }}
                                                    @else
                                                        {{ 'N/A' }}
                                                    @endif
                                                </a>
                                                <p class="mb-0 text-p">Individual Buyer in Pune, India</p>
                                            </div>
                                        </div>
                                        <div class="frist-box" style="cursor: pointer;">
                                            <div class="frist-box-part">
                                                <div class="social-info-detail detailPageLink" data-id="{{ url('investor-detail', $value->vUniqueCode) }}">
                                                    <ul>
                                                        <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Email Verified"><i class="fal fa-envelope"></i>Email</a></li>
                                                        <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Phone Verified"><i class="far fa-phone-alt"></i>Phone</a></li>
                                                    </ul>
                                                </div>
                                                <div class="middle-text detailPageLink" data-id="{{ url('investor-detail', $value->vUniqueCode) }}">
                                                    <div class="interests">
                                                        <p><b>Detail: </b>{{ $value->tInvestorProfileDetail }} </p>
                                                    </div>
                                                </div>
                                                <ul class="business-box-text mt-2 contect-rating-line detailPageLink" data-id="{{ url('investor-detail', $value->vUniqueCode) }}">
                                                    <li class="rating">
                                                        <p class="m-0"><i class="fas fa-star" style="color: var(--yellowcolor);"></i>
                                                            @if ($value->vAverageRating == null || $value->vAverageRating == 0)
                                                                {{ 'No Rating' }}
                                                            @else
                                                                {{ $value->vAverageRating }}
                                                            @endif
                                                        </p>
                                                    </li>
                                                </ul>
                                                <div class="next-step-new detailPageLink" data-id="{{ url('investor-detail', $value->vUniqueCode) }}">
                                                    <ul>
                                                        <li class="second-box">
                                                            <p>City</p>
                                                            <h5>
                                                                @if (!empty($value->iCity))
                                                                    {{ $value->iCity }}
                                                                @else
                                                                    {{ 'N/A' }}
                                                                @endif
                                                            </h5>
                                                        </li>
                                                        <li class="second-box">
                                                            <p>Industries </p>
                                                            <h5>
                                                                @php
                                                                    $nullValue2 = '';
                                                                    $noIndustry = 0;
                                                                    $industry_tooltip = '';
                                                                @endphp
                                                                @foreach ($industries_investor as $key => $ivalue)
                                                                    @if (!empty($ivalue[0]->vIndustryName) && $ivalue[0]->iInvestorProfileId == $value->iInvestorProfileId)
                                                                        @php
                                                                            $nullValue2 = '';
                                                                            $noIndustry = 1;
                                                                        @endphp
                                                                        {{ $ivalue[0]->vIndustryName }}

                                                                        @if (count($ivalue) > 1)
                                                                            @if ($key > 0)
                                                                                @php
                                                                                    foreach ($ivalue as $key1 => $value1) {
                                                                                        if (count($ivalue) - 1 > $key1) {
                                                                                            $industry_tooltip .= $value1->vIndustryName . ', ';
                                                                                        } else {
                                                                                            $industry_tooltip .= $value1->vIndustryName;
                                                                                        }
                                                                                    }
                                                                                @endphp
                                                                                <label class='pointer_cursor' data-bs-toggle="tooltip" title="{{ $industry_tooltip }}">
                                                                                    + {{ count($ivalue) - 1 }} More
                                                                                </label>
                                                                            @endif
                                                                        @endif
                                                                    @else
                                                                        @php
                                                                            $nullValue2 = 'N/A';
                                                                        @endphp
                                                                    @endif
                                                                @endforeach
                                                                @if (!empty($nullValue2) && $noIndustry == 0)
                                                                    {{ $nullValue2 }}
                                                                @endif
                                                            </h5>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="final-step-detail">
                                                    <ul>
                                                        <li class="second-box">
                                                            <p>Investment Size</p>
                                                            <h3>
                                                                @if (!empty($value->vHowMuchInvest))
                                                                    {{ $value->vHowMuchInvest }}
                                                                @else
                                                                    {{ 'N/A' }}
                                                                @endif
                                                            </h3>
                                                        </li>
                                                        <li class="line"></li>
                                                        <li class="contact-btn investor_ajax_listing_button">
                                                            <a href="{{ url('investor-detail', $value->vUniqueCode) }}">Send Proposal</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="-box-wrapper">
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-12">
                        <div class="align-self-center">
                            <div class="box-bussines-right">
                                <h5 class="left-title">Investors</h5>
                                <p class="mt-4">Are you looking for investment opportunities to invest in? PitchInvestors is the perfect place to start your search. We offer a curated list of companies that are actively seeking investment or are open to being acquired. Easily filter out and search for opportunities that meet your investment criteria. Start your investment journey today on PitchInvestors!</p>
                                <!-- <p style="text-align: justify;" class="mt-4">Are you looking for investment opportunities to invest in? PitchInvestors is the perfect place to start your search. We offer a curated list of companies that are actively seeking investment or are open to being acquired, and our platform allows you to easily filter and search for opportunities that meet your investment criteria.</p>
                                <p style="text-align: justify;" class="mt-4"> Our team of experts carefully reviews and evaluate each opportunity before it is listed on our platform, ensuring that you have access to a curated selection of high-quality investment opportunities.</p>
                                <p style="text-align: justify;" class="mt-4">Don't miss this chance to expand your investment opportunities and potentially secure a lucrative deal. Invest in businesses across Kenya. Find global Investors.</p> -->
                            </div>
                            <div class="box-footer-wrapper">
                                <a href="#" class="view-all">
                                    View all Investors
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Business Investors slider end-->
    @endif

    <section class="pt-xl-5">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-3">
                    <h2 style="color: #2B7090; font-weight:500;" class="d-flex align-items-center">
                        <div class="green_block me-3" style="width: 30px; height:30px; background: #66BA62;"></div>
                        Characteristics of Businesses Accepted by PitchInvestors
                    </h2>
                </div>

                <div class="col-xl-6 order-xl-1 order-2 pt-xl-0 pt-4">
                    <div class="row">
                        <div class="col-12">
                            <h4 style="font-size: 19px;">Strong Revenue Generation:</h4>

                            <p style="font-size: 15px;">PitchInvestors welcomes businesses that have demonstrated a consistent track record of generating substantial revenue, showcasing their viability and growth potential.</p>
                        </div>

                        <div class="col-12">
                            <h4 style="font-size: 19px;">Established Operations:</h4>

                            <p style="font-size: 15px;"> We prioritize businesses that have been in operation for a significant period, typically six months or more. This requirement ensures that the companies listed on our platform have laid a solid foundation and have gained valuable market experience.</p>
                        </div>

                        <div class="col-12">
                            <h4 style="font-size: 19px;">Scalability and Growth Potential:</h4>

                            <p style="font-size: 15px;">We seek businesses with the potential for scalability and expansion. Whether through innovative products, unique market positioning, or promising industry trends, we aim to connect investors with ventures that can grow and thrive.</p>
                        </div>

                        <div class="col-12">

                        <h4 style="font-size: 19px;">Registration and Compliance:</h4>

                        <p style="font-size: 15px;">PitchInvestors values transparency and legitimacy. Therefore, we require businesses to be properly registered and compliant with applicable laws and regulations. This ensures a trustworthy and regulated environment for both investors and businesses.</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 order-xl-2 order-1">
                    <img class="w-100" src="{{ asset('/front/assets/images/desk_second.png') }}" >
                </div>
            </div>
        </div>
    </section>

    @if (count($industries) > 0)
        <!-- Categories start -->
        <section class="Categories">
            <div class="container">
                <h2 style="color: #2B7090; font-weight:500;" class="d-flex align-items-center mb-4">
                    <div class="green_block me-3" style="width: 30px; height:30px; background: #66BA62;"></div>
                    Categories
                </h2>

                <div class="cat-wrapper" data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-in-sine">
                    @php
                        $start = 1;
                        $end = 6;
                    @endphp
                    @foreach ($industries as $key => $value)
                        @php
                            $image = asset('uploads/default/no-image.png');
                            if (isset($value)) {
                                if ($value->vImage != '') {
                                    $image = asset('uploads/industry/' . $value->vImage);
                                }
                            }
                        @endphp
                        @if ($start == 1)
                            <ul class="categorise-box">
                        @endif
                        <li class="catergorie-list">
                            <img src="{{ url($image) }}">
                            <p class="m-0">{{ $value->vName }}</p>
                        </li>
                        @if ($end == $start)
                            </ul>
                        @endif

                        @if ($start == $end)
                            @if ($end == 6)
                                @php $end = 5; @endphp
                            @else
                                @php $end = 6; @endphp
                            @endif
                            @php $start = 1; @endphp
                        @else
                            @php $start +=1; @endphp
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
        <!-- Categories end -->
    @endif

    @if (count($testimonial) > 0)
        <!--  Testimonial start-->
        <section class="testimonial right-shape pt-5 mb-0 mt-5" style="background: #F0F0F0; padding-bottom:100px;">
            <div class="container">
                <h2 style="color: #2B7090; font-weight:500;" class="d-flex align-items-center mb-4">
                    <div class="green_block me-3" style="width: 30px; height:30px; background: #66BA62;"></div>
                    Testimonial
                </h2>

                <div class="testmonial-slider owl-carousel">
                    <!-- item-1 -->
                    @foreach ($testimonial as $key => $value)
                        <div class="testmonial-wrapper" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="900">
                            <div class="testmonail-item" style="">
                                @if (!empty($value->vImage))
                                    <img src="{{ asset('uploads/front/testimonial/' . $value->vImage) }}">
                                    <h6 class="m-0">{{ $value->vName }}</h6>
                                @else
                                    <div class="d-flex justify-content-start align-items-center py-2 pb-3">
                                        <div class="test-icon d-flex m-0">
                                            <img src="{{ asset('uploads/front/testimonial/slider-cmt.png') }}" alt="">
                                        </div>

                                        <div class="ps-3"> 
                                            <h6 class="m-0">{{ $value->vName }}</h6>
                                        </div>
                                    </div>
                                @endif
                                <p class="m-0 testimonial-write">
                                    {{ strip_tags($value->tDescription) }}
                                </p>
                            </div>
                            
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!--  Testimonial end-->
    @endif
@endsection
@section('custom-js')
<script type="text/javascript">
function showSubscribe() {
    $('#transparent-bg').show();
    $('#exampleModal10').css("display", "block");
    $('#exampleModal10').css("opacity", "1");
}
@if (!session('close-popup'))
showSubscribe();
@endif
$(document).on('click','.closeModel',function() 
{
    $('#transparent-bg').hide();
    $('#exampleModal10').css("display", "none");
    $('#exampleModal10').css("opacity", "0");
    $.ajax({
        url: '{{url('hide-subscribe')}}',
        type: "POST",
        headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
        data: {            
        },
        success: function(response) {

        }
    });
});

function subscribe() {
    if($.trim($('#name').val()) == '') {
        $('#sub_name').show();
        $('#sub_name').html('Please enter name');
    } else {
        $('#sub_name').hide();
    }

    if($.trim($('#email').val()) == '') {
        $('#sub_email').show();
        $('#sub_email').html('Please enter email');
    } else {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        if(!pattern.test($('#email').val())) {
            $('#sub_email').show();
            $('#sub_email').html('Please enter correct email');
        } else {
            $('#sub_email').hide();
        }
    }
    
    $.ajax({
        url: '{{url('subscribe')}}',
        type: "POST",
        headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
        data: {
            name:$.trim($('#name').val()),
            email:$.trim($('#email').val())
        },
        success: function(response) {
            $('#transparent-bg').hide();
            $('#exampleModal10').css("display", "none");
            $('#exampleModal10').css("opacity", "0");
        }
    }); 

}
</script>
@endsection