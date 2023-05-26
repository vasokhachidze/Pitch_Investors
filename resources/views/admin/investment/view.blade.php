@extends('layouts.app.admin-app')
@section('title', 'Investment - ' . env('APP_NAME'))
@php
// dd($investment);
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
                                <div class="card-body">
                                    <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if (isset($investment)) {{ $investment->vUniqueCode }} @endif">
                                    <div class="row">
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>First Name</label>
                                            <p>@if (isset($investment)) {{ $investment->vFirstName }} @endif</p>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Last Name</label>
                                            <p>@if (isset($investment)) {{ $investment->vLastName }} @endif</p>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>DOB</label>
                                            <p>@if (isset($investment)) {{ date('d-F-Y', strtotime($investment->dDob)) }} @endif</p>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Email</label>
                                            <p>@if(isset($investment)){{$investment->vEmail}}@endif</p>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Phone</label>
                                            <p>@if (isset($investment)) {{ $investment->vPhone }} @endif</p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Identification No</label>
                                            <p>@if (isset($investment)) {{ $investment->vIdentificationNo }} @endif</p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Business Name</label>
                                            <p>@if (isset($investment)) {{ $investment->vBusinessName }} @endif</p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Business Eltablished</label>
                                            <p>@if (isset($investment)) {{ $investment->vBusinessEstablished }} @endif</p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Business Profile Name</label>
                                            <p>@if (isset($investment)) {{ $investment->vBusinessProfileName }} @endif</p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Business Profile Detail</label>
                                            <p>@if (isset($investment)) {{ $investment->tBusinessProfileDetail }} @endif</p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Location</label>
                                            <p>
                                                @foreach ($location as $key => $value)
                                                    @php
                                                        $region_select = '';
                                                        $county_select = '';
                                                        $subcounty_select = '';
                                                    @endphp

                                                    @if (isset($selected_location))
                                                        @foreach ($selected_location as $key => $lvalue)
                                                            @if ($lvalue->iLocationId == $value['regionId'] && $lvalue->eLocationType == 'Region')
                                                               {{$value['regionName']}}
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    
                                                    @foreach ($value as $key1 => $value1)
                                                        @if (in_array($key1, ['regionId', 'regionName']))
                                                            @continue
                                                        @endif

                                                        @if (isset($selected_location))
                                                            @foreach ($selected_location as $key => $lvalue)
                                                                @if ($lvalue->iLocationId == $value1['countyId'] && $lvalue->eLocationType == 'County')
                                                                   {{$value1['countyId']}}
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        
                                                        @foreach ($value1 as $key2 => $value2)
                                                            @if (in_array($key2, ['countyId', 'countyName']))
                                                                @continue
                                                            @endif

                                                            @if (isset($selected_location))
                                                                @foreach ($selected_location as $key => $lvalue)
                                                                    @if ($lvalue->iLocationId == $value2['subCountyName'] && $lvalue->eLocationType == 'Sub County')
                                                                       {{$value2['subCountyName']}}
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                            
                                                        @endforeach
                                                    @endforeach
                                                @endforeach</p>
                                            </select>
                                            <div id="locations_error" class="error mt-1" style="color:red;display: none;">Please Select Location</div>
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
                                                            @if ($industry->iIndustryId == $value->iIndustryId)
                                                                {{$value->vName}}
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6 checkbox">
                                            <label>Business Profile</label></br>
                                            <p>
                                                @if (isset($investment) and $investment->eBusinessProfile == 'Business owner') {{ 'Business owner' }}  <br>@endif
                                            
                                             @if (isset($investment) and $investment->eBusinessProfile == 'Business Broker') {{ 'Business Broker' }}   </br> @endif

                                             @if (isset($investment) and $investment->eBusinessProfile == 'Business advisor') {{ 'Business advisor' }} </br>@endif </p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6 checkbox">
                                            <label>You are intrested in...</label></br>
                                                <p>
                                            @if (isset($investment) and $investment->eFullSaleBusiness == 'Yes') {{ 'Full sale of business' }}, @endif

                                            @if (isset($investment) and $investment->eLoanForBusiness == 'Yes') {{ 'Loan for business' }}, </br> @endif 

                                            @if (isset($investment) and $investment->ePartialSaleBusiness == 'Yes') {{ 'Partial sale of business/Investment' }}, </br> @endif 
                                            
                                            @if (isset($investment) and $investment->eBailout == 'Yes') {{ 'Distressed company looking for bailout' }}, </br> @endif

                                            @if (isset($investment) and $investment->eBusinessAsset == 'Yes') {{ 'Selling or leasing out business asset' }} @endif
                                            </p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6 checkbox">
                                            <label>Business legal entity type</label></br>
                                            <p>
                                            @if (isset($investment) and $investment->eSoleProprietor == 'Yes') {{ 'Sole proprietor' }} @endif

                                            @if (isset($investment) and $investment->eGeneralPartnership == 'Yes') {{ 'General partnership' }} @endif

                                            @if (isset($investment) and $investment->eLLP == 'Yes') {{ 'Limited liability partnership (LLP)' }} @endif

                                            @if (isset($investment) and $investment->eLLC == 'Yes') {{ 'Limited liability company (LLC)' }} @endif </p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6 checkbox">
                                            <label>Business legal entity type</label></br><p>
                                            @if (isset($investment) and $investment->ePrivateCompany == 'Yes') {{ 'Private company' }} @endif
                                            @if (isset($investment) and $investment->ePrivateLimitedCompany == 'Yes') {{ 'Public limited company' }} @endif
                                            @if (isset($investment) and $investment->eSCorporation == 'Yes') {{ 'S corporation' }} @endif                                            
                                            @if (isset($investment) and $investment->eCCorporation == 'Yes') {{ 'C corporation' }} @endif</p>
                                        </div>


                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Describe Your Business</label>
                                            <p> @if (isset($investment)){{ $investment->tBusinessDetail }}@endif</p>
                                            
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>High lights Of Business</label>
                                            <p> @if (isset($investment)){{ $investment->tBusinessHighLights }}@endif</p>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Describe your facility</label>
                                            <p> @if (isset($investment)){{ $investment->tFacility }}@endif</p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>List of products and services </label>
                                                <p> @if (isset($investment)){{ $investment->tListProductService }}@endif</p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Annual sales? (in KES)</label>
                                            <p>@if (isset($investment)) {{ $investment->vAverateMonthlySales }} @endif</p>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>What is the EBITDA / Operating Profit Margin Percentage?
                                                (Percentage)</label>
                                            <p>@if (isset($investment)) {{ $investment->vProfitMargin }} @endif</p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>What is the value of physical assets owned by the business?</label>
                                            <p>@if (isset($investment)) {{ $investment->vPhysicalAssetValue }} @endif</p>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>What is the maximum stake you are willing to sell? (Should be in
                                                percentage)</label>
                                            <p>@if (isset($investment)) {{ $investment->vMaxStakeSell }} @endif</p>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>What investment amount are you seeking for this stake? </label>
                                            <p>@if (isset($investment)) {{ $investment->vInvestmentAmountStake }} @endif</p>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Provide reason for investment</label>
                                            <p>@if (isset($investment)) {{ $investment->tInvestmentReason }} @endif</p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Show On Home Page</label>
                                            <p>@if (isset($investment)) @if ($investment->eShowHomePage == 'Yes') {{'Yes'}} @endif @endif
                                             @if (isset($investment)) @if ($investment->eShowHomePage == 'No') {{'No'}} @endif @endif</p>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Profile Image</label>                                            
                                            @php
                                                $image = asset('uploads/default/no-image.png');
                                                if (!empty($profile)) {
                                                    $image = asset('uploads/investment/profile/' . $profile[0]);
                                                }
                                            @endphp

                                            <img id="img" class="d-block mt-2" width="100px" height="100px" src="{{ $image }}">
                                        </div>

                                    </div>
                                </div> {{-- end row --}}
                               
                        </div>{{-- end card-body --}}

                            <input type="hidden" id="facility_image_upload_id" name="facility_image_upload_id">
                        
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
