@extends('layouts.app.admin-app')
@section('title', 'Business Advisor - '.env('APP_NAME'))
@section('custom-css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css" integrity="sha512-TQQ3J4WkE/rwojNFo6OJdyu6G8Xe9z8rMrlF9y7xpFbQfW5g8aSWcygCQ4vqRiJqFsDsE1T6MoAOMJkFXlrI9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ isset($advisor) ? 'Edit' : 'Add' }} Business Advisor</h1>
        </div>
    </div>
  </div>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <!-- <div class="card-header custome-nav-tabs">
              @if(isset($advisor))
              @endif
            </div> -->
            <form action="{{url('admin/business-advisor/store')}}" name="frm" id="frm" method="post" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if(isset($advisor)){{$advisor->vUniqueCode}}@endif">
                <div class="row">
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Profession</label>
                      <input type="text" name="vAdvisorProfileTitle" id="vAdvisorProfileTitle" class="form-control" placeholder="Enter Profession" value="@if(isset($advisor)){{$advisor->vAdvisorProfileTitle}}@endif">
                      <div id="vAdvisorProfileTitle_error" class="error mt-1" style="color:red;display: none;">Please Enter Profession </div>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Company Name</label>
                      <input type="text" name="vCompanyName" id="vCompanyName" class="form-control" placeholder="Enter Comapny Name" value="@if(isset($advisor)){{$advisor->vCompanyName}}@endif">
                      <div id="vCompanyName_error" class="error mt-1" style="color:red;display: none;">Please Enter Company Name</div>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>First Name</label>
                      <input type="text" name="vFirstName" id="vFirstName" class="form-control" placeholder="Enter First Name" value="@if(isset($advisor)){{$advisor->vFirstName}}@endif">
                      <div id="vFirstName_error" class="error mt-1" style="color:red;display: none;">Please Enter First Name </div>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Last Name</label>
                      <input type="text" name="vLastName" id="vLastName" class="form-control" placeholder="Enter Last Name" value="@if(isset($advisor)){{$advisor->vLastName}}@endif">
                      <div id="vLastName_error" class="error mt-1" style="color:red;display: none;">Please Enter Last Name </div>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>DOB</label>
                      <input type="text" name="dDob" id="dDob" class="form-control datepicker"  placeholder="Enter Date of Birth" value="@if(isset($advisor)){{date('d-F-Y',strtotime($advisor->dDob))}}@endif">
                      <div id="dDob_error" class="error mt-1" style="color:red;display: none;">Please Enter Date of Birth </div>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Email</label>
                      <input type="text" name="vEmail" id="vEmail" class="form-control datepicker"  placeholder="Enter Email" value="@if(isset($advisor)){{$advisor->vEmail}}@endif">
                      <div id="vEmail_error" class="error mt-1" style="color:red;display: none;">Please Enter Email </div>
                      <div id="vEmail_valid_error" class="error_show" style="color:red;display: none;">Please Enter Valid Email</div>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Phone</label>
                      <input type="text" name="vPhone" id="vPhone" class="form-control numeric" maxlength="10"  placeholder="Enter Phone No." value="@if(isset($advisor)){{$advisor->vPhone}}@endif">
                      <div id="vPhone_error" class="error mt-1" style="color:red;display: none;">Please Enter Phone No. </div>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Identification No</label>
                      <input type="text" name="vIdentificationNo" id="vIdentificationNo" class="form-control"  placeholder="Enter Identification No" value="@if(isset($advisor)){{$advisor->vIdentificationNo}}@endif">
                      <div id="vIdentificationNo_error" class="error mt-1" style="color:red;display: none;">Please Enter Identification No </div>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>How much do you charge for your services in KES</label>
                      <input type="text" name="iCost" id="iCost" class="form-control"  placeholder="Enter Charge for cost" value="@if(isset($advisor)){{$advisor->iCost}}@endif">
                      <div id="iCost_error" class="error mt-1" style="color:red;display: none;">Please Enter Charge for cost </div>
                      <div id="iCost_max_error" class="error mt-1" style="color:red;display: none;">Please Enter Charge for cost</div>
                  </div>

					{{-- <div class="form-group col-xl-6 col-lg-12 col-md-6">
						<label>Advisor Profile Name</label>
						<input type="text" name="vAdvisorProfileName" id="vAdvisorProfileName" class="form-control " placeholder="Enter Advisor Profile Name" value="@if (isset($advisor)) {{ $advisor->vAdvisorProfileName }} @endif">
						<div id="vAdvisorProfileName_error" class="error mt-1" style="color:red;display: none;">Please Enter Advisor Profile Name. </div>
					</div> --}}

					<div class="form-group col-xl-6 col-lg-12 col-md-6">
						<label>Advisor Profile Detail</label>
						<input type="text" name="tAdvisorProfileDetail" id="tAdvisorProfileDetail" class="form-control " placeholder="Enter Advisor Profile Detail" value="@if (isset($advisor)){{$advisor->tAdvisorProfileDetail}}@endif">
						<div id="tAdvisorProfileDetail_error" class="error mt-1" style="color:red;display: none;">Please Enter Advisor Profile Detail. </div>
					</div>

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
          <div id="locations_error" class="error mt-1" style="color:red;display: none;">Please Select Location</div>
      </div>

                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Advisor Industries</label>
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
                          <option value="{{ $value->vName }}_{{ $value->iIndustryId }}"
                              {{ $industry_select }}>{{ $value->vName }}</option>
                      @endforeach
                  </select>
                  <div id="industries_error" class="error mt-1"
                      style="color:red; display: none;">Please Select Industries</div>
                  </div>



                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Status</label>
                    <select name="eStatus" id="eStatus" class="form-control">
                      <option value="">Select Status</option>
                      <option value="Active" @if(isset($advisor)) @if($advisor->eStatus == 'Active') selected @endif @endif>Active</option>
                      <option value="Inactive" @if(isset($advisor)) @if($advisor->eStatus == 'Inactive') selected @endif @endif>Inactive</option>
                    </select>
                    <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">Please Select Status</div>
                  </div>

                <div class="form-group col-xl-6 col-lg-12 col-md-6 checkbox">
                    <label>Profession Title</label></br>

                    <input type="checkbox" name="eFinancialAnalyst" id="eFinancialAnalyst" class="checkboxall ProfessionCheckbox" value="Yes" @if (isset($advisor) and $advisor->eFinancialAnalyst == 'Yes') {{ 'checked' }} @endif>
                    <label for="eFinancialAnalyst">Financial analyst</label>

                    <input type="checkbox" name="eAccountant" id="eAccountant" class="checkboxall ProfessionCheckbox" value="Yes" @if (isset($advisor) and $advisor->eAccountant == 'Yes') {{ 'checked' }} @endif>
                    <label for="eAccountant">Accountant</label></br>

                    <input type="checkbox" name="eBusinessLawer" id="eBusinessLawer" class="checkboxall ProfessionCheckbox" value="Yes" @if (isset($advisor) and $advisor->eBusinessLawer == 'Yes') {{ 'checked' }} @endif>
                    <label for="eBusinessLawer">Business lawyer</label></br>

                    <input type="checkbox" name="eTaxConsultant" id="eTaxConsultant" class="checkboxall ProfessionCheckbox" value="Yes" @if (isset($advisor) and $advisor->eTaxConsultant == 'Yes') {{ 'checked' }} @endif>
                    <label for="eTaxConsultant">Tax consultant</label></br>

                    <input type="checkbox" name="eBusinessBrokers" id="eBusinessBrokers" class="checkboxall ProfessionCheckbox" value="Yes" @if (isset($advisor) and $advisor->eBusinessBrokers == 'Yes') {{ 'checked' }} @endif>
                    <label for="eBusinessBrokers">Busines brokers</label>

                    <input type="checkbox" name="eCommercialRealEstateBrokers" id="eCommercialRealEstateBrokers" class="checkboxall ProfessionCheckbox" value="Yes" @if (isset($advisor) and $advisor->eCommercialRealEstateBrokers == 'Yes') {{ 'checked' }} @endif>
                    <label for="eCommercialRealEstateBrokers">Commercial Real Estate Brokers</label>

                    <input type="checkbox" name="eMandAAdvisor" id="eMandAAdvisor" class="checkboxall ProfessionCheckbox" value="Yes" @if (isset($advisor) and $advisor->eMandAAdvisor == 'Yes') {{ 'checked' }} @endif>
                    <label for="eMandAAdvisor">M&A advisors</label>  

                    <input type="checkbox" name="eInvestmentBanks" id="eInvestmentBanks" class="checkboxall ProfessionCheckbox" value="Yes" @if (isset($advisor) and $advisor->eInvestmentBanks == 'Yes') {{ 'checked' }} @endif>
                    <label for="eInvestmentBanks">Investment banks</label>

                    <div id="profession_error" class="error mt-1" style="color:red;display: none;">Please Select</div>
                </div>

                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Education Detail</label>
                    <textarea class="form-control" id="tEducationDetail" name="tEducationDetail" placeholder="Please enter Factors in Business ">@if(isset($advisor)){{$advisor->tEducationDetail}}@endif</textarea>
                    <div id="tEducationDetail_error" class="error mt-1" style="color:red;display: none;">Please Enter Educaion Detail </div>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Bio (Self)</label>
                    <textarea class="form-control" id="tBio" name="tBio" placeholder="Please enter About Company">@if(isset($advisor)){{$advisor->tBio}}@endif</textarea>
                    <div id="tBio_error" class="error mt-1" style="color:red;display: none;">Please describe your self</div>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Work Experience</label>
                    <textarea class="form-control" id="vExperince" name="vExperince" placeholder="Please enter About Company">@if(isset($advisor)){{$advisor->vExperince}}@endif</textarea>
                    <div id="vExperince_error" class="error mt-1" style="color:red;display: none;">Please describe your experience</div>
                  </div>

                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Discription</label>
                    <textarea class="form-control" id="tDescription" name="tDescription" placeholder="Please enter About Company">@if(isset($advisor)){{$advisor->tDescription}}@endif</textarea>
                    <div id="tDescription_error" class="error mt-1" style="color:red;display: none;">Please enter discription</div>
                  </div>
                  <input type="hidden" name="documentId" id="documentId">
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Upload Education File</label>
                    <input type="file" name="file_experience_documents[]" id="file_experience_documents" class="d-none" accept="image/png, image/jpeg">
                    <div id="experience_documents_dropzone" name='experience_documents_dropzone' class="dropzone experience-dropzone"></div>
                  </div>
                  <!-- start display image code -->
                   {{-- <div class="file-upload-img">
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
                                                          </div>--}}
                    <!-- close display image code -->


                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Upload Experience documents</label>
                    <input type="file" name="file_education_documents[]" id="file_education_documents" class="d-none" accept="image/png, image/jpeg">
                    <div id="education_documents_dropzone" name='education_documents_dropzone' class="dropzone education-dropzon"></div>
                  </div> 
                    <!-- start display image code -->
                      {{--<div class="file-upload-img">
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
                                                                  </div>--}}
                      <!-- close display image code -->
    
                    
                   <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Upload Profile Image</label>
                    <input type="file" name="file_investor_profile_image[]" id="file_investor_profile_image" class="d-none" accept="image/png, image/jpeg">
                    <div id="file_investor_profile_image_dropzone" name='file_investor_profile_image_dropzone' class="dropzone education-dropzon"></div>

                  </div>


                 <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Show On Home Page</label>
                    <select name="eShowHomePage" id="eShowHomePage" class="form-control">
                      <option value="">Select option</option>
                      <option value="Yes" @if(isset($advisor)) @if($advisor->eShowHomePage  == 'Yes') selected @endif @endif>Yes</option>
                      <option value="No" @if(isset($advisor)) @if($advisor->eShowHomePage  == 'No') selected @endif @endif>No</option>
                    </select>
                    <div id="eHomeStatus_error" class="error mt-1" style="color:red;display: none;">Please Select Status</div>
                  </div>              

                   <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Admin Approval</label>
                        <select name="eAdminApproval" id="eAdminApproval" class="form-control">
                            <option value="">Select option</option>
                            <option value="Pending" @if (isset($advisor)) @if ($advisor->eAdminApproval == 'Pending') selected @endif @endif>
                                pending
                            </option>
                            <option value="Approved" @if (isset($advisor)) @if ($advisor->eAdminApproval == 'Approved') selected @endif @endif>
                                approved
                            </option>
                            <option value="Reject" @if (isset($advisor)) @if ($advisor->eAdminApproval == 'Reject') selected @endif @endif>
                                reject
                            </option>
                        </select>                          
                    </div>
                    
                </div> {{-- end row --}}
                <div class="card-footer col-12 d-inline-block mt-0">
                  <a href="javascript:;" class="btn btn-primary submit" id="save">Submit</a>
                  <a href="javascript:;" class="btn btn-primary loading" style="display: none;">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                  </a>
                  <a href="{{url('admin/investor/listing')}}" class="btn-info btn">Back</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">

  var datePicker = $('#dDob');
  var upload_url = '{{url("admin/business-advisor/upload")}}';
  datePicker.datepicker({
    format: 'dd-MM-yyyy',
    autoclose: true,
    endDate: '+0d',
  });

  $(document).ready(function() {
    $('.select2Option').select2();

    $('#locations').select2({
      closeOnSelect : false,
            placeholder : "Select Location",
            allowClear: true,
      tags: true,
      maximumSelectionLength: 5
    });
    $('#industries').select2({
      closeOnSelect : true,
            placeholder : "Select Industry",
            allowClear: true,
      tags: true
    });

  });
  $(document).on("input", ".numeric", function() {
    this.value = this.value.replace(/\D/g,'');
  });
  
    Dropzone.autoDiscover = false;
    var docString='';
    const experience_documents_dropzone = document.getElementById('experience_documents_dropzone');
    const file_experience_documents = document.getElementById('file_experience_documents');

    const education_documents_dropzone = document.getElementById('education_documents_dropzone');
    const file_education_documents = document.getElementById('file_education_documents');

    const file_investor_profile_image_dropzone = document.getElementById('file_investor_profile_image_dropzone');
    const file_investor_profile_image = document.getElementById('file_investor_profile_image');
        file_up_names=[];


    datePicker.datepicker({
        format: 'dd-MM-yyyy',
        autoclose: true,
        endDate: '+0d',
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

        url:upload_url,
        paramName:"file",
        params: {
            'type': 'experience'
        },
        headers: {
            'x-csrf-token': '{{csrf_token()}}',
        },
        success: function(file, response)
        { 
             docString+=response.id+',';
            $('#documentId').val(docString.slice(0, -1));
            file_up_names.push(file.name);

        }
    });
    experience_documents_dropzone.addEventListener('drop', event => {
        event.preventDefault();
        let files1 = event.dataTransfer.files;
        file_experience_documents.files = files1;
        console.log('added '+files1.length+' files');
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

        url:upload_url,
        paramName:"file",
        params: {
            'type': 'education_document'
        },
        headers: {
            'x-csrf-token': '{{csrf_token()}}',
        },
        success: function(file, response)
        { 
             docString+=response.id+',';
            $('#documentId').val(docString.slice(0, -1));
                        file_up_names.push(file.name);

        }
    });
    education_documents_dropzone.addEventListener('drop', event => {
        event.preventDefault();
        let files1 = event.dataTransfer.files;
        file_education_documents.files = files1;
        console.log('added '+files1.length+' files');
    });

     var dropzone = new Dropzone('#file_investor_profile_image_dropzone', {
            thumbnailWidth: 200,
            parallelUploads: 10,
            dictDefaultMessage: "Upload Profile Image",
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",
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
        });

  $(document).on('click','.submit',function(){
    tinymce.triggerSave();
    var vUniqueCode           = $("#vUniqueCode").val();
    var vAdvisorProfileTitle  = $("#vAdvisorProfileTitle").val();
    var vCompanyName          = $("#vCompanyName").val()
    var vFirstName            = $("#vFirstName").val();
    var vLastName             = $("#vLastName").val();
    var dDob                  = $("#dDob").val();
    var vEmail                = $("#vEmail").val();
    var vPhone                = $("#vPhone").val();
    var vIdentificationNo     = $("#vIdentificationNo").val();
    var iCost                 = $("#iCost").val();
	  var tAdvisorProfileDetail = $("#tAdvisorProfileDetail").val();
    var tBio                  = $("#tBio").val();
    var tEducationDetail      = $("#tEducationDetail").val();
    var vExperince            = $("#vExperince").val();
    var tDescription          = $("#tDescription").val();
    var vImage                = $("#vImage").val();
    var eStatus               = $("#eStatus").val();
    var ProfessionCheckbox = $(".ProfessionCheckbox:checkbox:checked").length;
    
    var error                 = false;

    if(vAdvisorProfileTitle.length == 0){
        $("#vAdvisorProfileTitle_error").show();
        error = true;
    } else{
        $("#vAdvisorProfileTitle_error").hide();
    }
    if(vCompanyName.length == 0){
        $("#vCompanyName_error").show();
        error = true;
    } else{
        $("#vCompanyName_error").hide();
    }
    if(vFirstName.length == 0){
        $("#vFirstName_error").show();
        error = true;
    } else{
        $("#vFirstName_error").hide();
    }
    if(vLastName.length == 0){
        $("#vLastName_error").show();
        error = true;
    } else{
        $("#vLastName_error").hide();
    }
    if(dDob.length == 0){
        $("#dDob_error").show();
        error = true;
    } else{
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
    if(vPhone.length == 0){
        $("#vPhone_error").show();
        error = true;
    } else{
        $("#vPhone_error").hide();
    }
    if(vIdentificationNo.length == 0){
        $("#vIdentificationNo_error").show();
        error = true;
    } else{
        $("#vIdentificationNo_error").hide();
    } 
     if (iCost.length == 0) 
     {
      $("#iCost_error").show();
      error= true;
     } else {
        if (iCost > 100) 
        {
            $("#iCost_max_error").show();
            error= true;
        }        
    }

	/* if (vAdvisorProfileName.length == 0) {
		$("#vAdvisorProfileName_error").show();
		error = true;
	} else {
		$("#vAdvisorProfileName_error").hide();
	} */
	if (tAdvisorProfileDetail.length == 0) {
		$("#tAdvisorProfileDetail_error").show();
		error = true;
	} else {
		$("#tAdvisorProfileDetail_error").hide();
	}
  if (ProfessionCheckbox <= 0) {
          $("#profession_error").show();
          error = true;
      } else {
          $("#profession_error").hide();
      }
    if(tBio.length == 0){
        $("#tBio_error").show();
        error = true;
    } else{
        $("#tBio_error").hide();
    }
    if(tEducationDetail.length == 0){
        $("#tEducationDetail_error").show();
        error = true;
    } else{
        $("#tEducationDetail_error").hide();
    }
    if(vExperince.length == 0){
        $("#vExperince_error").show();
        error = true;
    } else{
        $("#vExperince_error").hide();
    }
    if(tDescription.length == 0){
        $("#tDescription_error").show();
        error = true;
    } else{
        $("#tDescription_error").hide();
    }

    if(eStatus.length == 0){
        error = true;
        $("#eStatus_error").show();
    } else{
        $("#eStatus_error").hide();
    }

    setTimeout(function(){
      if(error == true){
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
</script>
@endsection
