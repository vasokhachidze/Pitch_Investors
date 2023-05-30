@if(($data->count()))
@foreach($data as $key => $value)
    @php
        $locationName = 'N/A';
        foreach ($location as $key_1 => $value_location) {
            foreach ($value_location as $key1 => $value1) {
                if ($value1->eLocationType == 'Sub County' && $value->iAdvisorProfileId ==  $value1->iAdvisorProfileId) {
                    $locationName = $value1->vLocationName;
                }
            }
        }
    @endphp
<div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 mb-4">
    <div class="business-detail-box">
        <div class="frist-box"  style="cursor: pointer;">
           <!--  <div class="status-bar-name">
                <a href=""><i class="fas fa-circle"></i> Serviced Apartment Investment Opportunity in Pune, India</a>
            </div> -->

            <a class="detailPageLink" href="{{url('advisor-detail',$value->vUniqueCode)}}">
                <h2>
                    @if(!empty($value->vAdvisorProfileTitle))
                    {{(strlen($value->vAdvisorProfileTitle) > 25) ? substr($value->vAdvisorProfileTitle,0,25).'...' : $value->vAdvisorProfileTitle}}
                    @else
                        {{ "N/A" }}
                    @endif
                </h2>
            </a>
            <div class="social-info-detail detailPageLink" data-id="{{url('advisor-detail',$value->vUniqueCode)}}">
                <ul>
                    <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Email Verified"><i class="fal fa-envelope"></i>Email</a></li>
                    <li><a href="" data-bs-toggle="tooltip" data-bs-placement="top" title="Phone Verified"><i class="far fa-phone-alt"></i>Phone</a></li>
                    
                </ul>
            </div>
            <div class="new-box-detail-img detailPageLink" data-id="{{url('advisor-detail',$value->vUniqueCode)}}" >
                <p class="investment-detail-info-read">
                    @if(!empty($value->tAdvisorProfileDetail))
                        {{strip_tags($value->tAdvisorProfileDetail)}}
                    @else
                        {{ "N/A" }}
                    @endif
                </p>
                <div class="business-box-img">
                    @php
                        $current_image = '';
                    @endphp
                    @if(!empty($value->vImage) && file_exists(public_path('uploads/business-advisor/profile/'.$value->vImage)))
                        @php
                            $current_image = 'uploads/business-advisor/profile/'.$value->vImage;
                        @endphp
                    @else
                        @php
                            $current_image = 'uploads/default/no-image.png';
                        @endphp
                    @endif
                    <img src="{{ asset($current_image) }}" alt="{{asset('uploads/business-advisor/profile/'.$value->vImage)}}">
                </div>
            </div>


            <div class="frist-box-part detailPageLink" data-id="{{url('advisor-detail',$value->vUniqueCode)}}">
                <!-- <div class="business-box-img">
                    @php
                        $current_image = '';
                    @endphp
                    @if(!empty($value->vImage) && file_exists(public_path('uploads/business-advisor/profile/' . $value->vImage)))
                        @php
                            $current_image = 'uploads/business-advisor/profile/'.$value->vImage;
                        @endphp
                    @else
                        @php
                            $current_image = 'uploads/default/no-image.png';
                        @endphp
                    @endif

                    <img src="{{asset($current_image)}}" alt="">
                </div> -->
                <ul class="business-box-text mt-3">
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
                        <p class="m-0"><i class="fas fa-map-marker-alt" style="color: #939292;"></i>{{$locationName}}</p>
                    </li>
                </ul>
            </div>

            <div class="next-step-new detailPageLink" data-id="{{url('advisor-detail',$value->vUniqueCode)}}">
                <ul>
                    <li class="second-box">
                    <p>Locations</p>
                    <h5>
                    @php
                        $nullValue='';
                        $noLocation = 0;
                        $tooltip = '';
                    @endphp
                    @foreach($location as $key => $lvalue)
                        @if(!empty($lvalue[0]->vLocationName) && ($lvalue[0]->iAdvisorProfileId == $value->iAdvisorProfileId))
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
                                        {{$value1->vLocationName}}
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
                        $noLocation = 0;
                    @endphp
                    @foreach($industries as $key => $ivalue)
                        @if(!empty($ivalue[0]->vIndustryName) && ($ivalue[0]->iAdvisorProfileId == $value->iAdvisorProfileId))
                            @php
                                $nullValue='';
                                $noLocation = 1;
                            @endphp 
                            {{ $ivalue[0]->vIndustryName }}
                            @if(count($ivalue) > 1)
                                + {{count($ivalue) - 1}} More
                            @endif
                        @else
                            @php
                                $nullValue2='N/A';
                            @endphp
                        @endif
                    @endforeach
                    @if($nullValue == 'N/A' && $noLocation == 0)
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
                            {{ strtolower(trans($value->vHowMuchInvest))}}
                        @else
                        {{ "N/A" }}
                        @endif
                       </h3>
                    </li>
                    <li class="line"></li>
                    <li class="contact-btn advisor_ajax_listing_button">
                        <a href="{{url('advisor-detail',$value->vUniqueCode)}}">Send Proposal</a>
                    </li>
                </ul>
            </div>



            <!-- <a href="{{url('advisor-detail',$value->vUniqueCode)}}">
                <h2>@if(!empty($value->vAdvisorProfileTitle))
                        {{$value->vAdvisorProfileTitle}}
                    @else
                        {{ "N/A" }}
                    @endif
                </h2>
            </a> -->
            <!-- <p class="investment-detail-info">
                @if(!empty($value->tAdvisorProfileDetail))
                    {{strip_tags($value->tAdvisorProfileDetail)}}
                @else
                    {{ "N/A" }}
                @endif
            </p> -->
        </div>
        <ul class="-box-wrapper">
            {{-- <li class="second-box">
                <p>Investment Size</p>
                <h3> 
                    @if(!empty($value->vHowMuchInvest))
                        {{ strtolower(trans($value->vHowMuchInvest))}}
                    @else
                        {{ "N/A" }}
                    @endif
                </h3>
            </li> --}}
            <!-- <li class="second-box">
                <p>Locations</p>
                <h5>
                    @php
                        $nullValue='';
                        $noLocation = 0;
                        $tooltip = '';
                    @endphp
                    @foreach($location as $key => $lvalue)
                        @if(!empty($lvalue[0]->vLocationName) && ($lvalue[0]->iAdvisorProfileId == $value->iAdvisorProfileId))
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
            </li> -->
            <!-- <li class="second-box">
                <p>Industries </p>
                <h5>
                    @php
                        $nullValue2='';
                        $noLocation = 0;
                    @endphp
                    @foreach($industries as $key => $ivalue)
                        @if(!empty($ivalue[0]->vIndustryName) && ($ivalue[0]->iAdvisorProfileId == $value->iAdvisorProfileId))
                            @php
                                $nullValue='';
                                $noLocation = 1;
                            @endphp 
                            {{ $ivalue[0]->vIndustryName }}
                            @if(count($ivalue) > 1)
                                + {{count($ivalue) - 1}} More
                            @endif
                        @else
                            @php
                                $nullValue2='N/A';
                            @endphp
                        @endif
                    @endforeach
                    @if($nullValue == 'N/A' && $noLocation == 0)
                        {{$nullValue2}}
                    @endif
                </h5>
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