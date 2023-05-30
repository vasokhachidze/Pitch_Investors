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
$business_proof = $fast_verification = $profile = $facility = $business_plan = $NDA = [];
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
        } elseif ($value->eType == 'business_plan') {
            array_push($business_plan, $value->vImage);
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
                    <div class="col-lg-8 col-md-12">

                    
                        <form id="frm" action="{{ url('investment-store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if(isset($investment)){{$investment->vUniqueCode}}@endif">
                            <input type="hidden" id="iTempId" name="iTempId" value="@if (isset($iTempId)){{$iTempId}}@endif">
                            <input type="hidden" id="iInvestmentProfileId" name="iInvestmentProfileId" value="@if (isset($investment->iInvestmentProfileId)){{$investment->iInvestmentProfileId}}@endif">

                            <!-- frist-step -->
                        <div id="first-step" class="other-detail investment_forms frist-steps">
                            <h5>{{ isset($investment) ? 'Edit' : 'Add' }}  Business Profile</h5>                           
                            <div class="card">
                                <div class="card-header"><p><b>Business Information</b></p><p>Information entered here is displayed publicly to match you with the right set of investors and buyers. Do not mention business name/information which can identify the business.</p></div>
                                
                                <div class="card-body">

                                    <!-- second step -->
                                    <div id="second-step" class="other-detail investment_forms second-steps">
                                        <div class="detail-form">
                                            <div class="row">
                                                <div class="col-lg-12 d-flex-contain positon-relative">
                                                        <label class="top-head" for="vBusinessName">Business Name</label>
                                                        <div class="input-error-type">
                                                        <input type="text" class="form-control rounded-pill" id="vBusinessName" name="vBusinessName" placeholder="Enter the name of your business." value="@if(isset($investment)){{$investment->vBusinessName}}@endif">
                                                        <div class="validination-info">
                                                            <i class="" id="vBusinessNameError"></i>
                                                        </div>

                                                        <div id="vBusinessName_error" class="error mt-1" style="color:red;display: none;">Enter the name of your business. </div>
                                                        </div>
                                                </div>
                                                <div class="col-lg-12 d-flex-contain positon-relative">
                                                    
                                                    <label class="top-head" for="industries">Business Industry</label>
                                                    <div class="input-error-type">   
                                                    <select name="industries" id="industries" class="form-control rounded-pill">
                                                        @php
                                                            // dd($selected_industries);
                                                            $industry_select = '';
                                                        @endphp
                                                        <option value="">Select Industry</option>

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
                                                    <div id="industries_error" class="error mt-1" style="color:red;display: none;">Specify the industry or sector your business operates in</div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 d-flex-contain positon-relative">
                                                    <label class="top-head" for="tBusinessProfileDetail">Business Description</label>
                                                    <div class="input-error-type">
                                                    <textarea class="form-control" id="tBusinessProfileDetail" name="tBusinessProfileDetail" placeholder="Business Description" cols='60' rows='8' style="height: 100px">@if(isset($investment)){{$investment->tBusinessProfileDetail}}@endif</textarea>
                                                    {{-- <input type="text" class="form-control" id="tBusinessProfileDetail" name="tBusinessProfileDetail" placeholder="Business Description" value="@if(isset($investment)){{$investment->tBusinessProfileDetail}}@endif"> --}}
                                                    <div class="validination-info">
                                                        <i class="" id="tBusinessProfileDetailError"></i>
                                                    </div>

                                                    <div id="tBusinessProfileDetail_error" class="error mt-1" style="color:red;display: none;">Briefly describe your business and its products/services </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 d-flex-contain positon-relative">
                                                    <label class="top-head" for="tBusinessStage">Business Stage</label>
                                                    <div class="input-error-type">   
                                                    <select id="vBusinessStage" name="vBusinessStage" class="add_select2 form-control rounded-pill">
                                                        <option  value="">Select Stage</option>
                                                        <option <?php if(isset($investment) && $investment->vBusinessStage == 'Startup'){ echo 'selected';  } ?> value="Startup">Startup</option>
                                                        <option <?php if(isset($investment) && $investment->vBusinessStage == 'Growth'){ echo 'selected';  } ?> value="Growth">Growth</option>
                                                        <option  <?php if(isset($investment) && $investment->vBusinessStage == 'Established'){ echo 'selected';  } ?> value="Established">Established</option>
                                                    </select>
                                                    <div class="validination-info">
                                                        <i class="" id="tBusinessStage"></i>
                                                    </div>
                                                    <div id="vBusinessStage_error" class="error mt-1" style="color:red;display: none;">Select the stage of your business's development</div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 d-flex-contain positon-relative">
                                                    <label class="top-head" for="vInvestmentAmountStake"> Funding Amount</label>
                                                    <div class="input-error-type">
                                                        <input type="text" class="form-control rounded-pill" name="vInvestmentAmountStake" id="vInvestmentAmountStake" class="form-control numeric money" placeholder="Enter the amount of funding you are seeking in USD" value="@if(isset($investment)){{$investment->vInvestmentAmountStake}}@endif">
                                                        <div class="validination-info">
                                                        <i class="" id="vInvestmentAmountStakeError"></i>
                                                        </div>

                                                        <div id="vInvestmentAmountStake_error" class="error mt-1" style="color:red;display: none;">Enter the amount of funding you are seeking in USD</div>
                                                    </div>
                                                </div>


                                                <div class="col-lg-12 d-flex-contain positon-relative">
                                                    <label class="top-head">Funding Purpose</label>
                                                    <div class="input-error-type">
                                                    <textarea class="form-control" id="tInvestmentReason" name="tInvestmentReason" placeholder="Describe how you plan to use the investment funds" cols='60' rows='8' style="height: 100px">@if(isset($investment)){{$investment->tInvestmentReason}}@endif</textarea>
                                                    <div class="validination-info">
                                                        <i class="" id="tInvestmentReasonError"></i>
                                                    </div>

                                                    <div id="ttInvestmentReason_error" class="error mt-1" style="color:red;display: none;">Describe how you plan to use the investment funds </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 d-flex-contain positon-relative">
                                                    <label class="top-head" for="vPhysicalAssetValue">Business Valuation</label>
                                                    <div class="input-error-type">
                                                        <input type="text" class="form-control rounded-pill" name="vPhysicalAssetValue" id="vPhysicalAssetValue" class="form-control numeric money" placeholder="Provide an estimate of your business's value in USD" value="@if(isset($investment)){{$investment->vPhysicalAssetValue}}@endif">
                                                            <div class="validination-info">
                                                            <i class="" id="vPhysicalAssetValueError"></i>
                                                        </div>
                                                        <div id="vPhysicalAssetValue_error" class="error mt-1" style="color:red;display: none;">Provide an estimate of your business's value in USD</div>
                                                    </div>    
                                                </div>
                                                <div class="col-lg-12 d-flex-contain positon-relative">
                                                    <label class="top-head" for="tRevenueAndFinancials">Revenue and Financials</label>
                                                    <div class="input-error-type">
                                                    <textarea class="form-control" id="tRevenueAndFinancials" name="tRevenueAndFinancials" placeholder="Provide details about your business's financial performance, revenue, and growth" cols='60' rows='8' style="height: 100px">@if(isset($investment)){{$investment->tRevenueAndFinancials}}@endif</textarea>
                                                        <!-- <input type="text" class="form-control rounded-pill" name="tRevenueAndFinancials" id="tRevenueAndFinancials" class="form-control numeric money" placeholder="Provide details about your business's financial performance, revenue, and growth" value="@if(isset($investment)){{$investment->tRevenueAndFinancials}}@endif"> -->
                                                            <div class="validination-info">
                                                            <i class="" id="tRevenueAndFinancialsError"></i>
                                                        </div>
                                                        <div id="tRevenueAndFinancials_error" class="error mt-1" style="color:red;display: none;">Provide details about your business's financial performance, revenue, and growth</div>
                                                    </div>    
                                                </div>
                                                <div class="col-lg-12 d-flex-contain positon-relative">
                                                    <label class="top-head" for="tMarketAnalysis">Market Analysis</label>
                                                    <div class="input-error-type">
                                                    <textarea class="form-control" id="tMarketAnalysis" name="tMarketAnalysis" placeholder="Describe your target market, competition, and market opportunity" cols='60' rows='8' style="height: 100px">@if(isset($investment)){{$investment->tMarketAnalysis}}@endif</textarea>
                                                            <div class="validination-info">
                                                            <i class="" id="tMarketAnalysisError"></i>
                                                        </div>
                                                        <div id="tMarketAnalysis_error" class="error mt-1" style="color:red;display: none;">Describe your target market, competition, and market opportunity</div>
                                                    </div>    
                                                </div>
                                                <div class="col-lg-12 d-flex-contain positon-relative">
                                                    <label class="top-head" for="vPhysicalAssetValue">Website or Online Presence</label>
                                                    <div class="input-error-type">
                                                        <input type="text" class="form-control rounded-pill" name="vWebsiteLink" id="vWebsiteLink" class="form-control numeric money" placeholder="Provide the URL of your business website or any relevant online presence" value="@if(isset($investment)){{$investment->vWebsiteLink}}@endif">
                                                            <div class="validination-info">
                                                            <i class="" id="vvWebsiteLinkError"></i>
                                                        </div>
                                                        <div id="vWebsiteLink_error" class="error mt-1" style="color:red;display: none;">Provide the URL of your business website or any relevant online presence</div>
                                                    </div>    
                                                </div>

                                                <div class="col-lg-12 d-flex-contain positon-relative">
                                                    <label class="top-head" for="vPhysicalAssetValue">Business Location</label>
                                                    <div class="input-error-type">
                                                        <input type="text" class="form-control rounded-pill" name="vLocation" id="vLocation" class="form-control numeric money" placeholder="Provide the URL of your business website or any relevant online presence" value="@if(isset($investment)){{$investment->vWebsiteLink}}@endif">
                                                            <div class="validination-info">
                                                            <i class="" id="vLocation"></i>
                                                        </div>
                                                        <div id="vLocation" class="error mt-1" style="color:red;display: none;">Provide business location</div>
                                                    </div>    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <br> -->
                            <div class="card" style="display:none">
                                <div class="card-header"><p><b>Business Location</b></p></div>
                                <div class="card-body">
                                    <div class="detail-form">
                                        <div class="row">                                        
                                            <div class="col-lg-6 mb-2 form-group custom-select positon-relative">
                                                <label class="top-head">Select Country</label>
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
                                                <label class="top-head">Select Region</label>
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
                                                <label class="top-head">Select County</label>
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
                                                <label class="top-head">Select Sub County</label>
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
                                <div class="card-header"><p><b>Team Members</div>
                                    <div class="card-body">
                                    <div class="detail-form member-data">
                                    <div class = "member-1" style = "display:none;">
                                        <div class="row ">
                                            <div class="col-md-5 positon-relative">
                                                <label for="floatingPassword">Member</label>
                                                <input type="text" class="form-control rounded-pill"  name="vMemberName[]" placeholder="Member name" value="">                                                
                                            </div>

                                            <div class="col-md-5 positon-relative">
                                                <label for="floatingPassword">Role</label>
                                                <input type="text" class="form-control rounded-pill"  name="vMemberRole[]" placeholder="Member Role" value="">
                                                <div class="validination-info">
                                                    <i class="" ></i>
                                                </div>                                                
                                            </div>                                            
                                            <div onclick ="delete_role(this)" class="col-md-2 positon-relative" style="margin-top:25px;cursor:pointer; color:red">
                                                <i class="fa fa-trash-o"></i> Delete
                                            </div>
                                        </div>
                                        
                                        </div>
                                        @if(isset($selected_memberrole) && !empty($selected_memberrole) && count($selected_memberrole) > 0) 
                                                @foreach ($selected_memberrole as $key => $memberdata)
                                        <div class="row ">
                                            <div class="col-md-5 positon-relative">
                                                <label for="floatingPassword">Member</label>
                                                <input type="text" class="form-control rounded-pill"  name="vMemberName[]" placeholder="Member name" value="{{$memberdata->vMemberName}}">
                                                
                                            </div>

                                            <div class="col-md-5 positon-relative">
                                                <label for="floatingPassword">Role</label>
                                                <input type="text" class="form-control rounded-pill"  name="vMemberRole[]" placeholder="Member Role" value="{{$memberdata->vMemberRole}}">
                                                <div class="validination-info">
                                                    <i class="" ></i>
                                                </div>
                                                
                                            </div>
                                            <div class="memeber-role col-md-2" style="margin-top:25px;cursor:pointer">
                                                <i class="fa fa-plus"></i> Add New
                                            </div>                                            
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="row ">
                                            <div class="col-md-5 positon-relative">
                                                <label for="floatingPassword">Member</label>
                                                <input type="text" class="form-control rounded-pill"  name="vMemberName[]" placeholder="Member name" value="">
                                                
                                            </div>

                                            <div class="col-md-5 positon-relative">
                                                <label for="floatingPassword">Role</label>
                                                <input type="text" class="form-control rounded-pill"  name="vMemberRole[]" placeholder="Member Role" value="">
                                                <div class="validination-info">
                                                    <i class="" ></i>
                                                </div>
                                                
                                            </div>
                                            <div class="memeber-role col-md-2" style="margin-top:25px;cursor:pointer">
                                                <i class="fa fa-plus"></i> Add New
                                            </div>                                            
                                        </div>
                                        @endif
                                    </div>                                    
                                </div>                                
                            </div>
                           
                            <br>
                            <div class="card">
                                <div class="card-header"><p><b>Contact Information</div>
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
                                                <label for="floatingPassword">Email Address</label>
                                                <input type="text" class="form-control rounded-pill" id="vEmail" name="vEmail" placeholder="Email" value="@if(isset($investment)){{$investment->vEmail}}@else{{$session_data['vEmail']}}@endif">
                                                <div class="validination-info">
                                                    <i class="" id="vEmailError"></i>
                                                </div>

                                                <div id="vEmail_error" class="error mt-1" style="color:red;display: none;">Please Enter Your Email </div>
                                                <div id="vEmail_valid_error" class="error_show" style="color:red;display: none;">Please Enter a Valid Email</div>
                                            </div>

                                            <div class="col-md-6 positon-relative">
                                                <label for="floatingPassword">Phone Number</label>
                                                <input type="text" class="form-control rounded-pill numeric" id="vPhone" maxlength="10" name="vPhone" placeholder="Phone No." value="@if(isset($investment)){{$investment->vPhone}}@elseif(!empty($userData)) {{$userData->vPhone}}@else{{$session_data['vPhone']}}@endif">
                                                <div class="validination-info">
                                                    <i class="" id="vPhoneError"></i>
                                                </div>
                                                <div id="vPhone_error" class="error mt-1" style="color:red;display: none;">Please Enter Your Phone No. </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>              
                                
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-header"><p><b>Photos, Documents & Proof</b></p><p>Photos are an important part of your profile and are publicly displayed. Documents help us verify and approve your profile faster. Documents names entered here are publicly visible but are accessible only to introduced members.</p></div>
                                <div class="card-body">    
                                <input type="hidden" name="documentId" id="documentId">                                    
                                    <div class="detail-form">
                                            <div class="row">
                                                <div class="col-lg-12 d-flex-contain positon-relative">
                                                    <label class="mb-1">Business Plan or Pitch Deck</label>
                                                    <div class="input-error-type">
                                                    <div style="font-weight:normal" id="business_plan_dropzone" name='business_plan_dropzone' class="dropzone mb-2"></div>
                                                    <input type="file" name="file_business_plan[]" id="file_business_plan" class="d-none">
                                                </div>
                                                <!-- start display image code -->
                                                <div class="file-upload-img">
                                                    <ul>
                                                    @if(!empty($documents)) 
                                                        @foreach ($documents as $value)
                                                            @if($value->eType == 'business_plan')
                                                            <li class="img-upload">
                                                                @php
                                                                    $current_image = '';
                                                                    @endphp
                                                                    @if(!empty($value->vImage) && file_exists(public_path('uploads/investment/business_plan/' . $value->vImage)))
                                                                        @php
                                                                        $current_image = 'uploads/investment/business_plan/'.$value->vImage;
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
                                </div>
                            </div>
                           <br>
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

      
        var docString = '';

        const business_proof_dropzone = document.getElementById('business_proof_dropzone');
        const file_business_proof = document.getElementById('file_business_proof');

        const facility_upload_dropzone = document.getElementById('facility_upload_dropzone');
        const file_facility_upload = document.getElementById('file_facility_upload');

        const business_plan_dropzone = document.getElementById('business_plan_dropzone');
        const file_business_plan = document.getElementById('file_business_plan');

        const file_NDA_dropzone = document.getElementById('file_NDA_dropzone');
        const file_NDA_upload = document.getElementById('file_NDA_upload');
        iTempId = $('#iTempId').val();
        iInvestmentProfileId=$('#iInvestmentProfileId').val();
        file_up_names=[];
       
        var dropzone = new Dropzone('#business_plan_dropzone', {
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
                'type': 'business_plan',
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
        business_plan_dropzone.addEventListener('drop', event => {
            event.preventDefault();
            let files = event.dataTransfer.files;
            file_business_plan.files = files;
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
        
            // var iRegionId = $("#iRegionId").val();
            //  if (iRegionId.length == 0) {
            //     $("#region_id_error").show();
            //     $("#iRegionId").addClass('has-error');
            //     $("#iRegionIdError").addClass('fas fa-exclamation-circle');
            //     error = true;
            // } else {
            //     $("#region_id_error").hide();
            //     $("#iRegionId").removeClass('has-error');
            //     $("#iRegionIdError").removeClass('fas fa-exclamation-circle');                
            //     $("#iRegionIdError").addClass('fas fa-check-circle');
            // }
        
            // var iCountryId = $("#country_id").val();
            // if (iCountryId.length == 0) {
            //     $("#country_id").addClass('has-error');
            //     $("#iCountryId_error").show();
            //     $("#iCountryIdError").addClass('fas fa-exclamation-circle');                
            //      error = true;
            // } else {
            //     $("#iCountryId_error").hide();
            //     $("#country_id").removeClass('has-error');
            //     $("#iCountryIdError").removeClass('fas fa-exclamation-circle');                
            //     $("#iCountryIdError").addClass('fas fa-check-circle');
            // }
        
            // var iSubCountyId = $("#iSubCountyId").val();
            // if (iSubCountyId.length == 0) {
            //     $("#sub_county_id_error").show();
            //     $("#iSubCountyId").addClass('has-error');
            //     $("#iSubCountyIdError").addClass('fas fa-exclamation-circle');                
            //     error = true;
            // } else {
            //     $("#sub_county_id_error").hide();
            //     $("#iSubCountyId").removeClass('has-error');
            //     $("#iSubCountyIdError").removeClass('fas fa-exclamation-circle');                
            //     $("#iSubCountyIdError").addClass('fas fa-check-circle');
            // }
        
            // var tBusinessDetail = $("#tBusinessDetail").val();
            //  if (tBusinessDetail.length == 0) {
            //     $("#tBusinessDetail_error").show();
            //     $("#tBusinessDetail").addClass('has-error');
            //     $("#tBusinessDetailError").addClass('fas fa-exclamation-circle');
            //     error = true;
            // } else {
            //     if (max_word_allow_check('tBusinessDetail',50) <= 50) {
            //         $("#tBusinessDetail_min_length_error").show();
            //         $("#tBusinessDetail").addClass('has-error');
            //         $("#tBusinessDetailError").addClass('fas fa-exclamation-circle');
            //         error = true;
            //     }
            //     else {
            //         $("#tBusinessDetail_error").hide();
            //         $("#tBusinessDetail").removeClass('has-error');
            //         $("#tBusinessDetail_min_length_error").hide();
            //         $("#tBusinessDetailError").removeClass('fas fa-exclamation-circle');
            //         $("#tBusinessDetailError").addClass('fas fa-check-circle');
            //     }
            // }
        
        
        
            var vPhysicalAssetValue = $("#vPhysicalAssetValue").val();
            if (vPhysicalAssetValue.length == 0) {
                $("#vPhysicalAssetValue_error").show();
                $("#vPhysicalAssetValue").addClass('has-error');
                $("#vPhysicalAssetValueError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vPhysicalAssetValue_error").hide();
                $("#vPhysicalAssetValue").removeClass('has-error');
                $("#vPhysicalAssetValueError").removeClass('fas fa-exclamation-circle');
                $("#vPhysicalAssetValueError").addClass('fas fa-check-circle');
                
            }
        
            var tRevenueAndFinancials = $("#tRevenueAndFinancials").val();
             if (tRevenueAndFinancials.length == 0) {
                $("#tRevenueAndFinancials_error").show();
                $("#tRevenueAndFinancials").addClass('has-error');
                $("#tRevenueAndFinancialsError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#tRevenueAndFinancials_error").hide();
                $("#tRevenueAndFinancials").removeClass('has-error');
                $("#tRevenueAndFinancialsError").removeClass('fas fa-exclamation-circle');
                $("#tRevenueAndFinancialsError").addClass('fas fa-check-circle');
            }
            
            var tMarketAnalysis = $("#tMarketAnalysis").val();
             if (tMarketAnalysis.length == 0) {
                $("#tMarketAnalysis_error").show();
                $("#tMarketAnalysis").addClass('has-error');
                $("#tMarketAnalysisError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#tMarketAnalysis_error").hide();
                $("#tMarketAnalysis").removeClass('has-error');
                $("#tMarketAnalysisError").removeClass('fas fa-exclamation-circle');
                $("#tMarketAnalysisError").addClass('fas fa-check-circle');
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
       
        $(document).on('change blur', '#vPhysicalAssetValue', function()         
        {
            var vPhysicalAssetValue = $("#vPhysicalAssetValue").val();
           if (vPhysicalAssetValue.length == 0) {
                $("#vPhysicalAssetValue_error").show();
                $("#vPhysicalAssetValue").addClass('has-error');
                
                $("#vPhysicalAssetValueError").addClass('fas fa-exclamation-circle');
                error = true;
            } else {
                $("#vPhysicalAssetValue_error").hide();
                $("#vPhysicalAssetValue").removeClass('has-error');
                $("#vPhysicalAssetValueError").removeClass('fas fa-exclamation-circle');
                $("#vPhysicalAssetValueError").addClass('fas fa-check-circle');
                
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
        $(document).on('click', '.memeber-role', function() {
           $(".member-data").append($(".member-1").html());
        });

        function delete_role(obj) {
            $(obj).parent().remove();
        } 


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