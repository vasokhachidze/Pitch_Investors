@extends('layouts.app.front-app')
@section('title', 'Dashboard '.env('APP_NAME'))
@section('content')
@php
    // dd($session_data);
    $session_data = (session('user') !== null )?session('user'):'';
    $userData = '';
    if ($session_data !== '') {
    $userData = App\Helper\GeneralHelper::get_user_by_id($session_data['iUserId']);
    }
@endphp
<style>
.box1 {
    order: 1;
}

.box2 {
    order: 2;
}
@media screen and (max-width: 991px) {
    .secondary-chat {
        display: block !important;
    }
    .primary-chat{
        display: none;
    }
    .box1 {
        order: 2;
    }

    .box2 {
        order: 1;
    }
}

</style>

<section class="my-dashbord">
    <div class="container">
        <div class="row">
            @include('layouts.front.left_dashboard')
            
            <div class="col-lg-9 box2">
                <div class="right-panal-side">
                    @include('layouts.front.header_dashboard')
                    <!-- @if (isset($userData) && $userData->is_premium == 0)
                    <a style = "margin:20px;" href="{{ url('/premium-detail') }}" class="btn btn-primary bg-blue">Learn About Premium Account</a>
                   @endif -->
                    <!-- Sell Your business section start -->
                        <div class="row mt-3 padding-no" style="display: none">
                            <div class="letest-activity">
                                <div class="col-lg-12 sell-busi-activity">
                                    <div>
                                        <h3 class="activity-hading">Sell Your business (6)</h3>
                                    </div>
                                    
                                    <div class="add-bussines-new">
                                        <a href="#"><i class="far fa-plus"></i>Add Business</a>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class=" col-xl-4 col-lg-6 col-md-6 col-12 mt-3">
                                        <div class="sell-busi-box-warp">
                                            <div class="bussines-sell-box-detail">
                                                <h5 class="heading">Business 1 </h5>
                                                <p>Lorem Ipsum is simply dummy text of </p>
                                            </div>
                                            <div class="bussines-sell-box-number">
                                                <h6>20</h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6 col-md-6 col-12 mt-3">
                                        <div class="sell-busi-box-warp">
                                            <div class="bussines-sell-box-detail">
                                                <h5 class="heading">Business 2 </h5>
                                                <p>Lorem Ipsum is simply dummy text of </p>
                                            </div>
                                            <div class="bussines-sell-box-number">
                                                <h6>30</h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6 col-md-6 col-12 mt-3">
                                        <div class="sell-busi-box-warp">
                                            <div class="bussines-sell-box-detail">
                                                <h5 class="heading">Business 3 </h5>
                                                <p>Lorem Ipsum is simply dummy text of </p>
                                            </div>
                                            <div class="bussines-sell-box-number">
                                                <h6>20</h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class=" col-xl-4 col-lg-6 col-md-6 col-12 mt-3">
                                        <div class="sell-busi-box-warp">
                                            <div class="bussines-sell-box-detail">
                                                <h5 class="heading">Business 4 </h5>
                                                <p>Lorem Ipsum is simply dummy text of </p>
                                            </div>
                                            <div class="bussines-sell-box-number">
                                                <h6>15</h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class=" col-xl-4 col-lg-6 col-md-6 col-12 mt-3">
                                        <div class="sell-busi-box-warp">
                                            <div class="bussines-sell-box-detail">
                                                <h5 class="heading">Business 5 </h5>
                                                <p>Lorem Ipsum is simply dummy text of </p>
                                            </div>
                                            <div class="bussines-sell-box-number">
                                                <h6>10</h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class=" col-xl-4 col-lg-6 col-md-6 col-12 mt-3">
                                        <div class="sell-busi-box-warp">
                                            <div class="bussines-sell-box-detail">
                                                <h5 class="heading">Business 6 </h5>
                                                <p>Lorem Ipsum is simply dummy text of </p>
                                            </div>
                                            <div class="bussines-sell-box-number">
                                                <h6>15</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="sell-yiur-bussinrs-activity-listing margin-top-foruthy">
                                            <div class="left-text">
                                                <h3 class="activity-hading">Recent Notification</h3>
                                            </div>
                                            <div class="right-text">
                                                <div class="dropdown">
                                                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Sort By
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                        <li><a class="dropdown-item sort" data-id="a-z" href="javascript:;">Business 1</a></li>
                                                        <li><a class="dropdown-item sort" data-id="a-z" href="javascript:;">Business 2</a></li>
                                                        <li><a class="dropdown-item sort" data-id="a-z" href="javascript:;">Business 3</a></li>
                                                        <li><a class="dropdown-item sort" data-id="a-z" href="javascript:;">Business 4</a></li>
                                                        <li><a class="dropdown-item sort" data-id="a-z" href="javascript:;">Business 5</a></li>
                                                        <li><a class="dropdown-item sort" data-id="a-z" href="javascript:;">Business 6</a></li>
                                                        <li><a class="dropdown-item sort" data-id="a-z" href="javascript:;">Business 7</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 mt-3">
                                        <div class="business-detail-box sell-bussines-box">
                                            <div class="frist-box">
                                                <div class="frist-box-part">
                                                    <div class="business-box-img">
                                                        <img src="{{asset('front/assets/images/hexa-1.png')}}" alt="">
                                                    </div>

                                                    <ul class="business-box-text">
                                                        <li class="rating">
                                                            <p class="m-0"><i class="fas fa-star" style="color: var(--yellowcolor);"></i>8.5</p>
                                                        </li>
                                                        <li class="location pt-2">
                                                            <p class="m-0"><i class="fas fa-map-marker-alt" style="color: #939292;"></i>kenya 9</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <a href="" class="main-title">
                                                    <h2>John Doe </h2>
                                                </a>

                                                <p class="investment-detail-info mb-0">
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Arcu auctor
                                                    sollicitudin dolor scelerisque mauris viverra. Pellentesque lectus
                                                    tincidunt dignissim
                                                </p>

                                                <div class="view-peofile-btn">
                                                    <a href="#" class="sell-busines-view-profile">View Profile</a>
                                                </div>
                                            </div>

                                            <ul class="box-wrapper">
                                                <li class="contact-btn">
                                                    <ul class="d-flex">
                                                        <li style="border-right: 1px solid #C4C4C4;"><a href="" class="text-green"><i class="fal fa-check"></i>Accept</a>
                                                        </li>
                                                        <li><a href="" class="text-gray"><i class="fal fa-times"></i>Reject</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 mt-3">
                                        <div class="business-detail-box sell-bussines-box">
                                            <div class="frist-box">
                                                <div class="frist-box-part">
                                                    <div class="business-box-img">
                                                        <img src="{{asset('front/assets/images/hexa-1.png')}}" alt="">
                                                    </div>

                                                    <ul class="business-box-text">
                                                        <li class="rating">
                                                            <p class="m-0"><i class="fas fa-star" style="color: var(--yellowcolor);"></i>8.5</p>
                                                        </li>

                                                        <li class="location pt-2">
                                                            <p class="m-0"><i class="fas fa-map-marker-alt" style="color: #939292;"></i>kenya 9</p>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <a href="" class="main-title">
                                                    <h2>John Doe </h2>
                                                </a>

                                                <p class="investment-detail-info mb-0">
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Arcu auctor
                                                    sollicitudin dolor scelerisque mauris viverra. Pellentesque lectus
                                                    tincidunt dignissim
                                                </p>

                                                <div class="view-peofile-btn">
                                                    <a href="#" class="sell-busines-view-profile">View Profile</a>
                                                </div>
                                            </div>
                                            <ul class="box-wrapper">
                                                <li class="contact-btn">
                                                    <ul class="d-flex">
                                                        <li style="border-right: 1px solid #C4C4C4;"><a href="" class="text-green"><i class="fal fa-check"></i>Accept</a>
                                                        </li>
                                                        <li><a href="" class="text-gray"><i class="fal fa-times"></i>Reject</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mt-3">
                                        <div class="business-detail-box sell-bussines-box">
                                            <div class="frist-box">
                                                <div class="frist-box-part">
                                                    <div class="business-box-img">
                                                        <img src="{{asset('front/assets/images/hexa-1.png')}}" alt="">
                                                    </div>

                                                    <ul class="business-box-text">
                                                        <li class="rating">
                                                            <p class="m-0"><i class="fas fa-star" style="color: var(--yellowcolor);"></i>8.5</p>
                                                        </li>

                                                        <li class="location pt-2">
                                                            <p class="m-0"><i class="fas fa-map-marker-alt" style="color: #939292;"></i>kenya 9</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <a href="" class="main-title">
                                                    <h2>John Doe </h2>
                                                </a>

                                                <p class="investment-detail-info mb-0">
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Arcu auctor
                                                    sollicitudin dolor scelerisque mauris viverra. Pellentesque lectus
                                                    tincidunt dignissim
                                                </p>

                                                <div class="view-peofile-btn">
                                                    <a href="#" class="sell-busines-view-profile">View Profile</a>
                                                </div>
                                            </div>
                                            <ul class="box-wrapper">
                                                <li class="contact-btn">
                                                    <ul class="d-flex">
                                                        <li style="border-right: 1px solid #C4C4C4;"><a href="" class="text-green"><i class="fal fa-check"></i>Accept</a>
                                                        </li>
                                                        <li><a href="" class="text-gray"><i class="fal fa-times"></i>Reject</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="sell-yiur-bussinrs-activity-listing margin-top-foruthy">
                                            <div class="left-text">
                                                <h3 class="activity-hading">Boookmarks</h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-6 col-md-6 mt-3">
                                        <div class="business-detail-box">
                                            <div class="frist-box">
                                                <div class="frist-box-part">
                                                    <div class="business-box-img">
                                                        <img src="{{asset('front/assets/images/hexa-1.png')}}" alt="">
                                                    </div>

                                                    <ul class="business-box-text">
                                                        <li class="rating">
                                                            <p class="m-0"><i class="fas fa-star" style="color: var(--yellowcolor);"></i>8.5</p>
                                                        </li>

                                                        <li class="location pt-2">
                                                            <p class="m-0"><i class="fas fa-map-marker-alt" style="color: #939292;"></i>kenya 9</p>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <a href="" class="main-title">
                                                    <h2> Lorem ipsum dolor sit amet tetur elit. </h2>
                                                </a>

                                                <p class="investment-detail-info mb-0">
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Arcu auctor
                                                    sollicitudin dolor scelerisque mauris viverra. Pellentesque lectus
                                                    tincidunt dignissim
                                                </p>
                                            </div>
                                            <ul class="box-wrapper">
                                                <li class="second-box">
                                                    <p class="mb-0">Financial Investment </p>
                                                    <h3 class="mb-0"> KES 12</h3>
                                                </li>

                                                <li class="second-box">
                                                    <p class="mb-0">Run Rate Sales </p>
                                                    <h5 class="mb-0"> 12 % </h5>
                                                </li>

                                                <li class="second-box">
                                                    <p class="mb-0">EBITDA Margin </p>
                                                    <h5 class="mb-0"> 2 %</h5>
                                                </li>

                                                {{-- <li class="second-box add-to-bookmark yellow-color">
                                                    <a href="#" class="active"><i class="far fa-bookmark icon-bookmark"></i>Add to Bookmark</a>
                                                </li> --}}

                                                <li class="contact-btn">
                                                    <ul class="d-flex">
                                                        <li style="border-right: 1px solid #C4C4C4;"><a href="" class="text-green"><i class="fal fa-check"></i>Accept</a>
                                                        </li>
                                                        <li><a href="" class="text-gray"><i class="fal fa-times"></i>Reject</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 mt-3">
                                        <div class="business-detail-box">
                                            <div class="frist-box">
                                                <div class="frist-box-part">
                                                    <div class="business-box-img">
                                                        <img src="{{asset('front/assets/images/hexa-1.png')}}" alt="">
                                                    </div>

                                                    <ul class="business-box-text">
                                                        <li class="rating">
                                                            <p class="m-0"><i class="fas fa-star" style="color: var(--yellowcolor);"></i>8.5</p>
                                                        </li>

                                                        <li class="location pt-2">
                                                            <p class="m-0"><i class="fas fa-map-marker-alt" style="color: #939292;"></i>kenya 9</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <a href="" class="main-title">
                                                    <h2> Lorem ipsum dolor sit amet tetur elit. </h2>
                                                </a>
                                                <p class="investment-detail-info mb-0">
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Arcu auctor
                                                    sollicitudin dolor scelerisque mauris viverra. Pellentesque lectus
                                                    tincidunt dignissim
                                                </p>
                                            </div>
                                            <ul class="box-wrapper">
                                                <li class="second-box">
                                                    <p class="mb-0">Financial Investment </p>
                                                    <h3 class="mb-0"> KES 12</h3>
                                                </li>
                                                <li class="second-box">
                                                    <p class="mb-0">Run Rate Sales </p>
                                                    <h5 class="mb-0"> 12 % </h5>
                                                </li>
                                                <li class="second-box">
                                                    <p class="mb-0">EBITDA Margin </p>
                                                    <h5 class="mb-0"> 2 %</h5>
                                                </li>
                                                {{-- <li class="second-box add-to-bookmark yellow-color">
                                                    <a href="#" class="active"><i class="far fa-bookmark icon-bookmark"></i>Add to Bookmark</a>
                                                </li> --}}
                                                <li class="contact-btn">
                                                    <ul class="d-flex">
                                                        <li style="border-right: 1px solid #C4C4C4;"><a href="" class="text-green"><i class="fal fa-check"></i>Accept</a>
                                                        </li>
                                                        <li><a href="" class="text-gray"><i class="fal fa-times"></i>Reject</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 mt-3">
                                        <div class="business-detail-box">
                                            <div class="frist-box">
                                                <div class="frist-box-part">
                                                    <div class="business-box-img">
                                                        <img src="{{asset('front/assets/images/hexa-1.png')}}" alt="">
                                                    </div>
                                                    <ul class="business-box-text">
                                                        <li class="rating">
                                                            <p class="m-0"><i class="fas fa-star" style="color: var(--yellowcolor);"></i>8.5</p>
                                                        </li>
                                                        <li class="location pt-2">
                                                            <p class="m-0"><i class="fas fa-map-marker-alt" style="color: #939292;"></i>kenya 9</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <a href="" class="main-title">
                                                    <h2> Lorem ipsum dolor sit amet tetur elit. </h2>
                                                </a>
                                                <p class="investment-detail-info mb-0">
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Arcu auctor
                                                    sollicitudin dolor scelerisque mauris viverra. Pellentesque lectus
                                                    tincidunt dignissim
                                                </p>
                                            </div>
                                            <ul class="box-wrapper">
                                                <li class="second-box">
                                                    <p class="mb-0">Financial Investment </p>
                                                    <h3 class="mb-0"> KES 12</h3>
                                                </li>
                                                <li class="second-box">
                                                    <p class="mb-0">Run Rate Sales </p>
                                                    <h5 class="mb-0"> 12 % </h5>
                                                </li>
                                                <li class="second-box">
                                                    <p class="mb-0">EBITDA Margin </p>
                                                    <h5 class="mb-0"> 2 %</h5>
                                                </li>
                                                {{-- <li class="second-box add-to-bookmark yellow-color">
                                                    <a href="#" class="active"><i class="far fa-bookmark icon-bookmark"></i>Add to Bookmark</a>
                                                </li> --}}
                                                <li class="contact-btn">
                                                    <ul class="d-flex">
                                                        <li style="border-right: 1px solid #C4C4C4;"><a href="" class="text-green"><i class="fal fa-check"></i>Accept</a>
                                                        </li>
                                                        <li><a href="" class="text-gray"><i class="fal fa-times"></i>Reject</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!-- Sell Your business section end -->
                    <div class="row mt-3 padding-no" style="display: none">
                        <div class="letest-activity">
                            <div class="col-lg-12">
                                <h3 class="activity-hading">Leatest Activity</h3>
                            </div>

                            <div class="row">
                                <div class="col-xl-4 col-lg-6 col-md-6 mt-3">
                                    <div class="business-detail-box">
                                        <div class="frist-box">
                                            <div class="frist-box-part">
                                                <div class="business-box-img">
                                                    <img src="{{asset('front/assets/images/hexa-1.png')}}" alt="">
                                                </div>
                                                <ul class="business-box-text">
                                                    <li class="rating">
                                                        <p class="m-0"><i class="fas fa-star" style="color: var(--yellowcolor);"></i>8.5</p>
                                                    </li>
                                                    <li class="location pt-2">
                                                        <p class="m-0"><i class="fas fa-map-marker-alt" style="color: #939292;"></i>kenya 9</p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <a href="" class="main-title">
                                                <h2> Lorem ipsum dolor sit amet tetur elit. </h2>
                                            </a>
                                            <p class="investment-detail-info mb-0">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Arcu auctor
                                                sollicitudin dolor scelerisque mauris viverra. Pellentesque lectus
                                                tincidunt dignissim
                                            </p>
                                        </div>
                                        <ul class="box-wrapper">
                                            <li class="second-box">
                                                <p class="mb-0">Financial Investment </p>
                                                <h3 class="mb-0"> KES 12</h3>
                                            </li>
                                            <li class="second-box">
                                                <p class="mb-0">Run Rate Sales </p>
                                                <h5 class="mb-0"> 12 % </h5>
                                            </li>
                                            <li class="second-box">
                                                <p class="mb-0">EBITDA Margin </p>
                                                <h5 class="mb-0"> 2 %</h5>
                                            </li>
                                            {{-- <li class="second-box add-to-bookmark yellow-color">
                                                <a href="#" class="active"><i class="far fa-bookmark icon-bookmark"></i>Add to Bookmark</a>
                                            </li> --}}
                                            <li class="contact-btn">
                                                <ul class="d-flex">
                                                    <li style="border-right: 1px solid #C4C4C4;"><a href="" class="text-green"><i class="fal fa-check"></i>Accept</a>
                                                    </li>
                                                    <li><a href="" class="text-gray"><i class="fal fa-times"></i>Reject</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-md-6 mt-3">
                                    <div class="business-detail-box">
                                        <div class="frist-box">
                                            <div class="frist-box-part">
                                                <div class="business-box-img">
                                                    <img src="{{asset('front/assets/images/hexa-1.png')}}" alt="">
                                                </div>
                                                <ul class="business-box-text">
                                                    <li class="rating">
                                                        <p class="m-0"><i class="fas fa-star" style="color: var(--yellowcolor);"></i>8.5</p>
                                                    </li>
                                                    <li class="location pt-2">
                                                        <p class="m-0"><i class="fas fa-map-marker-alt" style="color: #939292;"></i>kenya 9</p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <a href="" class="main-title">
                                                <h2> Lorem ipsum dolor sit amet tetur elit. </h2>
                                            </a>
                                            <p class="investment-detail-info mb-0">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Arcu auctor
                                                sollicitudin dolor scelerisque mauris viverra. Pellentesque lectus
                                                tincidunt dignissim
                                            </p>
                                        </div>
                                        <ul class="box-wrapper">
                                            <li class="second-box">
                                                <p class="mb-0">Financial Investment </p>
                                                <h3 class="mb-0 text-green"> KES 12</h3>
                                            </li>
                                            <li class="second-box">
                                                <p class="mb-0">Run Rate Sales </p>
                                                <h5 class="mb-0"> 12 % </h5>
                                            </li>
                                            <li class="second-box">
                                                <p class="mb-0">EBITDA Margin </p>
                                                <h5 class="mb-0"> 2 %</h5>
                                            </li>
                                            {{-- <li class="second-box add-to-bookmark green-color">
                                                <a href="#" class="active"><i class="far fa-bookmark icon-bookmark"></i>Add to Bookmark</a>
                                            </li> --}}
                                            <li class="send-btn">
                                                <a href="#">Send Proposal</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-md-6 mt-3">
                                    <div class="business-detail-box">
                                        <div class="frist-box">
                                            <div class="frist-box-part">
                                                <div class="business-box-img">
                                                    <img src="{{asset('front/assets/images/hexa-1.png')}}" alt="">
                                                </div>
                                                <ul class="business-box-text">
                                                    <li class="rating">
                                                        <p class="m-0"><i class="fas fa-star" style="color: var(--yellowcolor);"></i>8.5</p>
                                                    </li>
                                                    <li class="location pt-2">
                                                        <p class="m-0"><i class="fas fa-map-marker-alt" style="color: #939292;"></i>kenya 9</p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <a href="" class="main-title">
                                                <h2> Lorem ipsum dolor sit amet tetur elit. </h2>
                                            </a>
                                            <p class="investment-detail-info mb-0">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Arcu auctor
                                                sollicitudin dolor scelerisque mauris viverra. Pellentesque lectus
                                                tincidunt dignissim
                                            </p>
                                        </div>
                                        <ul class="box-wrapper">
                                            <li class="second-box">
                                                <p class="mb-0">Financial Investment </p>
                                                <h3 class="mb-0 text-blue"> KES 12</h3>
                                            </li>
                                            <li class="second-box">
                                                <p class="mb-0">Run Rate Sales </p>
                                                <h5 class="mb-0"> 12 % </h5>
                                            </li>
                                            <li class="second-box">
                                                <p class="mb-0">EBITDA Margin </p>
                                                <h5 class="mb-0"> 2 %</h5>
                                            </li>
                                            {{-- <li class="second-box add-to-bookmark blue-color">
                                                <a href="#" class="active"><i class="far fa-bookmark icon-bookmark"></i>Add to Bookmark</a>
                                            </li> --}}
                                            <li class="send-btn">
                                                <a href="#">Send Proposal</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-md-6 mt-3">
                                    <div class="business-detail-box">
                                        <div class="frist-box">
                                            <div class="frist-box-part">
                                                <div class="business-box-img">
                                                    <img src="{{asset('front/assets/images/hexa-1.png')}}" alt="">
                                                </div>
                                                <ul class="business-box-text">
                                                    <li class="rating">
                                                        <p class="m-0"><i class="fas fa-star" style="color: var(--yellowcolor);"></i>8.5</p>
                                                    </li>
                                                    <li class="location pt-2">
                                                        <p class="m-0"><i class="fas fa-map-marker-alt" style="color: #939292;"></i>kenya 9</p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <a href="" class="main-title">
                                                <h2> Lorem ipsum dolor sit amet tetur elit. </h2>
                                            </a>
                                            <p class="investment-detail-info mb-0">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Arcu auctor
                                                sollicitudin dolor scelerisque mauris viverra. Pellentesque lectus
                                                tincidunt dignissim
                                            </p>
                                        </div>
                                        <ul class="box-wrapper">
                                            <li class="second-box">
                                                <p class="mb-0">Financial Investment </p>
                                                <h3 class="mb-0"> KES 12</h3>
                                            </li>
                                            <li class="second-box">
                                                <p class="mb-0">Run Rate Sales </p>
                                                <h5 class="mb-0"> 12 % </h5>
                                            </li>
                                            <li class="second-box">
                                                <p class="mb-0">EBITDA Margin </p>
                                                <h5 class="mb-0"> 2 %</h5>
                                            </li>
                                            {{-- <li class="second-box add-to-bookmark yellow-color">
                                                <a href="#" class="active"><i class="far fa-bookmark icon-bookmark"></i>Add to Bookmark</a>
                                            </li> --}}
                                            <li class="send-btn">
                                                <a href="#">Send Proposal</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-md-6 mt-3">
                                    <div class="business-detail-box">
                                        <div class="frist-box">
                                            <div class="frist-box-part">
                                                <div class="business-box-img">
                                                    <img src="{{asset('front/assets/images/hexa-1.png')}}" alt="">
                                                </div>
                                                <ul class="business-box-text">
                                                    <li class="rating">
                                                        <p class="m-0"><i class="fas fa-star" style="color: var(--yellowcolor);"></i>8.5</p>
                                                    </li>
                                                    <li class="location pt-2">
                                                        <p class="m-0"><i class="fas fa-map-marker-alt" style="color: #939292;"></i>kenya 9</p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <a href="" class="main-title">
                                                <h2> Lorem ipsum dolor sit amet tetur elit. </h2>
                                            </a>
                                            <p class="investment-detail-info mb-0">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Arcu auctor
                                                sollicitudin dolor scelerisque mauris viverra. Pellentesque lectus
                                                tincidunt dignissim
                                            </p>
                                        </div>
                                        <ul class="box-wrapper">
                                            <li class="second-box">
                                                <p class="mb-0">Financial Investment </p>
                                                <h3 class="mb-0 text-green"> KES 12</h3>
                                            </li>
                                            <li class="second-box">
                                                <p class="mb-0">Run Rate Sales </p>
                                                <h5 class="mb-0"> 12 % </h5>
                                            </li>
                                            <li class="second-box">
                                                <p class="mb-0">EBITDA Margin </p>
                                                <h5 class="mb-0"> 2 %</h5>
                                            </li>
                                            {{-- <li class="second-box add-to-bookmark green-color">
                                                <a href="#" class="active"><i class="far fa-bookmark icon-bookmark"></i>Add to Bookmark</a>
                                            </li> --}}
                                            <li class="send-btn">
                                                <a href="#">Send Proposal</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-md-6 mt-3">
                                    <div class="business-detail-box">
                                        <div class="frist-box">
                                            <div class="frist-box-part">
                                                <div class="business-box-img">
                                                    <img src="{{asset('front/assets/images/hexa-1.png')}}" alt="">
                                                </div>
                                                <ul class="business-box-text">
                                                    <li class="rating">
                                                        <p class="m-0"><i class="fas fa-star" style="color: var(--yellowcolor);"></i>8.5</p>
                                                    </li>
                                                    <li class="location pt-2">
                                                        <p class="m-0"><i class="fas fa-map-marker-alt" style="color: #939292;"></i>kenya 9</p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <a href="" class="main-title">
                                                <h2> Lorem ipsum dolor sit amet tetur elit. </h2>
                                            </a>
                                            <p class="investment-detail-info mb-0">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Arcu auctor
                                                sollicitudin dolor scelerisque mauris viverra. Pellentesque lectus
                                                tincidunt dignissim
                                            </p>
                                        </div>
                                        <ul class="box-wrapper">
                                            <li class="second-box">
                                                <p class="mb-0">Financial Investment </p>
                                                <h3 class="mb-0 text-blue"> KES 12</h3>
                                            </li>
                                            <li class="second-box">
                                                <p class="mb-0">Run Rate Sales </p>
                                                <h5 class="mb-0"> 12 % </h5>
                                            </li>
                                            <li class="second-box">
                                                <p class="mb-0">EBITDA Margin </p>
                                                <h5 class="mb-0"> 2 %</h5>
                                            </li>
                                            {{-- <li class="second-box add-to-bookmark blue-color">
                                                <a href="#" class="active"><i class="far fa-bookmark icon-bookmark"></i>Add to Bookmark</a>
                                            </li> --}}
                                            <li class="send-btn">
                                                <a href="#">Send Proposal</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="secondary-chat col-12" style="display:none">
            <div>
                @if ($session_data !== '')
                    @include('layouts.front.chat_inbox_connection_listing')
                @endif
            </div>
        </div>
    </div>
</section>
@endsection


@section('custom-js')
<script>
    /* $( ".chat-person-profile" ).click(function() {
        $(".chating-box").show();
    });
    $( ".close-chat" ).click(function() {
        $(".chating-box").parent().hide();
    }); */
</script>
@endsection