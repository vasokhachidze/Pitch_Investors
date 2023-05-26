@extends('layouts.app.front-app')
@section('title', 'Investor Dashboard - '.env('APP_NAME'))
@section('content')
@php
    // dd($session_data);
    // dd($my_investor_profile);
@endphp
<section class="my-dashbord">
    <div class="container">
        <div class="row">
            @include('layouts.front.left_dashboard')
            <div class="col-lg-9">
                <div class="right-panal-side">
                    @include('layouts.front.header_dashboard')
                    <!-- Sell Your business section start -->
                        <div class="row mt-3 padding-no">
                            <div class="letest-activity">
                                <div class="col-lg-12 sell-busi-activity">
                                    {{-- <div>
                                        <h3 class="activity-hading">Sell Your business ({{count($investor_accepted_sender_data) + count($investor_accepted_receiver_data) + count($investor_receive_request_data)}})</h3>
                                    </div> --}}
                                    {{-- <div class="add-bussines-new">
                                        <a href="#"><i class="far fa-plus"></i>Add Business</a>
                                    </div> --}}
                                </div>
                                @if(!empty($my_investor_profile))
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="sell-yiur-bussinrs-activity-listing margin-top-foruthy">
                                                <div class="left-text">
                                                    <h3 class="activity-hading">My Investor Profile</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mt-3">
                                            <div class="business-detail-box sell-bussines-box">
                                                {{-- <div class="new-activity-task">
                                                    <div class="border-bottom-line">
                                                        <div class="text-city-name">
                                                            <p class="mb-0">New activity in <span><b>Gujrat</b></span> and <span><b>Application Software</b></span></p>
                                                        </div>
                                                        <div class="time-hour-text">
                                                           <p class="mb-0"><i class="fal fa-clock"></i> 1 day, <span>18  hours ago</span></p>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div class="frist-box">
                                                    <div class="title-hading-main">
                                                        <a href="{{ url('investor-detail',$my_investor_profile->vUniqueCode) }}" class="main-title" style="display: inline-block;">
                                                            <h2>{{$my_investor_profile->vInvestorProfileName}} </h2>
                                                        </a><span class="new-rating">Rating<i class="fas fa-star" style="color: var(--yellowcolor); margin-left: 7px; margin-right: 5px;"></i>

                                                             @if($my_investor_profile->vAverageRating == NULL || $my_investor_profile->vAverageRating == 0)
                                                                    {{'No Rating'}}
                                                                @else
                                                                    {{$my_investor_profile->vAverageRating}}
                                                                @endif 
                                                                {{-- 8.5 / 10  --}}
                                                            </span>
                                                            @if($my_investor_profile->eAdminApproval == 'Pending')
                                                        <p class="text-warning">{{'Admin Approval is Pending'}} </p>
                                                    @endif
                                                    </div>
                                                    <div class="frist-box-part mt-3 listing-detail-main">
                                                        <div class="row">
                                                            <div class="col-md-3 col-sm-4">
                                                                <div class="business-box-img">
                                                                    @php
                                                                       $current_image = '';
                                                                            $current_image_status = '';
                                                                        @endphp
                                                                        @if (!empty($my_investor_profile->vImage) && file_exists(public_path('uploads/investor/profile/' . $my_investor_profile->vImage)) )
                                                                            @php
                                                                                $current_image = 'uploads/investor/profile/' . $my_investor_profile->vImage;
                                                                            @endphp
                                                                        @else
                                                                            @php
                                                                                $current_image_status = 'w-100';
                                                                                $current_image = 'uploads/no-image.png';
                                                                            @endphp
                                                                        @endif
                                                                    <img src="{{ asset($current_image) }}" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9 col-sm-8">
                                                                <div class="">
                                                                    <p class="advisor-detail-info">- {{$my_investor_profile->tInvestorProfileDetail}}.</p>
                                                                </div>
                                                                <div class="new-saling-text">
                                                                    <ul>
                                                                        <li class="full-sale-detail">
                                                                            <label><b>@if (isset($my_investor_profile) and $my_investor_profile->eAcquiringBusiness == 'Yes') {{ '- Acquiring / Buying a Business' }} @endif</b></label><br>
                                                                            <label><b>@if (isset($my_investor_profile) and $my_investor_profile->eInvestingInBusiness == 'Yes') {{ '- Investing in a Business' }}@endif</b></label><br>
                                                                            <label><b>@if (isset($my_investor_profile) and $my_investor_profile->eLendingToBusiness == 'Yes') {{ '- Lending to a Business' }}@endif</b></label><br>
                                                                            <label><b>@if (isset($my_investor_profile) and $my_investor_profile->eBuyingProperty == 'Yes') {{ '- Buying Property' }}@endif</b></label><br>
                                                                            <!-- <p class="mb-0">KES 95 lakh</p> -->
                                                                        </li>
                                                                        <li class="run-rate-revenu">
                                                                            <label><b>How Much Invest</b></label>
                                                                            <!-- <p class="mb-0">KES 48 lakh @ 15 % EBITDA</p> -->
                                                                            <p class="mb-0">KES 
                                                                                @if (isset($my_investor_profile) and $my_investor_profile->vHowMuchInvest == '100K - 1M') {{ '100K - 1M' }} @endif
                                                                                @if (isset($my_investor_profile) and $my_investor_profile->vHowMuchInvest == '1M - 5M') {{ '1M - 5M' }} @endif
                                                                                @if (isset($my_investor_profile) and $my_investor_profile->vHowMuchInvest == '5M - 10M') {{ '5M - 10M' }} @endif
                                                                                @if (isset($my_investor_profile) and $my_investor_profile->vHowMuchInvest == '10M+') {{ '10M+' }} @endif
                                                                            </p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="view-peofile-btn listing-button-view">
                                                        <a href="@if($my_investor_profile->eAdminApproval == 'Approved') {{ url('investor-detail',$my_investor_profile->vUniqueCode)}} @endif" class="sell-busines-view-profile btn btn-primary bg-green">View Profile</a></br>
                                                        <a href="{{ url('investor-edit',$my_investor_profile->vUniqueCode)}}" class="sell-busines-view-profile btn btn-primary bg-blue">Edit Investor Profile</a>
                                                        <a href="@if($my_investor_profile->eAdminApproval == 'Approved') {{ url('investor-detail',$my_investor_profile->vUniqueCode)}} @endif" class="btn btn-primary bg-orange">Contact Bussines</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                               <!--  <div class="row">
                                    @foreach($investor_accepted_sender_data as $key =>$sValue)
                                    <div class=" col-xl-4 col-lg-6 col-md-6 col-12 mt-3">
                                        <div class="sell-busi-box-warp">
                                            <div class="bussines-sell-box-detail">
                                                <h5 class="heading">{{$sValue->vSenderContactPersonName}}</h5>
                                                <p>{{$sValue->vSenderProfileTitle}}</p>
                                            </div>
                                            <div class="bussines-sell-box-number">
                                                <h6>20</h6>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                     @foreach($investor_accepted_receiver_data as $key =>$rValue)
                                    <div class=" col-xl-4 col-lg-6 col-md-6 col-12 mt-3">
                                        <div class="sell-busi-box-warp">
                                            <div class="bussines-sell-box-detail">
                                                <h5 class="heading">{{$rValue->vReceiverProfileTitle}}</h5>
                                                <p>{{$rValue->vReceiverContactPersonName}}</p>
                                            </div>
                                            <div class="bussines-sell-box-number">
                                                <h6>20</h6>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>      -->                           
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('custom-js')
<script>
    $(document).on('click', '#accept', function() {
        var iConnectionId = $(this).data("id");
            $.ajax({
                url: "{{ url('accept_reject_connection') }}",
                type: "POST",
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                data: {
                    iConnectionId: iConnectionId,connectionType:'accept'
                },
                success: function(response) {
                    if(response == 0){
                        //    location.reload();
                    }   
                }
            });        
    });
      $(document).on('click', '#reject', function() {
        var iConnectionId = $(this).data("id");
        $.ajax({
            url: "{{ url('accept_reject_connection_investor') }}",
            type: "POST",
            headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
            data: {
                iConnectionId: iConnectionId,connectionType:'reject'
            },
            success: function(response) {
                if(response == 0){
                       // location.reload();
                }   
            }
        });        
    });
</script>
@endsection