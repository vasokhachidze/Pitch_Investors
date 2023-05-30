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
              <div class="card-body">
                <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if(isset($advisor)){{$advisor->vUniqueCode}}@endif">
                <div class="row">
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Profile Title</label>
                      <p>@if(isset($advisor)){{$advisor->vAdvisorProfileTitle}}@endif</p>
                      
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Company Name</label>
                      <p>@if(isset($advisor)){{$advisor->vCompanyName}}@endif</p>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>First Name</label>
                      <p>@if(isset($advisor)){{$advisor->vFirstName}}@endif</p>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Last Name</label>
                      <p>@if(isset($advisor)){{$advisor->vLastName}}@endif</p>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>DOB</label>
                      <p>@if(isset($advisor)){{date('d-F-Y',strtotime($advisor->dDob))}}@endif</p>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Email</label>
                      <p>@if(isset($advisor)){{$advisor->vEmail}}@endif</p>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Phone</label>
                      <p>@if(isset($advisor)){{$advisor->vPhone}}@endif</p>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Identification No</label>
                      <p>@if(isset($advisor)){{$advisor->vIdentificationNo}}@endif</p>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Cost ( Please enter cost in Percentage )</label>
                      <p>@if(isset($advisor)){{$advisor->iCost}}@endif</p>
                  </div>

        					<div class="form-group col-xl-6 col-lg-12 col-md-6">
        						<label>Advisor Profile Detail</label>
        						<p>@if (isset($advisor)){{$advisor->tAdvisorProfileDetail}}@endif</p>
        					</div>

                   <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Location</label>
                     <p>
                     @foreach($location as  $key => $value)
                      @php
                        $region_select = '';
                        $county_select = '';
                        $subcounty_select = '';
                      @endphp

                      @if(isset($selected_location))
                        @foreach($selected_location as  $key => $lvalue)
                          @if($lvalue->iLocationId == $value['regionId'] && $lvalue->eLocationType == 'Region')
                            {{$value['regionName']}}
                          @endif
                        @endforeach
                      @endif
                        

                        @foreach($value as  $key1 => $value1)
                          @if (in_array($key1,['regionId','regionName']))
                            @continue
                          @endif

                          @if(isset($selected_location))
                            @foreach($selected_location as  $key => $lvalue1)
                              @if($lvalue1->iLocationId == $value1['countyId'] && $lvalue1->eLocationType == 'County')
                                {{$value1['countyName']}}
                              @endif
                            @endforeach
                          @endif
                          
                          @foreach($value1 as  $key2 => $value2)
                            @if (in_array($key2,['countyId','countyName']))
                              @continue
                            @endif

                             @if(isset($selected_location))
                               @foreach($selected_location as  $key => $lvalue)
                                  @if($lvalue->iLocationId == $value2['iSubCountId'] && $lvalue->eLocationType == 'Sub County')
                                    {{ $value2['subCountyName'] }}
                                  @endif
                                @endforeach
                              @endif
                            
                          @endforeach
                        @endforeach
                      @endforeach
                    </p>

                  </div>

                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Advisor Industries</label>
                    
                      @php
                        $industry_select = '';
                      @endphp
                      @foreach($industries as  $ivalue)
                        @if(isset($selected_industries))
                          @foreach ($selected_industries as $industry)
                            @if($industry->iIndustryId == $ivalue->iIndustryId)
                              <p> {{$ivalue->vName }}, </p>
                            @endif
                          @endforeach
                        @endif                        
                      @endforeach                    
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Status</label>
                    <p>
                      @if($advisor->eStatus == 'Active') {{'Active'}} @endif 
                      @if($advisor->eStatus == 'Inactive') {{'Inactive'}} @endif 
                    </p>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label></label>
                  </div>

                  <div class="form-group col-xl-6 col-lg-12 col-md-6 checkbox">
                      <label>Profession Title</label></br>
                      <p>@if (isset($advisor) and $advisor->eFinancialAnalyst == 'Yes') {{ 'Businesses Seeking advisor' }} @endif</p>
                      <p>@if (isset($advisor) and $advisor->eInvestmentBanks == 'Yes') {{ 'Investment Banks' }} @endif</p>
                      <p> @if (isset($advisor) and $advisor->eMandAAdvisor == 'Yes') {{ 'M&A Advisors' }} @endif</p>
                      <p>@if (isset($advisor) and $advisor->eBusinessBrokers == 'Yes') {{ 'Business Brokers' }} @endif</p>
                      <p>@if (isset($advisor) and $advisor->eCommercialRealEstateBrokers == 'Yes') {{ 'CRE Brokers' }} @endif</p>
                      <p>@if (isset($advisor) and $advisor->eTaxConsultant == 'Yes') {{ 'Financial Consultants' }} @endif</p>
                      <p>@if (isset($advisor) and $advisor->eAccountant == 'Yes') {{ 'Accountants' }} @endif</p>
                      <p>@if (isset($advisor) and $advisor->eBusinessLawer == 'Yes') {{ 'Law Firms' }} @endif</p>
                  </div>

                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Education Detail</label>
                    <p>@if(isset($advisor)){!! $advisor->tEducationDetail !!}@endif</p>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Bio (Self)</label>
                   <p>@if(isset($advisor)){!! $advisor->tBio !!}@endif</p>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Work Experience</label>
                    <p>@if(isset($advisor)){!! $advisor->vExperince !!}@endif</p>                    
                  </div>

                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Discription</label>
                    <p>@if(isset($advisor)){{$advisor->tDescription}}@endif</p>
                  </div>
                 

                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Show On Home Page</label>
                      <p>
                      @if(isset($advisor)) @if($advisor->eShowHomePage  == 'Yes') {{'Yes'}} @endif @endif
                      @if(isset($advisor)) @if($advisor->eShowHomePage  == 'No') {{'No'}} @endif @endif
                    </p>
                  </div>
                  
                </div> {{-- end row --}}
              
              </div>{{-- end card-body --}}
            
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

@endsection
