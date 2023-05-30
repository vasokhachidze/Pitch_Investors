@extends('layouts.app.admin-app')
@section('title', 'Investment - ' . env('APP_NAME'))
@php
    //dd($location, $selected_location);
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
        /* .dropzone {
            background: white;
            border-radius: 5px;
            border: 2px dashed rgb(0, 135, 247);
            border-image: none;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }*/
    </style>
@endsection
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($investment) ? 'Edit' : 'Add' }} Investment</h1>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <!-- <div class="card-header custome-nav-tabs">
                        
                      </div> -->
                            <form action="{{ url('admin/investment/store') }}" name="frm" id="frm" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if (isset($investment)) {{ $investment->vUniqueCode }} @endif">
                                    <div class="row">
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>First Name</label>
                                            <input type="text" name="vFirstName" id="vFirstName" class="form-control" placeholder="Enter First Name" value="@if (isset($investment)) {{ $investment->vFirstName }} @endif">
                                            <div id="vFirstName_error" class="error mt-1" style="color:red;display: none;">
                                                Please Enter First Name </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Last Name</label>
                                            <input type="text" name="vLastName" id="vLastName" class="form-control" placeholder="Enter Last Name" value="@if (isset($investment)) {{ $investment->vLastName }} @endif">
                                            <div id="vLastName_error" class="error mt-1" style="color:red;display: none;">
                                                Please Enter Last Name </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>DOB</label>
                                            <input type="text" name="dDob" id="dDob" class="form-control datepicker" placeholder="Enter Date of Birth" value="@if (isset($investment)) {{ date('d-F-Y', strtotime($investment->dDob)) }} @endif">
                                            <div id="dDob_error" class="error mt-1" style="color:red;display: none;">Please
                                                Enter Date of Birth </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Email</label>
                                            <input type="text" name="vEmail" id="vEmail" class="form-control datepicker" placeholder="Enter Email" value="@if(isset($investment)){{$investment->vEmail}}@endif">
                                            <div id="vEmail_error" class="error mt-1" style="color:red;display: none;">
                                                Please Enter Email </div>
                                            <div id="vEmail_valid_error" class="error_show" style="color:red;display: none;">Please Enter Valid Email</div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Phone</label>
                                            <input type="text" name="vPhone" id="vPhone" class="form-control numeric" maxlength="10" placeholder="Enter Phone No." value="@if (isset($investment)) {{ $investment->vPhone }} @endif">
                                            <div id="vPhone_error" class="error mt-1" style="color:red;display: none;">
                                                Please Enter Phone No. </div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Identification No</label>
                                            <input type="text" name="vIdentificationNo" id="vIdentificationNo" class="form-control datepicker" placeholder="Enter Identification No." value="@if (isset($investment)) {{ $investment->vIdentificationNo }} @endif">
                                            <div id="vIdentificationNo_error" class="error mt-1" style="color:red;display: none;">Please Enter Identification No. </div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Business Name</label>
                                            <input type="text" name="vBusinessName" id="vBusinessName" class="form-control " placeholder="Enter Business Name" value="@if (isset($investment)) {{ $investment->vBusinessName }} @endif">
                                            <div id="vBusinessName_error" class="error mt-1" style="color:red;display: none;">Please Enter Business Name. </div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Business Eltablished</label>
                                            <input type="text" name="vBusinessEstablished" id="vBusinessEstablished" class="form-control datepicker" placeholder="Enter Business Establishment" value="@if (isset($investment)) {{ $investment->vBusinessEstablished }} @endif">
                                            <div id="vBusinessEstablished_error" class="error mt-1" style="color:red;display: none;">Please Enter Business Establishment.
                                            </div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Business Profile Name</label>
                                            <input type="text" name="vBusinessProfileName" id="vBusinessProfileName" class="form-control " placeholder="Enter Business Profile Name" value="@if (isset($investment)) {{ $investment->vBusinessProfileName }} @endif">
                                            <div id="vBusinessProfileName_error" class="error mt-1" style="color:red;display: none;">Please Enter Business Profile Name.</div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Business Profile Detail</label>
                                            <input type="text" name="tBusinessProfileDetail" id="tBusinessProfileDetail" class="form-control " placeholder="Enter Business Profile Detail" value="@if (isset($investment)) {{ $investment->tBusinessProfileDetail }} @endif">
                                            <div id="tBusinessProfileDetail_error" class="error mt-1" style="color:red;display: none;">Please Enter Business Profile Detail. </div>
                                        </div>

                                        <!-- <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Location</label>
                                            <select name="locations[]" id="locations" class="form-control" multiple="multiple">
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
                                                            @else
                                                                @php
                                                                    $region_select = '';
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    <option class="region_option" value="Region_{{ $value['regionId'] }}-{{ $value['regionName'] }}"{{ $region_select }}>{{ $value['regionName'] }}</option>
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
                                                                @else
                                                                    @php
                                                                        $county_select = '';
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        <option class="county_option" value="County_{{ $value1['countyId'] }}-{{ $value1['countyName'] }}" {{ $county_select }}>-{{ $value1['countyName'] }}</option>
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
                                                                    @else
                                                                        @php
                                                                            $subcounty_select = '';
                                                                        @endphp
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            <option class="subCounty_option" value="Sub County_{{ $value2['iSubCountId'] }}-{{ $value2['subCountyName'] }}" {{ $subcounty_select }}>--{{ $value2['subCountyName'] }}
                                                            </option>
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            <div id="locations_error" class="error mt-1" style="color:red;display: none;">Please Select Location</div>
                                        </div> -->
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Location</label>
                                            <select name="locations[]" id="locations" class="form-control" multiple="multiple">
                                                @foreach ($location as $key => $value)
                                                    @php
                                                        $region_select = '';
                                                        $county_select = '';
                                                        $subcounty_select = '';
                                                    @endphp

                                                    @if (isset($selected_location))
                                                        @foreach ($selected_location as $key => $lvalue)
                                                            @if ($region_select != '')
                                                                @php
                                                                    continue;
                                                                @endphp
                                                            @endif
                                                            @if ($lvalue->iLocationId == $value['regionId'] && $lvalue->eLocationType == 'Region')
                                                                @php
                                                                    $region_select = 'selected';
                                                                @endphp
                                                            @else
                                                                @php
                                                                    $region_select = '';
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    <option class="region_option" value="Region_{{ $value['regionId'] }}-{{ $value['regionName'] }}"{{ $region_select }}>{{ $value['regionName'] }}</option>
                                                    @foreach ($value as $key1 => $value1)
                                                        @if (in_array($key1, ['regionId', 'regionName']))
                                                            @continue
                                                        @endif

                                                        @if (isset($selected_location))
                                                            @foreach ($selected_location as $key => $lvalue)
                                                                @if ($county_select != '')
                                                                    @php
                                                                        continue;
                                                                    @endphp
                                                                @endif
                                                                @if ($lvalue->iLocationId == $value1['countyId'] && $lvalue->eLocationType == 'County')
                                                                    @php
                                                                        $county_select = 'selected';
                                                                    @endphp
                                                                @else
                                                                    @php
                                                                        $county_select = '';
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        <option class="county_option" value="County_{{ $value1['countyId'] }}-{{ $value1['countyName'] }}" {{ $county_select }}>-{{ $value1['countyName'] }}</option>
                                                        @foreach ($value1 as $key2 => $value2)
                                                            @if (in_array($key2, ['countyId', 'countyName']))
                                                                @continue
                                                            @endif

                                                            @if (isset($selected_location))
                                                                @foreach ($selected_location as $key => $lvalue)
                                                                    @if ($subcounty_select != '')
                                                                        @php
                                                                            continue;
                                                                        @endphp
                                                                    @endif
                                                                    @if ($lvalue->iLocationId == $value2['subCountyName'] && $lvalue->eLocationType == 'Sub County')
                                                                        @php
                                                                            $subcounty_select = 'selected';
                                                                        @endphp
                                                                    @else
                                                                        @php
                                                                            $subcounty_select = '';
                                                                        @endphp
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            <option class="subCounty_option" value="Sub County_{{ $value2['iSubCountId'] }}-{{ $value2['subCountyName'] }}" {{ $subcounty_select }}>--{{ $value2['subCountyName'] }}
                                                            </option>
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            <div id="locations_error" class="error mt-1" style="color:red;display: none;">Kindly select the location of the business</div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Investment industries</label>
                                            <select name="industries[]" id="industries" class="form-control" multiple="multiple">
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
                                                    <option value="{{ $value->vName }}_{{ $value->iIndustryId }}" {{ $industry_select }}>{{ $value->vName }}</option>
                                                @endforeach
                                            </select>
                                            <div id="industries_error" class="error mt-1" style="color:red; display: none;">Please Select Industries</div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6 checkbox">
                                            <label>Business Profile</label></br>

                                            <input type="radio" id="Business_owner" name="eBusinessProfile" class="checkboxall" value="Business owner" @if (isset($investment) and $investment->eBusinessProfile == 'Business owner') {{ 'checked' }} @endif>
                                            <label for="Business_owner">Business owner</label></br>

                                            <input type="radio" id="Business_Broker" name="eBusinessProfile" class="checkboxall" value="Business Broker" @if (isset($investment) and $investment->eBusinessProfile == 'Business Broker') {{ 'checked' }} @endif>
                                            <label for="Business_Broker">Business Broker</label></br>

                                            <input type="radio" id="Business_advisor" name="eBusinessProfile" class="checkboxall" value="Business advisor" @if (isset($investment) and $investment->eBusinessProfile == 'Business advisor') {{ 'checked' }} @endif>
                                            <label for="Business_advisor">Business advisor</label></br>

                                            <div id="eBusinessProfile_error" class="error mt-1" style="color:red;display: none;">Please Select</div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6 checkbox">
                                            <label>You are intrested in...</label></br>

                                            <input type="checkbox" name="eFullSaleBusiness" id="eFullSaleBusiness" class="checkboxall intrestCheckbox" value="Yes" @if (isset($investment) and $investment->eFullSaleBusiness == 'Yes') {{ 'checked' }} @endif>
                                            <label for="eFullSaleBusiness">Full sale of business</label>

                                            <input type="checkbox" name="eLoanForBusiness" id="eLoanForBusiness" class="checkboxall intrestCheckbox" value="Yes" @if (isset($investment) and $investment->eLoanForBusiness == 'Yes') {{ 'checked' }} @endif>
                                            <label for="eLoanForBusiness">Loan for business</label></br>

                                            <input type="checkbox" name="ePartialSaleBusiness" id="ePartialSaleBusiness" class="checkboxall intrestCheckbox" value="Yes" @if (isset($investment) and $investment->ePartialSaleBusiness == 'Yes') {{ 'checked' }} @endif>
                                            <label for="ePartialSaleBusiness">Partial sale of business/Investment</label></br>

                                            <input type="checkbox" name="eBailout" id="eBailout" class="checkboxall intrestCheckbox" value="Yes" @if (isset($investment) and $investment->eBailout == 'Yes') {{ 'checked' }} @endif>
                                            <label for="eBailout">Distressed company looking for bailout</label></br>

                                            <input type="checkbox" name="eBusinessAsset" id="eBusinessAsset" class="checkboxall intrestCheckbox" value="Yes" @if (isset($investment) and $investment->eBusinessAsset == 'Yes') {{ 'checked' }} @endif>
                                            <label for="eBusinessAsset">Selling or leasing out business asset</label>

                                            <div id="intrestedIn_error" class="error mt-1" style="color:red;display: none;">Please Select</div>
                                        </div>



                                        <div class="form-group col-xl-6 col-lg-12 col-md-6 checkbox">
                                            <label>Business legal entity type</label></br>

                                            <input type="radio" value="eSoleProprietor" name="legal_entity" id="eSoleProprietor" class="checkboxall legal_entity" @if (isset($investment) and $investment->eSoleProprietor == 'Yes') {{ 'checked' }} @endif>
                                            <label for="eSoleProprietor">Sole proprietor</label></br>

                                            <input type="radio" value="eGeneralPartnership" name="legal_entity" id="eGeneralPartnership" class="checkboxall legal_entity" @if (isset($investment) and $investment->eGeneralPartnership == 'Yes') {{ 'checked' }} @endif>
                                            <label for="eGeneralPartnership">General partnership</label></br>

                                            <input type="radio" value="eLLP" name="legal_entity" id="eLLP" class="checkboxall legal_entity" @if (isset($investment) and $investment->eLLP == 'Yes') {{ 'checked' }} @endif>
                                            <label for="eLLP">Limited liability partnership (LLP)</label></br>

                                            <input type="radio" value="eLLC" name="legal_entity" id="eLLC" class="checkboxall legal_entity" @if (isset($investment) and $investment->eLLC == 'Yes') {{ 'checked' }} @endif>
                                            <label for="eLLC">Limited liability company (LLC)</label>

                                            <div id="legelEntity_error" class="error mt-1" style="color:red;display: none;">Please Select legal entity</div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6 checkbox">
                                            <label></label></br>

                                            <input type="radio" value="ePrivateCompany" name="legal_entity" id="ePrivateCompany" class="checkboxall legal_entity" @if (isset($investment) and $investment->ePrivateCompany == 'Yes') {{ 'checked' }} @endif>
                                            <label for="ePrivateCompany">Private company</label></br>

                                            <input type="radio" value="ePrivateLimitedCompany" name="legal_entity" id="ePrivateLimitedCompany" class="checkboxall legal_entity" @if (isset($investment) and $investment->ePrivateLimitedCompany == 'Yes') {{ 'checked' }} @endif>
                                            <label for="ePrivateLimitedCompany">Public limited company</label></br>

                                            <input type="radio" value="eSCorporation" name="legal_entity" id="eSCorporation" class="checkboxall legal_entity" @if (isset($investment) and $investment->eSCorporation == 'Yes') {{ 'checked' }} @endif>
                                            <label for="eSCorporation">S corporation</label></br>

                                            <input type="radio" value="eCCorporation" name="legal_entity" id="eCCorporation" class="checkboxall legal_entity" @if (isset($investment) and $investment->eCCorporation == 'Yes') {{ 'checked' }} @endif>
                                            <label for="eCCorporation">C corporation</label>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Upload Business Proof</label>
                                            <div id="business_proof_dropzone" name='business_proof_dropzone' class="dropzone"></div>
                                            <input type="file" name="file_business_proof[]" id="file_business_proof" class="d-none">
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>NDA if you have any</label>
                                            <div id="file_NDA_dropzone" name='file_NDA_dropzone' class="dropzone"></div>
                                            <input type="file" name="file_NDA_upload[]" id="file_NDA_upload" class="d-none">
                                        </div>

                                        {{-- <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Upload Fast verification</label>
                                            <div id="fast_verification_dropzone" name='fast_verification_dropzone' class="dropzone"></div>
                                            <input type="file" name="file_fast_verification[]" id="file_fast_verification" class="d-none">
                                        </div> --}}

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Describe Your Business</label>
                                            <textarea class="form-control" id="tBusinessDetail" name="tBusinessDetail" placeholder="Please enter describe Business ">
												@if (isset($investment)){{ $investment->tBusinessDetail }}@endif
											</textarea>
                                            <div id="tBusinessDetail_error" class="error mt-1" style="color:red;display: none;">Please Enter describe Business </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>High lights Of Business</label>
                                            <textarea class="form-control" id="tBusinessHighLights" name="tBusinessHighLights" placeholder="Please enter Business High lights">
												@if (isset($investment)){{ $investment->tBusinessHighLights }}@endif
											</textarea>
                                            <div id="tBusinessHighLights_error" class="error mt-1" style="color:red;display: none;">Please Enter Business High lights</div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Describe your facility</label>
                                            <textarea class="form-control" id="tFacility" name="tFacility" placeholder="Please enter Facility Detail">
												@if (isset($investment)){{ $investment->tFacility }}@endif
											</textarea>
                                            <div id="tFacility_error" class="error mt-1" style="color:red;display: none;">Please Enter Facility Detail</div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>List of products and services </label>
                                            <textarea class="form-control" id="tListProductService" name="tListProductService" placeholder="Please enter Facility Detail">
												@if (isset($investment)){{ $investment->tListProductService }}@endif
											</textarea>
                                            <div id="tListProductService_error" class="error mt-1" style="color:red;display: none;">Please Enter Products and services</div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Upload Image Your Facility / Stores (If any)</label>
                                            <div id="facility_upload_dropzone" name='facility_upload_dropzone' class="dropzone"></div>
                                            <input type="file" name="file_facility_upload[]" id="file_facility_upload" class="d-none">
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Upload Yearly sales Reoport</label>
                                            <div id="yearly_sales_report_dropzone" name='yearly_sales_report_dropzone' class="dropzone"></div>
                                            <input type="file" name="file_yearly_sales_report[]" id="file_yearly_sales_report" class="d-none">
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Annual sales? (in KES)</label>
                                            <input type="text" name="vAverateMonthlySales" id="vAverateMonthlySales" class="form-control numeric" value="@if (isset($investment)) {{ $investment->vAverateMonthlySales }} @endif">
                                            <div id="vAverateMonthlySales_error" class="error mt-1" style="color:red;display: none;">Please Enter Annual sales</div>
                                            <div id="vAverateMonthlySales_number_error" class="error mt-1" style="color:red;display: none;">Please Enter numbers only
                                        </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>What is the  Profit Margin Percentage?
                                                (Percentage)</label>
                                            <input type="text" name="vProfitMargin" id="vProfitMargin" class="form-control numeric" maxlength="3" value="@if (isset($investment)) {{ $investment->vProfitMargin }} @endif">
                                            <div id="vProfitMargin_error" class="error mt-1" style="color:red;display: none;">Please Enter  Profit
                                                Margin Percentage</div>
                                            <div id="vProfitMargin_number_error" class="error mt-1" style="color:red;display: none;">range 0 to 100
                                            </div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>What is the value of physical assets owned by the business?</label>
                                            <input type="text" name="vPhysicalAssetValue" id="vPhysicalAssetValue" class="form-control numeric" value="@if (isset($investment)) {{ $investment->vPhysicalAssetValue }} @endif">
                                            <div id="vPhysicalAssetValue_error" class="error mt-1" style="color:red;display: none;">Please Enter value of physical assets
                                                owned by the business</div>
                                            <div id="vPhysicalAsset_number_error" class="error mt-1" style="color:red;display: none;">Please Enter numbers only
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>What is the maximum stake you are willing to sell? (Should be in
                                                percentage)</label>
                                            <input type="text" name="vMaxStakeSell" id="vMaxStakeSell" class="form-control numeric" maxlength="3" value="@if (isset($investment)) {{ $investment->vMaxStakeSell }} @endif">
                                            <div id="vMaxStakeSell_error" class="error mt-1" style="color:red;display: none;">Please Enter maximum stake you are willing
                                                to sell</div>
                                            <div id="vMaxStakeSell_number_error" class="error mt-1" style="color:red;display: none;">Please Enter Percentage less than 100
                                            </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>What investment amount are you seeking for this stake? </label>
                                            <input type="text" name="vInvestmentAmountStake" id="vInvestmentAmountStake" class="form-control numeric" value="@if (isset($investment)) {{ $investment->vInvestmentAmountStake }} @endif">
                                            <div id="vInvestmentAmountStake_error" class="error mt-1" style="color:red;display: none;">Please Enter investment amount you are
                                                seeking for this stake</div>
                                                <div id="vInvestmentAmountStake_number_error" class="error mt-1" style="color:red;display: none;">Please Enter numbers only
                                        </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Provide reason for investment</label>
                                            <input type="text" name="tInvestmentReason" id="tInvestmentReason" class="form-control" value="@if (isset($investment)) {{ $investment->tInvestmentReason }} @endif">
                                            <div id="tInvestmentReason_error" class="error mt-1" style="color:red;display: none;">Please Enter reason for investment</div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Show On Home Page</label>
                                            <select name="eShowHomePage" id="eShowHomePage" class="form-control">
                                                <option value="">Select option</option>
                                                <option value="Yes" @if (isset($investment)) @if ($investment->eShowHomePage == 'Yes') selected @endif @endif>
                                                    Yes
                                                </option>
                                                <option value="No" @if (isset($investment)) @if ($investment->eShowHomePage == 'No') selected @endif @endif>
                                                    No
                                                </option>
                                            </select>
                                            <div id="eHomeStatus_error" class="error mt-1" style="color:red;display: none;">Please Select Status</div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Status</label>
                                            <select name="eStatus" id="eStatus" class="form-control">
                                                <option value="">Select Status</option>
                                                <option value="Active"
                                                    @if (isset($investment)) @if ($investment->eStatus == 'Active') selected @endif
                                                    @endif>Active</option>
                                                <option value="Inactive"
                                                    @if (isset($investment)) @if ($investment->eStatus == 'Inactive') selected @endif
                                                    @endif>Inactive</option>
                                            </select>
                                            <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">
                                                Please Select Status</div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Admin Approval</label>
                                            <select name="eAdminApproval" id="eAdminApproval" class="form-control">
                                                <option value="">Select option</option>
                                                <option value="Pending" @if (isset($investment)) @if ($investment->eAdminApproval == 'Pending') selected @endif @endif>
                                                    pending
                                                </option>
                                                <option value="Approved" @if (isset($investment)) @if ($investment->eAdminApproval == 'Approved') selected @endif @endif>
                                                    approved
                                                </option>
                                                <option value="Reject" @if (isset($investment)) @if ($investment->eAdminApproval == 'Reject') selected @endif @endif>
                                                    reject
                                                </option>
                                            </select>                          
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Profile Image</label>
                                            <input type="file" name="vImage" id="vImage" accept="image/*" class="form-control">
                                            @php
                                                $image = asset('uploads/default/no-image.png');
                                                if (!empty($profile)) {
                                                    $image = asset('uploads/investment/profile/' . $profile[0]);
                                                }
                                            @endphp

                                            <div id="vImage_error" class="error mt-1" style="color:red;display: none;">
                                                Please Select Image</div>
                                            <div id="vImage_error_max" class="error mt-1" style="color:red;display: none;">Please Select Image Max File Size 2 MB
                                            </div>
                                            <div id="vImage_error_required" class="error mt-1" style="color:red;display: none;">Please Select Image</div>
                                            <img id="img" class="d-block mt-2" width="100px" height="100px" src="{{ $image }}">
                                            <input type="hidden" name="old_vImage" id="old_vImage" value="{{ isset($image_data) ? $image_data->vImage : '' }}">
                                            @if ($errors->has('vImage'))
                                                <div class="error mt-1" style="color:red;">The image must be a file of type: png, jpg, jpeg </div>
                                            @endif
                                        </div>

                                        <div class="form-group col-xl-12 col-lg-12 col-md-12 checkbox">
                                            <label>
                                                <input type="checkbox" name="eFindersFee" id="eFindersFee" class="checkboxall intrestCheckbox" value="Yes" @if (isset($investment) and $investment->eFindersFee == 'Yes') {{ 'checked' }} @endif>
                                                I accept 1% finder's fee (payable post transaction) and other <a href="#">Terms of engagement</a> </label></br>
                                            <div id="eFindersFee_error" class="error mt-1" style="color:red;display: none;">Please accept terms of engagement</div>
                                        </div>


                                    </div>
                                </div> {{-- end row --}}
                                <div class="card-footer col-12 d-inline-block mt-0">
                                    <a href="javascript:;" class="btn btn-primary submit" id="save">Submit</a>
                                    <a href="javascript:;" class="btn btn-primary loading" style="display: none;">
                                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                                    </a>
                                    <a href="{{ url('admin/investment/listing') }}" class="btn-info btn">Back</a>
                                </div> {{-- end card-footer --}}
                        </div>{{-- end card-body --}}

                            <input type="hidden" id="facility_image_upload_id" name="facility_image_upload_id">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        var datePicker = $('#dDob');
        var datePicker1 = $('#vBusinessEstablished').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            endDate: '+0d',
            autoclose: true //to close picker once year is selected
        });
        var upload_url = '{{ url('admin/investment/upload/') }}';

        datePicker.datepicker({
            format: 'dd-MM-yyyy',
            autoclose: true,
            endDate: '+0d',
        });

        $(document).ready(function() {
            $('#locations').select2({
                closeOnSelect: false,
                placeholder: "Select Location",
                allowClear: true,
                tags: true,
                maximumSelectionLength: 5
            });
            $('#industries').select2({
                closeOnSelect: true,
                placeholder: "Select Industry",
                allowClear: true,
                tags: true
            });
        });

        $(document).on("input", ".numeric", function() {
            this.value = this.value.replace(/\D/g, '');
        });

        Dropzone.autoDiscover = false;

        const business_proof_dropzone = document.getElementById('business_proof_dropzone');
        const file_business_proof = document.getElementById('file_business_proof');

        /* const fast_verification_dropzone = document.getElementById('fast_verification_dropzone');
        const file_fast_verification = document.getElementById('file_fast_verification'); */

        const facility_upload_dropzone = document.getElementById('facility_upload_dropzone');
        const file_facility_upload = document.getElementById('file_facility_upload');

        const yearly_sales_report_dropzone = document.getElementById('yearly_sales_report_dropzone');
        const file_yearly_sales_report = document.getElementById('file_yearly_sales_report');

        const file_NDA_dropzone = document.getElementById('file_NDA_dropzone');
        const file_NDA_upload = document.getElementById('file_NDA_upload');

        /* var dropzone = new Dropzone('#fast_verification_dropzone', {
            thumbnailWidth: 200,
            parallelUploads: 10,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            url: upload_url,
            headers: {
                'x-csrf-token': '{{ csrf_token() }}',
            },
            success: function(file, response) {}
        });
        fast_verification_dropzone.addEventListener('drop', event => {
            event.preventDefault();
            let files1 = event.dataTransfer.files;
            file_fast_verification.files = files1;
            console.log('added ' + files.length + ' files');
        }); */

        var dropzone = new Dropzone('#business_proof_dropzone', {
            thumbnailWidth: 200,
            parallelUploads: 10,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            url: upload_url,
            headers: {
                'x-csrf-token': '{{ csrf_token() }}',
            },
            success: function(file, response) {}
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
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            url: upload_url,
            headers: {
                'x-csrf-token': '{{ csrf_token() }}',
            },
            success: function(file, response) {}
        });
        file_NDA_dropzone.addEventListener('drop', event => {
            event.preventDefault();
            let files = event.dataTransfer.files;
            file_NDA_upload.files = files;
            console.log('added ' + files.length + ' files');
        });
        var facility_image_upload_id = '';
        var dropzone = new Dropzone('#facility_upload_dropzone', {
            thumbnailWidth: 200,
            parallelUploads: 10,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            url: upload_url,
            headers: {
                'x-csrf-token': '{{ csrf_token() }}',
            },
            params: {
                type:'facility'
            },
            success: function(file, response) {
                facility_image_upload_id = facility_image_upload_id+','+response.id;
                $('#facility_image_upload_id').val(facility_image_upload_id.substring(1));
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
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            url: upload_url,
            headers: {
                'x-csrf-token': '{{ csrf_token() }}',
            },
            success: function(file, response) {}
        });
        yearly_sales_report_dropzone.addEventListener('drop', event => {
            event.preventDefault();
            let files = event.dataTransfer.files;
            file_yearly_sales_report.files = files;
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
            var vFirstName = $("#vFirstName").val();
            var vLastName = $("#vLastName").val();
            var dDob = $("#dDob").val();
            var vEmail = $("#vEmail").val();
            var vPhone = $("#vPhone").val();
            var vIdentificationNo = $("#vIdentificationNo").val();
            var vBusinessName = $("#vBusinessName").val();
            var vBusinessProfileName = $("#vBusinessProfileName").val();
            var tBusinessProfileDetail = $("#tBusinessProfileDetail").val();
            var vBusinessEstablished = $("#vBusinessEstablished").val();
            var eBusinessProfile = $('input:radio[name="eBusinessProfile"]:checked').length;
            var intrestCheckbox = $(".intrestCheckbox:checkbox:checked").length;
            var legal_entity = $('input:radio[name="legal_entity"]:checked').length;
            // var legal_entity    = $(".legal_entity:checkbox:checked").length;
            var locations = $("#locations").val();
            var industries = $("#industries").val();
            var vAverateMonthlySales = $("#vAverateMonthlySales").val();
            var vProfitMargin = $("#vProfitMargin").val();
            var vPhysicalAssetValue = $("#vPhysicalAssetValue").val();
            var vMaxStakeSell = $("#vMaxStakeSell").val();
            var vInvestmentAmountStake = $("#vInvestmentAmountStake").val();
            var tInvestmentReason = $("#tInvestmentReason").val();
            var eFindersFee = $("#eFindersFee:checkbox:checked").length;
            var error = false;

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
            if (vIdentificationNo.length == 0) {
                $("#vIdentificationNo_error").show();
                error = true;
            } else {
                $("#vIdentificationNo_error").hide();
            }
            if (vBusinessName.length == 0) {
                $("#vBusinessName_error").show();
                error = true;
            } else {
                $("#vBusinessName_error").hide();
            }
            if (vBusinessProfileName.length == 0) {
                $("#vBusinessProfileName_error").show();
                error = true;
            } else {
                $("#vBusinessProfileName_error").hide();
            }
            if (tBusinessProfileDetail.length == 0) {
                $("#tBusinessProfileDetail_error").show();
                error = true;
            } else {
                $("#tBusinessProfileDetail_error").hide();
            }
            if (vBusinessEstablished.length == 0) {
                $("#vBusinessEstablished_error").show();
                error = true;
            } else {
                $("#vBusinessEstablished_error").hide();
            }
            if (eBusinessProfile <= 0) {
                $("#eBusinessProfile_error").show();
                error = true;
            } else {
                $("#eBusinessProfile_error").hide();
            }
            if (intrestCheckbox <= 0) {
                $("#intrestedIn_error").show();
                error = true;
            } else {
                $("#intrestedIn_error").hide();
            }
            if (legal_entity <= 0) {
                $("#legelEntity_error").show();
                error = true;
            } else {
                $("#legelEntity_error").hide();
            }
            if (locations.length == 0) {
                $("#locations_error").show();
                error = true;
            } else {
                $("#locations_error").hide();
            }
            if (industries.length == 0) {
                $("#industries_error").show();
                error = true;
            } else {
                $("#industries_error").hide();
            }

            if (vAverateMonthlySales.length == 0) {
                $("#vAverateMonthlySales_error").show();
                error = true;
            } else {
                $("#vAverateMonthlySales_error").hide();
                if (!$.isNumeric(vAverateMonthlySales)) {
                    $("#vAverateMonthlySales_number_error").show();
                    error = true;
                } else {
                    $("#vAverateMonthlySales_number_error").hide();
                 }
            }
            
            
            if (vProfitMargin.length == 0) {
                $("#vProfitMargin_error").show();
                error = true;
            } else {
                if (vProfitMargin <= 100) {
                    $("#vProfitMargin_number_error").hide();
                    $("#vProfitMargin_error").hide();
                } else {
                    $("#vProfitMargin_number_error").show();
                    $("#vProfitMargin_error").hide();
                    error = true;
                }
            }
            if (vPhysicalAssetValue.length == 0) {
                $("#vPhysicalAssetValue_error").show();
                error = true;
            } else {
                $("#vPhysicalAssetValue_error").hide();
                if(!$.isNumeric(vPhysicalAssetValue)) {
                    $("#vPhysicalAsset_number_error").show();
                    error = true;
                } else {
                    $("#vPhysicalAsset_number_error").hide();
                }
            }
            

            if (vMaxStakeSell.length == 0) {
                $("#vMaxStakeSell_error").show();
                error = true;
            } else {
                if (vMaxStakeSell <= 100) {
                    $("#vMaxStakeSell_number_error").hide();
                    $("#vMaxStakeSell_error").hide();
                } else {
                    $("#vMaxStakeSell_number_error").show();
                    $("#vMaxStakeSell_error").hide();
                    error = true;
                }
            }

            if (vInvestmentAmountStake.length == 0) {
                $("#vInvestmentAmountStake_error").show();
                error = true;
            } else {
                $("#vInvestmentAmountStake_error").hide();
                if (!$.isNumeric(vInvestmentAmountStake)) {
                    $("#vInvestmentAmountStake_number_error").show();
                    error = true;
                    } else {
                        $("#vInvestmentAmountStake_number_error").hide();
                    }
            }
           
            if (tInvestmentReason.length == 0) {
                $("#tInvestmentReason_error").show();
                error = true;
            } else {
                $("#tInvestmentReason_error").hide();
            }

            if (eFindersFee == 0) {
                error = true;
                $("#eFindersFee_error").show();
            } else {
                $("#eFindersFee_error").hide();
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
            var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (filter.test(sEmail)) {
                return true;
            } else {
                return false;
            }
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
