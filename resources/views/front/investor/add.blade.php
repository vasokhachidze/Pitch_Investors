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
</style>
    <section class="add-edit-detail lite-gray investor-edit-detail">
        <div class="adit-detail-step">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="steps-in">
                            <ul>
                                <li><a id="first-tab" data-id='first-step' class="active investorHeader">Profile</a></li>
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
        <div class="add-step-detail">
            <div class="container">
                <div class="row">
                    @include('layouts.front.left_dashboard')
                    <div class="col-lg-9">
                        <form action="{{ url('investor-store') }}" name="frm" id="frm" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if(isset($investor)){{$investor->vUniqueCode}}@endif">
                            <input type="hidden" id="iTempId" name="iTempId" value="@if (isset($iTempId)){{$iTempId}}@endif">
                            <input type="hidden" id="iInvestorProfileId" name="iInvestorProfileId" value="@if (isset($investor->iInvestorProfileId)){{$investor->iInvestorProfileId}}@endif">
                            <!-- frist-step -->
                            <div id="first-step" class="other-detail investor_forms first-steps">
                                
                                    <h5>{{ isset($investor) ? 'Edit' : 'Add' }} Investors</h5>
                                    <div class="main-text">
                                        <h3>Are you an investor looking for an investment opportunity?</h3>
                                        <p style="text-align: justify;"> Are you looking to find a way to grow your wealth over time while minimizing risk? PitchInvestors offers a range of investment options that are carefully selected to meet the needs of investors like you. Whether you seek a long-term investment or a shorter-term opportunity, we have something to suit your needs. Explore our offerings today and take the first step towards achieving your financial goals.</p>

                                        <div class="image-avtar">
                                            <img src="{{ asset('uploads/front/investor/profile1.png') }}" alt="">
                                        </div>
                                    </div>
                                

                                <div class="detail-form">
                                    <div class="row">
                                        <div class="col-md-12 positon-relative">
                                            <div>
                                                <label for="floatingFirstname">Profession</label>
                                                <input type="text" class="form-control" id="vProfileTitle" name="vProfileTitle" placeholder="Profession" value="@if(isset($investor)){{$investor->vProfileTitle}}@endif">
                                                  <div class="validination-info">
                                                    <i class="" id="vProfileTitleError"></i>
                                                  </div>
                                                <div id="vProfileTitle_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter Profession </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 positon-relative">
                                            <div>
                                                <label for="floatingFirstname">First name</label>
                                                <input type="text" class="form-control" id="vFirstName" name="vFirstName" placeholder="First name" value="@if(isset($investor)){{$investor->vFirstName}}@elseif(!empty($loginuserdata)) {{$loginuserdata->vFirstName}}@else{{$session_data['vFirstName']}}@endif">
                                                    <div class="validination-info">
                                                        <i class="" id="fNameError"></i>
                                                    </div>
                                                <div id="vFirstName_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter First Name </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 positon-relative">
                                            <div>
                                                <label for="floatingLastname">Last name</label>
                                                <input type="text" class="form-control" id="vLastName" name="vLastName" placeholder="Last name" value="@if(isset($investor)){{$investor->vLastName}}@elseif(!empty($loginuserdata)) {{$loginuserdata->vLastName}}@else{{$session_data['vLastName']}}@endif">
                                                 <div class="validination-info">
                                                    <i class="" id="lNameError"></i>
                                                </div>
                                                <div id="vLastName_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter Last Name </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 positon-relative">
                                            <div class="dob-calender">
                                                <label for="floatingDOB">DOB</label>
                                                <input type="text" class="form-control" id="dDob" name="dDob" placeholder="DOB" value="@if(isset($investor)){{date('d-F-Y',strtotime($investor->dDob))}}@elseif(!empty($userData)) {{ date('d-F-Y', strtotime($userData->dDob)) }}@endif">
                                                <div class="validination-info">
                                                    <i class="" id="DOBError"></i>
                                                </div>
                                                <div id="dDob_error" class="error mt-1" style="color:red;display: none; font-size: small;">
                                                    Please Enter Date of Birth </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 positon-relative">
                                            <div>
                                                <label for="floatingEmail">Email</label>
                                                <input type="text" class="form-control" id="vEmail" name="vEmail" placeholder="Email" value="@if(isset($investor)){{$investor->vEmail}}@else{{$session_data['vEmail']}}@endif">
                                                <div class="validination-info">
                                                    <i class="" id="vEmailError"></i>
                                                </div>
                                                <div id="vEmail_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter Email </div>
                                                <div id="vEmail_valid_error" class="error_show" style="color:red;display: none; font-size: small;">Please Enter Valid Email</div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 positon-relative">
                                            <div>
                                                <label for="floatingPhoneNo">Phone No.</label>
                                                <input type="text" class="form-control numeric" minlength="10" maxlength="10" id="vPhone" name="vPhone" placeholder="Phone No." value="@if(isset($investor)){{$investor->vPhone}}@elseif(!empty($loginuserdata)) {{$loginuserdata->vPhone}}@else{{$session_data['vPhone']}}@endif">
                                                <div class="validination-info">
                                                    <i class="" id="vPhoneError"></i>
                                                </div>
                                                <div id="vPhone_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter Phone No. </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 positon-relative">
                                            <div>
                                                <label for="floatingIdentification No">Identification No</label>
                                                <input type="text" class="form-control" id="vIdentificationNo" name="vIdentificationNo" placeholder="Identification No" value="@if (isset($investor)) {{ $investor->vIdentificationNo }}@elseif(!empty($userData)) {{$userData->vIdentificationNo}}@endif">
                                                <div class="validination-info">
                                                    <i class="" id="vIdentificationNoError"></i>
                                                </div>
                                                <div id="vIdentificationNo_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter Identification No. </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 positon-relative">
                                            <div>
                                            <label for="floatingAddress">Address</label>
                                                <input type="text" class="form-control" id="vAddress" name="vAddress" placeholder="Address" value="@if (isset($investor)) {{ $investor->vAddress }} @endif">
                                                <div class="validination-info">
                                                    <i class="" id="vAddressError"></i>
                                                </div>
                                                <div id="vAddress_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter Address </div>
                                            </div>
                                        </div>

                                        {{-- <div class="col-md-6">
                                        </div> --}}

                                        <div class="col-md-6 positon-relative">
                                            <label>Investor Nationality</label>
                                            <select class="form-select" aria-label="Default select example" id="iNationality" name="iNationality">
                                                <option value="">Select Nationality</option>
                                                @foreach ($countries as $value)
                                                    @if(!empty($value->vNationality))
                                                        <option value="{{ $value->iCountryId }}" @if (isset($investor)) @if ($investor->iNationality == $value->iCountryId) selected @endif @endif>{{ $value->vNationality }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="validination-info">
                                                <i class="" id="iNationalityError"></i>
                                            </div>
                                            <div id="iNationality_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Select Nationality</div>
                                        </div>

                                        <div class="col-md-6 positon-relative">
                                            <label>Investor City</label>
                                            <input type="text" class="form-control" id="iCity" name="iCity" placeholder="City" value="@if (isset($investor)) {{ $investor->iCity }} @endif">
                                            <!-- <select class="form-select" aria-label="Default select example" id="iCity" name="iCity">
                                                <option value="">Select City</option>
                                                @foreach ($subRegion as $value)
                                                    <option value="{{ $value->iSubCountId }}" @if (isset($investor)) @if ($investor->iCity == $value->iSubCountId) selected @endif @endif>{{ $value->vTitle }}</option>
                                                @endforeach
                                            </select> -->
                                            <div class="validination-info">
                                                <i class="" id="iCityError"></i>
                                            </div>
                                            <div id="iCity_error" class="error mt-1" style="color:red;display: none; font-size: small;">
                                                Please Enter City</div>
                                        </div>

                                        <div class="col-md-12 mt-4">
                                            <label class="mb-1">Upload ID (Driving Licence, Passport)</label>
                                            <div class="custom-upload-inner1"><br>
                                                <input type="hidden" name="documentId" id="documentId">
                                                <div id="identification_photo_dropzone" name='identification_photo_dropzone' class="dropzone"></div>
                                                <input type="file" name="file_identification_photo[]" id="file_identification_photo" class="d-none">
                                            </div>
                                        </div>
                                    </div>
                                        <!-- start display image code -->
                                        <div class="file-upload-img">
                                            <ul>
                                            @if(!empty($image_data)) 
                                                @foreach ($image_data as $value)
                                                @if($value->eType == 'identification_photo')
                                                    <li class="img-upload">
                                                          @php
                                                            $current_image = '';
                                                            @endphp
                                                            @if(!empty($value->vImage) && file_exists(public_path('uploads/investor/identification_photo/' . $value->vImage)))
                                                                @php
                                                                $current_image = 'uploads/investor/identification_photo/'.$value->vImage;
                                                                @endphp
                                                            @else
                                                                @php
                                                                $current_image = 'uploads/default/no-image.png';
                                                                @endphp
                                                            @endif
                                                          <a target="_blank" href="{{asset($current_image)}}">
                                                                <img src="{{asset($current_image)}}" alt="{{$value->vImage}}" class="imgese" height="100px">
                                                                <a href="javascript:;" class="delete_document clear-btn" data-id="{{$value->iInvestorDocId}}">
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
                            </div>

                            <!-- second step -->
                            <div id="second-step" class="other-detail investor_forms second-steps">
                                <div class="detail-form">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 positon-relative">
                                            <div>
                                                <label for='vInvestorProfileName'>Investor Profile Name</label>
                                                <input type="text" name="vInvestorProfileName" id="vInvestorProfileName" class="form-control" placeholder="Enter Investor Profile Name" value="@if (isset($investor)){{$investor->vInvestorProfileName}}@endif">
                                                <div class="validination-info">
                                                    <i class="" id="vInvestorProfileNameError"></i>
                                                </div>
                                                <div id="vInvestorProfileName_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter Investor Profile Name </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 positon-relative">
                                            <div>
                                                <label for="tInvestorProfileDetail">Investor Profile Detail</label>
                                                <input type="text" name="tInvestorProfileDetail" id="tInvestorProfileDetail" class="form-control" placeholder="Enter Investor Profile Detail" value="@if (isset($investor)) {{ $investor->tInvestorProfileDetail }} @endif">
                                                 <div class="validination-info">
                                                    <i class="" id="tInvestorProfileDetailError"></i>
                                                </div>
                                                <div id="tInvestorProfileDetail_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter Investor Profile Detail </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 positon-relative">
                                            <label>Are You</label>
                                            <ul class="select-panal">
                                                <li class="options-select">
                                                    <div class="form-check form-check-inline">
                                                        @php
                                                            $selet1 = '';
                                                        @endphp
                                                        @if (isset($investor))
                                                            @if ($investor->eInvestorType == 'Individual')
                                                                @php
                                                                    $selet1 = 'checked';
                                                                @endphp
                                                            @endif
                                                        @endif

                                                        <input class="form-check-input" type="radio"name="eInvestorType" id="individual" value="Individual" {{ $selet1 }}>
                                                        <label class="form-check-label" for="individual">Individual Investor</label>
                                                    </div>
                                                </li>

                                                <li class="options-select">
                                                    <div class="form-check form-check-inline">
                                                        @php
                                                            $selet2 = '';
                                                        @endphp
                                                        @if (isset($investor))
                                                            @if ($investor->eInvestorType == 'Institutional')
                                                                @php
                                                                    $selet2 = 'checked';
                                                                @endphp
                                                            @endif
                                                        @endif
                                                        <input class="form-check-input" type="radio" name="eInvestorType" id="institutional" value="Institutional" {{ $selet2 }}>
                                                        <label class="form-check-label" for="institutional">Institutional Investor</label>
                                                    </div>
                                                </li>
                                            </ul>
                                             
                                            <div id="eInvestorType_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please select Investor type</div>
                                        </div>

                                        <div class="col-md-12 mt-3 positon-relative">                                            
                                            <div>
                                            <label for="tAboutCompany">About your company</label>
                                                <textarea class="form-control no-space-control" placeholder="Leave a comment here" id="tAboutCompany" name="tAboutCompany" style="height: 120px">@if (isset($investor)){{ $investor->tAboutCompany }}@endif</textarea>
                                                <div class="validination-info">
                                                     <i class="" id="tAboutCompanyError"></i>
                                                 </div>
                                                <div id="tAboutCompany_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please describe your company</div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 positon-relative">
                                            <label>Experience in investing ?</label><br>
                                            <div class="form-check form-check-inline">
                                                @php
                                                    $sele = '';
                                                @endphp
                                                @if (isset($investor))
                                                    @if ($investor->eInvestingExp == 'Yes')
                                                        @php
                                                            $sele = 'checked';
                                                        @endphp
                                                    @endif
                                                @endif
                                                <input class="form-check-input" type="radio" id="investingYes" name="eInvestingExp" value="Yes" {{ $sele }}>
                                                <label class="form-check-label" for="investingYes">Yes</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                @php
                                                    $sele1 = '';
                                                @endphp
                                                @if (isset($investor))
                                                    @if ($investor->eInvestingExp == 'No')
                                                        @php
                                                            $sele1 = 'checked';
                                                        @endphp
                                                    @endif
                                                @endif

                                                <input class="form-check-input" type="radio" id="ivestingNo" name="eInvestingExp" value="No" {{ $sele1 }}>
                                                <label class="form-check-label" for="ivestingNo">No</label>
                                            </div>
                                                
                                            <div id="eInvestingExp_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please select your experience</div>
                                        </div>

                                        <div class="col-md-6 ">
                                            <label>Will you need a business advisor to guide you?</label><br>
                                            <div class="form-check form-check-inline">
                                                @php
                                                    $sele2 = '';
                                                @endphp
                                                @if (isset($investor))
                                                    @if ($investor->eAdvisorGuide == 'Yes')
                                                        @php
                                                            $sele2 = 'checked';
                                                        @endphp
                                                    @endif
                                                @endif

                                                <input class="form-check-input" type="radio" id="guideYes" name="eAdvisorGuide" value="Yes" {{ $sele2 }}>
                                                <label class="form-check-label" for="guideYes">Yes</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                @php
                                                    $sele3 = '';
                                                @endphp
                                                @if (isset($investor))
                                                    @if ($investor->eAdvisorGuide == 'No')
                                                        @php
                                                            $sele3 = 'checked';
                                                        @endphp
                                                    @endif
                                                @endif
                                                <input class="form-check-input" type="radio" id="guideNo" name="eAdvisorGuide" value="No" {{ $sele3 }}>
                                                <label class="form-check-label" for="guideNo">No</label>
                                            </div>
                                            <div id="eAdvisorGuide_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please select your guide help</div>
                                        </div>

                                        <div class="col-md-12 mt-3 positon-relative">
                                            <div>
                                                <label for='vCompanyWebsite'>Company website, or LinkedIn profile</label>
                                                <input type="text" id="vCompanyWebsite" name="vCompanyWebsite" class="form-control" placeholder="Company website, or LinkedIn profile" value="@if (isset($investor)) {{ $investor->vCompanyWebsite }} @endif">
                                            </div>
                                            <div class="validination-info">
                                                <i class="" id="vCompanyWebsiteError"></i>
                                            </div>
                                            <div id="vCompanyWebsite_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Enter Company website, or LinkedIn profile</div>
                                        </div>

                                        <div class="col-md-12">
                                            <h6 class="text-center mt-2">OR</h6>
                                            <label for="">Upload Profile Image</label>

                                            <div class="custom-upload-inner1">
                                                <div id="company_document_dropzone" name='company_document_dropzone' class="dropzone"></div>
                                                <input type="file" name="file_company_document[]" id="file_company_document" class="d-none">
                                            </div>
                                        </div>
                                        <!-- start display image code -->
                                        <div class="file-upload-img">
                                            <ul>
                                            @if(!empty($image_data)) 
                                                @foreach ($image_data as $value)
                                                    @if($value->eType == 'profile')
                                                    <li class="img-upload">
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
                                                          <a target="_blank" href="{{asset($current_image)}}">
                                                                <img src="{{asset($current_image)}}" alt="{{$value->vImage}}" class="imgese" height="100px">
                                                                <a href="javascript:;" class="delete_document clear-btn" data-id="{{$value->iInvestorDocId}}">
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
                                </div>
                            </div>

                            <!-- third step -->
                            <div id="third-step" class="other-detail investor_forms thirth-steps">
                                <div class="detail-form">
                                    <div class="row">
                                        <div class="col-lg-12 positon-relative">
                                            <div class="form-group">
                                                <label>Industry</label>
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

                                        <div class="col-lg-4 col-md-6 intersted-part positon-relative">
                                            <label>You are interested in ?</label>
                                            <ul>
                                                <li>
                                                    <label for="eAcquiringBusiness"><input type="checkbox" class="intrestCheckbox" id="eAcquiringBusiness" name="eAcquiringBusiness" value="Yes" @if (isset($investor) and $investor->eAcquiringBusiness == 'Yes') {{ 'checked' }} @endif />
                                                        Acquiring / Buying a Business</label>
                                                </li>
                                                <li>
                                                    <label for="eInvestingInBusiness"><input type="checkbox" class="intrestCheckbox" id="eInvestingInBusiness" name="eInvestingInBusiness" value="Yes" @if (isset($investor) and $investor->eInvestingInBusiness == 'Yes') {{ 'checked' }} @endif />
                                                        Investing in a Business</label>
                                                </li>
                                                <li>
                                                    <label for="eLendingToBusiness"><input type="checkbox" class="intrestCheckbox" id="eLendingToBusiness" name="eLendingToBusiness" value="Yes" @if (isset($investor) and $investor->eLendingToBusiness == 'Yes') {{ 'checked' }} @endif />
                                                        Lending to a Business</label>
                                                </li>
                                                <li>
                                                    <label for="eBuyingProperty"><input type="checkbox" class="intrestCheckbox" id="eBuyingProperty" name="eBuyingProperty" value="Yes" @if (isset($investor) and $investor->eBuyingProperty == 'Yes') {{ 'checked' }} @endif />
                                                        Buying Property</label>
                                                </li> 
                                                <li>
                                                    <label for="eCorporateInvestor"><input type="checkbox" class="intrestCheckbox" id="eCorporateInvestor" name="eCorporateInvestor" value="Yes" @if (isset($investor) and $investor->eCorporateInvestor == 'Yes') {{ 'checked' }} @endif />Corporate Investors</label>
                                                </li>
                                                <li>
                                                    <label for="eVentureCapitalFirms"><input type="checkbox" class="intrestCheckbox" id="eVentureCapitalFirms" name="eVentureCapitalFirms" value="Yes" @if (isset($investor) and $investor->eVentureCapitalFirms == 'Yes') {{ 'checked' }} @endif />Venture Capital Firms</label>
                                                </li>
                                                <li>
                                                    <label for="ePrivateEquityFirms"><input type="checkbox" class="intrestCheckbox" id="ePrivateEquityFirms" name="ePrivateEquityFirms" value="Yes" @if (isset($investor) and $investor->ePrivateEquityFirms == 'Yes') {{ 'checked' }} @endif />Private Equity Firms</label>
                                                </li>
                                                <li>
                                                    <label for="eFamilyOffices"><input type="checkbox" class="intrestCheckbox" id="eFamilyOffices" name="eFamilyOffices" value="Yes" @if (isset($investor) and $investor->eFamilyOffices == 'Yes') {{ 'checked' }} @endif />Family Offices</label>
                                                </li>
                                            </ul>
                                            <div id="intrestIn_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please select your intrest</div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 invest-part">
                                            <label>How much would you like to invest?</label>
                                            <ul>
                                                <li>
                                                    <label for="investment1M">
                                                        <input type="radio" id="investment1M" class="HowMuchInvest" name="vHowMuchInvest" value="100K - 1M" @if (isset($investor) and $investor->vHowMuchInvest == '100K - 1M') {{ 'checked' }} @endif />
                                                        100K - 1M
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="invest5M">
                                                        <input type="radio" id="invest5M"  class="HowMuchInvest" name="vHowMuchInvest" value="1M - 5M" @if (isset($investor) and $investor->vHowMuchInvest == '1M - 5M') {{ 'checked' }} @endif />
                                                        1M - 5M
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="invest10M">
                                                        <input type="radio" id="invest10M" class="HowMuchInvest" name="vHowMuchInvest" value="5M - 10M" @if (isset($investor) and $investor->vHowMuchInvest == '5M - 10M') {{ 'checked' }} @endif />
                                                        5M - 10M
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="invest10+M">
                                                        <input type="radio" id="invest10+M" class="HowMuchInvest" name="vHowMuchInvest" value="10M+" @if (isset($investor) and $investor->vHowMuchInvest == '10M+') {{ 'checked' }} @endif />
                                                        10M+</label>
                                                </li>
                                            </ul>
                                             
                                            <div id="vHowMuchInvest_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please select how much you Invest</div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 time-part">
                                            <label>When do you want to invest?</label>
                                            <ul>
                                                <li>
                                                    @php
                                                        $chk1 = '';
                                                    @endphp
                                                    @if (isset($investor) && $investor->vWhenInvest == 'next12')
                                                        @php
                                                            $chk1 = 'checked';
                                                        @endphp
                                                    @endif

                                                    <label for="whenNext12">
                                                        <input type="checkbox" id="whenNext12" class="whenInvestCheckbox" name="vWhenInvest" value="next12" {{ $chk1 }} />
                                                        Next 12 month
                                                    </label>
                                                </li>
                                                <li>
                                                    @php
                                                        $chk2 = '';
                                                    @endphp
                                                    @if (isset($investor) && $investor->vWhenInvest == 'after12')
                                                        @php
                                                            $chk2 = 'checked';
                                                        @endphp
                                                    @endif
                                                    <label for="whenAfter12">
                                                        <input type="checkbox" id="whenAfter12" class="whenInvestCheckbox" name="vWhenInvest" value="after12" {{ $chk2 }} />
                                                        After 12 month
                                                    </label>
                                                </li>
                                            </ul>
                                            
                                            <div id="vWhenInvest_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please select when you want to Invest
                                            </div>
                                        </div>
                                    
                                        <div class="col-lg-12 positon-relative">
                                            <div>
                                                <label for="tFactorsInBusiness">Factors you look at in a business</label>
                                                <textarea class="form-control no-space-control" placeholder="Leave a comment here" id="tFactorsInBusiness" name="tFactorsInBusiness" style="height: 150px">@if(isset($investor)){{$investor->tFactorsInBusiness}}@endif</textarea>
                                                <div class="validination-info">
                                                   <i class="" id="tFactorsInBusinessError"></i>
                                                 </div>
                                                <div id="tFactorsInBusiness_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please enter factors in business</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- fourth step -->
                            <div id="fourth-step" class="other-detail investor_forms fourth-steps">
                                <div class="detail-form">
                                    <div class="row">
                                        {{-- 
											<div class="col-lg-12 positon-relative">
												<h6 class="top-head">Location</h6>
												<div class="form-group">
													<select name="locations[]" id="locations" class="form-control" style="width: 100%;" multiple="multiple">
														<option></option>
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

															<option class="region_option" value="Region_{{ $value['regionId'] }}-{{ $value['regionName'] }}" {{ $region_select }}>{{ $value['regionName'] }}</option>
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
																			@if ($lvalue->iLocationId == $value2['iSubCountId'] && $lvalue->eLocationType == 'Sub County')
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
																	<option class="subCounty_option" value="Sub County_{{ $value2['iSubCountId'] }}-{{ $value2['subCountyName'] }}" {{ $subcounty_select }}>
																		--{{ $value2['subCountyName'] }}</option>
																@endforeach
															@endforeach
														@endforeach
													</select>
                                                    <div class="validination-info">
                                                         <i class="" id="locationsError"></i>
                                                    </div>
													<div id="locations_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please select location</div>
												</div>
											</div> 
										--}}

                                        {{-- 
                                            <div class="col-lg-6 mt-3 mb-2 form-group border-box-control positon-relative">
                                                <select id="country_id" name="iCountryId" class="form-control">
                                                    <option value="">Select Country</option>
                                                    @foreach ($countries as $value)
                                                        <option value="{{ $value->iCountryId.'_'.$value->vCountry }}" @if (isset($investor)) @if ($selected_location[0]->iLocationId == $value->iCountryId) {{'selected'}} @endif @endif>{{ $value->vCountry }}</option>
                                                    @endforeach
                                                </select>
                                                 <div class="validination-info">
                                                   <i class="" id="iCountryIdError"></i>
                                                 </div>
                                                <div id="iCountryId_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Select Country name</div>
                                            </div>
                                            <input type="hidden" id="selected_region_id" value="@if (isset($selected_location)){{$selected_location[1]->iLocationId.'_'.$selected_location[1]->vLocationName}}@endif">
                                            <div class="col-lg-6 mt-3 mb-2 form-group border-box-control positon-relative">
                                                <select id="iRegionId" name="iRegionId" class="form-control">
                                                    <option value="">Select Region</option>
                                                </select>
                                                <div class="validination-info">
                                                   <i class="" id="iRegionIdError"></i>
                                                 </div>
                                                <div id="region_id_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Select Region name</div>
                                            </div>
                                            <input type="hidden" id="selected_county_id" value="@if (isset($selected_location)){{$selected_location[2]->iLocationId.'_'.$selected_location[2]->vLocationName}}@endif">
                                            <div class="col-lg-6 mt-3 mb-2 form-group border-box-control positon-relative">
                                                <select id="iCountyId" name="iCountyId" class="form-control">
                                                    <option value="">Select County</option>
                                                </select>
                                                <div class="validination-info">
                                                   <i class="" id="iCountyIdError"></i>
                                                 </div>
                                                <div id="county_id_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Select County name</div>
                                            </div>
                                            <input type="hidden" id="selected_sub_county_id" value="@if (isset($selected_location)){{$selected_location[3]->iLocationId.'_'.$selected_location[3]->vLocationName}}@endif">
                                            <div class="col-lg-6 mt-3 mb-2 form-group border-box-control positon-relative">
                                                <select id="iSubCountyId" name="iSubCountyId" class="form-control">
                                                    <option value="">Select Sub County</option>
                                                </select>
                                                <div class="validination-info">
                                                   <i class="" id="iSubCountyIdError"></i>
                                                 </div>
                                                <div id="sub_county_id_error" class="error mt-1" style="color:red;display: none; font-size: small;">Please Select Sub County name</div>
                                            </div>
                                        --}}

                                    </div>
                                    <div class="term-accpet" style="margin-bottom:20px">
                                        <ul>
                                            <li>
                                                <label>
                                                    <span style="margin-right:5px"><input onclick='$("#termsrule_error").hide();' class = "terms_conditions" type="checkbox" value="1" @if(isset($investor)){{'checked'}}@endif /></span>
                                                    I confirm that the information provided in my investor profile is accurate and up-to-date.
                                                </label>
                                            </li>                                                
                                            <li>
                                                <label>
                                                    <span style="margin-right:5px"><input onclick='$("#termsrule_error").hide();' class = "terms_conditions" type="checkbox"  value="1" @if(isset($investor)){{'checked'}}@endif /></span>
                                                    I acknowledge that the due diligence performed by PitchInvestors is not a substitute for my own assessment of the investment opportunities.
                                                </label>
                                            </li>
                                            <li>
                                                <label>
                                                    <span style="margin-right:5px"><input onclick='$("#termsrule_error").hide();' class = "terms_conditions" type="checkbox" value="1" @if(isset($investor)){{'checked'}}@endif /></span>
                                                    I agree to use the information and reports provided by PitchInvestors solely for the purpose of evaluating investment opportunities on the platform.
                                                </label>
                                            </li>
                                            <li>
                                                <label>
                                                    <span style="margin-right:5px"><input onclick='$("#termsrule_error").hide();' class = "terms_conditions" type="checkbox" value="1" @if(isset($investor)){{'checked'}}@endif /></span>
                                                    I understand that my investments on PitchInvestors are subject to the terms and conditions set forth by the individual businesses I choose to invest in.
                                                </label>
                                            </li>
                                            <li>
                                                <label>
                                                    <span style="margin-right:5px"><input onclick='$("#termsrule_error").hide();' class = "terms_conditions" type="checkbox" value="1" @if(isset($investor)){{'checked'}}@endif /></span>
                                                    I agree to comply with all applicable laws and regulations related to investments and financial transactions.
                                                </label>
                                            </li>
                                        </ul>
                                        <div id="termsrule_error" class="error mt-1" style="color:red;display: none;">Please accept terms of engagement</div>
                                    </div>
                                    <div class="row margin-left-button" id="submit">
                                       <label class="save-detail mt-0"><a href="javascript:;">Save</a></label>
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

        Dropzone.autoDiscover = false;
        var docString = '';
        const identification_photo_dropzone = document.getElementById('identification_photo_dropzone');
        const file_identification_photo = document.getElementById('file_identification_photo');

        const company_document_dropzone = document.getElementById('company_document_dropzone');
        const file_company_document = document.getElementById('file_company_document');
        file_up_names=[];

        var dropzone = new Dropzone('#identification_photo_dropzone', {
            thumbnailWidth: 200,
            parallelUploads: 1,                
            maxFiles: 1,
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

                url="{{ url('investor-delete-document') }}";
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
                'type': 'identification_photo',
                 // 'iTempId': iTempId,
                 // 'iInvestorProfileId': iInvestorProfileId
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
        identification_photo_dropzone.addEventListener('drop', event => {
            event.preventDefault();
            let files1 = event.dataTransfer.files;
            file_identification_photo.files = files1;
            console.log('added ' + files.length + ' files');
        });

        var dropzone = new Dropzone('#company_document_dropzone', 
        {
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

                url="{{ url('investor-delete-document') }}";
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
                'type': 'profile',
                // 'iTempId': iTempId,
                //  'iInvestorProfileId': iInvestorProfileId
            },
            headers: {
                'x-csrf-token': '{{ csrf_token() }}',
            },
            success: function(file, response) 
            {
                console.log(response)
                docString += response.id + ',';
                $('#documentId').val(docString.slice(0, -1));
                file_up_names.push(file.name);
            }
        });
        company_document_dropzone.addEventListener('drop', event => {
            event.preventDefault();
            let files1 = event.dataTransfer.files;
            file_company_document.files = files1;
            console.log('added ' + files.length + ' files');
        });
        
       
        $(document).on('click', '#submit', function() 
        {
         error = false;   
            var vUniqueCode = $("#vUniqueCode").val();
            var vProfileTitle = $("#vProfileTitle").val();
            var vFirstName = $("#vFirstName").val();
            var vLastName = $("#vLastName").val();
            var dDob = $("#dDob").val();                
            var vEmail = $("#vEmail").val();                
            var vPhone = $("#vPhone").val();                
            var vIdentificationNo = $("#vIdentificationNo").val();                
            var vAddress = $("#vAddress").val();   
            var iNationality = $("#iNationality").val();                
            var iCity = $("#iCity").val();                
            var vInvestorProfileName = $("#vInvestorProfileName").val();
            var eInvestorType = $('input:radio[name="eInvestorType"]:checked').length;            
            var vCompanyWebsite = $("#vCompanyWebsite").val();
            var eInvestingExp = $('input:radio[name="eInvestingExp"]:checked').length;
            var eAdvisorGuide = $('input:radio[name="eAdvisorGuide"]:checked').length;
            var tAboutCompany = $("#tAboutCompany").val();
            var tInvestorProfileDetail = $("#tInvestorProfileDetail").val();
            var industries = $("#industries").val();            
            var intrestCheckbox = $(".intrestCheckbox:checkbox:checked").length;
            var vHowMuchInvest = $('input:radio[name="vHowMuchInvest"]:checked').length;
            var whenInvestCheckbox = $(".whenInvestCheckbox:checkbox:checked").length;
            var tFactorsInBusiness = $("#tFactorsInBusiness").val();

            if (vProfileTitle.length == 0) 
            {
            $("#vProfileTitle_error").show();
            $("#vProfileTitle").addClass('has-error');
            $("#vProfileTitleError").addClass('fas fa-exclamation-circle');
              error = true;
            } else {
                $("#vProfileTitle_error").hide();
                $("#vProfileTitle").removeClass('has-error');
                $("#vProfileTitleError").removeClass('fas fa-exclamation-circle');
                $("#vProfileTitleError").addClass('fas fa-check-circle');
            }           
        
            if(vFirstName.length == 0) {
            $("#vFirstName_error").show();
            $( "#vFirstName" ).addClass('has-error');
            $("#fNameError").addClass('fas fa-exclamation-circle');
            error = true;            
            } else {
                $("#vFirstName_error").hide();
                $("#vFirstName").removeClass('has-error');
                $("#fNameError").removeClass('fas fa-exclamation-circle');
                $("#fNameError").addClass('fas fa-check-circle');
            }
            if (vLastName.length == 0) 
            {
                $("#vLastName_error").show();
                $( "#vLastName" ).addClass('has-error');
                $("#lNameError").addClass('fas fa-exclamation-circle');
                error = true;                
            } else {
                $("#vLastName_error").hide();
                $("#vLastName").removeClass('has-error');
                $("#lNameError").removeClass('fas fa-exclamation-circle');
                $("#lNameError").addClass('fas fa-check-circle');
            }
            if (dDob.length == 0) 
            {
                $("#dDob_error").show();
                $("#dDob").addClass('has-error');
                $("#DOBError").addClass('fas fa-exclamation-circle');
                error = true;            
            } else 
            {
                $("#dDob_error").hide();
                $("#dDob").removeClass('has-error');
                $("#DOBError").removeClass('fas fa-exclamation-circle');
                $("#DOBError").addClass('fas fa-check-circle');
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
            if (vIdentificationNo.length == 0) 
            {
                $("#vIdentificationNo_error").show();
                $( "#vIdentificationNo" ).addClass('has-error');
                $("#vIdentificationNoError").addClass('fas fa-exclamation-circle');
                error = true;                
            } else 
            {
                $("#vIdentificationNo_error").hide();
                $("#vIdentificationNo").removeClass('has-error');
                $("#vIdentificationNoError").removeClass('fas fa-exclamation-circle');
                $("#vIdentificationNoError").addClass('fas fa-check-circle');
            }            
            if (vAddress.length == 0) 
            {
                $("#vAddress_error").show();
                $("#vAddress").addClass('has-error');
                $("#vAddressError").addClass('fas fa-exclamation-circle');
                error = true;
            } else 
            {
                $("#vAddress_error").hide();
                $("#vAddress").removeClass('has-error');
                $("#vAddressError").removeClass('fas fa-exclamation-circle');
                $("#vAddressError").addClass('fas fa-check-circle');
            }
            if (iNationality.length == 0) 
            {
                $("#iNationality_error").show();
                $("#iNationality").addClass('has-error');
                $("#iNationalityError").removeClass('fas fa-exclamation-circle');
                error = true;                
            } else 
            {
                $("#iNationality_error").hide();
                $("#iNationality").removeClass('has-error');
                $("#iNationalityError").removeClass('fas fa-exclamation-circle');
                $("#iNationalityError").addClass('fas fa-check-circle');
            }
            if (iCity.length == 0) 
            {
                $("#iCity_error").show();
                $( "#iCity" ).addClass('has-error');
                $("#iCityError").addClass('fas fa-exclamation-circle');
                error = true;                
            } else 
            {
                $("#iCity_error").hide();
                $( "#iCity" ).removeClass('has-error');
                $("#iCityError").removeClass('fas fa-exclamation-circle');
                $("#iCityError").addClass('fas fa-check-circle');
            }
            if (vInvestorProfileName.length == 0) 
            {
                $("#vInvestorProfileName_error").show();
                $("#vInvestorProfileName").addClass('has-error');
                $("#vInvestorProfileNameError").addClass('fas fa-exclamation-circle');
                error = true;
            } else 
            {
                $("#vInvestorProfileName_error").hide();
                $("#vInvestorProfileName").removeClass('has-error');
                $("#vInvestorProfileNameError").removeClass('fas fa-exclamation-circle');
                $("#vInvestorProfileNameError").addClass('fas fa-check-circle');
            }
            if (eInvestorType <= 0) 
            {
                $("#eInvestorType_error").show();
                $("#eInvestorType").addClass('has-error');
                error = true;                
            } else 
            {
                $("#eInvestorType_error").hide();
                $("#eInvestorType").removeClass('has-error');
            }
            if (vCompanyWebsite.length == 0) 
            {
                $("#vCompanyWebsite_error").show();
                $("#vCompanyWebsite_error").addClass('has-error');
                $("#vCompanyWebsiteError").addClass('fas fa-exclamation-circle');
                error = true;                
            } else 
            {
                $("#vCompanyWebsite_error").hide();
                $("#vCompanyWebsite_error").removeClass('has-error');
                $("#vCompanyWebsiteError").removeClass('fas fa-exclamation-circle');
                $("#vCompanyWebsiteError").addClass('fas fa-check-circle');
            }
            if (eInvestingExp <= 0) 
            {
                $("#eInvestingExp_error").show();
                $("#eInvestingExp").addClass('has-error');                
                error = true;                
            } else {
                $("#eInvestingExp_error").hide();
                $("#eInvestingExp").removeClass('has-error');
            }
            if (eAdvisorGuide <= 0) 
            {
                $("#eAdvisorGuide_error").show();
                $("#eAdvisorGuide").addClass('has-error');
                error = true;   
            } else 
            {
                $("#eAdvisorGuide_error").hide();
                $("#eAdvisorGuide").removeClass('has-error');
            }
            if (tAboutCompany.length == 0) {
                $("#tAboutCompany_error").show();
                $("#tAboutCompany").addClass('has-error');
                $("#tAboutCompanyError").addClass('fas fa-exclamation-circle');
                error = true;                
            } else 
            {
                $("#tAboutCompany_error").hide();
                $("#tAboutCompany").removeClass('has-error');
                $("#tAboutCompanyError").removeClass('fas fa-exclamation-circle');
                $("#tAboutCompanyError").addClass('fas fa-check-circle');
            }if (tInvestorProfileDetail.length == 0) 
            {
                $("#tInvestorProfileDetail_error").show();
                $("#tInvestorProfileDetail").addClass('has-error');
                $("#tInvestorProfileDetailError").addClass('fas fa-exclamation-circle');                
                error = true;                
            } else 
            {
                $("#tInvestorProfileDetail_error").hide();
                $("#tInvestorProfileDetail").removeClass('has-error');
                $("#tInvestorProfileDetailError").removeClass('fas fa-exclamation-circle');
                $("#tInvestorProfileDetailError").addClass('fas fa-check-circle');
            }if (industries.length == 0) {
                $("#industries_error").show();
                $("#industries").addClass('has-error');
                $("#industriesError").addClass('fas fa-exclamation-circle');
               error = true;                
            } else 
            {
                $("#industries_error").hide();
                $("#industries").removeClass('has-error');
                $("#industriesError").removeClass('fas fa-exclamation-circle');
                $("#industriesError").addClass('fas fa-check-circle');
            }if (intrestCheckbox <= 0) 
            {
                $("#intrestIn_error").show();
                $("#intrestIn_error").addClass('has-error');
                error = true;                
            } else 
            {
                $("#intrestIn_error").hide();
                $("#intrestIn_error").removeClass('has-error');
            }if (vHowMuchInvest <= 0) 
            {
                $("#vHowMuchInvest_error").show();
                $("#vHowMuchInvest_error").addClass('has-error');
                error = true;                
            } else 
            {
                $("#vHowMuchInvest_error").hide();
                $("#vHowMuchInvest_error").removeClass('has-error');
            }
            if (whenInvestCheckbox <= 0) {
                $("#vWhenInvest_error").show();
                $("#vWhenInvest_error").addClass('has-error');
                error = true;
                
            } else 
            {
                $("#vWhenInvest_error").hide();
                $("#vWhenInvest_error").removeClass('has-error');
            }            
            if (tFactorsInBusiness.length == 0) 
            {
                $("#tFactorsInBusiness_error").show();
                $("#tFactorsInBusiness_error").addClass('has-error');
                $("#tFactorsInBusinessError").addClass('has-error');                
                    error = true;
            } else 
            {
                $("#tFactorsInBusiness_error").hide();
                $("#tFactorsInBusiness_error").removeClass('has-error');
                $("#tFactorsInBusinessError").removeClass('fas fa-exclamation-circle');
                $("#tFactorsInBusinessError").addClass('fas fa-check-circle');
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

       
           $(document).on('change blur', '#vProfileTitle', function() {
                var vProfileTitle = $("#vProfileTitle").val();
                if (vProfileTitle.length == 0) {
                $("#vProfileTitle_error").show();
                $("#vProfileTitle").addClass('has-error');
                $("#vProfileTitleError").addClass('fas fa-exclamation-circle');            
                error = true;           
                } else {
                    $("#vProfileTitle_error").hide();
                    $("#vProfileTitle").removeClass('has-error');
                    $("#vProfileTitleError").removeClass('fas fa-exclamation-circle');
                    $("#vProfileTitleError").addClass('fas fa-check-circle');
                }
            });
            $(document).on('change blur', '#vFirstName', function() {
                var vFirstName = $("#vFirstName").val();
                if (vFirstName.length == 0) {
                $("#vFirstName_error").show();
                $( "#vFirstName" ).addClass('has-error');
                $("#fNameError").addClass('fas fa-exclamation-circle');
                error = true;
                } else {
                    $("#vFirstName_error").hide();
                    $("#vFirstName").removeClass('has-error');
                    $("#fNameError").removeClass('fas fa-exclamation-circle');
                    $("#fNameError").addClass('fas fa-check-circle');
                }
            });
            $(document).on('change blur', '#vLastName', function() {
                  var vLastName = $("#vLastName").val();
                 if (vLastName.length == 0) {
                    $("#vLastName_error").show();
                    $( "#vLastName" ).addClass('has-error');
                    $("#lNameError").addClass('fas fa-exclamation-circle');
                    error = true;                
                } else {
                    $("#vLastName_error").hide();
                    $("#vLastName").removeClass('has-error');
                    $("#lNameError").removeClass('fas fa-exclamation-circle');
                    $("#lNameError").addClass('fas fa-check-circle');
                }
            });
            $(document).on('change blur', '#dDob', function() {
                var dDob = $("#dDob").val();                
                 if (dDob.length == 0) {
                $("#dDob_error").show();
                $("#dDob").addClass('has-error');
                $("#DOBError").addClass('fas fa-exclamation-circle');
                error = true;            
                } else {
                    $("#dDob_error").hide();
                    $("#dDob").removeClass('has-error');
                    $("#DOBError").removeClass('fas fa-exclamation-circle');
                    $("#DOBError").addClass('fas fa-check-circle');
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
            $(document).on('change blur', '#vIdentificationNo', function() {
                var vIdentificationNo = $("#vIdentificationNo").val();                
                if (vIdentificationNo.length == 0) {
                    $("#vIdentificationNo_error").show();
                    $( "#vIdentificationNo" ).addClass('has-error');
                    $("#vIdentificationNoError").addClass('fas fa-exclamation-circle');
                    error = true;                
                } else {
                    $("#vIdentificationNo_error").hide();
                    $("#vIdentificationNo").removeClass('has-error');
                    $("#vIdentificationNoError").removeClass('fas fa-exclamation-circle');
                    $("#vIdentificationNoError").addClass('fas fa-check-circle');
                }
            });
            $(document).on('change blur', '#vAddress', function() {
                  var vAddress = $("#vAddress").val();   
                if (vAddress.length == 0) {
                    $("#vAddress_error").show();
                    $("#vAddress").addClass('has-error');
                    $("#vAddressError").addClass('fas fa-exclamation-circle');
                    error = true;
                } else {
                    $("#vAddress_error").hide();
                    $("#vAddress").removeClass('has-error');
                    $("#vAddressError").removeClass('fas fa-exclamation-circle');
                    $("#vAddressError").addClass('fas fa-check-circle');
                }
            });
            $(document).on('change blur', '#iNationality', function() {
                var iNationality = $("#iNationality").val();                
                 if (iNationality.length == 0) {
                    $("#iNationality_error").show();
                    $("#iNationality").addClass('has-error');
                    $("#iNationalityError").removeClass('fas fa-exclamation-circle');
                    error = true;                
                } else {
                        $("#iNationality_error").hide();
                        $("#iNationality").removeClass('has-error');
                        $("#iNationalityError").removeClass('fas fa-exclamation-circle');
                        $("#iNationalityError").addClass('fas fa-check-circle');
                }
            });
            $(document).on('change blur', '#iCity', function() {
                  var iCity = $("#iCity").val();                
                if (iCity.length == 0) {
                    $("#iCity_error").show();
                    $( "#iCity" ).addClass('has-error');
                    $("#iCityError").addClass('fas fa-exclamation-circle');
                    error = true;                
                } else {
                    $("#iCity_error").hide();
                    $( "#iCity" ).removeClass('has-error');
                    $("#iCityError").removeClass('fas fa-exclamation-circle');
                    $("#iCityError").addClass('fas fa-check-circle');
                }
            });
            $(document).on('change blur', '#vInvestorProfileName', function() {
                var vInvestorProfileName = $("#vInvestorProfileName").val();
                if (vInvestorProfileName.length == 0) {
                    $("#vInvestorProfileName_error").show();
                    $("#vInvestorProfileName").addClass('has-error');
                    $("#vInvestorProfileNameError").addClass('fas fa-exclamation-circle');                
                    error = true;                
                } else {
                    $("#vInvestorProfileName_error").hide();
                    $("#vInvestorProfileName").removeClass('has-error');
                    $("#vInvestorProfileNameError").removeClass('fas fa-exclamation-circle');
                    $("#vInvestorProfileNameError").addClass('fas fa-check-circle');
                }
            });
            $(document).on('change blur', '#tInvestorProfileDetail', function() {
                 var tInvestorProfileDetail = $("#tInvestorProfileDetail").val();
                if (tInvestorProfileDetail.length == 0) {
                    $("#tInvestorProfileDetail_error").show();
                    $("#tInvestorProfileDetail").addClass('has-error');
                    $("#tInvestorProfileDetailError").addClass('fas fa-exclamation-circle');                
                     error = true;                
                } else {
                    $("#tInvestorProfileDetail_error").hide();
                    $("#tInvestorProfileDetail").removeClass('has-error');
                    $("#tInvestorProfileDetailError").removeClass('fas fa-exclamation-circle');
                    $("#tInvestorProfileDetailError").addClass('fas fa-check-circle');
                }
            });
            $(document).on('change blur', '#individual', function() {
                 var eInvestorType = $('input:radio[name="eInvestorType"]:checked').length;            
                 if (eInvestorType <= 0) {
                    $("#eInvestorType_error").show();
                    $("#eInvestorType").addClass('has-error');
                    error = true;                
                } else {
                    $("#eInvestorType_error").hide();
                    $("#eInvestorType").removeClass('has-error');
                }
            });
            $(document).on('change blur', '#tAboutCompany', function() {
                  var tAboutCompany = $("#tAboutCompany").val();
                if (tAboutCompany.length == 0) {
                    $("#tAboutCompany_error").show();
                    $("#tAboutCompany").addClass('has-error');
                    $("#tAboutCompanyError").addClass('fas fa-exclamation-circle');                    
                        error = true;                        
                    } else {
                        $("#tAboutCompany_error").hide();
                        $("#tAboutCompany").removeClass('has-error');
                        $("#tAboutCompanyError").removeClass('fas fa-exclamation-circle');
                        $("#tAboutCompanyError").addClass('fas fa-check-circle');
                    }
            });
            $(document).on('change blur', '#investingYes', function() {
                var eInvestingExp = $('input:radio[name="eInvestingExp"]:checked').length;
                if (eInvestingExp <= 0) {
                    $("#eInvestingExp_error").show();
                    $("#eInvestingExp").addClass('has-error');                
                    error = true;                
                } else {
                    $("#eInvestingExp_error").hide();
                    $("#eInvestingExp").removeClass('has-error');
                }
            });
            $(document).on('change blur', '#vCompanyWebsite', function() {
                var vCompanyWebsite = $("#vCompanyWebsite").val();
                if (vCompanyWebsite.length == 0) {
                    $("#vCompanyWebsite_error").show();
                    $("#vCompanyWebsite_error").addClass('has-error');
                    $("#vCompanyWebsiteError").addClass('fas fa-exclamation-circle');
                    error = true;                
                } else {
                    $("#vCompanyWebsite_error").hide();
                    $("#vCompanyWebsite_error").removeClass('has-error');
                    $("#vCompanyWebsiteError").removeClass('fas fa-exclamation-circle');
                    $("#vCompanyWebsiteError").addClass('fas fa-check-circle');
                }
            });
            $(document).on('change blur', '#guideYes', function() {
                var eAdvisorGuide = $('input:radio[name="eAdvisorGuide"]:checked').length;
                 if (eAdvisorGuide <= 0) {
                    $("#eAdvisorGuide_error").show();
                    $("#eAdvisorGuide").addClass('has-error');
                    error = true;                
                } else {
                    $("#eAdvisorGuide_error").hide();
                    $("#eAdvisorGuide").removeClass('has-error');
                }
            });
            $(document).on('change blur', '#industries', function() {
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
            $(document).on('change blur', '.whenInvestCheckbox', function() {
                 var whenInvestCheckbox = $(".whenInvestCheckbox:checkbox:checked").length;
                 if (whenInvestCheckbox <= 0) {
                    $("#vWhenInvest_error").show();
                    $("#vWhenInvest_error").addClass('has-error');
                    error = true;
                    
                } else {
                    $("#vWhenInvest_error").hide();
                    $("#vWhenInvest_error").removeClass('has-error');
                    
                }   
            });
            $(document).on('change blur', '#tFactorsInBusiness', function() {
                var tFactorsInBusiness = $("#tFactorsInBusiness").val();
                if (tFactorsInBusiness.length == 0) {
                    $("#tFactorsInBusiness_error").show();
                    $("#tFactorsInBusiness_error").addClass('has-error');
                    $("#tFactorsInBusinessError").addClass('has-error');                
                        error = true;
                } else 
                {
                    $("#tFactorsInBusiness_error").hide();
                    $("#tFactorsInBusiness_error").removeClass('has-error');
                    $("#tFactorsInBusinessError").removeClass('fas fa-exclamation-circle');
                    $("#tFactorsInBusinessError").addClass('fas fa-check-circle');
                }
            });

        $('.numeric').keyup(function(e) {
            if (/\D/g.test(this.value)) {
                this.value = this.value.replace(/\D/g, '');
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
        $(document).ready(function () {
            $( "#country_id" ).trigger( "change" );
            setTimeout( function(){ 
                $( "#iRegionId" ).trigger( "change" );
            }  , 1000 );
            setTimeout( function(){ 
                $( "#iCountyId" ).trigger( "change" );
            }  , 2000 );
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
                            if (selected_region_id == value.iRegionId+ '_'+ value.vTitle) {
                                selected = 'selected';
                            }
							$("#iRegionId").append('<option value="' + value.iRegionId + '_'+ value.vTitle +'" '+selected+'>' + value.vTitle + '</option>');
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
                            if (selected_county_id == value.iCountyId + '_'+ value.vTitle) {
                                selected = 'selected';
                            }
							$("#iCountyId").append('<option value="' + value.iCountyId + '_'+ value.vTitle + '" '+selected+'>' + value.vTitle + '</option>');
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
                            if (selected_sub_county_id == value.iSubCountId + '_'+ value.vTitle) {
                                selected = 'selected';
                            }
							$("#iSubCountyId").append('<option value="' + value.iSubCountId + '_'+ value.vTitle + '" '+selected+'>' + value.vTitle + '</option>');
						});
					}
				});
			}
		});

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
          iInvestorDocId = $(this).data("id");
          
          url = "{{ url('investor-delete-document') }}";
          setTimeout(function(){
            $.ajax({
              url: url,
              type: "POST",
              data:  {iInvestorDocId:iInvestorDocId,_token: '{{ csrf_token() }}'}, 
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

const ele = document.getElementById('tAboutCompany');
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

