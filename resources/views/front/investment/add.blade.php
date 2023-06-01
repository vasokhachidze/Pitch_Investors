@extends('layouts.app.front-app')
@section('title', 'Add - Edit Business - ' . env('APP_NAME'))
@php

$session_data = session('user');
use App\Helper\GeneralHelper;
$userData = '';
if ($session_data !== '') {
    $userData = App\Helper\GeneralHelper::get_user_data_in_profile($session_data['iUserId']);
}

$payment_setting = GeneralHelper::setting_info('Currency');
$business_proof = $fast_verification = $profile = $facility = $yearly_sales_report = $NDA = [];
if (isset($documents)) {
    foreach ($documents as $key => $value) {
        if ($value->eType == 'business_proof') {
            array_push($business_proof, $value->vImage);
        } elseif ($value->eType == 'fast_verification') {
            array_push($fast_verification, $value->vImage);
        } elseif ($value->eType == 'profile') {
            array_push($profile, $value->vImage);
        } elseif ($value->eType == 'facility') {
            array_push($facility, $value->vImage);
        } elseif ($value->eType == 'yearly_sales_report') {
            array_push($yearly_sales_report, $value->vImage);
        } elseif ($value->eType == 'NDA') {
            array_push($NDA, $value->vImage);
        }
    }
}
@endphp
@section('custom-css')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css" integrity="sha512-TQQ3J4WkE/rwojNFo6OJdyu6G8Xe9z8rMrlF9y7xpFbQfW5g8aSWcygCQ4vqRiJqFsDsE1T6MoAOMJkFXlrI9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

    <style>
        .save-detail {
            cursor: pointer;
        }
        label {
            font-size:13px !important;
        }
        .select2-selection__rendered {
            font-size:13px !important;
        }
        .rounded-pill {
            border-radius : 0 !important;
        }
    </style>

