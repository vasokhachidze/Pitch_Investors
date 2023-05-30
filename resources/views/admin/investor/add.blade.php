@extends('layouts.app.admin-app')
@section('title', 'Investor - ' . env('APP_NAME'))

@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css"
        integrity="sha512-TQQ3J4WkE/rwojNFo6OJdyu6G8Xe9z8rMrlF9y7xpFbQfW5g8aSWcygCQ4vqRiJqFsDsE1T6MoAOMJkFXlrI9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <style>
        /*
        .dropzone {
          background: white;
          border-radius: 5px;
          border: 2px dashed rgb(0, 135, 247);
          border-image: none;
          max-width: 500px;
          margin-left: auto;
        }
      */
    </style>
@endsection
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($investor) ? 'Edit' : 'Add' }} Investor</h1>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card ">
                            <!-- @if (isset($investor))
                <div class="card-header custome-nav-tabs">
             
                </div>
                     
                @endif -->
                            <form action="{{ url('admin/investor/store') }}" name="frm" id="frm" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="card-body">
                                    <input type="hidden" id="vUniqueCode" name="vUniqueCode"
                                        value="@if (isset($investor)) {{ $investor->vUniqueCode }} @endif">
                                    <div class="row">
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Profession</label>
                                            <input type="text" name="vProfileTitle" id="vProfileTitle"
                                                class="form-control" placeholder="Enter Profession"
                                                value="@if (isset($investor)) {{ $investor->vProfileTitle }} @endif">
                                            <div id="vProfileTitle_error" class="error mt-1"
                                                style="color:red;display: none;">Please Enter Profession </div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>First Name</label>
                                            <input type="text" name="vFirstName" id="vFirstName" class="form-control"
                                                placeholder="Enter First Name"
                                                value="@if (isset($investor)) {{ $investor->vFirstName }} @endif">
                                            <div id="vFirstName_error" class="error mt-1" style="color:red;display: none;">
                                                Please Enter First Name </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Last Name</label>
                                            <input type="text" name="vLastName" id="vLastName" class="form-control"
                                                placeholder="Enter Last Name"
                                                value="@if (isset($investor)) {{ $investor->vLastName }} @endif">
                                            <div id="vLastName_error" class="error mt-1" style="color:red;display: none;">
                                                Please Enter Last Name </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>DOB</label>
                                            <input type="text" name="dDob" id="dDob"
                                                class="form-control datepicker" placeholder="Enter Date of Birth"
                                                value="@if (isset($investor)) {{ date('d-F-Y', strtotime($investor->dDob)) }} @endif">
                                            <div id="dDob_error" class="error mt-1" style="color:red;display: none;">Please
                                                Enter Date of Birth </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Email</label>
                                            <input type="text" name="vEmail" id="vEmail"
                                                class="form-control datepicker" placeholder="Enter Email"
                                                value="@if (isset($investor)){{$investor->vEmail}}@endif">
                                            <div id="vEmail_error" class="error mt-1" style="color:red;display: none;">
                                                Please Enter Email </div>
                                            <div id="vEmail_valid_error" class="error_show"
                                                style="color:red;display: none;">Please Enter Valid Email</div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Phone</label>
                                            <input type="text" name="vPhone" id="vPhone" class="form-control numeric"
                                                maxlength="10" placeholder="Enter Identification No"
                                                value="@if (isset($investor)) {{ $investor->vPhone }} @endif">
                                            <div id="vPhone_error" class="error mt-1" style="color:red;display: none;">
                                                Please Enter Phone No </div>
                                        </div>
                                        
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Identification No</label>
                                            <input type="text" name="vIdentificationNo" id="vIdentificationNo"
                                                class="form-control datepicker" placeholder="Enter Identification No."
                                                value="@if (isset($investor)) {{ $investor->vIdentificationNo }} @endif">
                                            <div id="vIdentificationNo_error" class="error mt-1"
                                                style="color:red;display: none;">Please Enter Identification No </div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Investor Profile Name</label>
                                            <input type="text" name="vInvestorProfileName" id="vInvestorProfileName"
                                                class="form-control " placeholder="Enter Investor Profile Name"
                                                value="@if (isset($investor)) {{ $investor->vInvestorProfileName }} @endif">
                                            <div id="vInvestorProfileName_error" class="error mt-1"
                                                style="color:red;display: none;">Please Enter Investor Profile Name </div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Investor Profile Detail</label>
                                            <input type="text" name="tInvestorProfileDetail"
                                                id="tInvestorProfileDetail" class="form-control "
                                                placeholder="Enter Investor Profile Detail"
                                                value="@if (isset($investor)) {{ $investor->tInvestorProfileDetail }} @endif">
                                            <div id="tInvestorProfileDetail_error" class="error mt-1"
                                                style="color:red;display: none;">Please Enter Investor Profile Detail
                                            </div>
                                        </div> 
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Company website, or LinkedIn profile</label>
                                            <input type="text" name="vCompanyWebsite"
                                                id="vCompanyWebsite" class="form-control "
                                                placeholder="Enter Investor Profile Detail"
                                                value="@if (isset($investor)) {{ $investor->vCompanyWebsite }} @endif">
                                            <div id="vCompanyWebsite_error" class="error mt-1"
                                                style="color:red;display: none;">Please Enter Investor Profile Detail
                                            </div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Select Nationality</label>
                                            <select name="iNationality" id="iNationality" class="form-control">
                                                <option value="">Select Nationality</option>
                                                @foreach ($countries as $value)
                                                    <option value="{{ $value->iCountryId }}"
                                                        @if (isset($investor)) @if ($investor->iNationality == $value->iCountryId) selected @endif
                                                        @endif>{{ $value->vNationality }}</option>
                                                @endforeach
                                            </select>
                                            <div id="iNationality_error" class="error mt-1"
                                                style="color:red;display: none;">Please Select Nationality</div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Select City</label>
                                            <input type="text" name="iCity"
                                                id="iCity" class="form-control"
                                                placeholder="Enter Investor Profile Detail"
                                                value="@if (isset($investor)) {{ $investor->iCity }} @endif">
                                           <!--  <select name="iCity" id="iCity" class="form-control"
                                                class="select2Option">
                                                <option value="">Select City</option>
                                                @foreach ($subRegion as $value)
                                                    <option value="{{ $value->iSubCountId }}"
                                                        @if (isset($investor)) @if ($investor->iCity == $value->iSubCountId) selected @endif
                                                        @endif>{{ $value->vTitle }}</option>
                                                @endforeach
                                            </select> -->
                                            <div id="iCity_error" class="error mt-1" style="color:red;display: none;">
                                                Please Select City</div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Investing Experience</label>
                                            <select name="eInvestingExp" id="eInvestingExp" class="form-control">
                                                <option value="">Select Option</option>
                                                <option value="Yes"
                                                    @if (isset($investor)) @if ($investor->eInvestingExp == 'Yes') selected @endif
                                                    @endif>Yes</option>
                                                <option value="No"
                                                    @if (isset($investor)) @if ($investor->eInvestingExp == 'No') selected @endif
                                                    @endif>No</option>
                                            </select>
                                            <div id="eInvestingExp_error" class="error mt-1"
                                                style="color:red;display: none;">Please Select</div>
                                        </div> 
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Will you need a business advisor to guide you?</label>
                                            <select name="eAdvisorGuide" id="eAdvisorGuide" class="form-control">
                                                <option value="">Select Option</option>
                                                <option value="Yes"
                                                    @if (isset($investor)) @if ($investor->eAdvisorGuide == 'Yes') selected @endif
                                                    @endif>Yes</option>
                                                <option value="No"
                                                    @if (isset($investor)) @if ($investor->eAdvisorGuide == 'No') selected @endif
                                                    @endif>No</option>
                                            </select>
                                            <div id="eAdvisorGuide_error" class="error mt-1"
                                                style="color:red;display: none;">Please Select</div>
                                        </div>
                                         <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Are You</label>
                                            <select name="eInvestorType" id="eInvestorType" class="form-control">
                                                <option value="">Select Option</option>
                                                <option value="Institutional" @if (isset($investor)) @if ($investor->eInvestorType == 'Individual') selected @endif
                                                    @endif>Individual Investors</option>
                                                <option value="Institutional" @if (isset($investor)) @if ($investor->eInvestorType == 'Institutional') selected @endif
                                                    @endif>Institutional Investors</option>
                                            </select>
                                            <div id="eInvestorType_error" class="error mt-1"
                                                style="color:red;display: none;">Please Select</div>
                                        </div>

                                        {{--<div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Location</label>
                                            <select name="locations[]" id="locations" class="form-control"
                                                multiple="multiple">
                                                @foreach ($location as $key => $value)
                                                    @php
                                                        $region_select = '';
                                                        $county_select = '';
                                                        $subcounty_select = '';
                                                    @endphp

                                                    @if (isset($selected_location))
                                                        @foreach ($selected_location as $key => $lvalue)
                                                            @if ($lvalue->iLocationId == $value['regionId'] && $lvalue->eLocationType == 'Region')
                                                                @php
                                                                    $region_select = 'selected';
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                    <option class="region_option"
                                                        value="Region_{{ $value['regionId'] }}-{{ $value['regionName'] }}"
                                                        {{ $region_select }}>{{ $value['regionName'] }}</option>
                                                    @foreach ($value as $key1 => $value1)
                                                        @if (in_array($key1, ['regionId', 'regionName']))
                                                            @continue
                                                        @endif

                                                        @if (isset($selected_location))
                                                            @foreach ($selected_location as $key => $lvalue)
                                                                @if ($lvalue->iLocationId == $value1['countyId'] && $lvalue->eLocationType == 'County')
                                                                    @php
                                                                        $county_select = 'selected';
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        <option class="county_option"
                                                            value="County_{{ $value1['countyId'] }}-{{ $value1['countyName'] }}"
                                                            {{ $county_select }}>-{{ $value1['countyName'] }}</option>
                                                        @foreach ($value1 as $key2 => $value2)
                                                            @if (in_array($key2, ['countyId', 'countyName']))
                                                                @continue
                                                            @endif


                                                            @if (isset($selected_location))
                                                                @foreach ($selected_location as $key => $lvalue)
                                                                    @if ($lvalue->iLocationId == $value2['subCountyName'] && $lvalue->eLocationType == 'Sub County')
                                                                        @php
                                                                            $subcounty_select = 'selected';
                                                                        @endphp
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            <option class="subCounty_option"
                                                                value="Sub County_{{ $value2['iSubCountId'] }}-{{ $value2['subCountyName'] }}"
                                                                {{ $subcounty_select }}>--{{ $value2['subCountyName'] }}
                                                            </option>
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            <div id="locations_error" class="error mt-1"
                                                style="color:red;display: none;">Please Select Location</div>
                                        </div>
                                        --}}
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Investment industries</label>
                                            <select name="industries[]" id="industries" class="form-control"
                                                multiple="multiple">
                                                @php
                                                    // dd($selected_industries);
                                                    $industry_select = '';
                                                @endphp
                                                <option value="">Select industries</option>

                                                @foreach ($industries as $value)
                                                    @php
                                                        $industry_select = '';
                                                    @endphp
                                                    @if (isset($selected_industries))
                                                        @foreach ($selected_industries as $industry)
                                                            @if ($industry->iIndustryId == $value->iIndustryId)
                                                                @php
                                                                    $industry_select = 'selected';
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    <option value="{{ $value->vName }}_{{ $value->iIndustryId }}"
                                                        {{ $industry_select }}>{{ $value->vName }}</option>
                                                @endforeach
                                            </select>
                                            <div id="industries_error" class="error mt-1"
                                                style="color:red; display: none;">Please Select Industries</div>
                                        </div>


                                        <div class="form-group col-xl-6 col-lg-12 col-md-6 checkbox">
                                            <label>When do you want to invest?</label></br>
                                            <input type="radio" name="vWhenInvest" id="next12" class="checkboxall"
                                                value="next12"
                                                @if (isset($investor) and $investor->vWhenInvest == 'next12') {{ 'checked' }} @endif>
                                            <label>Next 12 Month</label></br>
                                            <input type="radio" name="vWhenInvest" id="after12" class="checkboxall"
                                                value="after12"
                                                @if (isset($investor) and $investor->vWhenInvest == 'after12') {{ 'checked' }} @endif>
                                            <label>After 12 Month</label></br>

                                            <div id="vWhenInvest_error" class="error mt-1"
                                                style="color:red;display: none;">Please Select Invest period</div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6 checkbox">
                                            <label>You are intrested in...</label></br>

                                            <input type="checkbox" name="eAcquiringBusiness" id="eAcquiringBusiness" class="checkboxall intrestCheckbox" value="Yes" @if (isset($investor) and $investor->eAcquiringBusiness == 'Yes') {{ 'checked' }} @endif>
                                            <label for="eAcquiringBusiness">Acquiring / Buying a Business</label></br>


                                            <input type="checkbox" name="eInvestingInBusiness" id="eInvestingInBusiness"
                                                class="checkboxall intrestCheckbox" value="Yes" @if (isset($investor) and $investor->eInvestingInBusiness == 'Yes') {{ 'checked' }} @endif>
                                            <label for="eInvestingInBusiness">Investing in a Business</label></br>

                                            <input type="checkbox" name="eLendingToBusiness" id="eLendingToBusiness" class="checkboxall intrestCheckbox" value="Yes" @if (isset($investor) and $investor->eLendingToBusiness == 'Yes') {{ 'checked' }} @endif>
                                            <label for="eLendingToBusiness">Lending to a Business</label></br>

                                            <input type="checkbox" name="eBuyingProperty" id="eBuyingProperty" class="checkboxall intrestCheckbox" value="Yes" @if (isset($investor) and $investor->eBuyingProperty == 'Yes') {{ 'checked' }} @endif>
                                            <label for="eBuyingProperty">Buying Property / Plant / Machinery</label>


                                            <input type="checkbox" name="eCorporateInvestor" id="eCorporateInvestor" class="checkboxall intrestCheckbox" value="Yes" @if (isset($investor) and $investor->eCorporateInvestor == 'Yes') {{ 'checked' }} @endif>
                                            <label for="eCorporateInvestor">Corporate Investors</label>

                                            <input type="checkbox" name="eVentureCapitalFirms" id="eVentureCapitalFirms" class="checkboxall intrestCheckbox" value="Yes" @if (isset($investor) and $investor->eVentureCapitalFirms == 'Yes') {{ 'checked' }} @endif>
                                            <label for="eVentureCapitalFirms">Venture Capital Firms</label>

                                            <input type="checkbox" name="ePrivateEquityFirms" id="ePrivateEquityFirms" class="checkboxall intrestCheckbox" value="Yes" @if (isset($investor) and $investor->ePrivateEquityFirms == 'Yes') {{ 'checked' }} @endif>
                                            <label for="ePrivateEquityFirms">Private Equity Firms</label> 

                                            <input type="checkbox" name="eFamilyOffices" id="eFamilyOffices" class="checkboxall intrestCheckbox" value="Yes" @if (isset($investor) and $investor->eFamilyOffices == 'Yes') {{ 'checked' }} @endif>
                                            <label for="eFamilyOffices">Family Offices</label>

                                            <div id="intrestedIn_error" class="error mt-1" style="color:red;display: none;">Please Select your intrest</div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6 checkbox">
                                            <label>How much would you like to invest?</label></br>

                                            <input type="radio" name="vHowMuchInvest" id="" class="checkboxall" value="100K - 1M"
                                                @if (isset($investor) and $investor->vHowMuchInvest == '100K - 1M') {{ 'checked' }} @endif>
                                            <label>100K - 1M</label></br>

                                            <input type="radio" name="vHowMuchInvest" id="" class="checkboxall" value="1M - 5M"
                                                @if (isset($investor) and $investor->vHowMuchInvest == '1M - 5M') {{ 'checked' }} @endif>
                                            <label>1M - 5M</label></br>

                                            <input type="radio" name="vHowMuchInvest" id="" class="checkboxall" value="5M - 10M" @if (isset($investor) and $investor->vHowMuchInvest == '5M - 10M') {{ 'checked' }} @endif>
                                            <label>5M - 10M</label></br>

                                            <input type="radio" name="vHowMuchInvest" id="" class="checkboxall" value="10M+" @if (isset($investor) and $investor->vHowMuchInvest == '10M+') {{ 'checked' }} @endif>
                                            <label>10M+</label>

                                            <div id="vHowMuchInvest_error" class="error mt-1"
                                                style="color:red;display: none;">Please Select range of your Investment
                                            </div>
                                        </div>
                                         <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Profile Image</label>
                                            <input type="file" name="vImage" id="vImage" accept="image/*"
                                                class="form-control">
                                            @php
                                                $image = asset('uploads/default/no-image.png');
                                                if (isset($image_data)) {
                                                    if ($image_data->vImage != '') {
                                                        $image = asset('uploads/investor/profile/' . $image_data->vImage);
                                                    }
                                                }
                                            @endphp

                                            <div id="vImage_error" class="error mt-1" style="color:red;display: none;">
                                                Please Select Image</div>
                                            <div id="vImage_error_max" class="error mt-1"
                                                style="color:red;display: none;">Please Select Image Max File Size 2 MB
                                            </div>
                                            <div id="vImage_error_required" class="error mt-1"
                                                style="color:red;display: none;">Please Select Image</div>
                                            <img id="img" class="d-block mt-2" width="100px" height="100px"
                                                src="{{ $image }}">
                                            <input type="hidden" name="old_vImage" id="old_vImage"
                                                value="{{ isset($image_data) ? $image_data->vImage : '' }}">
                                            @if ($errors->has('vImage'))
                                                <div class="error mt-1" style="color:red;">The image must be a file of
                                                    type: png, jpg, jpeg </div>
                                            @endif
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Factors In Business</label>
                                            <textarea class="form-control" id="tFactorsInBusiness" name="tFactorsInBusiness"
                                                placeholder="Please enter Factors in Business "> @if (isset($investor)){{ $investor->tFactorsInBusiness }}@endif </textarea>
                                            <div id="tFactorsInBusiness_error" class="error mt-1"
                                                style="color:red;display: none;">Please Enter Factors in Business </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>About your company</label>
                                            <textarea class="form-control" id="tAboutCompany" name="tAboutCompany" placeholder="Please enter About Company"> @if (isset($investor)){{ $investor->tAboutCompany }}@endif </textarea>
                                            <div id="tAboutCompany_error" class="error mt-1"
                                                style="color:red;display: none;">Please Enter About Company</div>
                                        </div>

                                       

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Upload Id Photo</label>
                                            <input type="hidden" name="documentId" id="documentId">
                                            <div id="identification_photo_dropzone" name='identification_photo_dropzone'
                                                class="dropzone"></div>
                                            <input type="file" name="file_identification_photo[]"
                                                id="file_identification_photo" class="d-none">
                                        </div>
                                          <!-- start display image code -->
                                        {{--<div class="file-upload-img">
                                            <ul>
                                            @if(!empty($image_data)) 
                                                @foreach ($image_data as $iValue)
                                                @if($iValue->eType == 'identification_photo')
                                                    <li class="img-upload">
                                                          @php
                                                            $current_image = '';
                                                            @endphp
                                                            @if(!empty($iValue->vImage) && file_exists(public_path('uploads/investor/identification_photo/' . $iValue->vImage)))
                                                                @php
                                                                $current_image = 'uploads/investor/identification_photo/'.$iValue->vImage;
                                                                @endphp
                                                            @else
                                                                @php
                                                                $current_image = 'uploads/default/no-image.png';
                                                                @endphp
                                                            @endif
                                                          <a target="_blank" href="{{asset($current_image)}}">
                                                                <img src="{{asset($current_image)}}" alt="{{$iValue->vImage}}" class="imgese" height="100px">
                                                                <a href="javascript:;" class="delete_document clear-btn" data-id="{{$iValue->iInvestorDocId}}">
                                                                   <i class="fal fa-times"></i>
                                                                </a>
                                                          </a>
                                                    </li>
                                                    @endif
                                                 @endforeach
                                            @endif
                                           </ul>
                                        </div>--}}
                                        <!-- close display image code -->

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Status</label>
                                            <select name="eStatus" id="eStatus" class="form-control">
                                                <option value="">Select Status</option>
                                                <option value="Active"
                                                    @if (isset($investor)) @if ($investor->eStatus == 'Active') selected @endif
                                                    @endif>Active</option>
                                                <option value="Inactive"
                                                    @if (isset($investor)) @if ($investor->eStatus == 'Inactive') selected @endif
                                                    @endif>Inactive</option>
                                            </select>
                                            <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">
                                                Please Select Status</div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Show On Home Page</label>
                                            <select name="eShowHomePage" id="eShowHomePage" class="form-control">
                                                <option value="">Select option</option>
                                                <option value="Yes"
                                                    @if (isset($investor)) @if ($investor->eShowHomePage == 'Yes') selected @endif
                                                    @endif>Yes</option>
                                                <option value="No"
                                                    @if (isset($investor)) @if ($investor->eShowHomePage == 'No') selected @endif
                                                    @endif>No</option>
                                            </select>
                                            <div id="eHomeStatus_error" class="error mt-1"
                                                style="color:red;display: none;">Please Select Status</div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Admin Approval</label>
                                            <select name="eAdminApproval" id="eAdminApproval" class="form-control">
                                                <option value="">Select option</option>
                                                <option value="Pending" @if (isset($investor)) @if ($investor->eAdminApproval == 'Pending') selected @endif @endif>
                                                    pending
                                                </option>
                                                <option value="Approved" @if (isset($investor)) @if ($investor->eAdminApproval == 'Approved') selected @endif @endif>
                                                    approved
                                                </option>
                                                 <option value="Reject" @if (isset($investment)) @if ($investment->eAdminApproval == 'Reject') selected @endif @endif>
                                                    reject
                                                </option>
                                            </select>                          
                                        </div>
                                    </div> {{-- end row --}}
                                    <div class="card-footer col-12 d-inline-block mt-0">
                                        <a href="javascript:;" class="btn btn-primary submit" id="save">Submit</a>
                                        <a href="javascript:;" class="btn btn-primary loading" style="display: none;">
                                            <span class="spinner-border spinner-border-sm"
                                                aria-hidden="true"></span>Loading...
                                        </a>
                                        <a href="{{ url('admin/investor/listing') }}" class="btn-info btn">Back</a>
                                    </div> {{-- end card-footer --}}
                                </div>{{-- end card-body --}}
                            </form>
                        </div> {{-- end card --}}
                    </div> {{-- end col --}}
                </div> {{-- end row --}}
            </div> {{-- end container-fluid --}}
        </section> {{-- end content section --}}
    </section> {{-- end content-header section --}}
