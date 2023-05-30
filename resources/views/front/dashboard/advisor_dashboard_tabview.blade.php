@extends('layouts.app.front-app')
@section('title', 'Advisor Connection - '.env('APP_NAME'))

@section('content')
@php
    // dd($session_data);
@endphp
<style type="text/css">/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  /*display: none;*/
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>
<section class="my-dashbord">
    <div class="container">
        <div class="row">
            @include('layouts.front.left_dashboard')
            <div class="col-lg-9">
                <div class="right-panal-side">

                    <!-- Sell Your business section start -->
                    <div class="row mt-3 padding-no">
                        <div class="letest-activity">
                         <div class="tab">
                          <button class="tablinks active" onclick="openProfile(event, 'Investment')">Investment</button>
                          <button class="tablinks" onclick="openProfile(event, 'Investor')">Investor</button>
                      </div>
                      <!-- Investment tab start-->
                      <div id="Investment" class="tabcontent">
                            @if(count($advisor_receive_request_data) > 0 ||  !empty($advisor_receive_request_data))
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="sell-yiur-bussinrs-activity-listing margin-top-foruthy">
                                            <div class="left-text">
                                                <h3 class="activity-hading mt-4">My Received Connection</h3>
                                            </div>
                                        </div>
                                    </div>
                                   @if(!empty($senderInvestmentData))
                                    @foreach($advisor_receive_request_data as $key => $rValue)                                            
                                      @if($rValue->eSenderProfileType == 'Investment')
                                        @foreach($senderInvestmentData as $key => $invalue)
                                            <div class="col-lg-12 mt-3">
                                                <div class="business-detail-box sell-bussines-box">
                                                    <!-- <div class="new-activity-task">
                                                        <div class="border-bottom-line">
                                                            <div class="text-city-name">
                                                                <p class="mb-0">New activity in <span><b>Gujrat</b></span> and <span><b>Application Software</b></span></p>
                                                            </div>
                                                            <div class="time-hour-text">
                                                                <p class="mb-0"><i class="fal fa-clock"></i>  1 day, <span>18  hours ago</span></p>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="frist-box">
                                                        <div class="title-hading-main">
                                                            <a href="" class="main-title" style="display: inline-block;">
                                                                <h2>{{$rValue->vSenderProfileTitle}} </h2>
                                                            </a><span class="new-rating">Rating<i class="fas fa-star" style="color: var(--yellowcolor); margin-left: 7px; margin-right: 5px;"></i>
                                                                @if($invalue->vAverageRating == NULL || $invalue->vAverageRating == 0)
                                                                    {{'No Rating'}}
                                                                @else
                                                                    {{$invalue->vAverageRating}}
                                                                @endif 
                                                            </span>
                                                        </div>
                                                        <div class="frist-box-part mt-3 listing-detail-main">
                                                            <div class="row">
                                                                <div class="col-md-3 col-sm-4">
                                                                    <div class="business-box-img">
                                                                        @php
                                                                        $current_image = '';
                                                                        @endphp
                                                                        @if(!empty($invalue->vImage) && file_exists('uploads/investment/profile/' . $invalue->vImage))
                                                                        @php
                                                                        $current_image = 'uploads/investment/profile/'.$invalue->vImage;
                                                                        @endphp
                                                                        @else
                                                                        @php
                                                                        $current_image = 'uploads/default/no-image.png';
                                                                        @endphp
                                                                        @endif
                                                                        <img src="{{asset($current_image)}}" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-9 col-sm-12">
                                                                    <div class="">                                                                        
                                                                        <p class="advisor-detail-info">- {{$invalue->tBusinessProfileDetail}}</p>
                                                                    </div>
                                                                    <div class="new-saling-text">
                                                                        <ul>
                                                                            <li class="full-sale-detail">
                                                                                <label><b>@if ($invalue->eFullSaleBusiness == 'Yes') {{ '- Full sale of business' }} @endif</b></label></br>
                                                                                <label><b>@if ($invalue->ePartialSaleBusiness == 'Yes') {{ '- Partial sale of business/Investment' }} @endif</b></label></br>
                                                                                <label><b>@if ($invalue->eLoanForBusiness == 'Yes') {{ '- Loan for business' }} @endif</b></label></br>
                                                                                <label><b>@if ($invalue->eBusinessAsset == 'Yes') {{ '- Selling or leasing out business asset' }}  @endif</b></label></br>
                                                                                <label><b>@if ($invalue->eBailout == 'Yes') {{ '- Distressed company looking for bailout' }}  @endif</b></label></br>
                                                                                <p class="mb-0"><label class="kesSmall" style="font-size: 12px;">KES</label>  
                                                                                    {{ \App\Helper\GeneralHelper::rupees_format_thaousand_billion_million($invalue->vInvestmentAmountStake) }}</p>
                                                                            </li>
                                                                            <li class="run-rate-revenu">
                                                                                <label><b>Run Rate Revenue</b></label>
                                                                                <p class="mb-0"><label class="kesSmall" style="font-size: 12px;">KES</label> 
                                                                                    {{ \App\Helper\GeneralHelper::rupees_format_thaousand_billion_million($invalue->vAverateMonthlySales) }} @ {{$invalue->vProfitMargin}} % EBITDA
                                                                                </p>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="view-peofile-btn listing-button-view">
                                                            <a href="{{ url('investment-detail',$invalue->vUniqueCode)}}" class="btn btn-primary bg-orange">Contact Bussines</a>                                                            
                                                        </div>                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                       @endif
                                     @endforeach
                                    @else
                                     <div class="row">
                                        <div class="col-lg-12 mt-3">
                                            <div class="business-detail-box sell-bussines-box">                                            
                                                <div class="frist-box">
                                                        <div class="title-hading-main">
                                                        <p class="mb-0"><b>No Connection Found</b></p>
                                                    </div>
                                                </div>                                            
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>                           
                            @endif

                            @if(count($advisor_send_request_data) > 0 || !empty($advisor_send_request_data))
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="sell-yiur-bussinrs-activity-listing margin-top-foruthy">
                                            <div class="left-text">
                                                <h3 class="activity-hading mt-4">My Send Connection</h3>
                                            </div>
                                        </div>
                                    </div>
                                    @if(!empty($receiverInvestmentData))
                                     @foreach($advisor_send_request_data as $key => $iValue)
                                       @if($iValue->eReceiverProfileType == 'Investment')
                                        @foreach($receiverInvestmentData as $key => $invalue)
                                        <div class="col-lg-12 mt-3">
                                            <div class="business-detail-box sell-bussines-box">
                                                <!-- <div class="new-activity-task">
                                                    <div class="border-bottom-line">
                                                        <div class="text-city-name">
                                                            <p class="mb-0">New activity in <span><b>Gujrat</b></span> and <span><b>Application Software</b></span></p>
                                                        </div>
                                                        <div class="time-hour-text">
                                                            <p class="mb-0"><i class="fal fa-clock"></i> 1 day, <span>18  hours ago</span></p>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="frist-box">
                                                    <div class="title-hading-main">
                                                        <a href="" class="main-title" style="display: inline-block;">
                                                            <h2>{{$iValue->vReceiverProfileTitle}} </h2>
                                                        </a><span class="new-rating">Rating<i class="fas fa-star" style="color: var(--yellowcolor); margin-left: 7px; margin-right: 5px;"></i>
                                                                @if($invalue->vAverageRating == NULL || $invalue->vAverageRating == 0)
                                                                    {{'No Rating'}}
                                                                @else
                                                                    {{$invalue->vAverageRating}}
                                                                @endif 
                                                            </span>
                                                    </div>
                                                    <div class="frist-box-part mt-3 listing-detail-main">
                                                        <div class="row">
                                                            <div class="col-md-3 col-sm-4">
                                                                <div class="business-box-img">
                                                                   @php
                                                                   $current_image = '';
                                                                   @endphp
                                                                   @if(!empty($invalue->vImage) && file_exists('uploads/investment/profile/' . $invalue->vImage))
                                                                   @php
                                                                   $current_image = 'uploads/investment/profile/'.$invalue->vImage;
                                                                   @endphp
                                                                   @else
                                                                   @php
                                                                   $current_image = 'uploads/default/no-image.png';
                                                                   @endphp
                                                                   @endif
                                                                   <img src="{{asset($current_image)}}" alt="">
                                                               </div>
                                                           </div>
                                                            <div class="col-md-9 col-sm-8">
                                                                <div class="">
                                                                   <p class="advisor-detail-info">- {{$invalue->tBusinessProfileDetail}}</p>
                                                                </div>
                                                                <div class="new-saling-text">
                                                                    <ul>
                                                                        <li class="full-sale-detail">
                                                                            <label><b>@if ($invalue->eFullSaleBusiness == 'Yes') {{ '- Full sale of business' }}  @endif</b></label></br>
                                                                            <label><b>@if ($invalue->ePartialSaleBusiness == 'Yes') {{ '- Partial sale of business/Investment' }}  @endif</b></label></br>
                                                                            <label><b>@if ($invalue->eLoanForBusiness == 'Yes') {{ '- Loan for business' }}  @endif</b></label></br>
                                                                            <label><b>@if ($invalue->eBusinessAsset == 'Yes') {{ '- Selling or leasing out business asset' }}  @endif</b></label></br>
                                                                            <label><b>@if ($invalue->eBailout == 'Yes') {{ '- Distressed company looking for bailout' }}  @endif</b></label></br>
                                                                            <p class="mb-0"><label class="kesSmall" style="font-size: 12px;">KES</label>  {{$invalue->vInvestmentAmountStake}} lakh</p>
                                                                        </li>
                                                                        <li class="run-rate-revenu">
                                                                            <label><b>Run Rate Revenue</b></label>
                                                                            <p class="mb-0"><label class="kesSmall" style="font-size: 12px;">KES</label>  {{$invalue->vAverateMonthlySales}} lakh @ {{$invalue->vProfitMargin}} % EBITDA</p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="view-peofile-btn listing-button-view">
                                                        <a href="{{ url('investment-detail',$invalue->vUniqueCode)}}" class="btn btn-primary bg-orange">Contact Bussines</a>                                                            
                                                    </div>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                       @endif
                                     @endforeach
                                    @else
                                        <div class="row">
                                            <div class="col-lg-12 mt-3">
                                                <div class="business-detail-box sell-bussines-box">                                            
                                                    <div class="frist-box">
                                                            <div class="title-hading-main">
                                                            <p class="mb-0"><b>No Connection Found</b></p>
                                                        </div>
                                                    </div>                                            
                                                </div>
                                            </div>
                                        </div>
                                   @endif       
                            </div>
                           
                            @endif
                      </div>
                      <!-- Investment tab end-->

                      <div id="Investor" class="tabcontent" style="display:none">
                            @if(count($advisor_receive_request_data) > 0 || !empty($advisor_receive_request_data))
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="sell-yiur-bussinrs-activity-listing margin-top-foruthy">
                                            <div class="left-text">
                                                <h3 class="activity-hading mt-4">My Received Connection</h3>
                                            </div>
                                        </div>
                                    </div>
                                    @if(!empty($senderInvestorData))
                                     @foreach($advisor_receive_request_data as $key => $rValue)                                            
                                       @if($rValue->eSenderProfileType == 'Investor')
                                        @foreach($senderInvestorData as $key => $investvalue)
                                        <div class="col-lg-12 mt-3">
                                            <div class="business-detail-box sell-bussines-box">
                                               <!--  <div class="new-activity-task">
                                                    <div class="border-bottom-line">
                                                        <div class="text-city-name">
                                                            <p class="mb-0">New activity in <span><b>Gujrat</b></span> and <span><b>Application Software</b></span></p>
                                                        </div>
                                                        <div class="time-hour-text">
                                                            <p class="mb-0"><i class="fal fa-clock"></i> 1 day, <span>18  hours ago</span></p>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="frist-box">
                                                    <div class="title-hading-main">
                                                        <a href="" class="main-title" style="display: inline-block;">
                                                            <h2> {{$rValue->vReceiverProfileTitle}} </h2>
                                                        </a><span class="new-rating">Rating<i class="fas fa-star" style="color: var(--yellowcolor); margin-left: 7px; margin-right: 5px;"></i>
                                                                @if($investvalue->vAverageRating == NULL || $investvalue->vAverageRating == 0)
                                                                    {{'No Rating'}}
                                                                @else
                                                                    {{$c->vAverageRating}}
                                                                @endif 
                                                            </span>
                                                    </div>
                                                    <div class="frist-box-part mt-3 listing-detail-main">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="business-box-img">
                                                                  @php
                                                                  $current_image = '';
                                                                  $current_image_status = '';
                                                                  @endphp
                                                                  @if (!empty($investvalue->vImage) && file_exists('uploads/investor/profile/' . $investvalue->vImage) )
                                                                  @php
                                                                  $current_image = 'uploads/investor/profile/' . $investvalue->vImage;
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
                                                            <div class="col-md-9">
                                                                <div class="">
                                                                    <p class="advisor-detail-info">-@if(isset($investvalue->tBusinessProfileDetail)) {{$investvalue->tBusinessProfileDetail}} @endif</p>
                                                                </div>
                                                                <div class="new-saling-text">
                                                                    <ul>
                                                                       <li class="full-sale-detail">
                                                                            <label><b>@if ($investvalue->eAcquiringBusiness == 'Yes') {{ '- Acquiring / Buying a Business' }}@endif</b></label></br>
                                                                            <label><b>@if ($investvalue->eInvestingInBusiness == 'Yes') {{ '- Investing in a Business' }}@endif</b></label></br>
                                                                            <label><b>@if ($investvalue->eLendingToBusiness == 'Yes') {{ '- Lending to a Business' }}@endif</b></label></br>
                                                                            <label><b>@if ($investvalue->eBuyingProperty == 'Yes') {{ '- Buying Property' }}@endif</b></label></br>
                                                                            <!-- <p class="mb-0">KES 95 lakh</p> -->
                                                                        </li>
                                                                        <li class="run-rate-revenu">
                                                                            <label><b>How Much Invest</b></label>
                                                                            <!-- <p class="mb-0">KES 48 lakh @ 15 % EBITDA</p> -->
                                                                            <p class="mb-0"><label class="kesSmall" style="font-size: 12px;">KES</label>  @if ($investvalue->vHowMuchInvest == '100K - 1M') {{ '100K - 1M' }} @endif
                                                                                @if ($investvalue->vHowMuchInvest == '1M - 5M') {{ '1M - 5M' }} @endif
                                                                                @if ($investvalue->vHowMuchInvest == '5M - 10M') {{ '5M - 10M' }} @endif
                                                                                @if ($investvalue->vHowMuchInvest == '10M+') {{ '10M+' }} @endif

                                                                            </p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="view-peofile-btn listing-button-view">
                                                        <a href="{{ url('investor-detail',$investvalue->vUniqueCode)}}" class="btn btn-primary bg-orange">Contact Bussines</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        @endforeach
                                       @endif
                                      @endforeach
                                    @else
                                        <div class="row">
                                            <div class="col-lg-12 mt-3">
                                                <div class="business-detail-box sell-bussines-box">                                            
                                                    <div class="frist-box">
                                                            <div class="title-hading-main">
                                                            <p class="mb-0"><b>No Connection Found</b></p>
                                                        </div>
                                                    </div>                                            
                                                </div>
                                            </div>
                                        </div>
                                    @endif    
                                </div>
                            
                            @endif

                            @if(count($advisor_send_request_data) > 0 || !empty($advisor_receive_request_data))
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="sell-yiur-bussinrs-activity-listing margin-top-foruthy">
                                        <div class="left-text">
                                            <h3 class="activity-hading mt-4">My Send Connection</h3>
                                        </div>
                                    </div>
                                </div>
                                @if(!empty($receiverInvestorData))
                                 @foreach($advisor_send_request_data as $key => $iValue)
                                  @if($iValue->eReceiverProfileType == 'Investor')
                                    @foreach($receiverInvestorData as $key => $investvalue)
                                    <div class="col-lg-12 mt-3">
                                        <div class="business-detail-box sell-bussines-box">
                                           <!--  <div class="new-activity-task">
                                                <div class="border-bottom-line">
                                                    <div class="text-city-name">
                                                        <p class="mb-0">New activity in <span><b>Gujrat</b></span> and <span><b>Application Software</b></span></p>
                                                    </div>
                                                    <div class="time-hour-text">
                                                        <p class="mb-0"><i class="fal fa-clock"></i> 1 day, <span>18  hours ago</span></p>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="frist-box">
                                                <div class="title-hading-main">
                                                    <a href="" class="main-title" style="display: inline-block;">
                                                        <h2> {{$value->vReceiverProfileTitle}} </h2>
                                                    </a><span class="new-rating">Rating<i class="fas fa-star" style="color: var(--yellowcolor); margin-left: 7px; margin-right: 5px;"></i>
                                                            @if($investvalue->vAverageRating == NULL || $investvalue->vAverageRating == 0)
                                                                {{'No Rating'}}
                                                            @else
                                                                {{$investvalue->vAverageRating}}
                                                            @endif 
                                                        </span>
                                                </div>
                                                <div class="frist-box-part mt-3 listing-detail-main">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="business-box-img">
                                                              @php
                                                              $current_image = '';
                                                              $current_image_status = '';
                                                              @endphp
                                                              @if (!empty($investvalue->vImage) && file_exists('uploads/investor/profile/' . $investvalue->vImage) )
                                                              @php
                                                              $current_image = 'uploads/investor/profile/' . $investvalue->vImage;
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
                                                      <div class="col-md-9">
                                                            <div class="">
                                                                <p class="advisor-detail-info">- {{$investvalue->tBusinessProfileDetail}}</p>
                                                            </div>
                                                            <div class="new-saling-text">
                                                                <ul>
                                                                   <li class="full-sale-detail">
                                                                        <label><b>@if ($investvalue->eAcquiringBusiness == 'Yes') {{ '- Acquiring / Buying a Business' }}@endif</b></label></br>
                                                                        <label><b>@if ($investvalue->eInvestingInBusiness == 'Yes') {{ '- Investing in a Business' }}@endif</b></label></br>
                                                                        <label><b>@if ($investvalue->eLendingToBusiness == 'Yes') {{ '- Lending to a Business' }}@endif</b></label></br>
                                                                        <label><b>@if ($investvalue->eBuyingProperty == 'Yes') {{ '- Buying Property' }}@endif</b></label></br>
                                                                        <!-- <p class="mb-0">KES 95 lakh</p> -->
                                                                    </li>
                                                                    <li class="run-rate-revenu">
                                                                        <label><b>How Much Invest</b></label>
                                                                        <!-- <p class="mb-0">KES 48 lakh @ 15 % EBITDA</p> -->
                                                                        <p class="mb-0"><label class="kesSmall" style="font-size: 12px;">KES</label>  @if ($investvalue->vHowMuchInvest == '100K - 1M') {{ '100K - 1M' }} @endif
                                                                            @if ($investvalue->vHowMuchInvest == '1M - 5M') {{ '1M - 5M' }} @endif
                                                                            @if ($investvalue->vHowMuchInvest == '5M - 10M') {{ '5M - 10M' }} @endif
                                                                            @if ($investvalue->vHowMuchInvest == '10M+') {{ '10M+' }} @endif

                                                                        </p>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="view-peofile-btn listing-button-view">
                                                    <a href="{{ url('investor-detail',$investvalue->vUniqueCode)}}" class="btn btn-primary bg-orange">Contact Bussines</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    @endforeach
                                   @endif
                                  @endforeach
                                  @else
                                    <div class="row">
                                        <div class="col-lg-12 mt-3">
                                            <div class="business-detail-box sell-bussines-box">                                            
                                                <div class="frist-box">
                                                        <div class="title-hading-main">
                                                        <p class="mb-0"><b>No Connection Found</b></p>
                                                    </div>
                                                </div>                                            
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>                        
                        @endif
                      </div>
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


      // for tab
function openProfile(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
@endsection