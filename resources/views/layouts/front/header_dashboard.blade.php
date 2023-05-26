<style>

/* styles for screens between 768px and 1024px */
@media (min-width: 840px) and (max-width: 1395px) {
   .final-button{
        margin-top: 250px!important;
    }
}
@media (min-width: 576px) and (max-width: 843px) {
   .final-button{
        margin-top: 270px!important;
    }
}
@media (max-width: 575px) {
   .final-button{
        margin-top: 140px!important;
    }
}
</style>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6" data-bs-toggle="tooltip" data-bs-placement="top" title="No of Investment Profile">
        @php
            $investment_link = 'business-instruction';
            $investment_link_text = 'Invest Now';
            $investment_header_count = 0;
            if(count($investment_profile_count) > 0){
                $investment_link = 'investmentDashboard';
                $investment_link_text = 'My Investment Profile';
                $investment_header_count = count($investment_profile_count);
            }
        @endphp
        <a href="{{url('investmentDashboard')}}">
            <div class="profile-box-warp investment-businss">
                <div class="profile-box-detail">
                    <div class="btn-group dropstart my-change-dropdown" role="group">
                    <!--  <a type="button" class="btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="toggler-icon top-bar"></span>
                            <span class="toggler-icon middle-bar"></span>
                            <span class="toggler-icon bottom-bar"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <li><button class="dropdown-item" type="button">Action</button></li>
                            <li><button class="dropdown-item" type="button">Another action</button></li>
                            <li><button class="dropdown-item" type="button">Something else here</button>
                            </li>
                        </ul> -->
                    </div>
                    <div class="profile-number d-none">
                        <h2>{{$investment_header_count}}</h2>
                    </div>
                    <div class="profile-heading">
                        <h1>Businesses</h1>
                    </div>
                    <div class="other-detail" >
                        <p class="investment-detail-info" style="min-height: 0px; overflow: inherit;">
                           Click "Add Business" button and follow the steps to showcase your business to potential investors. Take the first step towards securing funding and growing your business with PitchInvestors.
                        </p>
                    </div>
                    <div class="final-button" style="margin-top: 160px;">
                        <!--<a href="{{url($investment_link)}}" class="btn btn-primary bg-orange">{{$investment_link_text}}</a>-->
                        <a href="{{url($investment_link)}}" class="btn btn-primary bg-orange">Add Business</a>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6" data-bs-toggle="tooltip" data-bs-placement="top" title="My Advisor profile connections">
        @php
            $advisor_link = 'advisor-add';
            $advisor_link_text = 'Advise Now';
            if(!empty($advisor_profile_count)){
                $advisor_link = 'advisorDashboard';
                $advisor_link_text = 'My Advisor Profile';
            }
        @endphp
        
        <a href="{{url($advisor_link)}}">
            <div class="profile-box-warp become-advisor">
                <div class="profile-box-detail">
                    {{-- <div class="btn-group dropstart my-change-dropdown" role="group">
                        <a type="button" class="btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="toggler-icon top-bar"></span>
                            <span class="toggler-icon middle-bar"></span>
                            <span class="toggler-icon bottom-bar"></span>
                        </a>
                        @php
                            $advisor_unique_id = '';
                        @endphp
                        @if (!empty($advisor_edit_data))
                            @php
                                $advisor_unique_id = $advisor_edit_data->vUniqueCode;
                            @endphp
                        @endif
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <li>
                                <a class="dropdown-item" href="{{route('front.advisor.edit',$advisor_unique_id)}}">Edit</a>
                            </li>
                        </ul>
                    </div> --}}
                    <div class="profile-number d-none">
                        <h2>{{$advisor_count}}</h2>
                    </div>
                    <div class="profile-heading">
                        <h1>Advisor</h1>
                    </div>
                    <div class="other-detail">
                        <p class="investment-detail-info" style="min-height: 0px; overflow: inherit;">
                           Create a new advisor profile on PitchInvestors and tap into a network of entrepreneurs and businesses seeking expert guidance. By clicking the "Add Advisor Profile" button, you can showcase your skills, experience, and specialties to potential clients and start earning as a freelance advisor. Join PitchInvestors and start earning today!
                        </p>
                    </div>
                    <div class="final-button" style="margin-top: 160px;">
                        <a href="{{url($advisor_link)}}" class="btn btn-primary bg-green">{{$advisor_link_text}}</a>
                    </div>
                </div>
            </div>
        </a>
        
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12" data-bs-toggle="tooltip" data-bs-placement="top" title="My Investor profile connections">
        <a href="{{'investorDashboard'}}">
            @php
                $investor_link = 'investor-add';
                $investor_link_text = 'Invest Now';
                if(!empty($investor_profile_count)){
                    $investor_link = 'investorDashboard';
                    $investor_link_text = 'My Investor Profile';
                }
            @endphp
        
            <div class="profile-box-warp sell-your-businss">
                <div class="profile-box-detail">
                    {{-- <div class="btn-group dropstart my-change-dropdown" role="group">
                        <a type="button" class="btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="toggler-icon top-bar"></span>
                            <span class="toggler-icon middle-bar"></span>
                            <span class="toggler-icon bottom-bar"></span>
                        </a>
                        @php
                            $investor_unique_id = '';
                        @endphp
                        @if (!empty($investor_edit_data))
                            @php
                                $investor_unique_id = $investor_edit_data->vUniqueCode;
                            @endphp
                        @endif
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <li>
                                <a class="dropdown-item" href="{{route('front.investor.edit',$investor_unique_id)}}">Edit</a>
                            </li>
                            
                        </ul>
                    </div> --}}
                    <div class="profile-number d-none">
                        <h2>{{$investor_count}}</h2>
                    </div>
                    <div class="profile-heading">
                        <h1>Investor</h1>
                    </div>
                    <div class="other-detail">
                        <p class="investment-detail-info" style="min-height: 0px; overflow: inherit;">
                           Join the world of investment opportunities with PitchInvestors. By clicking the "Add Investor" button, you can create a profile and gain access to a diverse range of businesses and entrepreneurs seeking funding. Explore and invest in the projects that align with your interests and goals. Start your investment journey with PitchInvestors today!
                        </p>
                    </div>
                    <div class="final-button"  style="margin-top: 160px;">
                       {{--  @if (!empty($investor_profile_count))
                            <a href="{{url('investorDashboard')}}" class="btn btn-primary bg-blue">Invest Now</a>
                        @else
                            <a href="{{url($investor_link)}}" class="btn btn-primary bg-blue">{{$investor_link}}</a>
                        @endif --}}
                        <!--<a href="{{url($investor_link)}}" class="btn btn-primary bg-blue">{{$investor_link_text}}</a>-->
                        <a href="{{url($investor_link)}}" class="btn btn-primary bg-blue">Add Investor</a>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>