@endsection

@section('custom-js')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        var datePicker = $('#dDob');
        var upload_url = '{{ url('admin/investor/upload') }}';
        datePicker.datepicker({
            format: 'dd-MM-yyyy',
            autoclose: true,
            endDate: '+0d',
        });

        $(document).ready(function() {
            $('.select2Option').select2();
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
        });
        $(document).on("input", ".numeric", function() {
            this.value = this.value.replace(/\D/g, '');
        });

        Dropzone.autoDiscover = false;
        var docString = '';
        const identification_photo_dropzone = document.getElementById('identification_photo_dropzone');
        const file_identification_photo = document.getElementById('file_identification_photo');

        var dropzone = new Dropzone('#identification_photo_dropzone', {
            thumbnailWidth: 200,
            parallelUploads: 10,
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",
            addRemoveLinks: true,
            url: upload_url,
            paramName: "file",
            params: {
                'type': 'identification_photo'
            },
            headers: {
                'x-csrf-token': '{{ csrf_token() }}',
            },
            success: function(file, response) {
                docString += response.id + ',';
                $('#documentId').val(docString.slice(0, -1));
            }
        });
        identification_photo_dropzone.addEventListener('drop', event => {
            event.preventDefault();
            let files1 = event.dataTransfer.files;
            file_identification_photo.files = files1;
            console.log('added ' + files.length + ' files');
        });

        var fileName = '';
        $(document).on('change', '#vImage', function() {
            fileName = this.files[0].name;
            var filesize = this.files[0].size
            var maxfilesize = parseInt(filesize / 1024);
            if (maxfilesize > 2048) {
                $('#vImage').val('');
                $("#vImage_error_max").show();
                $("#save").removeClass("submit");
                return false;
            } else {
                $("#save").addClass("submit");
                $("#vImage_error_max").hide();
            }
        });

        $(document).on('click', '.submit', function() {
            tinymce.triggerSave();
            var vUniqueCode = $("#vUniqueCode").val();
            var industries = $("#industries").val();
            var vProfileTitle = $("#vProfileTitle").val();
            var vFirstName = $("#vFirstName").val();
            var vLastName = $("#vLastName").val();
            var dDob = $("#dDob").val();
            var vEmail = $("#vEmail").val();
            var vPhone = $("#vPhone").val();
			var vInvestorProfileName = $("#vInvestorProfileName").val();
            var tInvestorProfileDetail = $("#tInvestorProfileDetail").val();
            var iNationality = $("#iNationality").val();
            var iCity = $("#iCity").val();
            var eInvestingExp = $("#eInvestingExp").val();
            var eAdvisorGuide = $("#eAdvisorGuide").val();
            var eInvestorType = $("#eInvestorType").val();
            var vWhenInvest = $('input:radio[name="vWhenInvest"]:checked').length;
            var intrestCheckbox = $(".intrestCheckbox:checkbox:checked").length;
            var vHowMuchInvest = $('input:radio[name="vHowMuchInvest"]:checked').length;
            var vIdentificationNo = $("#vIdentificationNo").val();
            var tFactorsInBusiness = $('#tFactorsInBusiness').val();
            var vImage = $("#vImage").val();
            var eStatus = $("#eStatus").val();
            var error = false;

            if (vProfileTitle.length == 0) {
                $("#vProfileTitle_error").show();
                error1 = true;
            } else {
                $("#vProfileTitle_error").hide();
            }
            if (fileName == '') {
                //$("#vImage_error_required").show();
            } else {
                $("#vImage_error_required").hide();
            }
            if (vFirstName.length == 0) {
                $("#vFirstName_error").show();
                error = true;
            } else {
                $("#vFirstName_error").hide();
            }
            if (vLastName.length == 0) {
                $("#vLastName_error").show();
                error = true;
            } else {
                $("#vLastName_error").hide();
            }
            if (dDob.length == 0) {
                $("#dDob_error").show();
                error = true;
            } else {
                $("#dDob_error").hide();
            }
            if (vEmail.length == 0) {
                $("#vEmail_error").show();
                $("#vEmail_valid_error").hide();
                error = true;
            } else {
                if (validateEmail(vEmail)) {
                    $("#vEmail_valid_error").hide();
                    $("#vEmail_error").hide();
                } else {
                    $("#vEmail_valid_error").show();
                    $("#vEmail_error").hide();
                    error = true;
                }
            }
            if (vPhone.length == 0) {
                $("#vPhone_error").show();
                error = true;
            } else {
                $("#vPhone_error").hide();
            }

            if (vInvestorProfileName.length == 0) {
                $("#vInvestorProfileName_error").show();
                error = true;
            } else {
                $("#vInvestorProfileName_error").hide();
            }
            if (tInvestorProfileDetail.length == 0) {
                $("#tInvestorProfileDetail_error").show();
                error = true;
            } else {
                $("#tInvestorProfileDetail_error").hide();
            }

            if (iNationality === '') {
                $("#iNationality_error").show();
            } else {
                $("#iNationality_error").hide();
            }
            if (iCity === '') {
                $("#iCity_error").show();
            } else {
                $("#iCity_error").hide();
            }
            if (eInvestingExp === '') {
                $("#eInvestingExp_error").show();
            } else {
                $("#eInvestingExp_error").hide();
            }
            if (eAdvisorGuide === '') {
                $("#eAdvisorGuide_error").show();
            } else {
                $("#eAdvisorGuide_error").hide();
            }if (eInvestorType === '') {
                $("#eInvestorType_error").show();
            } else {
                $("#eInvestorType_error").hide();
            }
            if (industries.length == 0) {
                $("#industries_error").show();
                error = true;
            } else {
                $("#industries_error").hide();
            }
            if (vWhenInvest <= 0) {
                $("#vWhenInvest_error").show();
            } else {
                $("#vWhenInvest_error").hide();
            }
            if (intrestCheckbox <= 0) {
                $("#intrestedIn_error").show();
            } else {
                $("#intrestedIn_error").hide();
            }
            if (vHowMuchInvest <= 0) {
                $("#vHowMuchInvest_error").show();
            } else {
                $("#vHowMuchInvest_error").hide();
            }

            if (vIdentificationNo.length == 0) {
                $("#vIdentificationNo_error").show();
                error = true;
            } else {
                $("#vIdentificationNo_error").hide();
            }
            if (tFactorsInBusiness.length == 0) {
                /* $("#tFactorsInBusiness_error").show();
                error = true; */
            } else {
                /* $("#tFactorsInBusiness_error").hide(); */
            }
            if (eStatus.length == 0) {
                error = true;
                $("#eStatus_error").show();
            } else {
                $("#eStatus_error").hide();
            }

            setTimeout(function() {
                if (error == true) {
                    return false;
                } else {
                    $("#frm").submit();
                    $('.submit').hide();
                    $('.loading').show();
                    return true;
                }
            }, 1000);
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

        function dropdown_validate(id) {
            alert($('#' + id + ' option:selected').length);
            return $('#' + id).length > 0;
        }

        $(document).on('change', '#vImage', function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#img').attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
@endsection
