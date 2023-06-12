@extends('layouts.app.front-app')
@section('title', 'Add Advisor ' . env('APP_NAME'))
@php
    $session_data = session('user');
    $userData = '';
    if ($session_data !== '') {
        $userData = App\Helper\GeneralHelper::get_user_data_in_profile($session_data['iUserId']);
    }
// dd($selected_location);
@endphp
@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css" integrity="sha512-TQQ3J4WkE/rwojNFo6OJdyu6G8Xe9z8rMrlF9y7xpFbQfW5g8aSWcygCQ4vqRiJqFsDsE1T6MoAOMJkFXlrI9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

    <style>
        .image-previewer {
            height: 200px;
            width: 250px;
            display: flex;
            border-radius: 10px;
            border: 1px solid lightgrey;
            padding: 5px;
            object-fit: cover;
        }
        .image-previewer img{
            height: 100%;
            width: 100%;
            border-radius: 10px;
            object-fit: cover;
        }
    </style>

@endsection
@section('content')

    <section class="add-edit-detail lite-gray advisor-edit-detail">
        <div class="adit-detail-step">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="steps-in">
                            <ul>
                                <li><a style="cursor: pointer;" id="first_tab" onclick="next_div('first','');" class="active">Profile</a></li>
                                {{--
                                    <li><a style="cursor: pointer;" id="second_tab" onclick="next_div('second','first');">About Company</a> </li>
                                    <li><a style="cursor: pointer;" id="third_tab" onclick="next_div('third','second');">Investment Interest</a></li>
                                    <li><a style="cursor: pointer;" id="fourth_tab" onclick="next_div('fourth','third');">Location and Factors</a></li>
                                --}}
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
                    <div class="col-lg-9 col-md-12">
                        <!-- frist-step -->
                        
            
                                <form id="frm" action="{{ url('advisor-store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if (isset($advisor)) {{ $advisor->vUniqueCode }} @endif">
                                    <div class="other-detail frist-step">
                                    <h5>{{ isset($advisor) ? 'Edit' : 'Add' }} Business Advisor</h5>
                                        <div class="main-text" style="text-align: justify;">
                                            <h3>Can you help SMEs grow?</h3>
                                            <p>Are you a financial business advisor looking to connect with potential clients? Do you have a degree in Finance, CFA, CPA, or any other finance certification? Do you know how to develop business plans, business valuation models, and other robust financial models? 
                                            </p>
                                            <p>We invite you to sign up on our website to access a network of entrepreneurs and small business owners who are in need of financial advice and guidance. Get started by creating a profile and listing your services to showcase your expertise and qualifications  and start earning as you help SMEs grow.</p>
                                            <div class="image-avtar">
                                                <img src="{{ asset('uploads/front/advisor/profile1.png') }}" alt="">
                                            </div>
                                        </div>
                                    <div class="detail-form">
                                    <div class="row">
                                        <div class="col-md-12 positon-relative basic-detail">
                                            <label for="vAdvisorProfileTitle">Profession</label>
                                            <input type="text" class="form-control" id="vAdvisorProfileTitle" name="vAdvisorProfileTitle" placeholder="Profession" value="@if (isset($advisor)) {{ $advisor->vAdvisorProfileTitle }} @endif">
                                            <div class="validination-info"> <i class=""></i> </div>
                                            <div id="vAdvisorProfileTitle_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter Profession</div>
                                        </div>
                                        <div class="col-md-12 basic-detail positon-relative">                                            
                                            <label for="vCompanyName">Company Name</label>
                                            <input type="text" class="form-control" id="vCompanyName" name="vCompanyName" placeholder="Company Name" value="@if (isset($advisor)) {{ $advisor->vCompanyName }} @endif">
                                            <div class="validination-info">
                                                <i class=""></i>
                                            </div>
                                            <div id="vCompanyName_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter Company Name</div>
                                        </div>
                                        <div class="col-md-6 basic-detail positon-relative">
                                            
                                            <label for="vFirstName">First Name</label>
                                            <input type="text" class="form-control" id="vFirstName" name="vFirstName" placeholder="First Name" value="@if(isset($advisor)){{$advisor->vFirstName}}@elseif(!empty($userData)) {{$userData->vFirstName}}@else{{$session_data['vFirstName']}}@endif">
                                            <div class="validination-info">
                                                <i class=""></i>
                                            </div>
                                            <div id="vFirstName_error" class="error mt-1" style="color:red;display: none; font-size: small;">
                                                Please Enter First Name </div>
                                        </div>

                                        <div class="col-md-6 basic-detail positon-relative">
                                            
                                            <label for="vLastName">Last Name</label>
                                            <input type="text" class="form-control" id="vLastName" name="vLastName" placeholder="Last Name" value="@if(isset($advisor)){{$advisor->vLastName}}@elseif(!empty($userData)) {{$userData->vLastName}}@else{{$session_data['vLastName']}}@endif">
                                            <div class="validination-info">
                                                <i class=""></i>
                                            </div>
                                            <div id="vLastName_error" class="error mt-1" style="color:red;display: none; font-size: small;">
                                                Please Enter Last Name </div>
                                        </div>

                                        <div class="col-md-6 basic-detail positon-relative">
                                            <label for="vPhone">Phone No.</label>
                                            <input type="text" class="form-control numeric" id="vPhone" name="vPhone" placeholder="Phone No." value="@if(isset($advisor)){{$advisor->vPhone}}@elseif(!empty($userData)) {{$userData->vPhone}}@else{{$session_data['vPhone']}}@endif">
                                            <div class="validination-info">
                                                <i class=""></i>
                                            </div>
                                            <div id="vPhone_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter Phone No. </div>
                                        </div>

                                        {{--
                                            <div class="col-md-6 basic-detail positon-relative">
                                                <div>
                                                    <label for="vAdvisorProfileName">Advisor Profile Name</label>
                                                    <input type="text" class="form-control" id="vAdvisorProfileName" name="vAdvisorProfileName" placeholder="Advisor Profile Title" value="@if (isset($advisor)) {{ $advisor->vAdvisorProfileName }} @endif">
                                                </div>
                                                <div id="vAdvisorProfileName_error" class="error mt-1" style="color:red;display: none; font-size: small;">
                                                    Please Enter Advisor Profile Name </div>
                                            </div>
                                        --}}
                                        <div class="col-md-6 basic-detail positon-relative">
                                            
                                            <label for="tAdvisorProfileDetail">Advisor Profile Detail</label>
                                            <input type="text" class="form-control" id="tAdvisorProfileDetail" name="tAdvisorProfileDetail" placeholder="Advisor Profile Detail" value="@if (isset($advisor)) {{ $advisor->tAdvisorProfileDetail }} @endif">
                                            <div class="validination-info">
                                                <i class=""></i>
                                            </div>
                                            <div id="tAdvisorProfileDetail_error" class="error mt-1" style="color:red;display: none; font-size: small;">
                                                Please Enter Advisor Profile Detail </div>
                                        </div>

                                        <div class="col-md-6 basic-detail positon-relative">
                                            
                                            <label for="floatingEmail">Email</label>  
                                            <input type="text" class="form-control" id="vEmail" name="vEmail" placeholder="Email" value="@if(isset($advisor)){{$advisor->vEmail}}@else{{$session_data['vEmail']}}@endif">
                                            <div class="validination-info">
                                                <i class=""></i>
                                            </div>
                                            <div id="vEmail_error" class="error mt-1" style="color:red;display: none; font-size: small;">
                                                Please Enter Email </div>
                                            <div id="vEmail_valid_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter Valid Email </div>
                                        </div>

                                        <div class="col-md-6 basic-detail positon-relative">
                                            <div class="dob-calender">
                                                <label>DOB</label>
                                                <input type="text" class="form-control" id="dDob" name="dDob" placeholder="DOB" value="@if (isset($advisor)) {{ date('d-F-Y', strtotime($advisor->dDob)) }}@elseif(!empty($userData)) {{ date('d-F-Y', strtotime($userData->dDob)) }}@endif">
                                                <div class="validination-info">
                                                    <i class=""></i>
                                                </div>
                                            </div>
                                            <div id="dDob_error" class="error mt-1" style="color:red;display: none; font-size: small;">
                                                Please Enter Date of Birth </div>
                                        </div>

                                        <div class="col-md-6 basic-detail positon-relative">
                                            <div>
                                                <label for="floatingIdentification No">Identification No</label>
                                                <input type="text" class="form-control" id="vIdentificationNo" name="vIdentificationNo" placeholder="Identification No" value="@if (isset($advisor)) {{ $advisor->vIdentificationNo }}@elseif(!empty($userData)) {{$userData->vIdentificationNo}}@endif">
                                                <div class="validination-info">
                                                    <i class=""></i>
                                                </div>
                                            </div>
                                            <div id="vIdentificationNo_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter Identification No. </div>
                                        </div>

                                        <div class="col-md-6 basic-detail positon-relative">
                                            <label for="iCost">How much do you charge for your services in KES</label>
                                            <input type="text" class="form-control numeric money percentage" id="iCost" name="iCost" placeholder="Charge for services" value="@if(isset($advisor)){{$advisor->iCost}}@endif">
                                            <div class="validination-info">
                                                <i class=""></i>
                                            </div>
                                            <div id="iCost_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter Charge for services </div>
                                        </div>

                                        {{--
                                            <div class="col-lg-12 mt-2  mb-2 form-group">
                                                <h6 class="top-head">Location</h6>

                                                <select name="locations[]" id="locations" class="form-control"
                                                    multiple="multiple" style="width: 100%; height: 40px;">
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
                                                                @foreach ($selected_location as $key => $lvalue1)
                                                                    @if ($lvalue1->iLocationId == $value1['countyId'] && $lvalue1->eLocationType == 'County')
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
                                                                        @if ($lvalue->iLocationId == $value2['iSubCountId'] && $lvalue->eLocationType == 'Sub County')
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
                                                    style="color:red;display: none; font-size: small;">Please Select Location</div>
                                            </div>
                                        --}}

                                        <div class="col-lg-6 positon-relative form-group custom-select">
                                            <label>Select Country</label> 
                                            <select id="country_id" name="iCountryId" class="form-control with-border">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $value)
                                                 <option value="{{ $value->iCountryId . '_' . $value->vCountry }}" @if(isset($advisor)) @if($selected_location[0]->iLocationId == $value->iCountryId) {{'selected'}}@endif @endif>{{ $value->vCountry }}</option>
                                                   <!--  <option value="{{ $value->iCountryId . '_' . $value->vCountry }}" {{-- @if (isset($region)) @if ($region->iCountryId == $value->iCountryId) selected @endif @endif --}}>{{ $value->vCountry }}</option> -->
                                                @endforeach
                                            </select>
                                            <div class="validination-info">
                                                <i class=""></i>
                                            </div>
                                            <div id="iCountryId_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Select Country name</div>
                                        </div>
                                        @php
                                            // dd($selected_location);
                                        @endphp
                                        <input type="hidden" id="selected_region_id" value="@if(isset($selected_location)){{$selected_location[1]->iLocationId . '_' . $selected_location[1]->vLocationName}}@endif">
                                        <div class="col-lg-6 positon-relative form-group">
                                            <label>Select Region</label>
                                            <select id="iRegionId" name="iRegionId" class="add_select2 form-control with-border">
                                                <option value="">Select Region</option>
                                            </select>
                                            <div class="validination-info">
                                                <i class=""></i>
                                            </div>
                                            <div id="region_id_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Select Region name</div>
                                        </div>
                                         <input type="hidden" id="selected_county_id" value="@if(isset($selected_location) && isset($selected_location[2])){{$selected_location[2]->iLocationId . '_' . $selected_location[2]->vLocationName}}@endif">
                                        <div class="col-lg-6 positon-relative form-group">
                                            <label>Select County</label>
                                            <select id="iCountyId" name="iCountyId" class="add_select2 form-control with-border">
                                                <option value="">Select County</option>
                                            </select>
                                            <div class="validination-info">
                                                <i class=""></i>
                                            </div>
                                            <div id="county_id_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Select County name</div>
                                        </div>
                                         <input type="hidden" id="selected_sub_county_id" value="@if(isset($selected_location) && isset($selected_location[3])){{$selected_location[3]->iLocationId . '_' . $selected_location[3]->vLocationName}}@endif">
                                        <div class="col-lg-6 positon-relative form-group">
                                            <label>Select Sub County</label>
                                            <select id="iSubCountyId" name="iSubCountyId" class="add_select2 form-control with-border">
                                                <option value="">Select Sub County</option>
                                            </select>
                                            <div class="validination-info">
                                                <i class=""></i>
                                            </div>
                                            <div id="sub_county_id_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Select Sub County name</div>
                                        </div>

                                        <div class="col-lg-12 positon-relative mt-1 form-group">
                                            <label>Advisor Industries</label>
                                            <div>
                                               <select name="industries[]" id="industries" class="form-control" multiple="multiple" style="width: 100%;">
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
                                                <div class="validination-info">
                                                     <i class="" id="industriesError"></i>
                                                </div>
                                                <div id="industries_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please select Industry</div>
                                            </div>
                                        </div>

                                         <div class="col-lg-12 mt-3 intersted-part">
                                            <h6 class="top-head">Profession Title</h6>
                                            <ul class="ul-flex">
                                                <li>
                                                    <label for="eFinancialAnalyst"><input type="checkbox" class="ProfessionCheckbox" id="eFinancialAnalyst" name="eFinancialAnalyst" value="Yes" @if(isset($advisor) and $advisor->eFinancialAnalyst == 'Yes') {{'checked'}}@endif /> Financial analyst</label>
                                                </li>
                                                <li>
                                                    <label for="eAccountant"><input type="checkbox" class="ProfessionCheckbox" id="eAccountant" name="eAccountant" value="Yes" @if(isset($advisor) and $advisor->eAccountant == 'Yes') {{'checked'}}@endif /> Accountant</label>
                                                </li>
                                                <li>
                                                    <label for="eBusinessLawer"><input type="checkbox" class="ProfessionCheckbox" id="eBusinessLawer" name="eBusinessLawer" value="Yes" @if(isset($advisor) and $advisor->eBusinessLawer == 'Yes') {{'checked'}}@endif /> Business lawyer</label>
                                                </li>
                                                <li>
                                                    <label for="eTaxConsultant"><input type="checkbox" class="ProfessionCheckbox" id="eTaxConsultant" name="eTaxConsultant" value="Yes" @if(isset($advisor) and $advisor->eTaxConsultant == 'Yes') {{'checked'}}@endif /> Tax consultant</label>
                                                </li> 
                                                <li>
                                                    <label for="eBusinessBrokers"><input type="checkbox" class="ProfessionCheckbox" id="eBusinessBrokers" name="eBusinessBrokers" value="Yes" @if(isset($advisor) and $advisor->eBusinessBrokers == 'Yes') {{'checked'}}@endif />Busines brokers</label>
                                                </li> 
                                                <li>
                                                    <label for="eCommercialRealEstateBrokers"><input type="checkbox" class="ProfessionCheckbox" id="eCommercialRealEstateBrokers" name="eCommercialRealEstateBrokers" value="Yes" @if(isset($advisor) and $advisor->eCommercialRealEstateBrokers == 'Yes') {{'checked'}}@endif />Commercial Real Estate Brokers</label>
                                                </li>
                                                <li>
                                                    <label for="eMandAAdvisor"><input type="checkbox" class="ProfessionCheckbox" id="eMandAAdvisor" name="eMandAAdvisor" value="Yes" @if(isset($advisor) and $advisor->eMandAAdvisor == 'Yes') {{'checked'}}@endif />M&A advisors</label>
                                                </li>
                                                <li>
                                                    <label for="eInvestmentBanks"><input type="checkbox" class="ProfessionCheckbox" id="eInvestmentBanks" name="eInvestmentBanks" value="Yes" @if(isset($advisor) and $advisor->eInvestmentBanks == 'Yes') {{'checked'}}@endif />Investment Banker</label>
                                                </li>
                                            </ul>
                                            <div id="profession_error" class="error mt-1" style="color:red;display: none;">Please Select your profession</div>
                                        </div>
                                        <div class="col-md-12 positon-relative mt-3 no-floting-back">
                                            <div class="advisor-floting">
                                                <label for="tBio">Bio</label>
                                                <textarea class="form-control" id="tBio" name="tBio" placeholder="Explain yourself" style="height: 100px">@if (isset($advisor)){{ $advisor->tBio }}@endif</textarea>
                                                <div class="validination-info">
                                                    <i class=""></i>
                                                </div>
                                            </div>
                                            <div id="tBio_error" class="error mt-1" style="color:red;display: none; font-size: small;">
                                                Please describe your self.
                                            </div>
                                        </div>

                                        <div class="col-md-6 positon-relative no-floting-back">
                                            <div class="advisor-floting">
                                                <label for="tEducationDetail">Education</label>
                                                <textarea class="form-control" id="tEducationDetail" name="tEducationDetail" placeholder="Explain Education" style="height: 100px">@if (isset($advisor)){{ $advisor->tEducationDetail }}@endif</textarea>
                                                <div class="validination-info">
                                                    <i class=""></i>
                                                </div>
                                            </div>
                                            <div id="tEducationDetail_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please describe your education. </div>

                                             <!-- start display image code -->
                                            <div class="file-upload-img">
                                                <ul>
                                                @if(!empty($image_data)) 
                                                    @foreach ($image_data as $value)
                                                    @if($value->eType == 'education_document')
                                                        <li class="img-upload">
                                                              @php
                                                                $current_image = '';
                                                                @endphp
                                                                @if(!empty($value->vImage) && file_exists(public_path('uploads/business-advisor/education_document/' . $value->vImage)))
                                                                    @php
                                                                    $current_image = 'uploads/business-advisor/education_document/'.$value->vImage;
                                                                    @endphp
                                                                @else
                                                                    @php
                                                                    $current_image = 'uploads/default/no-image.png';
                                                                    @endphp
                                                                @endif
                                                              <a target="_blank" href="{{asset($current_image)}}">
                                                                    <img src="{{asset($current_image)}}" alt="{{$value->vImage}}" class="imgese" height="100px">
                                                                    <a href="javascript:;" class="delete_document clear-btn" data-id="{{$value->iDocumentId}}">
                                                                       <i class="fal fa-times"></i>
                                                                    </a>
                                                              </a>
                                                        </li>
                                                        @endif
                                                     @endforeach
                                                @endif
                                               </ul>
                                            </div>
                                            <!-- close display image code -->
                                        </div>
                                        <input type="hidden" name="documentId" id="documentId">
                                        <div class="col-md-6 padding-top-sixten">
                                            <input type="file" name="file_education_documents[]" id="file_education_documents" class="d-none" accept="image/png, image/jpeg">
                                            <div id="education_documents_dropzone" name='education_documents_dropzone' class="dropzone education-dropzon"></div>
                                        </div>
                                        <div class="col-md-6 positon-relative no-floting-back">
                                            <div class="advisor-floting">
                                                <label for="tAboutCompany">Work Experience</label>
                                                <textarea class="form-control" id="vExperince" name="vExperince" placeholder="Explain your work experience"  style="height: 100px">@if (isset($advisor)){{ $advisor->vExperince }}@endif</textarea>
                                                <div class="validination-info">
                                                    <i class=""></i>
                                                </div>
                                            </div>
                                            <div id="vExperince_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please describe your experience. </div>

                                             <!-- start display image code -->
                                            <div class="file-upload-img">
                                                <ul>
                                                @if(!empty($image_data)) 
                                                    @foreach ($image_data as $value)
                                                    @if($value->eType == 'experience')
                                                        <li class="img-upload">
                                                              @php
                                                                $current_image = '';
                                                                @endphp
                                                                @if(!empty($value->vImage) && file_exists(public_path('uploads/business-advisor/experience/' . $value->vImage)))
                                                                    @php
                                                                    $current_image = 'uploads/business-advisor/experience/'.$value->vImage;
                                                                    @endphp
                                                                @else
                                                                    @php
                                                                    $current_image = 'uploads/default/no-image.png';
                                                                    @endphp
                                                                @endif
                                                              <a target="_blank" href="{{asset($current_image)}}">
                                                                    <img src="{{asset($current_image)}}" alt="{{$value->vImage}}" class="imgese" height="100px">
                                                                    <a href="javascript:;" class="delete_document clear-btn" data-id="{{$value->iDocumentId}}">
                                                                       <i class="fal fa-times"></i>
                                                                    </a>
                                                              </a>
                                                        </li>
                                                        @endif
                                                     @endforeach
                                                @endif
                                               </ul>
                                            </div>
                                            <!-- close display image code -->
                                        </div>

                                        <div class="col-md-6 positon-relative padding-top-sixten">
                                            <input type="file" name="file_experience_documents[]" id="file_experience_documents" class="d-none" accept="image/png, image/jpeg">
                                            <div id="experience_documents_dropzone" name='experience_documents_dropzone' class="dropzone experience-dropzone"></div>
                                        </div>

                                        <div class="col-md-12 positon-relative no-floting-back">
                                            <div class="advisor-floting">
                                                <label for="tDescription">Discription</label>
                                                <textarea class="form-control" id="tDescription" name="tDescription" placeholder="Please describe your self" style="height: 100px">@if (isset($advisor)){{ $advisor->tDescription }}@endif</textarea>
                                                <div class="validination-info">
                                                    <i class=""></i>
                                                </div>
                                            </div>
                                            <div id="tDescription_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please describe your self. </div>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="col-md-12 positon-relative mt-4">
                                          @php
                                           $current_image = '';
                                                $current_image_status = '';
                                                $image_name = '';
                                                if (isset($my_advisor_profile->new_image->vImage)) {
                                                    $image_name = $my_advisor_profile->new_image->vImage;
                                                }
                                            @endphp
                                            @if (!empty($image_name) && file_exists(public_path('uploads/business-advisor/profile/' . $image_name)) )
                                                @php
                                                    $current_image = 'uploads/business-advisor/profile/' . $image_name;
                                                @endphp
                                            @else
                                                @php
                                                    $current_image_status = 'w-100';
                                                    $current_image = 'uploads/no-image.png';
                                                @endphp
                                            @endif
                                        
                                            <label for="cropzee-input" class="image-previewer new-image-block-section" data-cropzee="cropzee-input" >
                                                <img id="img" class="d-block" width="300px" height="200px" src="{{ asset($current_image) }}"></label>
                                                <div class="new-custom-img-box">
                                                    <span class="image-up-logo"><i class="fal fa-edit"></i></span>
                                            <input class="img-upload-file-type" id="cropzee-input" name="file_advisor_profile_image[]" type="file" accept="image/*">
                                            <input type="hidden"  id="get_cropped_image" name="get_cropped_image">
                                            </div>
                                       <!--  <input type="file" name="file_investor_profile_image[]" id="file_investor_profile_image" class="d-none" accept="image/png, image/jpeg">
                                        <div id="file_investor_profile_image_dropzone" name='file_investor_profile_image_dropzone' class="dropzone education-dropzon"></div> -->
                                    </div>
                                    <lable class="save-detail submit"><a href="javascript:;">Save</a></lable>
                                    
                                    <a href="javascript:;" class="btn btn-primary loading" style="display: none;"></a>
                                </form>

                                <div class="secondary-chat col-12 d-lg-none d-block" >
                                    <div>
                                        @if ($session_data !== '')
                                            @include('layouts.front.chat_inbox_connection_listing')
                                        @endif
                                    </div>
                                </div>
                                
                        <!-- End frist step -->
                    </div> {{-- end col-lg-9 --}}
                </div> {{-- End row --}}
                
            </div> {{-- End container --}}
        </div> {{-- End add-step-detail --}}
    </section>
