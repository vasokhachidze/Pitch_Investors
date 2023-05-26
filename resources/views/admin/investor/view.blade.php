@extends('layouts.app.admin-app')
@section('title', 'Investor - ' . env('APP_NAME'))

@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css"
        integrity="sha512-TQQ3J4WkE/rwojNFo6OJdyu6G8Xe9z8rMrlF9y7xpFbQfW5g8aSWcygCQ4vqRiJqFsDsE1T6MoAOMJkFXlrI9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
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
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Profile Title</label>
                                            <p>@if (isset($investor)) {{ $investor->vProfileTitle }} @endif</p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>First Name</label>
                                            <p>@if (isset($investor)) {{ $investor->vFirstName }} @endif</p>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Last Name</label>
                                            <p>@if (isset($investor)) {{ $investor->vLastName }} @endif</p>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>DOB</label>
                                            <p>@if (isset($investor)) {{ date('d-F-Y', strtotime($investor->dDob)) }} @endif</p>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Email</label>
                                            <p>@if (isset($investor)){{$investor->vEmail}}@endif</p>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Phone</label>
                                            <p>@if (isset($investor)) {{ $investor->vPhone }} @endif</p>
                                        </div>
                                        
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Identification No</label>
                                            <p>@if (isset($investor)) {{ $investor->vIdentificationNo }} @endif</p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Investor Profile Name</label>
                                            <p>@if (isset($investor)) {{ $investor->vInvestorProfileName }} @endif</p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Investor Profile Detail</label>
                                            <p>@if (isset($investor)) {{ $investor->tInvestorProfileDetail }} @endif</p>
                                        </div> 
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Company website, or LinkedIn profile</label>
                                            <p>@if (isset($investor)) {{ $investor->vCompanyWebsite }} @endif</p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Nationality</label>
                                            
                                            <p>    @foreach ($countries as $value)
                                                        @if (isset($investor)) @if ($investor->iNationality == $value->iCountryId) {{ $value->vNationality }} @endif
                                                        @endif
                                                @endforeach </p>
                                            </select>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>City</label>
                                            <p>
                                                @if (!empty($investor->iCity) ) {{ $investor->iCity }}@else {{ 'N/A' }} @endif
                                            </p>                                            
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Investing Experience</label>
                                              <p>  @if (isset($investor)) @if ($investor->eInvestingExp == 'Yes') {{'Yes'}} @endif
                                                    @endif
                                                   @if (isset($investor)) @if ($investor->eInvestingExp == 'No') {{'No'}} @endif
                                                    @endif
                                              </p>
                                            </p>
                                        </div> 
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Will you need a business advisor to guide you?</label>
                                            <p>     @if (isset($investor)) @if ($investor->eAdvisorGuide == 'Yes') {{'Yes'}} @endif @endif
                                                    @if (isset($investor)) @if ($investor->eAdvisorGuide == 'No') {{'No'}} @endif @endif
                                            </p>
                                        </div>
                                         <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Are You</label>
                                            <p>
                                                @if (isset($investor)) @if ($investor->eInvestorType == 'Individual') {{'Individual Investors'}} @endif @endif
                                                @if (isset($investor)) @if ($investor->eInvestorType == 'Institutional') {{'Institutional Investors'}} @endif @endif
                                            </p>
                                        </div>

                                      
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Investment industries</label>
                                            <p>
                                                @php
                                                    // dd($selected_industries);
                                                    $industry_select = '';
                                                @endphp
                                                

                                                @foreach ($industries as $value)
                                                    @php
                                                        $industry_select = '';
                                                    @endphp
                                                    @if (isset($selected_industries))
                                                        @foreach ($selected_industries as $industry)
                                                            @if( $value->iIndustryId == $industry->iIndustryId)
                                                            {{ $value->vName }},
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    
                                                @endforeach
                                            </p>
                                        </div>


                                        <div class="form-group col-xl-6 col-lg-12 col-md-6 checkbox">
                                            <label>When do you want to invest?</label></br>
                                            <p> @if (isset($investor) and $investor->vWhenInvest == 'next12') {{ 'Next 12 Month' }} @endif
                                                @if (isset($investor) and $investor->vWhenInvest == 'after12') {{ 'After 12 Month' }} @endif</p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6 checkbox">
                                            <label>You are intrested in...</label></br>

                                            <p>@if (isset($investor) and $investor->eAcquiringBusiness == 'Yes') {{ 'Acquiring / Buying a Business' }} @endif</p>
                                            <p>@if (isset($investor) and $investor->eInvestingInBusiness == 'Yes') {{ 'Investing in a Business' }} @endif</p>
                                            <p> @if (isset($investor) and $investor->eLendingToBusiness == 'Yes') {{ 'Lending to a Business' }} @endif</p>
                                            <p>@if (isset($investor) and $investor->eBuyingProperty == 'Yes') {{ 'Buying Property / Plant / Machinery' }} @endif</p> 
                                            <p>@if (isset($investor) and $investor->eCorporateInvestor == 'Yes') {{ 'Corporate Investors' }} @endif</p>
                                            <p>@if (isset($investor) and $investor->eVentureCapitalFirms == 'Yes') {{ 'Venture Capital Firms' }} @endif</p>
                                            <p>@if (isset($investor) and $investor->ePrivateEquityFirms == 'Yes') {{ 'Private Equity Firms' }} @endif</p>
                                            <p>@if (isset($investor) and $investor->eFamilyOffices == 'Yes') {{ 'Family Offices' }} @endif</p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6 checkbox">
                                            <label>How much would you like to invest?</label>
                                            <p>  @if (isset($investor) and $investor->vHowMuchInvest == '100K - 1M') {{ '100K - 1M' }} @endif</p>
                                            <p> @if (isset($investor) and $investor->vHowMuchInvest == '1M - 5M') {{ '1M - 5M' }} @endif</p>
                                            <p>@if (isset($investor) and $investor->vHowMuchInvest == '5M - 10M') {{ '5M - 10M' }} @endif</p>
                                            <p> @if (isset($investor) and $investor->vHowMuchInvest == '10M+') {{ '10M+' }} @endif</p>
                                        </div>
                                         
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Factors In Business</label>
                                             <p>@if (isset($investor)){!! $investor->tFactorsInBusiness !!}@endif</p>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>About your company</label>
                                            <p>@if (isset($investor))  {!! $investor->tAboutCompany !!} @endif</p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Status</label>
                                            <p> @if (isset($investor)) @if ($investor->eStatus == 'Active') {{'Active'}} @endif @endif
                                                @if (isset($investor)) @if ($investor->eStatus == 'Inactive') {{'Inactive'}} @endif @endif</p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Show On Home Page</label>
                                                <p>@if (isset($investor)) @if ($investor->eShowHomePage == 'Yes') {{'Yes'}} @endif @endif
                                                    @if (isset($investor)) @if ($investor->eShowHomePage == 'No') {{'No'}} @endif @endif</p>
                                        </div>
                                         <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Profile Image</label>                                            
                                             @php
                                                $image = asset('uploads/default/no-image.png');
                                                if (isset($image_data)) {
                                                    if ($image_data->vImage != '') {
                                                        $image = asset('uploads/investor/profile/' . $image_data->vImage);
                                                    }
                                                }
                                            @endphp
                                            <img id="img" class="d-block mt-2" width="100px" height="100px" src="{{ $image }}">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   
@endsection
