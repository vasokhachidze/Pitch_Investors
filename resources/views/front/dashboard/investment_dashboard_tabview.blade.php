@extends('layouts.app.front-app')
@section('title', 'Investor Dashboard - '.env('APP_NAME'))

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
                          <button class="tablinks active" onclick="openProfile(event, 'Investor')">Investor</button>
                          <button class="tablinks" onclick="openProfile(event, 'Advisor')">Advisor</button>
                      </div>
                      <!-- Investor tab start-->
                      <div id="Investor" class="tabcontent">
                            @if(count($received_request) > 0 ||  !empty($received_request))
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="sell-yiur-bussinrs-activity-listing margin-top-foruthy">
                                            <div class="left-text">
                                                <h3 class="activity-hading mt-4">My Received Connection</h3>
                                            </div>
                                        </div>
                                    </div>
                                    @if(!empty($senderInvestorData))
                                      @foreach($received_request as $key => $value)                                            
                                       @if($value->eSenderProfileType == 'Investor')
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
                                                                    <p class="advisor-detail-info">- {{$value->tBusinessProfileDetail}}</p>
                                                                </div>
                                                                <div class="new-saling-text">
                                                                    <ul>
                                                                       <li class="full-sale-detail">
                                                                            <label><b>@if ($investvalue->eAcquiringBusiness == 'Yes') {{ '- Acquiring / Buying a Business' }}  @endif</b></label></br>
                                                                            <label><b>@if ($investvalue->eInvestingInBusiness == 'Yes') {{ '- Investing in a Business' }}  @endif</b></label></br>
                                                                            <label><b>@if ($investvalue->eLendingToBusiness == 'Yes') {{ '- Lending to a Business' }}  @endif</b></label></br>
                                                                            <label><b>@if ($investvalue->eBuyingProperty == 'Yes') {{ '- Buying Property' }}  @endif</b></label></br>
                                                                            <!-- <p class="mb-0">KES 95 lakh</p> -->
                                                                        </li>
                                                                        <li class="run-rate-revenu">
                                                                            <label><b>How Much Invest</b></label>
                                                                            <!-- <p class="mb-0">KES 48 lakh @ 15 % EBITDA</p> -->
                                                                            <p class="mb-0"><label class="kesSmall" style="font-size: 12px;">KES</label> @if ($investvalue->vHowMuchInvest == '100K - 1M') {{ '100K - 1M' }} @endif
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

                            @if(count($send_request) > 0 ||  !empty($send_request))

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="sell-yiur-bussinrs-activity-listing margin-top-foruthy">
                                            <div class="left-text">
                                                <h3 class="activity-hading mt-4">My Send Connection</h3>
                                            </div>
                                        </div>
                                    </div>
                                    @if(!empty($receiverInvestorData))
                                     @foreach($send_request as $key => $value)
                                      @if($value->eReceiverProfileType == 'Investor')
                                        @foreach($receiverInvestorData as $key => $investvalue)
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
                                                                    <p class="advisor-detail-info">- {{$investvalue->tInvestorProfileDetail}}</p>
                                                                </div>
                                                                <div class="new-saling-text">
                                                                    <ul>
                                                                        <li class="full-sale-detail">
                                                                            <label><b>@if ($investvalue->eAcquiringBusiness == 'Yes') {{ '- Acquiring / Buying a Business' }} @endif</b></label> </br>
                                                                            <label><b>@if ($investvalue->eInvestingInBusiness == 'Yes') {{ '- Investing in a Business' }} @endif</b></label> </br>
                                                                            <label><b>@if ($investvalue->eLendingToBusiness == 'Yes') {{ '- Lending to a Business' }} @endif</b></label> </br>
                                                                            <label><b>@if ($investvalue->eBuyingProperty == 'Yes') {{ '- Buying Property' }} @endif</b></label> </br>
                                                                            <!-- <p class="mb-0">KES 95 lakh</p> -->
                                                                        </li>
                                                                        <li class="run-rate-revenu">
                                                                            <label><b>How Much Invest</b></label>
                                                                            <!-- <p class="mb-0">KES 48 lakh @ 15 % EBITDA</p> -->
                                                                            <p class="mb-0"><label class="kesSmall" style="font-size: 12px;">KES</label> @if ($investvalue->vHowMuchInvest == '100K - 1M') {{ '100K - 1M' }} @endif
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
                      <!-- investment tab end-->

                        <div id="Advisor" class="tabcontent" style="display:none">
                            @if(count($received_request) > 0 ||  !empty($received_request))
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="sell-yiur-bussinrs-activity-listing margin-top-foruthy">
                                            <div class="left-text">
                                                <h3 class="activity-hading mt-4">My Received Connection</h3>
                                            </div>
                                        </div>
                                    </div>
                                    @if(!empty($senderAdvisorData))
                                        @foreach($received_request as $key => $rValue)                                            
                                          @if($value->eSenderProfileType == 'Advisor')
                                            @foreach($senderAdvisorData as $key => $advValue)
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
                                                                <h2> {{$value->vReceiverProfileTitle}} </h2>
                                                            </a><span class="new-rating">Rating<i class="fas fa-star" style="color: var(--yellowcolor); margin-left: 7px; margin-right: 5px;"></i>
                                                                    @if($advValue->vAverageRating == NULL || $advValue->vAverageRating == 0)
                                                                        {{'No Rating'}}
                                                                    @else
                                                                        {{$advValue->vAverageRating}}
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
                                                                        @if (!empty($advValue->vImage) && file_exists('uploads/advisor/profile/' . $advValue->vImage) )
                                                                        @php
                                                                        $current_image = 'uploads/advisor/profile/' . $advValue->vImage;
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
                                                                        <p class="advisor-detail-info">- {{$advValue->tAdvisorProfileDetail}}</p>
                                                                    </div>
                                                                    <div class="new-saling-text">
                                                                        <ul>
                                                                            <!-- <li class="full-sale-detail">
                                                                                <label><b>Full Sale</b></label>
                                                                                <p class="mb-0">KES 95 lakh</p>
                                                                            </li>
                                                                            <li class="run-rate-revenu">
                                                                                <label><b>Run Rate Revenue</b></label>
                                                                                <p class="mb-0">KES 48 lakh @ 15 % EBITDA</p>
                                                                            </li> -->
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="view-peofile-btn listing-button-view">
                                                            <a href="{{ url('advisor-detail',$advValue->vUniqueCode)}}" class="btn btn-primary bg-orange">Contact Bussines</a>
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

                            @if(count($send_request) > 0 ||  !empty($send_request))
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="sell-yiur-bussinrs-activity-listing margin-top-foruthy">
                                        <div class="left-text">
                                            <h3 class="activity-hading mt-4">My Send Connection</h3>
                                        </div>
                                    </div>
                                </div>
                                @if(!empty($receiverAdvisorData))
                                    @foreach($send_request as $key => $value)
                                      @if($value->eReceiverProfileType == 'Advisor')
                                       @foreach($receiverAdvisorData as $key => $advValue)
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
                                                            <h2> {{$value->vReceiverProfileTitle}} </h2>
                                                        </a><span class="new-rating">Rating<i class="fas fa-star" style="color: var(--yellowcolor); margin-left: 7px; margin-right: 5px;"></i>
                                                            @if($advValue->vAverageRating == NULL || $advValue->vAverageRating == 0)
                                                                {{'No Rating'}}
                                                            @else
                                                                {{$advValue->vAverageRating}}
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
                                                                        @if (!empty($advValue->vImage) && file_exists('uploads/advisor/profile/' . $advValue->vImage) )
                                                                            @php
                                                                                $current_image = 'uploads/advisor/profile/' . $advValue->vImage;
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
                                                                        <p class="advisor-detail-info">- {{$advValue->tAdvisorProfileDetail}}</p>
                                                                </div>
                                                                <div class="new-saling-text">
                                                                    <ul>
                                                                        <!-- <li class="full-sale-detail">
                                                                            <label><b>Full Sale</b></label>
                                                                            <p class="mb-0">KES 95 lakh</p>
                                                                        </li>
                                                                        <li class="run-rate-revenu">
                                                                            <label><b>Run Rate Revenue</b></label>
                                                                            <p class="mb-0">KES 48 lakh @ 15 % EBITDA</p>
                                                                        </li> -->
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="view-peofile-btn listing-button-view">
                                                        <a href="{{ url('advisor-detail',$advValue->vUniqueCode)}}" class="btn btn-primary bg-orange">Contact Bussines</a>
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