@endsection
@section('content')

    <section class="add-edit-detail lite-gray investment-edit-detail">
        <div class="adit-detail-step">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="steps-in">
                            <ul>
                                <li><a style="cursor: arrow;" id="first-tab" data-id='first-step' class="active investmentHeader">Profile</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="add-step-detail">
            <div class="container">
                <div class="row">
                    @include('layouts.front.left_dashboard')
                    <div class="col-lg-8 col-md-12 ">

                    
                        <form id="frm" action="{{ url('investment-store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if(isset($investment)){{$investment->vUniqueCode}}@endif">
                            <input type="hidden" id="iTempId" name="iTempId" value="@if (isset($iTempId)){{$iTempId}}@endif">
                            <input type="hidden" id="iInvestmentProfileId" name="iInvestmentProfileId" value="@if (isset($investment->iInvestmentProfileId)){{$investment->iInvestmentProfileId}}@endif">

                            <!-- frist-step -->
                        <div id="first-step" class="other-detail investment_forms frist-steps">
                                <h5>{{ isset($investment) ? 'Edit' : 'Add' }}  Business Profile</h5>
                                <!-- <div class="main-text">
                                    <h3>Business Sale or Equity Investment Opportunity</h3>
                                    <p style="text-align: justify;">Share the details of your business with potential buyers and investors, and showcase your business details, location, revenues, suppliers, challenges, and the benefits they will experience while investing with you. Take advantage of this opportunity to connect with the right investors and support the growth of your business. Let's make it happen.</p>
                                    <p style="margin-top: 1%;">For the best results, provide extensive information about your business. Our goal at Pitchinvestors is to match you with the right investors to support your growth. This includes a comprehensive portfolio showcasing your products or services, location, revenue, suppliers, challenges, and the benefits investors can expect from investing with you.</p>
                                    <div class="image-avtar">
                                        <img src="{{ asset('uploads/front/investor/profile1.png') }}" alt="">
                                    </div>
                                </div> -->

                        <div class="card">
                            <div class="card-header"><p><b>Confidential Information</b></p>Please enter your own details here. Information entered here is not publicly displayed.</div>
                                

                                <div class="card-body">
                                <div class="detail-form">
                                    <div class="row">
                                        <div class="col-md-6 positon-relative">
                                            <label for="floatingPassword">First Name</label>
                                            <input type="text" class="form-control rounded-pill" id="vFirstName" name="vFirstName" placeholder="First name" value="@if(isset($investment)){{$investment->vFirstName}}@elseif(!empty($userData)) {{$userData->vFirstName}}@else{{$session_data['vFirstName']}}@endif">
                                            <div class="validination-info">
                                                <i class="" id="fNameError"></i>
                                            </div>
                                            <div id="vFirstName_error" class="error mt-1" style="color:red;display: none;">Please Enter First Name </div>
                                        </div>

                                        <div class="col-md-6 positon-relative">
                                            <label for="floatingPassword">Last Name</label>
                                            <input type="text" class="form-control rounded-pill" id="vLastName" name="vLastName" placeholder="Last Name" value="@if(isset($investment)){{$investment->vLastName}}@elseif(!empty($userData)) {{$userData->vLastName}}@else{{$session_data['vLastName']}}@endif">
                                            <div class="validination-info">
                                                <i class="" id="lNameError"></i>
                                            </div>
                                            <div id="vLastName_error" class="error mt-1" style="color:red;display: none;">Please Enter Last Name </div>
                                        </div>

                                        <div class="col-md-6 positon-relative">
                                            <label for="floatingPassword">DOB</label>
                                            <input type="text" class="form-control rounded-pill" id="dDob" name="dDob" placeholder="DOB" value="@if(isset($investment)){{date('d-F-Y', strtotime($investment->dDob))}}@elseif(!empty($userData)) {{ date('d-F-Y', strtotime($userData->dDob)) }}@endif">
                                             <div class="validination-info">
                                                <i class="" id="DOBError"></i>
                                            </div>
                                            <div id="dDob_error" class="error mt-1" style="color:red;display: none;">Please Enter Date of Birth </div>
                                        </div>

                                        <div class="col-md-6 positon-relative">
                                            <label for="floatingPassword">Email</label>
                                            <input type="text" class="form-control rounded-pill" id="vEmail" name="vEmail" placeholder="Email" value="@if(isset($investment)){{$investment->vEmail}}@else{{$session_data['vEmail']}}@endif">
                                            <div class="validination-info">
                                                <i class="" id="vEmailError"></i>
                                            </div>

                                            <div id="vEmail_error" class="error mt-1" style="color:red;display: none;">Please Enter Your Email </div>
                                            <div id="vEmail_valid_error" class="error_show" style="color:red;display: none;">Please Enter a Valid Email</div>
                                        </div>

                                        <div class="col-md-6 positon-relative">
                                            <label for="floatingPassword">Phone No.</label>
                                            <input type="text" class="form-control rounded-pill numeric" id="vPhone" maxlength="10" name="vPhone" placeholder="Phone No." value="@if(isset($investment)){{$investment->vPhone}}@elseif(!empty($userData)) {{$userData->vPhone}}@else{{$session_data['vPhone']}}@endif">
                                            <div class="validination-info">
                                                <i class="" id="vPhoneError"></i>
                                            </div>
                                            <div id="vPhone_error" class="error mt-1" style="color:red;display: none;">Please Enter Your Phone No. </div>
                                        </div>

                                        <div class="col-md-6 positon-relative">
                                            <label for="floatingPassword">Identification No</label>
                                            <input type="text" class="form-control rounded-pill" id="vIdentificationNo" name="vIdentificationNo" placeholder="Identification No" value="@if(isset($investment)){{$investment->vIdentificationNo}}@elseif(!empty($userData)) {{$userData->vIdentificationNo}}@endif">
                                             <div class="validination-info">
                                                <i class="" id="vIdentificationNoError"></i>
                                            </div>

                                            <div id="vIdentificationNo_error" class="error mt-1" style="color:red;display: none;">Please Enter Your Identification No. </div>
                                        </div>
                                    </div>
                                </div>
                             </div>              
                            
                            </div>
                        </div>
                            <br>


                            <div class="card">
                            <div class="card-header"><p><b>Location Details</b></p></div>
                                

                                <div class="card-body">
                                <div class="detail-form">
                                    <div class="row">
                                    {{--
                                            <div class="col-lg-12 mt-3 mb-2 form-group ">
                                                <label>Location</label>
                                                
                                                <select name="locations[]" id="locations" class="form-control" multiple="multiple" style="width: 100%; height: 40px;">
                                                    @foreach ($location as $key => $value)
                                                        @php
                                                            $region_select = '';
                                                            $county_select = '';
                                                            $subcounty_select = '';
                                                        @endphp

                                                            @if(isset($selected_location)) 
                                                            @foreach ($selected_location as $key => $lvalue)
                                                                @if($lvalue->iLocationId == $value['regionId'] && $lvalue->eLocationType == 'Region')
                                                                @php
                                                                    $region_select = 'selected';                                
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                            @endif
                                                            <option class="region_option" value="Region_{{$value['regionId']}}-{{$value['regionName']}}" {{$region_select }}>{{$value['regionName']}}</option>
                                                            @foreach ($value as $key1 => $value1)
                                                            @if(in_array($key1, ['regionId', 'regionName']))
                                                                @continue
                                                            @endif
                                                            
                                                            @if(isset($selected_location)) 
                                                                @foreach ($selected_location as $key => $lvalue)
                                                                @if($lvalue->iLocationId == $value1['countyId'] && $lvalue->eLocationType == 'County')
                                                                    @php
                                                                        $county_select = 'selected';                                
                                                                    @endphp
                                                                @endif
                                                                @endforeach
                                                            @endif
                                                            <option class="county_option" value="County_{{$value1['countyId']}}-{{$value1['countyName']}}" {{$county_select }}>-{{$value1['countyName']}}</option>
                                                            @foreach ($value1 as $key2 => $value2)
                                                                @if(in_array($key2, ['countyId', 'countyName']))
                                                                @continue
                                                                @endif

                                                            @if(isset($selected_location)) 
                                                                @foreach ($selected_location as $key => $lvalue)
                                                                    @if($lvalue->iLocationId == $value2['subCountyName'] && $lvalue->eLocationType == 'Sub County')
                                                                    @php
                                                                        $subcounty_select = 'selected';                                
                                                                        @endphp
                                                                    @endif
                                                                @endforeach
                                                                @endif
                                                                <option class="subCounty_option" value="Sub County_{{$value2['iSubCountId']}}-{{$value2['subCountyName']}}" {{$subcounty_select}}>--{{$value2['subCountyName']}}</option>
                                                            @endforeach
                                                            @endforeach
                                                        @endforeach
                                                </select>
                                                <div id="locations_error" class="error mt-1" style="color:red;display: none;">Please Select Location</div>
                                            </div>
                                        --}}
                                        <div class="col-lg-6 mb-2 form-group custom-select positon-relative">
                                             <label >Select Country</label>
                                            <select id="country_id" name="iCountryId" class="add_select2 form-control">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $value)
                                                    <option value="{{ $value->iCountryId . '_' . $value->vCountry }}" @if(isset($investment)) @if($selected_location[0]->iLocationId == $value->iCountryId) {{'selected'}}@endif @endif>{{ $value->vCountry }}</option>
                                                @endforeach
                                            </select>
                                             <div class="validination-info">
                                                <i class="" id="iCountryIdError"></i>
                                            </div>
                                            <div id="iCountryId_error" class="error mt-1" style="color:red;display: none;">Please Select Country name</div>
                                        </div>
                                        <input type="hidden" id="selected_region_id" value="@if(isset($selected_location)){{$selected_location[1]->iLocationId . '_' . $selected_location[1]->vLocationName}}@endif">
                                        <div class="col-lg-6 mb-2 form-group custom-select positon-relative">
                                            <label>Select Region</label>
                                            <select id="iRegionId" name="iRegionId" class="add_select2 form-control with-border">
                                                <option value="">Select Region</option>
                                            </select>
                                             <div class="validination-info">
                                                <i class="" id="iRegionIdError"></i>
                                            </div>
                                            <div id="region_id_error" class="error mt-1" style="color:red;display: none;">Please Select Region name</div>
                                        </div>

                                        <input type="hidden" id="selected_county_id" value="@if(isset($selected_location)){{$selected_location[2]->iLocationId . '_' . $selected_location[2]->vLocationName}}@endif">
                                        <div class="col-lg-6 mb-2 form-group custom-select positon-relative">
                                            <label>Select County</label>
                                            <select id="iCountyId" name="iCountyId" class="add_select2 form-control with-border">
                                                <option value="">Select County</option>
                                            </select>
                                            <div class="validination-info">
                                                <i class="" id="iCountyIdError"></i>
                                            </div>
                                            <div id="county_id_error" class="error mt-1" style="color:red;display: none;">Please Select County name</div>
                                        </div>
                                        <input type="hidden" id="selected_sub_county_id" value="@if(isset($selected_location)){{$selected_location[3]->iLocationId . '_' . $selected_location[3]->vLocationName}}@endif">
                                        <div class="col-lg-6 mb-2 form-group custom-select positon-relative">
                                            <label>Select Sub County</label>
                                            <select id="iSubCountyId" name="iSubCountyId" class="add_select2 form-control with-border">
                                                <option value="">Select Sub County</option>
                                            </select>
                                             <div class="validination-info">
                                                <i class="" id="iSubCountyIdError"></i>
                                            </div>
                                            <div id="sub_county_id_error" class="error mt-1" style="color:red;display: none;">Please Select Sub County name</div>
                                        </div>

                                        
                                    </div>
                                </div>
                             </div>              
                            
                            </div>
                      

                            <br>

                            <div class="card">
                            <div class="card-header"><p><b>Business Information</b></p>Information entered here is displayed publicly to match you with the right set of investors and buyers. Do not mention business name/information which can identify the business.</div>
                                
                                <div class="card-body">

                            <!-- second step -->
                            <div id="second-step" class="other-detail investment_forms second-steps">
                                <div class="detail-form">
                                    <div class="row">
                                        <!-- <div class="col-lg-3">
                                            <div class="custom-upload-inner1 logo-height">
                                                <input type="file" id="vImage" name="vImage" accept="image/png, image/jpeg">
                                                @php
                                                    $old_image = '';
                                                @endphp
                                                @if(!empty($documents))
                                                    @foreach ($documents as $key => $val)
                                                        @if($val->eType == 'profile')
                                                            <input type="hidden" name="old_vImage" id="old_vImage" value="{{$val->vImage}}">
                                                            @php
                                                                $old_image = $val->vImage;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                @endif

                                                <div class="upload-logo-text">
                                                    <label for="">Upload Your Logo</label>
                                                    <center>
                                                        @if(!empty($old_image))
                                                            <img class="mt-2" id="img_old_logo" src="{{ asset('uploads/investment/profile/' . $old_image) }}" height="100px" width="100px" alt=" ">
                                                        @endif
                                                        <img class="mt-2" id="img_logo" src="" height="100px" width="100px" style="display: none" alt=" ">
                                                    </center>
                                                </div>
                                            </div>
                                        </div> -->


                                        <div class="col-lg-12 d-flex-contain positon-relative">
                                                <label  for="vBusinessName">Business Name</label>
                                                <div class="input-error-type">
                                                <input type="text" class="form-control rounded-pill" id="vBusinessName" name="vBusinessName" placeholder="Business Name" value="@if(isset($investment)){{$investment->vBusinessName}}@endif">
                                                <div class="validination-info">
                                                    <i class="" id="vBusinessNameError"></i>
                                                </div>

                                                <div id="vBusinessName_error" class="error mt-1" style="color:red;display: none;">Please Enter the Business Name. </div>
                                                </div>
                                        </div>

                                        <div class="col-lg-12 d-flex-contain positon-relative">
                                            <label for="vBusinessProfileName">Business Profile Name</label>
                                            <div class="input-error-type">
                                            <input type="text" class="form-control rounded-pill" id="vBusinessProfileName" name="vBusinessProfileName" placeholder="Business Profile Name" value="@if(isset($investment)){{$investment->vBusinessProfileName}}@endif">
                                            <div class="validination-info">
                                                <i class="" id="vBusinessProfileNameError"></i>
                                            </div>

                                            <div id="vBusinessProfileName_error" class="error mt-1" style="color:red;display: none;">Please Enter Business Profile Name. </div>
                                             </div>
                                        </div>

                                       

                                    <div class="col-lg-12 d-flex-contain positon-relative">
                                        <label for="eBusinessProfile">Business Profile</label>
                                        <div class="input-error-type">
                                            <select class="form-control rounded-pill" id="eBusinessProfile" name="eBusinessProfile">
                                                <option value=""></option>
                                                <option value="Business owner" @if(isset($investment) and $investment->eBusinessProfile == 'Business owner') {{'selected'}}@endif>Business owner</option>
                                                <option value="Business Broker" @if(isset($investment) and $investment->eBusinessProfile == 'Business Broker') {{'selected'}}@endif>Business Broker</option>
                                                <option value="Business advisor" @if(isset($investment) and $investment->eBusinessProfile == 'Business advisor') {{'selected'}}@endif>Business advisor</option>
                                            </select>
                                            <div class="validination-info">
                                                    <i class="" id="eBusinessProfileerror"></i>
                                                </div>
                                            <div id="eBusinessProfile_error" class="error mt-1" style="color:red;display:none;">Please select a business profile</div>
                                    </div>
                                    </div>

                                    <div class="col-lg-12 d-flex-contain positon-relative">
                                            <label for="tBusinessProfileDetail">Business Profile Detail</label>
                                            <div class="input-error-type">
                                            <textarea class="form-control" id="tBusinessProfileDetail" name="tBusinessProfileDetail" placeholder="Business Profile Detail" cols='60' rows='8' style="height: 100px">@if(isset($investment)){{$investment->tBusinessProfileDetail}}@endif</textarea>
                                            {{-- <input type="text" class="form-control" id="tBusinessProfileDetail" name="tBusinessProfileDetail" placeholder="Business Profile Detail" value="@if(isset($investment)){{$investment->tBusinessProfileDetail}}@endif"> --}}
                                            <div class="validination-info">
                                                <i class="" id="tBusinessProfileDetailError"></i>
                                            </div>

                                            <div id="tBusinessProfileDetail_error" class="error mt-1" style="color:red;display: none;">A short description about your business. </div>
                                            </div>
                                        </div>

                                            
                                 
                                    <div class="col-lg-12 mt-3 intersted-part">
                                            <h6 class="top-head">You are interested in </h6>
                                            <ul class="ul-flex">
                                                <li>
                                                    <label for="eFullSaleBusiness"><input type="checkbox" class="intrestCheckbox" id="eFullSaleBusiness" name="eFullSaleBusiness" value="Yes" @if(isset($investment) and $investment->eFullSaleBusiness == 'Yes') {{'checked'}}@endif /> Full sale of business</label>
                                                </li>
                                                <li>
                                                    <label for="ePartialSaleBusiness"><input type="checkbox" class="intrestCheckbox" id="ePartialSaleBusiness" name="ePartialSaleBusiness" value="Yes" @if(isset($investment) and $investment->ePartialSaleBusiness == 'Yes') {{'checked'}}@endif /> Partial sale of business/Investment</label>
                                                </li>
                                                <li>
                                                    <label for="eLoanForBusiness"><input type="checkbox" class="intrestCheckbox" id="eLoanForBusiness" name="eLoanForBusiness" value="Yes" @if(isset($investment) and $investment->eLoanForBusiness == 'Yes') {{'checked'}}@endif /> Loan for business</label>
                                                </li>
                                                <li>
                                                    <label for="eBusinessAsset"><input type="checkbox" class="intrestCheckbox" id="eBusinessAsset" name="eBusinessAsset" value="Yes" @if(isset($investment) and $investment->eBusinessAsset == 'Yes') {{'checked'}}@endif /> Selling or leasing out business asset</label>
                                                </li>
                                                <li>
                                                    <label for="eBailout"><input type="checkbox" class="intrestCheckbox" id="eBailout" name="eBailout" value="Yes" @if(isset($investment) and $investment->eBailout == 'Yes') {{'checked'}}@endif /> Distressed company looking for bailout</label>
                                                </li>
                                            </ul>
                                            <div id="intrestedIn_error" class="error mt-1" style="color:red;display: none;">Please Select your intrest</div>
                                        </div>

                                        <br><br><br>
                                        <div class="col-lg-12 d-flex-contain positon-relative">
                                            
                                                <label class="top-head" for="vBusinessEstablished">When was the business established?</label>
                                                <div class="input-error-type">
                                                <input type="text" class="form-control rounded-pill" id="vBusinessEstablished" name="vBusinessEstablished" placeholder="Business Established" value="@if(isset($investment)){{$investment->vBusinessEstablished}}@endif">
                                                        <div class="validination-info">
                                                            <i class="" id="vBusinessEstablishedError"></i>
                                                    </div>

                                                    <div id="vBusinessEstablished_error" class="error mt-1" style="color:red;display: none;">Please Enter the Year the Business was Established.  </div>
                                                 </div>
                                        </div>





                                        <div class="col-lg-12 d-flex-contain positon-relative">
                                            
                                            <label class="top-head" for="vBusinessEstablished">Investment Industries</label>
                                            <div class="input-error-type">   
                                            <select name="industries" id="industries" class="form-control rounded-pill">
                                                @php
                                                    // dd($selected_industries);
                                                    $industry_select = '';
                                                @endphp
                                                <option value="">Select industries</option>

                                                @foreach ($industries as $value)
                                                    @php
                                                        $industry_select = '';
                                                    @endphp
                                                    @if(isset($selected_industries))
                                                        @foreach ($selected_industries as $industry)
                                                            @if($industry->iIndustryId == $value->iIndustryId)
                                                                @php
                                                                    $industry_select = 'selected';
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    <option value="{{$value->vName }}_{{$value->iIndustryId }}" {{ $industry_select }}>{{ $value->vName}}</option>
                                                @endforeach
                                            </select>
                                            <div class="validination-info">
                                                <i class="" id="industriesError"></i>
                                            </div>
                                            <div id="industries_error" class="error mt-1" style="color:red;display: none;">Please Select Industries</div>
                                            </div>
                                        </div>


                                        <!-- <div class="col-lg-12 d-flex-contain positon-relative">
                                            
                                                <label class="top-head" for="vBusinessName">How many permanent employees do yo have?</label>
                                                <div class="input-error-type">
                                                    <input type="text" class="form-control rounded-pill" id="vBusinessName" name="vBusinessName"  value="@if(isset($investment)){{$investment->vBusinessName}}@endif">
                                                        <div class="validination-info">
                                                            <i class="" id="vBusinessNameError"></i>
                                                    </div>

                                                    <div id="vBusinessName_error" class="error mt-1" style="color:red;display: none;">Please Enter No. of permanent employees </div>
                                                 </div>
                                        </div> -->


                                        <div class="col-lg-12 d-flex-contain positon-relative">
                                                <label class="top-head" >Select business legal entity type</label>
                                                <div class="input-error-type">  
                                                    <select class="form-control rounded-pill" name="legal_entity" id="legal_entity">
                                                            <option value=""></option>
                                                            <option value="eSoleProprietor" @if(isset($investment) and $investment->eSoleProprietor == 'Yes') {{'selected'}}@endif>Sole proprietor</option>
                                                            <option value="ePrivateCompany" @if(isset($investment) and $investment->ePrivateCompany == 'Yes') {{'selected'}}@endif>Private company</option>
                                                            <option value="eGeneralPartnership" @if(isset($investment) and $investment->eGeneralPartnership == 'Yes') {{'selected'}}@endif>General partnership</option>
                                                            <option value="ePrivateLimitedCompany" @if(isset($investment) and $investment->ePrivateLimitedCompany == 'Yes') {{'selected'}}@endif>Public limited company</option>
                                                            <option value="eLLP" @if(isset($investment) and $investment->eLLP == 'Yes') {{'selected'}}@endif>Limited liability partnership (LLP)</option>
                                                            <option value="eSCorporation" @if(isset($investment) and $investment->eSCorporation == 'Yes') {{'selected'}}@endif>S corporation</option>
                                                            <option value="eLLC" @if(isset($investment) and $investment->eLLC == 'Yes') {{'selected'}}@endif>Limited liability company (LLC)</option>
                                                            <option value="eCCorporation" @if(isset($investment) and $investment->eCCorporation == 'Yes') {{'selected'}}@endif>C corporation</option>
                                                    </select>
                                                        <div class="validination-info">
                                                                <i class="" id="legelEntityerror"></i>
                                                        </div>
                                                    <div id="legelEntity_error" class="error mt-1" style="color:red;display: none;">Please Select legal entity</div>
                                                </div>
                                        </div>



                                        <!-- <div class="col-lg-12 d-flex-contain positon-relative">
                                            <label class="top-head" for="legelEntity_error">Select business legal entity type</label>
                                            <div class="input-error-type">
                                              <select class="form-control rounded-pill" name="legal_entity" id="legal_entity">
                                                <option value=""></option>
                                                <option id="eSoleProprietor" value="eSoleProprietor" name="legal_entity">Sole proprietor</option>
                                                <option id="eGeneralPartnership" value="eGeneralPartnership" name="legal_entity">General partnership</option>
                                                <option id="eLLP" value="eLLP" name="legal_entity">Limited liability partnership (LLP)</option>
                                                <option id="eLLC" value="eLLC" name="legal_entity">Limited liability company (LLC)</option>
                                                <option id="ePrivateCompany" value="ePrivateCompany" name="legal_entity">Private company</option>
                                                <option id="ePrivateLimitedCompany" value="ePrivateLimitedCompany" name="legal_entity">Public limited company</option>
                                                <option id="eSCorporation" value="eSCorporation" name="legal_entity"> S corporation</option>
                                                <option id="eCCorporation" value="eCCorporation" name="legal_entity">C corporation</option>
                                              </select>
                                                
                                                <div class="validination-info">
                                                    <i class="" id="legelEntity_error"></i>
                                                </div>

                                                <div id="legelEntity_error" class="error mt-1" style="color:red;display: none;">Please Select your intrest</div>
                                            </div>
                                        </div> -->

                                        <!-- <div class="col-lg-12 d-flex-contain positon-relative">
                                        <label class="top-head" for="intrestedIn_error">Select business legal entity type</label>
                                           
                                            <div>
                                            <select class="form-control rounded-pill" name="legal_entity" id="legal_entity">
                                                    <option value="" @if(!isset($investment) || empty($investment->legal_entity)) {{ 'selected' }} @endif>Select legal entity</option>
    
                                                    <option value="eSoleProprietor" @if(isset($investment) and $investment->eSoleProprietor == 'Yes') {{'selected'}}@endif>Sole proprietor</option>
                                                    <option value="ePrivateCompany" @if(isset($investment) and $investment->ePrivateCompany == 'Yes') {{'selected'}}@endif>Private company</option>
                                                    <option value="eGeneralPartnership" @if(isset($investment) and $investment->eGeneralPartnership == 'Yes') {{'selected'}}@endif>General partnership</option>
                                                    <option value="ePrivateLimitedCompany" @if(isset($investment) and $investment->ePrivateLimitedCompany == 'Yes') {{'selected'}}@endif>Public limited company</option>
                                                    <option value="eLLP" @if(isset($investment) and $investment->eLLP == 'Yes') {{'selected'}}@endif>Limited liability partnership (LLP)</option>
                                                    <option value="eSCorporation" @if(isset($investment) and $investment->eSCorporation == 'Yes') {{'selected'}}@endif>S corporation</option>
                                                    <option value="eLLC" @if(isset($investment) and $investment->eLLC == 'Yes') {{'selected'}}@endif>Limited liability company (LLC)</option>
                                                    <option value="eCCorporation" @if(isset($investment) and $investment->eCCorporation == 'Yes') {{'selected'}}@endif>C corporation</option>
                                                </select>
                                                <div class="validination-info">
                                                    <i class="" id="legelEntity_error"></i>
                                                </div>
                                                <div id="legelEntity_error" class="error mt-1" style="color:red;display: none;">Please select legal entity</div>
                                            </div>
                                        </div> -->


                                <div class="col-lg-12 d-flex-contain positon-relative">
                                            
                                        <label class="top-head" for="tBusinessDetail">Describe Your Business</label>
                                        <div class="input-error-type">
                                                <textarea class="form-control" id="tBusinessDetail" name="tBusinessDetail" placeholder="You can explain your business 50 words" style="height: 100px">@if(isset($investment)){{$investment->tBusinessDetail}}@endif</textarea>
                                                <div class="validination-info">
                                                    <i class="" id="tBusinessDetailError"></i>
                                                </div>

                                                <div id="tBusinessDetail_error" class="error mt-1" style="color:red;display: none;">Please describe Business </div>
                                                <div id="tBusinessDetail_min_length_error" class="error mt-1" style="color:red;display: none;">Please describe Business minimum 50 words</div>
                                           </div>
                                        </div>


                                 <div class="col-lg-12 d-flex-contain positon-relative">
                                            
                                        <label class="top-head" for="tListProductService">List all products and services of the business</label>
                                        <div class="input-error-type">        
                                            <textarea class="form-control" id="tListProductService" name="tListProductService" placeholder="Describe your list of Products & Servecess" style="height: 100px">@if(isset($investment)){{$investment->tListProductService}}@endif</textarea>
                                                <div class="validination-info">
                                                    <i class="" id="tListProductServiceError"></i>
                                                </div>

                                                <div id="tListProductService_error" class="error mt-1" style="color:red;display: none;">Please Enter Products and services</div>
                                        </div>
                                 </div>


                                <div class="col-lg-12 d-flex-contain positon-relative">
                                            
                                            <label class="top-head" for="tBusinessHighLights">Mention highlights of the business including number of clients, growth rate, promoter experience, business relationships, awards, etc</label>
                                                
                                            <div class="input-error-type">
                                            
                                            <textarea class="form-control" id="tBusinessHighLights" name="tBusinessHighLights" placeholder="You can explain your business including number of clients, growth rate, promoter experience, business relationships, awards, etc" style="height: 100px">@if(isset($investment)){{$investment->tBusinessHighLights}}@endif</textarea>
                                                <div class="validination-info">
                                                    <i class="" id="tBusinessHighLightsError"></i>
                                                </div>

                                                <div id="tBusinessHighLights_error" class="error mt-1" style="color:red;display: none;">Please Enter Business High lights</div>
                                            
                                                </div>
                                            </div>

                                 <div class="col-lg-12 d-flex-contain positon-relative">
                                            
                                                <label class="top-head">Describe your facility such as built-up area, number of floors, rental/lease details</label>
                                                
                                    <div class="input-error-type">
                                                <textarea class="form-control tFacility" id="tFacility" name="tFacility" placeholder="Explain Your Built-up Area, Number of Floors and Rental/ Lease Details" style="height: 100px">@if(isset($investment)){{$investment->tFacility}}@endif</textarea>
                                                <div class="validination-info">
                                                    <i class="" id="tFacilityError"></i>
                                                </div>
                                                <div id="tFacility_error" class="error mt-1" style="color:red;display: none;">Tell us more about your facility and offices</div>
                                    </div>
                                </div>


                                

                                <div class="col-lg-12 d-flex-contain positon-relative">
                                            
                                                <label class="top-head" for="vAverateMonthlySales">Annual sales? (in KES)</label>
                                                <div class="input-error-type">
                                            <input type="text" class="form-control rounded-pill" name="vAverateMonthlySales" placeholder="Enter your annual sales in KES" id="vAverateMonthlySales" class="form-control numeric money" value="@if(isset($investment)){{$investment->vAverateMonthlySales}}@endif">
                                            <div class="validination-info">
                                                <i class="" id="vAverateMonthlySalesError"></i>
                                            </div>

                                            <div id="vAverateMonthlySales_error" class="error mt-1" style="color:red;display: none;">What is your annual sales</div>
                                        </div>
                                </div>


                                


                                <div class="col-lg-12 d-flex-contain positon-relative">
                                            <label class="top-head" for="vProfitMargin">What is the EBITDA margin in percentage ((Your Profits/total sales)*100)</label>
                                            <div class="input-error-type">
                                                <input type="text" class="form-control rounded-pill" name="vProfitMargin" id="vProfitMargin" class="form-control numeric" placeholder="Please Enter EBITDA / Operating Profit Margin Percentage" maxlength="5" value="@if(isset($investment)){{$investment->vProfitMargin}}@endif">
                                                    <div class="validination-info">
                                                    <i class="" id="vProfitMarginError"></i>
                                                </div>

                                                <div id="vProfitMargin_error" class="error mt-1" style="color:red;display: none;">Please Enter EBITDA / Operating Profit Margin Percentage</div>
                                                <div id="vProfitMargin_maxLength_error" class="error mt-1" style="color:red;display: none;">Please Enter percentage between 0 and 100%</div>
                                            </div>
                                        </div>


                                        <div class="col-lg-12 d-flex-contain positon-relative">
                                            <label class="top-head" for="vPhysicalAssetValue">What is the value of physical assets owned by the business?</label>
                                            <div class="input-error-type">
                                                <input type="text" class="form-control rounded-pill" name="vPhysicalAssetValue" id="vPhysicalAssetValue" class="form-control numeric money" placeholder="Please Enter value of physical assets owned by the business" value="@if(isset($investment)){{$investment->vPhysicalAssetValue}}@endif">
                                                    <div class="validination-info">
                                                       <i class="" id="vPhysicalAssetValueError"></i>
                                                   </div>
                                                <div id="vPhysicalAssetValue_error" class="error mt-1" style="color:red;display: none;">Please Enter value of physical assets owned by the business</div>
                                            </div>    
                                        </div>


                                        <div class="col-lg-12 d-flex-contain positon-relative">
                                            <label class="top-head" for="vMaxStakeSell">What percentage of the business do you want to sell to investors (Should be in percentage)</label>
                                            <div class="input-error-type">
                                                <input type="text" class="form-control rounded-pill" name="vMaxStakeSell" id="vMaxStakeSell" class="form-control numeric" maxlength="5" placeholder="Please Enter maximum stake you are willing to sell" value="@if(isset($investment)){{$investment->vMaxStakeSell}}@endif">
                                                <div class="validination-info">
                                                    <i class="" id="vMaxStakeSellError"></i>
                                                </div>

                                                <div id="vMaxStakeSell_error" class="error mt-1" style="color:red;display: none;">Please Enter maximum stake you are willing to sell</div>
                                                <div id="vMaxStakeSell_maxLength_error" class="error mt-1" style="color:red;display: none;">Please Enter percentage between 0 and 100</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 d-flex-contain positon-relative">
                                           <label class="top-head" for="vInvestmentAmountStake"> How much do you want for this stake?</label>
                                            <div class="input-error-type">
                                                <input type="text" class="form-control rounded-pill" name="vInvestmentAmountStake" id="vInvestmentAmountStake" class="form-control numeric money" placeholder="Please Enter investment amount are you seeking for this stake" value="@if(isset($investment)){{$investment->vInvestmentAmountStake}}@endif">
                                                   <div class="validination-info">
                                                   <i class="" id="vInvestmentAmountStakeError"></i>
                                                   </div>

                                                 <div id="vInvestmentAmountStake_error" class="error mt-1" style="color:red;display: none;">Please Enter investment amount are you seeking for this stake</div>
                                            </div>
                                        </div>


                                        <div class="col-lg-12 d-flex-contain positon-relative">
                                            <label class="top-head">Reason for Investment</label>
                                            <div class="input-error-type">
                                            <textarea class="form-control" id="tInvestmentReason" name="tInvestmentReason" placeholder="Reason for Investment" cols='60' rows='8' style="height: 100px">@if(isset($investment)){{$investment->tInvestmentReason}}@endif</textarea>
                                            {{-- <input type="text" class="form-control" id="tInvestmentReason" name="tInvestmentReason" placeholder="Reason for Investment" value="@if(isset($investment)){{$investment->tInvestmentReason}}@endif"> --}}
                                            <div class="validination-info">
                                                <i class="" id="tInvestmentReasonError"></i>
                                            </div>

                                            <div id="ttInvestmentReason_error" class="error mt-1" style="color:red;display: none;">Please give reason for Investment </div>
                                            </div>
                                        </div>



                                       








                                </div>
                            </div>
                        </div> 
                        
                        
                    </div>
    </div>
                           <br>


                                <div class="card">
                                    <div class="card-header"><p><b>Photos, Documents & Proof</b></p>Photos are an important part of your profile and are publicly displayed. Documents help us verify and approve your profile faster. Documents names entered here are publicly visible but are accessible only to introduced members.</div>
                                

                                            <div class="card-body">
                                            <input type="hidden" name="documentId" id="documentId">
                                        <div class="col-lg-12 d-flex-contain positon-relative">
                                        <label class="mb-1">Provide proof of the legal existence by providing documents such as but not limited to; Certificate of Formation, Articles of Organization, Certificate of Organization, Articles of Association or business permity</label>
                                            <!-- <h6 class="top-head">Provide proof of the legal existence by providing documents such as but not limited to; Certificate of Formation, Articles of Organization, Certificate of Organization, Articles of Association or business permit</h6> -->
                                            <div class="input-error-type">
                                            <div class="custom-upload-inner1">
                                                <div id="business_proof_dropzone" name='business_proof_dropzone' class="dropzone"></div>
                                                <input type="file" name="file_business_proof[]" id="file_business_proof" class="d-none">
                                            </div>
                                        </div>

                                        <!-- start display image code -->
                                        <div class="file-upload-img">
                                            <ul>
                                            @if(!empty($documents)) 
                                                @foreach ($documents as $value)
                                                    @if($value->eType == 'business_proof')
                                                    <li class="img-upload">
                                                          @php
                                                            $current_image = '';
                                                            @endphp
                                                            @if(!empty($value->vImage) && file_exists(public_path('uploads/investment/business_proof/' . $value->vImage)))
                                                                @php
                                                                $current_image = 'uploads/investment/business_proof/'.$value->vImage;
                                                                @endphp
                                                            @else
                                                                @php
                                                                $current_image = 'uploads/default/no-image.png';
                                                                @endphp
                                                            @endif
                                                          <a target="_blank" href="{{asset($current_image)}}">
                                                            <img src="{{asset($current_image)}}" alt="{{$value->vImage}}" class="imgese" height="100px">
                                                            <a href="javascript:;" class="delete_document clear-btn" data-id="{{$value->iInvestmentDocumentId}}">
                                                               <i class="fal fa-times"></i>
                                                            </a>
                                                          </a>
                                                    </li>
                                                    @endif
                                                 @endforeach
                                            @endif
                                           </ul>
                                        </div>
                                        </div>
                                    


                                        <!-- end of image -->

                                        <div class="col-lg-12 d-flex-contain positon-relative">
                                            <label class="mb-1">Upload any image of your facility if any</label>
                                            <div class="input-error-type">
                                            <div class="custom-upload-inner1">
                                                <div id="facility_upload_dropzone" name='facility_upload_dropzone' class="dropzone"></div>
                                                <input type="file" name="file_facility_upload[]" id="file_facility_upload" class="d-none">
                                            </div>
                                        </div>
                                        <!-- start display image code -->
                                        <div class="file-upload-img">
                                            <ul>
                                            @if(!empty($documents)) 
                                                @foreach ($documents as $value)
                                                    @if($value->eType == 'facility')
                                                    <li class="img-upload">
                                                          @php
                                                            $current_image = '';
                                                            @endphp
                                                            @if(!empty($value->vImage) && file_exists(public_path('uploads/investment/facility/' . $value->vImage)))
                                                                @php
                                                                $current_image = 'uploads/investment/facility/'.$value->vImage;
                                                                @endphp
                                                            @else
                                                                @php
                                                                $current_image = 'uploads/default/no-image.png';
                                                                @endphp
                                                            @endif
                                                          <a target="_blank" href="{{asset($current_image)}}">
                                                                <img src="{{asset($current_image)}}" alt="{{$value->vImage}}" class="imgese" height="100px">
                                                                <a href="javascript:;" class="delete_document clear-btn" data-id="{{$value->iInvestmentDocumentId}}">
                                                                   <i class="fal fa-times"></i>
                                                                </a>
                                                          </a>
                                                    </li>
                                                    @endif
                                                 @endforeach
                                            @endif
                                           </ul>
                                        </div>
                                        </div>
                                        <!-- end display image code -->


                                        <div class="col-lg-12 d-flex-contain positon-relative">
                                              <label class="mb-1">Upload Yearly sales Report(Optional but encouraged)</label>
                                              <div class="input-error-type">
                                             <div id="yearly_sales_report_dropzone" name='yearly_sales_report_dropzone' class="dropzone mb-2"></div>
                                            <input type="file" name="file_yearly_sales_report[]" id="file_yearly_sales_report" class="d-none">
                                        </div>
                                         <!-- start display image code -->
                                        <div class="file-upload-img">
                                            <ul>
                                            @if(!empty($documents)) 
                                                @foreach ($documents as $value)
                                                    @if($value->eType == 'yearly_sales_report')
                                                    <li class="img-upload">
                                                          @php
                                                            $current_image = '';
                                                            @endphp
                                                            @if(!empty($value->vImage) && file_exists(public_path('uploads/investment/yearly_sales_report/' . $value->vImage)))
                                                                @php
                                                                $current_image = 'uploads/investment/yearly_sales_report/'.$value->vImage;
                                                                @endphp
                                                            @else
                                                                @php
                                                                $current_image = 'uploads/default/no-image.png';
                                                                @endphp
                                                            @endif
                                                          <a target="_blank" href="{{asset($current_image)}}">                                                             
                                                            <img src="{{asset($current_image)}}" alt="{{$value->vImage}}" class="imgese" height="100px">
                                                            <a href="javascript:;" class="delete_document clear-btn" data-id="{{$value->iInvestmentDocumentId}}">
                                                               <i class="fal fa-times"></i>
                                                            </a>                                                            
                                                          </a>                                                       
                                                    </li>
                                                    @endif
                                                 @endforeach
                                            @endif
                                           </ul>
                                        </div>
                                        </div>

                                        <!-- end display image code -->


                                        
                                        <div class="col-lg-12 d-flex-contain positon-relative">
                                            <label class="mb-1">Upload NDA if you have any</label>
                                            <div class="input-error-type">
                                            <div class="custom-upload-inner1">
                                            <div id="file_NDA_dropzone" name='file_NDA_dropzone' class="dropzone"></div>
                                            <input type="file" name="file_NDA_upload[]" id="file_NDA_upload" class="d-none">
                                            </div>
                                        </div>

                                            <!-- start display image code -->
                                            <div class="file-upload-img">
                                                <ul>
                                                @if(!empty($documents)) 
                                                    @foreach ($documents as $value)
                                                        @if($value->eType == 'NDA')
                                                        <li class="img-upload">
                                                           
                                                              @php
                                                                $current_image = '';
                                                                @endphp
                                                                @if(!empty($value->vImage) && file_exists(public_path('uploads/investment/NDA/' . $value->vImage)))
                                                                    @php
                                                                    $current_image = 'uploads/investment/NDA/'.$value->vImage;
                                                                    @endphp
                                                                @else
                                                                    @php
                                                                    $current_image = 'uploads/default/no-image.png';
                                                                    @endphp
                                                                @endif
                                                              <a target="_blank" href="{{asset($current_image)}}">
                                                                <img src="{{asset($current_image)}}" alt="{{$value->vImage}}" class="imgese" height="100px">
                                                                <a href="javascript:;" class="delete_document clear-btn" data-id="{{$value->iInvestmentDocumentId}}">
                                                                   <i class="fal fa-times"></i>
                                                                </a>
                                                              </a>
                                                        </li>
                                                        @endif
                                                     @endforeach
                                                @endif
                                               </ul>
                                            </div>
                                            </div>

                                            </div>
                                </div>


                            

                           
                                            <!-- close display image code -->
                                   
                                    <div class="term-accpet">
                                        <ul>
                                            <li>
                                                <label for="eFindersFee">
                                                    <input type="checkbox" name="eFindersFee" id="eFindersFee" value="Yes" @if(isset($investment)){{'checked'}}@endif />
                                                    <p>I accept 1% finder's fee (payable post transaction) and other <a href="#"> Terms of engagement</a></p>
                                                </label>
                                            </li>
                                                <div id="eFindersFee_error" class="error mt-1" style="color:red;display: none;">Please accept terms of engagement</div>
                                        </ul>
                                        <span style="font-size:15pt;font-weight:bold;color:red">Subscribe to both services now, and get a 20% discount</span>
                                        <ul>
                                            <li>
                                                <label for="isNewsletterService">
                                                    <input class="prices" amount="@if(isset($payment_setting['NEWSLETTER_SERVICE_PRICE'])){{$payment_setting['NEWSLETTER_SERVICE_PRICE']['vValue']}}@endif" onclick="checkPrice()" type="checkbox" name="isNewsletterService" id="isNewsletterService" value="1" @if(isset($investment) && $investment->isNewsletterService == 1){{'checked disabled'}}@endif />
                                                    <p><b>Service : NewsLetter<br> Price: @if(isset($payment_setting['NEWSLETTER_SERVICE_PRICE'])) {{$payment_setting['NEWSLETTER_SERVICE_PRICE']['vValue']}} (KES)   @endif</b> <br>Pitch Investors is now offering an exclusive opportunity to feature your business in our monthly newsletter, which is sent to a growing community of over 300 investors.
