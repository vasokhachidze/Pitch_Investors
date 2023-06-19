@php
    // dd($location);
@endphp
@if ($data->count())
    @foreach ($data as $key => $value)
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
            foreach ($location as $key_1 => $value_location) {
                foreach ($value_location as $key1 => $value1) {
                    if ($value1->eLocationType == 'Sub County' && $value->iInvestmentProfileId == $value1->iInvestmentProfileId)
                    {
                        $locationName = $value1->vLocationName;
                    }
                }
            }
            /* if (!empty($location[$key])) {
                $locationName = $location[$key][0]->vLocationName;
            } */
        @endphp

        <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 mb-4">
            <div class="business-detail-box border-0">
                <div style="pointer-events:none; top:30px; width: 100%; height:160px; overflow:hidden;">
                    <img src="{{ asset('/front/assets/images/image_test.png') }}" class="w-100">
                </div>

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
                            <img src="{{ asset('/front/assets/images/pitch.svg') }}" alt="" class="me-2">
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
    @endforeach
    @if(($total_record >= 10))
        <tr>
            <td colspan="7" align="center">
                <div class="paginations">
                    <?php echo $paging; ?>
                </div>
            </td>
        </tr>
    @endif
@else
    <tr class="text-center">
        <td colspan="9">No Record Found</td>
    </tr>
@endif