@endsection
@section('custom-js')

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>

    <script>
        var error_class = "fas fa-exclamation-circle";
        var success_class = "fas fa-check-circle";
        var datePicker = $('#dDob');
        var upload_url = '{{ url('advisor-upload') }}';
        var error = false;
        Dropzone.autoDiscover = false;
        var docString = '';
        const experience_documents_dropzone = document.getElementById('experience_documents_dropzone');
        const file_experience_documents = document.getElementById('file_experience_documents');

        const education_documents_dropzone = document.getElementById('education_documents_dropzone');
        const file_education_documents = document.getElementById('file_education_documents');
        file_up_names=[];

        datePicker.datepicker({
            format: 'dd-MM-yyyy',
            autoclose: true,
            endDate: '+0d',
        });

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        var dropzone = new Dropzone('#experience_documents_dropzone', {
            thumbnailWidth: 200,
            parallelUploads: 10,
            dictDefaultMessage: "Upload Experience docuements",
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

                url="{{ url('advisor-delete-document') }}";
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
                'type': 'experience'
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
        experience_documents_dropzone.addEventListener('drop', event => {
            event.preventDefault();
            let files1 = event.dataTransfer.files;
            file_experience_documents.files = files1;
            // console.log('added ' + files1.length + ' files');
        });

        var dropzone = new Dropzone('#education_documents_dropzone', {
            thumbnailWidth: 200,
            parallelUploads: 10,
            dictDefaultMessage: "Upload Education docuements",
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

                url="{{ url('advisor-delete-document') }}";
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
                'type': 'education_document'
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
        education_documents_dropzone.addEventListener('drop', event => {
            event.preventDefault();
            let files1 = event.dataTransfer.files;
            file_education_documents.files = files1;
            // console.log('added ' + files1.length + ' files');
        });
/*
        var dropzone = new Dropzone('#file_investor_profile_image_dropzone', {
            thumbnailWidth: 200,
            parallelUploads: 10,
            dictDefaultMessage: "Upload Profile Image",
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            url: upload_url,
            paramName: "file",
            params: {
                'type': 'profile'
            },
            headers: {
                'x-csrf-token': '{{ csrf_token() }}',
            },
            success: function(file, response) {
                docString += response.id + ',';
                $('#documentId').val(docString.slice(0, -1));
            }
        });
        file_investor_profile_image_dropzone.addEventListener('drop', event => {
            event.preventDefault();
            let files1 = event.dataTransfer.files;
            file_investor_profile_image.files = files1;
            // console.log('added ' + files1.length + ' files');
        });*/

        function set_error_icon(targetId = '')
        {
            $("#"+targetId).next().children().addClass(error_class);
        }
        function set_success_icon(targetId = '')
        {
            $("#"+targetId).next().children().removeClass();
            $("#"+targetId).next().children().addClass(success_class);
        }
        $("#country_id").change(function (e) { 
            var iCountryId = $("#country_id").val();
            if (iCountryId.length == 0) 
            {
                $( "#iCountryId" ).addClass('has-error');
                $("#iCountryId_error").show();
                set_error_icon("country_id");
                error = true;
            } else {
                set_success_icon("country_id");
                $("#iCountryId_error").hide();
                $( "#iCountryId" ).removeClass('has-error');
            }
        });
        $("#iRegionId").change(function (e) { 
            var iRegionId = $("#iRegionId").val();
            if (iRegionId.length == 0) 
            {
                $( "#iRegionId" ).addClass('has-error');
                $("#region_id_error").show();
                set_error_icon("iRegionId");
                error = true;
            } else {
                set_success_icon("iRegionId");
                $("#region_id_error").hide();
                $( "#iRegionId" ).removeClass('has-error');
            }
        });
        $("#iCountyId").change(function (e) { 
            var iCountid = $("#iCountyId").val();
            if (iCountid.length == 0) 
            {
                $( "#iCountid" ).addClass('has-error');
                $("#county_id_error").show();
                set_error_icon("iCountyId");
                error = true;
            } else {
                set_success_icon("iCountyId");
                $("#county_id_error").hide();
                $( "#iCountyId" ).removeClass('has-error');
            }
        });
        $("#iSubCountyId").change(function (e) {
            var iSubCountyId = $("#iSubCountyId").val();
            if (iSubCountyId.length == 0) 
            {
                $( "#iSubCountyId" ).addClass('has-error');
                $("#sub_county_id_error").show();
                set_error_icon("iSubCountyId");
                error = true;
            } else {
                set_success_icon("iSubCountyId");
                $("#sub_county_id_error").hide();
                $( "#iSubCountyId" ).removeClass('has-error');
            }
        });
        $(".ProfessionCheckbox").change(function()
          {
            var ProfessionCheckbox = $(".ProfessionCheckbox:checkbox:checked").length;
           if (ProfessionCheckbox <= 0) {
                $("#profession_error").show();
                $("#profession_error").addClass('has-error');
                error = true;
            } else {
                $("#profession_error").hide();
                $("#profession_error").removeClass('has-error');
            }
        });
        /* $('textarea').on('blur', function(e) {
            $('.submit').trigger('click');
        }); */
        
        $(document).on('click', '.submit', function() 
        {
            error = false;
            var vAdvisorProfileTitle = $("#vAdvisorProfileTitle").val();
            if (vAdvisorProfileTitle.length == 0) {
                $("#vAdvisorProfileTitle_error").show();
                $( "#vAdvisorProfileTitle" ).addClass('has-error');
                set_error_icon("vAdvisorProfileTitle");
                error = true;
            } else {
                set_success_icon("vAdvisorProfileTitle");
                $( "#vAdvisorProfileTitle" ).removeClass('has-error');
                $("#vAdvisorProfileTitle_error").hide();
            }
        
            var vCompanyName = $("#vCompanyName").val();
            if (vCompanyName.length == 0) 
            {
                $("#vCompanyName_error").show();
                $( "#vCompanyName" ).addClass('has-error');
                set_error_icon("vCompanyName");
                error = true;
            } else {
                set_success_icon("vCompanyName");
                $( "#vCompanyName" ).removeClass('has-error');
                $("#vCompanyName_error").hide();
            }
        
            var vFirstName = $("#vFirstName").val();
            if (vFirstName.length == 0) 
            {
                $("#vFirstName_error").show();
                $( "#vFirstName" ).addClass('has-error');
                set_error_icon("vFirstName");
                error = true;
            } else {
                set_success_icon("vFirstName");
                $( "#vFirstName" ).removeClass('has-error');
                $("#vFirstName_error").hide();
            }
        
            var vLastName = $("#vLastName").val();
            if (vLastName.length == 0) 
            {
                $("#vLastName_error").show();
                $( "#vLastName" ).addClass('has-error');
                set_error_icon("vLastName");
                error = true;
            } else {
                set_success_icon("vLastName");
                $( "#vLastName" ).removeClass('has-error');
                $("#vLastName_error").hide();
            }
        
            var vPhone = $("#vPhone").val();
            if (vPhone.length == 0) 
            {
                $("#vPhone_error").show();
                $( "#vPhone" ).addClass('has-error');
                set_error_icon("vPhone");
                error = true;
            } else {
                set_success_icon("vPhone");
                $( "#vPhone" ).removeClass('has-error');
                $("#vPhone_error").hide();
            }
        
            var tAdvisorProfileDetail = $("#tAdvisorProfileDetail").val();
            if (tAdvisorProfileDetail.length == 0) 
            {
                $("#tAdvisorProfileDetail_error").show();
                $( "#tAdvisorProfileDetail" ).addClass('has-error');
                set_error_icon("tAdvisorProfileDetail");
                error = true;
            } else {
                set_success_icon("tAdvisorProfileDetail");
                $( "#tAdvisorProfileDetail" ).removeClass('has-error');
                $("#tAdvisorProfileDetail_error").hide();
            }
        
            var vEmail = $("#vEmail").val();
            if (vEmail.length == 0) {
                $("#vEmail_error").show()
                ;
                $("#vEmail_valid_error").hide();
                $( "#vEmail" ).addClass('has-error');
                set_error_icon("vEmail");
                error = true;
            } else {
                if (validateEmail(vEmail)) {
                    set_success_icon("vEmail");
                    $("#vEmail_valid_error").hide();
                    $("#vEmail_error").hide();
                    $( "#vEmail" ).removeClass('has-error');
                } else 
                {
                    $("#vEmail_error").hide();
                    $( "#vEmail" ).addClass('has-error');
                    set_error_icon("vEmail");
                    error = true;
                }
            }                    
        
            var dDob = $("#dDob").val();
            if (dDob.length == 0) 
            {
                $("#dDob_error").show();
                $( "#dDob" ).addClass('has-error');
                set_error_icon("dDob");
                error = true;
            } else {
                set_success_icon("dDob");
                $("#dDob_error").hide();
                $( "#dDob" ).removeClass('has-error');
            }
        
            var vIdentificationNo = $("#vIdentificationNo").val();
            if (vIdentificationNo.length == 0) 
            {
                $("#vIdentificationNo_error").show();
                $( "#vIdentificationNo" ).addClass('has-error');
                set_error_icon("vIdentificationNo");
                error = true;
            } else {
                set_success_icon("vIdentificationNo");
                $("#vIdentificationNo_error").hide();
                $( "#vIdentificationNo" ).removeClass('has-error');
            }
        
            var iCost = $("#iCost").val();
            if (iCost.length == 0) 
            {
                $("#iCost_error").show();
                $( "#iCost" ).addClass('has-error');
                set_error_icon("iCost");
                error = true;
            } else {
                set_success_icon("iCost");
                $( "#iCost" ).removeClass('has-error');
                $("#iCost_error").hide();
            }
        
             var ProfessionCheckbox = $(".ProfessionCheckbox:checkbox:checked").length;
            if (ProfessionCheckbox <= 0) {
                $("#profession_error").show();
                $("#profession_error").addClass('has-error');
                error = true;
            } else {
                $("#profession_error").hide();
                $("#profession_error").removeClass('has-error');
            }
        

            var tBio = $("#tBio").val();
            if (tBio.length == 0) 
            {
                $("#tBio_error").show();
                $( "#tBio" ).addClass('has-error');
                set_error_icon("tBio");
                error = true;
            } else {
                set_success_icon("tBio");
                $("#tBio_error").hide();
                $( "#tBio" ).removeClass('has-error');
            }
        
            var tEducationDetail = $("#tEducationDetail").val();
            if (tEducationDetail.length == 0) 
            {
                $("#tEducationDetail_error").show();
                $( "#tEducationDetail" ).addClass('has-error');
                set_error_icon("tEducationDetail");
                error = true;
            } else {
                set_success_icon("tEducationDetail");
                $("#tEducationDetail_error").hide();
                $( "#tEducationDetail" ).removeClass('has-error');
            }
        
            var vExperince = $("#vExperince").val();
            if (vExperince.length == 0) 
            {
                $("#vExperince_error").show();
                $( "#vExperince" ).addClass('has-error');
                set_error_icon("vExperince");
                error = true;
            } else {
                set_success_icon("vExperince");
                $("#vExperince_error").hide();
                $( "#vExperince" ).removeClass('has-error');
            }
        
            var tDescription = $("#tDescription").val();
            if (tDescription.length == 0) 
            {
                $("#tDescription_error").show();
                $( "#tDescription" ).addClass('has-error');
                set_error_icon("tDescription");
                error = true;
            } else {
                set_success_icon("tDescription");
                $("#tDescription_error").hide();
                $( "#tDescription" ).removeClass('has-error');
            }
            var iCountryId = $("#country_id").val();
            if (iCountryId.length == 0) 
            {
                $( "#iCountryId" ).addClass('has-error');
                $("#iCountryId_error").show();
                set_error_icon("country_id");
                error = true;
            } else {
                set_success_icon("country_id");
                $("#iCountryId_error").hide();
                $( "#iCountryId" ).removeClass('has-error');
            }
        
            var iRegionId = $("#iRegionId").val();
            if (iRegionId.length == 0) 
            {
                $( "#iRegionId" ).addClass('has-error');
                $("#region_id_error").show();
                set_error_icon("iRegionId");
                error = true;
            } else {
                set_success_icon("iRegionId");
                $("#region_id_error").hide();
                $( "#iRegionId" ).removeClass('has-error');
            }
        
            var iCountid = $("#iCountyId").val();
            if (iCountid.length == 0) 
            {
                $( "#iCountid" ).addClass('has-error');
                $("#county_id_error").show();
                set_error_icon("iCountyId");
                error = true;
            } else {
                set_success_icon("iCountyId");
                $("#county_id_error").hide();
                $( "#iCountyId" ).removeClass('has-error');
            }
        
            var iSubCountyId = $("#iSubCountyId").val();
            if (iSubCountyId.length == 0) 
            {
                $( "#iSubCountyId" ).addClass('has-error');
                $("#sub_county_id_error").show();
                set_error_icon("iSubCountyId");
                error = true;
            } else {
                set_success_icon("iSubCountyId");
                $("#sub_county_id_error").hide();
                $( "#iSubCountyId" ).removeClass('has-error');
            }
        
            var industriesId = $("#industries").val();
            if (industriesId.length == 0) 
            {
                $( "#industries" ).addClass('has-error');
                $("#industries_error").show();
                $("#industriesError").addClass('fas fa-exclamation-circle');                
                error = true;
            } else {
                $("#industries_error").hide();
                $("#industries").removeClass('has-error');
                $("#industriesError").removeClass('fas fa-exclamation-circle');                
                $("#industriesError").addClass('fas fa-check-circle');
            }
            
            setTimeout(function() {
                if (error == true) 
                {
                    $(".has-error").first().focus();
                    return false;
                } else {
                    $("#frm").submit(); 
                    $('.submit').hide();
                    $('.loading').show();
                    return true;
                }
            }, 1000);
        });

        /* Start Individual Validation */
        $(document).on('change blur', '#vAdvisorProfileTitle', function() {
                var vAdvisorProfileTitle = $("#vAdvisorProfileTitle").val();
                if (vAdvisorProfileTitle.length == 0) {
                    $("#vAdvisorProfileTitle_error").show();
                    $( "#vAdvisorProfileTitle" ).addClass('has-error');
                    set_error_icon("vAdvisorProfileTitle");
                    error = true;
                } else {
                    set_success_icon("vAdvisorProfileTitle");
                    $( "#vAdvisorProfileTitle" ).removeClass('has-error');
                    $("#vAdvisorProfileTitle_error").hide();
                }
        });
        $(document).on('change blur', '#vCompanyName', function() {
             var vCompanyName = $("#vCompanyName").val();
            if (vCompanyName.length == 0) 
            {
                $("#vCompanyName_error").show();
                $( "#vCompanyName" ).addClass('has-error');
                set_error_icon("vCompanyName");
                error = true;
            } else {
                set_success_icon("vCompanyName");
                $( "#vCompanyName" ).removeClass('has-error');
                $("#vCompanyName_error").hide();
            }
        });
        $(document).on('change blur', '#vFirstName', function() {
            var vFirstName = $("#vFirstName").val();
            if (vFirstName.length == 0) 
            {
                $("#vFirstName_error").show();
                $( "#vFirstName" ).addClass('has-error');
                set_error_icon("vFirstName");
                error = true;
            } else {
                set_success_icon("vFirstName");
                $( "#vFirstName" ).removeClass('has-error');
                $("#vFirstName_error").hide();
            }
        });
        $(document).on('change blur', '#vLastName', function() {
                var vLastName = $("#vLastName").val();
                if (vLastName.length == 0) 
                {
                    $("#vLastName_error").show();
                    $( "#vLastName" ).addClass('has-error');
                    set_error_icon("vLastName");
                    error = true;
                } else {
                    set_success_icon("vLastName");
                    $( "#vLastName" ).removeClass('has-error');
                    $("#vLastName_error").hide();
                }
        });
        $(document).on('change blur', '#vPhone', function() {
                var vPhone = $("#vPhone").val();
                if (vPhone.length == 0) 
                {
                    $("#vPhone_error").show();
                    $( "#vPhone" ).addClass('has-error');
                    set_error_icon("vPhone");
                    error = true;
                } else {
                    set_success_icon("vPhone");
                    $( "#vPhone" ).removeClass('has-error');
                    $("#vPhone_error").hide();
                }
        });
        $(document).on('change blur', '#tAdvisorProfileDetail', function() {
           var tAdvisorProfileDetail = $("#tAdvisorProfileDetail").val();
            if (tAdvisorProfileDetail.length == 0) 
            {
                $("#tAdvisorProfileDetail_error").show();
                $( "#tAdvisorProfileDetail" ).addClass('has-error');
                set_error_icon("tAdvisorProfileDetail");
                error = true;
            } else {
                set_success_icon("tAdvisorProfileDetail");
                $( "#tAdvisorProfileDetail" ).removeClass('has-error');
                $("#tAdvisorProfileDetail_error").hide();
            }
        });
        $(document).on('change blur', '#vEmail', function() {
             var vEmail = $("#vEmail").val();
            if (vEmail.length == 0) {
                $("#vEmail_error").show()
                ;
                $("#vEmail_valid_error").hide();
                $( "#vEmail" ).addClass('has-error');
                set_error_icon("vEmail");
                error = true;
            } else {
                if (validateEmail(vEmail)) {
                    set_success_icon("vEmail");
                    $("#vEmail_valid_error").hide();
                    $("#vEmail_error").hide();
                    $( "#vEmail" ).removeClass('has-error');
                } else 
                {
                    $("#vEmail_error").hide();
                    $( "#vEmail" ).addClass('has-error');
                    set_error_icon("vEmail");
                    error = true;
                }
            }
        });
        $(document).on('change blur', '#dDob', function() {
             var dDob = $("#dDob").val();
            if (dDob.length == 0) 
            {
                $("#dDob_error").show();
                $( "#dDob" ).addClass('has-error');
                set_error_icon("dDob");
                error = true;
            } else {
                set_success_icon("dDob");
                $("#dDob_error").hide();
                $( "#dDob" ).removeClass('has-error');
            }
        });
        $(document).on('change blur', '#vIdentificationNo', function() {
            var vIdentificationNo = $("#vIdentificationNo").val();
            if (vIdentificationNo.length == 0) 
            {
                $("#vIdentificationNo_error").show();
                $( "#vIdentificationNo" ).addClass('has-error');
                set_error_icon("vIdentificationNo");
                error = true;
            } else {
                set_success_icon("vIdentificationNo");
                $("#vIdentificationNo_error").hide();
                $( "#vIdentificationNo" ).removeClass('has-error');
            }
        });
        $(document).on('change blur', '#iCost', function() {
             var iCost = $("#iCost").val();
            if (iCost.length == 0) 
            {
                $("#iCost_error").show();
                $( "#iCost" ).addClass('has-error');
                set_error_icon("iCost");
                error = true;
            } else {
                set_success_icon("iCost");
                $( "#iCost" ).removeClass('has-error');
                $("#iCost_error").hide();
            }
        });
        $(document).on('blur', '#country_id', function() {
           var iCountryId = $("#country_id").val();
            if (iCountryId.length == 0) 
            {
                $( "#iCountryId" ).addClass('has-error');
                $("#iCountryId_error").show();
                set_error_icon("country_id");
                error = true;
            } else {
                set_success_icon("country_id");
                $("#iCountryId_error").hide();
                $( "#iCountryId" ).removeClass('has-error');
            }
        });
        $(document).on('blur', '#iRegionId', function() {
            var iRegionId = $("#iRegionId").val();
            if (iRegionId.length == 0) 
            {
                $( "#iRegionId" ).addClass('has-error');
                $("#region_id_error").show();
                set_error_icon("iRegionId");
                error = true;
            } else {
                set_success_icon("iRegionId");
                $("#region_id_error").hide();
                $( "#iRegionId" ).removeClass('has-error');
            }
        });
        $(document).on('blur', '#iCountyId', function() {
             var iCountid = $("#iCountyId").val();
            if (iCountid.length == 0) 
            {
                $( "#iCountid" ).addClass('has-error');
                $("#county_id_error").show();
                set_error_icon("iCountyId");
                error = true;
            } else {
                set_success_icon("iCountyId");
                $("#county_id_error").hide();
                $( "#iCountyId" ).removeClass('has-error');
            }
        });
        $(document).on('blur', '#iSubCountyId', function() {
            var iSubCountyId = $("#iSubCountyId").val();
            if (iSubCountyId.length == 0) 
            {
                $( "#iSubCountyId" ).addClass('has-error');
                $("#sub_county_id_error").show();
                set_error_icon("iSubCountyId");
                error = true;
            } else {
                set_success_icon("iSubCountyId");
                $("#sub_county_id_error").hide();
                $( "#iSubCountyId" ).removeClass('has-error');
            }
        });
        $(document).on('change blur', '#industries', function() {
            var industriesId = $("#industries").val();
            if (industriesId.length == 0) 
            {
                $( "#industries" ).addClass('has-error');
                $("#industries_error").show();
                $("#industriesError").addClass('fas fa-exclamation-circle');                
                error = true;
            } else {
                $("#industries_error").hide();
                $( "#industries").removeClass('has-error');
                $("#industriesError").removeClass('fas fa-exclamation-circle');                
                $("#industriesError").addClass('fas fa-check-circle');
            }
        });
        $(document).on('change blur', '#tBio', function() {
             var tBio = $("#tBio").val();
            if (tBio.length == 0) 
            {
                $("#tBio_error").show();
                $( "#tBio" ).addClass('has-error');
                set_error_icon("tBio");
                error = true;
            } else {
                set_success_icon("tBio");
                $("#tBio_error").hide();
                $( "#tBio" ).removeClass('has-error');
            }
        });
        $(document).on('change blur', '#tEducationDetail', function() {
            var tEducationDetail = $("#tEducationDetail").val();
            if (tEducationDetail.length == 0) 
            {
                $("#tEducationDetail_error").show();
                $( "#tEducationDetail" ).addClass('has-error');
                set_error_icon("tEducationDetail");
                error = true;
            } else {
                set_success_icon("tEducationDetail");
                $("#tEducationDetail_error").hide();
                $( "#tEducationDetail" ).removeClass('has-error');
            }
        });
        $(document).on('change blur', '#vExperince', function() {
            var vExperince = $("#vExperince").val();
            if (vExperince.length == 0) 
            {
                $("#vExperince_error").show();
                $( "#vExperince" ).addClass('has-error');
                set_error_icon("vExperince");
                error = true;
            } else {
                set_success_icon("vExperince");
                $("#vExperince_error").hide();
                $( "#vExperince" ).removeClass('has-error');
            }
        });
        $(document).on('change blur', '#tDescription', function() {
             var tDescription = $("#tDescription").val();
            if (tDescription.length == 0) 
            {
                $("#tDescription_error").show();
                $( "#tDescription" ).addClass('has-error');
                set_error_icon("tDescription");
                error = true;
            } else {
                set_success_icon("tDescription");
                $("#tDescription_error").hide();
                $( "#tDescription" ).removeClass('has-error');
            }
        });
        /* End Individual Validation */
        
        $(document).ready(function() 
        {
            $("#cropzee-input").cropzee({startSize: [85, 85, '%'],});

            /* $('#locations').select2({
                closeOnSelect: false,
                placeholder: "Select Location",
                allowClear: true,
                tags: true,
                maximumSelectionLength: 5
            }); */

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
                    $("#iSubCountyId").trigger("blur");
                }, 4000);   
            }
        });

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
                        // console.log(result);
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

        function validateEmail(sEmail) {
            var filter =
                /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (filter.test(sEmail)) {
                return true;
            } else {
                return false;
            }
        }

        function next_div(next, previous) {
            $('#' + previous + '-step').hide();
            $('#' + next + '-step').show();

            $('#' + previous + '-tab').removeClass('active');
            $('#' + next + '-tab').addClass('active');
        }

        $('.numeric').keyup(function(e)
        {
            if (/\D,/g.test(this.value)) {
                this.value = this.value.replace(/\D/g, '');
            }
        });
        $('.money').mask("000,000,000,000,000,000,000,000,000", {reverse: true});
 function error_focus()
        {
            $(".has-error").first().focus();
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
          iDocumentId = $(this).data("id");
          
          url = "{{ url('advisor-delete-document') }}";
          setTimeout(function(){
            $.ajax({
              url: url,
              type: "POST",
              data:  {iDocumentId:iDocumentId,_token: '{{ csrf_token() }}'}, 
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

const ele = document.getElementById('tDescription');
ele.addEventListener('keydown', function (e) {
    // Get the code of pressed key
    const keyCode = e.which || e.keyCode;

    // 13 represents the Enter key
    if (keyCode === 13) {
        console.log('etet');
        // Don't generate a new line
        e.preventDefault();
    e.preventDefault();
    this.value = this.value.substring(0, this.selectionStart) + "" + "\n" + this.value.substring(this.selectionEnd, this.value.length);
    }
});
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  
@endsection