<br><br>This premium package is designed to showcase your business to a wider audience of potential investors and increase your chances of securing the investment you need to grow your business. With this package, you will receive a dedicated feature in our monthly newsletter, highlighting the unique value proposition of your business and the potential for growth and profitability. </p>
                                                </label>
                                            </li>
                                                
                                        </ul>
                                        <ul>
                                            <li>
                                                <label for="isSocialMediaService">
                                                    <input class="prices" amount="@if(isset($payment_setting['SOCIAL_MEDIA_SERVICE_PRICE'])){{$payment_setting['SOCIAL_MEDIA_SERVICE_PRICE']['vValue']}}@endif" onclick="checkPrice()"  type="checkbox" name="isSocialMediaService" id="isSocialMediaService" value="1" @if(isset($investment) && $investment->isSocialMediaService == 1){{'checked disabled'}}@endif />
                                                    <p><b>Service : Soical Media <br>Price: @if(isset($payment_setting['SOCIAL_MEDIA_SERVICE_PRICE'])) {{$payment_setting['SOCIAL_MEDIA_SERVICE_PRICE']['vValue']}} (KES)   @endif</b> <br>Pitch Investors is excited to offer an exclusive opportunity to promote your business to our network of investors through our social media channels. With our premium package, we will share your business on our LinkedIn, Facebook, and Twitter pages, connecting you with potential investors who are actively seeking new opportunities.<br><br>Our social media platforms are a powerful tool for expanding your reach and building credibility with potential investors. By featuring your business on our channels, you can tap into our network of followers and increase your visibility to a wider audience of potential investors.
                                                    </p>
                                                </label>
                                            </li>
                                                
                                        </ul>
                                        <span id="price_cont" style="display:none">Total amount to pay: <span id="total_price"></span> KES <span id="discount" style="display:none; color:red">(20% discount applied)</span></span>
                                    </div>
                                    <div class="row margin-left-button" id="submit">
                                        <label class="save-detail"><a href="javascript:;" >Save</a></label>
                                    </div>
                                </div>
                            </div>
                        
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('custom-js')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">

        function checkPrice() {            
            var total = 0;
            var count = 0;
            $('.prices').each(function(){
                if($(this).is(":checked")) {
                    if(!this.disabled ) {
                        count++;
                        total = total + parseFloat($(this).attr('amount'));
                    }
                }                      
            });            
            if(total > 0) {
                if(count == 2) {
                    total = total - parseFloat(total*(20/100));
                    $('#discount').show();
                } else {
                    $('#discount').hide();
                }
                $('#price_cont').show();
                $('#total_price').html(total);
            } else {
                $('#price_cont').hide();
            }
        }
        /* $(document).on('change', '#locations', function() {
        var selectedValue=[];
        $("#locations :selected").each(function() {
                var text=$(this).text().replace(/[-]/gi,'');
                selectedValue.push(text);
                $('#option_value').val(selectedValue);
            });
        }); */


        var upload_url = '{{ url('investment-upload/') }}';
        Dropzone.autoDiscover = false;
        var error = false;

        var datePicker = $('#dDob').datepicker({
            format: "dd-mm-yyyy",
            endDate: '+0d',
            autoclose: true //to close picker once year is selected
        });
        var datePicker1 = $("#vBusinessEstablished").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            endDate: '+0d',
            autoclose: true //to close picker once year is selected
        });
        var docString = '';

        const business_proof_dropzone = document.getElementById('business_proof_dropzone');
        const file_business_proof = document.getElementById('file_business_proof');

        const facility_upload_dropzone = document.getElementById('facility_upload_dropzone');
        const file_facility_upload = document.getElementById('file_facility_upload');

        const yearly_sales_report_dropzone = document.getElementById('yearly_sales_report_dropzone');
        const file_yearly_sales_report = document.getElementById('file_yearly_sales_report');

        const file_NDA_dropzone = document.getElementById('file_NDA_dropzone');
        const file_NDA_upload = document.getElementById('file_NDA_upload');
        iTempId = $('#iTempId').val();
        iInvestmentProfileId=$('#iInvestmentProfileId').val();
        file_up_names=[];
        var dropzone = new Dropzone('#business_proof_dropzone', {
            thumbnailWidth: 200,
            parallelUploads: 10,
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",
            addRemoveLinks: true,

            removedfile: function(file) 
            {
                var Toast = Swal.mixin({
               toast: true,
               position: 'top-end',
               showConfirmButton: false,
                   timer: 3000
             });

                url="{{ url('investment-delete-document') }}";
                x = confirm('Do you want to delete?');
                if(!x)  return false;
                for(var i=0;i<file_up_names.length;++i){

                  if(file_up_names[i]==file.name) 
                  {
                    $.ajaxSetup({
                        headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                     });
                    $.post
                    (url,{file_name:file_up_names[i],action:'beforeSaveDelete'},
                       function(data,status)
                       {
                        if(status == 'success')
                         {
                            Toast.fire({
                            icon: 'success',
                            title: 'Document Deleted Successfully.'
                            })
                            file.previewElement.remove();
                          }   
                        }
                    );
                   }
                }
            },

            url: upload_url,
            paramName: "file",
            params: {
                'type': 'business_proof',
                'iTempId': iTempId,
                'iInvestmentProfileId': iInvestmentProfileId
            },
            headers: {
                'x-csrf-token': '{{ csrf_token() }}',
            },
            success: function(file, response) {

                docString += response.id + ',';
                $('#documentId').val(docString.slice(0, -1));
                file_up_names.push(file.name);

            }

        });

        business_proof_dropzone.addEventListener('drop', event => {
            event.preventDefault();
            let files = event.dataTransfer.files;
            file_business_proof.files = files;
            console.log('added ' + files.length + ' files');
        });

        var dropzone = new Dropzone('#file_NDA_dropzone', {
            thumbnailWidth: 200,
            parallelUploads: 10,
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",
            addRemoveLinks: true,
            removedfile: function(file) 
            {
                var Toast = Swal.mixin({
               toast: true,
               position: 'top-end',
               showConfirmButton: false,
                   timer: 3000
             });

                url="{{ url('investment-delete-document') }}";
                x = confirm('Do you want to delete?');
                if(!x)  return false;
                for(var i=0;i<file_up_names.length;++i){

                  if(file_up_names[i]==file.name) 
                  {
                    $.ajaxSetup({
                        headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                     });
                    $.post
                    (url,{file_name:file_up_names[i],action:'beforeSaveDelete'},
                       function(data,status)
                       {
                        if(status == 'success')
                         {
                            Toast.fire({
                            icon: 'success',
                            title: 'Document Deleted Successfully.'
                            })
                            file.previewElement.remove();
                          }   
                        }
                    );
                   }
                }
            },
            url: upload_url,
            paramName: "file",
            params: {
                'type': 'NDA',
                 'iTempId': iTempId,
                'iInvestmentProfileId': iInvestmentProfileId
            },
            headers: {
                'x-csrf-token': '{{ csrf_token() }}',
            },
            success: function(file, response) {
                docString += response.id + ',';
                $('#documentId').val(docString.slice(0, -1));
                file_up_names.push(file.name);
            }
        });
        file_NDA_dropzone.addEventListener('drop', event => {
            event.preventDefault();
            let files = event.dataTransfer.files;
            file_NDA_upload.files = files;
            console.log('added ' + files.length + ' files');
        });

        var dropzone = new Dropzone('#facility_upload_dropzone', {
            thumbnailWidth: 200,
            parallelUploads: 10,
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",
            addRemoveLinks: true,
            removedfile: function(file) 
            {
                var Toast = Swal.mixin({
               toast: true,
               position: 'top-end',
               showConfirmButton: false,
                   timer: 3000
             });

                url="{{ url('investment-delete-document') }}";
                x = confirm('Do you want to delete?');
                if(!x)  return false;
                for(var i=0;i<file_up_names.length;++i){

                  if(file_up_names[i]==file.name) 
                  {
                    $.ajaxSetup({
                        headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                     });
                    $.post
                    (url,{file_name:file_up_names[i],action:'beforeSaveDelete'},
                       function(data,status)
                       {
                        if(status == 'success')
                         {
                            Toast.fire({
                            icon: 'success',
                            title: 'Document Deleted Successfully.'
                            })
                            file.previewElement.remove();
                          }   
                        }
                    );
                   }
                }
            },
            url: upload_url,
            paramName: "file",
            params: {
                'type': 'facility',
                 'iTempId': iTempId,
                'iInvestmentProfileId': iInvestmentProfileId
            },
            headers: {
                'x-csrf-token': '{{ csrf_token() }}',
            },
            success: function(file, response) {
                docString += response.id + ',';
                $('#documentId').val(docString.slice(0, -1));
                file_up_names.push(file.name);
            }
        });
        facility_upload_dropzone.addEventListener('drop', event => {
            event.preventDefault();
            let files = event.dataTransfer.files;
            file_facility_upload.files = files;
            console.log('added ' + files.length + ' files');
        });

        var dropzone = new Dropzone('#yearly_sales_report_dropzone', {
            thumbnailWidth: 200,
            parallelUploads: 10,
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",
            addRemoveLinks: true,
            removedfile: function(file) 
            {
                var Toast = Swal.mixin({
               toast: true,
               position: 'top-end',
               showConfirmButton: false,
                   timer: 3000
             });

                url="{{ url('investment-delete-document') }}";
                x = confirm('Do you want to delete?');
                if(!x)  return false;
                for(var i=0;i<file_up_names.length;++i){

                  if(file_up_names[i]==file.name) 
                  {
                    $.ajaxSetup({
                        headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                     });
                    $.post
                    (url,{file_name:file_up_names[i],action:'beforeSaveDelete'},
                       function(data,status)
                       {
                        if(status == 'success')
                         {
                            Toast.fire({
                            icon: 'success',
                            title: 'Document Deleted Successfully.'
                            })
                            file.previewElement.remove();
                          }   
                        }
                    );
                   }
                }
            },
            url: upload_url,
            paramName: "file",
            params: {
                'type': 'yearly_sales_report',
                 'iTempId': iTempId,
                'iInvestmentProfileId': iInvestmentProfileId
            },
            headers: {
                'x-csrf-token': '{{ csrf_token() }}',
            },
            success: function(file, response) {
                docString += response.id + ',';
                $('#documentId').val(docString.slice(0, -1));
                file_up_names.push(file.name);
            }
        });
        yearly_sales_report_dropzone.addEventListener('drop', event => {
            event.preventDefault();
            let files = event.dataTransfer.files;
            file_yearly_sales_report.files = files;
            console.log('added ' + files.length + ' files');
        });

        $(document).ready(function() 
        {
            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            $('.add_select2').select2({
                closeOnSelect: true,
                // placeholder : "Select Country",
                // allowClear: true,
                // tags: true,
                /* maximumSelectionLength: 5 */
            });
            $('#industries').select2({
                closeOnSelect: true,
                placeholder: "Select Industry",
                allowClear: true,
                tags: true
            });

            datePicker.datepicker({
                format: 'dd-MM-yyyy',
                autoclose: true
            });

            datePicker1.datepicker({
                format: 'yyyy',
                autoclose: true
            });
            if ($("#vUniqueCode").val() != '') {
                $("#country_id").trigger("change");
                setTimeout(function() {
                    $("#iRegionId").trigger("change");
                }, 1000);
                setTimeout(function() {
                    $("#iCountyId").trigger("change");
                }, 2000);
                setTimeout(function() {
                    $("#iSubCountyId").trigger("change");
                }, 4000);  
            }

        });

       $('.numeric').keyup(function(e)
        {
            if (/\D,/g.test(this.value)) {
                this.value = this.value.replace(/\D/g, '');
            }
        });

        $('.money').mask("000,000,000,000,000,000,000,000,000", {reverse: true});
        
        function form_submit()
        {
             //echo "fdf";exit;
            error = false;
            var vFirstName = $("#vFirstName").val();


            if (vFirstName.length == 0) {
                $("#vFirstName_error").show();
                $("#vFirstName").addClass('has-error');
                $("#fNameError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vFirstName").removeClass('has-error');
                $("#vFirstName_error").hide();
                $("#fNameError").removeClass('fas fa-exclamation-circle');
                $("#fNameError").addClass('fas fa-check-circle');
                
            }

           // echo vFirstName;exit;
        
            var vLastName = $("#vLastName").val();
            if (vLastName.length == 0) {
                $("#vLastName").addClass('has-error');
                $("#vLastName_error").show();
                $("#lNameError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vLastName_error").hide();
                $("#vLastName").removeClass('has-error');
                $("#lNameError").removeClass('fas fa-exclamation-circle');
                $("#lNameError").addClass('fas fa-check-circle');
                
            }            
       
            var vPhone = $("#vPhone").val();
            if (vPhone.length == 0) {
                $("#vPhone").addClass('has-error');
                $("#vPhone_error").show();
                $("#vPhoneError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vPhone").removeClass('has-error');
                $("#vPhone_error").hide();
                $("#vPhoneError").removeClass('fas fa-exclamation-circle');
                $("#vPhoneError").addClass('fas fa-check-circle');
                
            }
      
            var vEmail = $("#vEmail").val();
            if (vEmail.length == 0) {
                $("#vEmail").addClass('has-error');
                $("#vEmail_error").show();
                $("#vEmail_valid_error").hide();
                $("#vEmailError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                if (validateEmail(vEmail)) {
                    $("#vEmail_valid_error").hide();
                    $("#vEmail_error").hide();
                    $("#vEmail").removeClass('has-error');
                    $("#vEmailError").removeClass('fas fa-exclamation-circle');
                    $("#vEmailError").addClass('fas fa-check-circle');
                    
                } else {
                    $("#vEmail").addClass('has-error');
                    $("#vEmail_valid_error").show();
                    $("#vEmail_error").hide();
                    $("#vEmailError").removeClass('fas fa-check-circle');
                    $("#vEmailError").addClass('fas fa-exclamation-circle');
                    error = true;
                }
            }
        
            var dDob = $("#dDob").val();
            if (dDob.length == 0) {
                $("#dDob").addClass('has-error');
                $("#dDob_error").show();
                $("#DOBError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#dDob_error").hide();
                $("#dDob").removeClass('has-error');
                $("#DOBError").removeClass('fas fa-exclamation-circle');
                $("#DOBError").addClass('fas fa-check-circle');
                
            }

            var vIdentificationNo = $("#vIdentificationNo").val();              
            if (vIdentificationNo.length == 0) {
                $("#vIdentificationNo").addClass('has-error');
                $("#vIdentificationNo_error").show();
                $("#vIdentificationNoError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vIdentificationNo_error").hide();
                $("#vIdentificationNo").removeClass('has-error');
                $("#vIdentificationNoError").removeClass('fas fa-exclamation-circle');
                $("#vIdentificationNoError").addClass('fas fa-check-circle');
            }

            var vBusinessName = $("#vBusinessName").val();

            if (vBusinessName.length == 0) {
                $("#vBusinessName_error").show();
                $("#vBusinessName").addClass('has-error');
                $("#vBusinessNameError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vBusinessName_error").hide();
                $("#vBusinessName").removeClass('has-error');
                $("#vBusinessNameError").removeClass('fas fa-exclamation-circle');
                $("#vBusinessNameError").addClass('fas fa-check-circle');
            }
      
            var vBusinessProfileName = $("#vBusinessProfileName").val();
            if (vBusinessProfileName.length == 0) {
                $("#vBusinessProfileName").addClass('has-error');    
                $("#vBusinessProfileName_error").show();
                $("#vBusinessProfileNameError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vBusinessProfileName_error").hide();
                $("#vBusinessProfileName").removeClass('has-error');
                $("#vBusinessProfileNameError").removeClass('fas fa-exclamation-circle');
                $("#vBusinessProfileNameError").addClass('fas fa-check-circle');
            }


            var tInvestmentReason = $("#tInvestmentReason").val();
             if (tInvestmentReason.length == 0) {
                $("#tInvestmentReason_error").show();
                $("#tInvestmentReason").addClass('has-error');
                $("#tInvestmentReasonError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#tInvestmentReason_error").hide();
                $("#tInvestmentReason").removeClass('has-error');
                $("#tInvestmentReasonError").removeClass('fas fa-exclamation-circle');
                $("#tInvestmentReasonError").addClass('fas fa-check-circle');
            }
        
            var tBusinessProfileDetail = $("#tBusinessProfileDetail").val();
             if (tBusinessProfileDetail.length == 0) {
                $("#tBusinessProfileDetail_error").show();
                $("#tBusinessProfileDetail").addClass('has-error');
                $("#tBusinessProfileDetailError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#tBusinessProfileDetail_error").hide();
                $("#tBusinessProfileDetail").removeClass('has-error');
                $("#tBusinessProfileDetailError").removeClass('fas fa-exclamation-circle');
                $("#tBusinessProfileDetailError").addClass('fas fa-check-circle');
            }
        
            var vBusinessEstablished = $("#vBusinessEstablished").val();
             if (vBusinessEstablished.length == 0) {
                $("#vBusinessEstablished").addClass('has-error');
                $("#vBusinessEstablished_error").show();
                $("#vBusinessEstablishedError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vBusinessEstablished_error").hide();
                $("#vBusinessEstablished").removeClass('has-error');
                $("#vBusinessEstablishedError").removeClass('fas fa-exclamation-circle');                
                $("#vBusinessEstablishedError").addClass('fas fa-check-circle');
            }

            var intrestCheckbox = $(".intrestCheckbox:checkbox:checked").length;
            if (intrestCheckbox <= 0) {
                $("#intrestedIn_error").show();
                $("#intrestedIn_error").addClass('has-error');
                error = true;
            } else {
                $("#intrestedIn_error").hide();
                $("#intrestedIn_error").removeClass('has-error');
            }
        
          



            // var interestedin = $("#interestedin").val();
            // if (interestedin.length == 0) {
            //     $("#intrestedin_error").show();
            //     $("#interestedin").addClass('has-error');
            //     $("#intrestedin_error").addClass('fas fa-exclamation-circle');
            //     error = true;
            // } else { 
            //     $("#interestedin_error").hide();
            //     $("#interestedin").removeClass('has-error');
            //     $("#intrestedin_error").removeClass('fas fa-exclamation-circle');                
            //     $("#intrestedin_error").addClass('fas fa-check-circle');
            // }

           
            var eBusinessProfile = $("#eBusinessProfile").val();
            if (eBusinessProfile.length == 0) {
                $("#eBusinessProfile_error").show();
                $("#eBusinessProfile").addClass('has-error');
                $("#eBusinessProfileerror").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#eBusinessProfile_error").hide();
                $("#eBusinessProfile").removeClass('has-error');
                $("#eBusinessProfileerror").removeClass('fas fa-exclamation-circle');                
                $("#eBusinessProfileerror").addClass('fas fa-check-circle');
            }

            // var legal_entity = $('#legal_entity option:selected').val();
            //     if (!legal_entity) {
            //         $("#legelEntity_error").show();
            //         $("#legelEntity_error").addClass('has-error');
            //         error = true;
            //     } else {
            //         $("#legelEntity_error").hide();
            //         $("#legelEntity_error").removeClass('has-error');
            // }


        
            var legal_entity = $("#legal_entity").val();
            if (legal_entity.length == 0) {
                $("#legelEntity_error").show();
                $("#legal_entity").addClass('has-error');
                $("#legelEntityerror").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#legelEntity_error").hide();
                $("#legal_entity").removeClass('has-error');
                $("#legelEntityerror").removeClass('fas fa-exclamation-circle');                
                $("#legelEntityerror").addClass('fas fa-check-circle');
            }
        
            var industries = $("#industries").val();
            if (industries.length == 0) {
                $("#industries_error").show();
                $("#industries").addClass('has-error');
                $("#industriesError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#industries_error").hide();
                $("#industries").removeClass('has-error');
                $("#industriesError").removeClass('fas fa-exclamation-circle');                
                $("#industriesError").addClass('fas fa-check-circle');
            }
        
            var iCountid = $("#iCountyId").val();
            if (iCountid.length == 0) {
                $("#county_id_error").show();
                $("#iCountyId").addClass('has-error');
                $("#iCountyIdError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#county_id_error").hide();
                $("#iCountid").removeClass('has-error');
                $("#iCountyIdError").removeClass('fas fa-exclamation-circle');                
                $("#iCountyIdError").addClass('fas fa-check-circle');
            }
        
            var iRegionId = $("#iRegionId").val();
             if (iRegionId.length == 0) {
                $("#region_id_error").show();
                $("#iRegionId").addClass('has-error');
                $("#iRegionIdError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#region_id_error").hide();
                $("#iRegionId").removeClass('has-error');
                $("#iRegionIdError").removeClass('fas fa-exclamation-circle');                
                $("#iRegionIdError").addClass('fas fa-check-circle');
            }
        
            var iCountryId = $("#country_id").val();
            if (iCountryId.length == 0) {
                $("#country_id").addClass('has-error');
                $("#iCountryId_error").show();
                $("#iCountryIdError").addClass('fas fa-exclamation-circle');                
                 error = true;
            } else {
                $("#iCountryId_error").hide();
                $("#country_id").removeClass('has-error');
                $("#iCountryIdError").removeClass('fas fa-exclamation-circle');                
                $("#iCountryIdError").addClass('fas fa-check-circle');
            }
        
            var iSubCountyId = $("#iSubCountyId").val();
            if (iSubCountyId.length == 0) {
                $("#sub_county_id_error").show();
                $("#iSubCountyId").addClass('has-error');
                $("#iSubCountyIdError").addClass('fas fa-exclamation-circle');                
                error = true;
            } else {
                $("#sub_county_id_error").hide();
                $("#iSubCountyId").removeClass('has-error');
                $("#iSubCountyIdError").removeClass('fas fa-exclamation-circle');                
                $("#iSubCountyIdError").addClass('fas fa-check-circle');
            }
        
            var tBusinessDetail = $("#tBusinessDetail").val();
             if (tBusinessDetail.length == 0) {
                $("#tBusinessDetail_error").show();
                $("#tBusinessDetail").addClass('has-error');
                $("#tBusinessDetailError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                if (max_word_allow_check('tBusinessDetail',50) <= 50) {
                    $("#tBusinessDetail_min_length_error").show();
                    $("#tBusinessDetail").addClass('has-error');
                    $("#tBusinessDetailError").addClass('fas fa-exclamation-circle');
                    error = true;
                }
                else {
                    $("#tBusinessDetail_error").hide();
                    $("#tBusinessDetail").removeClass('has-error');
                    $("#tBusinessDetail_min_length_error").hide();
                    $("#tBusinessDetailError").removeClass('fas fa-exclamation-circle');
                    $("#tBusinessDetailError").addClass('fas fa-check-circle');
                }
            }
        
            var tBusinessHighLights = $("#tBusinessHighLights").val();

            if (tBusinessHighLights.length == 0) {
                $("#tBusinessHighLights_error").show();
                $("#tBusinessHighLights").addClass('has-error');
                $("#tBusinessHighLightsError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#tBusinessHighLights_error").hide();
                $("#tBusinessHighLights").removeClass('has-error');
                $("#tBusinessHighLightsError").removeClass('fas fa-exclamation-circle');
                $("#tBusinessHighLightsError").addClass('fas fa-check-circle');
            }
        
            /*var tFacility = tinyMCE.get('tFacility').getContent();*/
            var tFacility = $("#tFacility").val();
            if (tFacility.length == 0) {
                $("#tFacility_error").show();
                $("#tFacility").addClass('has-error');
                $("#tFacilityError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#tFacility_error").hide();
                $("#tFacility").removeClass('has-error');
                $("#tFacilityError").removeClass('fas fa-exclamation-circle');
                $("#tFacilityError").addClass('fas fa-check-circle');
                
            }
        
            var tListProductService = tinyMCE.get('tListProductService').getContent();
             if (tListProductService.length == 0) {
                $("#tListProductService_error").show();
                $("#tListProductService").addClass('has-error');
                $("#tListProductServiceError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#tListProductService_error").hide();
                $("#tListProductService").removeClass('has-error');
                $("#tListProductServiceError").removeClass('fas fa-exclamation-circle');
                $("#tListProductServiceError").addClass('fas fa-check-circle');
                
            }
        
            var vAverateMonthlySales = $("#vAverateMonthlySales").val();
              if (vAverateMonthlySales.length == 0) {
                $("#vAverateMonthlySales_error").show();
                $("#vAverateMonthlySales").addClass('has-error');
                $("#vAverateMonthlySalesError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vAverateMonthlySales_error").hide();
                $("#vAverateMonthlySales").removeClass('has-error');
                $("#vAverateMonthlySalesError").removeClass('fas fa-exclamation-circle');
                $("#vAverateMonthlySalesError").addClass('fas fa-check-circle');
                
            }

        
            var vProfitMargin = $("#vProfitMargin").val();
             if (vProfitMargin.length == 0) {
                $("#vProfitMargin_error").show();
                $("#vProfitMargin").addClass('has-error');
                error = true;
            } else {
                if (check_length(vProfitMargin, 100)) {
                    $("#vProfitMargin_error").hide();
                    $("#vProfitMargin_maxLength_error").show();
                    $("#vProfitMargin").addClass('has-error');
                    error = true;
                } else {
                    $("#vProfitMargin_error").hide();
                    $("#vProfitMargin_maxLength_error").hide();
                    $("#vProfitMargin").removeClass('has-error');
                    
                }
            }
        
            var vPhysicalAssetValue = $("#vPhysicalAssetValue").val();
            if (vPhysicalAssetValue.length == 0) {
                $("#vPhysicalAssetValue_error").show();
                $("#vPhysicalAssetValue").addClass('has-error');
                $("#vAverateMonthlySales").addClass('has-error');
                $("#vPhysicalAssetValueError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vPhysicalAssetValue_error").hide();
                $("#vPhysicalAssetValue").removeClass('has-error');
                $("#vPhysicalAssetValueError").removeClass('fas fa-exclamation-circle');
                $("#vPhysicalAssetValueError").addClass('fas fa-check-circle');
                
            }
        
            var vMaxStakeSell = $("#vMaxStakeSell").val();
             if (vMaxStakeSell.length == 0) {
                $("#vMaxStakeSell_error").show();
                $("#vMaxStakeSell").addClass('has-error');
                $("#vMaxStakeSellError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                if (check_length(vMaxStakeSell, 100)) {
                    $("#vMaxStakeSell_error").hide();
                    $("#vMaxStakeSell_maxLength_error").show();
                    $("#vMaxStakeSell").addClass('has-error');
                    $("#vMaxStakeSellError").addClass('fas fa-exclamation-circle');
                    error = true;
                } else {
                    $("#vMaxStakeSell_error").hide();
                    $("#vMaxStakeSell_maxLength_error").hide();
                    $("#vMaxStakeSell").removeClass('has-error');
                    $("#vMaxStakeSellError").removeClass('fas fa-exclamation-circle');
                    $("#vMaxStakeSellError").addClass('fas fa-check-circle');
                    
                }
            }
        
            var vInvestmentAmountStake = $("#vInvestmentAmountStake").val();
            if (vInvestmentAmountStake.length == 0) {
                $("#vInvestmentAmountStake_error").show();
                $("#vInvestmentAmountStake").addClass('has-error');
                $("#vInvestmentAmountStakeError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vInvestmentAmountStake_error").hide();
                $("#vInvestmentAmountStake").removeClass('has-error');
                $("#vInvestmentAmountStakeError").removeClass('fas fa-exclamation-circle');
                $("#vInvestmentAmountStakeError").addClass('fas fa-check-circle');
                
            }


            // $(document).on('change blur', '#interestedin', function()         
            // {
            // var interestedin = $("#interestedin").val();
            // if (interestedin.length == 0) {
            //     $("#interestedin_error").show();
            //     $("#interestedin").addClass('has-error');
            //     $("#interestedinError").addClass('fas fa-exclamation-circle');
            //     error = true;
            // } else {
            //     $("#interestedin_error").hide();
            //     $("#interestedin").removeClass('has-error');
            //     $("#interestedinError").removeClass('fas fa-exclamation-circle');                
            //     $("#interestedinError").addClass('fas fa-check-circle');
            // }
            // });
        
      
            var eFindersFee = $("#eFindersFee:checkbox:checked").length;
             if (eFindersFee == 0) {
                $("#eFindersFee_error").show();
                $("#eFindersFee").addClass('has-error');
                error = true;
            } else {
                $("#eFindersFee_error").hide();
                $("#eFindersFee").removeClass('has-error');
            }
            setTimeout(function() {
                if (error == true) {
                    $('.has-error').first().focus();
                    return false;
                } else {
                    $("#frm").submit();
                    $('.submit').hide();
                    $('.loading').show();
                    return true;
                }
            }, 1000);

        }

        $(document).on('click', '#submit', function() {
            form_submit();            
        });
        $(document).on('change blur', '#vFirstName', function() {
         var vFirstName = $("#vFirstName").val();

            if (vFirstName.length == 0) {
                $("#vFirstName_error").show();
                $("#vFirstName").addClass('has-error');
                $("#fNameError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vFirstName").removeClass('has-error');
                $("#vFirstName_error").hide();
                $("#fNameError").removeClass('fas fa-exclamation-circle');
                $("#fNameError").addClass('fas fa-check-circle');
                
            }
        });

        $(document).on('change blur', '.intrestCheckbox', function()         
        {
            var intrestCheckbox = $(".intrestCheckbox:checkbox:checked").length;
           if (intrestCheckbox <= 0) {
                $("#intrestedIn_error").show();
                $("#intrestedIn_error").addClass('has-error');
                error = true;
            } else {
                $("#intrestedIn_error").hide();
                $("#intrestedIn_error").removeClass('has-error');
            }
        });

        // $(document).on('change blur', '#interestedin', function()         
        //     {
        //     var interestedin = $("#interestedin").val();
        //     if (interestedin.length == 0) {
        //         $("#interestedin_error").show();
        //         $("#interestedin").addClass('has-error');
        //         $("#interestedinError").addClass('fas fa-exclamation-circle');
        //         error = true;
        //     } else {
        //         $("#interestedin_error").hide();
        //         $("#interestedin").removeClass('has-error');
        //         $("#interestedinError").removeClass('fas fa-exclamation-circle');                
        //         $("#interestedinError").addClass('fas fa-check-circle');
        //     }
        //     });

         $(document).on('change blur', '#vLastName', function() 
          {
            var vLastName = $("#vLastName").val();
            if (vLastName.length == 0) {
                $("#vLastName").addClass('has-error');
                $("#vLastName_error").show();
                $("#lNameError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vLastName_error").hide();
                $("#vLastName").removeClass('has-error');
                $("#lNameError").removeClass('fas fa-exclamation-circle');
                $("#lNameError").addClass('fas fa-check-circle');
            }              
         });  
        $(document).on('change blur', '#vPhone', function() 
          {
            var vPhone = $("#vPhone").val();
             if (vPhone.length == 0) {
                $("#vPhone").addClass('has-error');
                $("#vPhone_error").show();
                $("#vPhoneError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vPhone").removeClass('has-error');
                $("#vPhone_error").hide();
                $("#vPhoneError").removeClass('fas fa-exclamation-circle');
                $("#vPhoneError").addClass('fas fa-check-circle');                
            }
        });
        $(document).on('change blur', '#vEmail', function() 
          {
            var vEmail = $("#vEmail").val();
            if (vEmail.length == 0) {
                $("#vEmail").addClass('has-error');
                $("#vEmail_error").show();
                $("#vEmail_valid_error").hide();
                $("#vEmailError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                if (validateEmail(vEmail)) {
                    $("#vEmail_valid_error").hide();
                    $("#vEmail_error").hide();
                    $("#vEmail").removeClass('has-error');
                    $("#vEmailError").removeClass('fas fa-exclamation-circle');
                    $("#vEmailError").addClass('fas fa-check-circle');
                    
                } else {
                    $("#vEmail").addClass('has-error');
                    $("#vEmail_valid_error").show();
                    $("#vEmail_error").hide();
                    $("#vEmailError").removeClass('fas fa-check-circle');
                    $("#vEmailError").addClass('fas fa-exclamation-circle');
                    error = true;
                }
            }
        });
        $(document).on('change blur', '#dDob', function() 
          {
              var dDob = $("#dDob").val();
                 if (dDob.length == 0) 
            {
                $("#dDob").addClass('has-error');
                $("#dDob_error").show();
                $("#DOBError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                    $("#dDob_error").hide();
                    $("#dDob").removeClass('has-error');
                    $("#DOBError").removeClass('fas fa-exclamation-circle');
                    $("#DOBError").addClass('fas fa-check-circle');                    
            }
          });
        $(document).on('change blur', '#vIdentificationNo', function() 
          {
            var vIdentificationNo = $("#vIdentificationNo").val();              
            if (vIdentificationNo.length == 0) {
                $("#vIdentificationNo").addClass('has-error');
                $("#vIdentificationNo_error").show();
                $("#vIdentificationNoError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vIdentificationNo_error").hide();
                $("#vIdentificationNo").removeClass('has-error');
                $("#vIdentificationNoError").removeClass('fas fa-exclamation-circle');
                $("#vIdentificationNoError").addClass('fas fa-check-circle');
            }

          });
        $(document).on('change blur', '#vBusinessName', function()         
          {
            var vBusinessName = $("#vBusinessName").val();

            if (vBusinessName.length == 0) {
                $("#vBusinessName_error").show();
                $("#vBusinessName").addClass('has-error');
                $("#vBusinessNameError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vBusinessName_error").hide();
                $("#vBusinessName").removeClass('has-error');
                $("#vBusinessNameError").removeClass('fas fa-exclamation-circle');
                $("#vBusinessNameError").addClass('fas fa-check-circle');
            }
         }); 
        $(document).on('change blur', '#vBusinessProfileName', function()         
          {
            var vBusinessProfileName = $("#vBusinessProfileName").val();
             if (vBusinessProfileName.length == 0) {
                $("#vBusinessProfileName").addClass('has-error');    
                $("#vBusinessProfileName_error").show();
                $("#vBusinessProfileNameError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vBusinessProfileName_error").hide();
                $("#vBusinessProfileName").removeClass('has-error');
                $("#vBusinessProfileNameError").removeClass('fas fa-exclamation-circle');
                $("#vBusinessProfileNameError").addClass('fas fa-check-circle');
            }
         });


         $(document).on('change blur', '#tInvestmentReason', function()         
          {
            var tInvestmentReason = $("#tInvestmentReason").val();
            if (tInvestmentReason.length == 0) {
                $("#tInvestmentReason_error").show();
                $("#tInvestmentReason").addClass('has-error');
                $("#tInvestmentReasonError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#tInvestmentReasonerror").hide();
                $("#tInvestmentReason").removeClass('has-error');
                $("#tInvestmentReasonError").removeClass('fas fa-exclamation-circle');
                $("#tInvestmentReasonError").addClass('fas fa-check-circle');
            }
        });
          $(document).on('change blur', '#tBusinessProfileDetail', function()         
          {
            var tBusinessProfileDetail = $("#tBusinessProfileDetail").val();
            if (tBusinessProfileDetail.length == 0) {
                $("#tBusinessProfileDetail_error").show();
                $("#tBusinessProfileDetail").addClass('has-error');
                $("#tBusinessProfileDetailError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#tBusinessProfileDetail_error").hide();
                $("#tBusinessProfileDetail").removeClass('has-error');
                $("#tBusinessProfileDetailError").removeClass('fas fa-exclamation-circle');
                $("#tBusinessProfileDetailError").addClass('fas fa-check-circle');
            }
        });
        $(document).on('change blur', '#vBusinessEstablished', function()         
          {
            var vBusinessEstablished = $("#vBusinessEstablished").val();
              if (vBusinessEstablished.length == 0) {
                $("#vBusinessEstablished").addClass('has-error');
                $("#vBusinessEstablished_error").show();
                $("#vBusinessEstablishedError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vBusinessEstablished_error").hide();
                $("#vBusinessEstablished").removeClass('has-error');
                $("#vBusinessEstablishedError").removeClass('fas fa-exclamation-circle');                
                $("#vBusinessEstablishedError").addClass('fas fa-check-circle');
            }
        });
        


        $(document).on('change blur', '#eBusinessProfile', function() {
            var eBusinessProfile = $(this).val();
            if (eBusinessProfile.length == 0) {
                $("#eBusinessProfile_error").show();
                $("#eBusinessProfile").addClass('has-error');
                $("#eBusinessProfileerror").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#eBusinessProfile_error").hide();
                $("#eBusinessProfile").removeClass('has-error');
                $("#eBusinessProfileerror").removeClass('has-error');
                $("#eBusinessProfileerror").addClass('fas fa-check-circle');
            }
            });
        

            $(document).on('change blur', '#legal_entity', function() {
            var legal_entity = $(this).val();
            if (legal_entity.length == 0) {
                $("#legelEntity_error").show();
                $("#legal_entity").addClass('has-error');
                $("#legelEntityerror").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#legelEntity_error").hide();
                $("#legal_entity").removeClass('has-error');
                $("#legelEntityerror").removeClass('has-error');
                $("#legelEntityerror").addClass('fas fa-check-circle');
            }
            });


        
        $(document).on('change blur', '#industries', function()         
        {
            var industries = $("#industries").val();
            if (industries.length == 0) {
                $("#industries_error").show();
                $("#industries").addClass('has-error');
                $("#industriesError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#industries_error").hide();
                $("#industries").removeClass('has-error');
                $("#industriesError").removeClass('fas fa-exclamation-circle');                
                $("#industriesError").addClass('fas fa-check-circle');
            }
        });

        $(document).on('change blur', '#iCountyId', function()         
        {
            var iCountid = $("#iCountyId").val();
           if (iCountid.length == 0) {
                $("#county_id_error").show();
                $("#iCountyId").addClass('has-error');
                $("#iCountyIdError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#county_id_error").hide();
                $("#iCountid").removeClass('has-error');
                $("#iCountyIdError").removeClass('fas fa-exclamation-circle');                
                $("#iCountyIdError").addClass('fas fa-check-circle');
            }
        });
        $(document).on('change blur', '#iRegionId', function()         
        {
            var iRegionId = $("#iRegionId").val();
             if (iRegionId.length == 0) {
                $("#region_id_error").show();
                $("#iRegionId").addClass('has-error');
                $("#iRegionIdError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#region_id_error").hide();
                $("#iRegionId").removeClass('has-error');
                $("#iRegionIdError").removeClass('fas fa-exclamation-circle');                
                $("#iRegionIdError").addClass('fas fa-check-circle');
            }
        });
        $(document).on('change blur', '#country_id', function()         
        {
            var iCountryId = $("#country_id").val();
            if (iCountryId.length == 0) {
                $("#country_id").addClass('has-error');
                $("#iCountryId_error").show();
                $("#iCountryIdError").addClass('fas fa-exclamation-circle');                
                 error = true;
            } else {
                $("#iCountryId_error").hide();
                $("#country_id").removeClass('has-error');
                $("#iCountryIdError").removeClass('fas fa-exclamation-circle');                
                $("#iCountryIdError").addClass('fas fa-check-circle');
            }
        });
        $(document).on('change blur', '#iSubCountyId', function()         
        {
            var iSubCountyId = $("#iSubCountyId").val();
            if (iSubCountyId.length == 0) {
                $("#sub_county_id_error").show();
                $("#iSubCountyId").addClass('has-error');
                $("#iSubCountyIdError").addClass('fas fa-exclamation-circle');                
                error = true;
            } else {
                $("#sub_county_id_error").hide();
                $("#iSubCountyId").removeClass('has-error');
                $("#iSubCountyIdError").removeClass('fas fa-exclamation-circle');                
                $("#iSubCountyIdError").addClass('fas fa-check-circle');
            }
        });
        $(document).on('change blur', '#tBusinessDetail', function()         
        {
            var tBusinessDetail = $("#tBusinessDetail").val();
             if (tBusinessDetail.length == 0) {
                $("#tBusinessDetail_error").show();
                $("#tBusinessDetail").addClass('has-error');
                $("#tBusinessDetailError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                if (max_word_allow_check('tBusinessDetail',50) < 50) {
                    $("#tBusinessDetail_min_length_error").show();
                    $("#tBusinessDetail_error").hide();
                    $("#tBusinessDetail").addClass('has-error');
                    $("#tBusinessDetailError").addClass('fas fa-exclamation-circle');
                    error = true;
                }
                else {
                    $("#tBusinessDetail_error").hide();
                    $("#tBusinessDetail_min_length_error").hide();
                    $("#tBusinessDetail").removeClass('has-error');
                    $("#tBusinessDetailError").removeClass('fas fa-exclamation-circle');
                    $("#tBusinessDetailError").addClass('fas fa-check-circle');
                }
            }
        });
        $(document).on('change blur', '#tBusinessHighLights', function()         
        {
            var tBusinessHighLights = $("#tBusinessHighLights").val();
            if (tBusinessHighLights.length == 0) {
                $("#tBusinessHighLights_error").show();
                $("#tBusinessHighLights").addClass('has-error');
                $("#tBusinessHighLightsError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#tBusinessHighLights_error").hide();
                $("#tBusinessHighLights").removeClass('has-error');
                $("#tBusinessHighLightsError").removeClass('fas fa-exclamation-circle');
                $("#tBusinessHighLightsError").addClass('fas fa-check-circle');
            }
        });
        $(document).on('change blur', '#tFacility', function()         
        {   var tFacility = $("#tFacility").val();
            
           if (tFacility.length == 0) {
                $("#tFacility_error").show();
                $("#tFacility").addClass('has-error');
                $("#tFacilityError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#tFacility_error").hide();
                $("#tFacility").removeClass('has-error');
                $("#tFacilityError").removeClass('fas fa-exclamation-circle');
                $("#tFacilityError").addClass('fas fa-check-circle');
            }
        });
        $(document).on('change blur', '#tListProductService', function()         
        {
            var tListProductService = tinyMCE.get('tListProductService').getContent();
             if (tListProductService.length == 0) {
                $("#tListProductService_error").show();
                $("#tListProductService").addClass('has-error');
                $("#tListProductServiceError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#tListProductService_error").hide();
                $("#tListProductService").removeClass('has-error');
                $("#tListProductServiceError").removeClass('fas fa-exclamation-circle');
                $("#tListProductServiceError").addClass('fas fa-check-circle');
                
            }
        });
        $(document).on('change blur', '#vAverateMonthlySales', function()         
        {
            var vAverateMonthlySales = $("#vAverateMonthlySales").val();
            if (vAverateMonthlySales.length == 0) {
                $("#vAverateMonthlySales_error").show();
                $("#vAverateMonthlySales").addClass('has-error');
                $("#vAverateMonthlySalesError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vAverateMonthlySales_error").hide();
                $("#vAverateMonthlySales").removeClass('has-error');
                $("#vAverateMonthlySalesError").removeClass('fas fa-exclamation-circle');
                $("#vAverateMonthlySalesError").addClass('fas fa-check-circle');
            }
        });
        $(document).on('change blur', '#vProfitMargin', function()         
        {
        
            var vProfitMargin = $("#vProfitMargin").val();

             if (vProfitMargin.length == 0) {
                $("#vProfitMargin_error").show();
                $("#vProfitMargin").addClass('has-error');
                $("#vProfitMarginError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                if (check_length(vProfitMargin, 100) || vProfitMargin > 100) {
                    $("#vProfitMargin_error").hide();
                    $("#vProfitMargin_maxLength_error").show();
                    $("#vProfitMargin").addClass('has-error');
                    $("#vProfitMarginError").addClass('fas fa-exclamation-circle');
                    error = true;
                } else {
                    $("#vProfitMargin_error").hide();
                    $("#vProfitMargin_maxLength_error").hide();
                    $("#vProfitMargin").removeClass('has-error');
                    $("#vProfitMarginError").removeClass('fas fa-exclamation-circle');
                    $("#vProfitMarginError").addClass('fas fa-check-circle');
                    
                }
            }
        });
        $(document).on('change blur', '#vPhysicalAssetValue', function()         
        {
            var vPhysicalAssetValue = $("#vPhysicalAssetValue").val();
           if (vPhysicalAssetValue.length == 0) {
                $("#vPhysicalAssetValue_error").show();
                $("#vPhysicalAssetValue").addClass('has-error');
                $("#vAverateMonthlySales").addClass('has-error');
                $("#vPhysicalAssetValueError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vPhysicalAssetValue_error").hide();
                $("#vPhysicalAssetValue").removeClass('has-error');
                $("#vPhysicalAssetValueError").removeClass('fas fa-exclamation-circle');
                $("#vPhysicalAssetValueError").addClass('fas fa-check-circle');
                
            }
        });
        $(document).on('change blur', '#vMaxStakeSell', function()         
        {
            var vMaxStakeSell = $("#vMaxStakeSell").val();
             if (vMaxStakeSell.length == 0) {
                $("#vMaxStakeSell_error").show();
                $("#vMaxStakeSell").addClass('has-error');
                $("#vMaxStakeSellError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                if (check_length(vMaxStakeSell, 100) || vMaxStakeSell > 100) {
                    $("#vMaxStakeSell_error").hide();
                    $("#vMaxStakeSell_maxLength_error").show();
                    $("#vMaxStakeSell").addClass('has-error');
                    $("#vMaxStakeSellError").addClass('fas fa-exclamation-circle');
                    error = true;
                } else {
                    $("#vMaxStakeSell_error").hide();
                    $("#vMaxStakeSell_maxLength_error").hide();
                    $("#vMaxStakeSell").removeClass('has-error');
                    $("#vMaxStakeSellError").removeClass('fas fa-exclamation-circle');
                    $("#vMaxStakeSellError").addClass('fas fa-check-circle');
                    
                }
            }
        });
        $(document).on('change blur', '#vInvestmentAmountStake', function()
        {
            var vInvestmentAmountStake = $("#vInvestmentAmountStake").val();
             if (vInvestmentAmountStake.length == 0) {
                $("#vInvestmentAmountStake_error").show();
                $("#vInvestmentAmountStake").addClass('has-error');
                $("#vInvestmentAmountStakeError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vInvestmentAmountStake_error").hide();
                $("#vInvestmentAmountStake").removeClass('has-error');
                $("#vInvestmentAmountStakeError").removeClass('fas fa-exclamation-circle');
                $("#vInvestmentAmountStakeError").addClass('fas fa-check-circle');
                
            }
        });
        $(document).on('change blur', '#eFindersFee', function()
          {
            var eFindersFee = $("#eFindersFee:checkbox:checked").length;
             if (eFindersFee == 0) {
                $("#eFindersFee_error").show();
                $("#eFindersFee").addClass('has-error');
                error = true;
            } else {
                $("#eFindersFee_error").hide();
                $("#eFindersFee").removeClass('has-error');
            }
          });
        
      //on change remove validation error end

        
        function validateEmail(sEmail) {
            var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (filter.test(sEmail)) {
                return true;
            } else {
                return false;
            }
        }

        function check_length(value, custom_length) {
            if (value > custom_length || value < 0) {
                return true;
            }
            return false;
        }

        $(document).on('change', '#vImage', function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#img_logo').attr('src', e.target.result);
                    $('#img_logo').show();
                    $('#img_old_logo').hide();
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        /* 
            $('.investmentHeader').click(function() {
            
                id = $(this).data("id");
                tabid=$(this).attr('id');

                if (id == "first-step" || id == "second-step" || id == "third-step" || id == 'fourth-step' ) 
                {
                    var first = id;
                    $('.investmentHeader').removeClass('active');
                    $("#" + tabid).addClass("active");
                    $(".investment_forms").hide();
                    $("#" + first).show();
                } 
            });
        */

        $(document).on('change', '#country_id', function() {
            var selected_region_id = $("#selected_region_id").val();
            var country_id = $("#country_id").val();
            if (country_id != '') {
                $("#iRegionId").html('');
                $.ajax({
                    url: "{{ url('investment/get_region_by_country') }}",
                    type: "POST",
                    data: {
                        country_id: country_id,
                        _token: '{{ csrf_token() }}'
                    },

                    dataType: 'json',
                    success: function(result) {
                        $('#iRegionId').html('<option value="">Select Region</option>');
                        $.each(result.region, function(key, value) {
                            var selected = '';
                            if (selected_region_id == value.iRegionId + '_' + value.vTitle) {
                                selected = 'selected';
                            }
                            $("#iRegionId").append('<option value="' + value.iRegionId + '_' + value.vTitle + '" ' + selected + '>' + value.vTitle + '</option>');
                        });
                    }
                });
            }
        });

        $(document).on('change', '#iRegionId', function() {
            var selected_county_id = $("#selected_county_id").val();
            var iRegionId = $("#iRegionId").val();
            if (iRegionId != '') {
                $("#iCountyId").html('');
                $.ajax({
                    url: "{{ url('investment/get_county_by_region') }}",
                    type: "POST",
                    data: {
                        region_id: iRegionId,
                        _token: '{{ csrf_token() }}'
                    },

                    dataType: 'json',
                    success: function(result) {
                        // console.log(result);
                        $('#iCountyId').html('<option value="">Select County</option>');
                        $.each(result.county, function(key, value) {
                            var selected = '';
                            if (selected_county_id == value.iCountyId + '_' + value.vTitle) {
                                selected = 'selected';
                            }
                            $("#iCountyId").append('<option value="' + value.iCountyId + '_' + value.vTitle + '" ' + selected + '>' + value.vTitle + '</option>');
                        });
                    }
                });
            }
        });

        $(document).on('change', '#iCountyId', function() {
            var selected_sub_county_id = $("#selected_sub_county_id").val();
            var iCountyId = $("#iCountyId").val();
            if (iCountyId != '') {
                $("#iSubCountyId").html('');
                $.ajax({
                    url: "{{ url('investment/get_sub_county_by_county') }}",
                    type: "POST",
                    data: {
                        iCountyId: iCountyId,
                        _token: '{{ csrf_token() }}'
                    },

                    dataType: 'json',
                    success: function(result) {
                        // console.log(result);
                        $('#iSubCountyId').html('<option value="">Select Sub County</option>');
                        $.each(result.subCounty, function(key, value) {
                            var selected = '';
                            if (selected_sub_county_id == value.iSubCountId + '_' + value.vTitle) {
                                selected = 'selected';
                            }
                            $("#iSubCountyId").append('<option value="' + value.iSubCountId + '_' + value.vTitle + '" ' + selected + '>' + value.vTitle + '</option>');
                        });
                    }
                });
            }
        });

      /*  function error_focus() {
            $(".has-error").first().focus();
        }*/

        function max_word_allow_check(input_id, max_word_allow) {
            var textbox_value = $("#"+input_id).val();
            var words = $.trim(textbox_value).length ? textbox_value.match(/\S+/g).length : 0;
            if (words <= max_word_allow) {
                return words;
            }
        }
    
    $(document).on('click','.delete_document',function()
    {
      swal({
        title: "Are you sure you want to delete this document.?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if(willDelete)
        {
          iInvestmentDocumentId = $(this).data("id");
          
          url = "{{ url('investment-delete-document') }}";
          setTimeout(function(){
            $.ajax({
              url: url,
              type: "POST",
              data:  {iInvestmentDocumentId:iInvestmentDocumentId,_token: '{{ csrf_token() }}'}, 
              success: function(response) {
                if(response == 'true'){
                    location.reload();
                }
              }
            });
          }, 500);
        }
      })
    });

// const ele = document.getElementById('tBusinessProfileDetail');
// ele.addEventListener('keydown', function (e) {
//     // Get the code of pressed key
//     const keyCode = e.which || e.keyCode;

//     // 13 represents the Enter key
//     if (keyCode === 13) {
//         console.log('etet');
//         // Don't generate a new line
//         e.preventDefault();
//     e.preventDefault();
//     this.value = this.value.substring(0, this.selectionStart) + "" + "\n" + this.value.substring(this.selectionEnd, this.value.length);
//     }
// });
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@endsection