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
                    <div class="main-banner" style="background-image:url('{{ $Bannerimage }}')">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 me-auto">
                                    <div class="left-text" data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-in-sine">
                                        <h1>{{ $vbanner->vBannerTitle }}</h1>
                                        <p style="text-align: justify;"> {{ $vbanner->vSubTitle }}</p>

                                        <div class="topbtn-group">
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
                                        </div>
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
                    <div class="main-banner">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 me-auto">
                                    <div class="main-image-banner">
                                        <img src="{{ $Bannerimage }}" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 me-auto">
                                    <div class="left-text" data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-in-sine">
                                        <h1>{{ $vbanner->vBannerTitle }}.</h1>
                                        <p> {{ $vbanner->vSubTitle }}.</p>

                                        <div class="topbtn-group">
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
                                        </div>
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
    <section class="banner-second right-shape">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 me-auto" data-aos="fade-down" data-aos-duration="800">
                    <h2>
                        Explore our pre-approved investors and get in touch today
                    </h2>
                    <p>The first step in getting investors is letting them know about your business. Explore a list of pre-approved investors who have been carefully vetted and are looking for opportunities to invest in businesses that align with their goals and criteria.
                    </p>
                </div>
                <div class="col-lg-2 text-end" data-aos="fade-down" data-aos-duration="800">
                    <a href="{{ url('investor') }}" class="green-btn">
                        Explore Investors
                    </a>
                </div>
            </div>
            <!-- mid-counter section -->
            <div class="mid-counter-main">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 align-self-end">
                        <div class="min-count-wrapper">
                            <div class="left-img-1" data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-in-sine">
                                <img src="{{ asset('uploads/front/count/green-count.jpg') }}" alt="">
                            </div>
                            <div class="right-desc">
                                <h3 class="yellow-color">{{ $investment_count[0]->total_investment }} +</h3>
                                <p>
                                    Investments to choose from
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 align-self-end">
                        <div class="min-count-wrapper">
                            <div class="left-img-2" data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-in-sine">
                                <img src="{{ asset('uploads/front/count/blue-count.jpg') }}" alt="">
                            </div>
                            <div class="right-desc">
                                <h3 class="blue-color">{{ $investor_count[0]->total_investor }} +</h3>
                                <p>
                                    Investors on our website
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 align-self-end">
                        <div class="min-count-wrapper">
                            <div class="left-img-3" data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-in-sine">
                                <img src="{{ asset('uploads/front/count/yellow-count.jpg') }}" alt="">
                            </div>
                            <div class="right-desc">
                                <h3 class="green-color">{{ $advisor_count[0]->total_advisor }} +</h3>
                                <p>
                                    Advisors to choose from
                                </p>
                            </div>
                        </div>
                    </div>
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
    <!-- banner secon end -->
    @if (count($investment_data) > 0)
        <!-- Business for sale slider -->
        <section class="business-slider-wrapper mini-sliders yellow-slider left-shape">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <div class="business-for-sale-slider owl-carousel owl-theme" data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-in-sine">
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
                                            <div class="business-detail-box">
                                                <div class="frist-box" style="cursor: pointer;">
                                                    <a class='detailPageLink' href="{{ route('front.investment.detail', $value->vUniqueCode) }}">
                                                        <h2>
                                                            @if (!empty($value->vBusinessProfileName))
                                                                {{ strlen($value->vBusinessProfileName) > 25 ? substr($value->vBusinessProfileName, 0, 25) . '...' : $value->vBusinessProfileName }}
                                                            @else
                                                                {{ 'N/A' }}
                                                            @endif
                                                        </h2>
                                                    </a>
                                                    <div class="social-info-detail detailPageLink" data-id="{{ route('front.investment.detail', $value->vUniqueCode) }}">
                                                        <ul>
                                                            <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Email Verified"><i class="fal fa-envelope"></i>Email</a></li>
                                                            <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Phone Verified"><i class="far fa-phone-alt"></i>Phone</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="new-box-detail-img detailPageLink" data-id="{{ route('front.investment.detail', $value->vUniqueCode) }}">
                                                        <p class="investment-detail-info-read {{ $current_image_status }}">
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
                                                    <ul class="business-box-text detailPageLink" data-id="{{ route('front.investment.detail', $value->vUniqueCode) }}">
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
                                                            <p class="m-0"><i class="fas fa-map-marker-alt" style="color: #939292;"></i> {{ $locationName }}</p>
                                                        </li>
                                                    </ul>
                                                    <div class="next-step-new detailPageLink" data-id="{{ route('front.investment.detail', $value->vUniqueCode) }}">
                                                        <ul>
                                                            <li class="second-box">
                                                                <p>Annual Revenue </p>
                                                                <h3>
                                                                    @if (!empty($value->vAverateMonthlySales))
                                                                        <label class="kes">KES</label> {{ \App\Helper\GeneralHelper::rupees_format_thaousand_billion_million($value->vAverateMonthlySales) }}
                                                                    @else
                                                                        {{ 'N/A' }}
                                                                    @endif
                                                                </h3>
                                                            </li>
                                                            <li class="second-box">
                                                                <p>EBITDA Margin </p>
                                                                <h5>
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
                                                            <li class="second-box">
                                                                <p>Financial Investment </p>
                                                                <h3>
                                                                    @if (!empty($value->vInvestmentAmountStake))
                                                                        <label class="kes">KES</label> {{ \App\Helper\GeneralHelper::rupees_format_thaousand_billion_million($value->vInvestmentAmountStake) }}
                                                                    @else
                                                                        {{ 'N/A' }}
                                                                    @endif
                                                                </h3>
                                                            </li>
                                                            <li class="line"></li>
                                                            <li class="contact-btn investment_ajax_listing_button">
                                                                <a href="{{ route('front.investment.detail', $value->vUniqueCode) }}">Contact Business</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
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
                                <h5 class="left-title">Investments</h5>
                                <p style="text-align: justify;" class="mt-4">Are you a startup looking for investors to take your business to the next level? Are you looking for an investor to inject some capital to help the company stabilize? Are you looking to find a buyer for your business? </p>
                                <p style="text-align: justify;" class="mt-4">
                                PitchInvestors connects you with a network of investors and advisors who are ready to support your growth and success. With PitchInvestors, you'll have access to the resources and expertise you need to take your business to the next level. Don't let a lack of capital or guidance hold you back any longer. Sign up today and start realizing your full potential by engaging with potential investors.
                                </p>
                            </div>
                            <div class="box-footer-wrapper">
                                <div class="row g-5">
                                    <div class="col-md-6">
                                        <div class="box-right-footer">
                                            <div class="footer-img">
                                                <img src="{{ asset('uploads/front/roket.png') }}" alt="" class="img-fluid">
                                            </div>
                                            <h5>Startup</h5>
                                            <p style="text-align: justify;" class="m-0">Click here to find angel investors interested in startups with high growth potential.</p>
                                            <a href="#" class="box-view-btn">View More</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="box-right-footer">
                                            <div class="footer-img">
                                                <img src="{{ asset('uploads/front/frame.png') }}" alt="" class="img-fluid">
                                            </div>
                                            <h5>Growth</h5>
                                            <p style="text-align: justify;" class="m-0">Explore your funding options today and find the solution that best fits your needs. Take your business to the next level</p>
                                            <a href="#" class="box-view-btn">View More</a>
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

    @if (count($industries) > 0)
        <!-- Categories start -->
        <section class="Categories">
            <div class="container">
                <h3 class="mid-title">
                    Categories
                </h3>
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
        <section class="testimonial right-shape">
            <h3 class="mid-title">
                Testimonial
            </h3>
            <div class="container">
                <div class="testmonial-slider owl-carousel">
                    <!-- item-1 -->
                    @foreach ($testimonial as $key => $value)
                        <div class="testmonial-wrapper" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="900">
                            <div class="testmonail-item">
                                
                                @if (!empty($value->vImage))
                                    <img src="{{ asset('uploads/front/testimonial/' . $value->vImage) }}">
                                @else
                                    <div class="test-icon">
                                        <img src="{{ asset('uploads/front/testimonial/slider-cmt.png') }}" alt="">
                                    </div>
                                @endif
                                <p class="m-0 text-center testimonial-write">
                                    {{ strip_tags($value->tDescription) }}
                                </p>
                            </div>
                            <div class="test-content text-center">
                                <h6 class="m-0">{{ $value->vName }}</h6>
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