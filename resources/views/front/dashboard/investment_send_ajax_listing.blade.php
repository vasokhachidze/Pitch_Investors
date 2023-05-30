@php
    // dd($send_request);
@endphp
@foreach ($send_request as $key => $value)
    @if($value->eReceiverProfileType == 'Investor')
       @foreach($receiverInvestorData as $key => $investvalue)
            <div class="col-lg-12 mt-3">
                <div class="business-detail-box sell-bussines-box">
                    <div class="new-activity-task">
                        <div class="border-bottom-line">
                            <div class="text-city-name">
                                <p class="mb-0">New activity in <span><b>Gujrat</b></span> and <span><b>Application Software</b></span></p>
                            </div>
                            <div class="time-hour-text">
                                <p class="mb-0"><i class="fal fa-clock"></i> 1 day, <span>18  hours ago</span></p>
                            </div>
                        </div>
                    </div>
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
                                                <label><b>@if ($investvalue->eAcquiringBusiness == 'Yes') {{ 'Acquiring / Buying a Business' }}@endif</b></label>
                                                <label><b>@if ($investvalue->eInvestingInBusiness == 'Yes') {{ 'Investing in a Business' }}@endif</b></label>
                                                <label><b>@if ($investvalue->eLendingToBusiness == 'Yes') {{ 'Lending to a Business' }}@endif</b></label>
                                                <label><b>@if ($investvalue->eBuyingProperty == 'Yes') {{ 'Buying Property' }}@endif</b></label>
                                                <!-- <p class="mb-0">KES 95 lakh</p> -->
                                            </li>
                                            <li class="run-rate-revenu">
                                                <label><b>How Much Invest</b></label>
                                                <!-- <p class="mb-0">KES 48 lakh @ 15 % EBITDA</p> -->
                                                <p class="mb-0">KES @if ($investvalue->vHowMuchInvest == '100K - 1M') {{ '100K - 1M' }} @endif
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

    @if($value->eReceiverProfileType == 'Advisor')
       @foreach($receiverAdvisorData as $key => $advValue)
         <div class="col-lg-12 mt-3">
            <div class="business-detail-box sell-bussines-box">
                <div class="new-activity-task">
                    <div class="border-bottom-line">
                        <div class="text-city-name">
                            <p class="mb-0">New activity in <span><b>Gujrat</b></span> and <span><b>Application Software</b></span></p>
                        </div>
                        <div class="time-hour-text">
                            <p class="mb-0"><i class="fal fa-clock"></i> 1 day, <span>18  hours ago</span></p>
                        </div>
                    </div>
                </div>
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
