@if(($data->count()))
@foreach($data as $key => $value)
@php
// dd($value);
// dd($location);
$locationName = 'N/A';
foreach ($location as $key_1 => $value_location) {
foreach ($value_location as $key1 => $value1) {
if ($value1->eLocationType == 'Sub County' && $value->iInvestorProfileId == $value1->iInvestorProfileId) {
$locationName = $value1->vLocationName;
}
}
}
// dd($location[0][0]->vLocationName);
@endphp
<div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 mb-4">
    <div class="business-detail-box">
        <div class="inves-profile detailPageLink" data-id="{{url('investor-detail',$value->vUniqueCode)}}" style="cursor: pointer;">
            <div class="invester-pro-pic">
                <img src="https://www.smergers.com/static/images/xuserimage.jpg.pagespeed.ic.rO7yBwOGY8.webp" alt="">
            </div>
            <div class="pro-detail-investor">
                <a class="detailPageLink" href="{{url('investor-detail',$value->vUniqueCode)}}">
                    <i class="fas fa-circle"></i>
                    @if(!empty($value->vInvestorProfileName))
                    {{(strlen($value->vInvestorProfileName) > 25) ? substr($value->vInvestorProfileName,0,25).'...' : $value->vInvestorProfileName}}
                    @else
                    {{ "N/A" }}
                    @endif
                </a>
                <p class="mb-0 text-p"></p>
            </div>
        </div>
        <div class="frist-box" style="cursor: pointer;">
            <div class="frist-box-part">
                <div class="social-info-detail detailPageLink" data-id="{{url('investor-detail',$value->vUniqueCode)}}" >
                    <ul>
                        <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Email Verified"><i
                                    class="fal fa-envelope"></i>Email</a></li>
                        <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Phone Verified"><i
                                    class="far fa-phone-alt"></i>Phone</a></li>
                        
                    </ul>
                </div>
                <div class="middle-text detailPageLink" data-id="{{url('investor-detail',$value->vUniqueCode)}}">
                    <div class="interests">
                        <p><b>Detail: </b>{{$value->tInvestorProfileDetail}} </p>
                    </div>
                    <!-- <div class="background">
                        <p><b>Background:</b> I am a PhD in engineering with almost 30 years of Industrial business
                            experience.</p>
                    </div> -->
                </div>
                <!-- <div class="business-box-img">
						@php
						$current_image = '';
						@endphp
						@if(!empty($value->vImage) && file_exists(public_path('uploads/investor/profile/' . $value->vImage)))
							@php
							$current_image = 'uploads/investor/profile/'.$value->vImage;
							@endphp
						@else
							@php
							$current_image = 'uploads/default/no-image.png';
							@endphp
						@endif

						<img src="{{asset($current_image)}}" alt="">
					</div> -->
                <ul class="business-box-text mt-2 contect-rating-line detailPageLink" data-id="{{url('investor-detail',$value->vUniqueCode)}}" >
                    <li class="rating">
                        <p class="m-0"><i class="fas fa-star" style="color: var(--yellowcolor);"></i>
                            @if($value->vAverageRating == NULL || $value->vAverageRating == 0)
                                {{'No Rating'}}
                            @else
                                {{$value->vAverageRating}}
                            @endif 
                        </p>
                    </li>
                    <!-- <li class="location">
							<p class="m-0"><i class="fas fa-map-marker-alt" style="color: #939292;"></i> {{-- Kenya --}} {{$locationName}}</p>
						</li> -->
                    <!-- <li class="connect-list">
                        <p>Connected with <b>34 businesses</b></p>
                    </li> -->
                </ul>


                <div class="next-step-new detailPageLink" data-id="{{url('investor-detail',$value->vUniqueCode)}}">
                    <ul>
                        <li class="second-box">
                            <p>City</p>
                            <h5>@if (!empty($value->iCity) ) {{ $value->iCity }}@else {{ 'N/A' }} @endif</h5>
                        </li>
                        <li class="second-box">
                            <p>Industries </p>
                            <h5>
                                @php
                                $nullValue2='';
                                $noIndustry = 0;
                                $industry_tooltip = '';
                                @endphp
                                @foreach($industries as $key => $ivalue)
                                @if(!empty($ivalue[0]->vIndustryName) && ($ivalue[0]->iInvestorProfileId ==
                                $value->iInvestorProfileId))
                                @php
                                $nullValue2='';
                                $noIndustry = 1;
                                @endphp
                                {{ $ivalue[0]->vIndustryName }}

                                @if(count($ivalue) > 1)
                                @if ($key > 0)
                                @php
                                foreach ($ivalue as $key1 => $value1) {
                                if (count($ivalue)-1 > $key1) {
                                    $industry_tooltip.= $value1->vIndustryName.', ';
                                }
                                else{
                                    $industry_tooltip.= $value1->vIndustryName;
                                }
                                }
                                @endphp
                                <lable class='pointer_cursor' data-bs-toggle="tooltip" title="{{$industry_tooltip}}">
                                    + {{count($ivalue) - 1}} More
                                </lable>
                                @endif
                                @endif
                                @else
                                @php
                                $nullValue2='N/A';
                                @endphp
                                @endif
                                @endforeach
                                @if(!empty($nullValue2) && $noIndustry == 0)
                                {{$nullValue2}}
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
                                @if(!empty($value->vHowMuchInvest))
                                {{ $value->vHowMuchInvest}}
                                @else
                                {{ "N/A" }}
                                @endif
                            </h3>
                        </li>
                        <li class="line"></li>
                        <li class="contact-btn investor_ajax_listing_button">
						    <a href="{{url('investor-detail',$value->vUniqueCode)}}">Send Proposal</a>
                        </li>
                    </ul>
                </div>



            </div>

            <!-- <a href="{{url('investor-detail',$value->vUniqueCode)}}">
					<h2>@if(!empty($value->vInvestorProfileName))
						{{$value->vInvestorProfileName}}
						@else
						{{ "N/A" }}
						@endif
					</h2>
				</a> -->
            <!-- <p class="investment-detail-info">
					@if(!empty($value->tInvestorProfileDetail))
					{{$value->tInvestorProfileDetail}}
				
					@else
					{{ "N/A" }}
					@endif
				</p> -->

        </div>
        <ul class="-box-wrapper">
            <!-- <li class="second-box">
                <p>Investment Size</p>
                <h3>
                    @if(!empty($value->vHowMuchInvest))
                    {{ $value->vHowMuchInvest}}
                    @else
                    {{ "N/A" }}
                    @endif
                </h3>
            </li> -->
            <!-- <li class="second-box">
                <p>Locations</p>
                <h5>
                    @php
                    $nullValue='';
                    $noLocation = 0;
                    $tooltip = '';
                    @endphp
                    @foreach($location as $key => $lvalue)
                    @if(!empty($lvalue[0]->vLocationName) && ($lvalue[0]->iInvestorProfileId ==
                    $value->iInvestorProfileId))
                    @php
                    $nullValue='';
                    $noLocation = 1;
                    @endphp
                    @if(count($lvalue) > 1)
                    {{-- @if ($key > 0) --}}
                    @php
                    foreach ($lvalue as $key1 => $value1) {
                    if (count($lvalue)-1 > $key1) {
                    $tooltip.= $value1->vLocationName.', ';
                    }
                    else{
                    $tooltip.= $value1->vLocationName;
                    }
                    }
                    @endphp
                    @if ($value1->eLocationType == 'Sub County')
                    {{ $value1->vLocationName }}
                    @endif
                    {{-- @endif --}}
                    <lable class='pointer_cursor' data-bs-toggle="tooltip" title="{{$tooltip}}">
                        + {{count($lvalue) - 1}} More
                    </lable>
                    @endif
                    @else
                    @php
                    $nullValue='N/A';
                    @endphp
                    @endif
                    @endforeach
                    @if($nullValue == 'N/A' && $noLocation == 0)
                    {{$nullValue}}
                    @endif
                </h5>
            </li>
            <li class="second-box">
                <p>Industries </p>
                <h5>
                    @php
                    $nullValue2='';
                    $noIndustry = 0;
                    $industry_tooltip = '';
                    @endphp
                    @foreach($industries as $key => $ivalue)
                    @if(!empty($ivalue[0]->vIndustryName) && ($ivalue[0]->iInvestorProfileId ==
                    $value->iInvestorProfileId))
                    @php
                    $nullValue2='';
                    $noIndustry = 1;
                    @endphp
                    {{ $ivalue[0]->vIndustryName }}

                    @if(count($ivalue) > 1)
                    @if ($key > 0)
                    @php
                    foreach ($ivalue as $key1 => $value1) {
                    if (count($ivalue)-1 > $key1) {
                    $industry_tooltip.= $value1->vIndustryName.', ';
                    }
                    else{
                    $industry_tooltip.= $value1->vIndustryName;
                    }
                    }
                    @endphp
                    <lable class='pointer_cursor' data-bs-toggle="tooltip" title="{{$industry_tooltip}}">
                        + {{count($ivalue) - 1}} More
                    </lable>
                    @endif
                    @endif
                    @else
                    @php
                    $nullValue2='N/A';
                    @endphp
                    @endif
                    @endforeach
                    @if(!empty($nullValue2) && $noIndustry == 0)
                    {{$nullValue2}}
                    @endif
                </h5>
            </li> -->
          
            <!-- <li class="contact-btn investor_ajax_listing_button">
                <a href="{{url('investor-detail',$value->vUniqueCode)}}">Send Proposal</a>
            </li> -->
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