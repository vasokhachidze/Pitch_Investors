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
            <div class="business-detail-box">
                <div class="frist-box" style="cursor: pointer;">
                    <!-- <div class="status-bar-name">
                        <a href=""><i class="fas fa-circle"></i> Serviced Apartment Investment Opportunity in Pune, India</a>
                    </div> -->
                    <a class='detailPageLink' href="{{ route('front.investment.detail', $value->vUniqueCode) }}">
                        <h2>
                            @if (!empty($value->vBusinessProfileName))
                             {{(strlen($value->vBusinessProfileName) > 25) ? substr($value->vBusinessProfileName,0,25).'...' : $value->vBusinessProfileName}}
                            @else
                                {{ 'N/A' }}
                            @endif
                        </h2>
                    </a>
                    <div class="social-info-detail detailPageLink" data-id="{{ route('front.investment.detail', $value->vUniqueCode) }}">
                        <ul>
                            <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Email Verified"><i class="fal fa-envelope"></i>Email</a></li>
                            <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Phone Verified"><i class="far fa-phone-alt"></i>Phone</a></li>
                            {{-- <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Google Verified"><i class="fab fa-google-plus-g"></i> Google</a></li>
                            <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Not Linkdin Verified" class="disable"><i class="fab fa-linkedin"></i> Linkdin</a></li> --}}
                        </ul>
                    </div>                    
                    <div class="new-box-detail-img detailPageLink" data-id="{{ route('front.investment.detail', $value->vUniqueCode) }}">
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
                    <ul class="business-box-text detailPageLink" data-id="{{ route('front.investment.detail', $value->vUniqueCode) }}">
                        <li class="rating">
                            <p class="m-0"><i class="fas fa-star" style="color: var(--yellowcolor);"></i>
                                @if($value->vAverageRating == NULL || $value->vAverageRating == 0)
                                    {{'No Rating'}}
                                @else
                                    {{$value->vAverageRating}}
                                @endif 
                                </p>
                            
                        </li>
                        <li class="location">
                            <p class="m-0"><i class="fas fa-map-marker-alt" style="color: #939292;"></i> {{$locationName}}</p>
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




