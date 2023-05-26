@extends('layouts.app.front-app')
@section('title', 'Investment Dashboard ' . env('APP_NAME'))
@section('content')
    @php
        // dd($investment_data);
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
                                    <div>
                                        <h3 class="activity-hading">Your business ({{ count($investment_data) }})</h3>
                                    </div>
                                    <div class="add-bussines-new">
                                        <a href="{{ url('business-instruction') }}"><i class="far fa-plus"></i>Add Business</a>
                                    </div>
                                </div>
                                </br>
                                <div class="row">
                                    @foreach ($investment_data as $key => $value)
                                        @php
                                            /* dd($value); */
                                            $current_image = '';
                                            $current_image_status = '';
                                        @endphp
                                        {{-- <div class=" col-xl-4 col-lg-6 col-md-6 col-12 mt-3 pointer_cursor get_investment_data" id="div_{{ $value->vUniqueCode }}" data-iInvestmentProfileId="{{ $value->iInvestmentProfileId }}" data-iUserId="{{ $value->iUserId }}">
                                            <div class="sell-busi-box-warp">
                                                <div class="bussines-sell-box-detail">
                                                    <h5 class="heading">{{ $value->vBusinessProfileName }} </h5>
                                                </div>
                                                <div class="bussines-sell-box-number">
                                                    <h6>{{ $value->total_received_connection + $value->total_send_connection }}</h6>
                                                </div>
                                                <div class="btn-group dropstart my-change-dropdown" role="group">
                                                    <a type="button" class="btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="toggler-icon top-bar"></span>
                                                        <span class="toggler-icon middle-bar"></span>
                                                        <span class="toggler-icon bottom-bar"></span>
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                        <li><a href="{{ url('investment-edit/' . $value->vUniqueCode) }}" class="dropdown-item" type="button">Edit</a></li>
                                                        @if ($value->eStatus == 'Active')
                                                            <li><a href="javascript:;" class="dropdown-item changeStatus" type="button" data-id="{{ $value->vUniqueCode }}" data-status="Inactive">Inactive</a></li>
                                                        @else
                                                            <li><a href="javascript:;" class="dropdown-item changeStatus" type="button" data-id="{{ $value->vUniqueCode }}" data-status="Active">Active</a></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div> --}}

                                        @if (!empty($value->vImage) && file_exists(public_path('uploads/investment/profile/' . $value->vImage)))
                                            @php
                                                $current_image = 'uploads/investment/profile/' . $value->vImage;
                                            @endphp
                                        @else
                                            @php
                                                /* $current_image_status = 'w-100'; */
                                                $current_image = 'uploads/no-image.png';
                                            @endphp
                                        @endif
                                        @php
                                            $locationName = 'N/A';
                                            foreach ($location as $key_1 => $value_location) {
                                                foreach ($value_location as $key1 => $value1) {
                                                    if ($value1->eLocationType == 'Sub County' && $value->iInvestmentProfileId == $value1->iInvestmentProfileId)
                                                    {
                                                        $locationName = $value1->vLocationName;
                                                    }
                                                }
                                            }
                                        @endphp
                                        <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 mb-4">
                                            <div class="business-detail-box">
                                                <div class="frist-box">
                                                    <!-- <div class="status-bar-name">
                                                        <a href=""><i class="fas fa-circle"></i> Serviced Apartment Investment Opportunity in Pune, India</a>
                                                    </div> -->
                                                    <a href="@if($value->eAdminApproval == 'Approved') {{ route('front.investment.detail', $value->vUniqueCode) }} @endif">
                                                        <h2 class="business-heading-name-size">
                                                            @if (!empty($value->vBusinessProfileName))
                                                                {{ $value->vBusinessProfileName }}
                                                            @else
                                                                {{ 'N/A' }}
                                                            @endif
                                                             @if($value->isNewsletterService == 0 && $value->isSocialMediaService == 0)
                                                            <i class="fal fa-warning" title="You have not opted for any Premium Service"></i>
                                                            @endif
                                                        </h2>
                                                         @if($value->eAdminApproval == 'Pending')
                                                            <p class="text-warning">{{'Admin Approval is Pending'}} </p>
                                                        @endif
                                                    </a>
                                                    <div class="social-info-detail">
                                                        <ul>
                                                            <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Email Verified"><i class="fal fa-envelope"></i>Email</a></li>
                                                            <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Phone Verified"><i class="far fa-phone-alt"></i>Phone</a></li>
                                                        </ul>
                                                    </div>
                            
                                                   <div class="new-box-detail-img">
                                                    <p class="investment-detail-info-read {{$current_image_status}}">
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
                                                   <ul class="business-box-text">
                                                        <li class="rating">
                                                            <p class="m-0"><i class="fas fa-star" style="color: var(--yellowcolor);"></i>
                                                                @if($value->vAverageRating == NULL || $value->vAverageRating == 0)
                                                                    {{'No Rating'}}
                                                                @else
                                                                    {{$value->vAverageRating}}
                                                                @endif 
                                                                {{-- 8.5 / 10  --}}
                                                            </p>
                                                        </li>
                                                        <li class="location">
                                                            <p class="m-0"><i class="fas fa-map-marker-alt" style="color: #939292;"></i> {{$locationName}}</p>
                                                        </li>
                                                    </ul>
                                                    <div class="next-step-new">
                                                        <ul>
                                                            <li class="second-box">
                                                                <p class="mb-0">Annual Revenue </p>
                                                                <h3 class="mb-0">
                                                                @if (!empty($value->vAverateMonthlySales))
                                                                    <label class="kes">KES</label> {{ \App\Helper\GeneralHelper::rupees_format_thaousand_billion_million($value->vAverateMonthlySales) }}
                                                                @else
                                                                    {{ 'N/A' }}
                                                                @endif
                                                                </h3>
                                                            </li>
                                                            <li class="second-box">
                                                                <p class="mb-0">EBITDA Margin </p>
                                                                <h5 class="mb-0">
                                                                @if (!empty($value->vProfitMargin))
                                                                    {{ $value->vProfitMargin }} %
                                                                @else
                                                                    {{ 'N/A' }}
                                                                @endif
                                                                </h5>
                                                            </li>
                                                        </ul>
                                                    </div>
                            
                                                    <div class="final-step-detail one">
                                                        <ul>
                                                            <li class="second-box">
                                                                <p class="mb-0">Financial Investment </p>
                                                                <h3 class="mb-0">
                                                                    @if (!empty($value->vInvestmentAmountStake))
                                                                        <label class="kes">KES</label> {{ \App\Helper\GeneralHelper::rupees_format_thaousand_billion_million($value->vInvestmentAmountStake) }}
                                                                    @else
                                                                        {{ 'N/A' }}
                                                                    @endif
                                                                </h3>
                                                            </li>
                                                            <li class="line"></li>
                                                            <li class="contact-btn investment_ajax_listing_button">
                                                                <a href="{{ route('front.investment.edit', $value->vUniqueCode) }}">Edit Investment</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <ul class="-box-wrapper">
                                                    <!-- <li class="second-box">
                                                        <p>Financial Investment </p>
                                                        <h3>
                                                            @if (!empty($value->vInvestmentAmountStake))
                                                                {{ \App\Helper\GeneralHelper::rupees_format_thaousand_billion_million($value->vInvestmentAmountStake) }}
                                                            @else
                                                                {{ 'N/A' }}
                                                            @endif
                                                        </h3>
                                                    </li> -->
                                                    <!-- <li class="second-box">
                                                        <p>Annual Revenue </p>
                                                        <h5>
                                                            @if (!empty($value->vAverateMonthlySales))
                                                                {{ \App\Helper\GeneralHelper::rupees_format_thaousand_billion_million($value->vAverateMonthlySales) }}
                                                            @else
                                                                {{ 'N/A' }}
                                                            @endif
                                                        </h5>
                                                    </li> -->
                                                    <!-- <li class="second-box">
                                                        <p>EBITDA Margin </p>
                                                        <h5>
                                                            @if (!empty($value->vProfitMargin))
                                                                {{ $value->vProfitMargin }} %
                                                            @else
                                                                {{ 'N/A' }}
                                                            @endif
                                                        </h5>
                                                    </li> -->
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div> {{-- end row --}}
                            </div>
                        </div>

                        <!-- Sell Your business section end -->
                        <div class="row mt-3 padding-no" id="ajax_main_div">
                            <div class="letest-activity">
                                <div id="send_request_div">
                                
                                    <div class="col-lg-12">
                                        <h3 class="activity-hading">My Send Connection request</h3>
                                    </div>

                                    <div class="row" id="investment_send_div">

                                    </div>
                                </div>
                                <div id="received_request_div">
                                    <div class="col-lg-12" id="received_title">
                                        <h3 class="activity-hading mt-4">My Received Connection request</h3>
                                    </div>
                                    
                                    <div class="row" id="investment_received_div">
                                        
                                    </div>
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
        $(document).ready(function() {
            $('#ajax_main_div').hide();
            $('#send_request_div').hide();
            $('#received_request_div').hide();
        });

        var ajax_url = '{{ url('investmentDashboard-ajax') }}';

        $(".get_investment_data").click(function(e) {

            $("#investment_send_div").html('');
            $("#investment_received_div").html('');

            var profile_id = $(this).data('iinvestmentprofileid');
            var iUserId = $(this).data('iuserid');
            $.ajax({
                type: "Post",
                url: ajax_url,
                data: {
                    profile_id: profile_id,
                    iUserId: iUserId,
                },
                dataType: "html",
                headers: {
                    'x-csrf-token': '{{ csrf_token() }}',
                },
                success: function(response) {
                    if(response.length>0){
                        $('#ajax_main_div').show();
                        $('#send_request_div').show();
                        $("#investment_send_div").html(response);
                    }
                    else
                    {
                        console.log('failed');
                        // $('#send_request_div').hide();
                    }
                }
            });
            
            $.ajax({
                type: "Post",
                url: "{{ route('front.dashboard.investmentDashboard-received-ajax') }}",
                data: {
                    profile_id: profile_id,
                    iUserId: iUserId,
                },
                dataType: "html",
                headers: {
                    'x-csrf-token': '{{ csrf_token() }}',
                },
                success: function(response) {
                    
                    if(response.length>0){
                        $('#ajax_main_div').show();
                        $('#received_request_div').show();
                        $("#investment_received_div").html(response);
                    }
                    else
                    {
                        // $('#received_request_div').hide();
                    }
                }
            });
        });

        $(".changeStatus").on("click", function(e) {
            /* if (e.target == this)
            {
                return;
            } */
            var hide_div_id = $(this).data('id');
            var status = $(this).data('status');
            $.ajax({
                type: "Post",
                url: '{{ route('front.investment.changeStatus') }}',
                data: {
                    id: hide_div_id,
                    status: status,
                },
                dataType: "html",
                headers: {
                    'x-csrf-token': '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response) {
                        $('#div_' + hide_div_id).hide();
                    }
                    $('#request_send_div').hide();
                    window.location.href = "{{ route('front.dashboard.investmentDashboard') }}";
                }
            });
        });
    </script>
@endsection
