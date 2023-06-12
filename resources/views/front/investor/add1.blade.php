@extends('layouts.app.front-app')
@section('title', 'Add investors ' . env('APP_NAME'))
@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css" integrity="sha512-TQQ3J4WkE/rwojNFo6OJdyu6G8Xe9z8rMrlF9y7xpFbQfW5g8aSWcygCQ4vqRiJqFsDsE1T6MoAOMJkFXlrI9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

    <style>
        .save-detail {
            cursor: pointer;
        }
        select {
            font-size : 14px !important;
            font-weight:normal !important;
        }
    </style>
@endsection
@php
    // dd($countries);
    // dd($selected_location);
    $session_data = session('user');

    $userData = '';
    if ($session_data !== '') {
        $userData = App\Helper\GeneralHelper::get_user_data_in_profile($session_data['iUserId']);
    }
@endphp
@section('content')
<style type="text/css">
    .fileupload-main-ul {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        flex-wrap: wrap;
        gap: 30px;
        list-style: none;
        margin-top: 30px;
        padding: 0px;
        }

    .add-investor-card{
        background: #FFFFFF; 
        border-bottom: 2px solid #2B7292; 
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        background-color:#fff;
    }

    .prefered-ul li label{
        font-size:12px !important;
    }

    .prefered-ul li input{
        margin-right:7px !important;
    }

    .add-investor-section label{
        font-size:14px !important;
    }

    .add-investor-section label{
        color: #313538; 
        font-weight:500;
        padding:8px 0;
    }

    .add-investor-card-heade p{
        margin-bottom:0 !important;
        color: #2B7292 !important;
    }   

    .term-accpet li label{
        font-size:14px !important;
        font-weight:normal;
    }

    .add-investor-section .form-select {
        overflow: hidden;
        overflow: -moz-hidden-unscrollable !important;
        background: url('/front/assets/images/arrow.svg' ) no-repeat right white;
        background-position:right 10px center;
    }

    .form-check label{
        padding:0 !important;
        font-weight:normal !important; 
        margin-bottom:0 !important;
        font-size:12px !important;
    }

    .validination-info .fa-check-circle{
        margin-top:18px !important;
    }

</style>
    <section class="add-edit-detail lite-gray investor-edit-detail add-investor-section">
        <div class="adit-detail-step border-0 pb-0">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="steps-in">
                            <ul class>
                                <li><a id="first-tab" data-id='first-step' class="active investorHeader" style="font-size:18px">Profile</a></li>
                                {{-- 
                                    <li><a id="second-tab" data-id='second-step' class="investorHeader">About Company</a> </li>
                                    <li><a id="third-tab" data-id='third-step' class="investorHeader">Investor Interest</a></li>
                                    <li><a id="fourth-tab" data-id='fourth-step' class="investorHeader">Location and Factors</a></li>
                                --}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="add-step-detail  pt-sm-3 pt-0">
            <div class="container">
                <div class="row">
                    @include('layouts.front.left_dashboard')
                    <div class="col-lg-9">
                        <form action="{{ url('investor-store') }}" name="frm" id="frm" method="post" enctype="multipart/form-data" class="bg-transparent p-0">
                            @csrf
                            <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if(isset($investor)){{$investor->vUniqueCode}}@endif">
                            <input type="hidden" id="iTempId" name="iTempId" value="@if (isset($iTempId)){{$iTempId}}@endif">
                            <input type="hidden" id="iInvestorProfileId" name="iInvestorProfileId" value="@if (isset($investor->iInvestorProfileId)){{$investor->iInvestorProfileId}}@endif">
                            <!-- frist-step -->
                            <div id="first-step" class="other-detail investor_forms first-steps">
                                <div class="add-investor-card bg-white p-4" >
                                    <h5 style="color: #2B7292;">{{ isset($investor) ? 'Edit' : 'Add' }} Investors</h5>

                                    <div class="p-0">
                                        <!-- <h3>Are you an investor looking for an investment opportunity?</h3> -->
                                        <p style="text-align: justify; font-size: 14px; color: #313538; opacity: 0.6;"> Are you looking to find a way to grow your wealth over time while minimizing risk? PitchInvestors offers a range of investment options that are carefully selected to meet the needs of investors like you. Whether you seek a long-term investment or a shorter-term opportunity, we have something to suit your needs. Explore our offerings today and take the first step towards achieving your financial goals.</p>

                                        <!-- <div class="image-avtar">
                                            <img src="{{ asset('uploads/front/investor/profile1.png') }}" alt="">
                                        </div> -->
                                    </div>

                                    <div class="add-investor-card-header">
                                        <p class="mb-0">
                                            <b style="color: #2B7292;" class="mb-0">Personal Information</b>
                                        </p>
                                    </div>   

                                    <div class="add-investor-card-body">                                
                                        <div class="detail-form mt-2">
                                            <div class="row">                                      
                                                <div class="col-md-12 positon-relative">
                                                    <div>
                                                        <label for="floatingFirstname" style="color: #313538; font-weight:500;" class="py-2">Full name</label>
                                                        <input type="text" class="form-control" id="vFullName" name="vFullName" placeholder="Full name" value="@if(isset($investor)){{$investor->vFullName}}@elseif(!empty($loginuserdata)) {{$loginuserdata->vFirstName.' '.$loginuserdata->vLastName}}@else{{$session_data['vFirstName'].' '.$session_data['vLastName']}}@endif">
                                                            <div class="validination-info">
                                                                <i class="" id="vFullNameError"></i>
                                                            </div>
                                                        <div id="vFullName_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter Full Name </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 positon-relative">
                                                    <div>
                                                        <label for="floatingEmail" style="color: #313538; font-weight:500;" class="py-2">Email</label>
                                                        <input type="text" class="form-control" id="vEmail" name="vEmail" placeholder="Email" value="@if(isset($investor)){{$investor->vEmail}}@else{{$session_data['vEmail']}}@endif">
                                                        <div class="validination-info">
                                                            <i class="" id="vEmailError"></i>
                                                        </div>
                                                        <div id="vEmail_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter Email </div>
                                                        <div id="vEmail_valid_error" class="error_show" style="color:red;display: none; font-size: small;">Please Enter Valid Email</div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 positon-relative">
                                                    <div>
                                                        <label for="floatingPhoneNo" style="color: #313538; font-weight:500;" class="py-2">Phone No.</label>
                                                        <input type="text" class="form-control numeric" minlength="10" maxlength="10" id="vPhone" name="vPhone" placeholder="Phone No." value="@if(isset($investor)){{$investor->vPhone}}@elseif(!empty($loginuserdata)) {{$loginuserdata->vPhone}}@else{{$session_data['vPhone']}}@endif">
                                                        <div class="validination-info">
                                                            <i class="" id="vPhoneError"></i>
                                                        </div>
                                                        <div id="vPhone_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter Phone No. </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                
                                <div class="add-investor-card p-4">
                                    <div class="add-investor-card-header">
                                        <p style="color: #2B7292;" class="mb-0">
                                            <b>Investment Preferences</b>
                                        </p>
                                    </div>  
                                                                  
                                    <div class="add-investor-card-body">
                                        <div class="detail-form mt-2">
                                            <div class="row">
                                                <div class="col-md-6 positon-relative">
                                                    <div>
                                                        <label for="floatingIdentification No" style="color: #313538; font-weight:500;" class="py-2">Investment Amount Range</label>
                                                        
                                                    <select class="form-select mb-1" aria-label="Default select example" id="vHowMuchInvest" name="vHowMuchInvest" style="border: 1px solid #D1D7DC;">
                                                    <option  value="">Select Amount Range</option>
                                                    <option <?php if(isset($investor) && $investor->vHowMuchInvest == '100K - 1M'){ echo 'selected';  } ?> value="100K - 1M">100K - 1M</option>
                                                    <option <?php if(isset($investor) && $investor->vHowMuchInvest == '1M - 5M'){ echo 'selected';  } ?> value="1M - 5M">1M - 5M</option>
                                                    <option  <?php if(isset($investor) && $investor->vHowMuchInvest == '5M - 10M'){ echo 'selected';  } ?> value="5M - 10M">5M - 10M</option>
                                                    <option  <?php if(isset($investor) && $investor->vHowMuchInvest == '10M+'){ echo 'selected';  } ?> value="5M - 10M">10M+</option>
                                                    </select>
                                                        <div class="validination-info">
                                                            <i class="" id="vHowMuchInvestError"></i>
                                                        </div>
                                                        <div id="vHowMuchInvest_error" class="error mt-1" style="color:red;display: none; font-size: small;">Select your preferred investment amount range. </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 positon-relative">
                                                    <label style="color: #313538; font-weight:500;" class="py-2">Investment Stage</label>
                                                    <select class="form-select mb-1" aria-label="Default select example" id="vInvestmentStage" name="vInvestmentStage" style="border: 1px solid #D1D7DC;">
                                                    <option  value="">Select Stage</option>
                                                    <option <?php if(isset($investor) && $investor->vInvestmentStage == 'Early-stage'){ echo 'selected';  } ?> value="Early-stage">Early-stage</option>
                                                    <option <?php if(isset($investor) && $investor->vInvestmentStage == 'Growth'){ echo 'selected';  } ?> value="Growth">Growth</option>
                                                    <option  <?php if(isset($investor) && $investor->vInvestmentStage == 'Established'){ echo 'selected';  } ?> value="Established">Established</option>
                                                    </select>
                                                    <div class="validination-info">
                                                        <i class="" id="vInvestmentStage"></i>
                                                    </div>
                                                    <div id="vInvestmentStage_error" class="error mt-1" style="color:red;display: none;">Select your preferred investment stage</div>
                                                </div>

                                                <div class="col-md-12 positon-relative">
                                                    <label style="color: #313538; font-weight:500;" class="py-2">Investment Timeline</label>
                                                    <select class="form-select mb-1 " aria-label="Default select example" id="vInvestmentTimeline" name="vInvestmentTimeline" style="border: 1px solid #D1D7DC;">
                                                    <option  value="">Select Timeline</option>
                                                    <option <?php if(isset($investor) && $investor->vInvestmentTimeline == 'Short-term'){ echo 'selected';  } ?> value="Short-term">Short-term</option>                                                    
                                                    <option <?php if(isset($investor) && $investor->vInvestmentTimeline == 'Medium-term'){ echo 'selected';  } ?> value="Medium-term">Medium-term</option>                                                    
                                                    <option <?php if(isset($investor) && $investor->vInvestmentTimeline == 'Long-term'){ echo 'selected';  } ?> value="Long-term">Long-term</option>
                                                    </select>
                                                    <div class="validination-info">
                                                        <i class="" id="vInvestmentTimeline"></i>
                                                    </div>
                                                    <div id="vInvestmentTimeline_error" class="error mt-1" style="color:red;display: none;">Select your preferred investment stage</div>
                                                </div>

                                                <div class="col-md-12 positon-relative">
                                                    <label style="color: #313538; font-weight:500;" class="py-2">Preferred Investment Sectors</label>
                                                    <ul class="prefered-ul">
                                                        <li style="min-width:30% !important" class="d-sm-inline-block d-block">
                                                            <label for="eAcquiringBusiness"><input type="checkbox" style = "margin-right: 2px;" class="intrestCheckbox" id="eAcquiringBusiness" name="eAcquiringBusiness" value="Yes" @if (isset($investor) and $investor->eAcquiringBusiness == 'Yes') {{ 'checked' }} @endif />
                                                                Acquiring / Buying a Business</label>
                                                        </li>
                                                        <li style="min-width:30% !important" class="d-sm-inline-block d-block">
                                                            <label for="eInvestingInBusiness"><input type="checkbox" style = "margin-right: 2px;" class="intrestCheckbox" id="eInvestingInBusiness" name="eInvestingInBusiness" value="Yes" @if (isset($investor) and $investor->eInvestingInBusiness == 'Yes') {{ 'checked' }} @endif />
                                                                Investing in a Business</label>
                                                        </li>
                                                        <li style="min-width:30% !important" class="d-sm-inline-block d-block">
                                                            <label for="eLendingToBusiness"><input type="checkbox" style = "margin-right: 2px;" class="intrestCheckbox" id="eLendingToBusiness" name="eLendingToBusiness" value="Yes" @if (isset($investor) and $investor->eLendingToBusiness == 'Yes') {{ 'checked' }} @endif />
                                                                Lending to a Business</label>
                                                        </li>
                                                        <li style="min-width:30% !important" class="d-sm-inline-block d-block">
                                                            <label for="eBuyingProperty"><input type="checkbox" style = "margin-right: 2px;" class="intrestCheckbox" id="eBuyingProperty" name="eBuyingProperty" value="Yes" @if (isset($investor) and $investor->eBuyingProperty == 'Yes') {{ 'checked' }} @endif />
                                                                Buying Property</label>
                                                        </li> 
                                                        <li style="min-width:30% !important" class="d-sm-inline-block d-block">
                                                            <label for="eCorporateInvestor"><input type="checkbox" style = "margin-right: 2px;" class="intrestCheckbox" id="eCorporateInvestor" name="eCorporateInvestor" value="Yes" @if (isset($investor) and $investor->eCorporateInvestor == 'Yes') {{ 'checked' }} @endif />Corporate Investors</label>
                                                        </li>
                                                        <li style="min-width:30% !important" class="d-sm-inline-block d-block">
                                                            <label for="eVentureCapitalFirms"><input type="checkbox" style = "margin-right: 2px;" class="intrestCheckbox" id="eVentureCapitalFirms" name="eVentureCapitalFirms" value="Yes" @if (isset($investor) and $investor->eVentureCapitalFirms == 'Yes') {{ 'checked' }} @endif />Venture Capital Firms</label>
                                                        </li>
                                                        <li style="min-width:30% !important" class="d-sm-inline-block d-block">
                                                            <label for="ePrivateEquityFirms"><input type="checkbox" style = "margin-right: 2px;" class="intrestCheckbox" id="ePrivateEquityFirms" name="ePrivateEquityFirms" value="Yes" @if (isset($investor) and $investor->ePrivateEquityFirms == 'Yes') {{ 'checked' }} @endif />Private Equity Firms</label>
                                                        </li>
                                                        <li style="min-width:30% !important" class="d-sm-inline-block d-block">
                                                            <label for="eFamilyOffices"><input type="checkbox" style = "margin-right: 2px;" class="intrestCheckbox" id="eFamilyOffices" name="eFamilyOffices" value="Yes" @if (isset($investor) and $investor->eFamilyOffices == 'Yes') {{ 'checked' }} @endif />Family Offices</label>
                                                        </li>
                                                    </ul>
                                                    <div id="intrestIn_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please select your preferred investment sectors </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="add-investor-card p-4">
                                    <div class="add-investor-card-header">
                                        <p style="color: #2B7292;" class="mb-0">
                                            <b>Investment Experience</b>
                                        </p>
                                    </div>  

                                    <div class="add-investor-card-body">
                                        <div class="detail-form mt-2">
                                            <div class="row">
                                                <div class="col-md-6 positon-relative">
                                                    <label>Previous Investment Experience</label>
                                                    <input type="text" class="form-control" id="tPreviousInvestMentExperience" name="tPreviousInvestMentExperience" placeholder="Describe your previous investment experience, if any" value="@if (isset($investor)) {{ $investor->tPreviousInvestMentExperience }} @endif">
                                                    
                                                </div>
                                                <div class="col-md-6 positon-relative">
                                                    <label>Types of Investments Made</label>
                                                    <input type="text" class="form-control" id="vTypeOfInvestmentMade" name="vTypeOfInvestmentMade" placeholder="Specify the types of investments you have made in the past" value="@if (isset($investor)) {{ $investor->vTypeOfInvestmentMade }} @endif">
                                                    <div class="validination-info">
                                                        <i class="" id="vTypeOfInvestmentMadeError"></i>
                                                    </div>
                                                    <div id="vTypeOfInvestmentMade_error" class="error mt-1" style="color:red;display: none; font-size: small;">
                                                    Specify the types of investments you have made in the past</div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 positon-relative">                                                    
                                                    <label for='tInvestmentTrackRecord'>Investment Track Record</label>
                                                    <textarea class="form-control no-space-control" placeholder="Provide information about your investment track record or portfolio" id="tInvestmentTrackRecord" name="tInvestmentTrackRecord" style="height: 120px">@if (isset($investor)){{ $investor->tInvestmentTrackRecord }}@endif</textarea>
                                                    <div class="validination-info">
                                                        <i class="" id="tInvestmentTrackRecordError"></i>
                                                    </div>
                                                    <div id="tInvestmentTrackRecord_error" class="error mt-1" style="color:red;display: none; font-size: small;">Provide information about your investment track record or portfolio </div>                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <br>
                                <div class="add-investor-card p-4">
                                    <div class="add-investor-card-header">
                                        <p style="color:#2B7292;" class="mb-0">
                                            <b>Risk Appetite</b>
                                        </p>
                                    </div>                                
                                    <div class="add-investor-card-body">
                                        <div class="detail-form mt-2">
                                            <div class="row">
                                            <div class="col-md-6 positon-relative">                                            
                                                <label for="tInvestorProfileDetail">Risk Tolerance Level</label>
                                                <select class="form-select" aria-label="Default select example" id="vRiskToleranceLevel" name="vRiskToleranceLevel" style="border: 1px solid #D1D7DC;">
                                            <option  value="">Select Risk Tolerance Level</option>
                                            <option <?php if(isset($investor) && $investor->vRiskToleranceLevel == 'Conservative'){ echo 'selected';  } ?> value="Conservative">Conservative</option>
                                            <option <?php if(isset($investor) && $investor->vRiskToleranceLevel == 'Moderate'){ echo 'selected';  } ?> value="Moderate">Moderate</option>
                                            <option  <?php if(isset($investor) && $investor->vRiskToleranceLevel == 'Aggressive'){ echo 'selected';  } ?> value="Aggressive">Aggressive</option>
                                            </select>
                                                 <div class="validination-info">
                                                    <i class="" id="vRiskToleranceLevelError"></i>
                                                </div>
                                                <div id="vRiskToleranceLevel_error" class="error mt-1" style="color:red;display: none; font-size: small;">Select your risk tolerance level </div>
                                            
                                        </div>
                                       
                                        <div class="col-md-6 positon-relative">                                                                                        
                                            <label for="tAboutCompany">Expected Investment Returns</label>
                                                <select class="form-select" aria-label="Default select example" id="vExpectedInvestmentReturns" name="vExpectedInvestmentReturns" style="border: 1px solid #D1D7DC;">
                                                    <option  value="">Select Investment Returns</option>
                                                    <option <?php if(isset($investor) && $investor->vExpectedInvestmentReturns == '100K-10M'){ echo 'selected';  } ?> value="100K-10M">100K-10M</option>
                                                    <option <?php if(isset($investor) && $investor->vExpectedInvestmentReturns == '10M-100M'){ echo 'selected';  } ?> value="10M-100M">10M-100M</option>
                                                    <option  <?php if(isset($investor) && $investor->vExpectedInvestmentReturns == '100M+'){ echo 'selected';  } ?> value="100M+">100M+</option>
                                                    </select>
                                                <div class="validination-info">
                                                     <i class="" id="vExpectedInvestmentReturnsError"></i>
                                                 </div>
                                                <div id="vExpectedInvestmentReturns_error" class="error mt-1" style="color:red;display: none; font-size: small;">Specify your expected investment returns</div>                                            
                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="add-investor-card p-4">
                                    <div class="add-investor-card-header">
                                        <p style="color:#2B7292;" class="mb-0">
                                            <b>Financial Capacity</b>
                                        </p>
                                    </div>     

                                    <div class="add-investor-card-body">
                                        <div class="detail-form mt-2">
                                            <div class="row">
                                                <div class="col-md-12 positon-relative">
                                                    <div>
                                                        <label for='vEstimatedNetWorth'>Estimated Net Worth(Should be in percentage)</label>
                                                        <input type="text" id="vEstimatedNetWorth" name="vEstimatedNetWorth" class="form-control percent" placeholder="Provide an estimation of your net worth" value="@if (isset($investor)) {{ $investor->vEstimatedNetWorth }} @endif">
                                                    </div>
                                                    <div class="validination-info">
                                                        <i class="" id="vEstimatedNetWorthError"></i>
                                                    </div>
                                                    <div id="vEstimatedNetWorth_percent_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter percentage Value</div>
                                                    <div id="vEstimatedNetWorth_error" class="error mt-1" style="color:red;display: none; font-size: small;">Provide an estimation of your net worth</div>
                                                </div>
                                                <div class="col-md-12 positon-relative">                                                
                                                    <label for="vAvailabilityOfInvestableFunds">Availability of Investable Funds</label>
                                                    <textarea class="form-control no-space-control" placeholder="Specify the availability of funds for investment" id="tAvailabilityOfInvestableFunds" name="tAvailabilityOfInvestableFunds" style="height: 120px">@if (isset($investor)){{ $investor->tAvailabilityOfInvestableFunds }}@endif</textarea>
                                                    <div class="validination-info">
                                                        <i class="" id="tAvailabilityOfInvestableFundsError"></i>
                                                    </div>
                                                    <div id="tAvailabilityOfInvestableFunds_error" class="error mt-1" style="color:red;display: none; font-size: small;">Specify the availability of funds for investment</div>                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="add-investor-card p-4">
                                    <div class="add-investor-card-header">
                                        <p style="color:#2B7292;" class="mb-0">
                                            <b>Expertise and Industry Knowledge</b>
                                        </p>
                                    </div>                                
                                    <div class="add-investor-card-body">
                                        <div class="detail-form mt-2">
                                            <div class="row">
                                            <div class="col-md-12 positon-relative">                                            
                                                <div>
                                                <label for="tBackgroundExpertise">Professional Background or Expertise</label>
                                                    <textarea class="form-control no-space-control" placeholder="Describe your professional background or expertise" id="tBackgroundExpertise" name="tBackgroundExpertise" style="height: 120px">@if (isset($investor)){{ $investor->tBackgroundExpertise }}@endif</textarea>
                                                    <div class="validination-info">
                                                        <i class="" id="tBackgroundExpertiseError"></i>
                                                    </div>
                                                    <div id="tBackgroundExpertise_error" class="error mt-1" style="color:red;display: none; font-size: small;">Describe your professional background or expertise</div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 positon-relative">                                            
                                                <div>
                                                <label for="vAvailabilityOfInvestableFunds">Industry Knowledge</label>
                                                    <textarea class="form-control no-space-control" placeholder="Specify industries you have knowledge or experience in" id="tIndustryKnowledge" name="tIndustryKnowledge" style="height: 120px">@if (isset($investor)){{ $investor->tIndustryKnowledge }}@endif</textarea>
                                                    <div class="validination-info">
                                                        <i class="" id="tIndustryKnowledgeError"></i>
                                                    </div>
                                                    <div id="tIndustryKnowledge_error" class="error mt-1" style="color:red;display: none; font-size: small;">Specify industries you have knowledge or experience in</div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="add-investor-card p-4">
                                    <div class="add-investor-card-header">
                                        <p style="color:#2B7292;" class="mb-0">
                                            <b>Geographic Preferences</b>
                                        </p>
                                    </div>     

                                    <div class="add-investor-card-body">
                                        <div class="detail-form mt-2">
                                            <div class="row">
                                            <div class="col-md-12 positon-relative">
                                                <label>Preferred Investment Location</label>
                                                <select class="form-select" aria-label="Default select example" id="vInvestmentLocation" name="vInvestmentLocation" style="border: 1px solid #D1D7DC;">
                                                <option  value="">Select Investment Location</option>
                                                <option <?php if(isset($investor) && $investor->vInvestmentLocation == 'Local'){ echo 'selected';  } ?> value="Local">Local</option>
                                                <option <?php if(isset($investor) && $investor->vInvestmentLocation == 'National'){ echo 'selected';  } ?> value="National">National</option>
                                                <option  <?php if(isset($investor) && $investor->vInvestmentLocation == 'International'){ echo 'selected';  } ?> value="International">International</option>
                                                </select>
                                                <div class="validination-info">
                                                    <i class="" id="vInvestmentLocationError"></i>
                                                </div>
                                                <div id="vInvestmentLocation_error" class="error mt-1" style="color:red;display: none;">Select your preferred investment stage</div>
                                            </div>                                            
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="add-investor-card p-4">
                                    <div class="add-investor-card-header">
                                        <p style="color:#2B7292;" class="mb-0">
                                            <b>Additional Comments or Criteria</b>
                                        </p>
                                    </div>                                
                                    <div class="add-investor-card-body">
                                        <div class="detail-form mt-2">
                                            <div class="row">
                                                <div class="col-md-12 mt-3 positon-relative">                                                                                            
                                                    <label for="tAdditionalComments">Additional Comments or Criteria</label>
                                                    <textarea class="form-control no-space-control mb-0" placeholder="Additional Comments or Criteria" id="tAdditionalComments" name="tAdditionalComments" style="height: 120px">@if (isset($investor)){{ $investor->tAdditionalComments }}@endif</textarea>                                                
                                                </div>
                                            </div>
                                        </div>

                                        <div id="fourth-step" class="other-detail investor_forms fourth-steps">
                                            <div class="detail-form mt-2">
                                        
                                                <div class="term-accpet" style="margin-bottom:20px">
                                                    <ul>
                                                        <li>
                                                            <label class="d-flex">
                                                                <span style="margin-right:5px"><input onclick='$("#termsrule_error").hide();' class = "terms_conditions" type="checkbox" value="1" @if(isset($investor)){{'checked'}}@endif /></span>
                                                                <span class="d-block ps-1">I confirm that the information provided in my investor profile is accurate and up-to-date.</span>
                                                            </label>
                                                        </li>                                                
                                                        <li>
                                                            <label class="d-flex">
                                                                <span style="margin-right:5px"><input onclick='$("#termsrule_error").hide();' class = "terms_conditions" type="checkbox"  value="1" @if(isset($investor)){{'checked'}}@endif /></span>
                                                                <span class="d-block ps-1">I acknowledge that the due diligence performed by PitchInvestors is not a substitute for my own assessment of the investment opportunities.</span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="d-flex">
                                                                <span style="margin-right:5px"><input onclick='$("#termsrule_error").hide();' class = "terms_conditions" type="checkbox" value="1" @if(isset($investor)){{'checked'}}@endif /></span>
                                                                <span class="d-block ps-1">I agree to use the information and reports provided by PitchInvestors solely for the purpose of evaluating investment opportunities on the platform.</span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="d-flex">
                                                                <span style="margin-right:5px"><input onclick='$("#termsrule_error").hide();' class = "terms_conditions" type="checkbox" value="1" @if(isset($investor)){{'checked'}}@endif /></span>
                                                                <span class="d-block ps-1">I understand that my investments on PitchInvestors are subject to the terms and conditions set forth by the individual businesses I choose to invest in.</span>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="d-flex">
                                                                <span style="margin-right:5px"><input onclick='$("#termsrule_error").hide();' class = "terms_conditions" type="checkbox" value="1" @if(isset($investor)){{'checked'}}@endif /></span>
                                                                <span class="d-block ps-1">I agree to comply with all applicable laws and regulations related to investments and financial transactions.</span>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                    <div id="termsrule_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please accept terms of engagement</div>
                                                </div>

                                                <div class="row margin-left-button" id="submit">
                                                    <label class="save-detail mt-0 m-auto" style="width:163px;"><a href="javascript:;">Save</a></label>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div> 
                        </form>

                        <div class="secondary-chat col-12 d-lg-none d-block" >
                                    <div>
                                        @if ($session_data !== '')
                                            @include('layouts.front.chat_inbox_connection_listing')
                                        @endif
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('custom-js')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        var datePicker = $('#dDob').datepicker({
            format: "dd-mm-yyyy",
            endDate: '+0d',
            autoclose: true //to close picker once year is selected
        });
        var upload_url = '{{ url('investor-upload') }}';
        $('#iNationality').select2({
            closeOnSelect: false,
            placeholder: "Select Nationality",
            allowClear: true,
            tags: true
        });
        /*$('#iCity').select2({
            closeOnSelect: false,
            placeholder: "Select City",
            allowClear: true,
            tags: true
        });*/
        $('#industries').select2({
            closeOnSelect: false,
            placeholder: "Select Industry",
            allowClear: true,
            tags: true,
            maximumSelectionLength: 5
        });
        $('#locations').select2({
            closeOnSelect: true,
            placeholder: "Select Locations",
            allowClear: true,
            tags: true
        });
        datePicker.datepicker({
            format: 'dd-MM-yyyy',
            autoclose: true
        });

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        var error = false;
       
        $(document).on('click', '#submit', function() 
        {
         error = false;   
            var vUniqueCode = $("#vUniqueCode").val();
            var vFullName = $("#vFullName").val();
            var vEmail = $("#vEmail").val();                
            var vPhone = $("#vPhone").val();                
            var intrestCheckbox = $(".intrestCheckbox:checkbox:checked").length;
            var vHowMuchInvest = $("#vHowMuchInvest").val(); 
            var vTypeOfInvestmentMade = $("#vTypeOfInvestmentMade").val(); 
            var vRiskToleranceLevel = $("#vRiskToleranceLevel").val(); 
            var vExpectedInvestmentReturns = $("#vExpectedInvestmentReturns").val(); 
            var vEstimatedNetWorth = $("#vEstimatedNetWorth").val(); 
            
            var tFactorsInBusiness = $("#tFactorsInBusiness").val();

           
            if(vFullName.length == 0) {
            $("#vFullName_error").show();
            $( "#vFullName" ).addClass('has-error');
            $("#vFullNameError").addClass('fas fa-exclamation-circle');
            error = true;            
            } else {
                $("#vFirstName_error").hide();
                $("#vFirstName").removeClass('has-error');
                $("#vFullNameError").removeClass('fas fa-exclamation-circle');
                $("#vFullNameError").addClass('fas fa-check-circle');
            }

            if(vTypeOfInvestmentMade.length == 0) {
            $("#vTypeOfInvestmentMade_error").show();
            $( "#vTypeOfInvestmentMade" ).addClass('has-error');
            $("#vTypeOfInvestmentMadeError").addClass('fas fa-exclamation-circle');
            error = true;            
            } else {
                $("#vTypeOfInvestmentMade_error").hide();
                $("#vTypeOfInvestmentMade").removeClass('has-error');
                $("#vTypeOfInvestmentMadeError").removeClass('fas fa-exclamation-circle');
                $("#vTypeOfInvestmentMadeError").addClass('fas fa-check-circle');
            }
          
            if (vEmail.length == 0) 
            {
                $("#vEmail_error").show();
                $("#vEmail_valid_error").hide();
                $( "#vEmail" ).addClass('has-error');
                $("#vEmailError").addClass('fas fa-exclamation-circle');                
                error = true;                
            } else 
            {
                if (validateEmail(vEmail)) {
                    $("#vEmail_valid_error").hide();
                    $("#vEmail_error").hide();
                    $( "#vEmail" ).removeClass('has-error');
                    $("#vEmailError").removeClass('fas fa-exclamation-circle');
                    $("#vEmailError").addClass('fas fa-check-circle');                    
                } else {
                    $("#vEmail_valid_error").show();
                    $("#vEmail_error").hide();
                    $("#vEmail").addClass('has-error');
                    $("#vEmailError").removeClass('fas fa-check-circle');
                    $("#vEmailError").addClass('fas fa-exclamation-circle');
                    error = true;                    
                }
            }
            if (vPhone.length == 0) 
            {
                $("#vPhone_error").show();
                $( "#vPhone" ).addClass('has-error');
                $("#vPhoneError").addClass('fas fa-exclamation-circle');
                error = true;                
            } else 
            {
                $("#vPhone_error").hide();
                $("#vPhone").removeClass('has-error');
                $("#vPhoneError").removeClass('fas fa-exclamation-circle');
                $("#vPhoneError").addClass('fas fa-check-circle');
            }
           
            if (intrestCheckbox <= 0) 
            {
                $("#intrestIn_error").show();
                $("#intrestIn_error").addClass('has-error');
                error = true;                
            } else 
            {
                $("#intrestIn_error").hide();
                $("#intrestIn_error").removeClass('has-error');
            }
            if (vHowMuchInvest <= 0) 
            {
                $("#vHowMuchInvest_error").show();
                $("#vHowMuchInvest_error").addClass('has-error');
                error = true;                
            } else 
            {
                $("#vHowMuchInvest_error").hide();
                $("#vHowMuchInvest_error").removeClass('has-error');
            }

            if (vRiskToleranceLevel.length <= 0) 
            {
                $("#vRiskToleranceLevel_error").show();
                $("#vRiskToleranceLevel_error").addClass('has-error');
                error = true;                
            } else 
            {
                $("#vRiskToleranceLevel_error").hide();
                $("#vRiskToleranceLevel_error").removeClass('has-error');
            }

            if(vExpectedInvestmentReturns.length == 0) {
            $("#vExpectedInvestmentReturns_error").show();
            $( "#vExpectedInvestmentReturns" ).addClass('has-error');
            $("#vExpectedInvestmentReturnsError").addClass('fas fa-exclamation-circle');
            error = true;            
            } else {
                $("#vFirstName_error").hide();
                $("#vFirstName").removeClass('has-error');
                $("#vExpectedInvestmentReturnsError").removeClass('fas fa-exclamation-circle');
                $("#vExpectedInvestmentReturnsError").addClass('fas fa-check-circle');
            }

            if(vEstimatedNetWorth.length == 0) {
                $("#vEstimatedNetWorth_percent_error").hide();
                $("#vEstimatedNetWorth_error").show();
                $( "#vEstimatedNetWorth" ).addClass('has-error');
                $("#vEstimatedNetWorthError").addClass('fas fa-exclamation-circle');
                error = true;            
            } else {
                $("#vEstimatedNetWorth_error").hide();
                $("#vEstimatedNetWorth").removeClass('has-error');
                $("#vEstimatedNetWorthError").removeClass('fas fa-exclamation-circle');
                $("#vEstimatedNetWorthError").addClass('fas fa-check-circle');
            }
                   
            var rule_check = 1;
            $(".terms_conditions").each(function(){
                if (!$(this).is(":checked")) {
                    rule_check = 0;
                    }
                });
                if (rule_check == 0) {
                    $("#termsrule_error").show();
                    $("#termsrule_error").addClass('has-error');
                    $("#termsrule_error").addClass('has-error');    
                } else {
                        $("#termsrule_error").hide();
                      $("#termsrule_error").removeClass('has-error');
                }     
            setTimeout(function() {
                if (error == true) {
                    $('.has-error').first().focus();
                    return false;
                } else {
                      $("#frm").submit();
                      $('#submit').hide();
                      $('.loading').show();
                    return true;
                }
            }, 1000);
        });

       
            $(document).on('change blur', '#vFullName', function() {
                var vFullName = $("#vFullName").val();
                if (vFullName.length == 0) {
                $("#vFullName_error").show();
                $( "#vFullName" ).addClass('has-error');
                $("#vFullNameError").addClass('fas fa-exclamation-circle');
                error = true;
                } else {
                    $("#vFullName_error").hide();
                    $("#vFullName").removeClass('has-error');
                    $("#vFullNameError").removeClass('fas fa-exclamation-circle');
                    $("#vFullNameError").addClass('fas fa-check-circle');
                }
            });
           
            $(document).on('change blur', '#vEmail', function() {
                 var vEmail = $("#vEmail").val();                
                if (vEmail.length == 0) 
                {
                    $("#vEmail_error").show();
                    $("#vEmail_valid_error").hide();
                    $( "#vEmail" ).addClass('has-error');
                    $("#vEmailError").addClass('fas fa-exclamation-circle');
                    error = true;                
                } else {
                    if (validateEmail(vEmail)) {
                        $("#vEmail_valid_error").hide();
                        $("#vEmail_error").hide();
                        $( "#vEmail" ).removeClass('has-error');
                        $("#vEmailError").removeClass('fas fa-exclamation-circle');
                        $("#vEmailError").addClass('fas fa-check-circle');
                    } else {
                        $("#vEmail_valid_error").show();
                        $("#vEmail_error").hide();
                        $("#vEmail").addClass('has-error');
                        $("#vEmailError").removeClass('fas fa-check-circle');
                        $("#vEmailError").addClass('fas fa-exclamation-circle');
                         error = true;                    
                    }
                }
            });
            $(document).on('change blur', '#vPhone', function() {
                var vPhone = $("#vPhone").val();                
                 if (vPhone.length == 0) {
                    $("#vPhone_error").show();
                    $( "#vPhone" ).addClass('has-error');
                    $("#vPhoneError").addClass('fas fa-exclamation-circle');
                     error = true;                
                } else {
                    $("#vPhone_error").hide();
                    $("#vPhone").removeClass('has-error');
                    $("#vPhoneError").removeClass('fas fa-exclamation-circle');
                    $("#vPhoneError").addClass('fas fa-check-circle');
                }
            });
            
            $(document).on('change blur', '#vEstimatedNetWorth', function() {
                var vEstimatedNetWorth = $("#vEstimatedNetWorth").val();                
                 if (vEstimatedNetWorth.length == 0) {
                    $("#vEstimatedNetWorth_error").show();
                    $( "#vEstimatedNetWorth" ).addClass('has-error');
                    $("#vEstimatedNetWorthError").addClass('fas fa-exclamation-circle');
                     error = true;                
                } else {
                    $("#vEstimatedNetWorth_error").hide();
                    $("#vEstimatedNetWorth").removeClass('has-error');
                    $("#vEstimatedNetWorthError").removeClass('fas fa-exclamation-circle');
                    $("#vEstimatedNetWorthError").addClass('fas fa-check-circle');
                }
            });
            $(document).on('change blur', '#vRiskToleranceLevel', function() {
                var vRiskToleranceLevel = $("#vRiskToleranceLevel").val();                
                 if (vRiskToleranceLevel.length == 0) {
                    $("#vRiskToleranceLevel_error").show();
                    $( "#vRiskToleranceLevel" ).addClass('has-error');
                    $("#vRiskToleranceLevelError").addClass('fas fa-exclamation-circle');
                     error = true;                
                } else {
                    $("#vRiskToleranceLevel_error").hide();
                    $("#vRiskToleranceLevel").removeClass('has-error');
                    $("#vRiskToleranceLevelError").removeClass('fas fa-exclamation-circle');
                    $("#vRiskToleranceLevelError").addClass('fas fa-check-circle');
                }
            });

            $(document).on('change blur', '#vExpectedInvestmentReturns', function() {
                var vExpectedInvestmentReturns = $("#vExpectedInvestmentReturns").val();                
                 if (vExpectedInvestmentReturns.length == 0) {
                    $("#vExpectedInvestmentReturns_error").show();
                    $( "#vExpectedInvestmentReturns" ).addClass('has-error');
                    $("#vExpectedInvestmentReturnsError").addClass('fas fa-exclamation-circle');
                     error = true;                
                } else {
                    $("#vExpectedInvestmentReturns_error").hide();
                    $("#vExpectedInvestmentReturns").removeClass('has-error');
                    $("#vExpectedInvestmentReturnsError").removeClass('fas fa-exclamation-circle');
                    $("#vExpectedInvestmentReturnsError").addClass('fas fa-check-circle');
                }
            });
            
            $(document).on('change blur', '.intrestCheckbox', function() {
                 var intrestCheckbox = $(".intrestCheckbox:checkbox:checked").length;
                if (intrestCheckbox <= 0) {
                    $("#intrestIn_error").show();
                    $("#intrestIn_error").addClass('has-error');
                    error = true;            
                } else {
                    $("#intrestIn_error").hide();
                    $("#intrestIn_error").removeClass('has-error');
                }
            });

            $(document).on('change blur', '.HowMuchInvest', function() {
                var vHowMuchInvest = $('input:radio[name="vHowMuchInvest"]:checked').length;
                if (vHowMuchInvest <= 0) {
                    $("#vHowMuchInvest_error").show();
                    $("#vHowMuchInvest_error").addClass('has-error');
                    error = true;                
                } else {
                    $("#vHowMuchInvest_error").hide();
                    $("#vHowMuchInvest_error").removeClass('has-error');
                }
            });
           
            

        $('.numeric').keyup(function(e) {
            if (/\D/g.test(this.value)) {
                this.value = this.value.replace(/\D/g, '');
            }
        });
        $('.percent').keyup(function(e) {
            if (/[^0-9.]/g.test(this.value)) {
                this.value = this.value.replace(/[^0-9.]/g, '');
            }
        });

        
        function validateEmail(sEmail) {
            var filter =
                /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (filter.test(sEmail)) {
                return true;
            } else {
                return false;
            }
        }
        function error_focus()
        {
            $(".has-error").first().focus();
        }

    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@endsection

