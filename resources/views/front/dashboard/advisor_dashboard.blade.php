@extends('layouts.app.front-app')
@section('title', 'Dashboard '.env('APP_NAME'))
@section('content')
@php
    // dd($session_data);
    // dd($my_advisor_profile);
@endphp
<section class="my-dashbord">
    <div class="container">
        <div class="row">
            @include('layouts.front.left_dashboard')
            <div class="col-lg-9">
                <div class="right-panal-side">
                    @include('layouts.front.header_dashboard')
                     <div class="row mt-3 padding-no">
                        <div class="letest-activity">
                            @if(!empty($my_advisor_profile))
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="sell-yiur-bussinrs-activity-listing margin-top-foruthy">
                                            <div class="left-text">
                                                <h3 class="activity-hading">My Advisor Profile</h3>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12 mt-3">
                                        <div class="business-detail-box sell-bussines-box">
                                            <div class="frist-box">
                                                <div class="title-hading-main">
                                                    <a href="" class="main-title" style="display: inline-block;">
                                                        <h2>{{$my_advisor_profile->vAdvisorProfileTitle}} </h2>

                                                    </a><span class="new-rating">Rating<i class="fas fa-star" style="color: var(--yellowcolor); margin-left: 7px; margin-right: 5px;"></i>

                                                        @if($my_advisor_profile->vAverageRating == NULL || $my_advisor_profile->vAverageRating == 0)
                                                            {{'No Rating'}}
                                                        @else
                                                            {{$my_advisor_profile->vAverageRating}}
                                                        @endif 
                                                        {{-- 8.5 / 10  --}}

                                                    {{count($advisor_receive_request_data)}}</span>
                                                    @if($my_advisor_profile->eAdminApproval == 'Pending')
                                                        <p class="text-warning">{{'Admin Approval is Pending'}} </p>
                                                    @endif
                                                </div>
                                                <div class="frist-box-part mt-3 listing-detail-main">
                                                    <div class="row">
                                                        <div class="col-md-3 col-sm-4">
                                                            <div class="business-box-img">
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
                                                                <img src="{{ asset($current_image) }}" alt="{{ asset('uploads/business-advisor/profile/' . $image_name) }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9 col-sm-8">
                                                            <div class="">
                                                                <p class="advisor-detail-info">- {{$my_advisor_profile->tAdvisorProfileDetail}}</p>
                                                            </div>
                                                            <div class="new-saling-text">
                                                                <ul>
                                                                   <!--  <li class="full-sale-detail">
                                                                        <label><b>Full Sale</b></label>
                                                                        <p class="mb-0">KES 95 lakh</p>
                                                                    </li>
                                                                    <li class="run-rate-revenu">
                                                                        <label><b>Run Rate Revenue</b></label>
                                                                        <p class="mb-0">KES 48 lakh @ 15 % EBITDA</p>
                                                                    </li> -->
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="view-peofile-btn listing-button-view">
                                                    <a href="@if($my_advisor_profile->eAdminApproval == 'Approved') {{ url('advisor-detail',$my_advisor_profile->vUniqueCode)}} @endif" class="sell-busines-view-profile btn btn-primary bg-green">View Profile</a>
                                                    <a href="{{ url('advisor-edit',$my_advisor_profile->vUniqueCode)}}" class="sell-busines-view-profile btn btn-primary bg-blue">Edit Advisor Profile</a>
                                                    <a href="@if($my_advisor_profile->eAdminApproval == 'Approved') {{ url('advisor-detail',$my_advisor_profile->vUniqueCode)}} @endif" class="btn btn-primary bg-orange">Contact Bussines</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
<script>
    $(document).on('click', '#accept', function() {
        var iConnectionId = $(this).data("id");
            $.ajax({
                url: "{{ url('accept_reject_connection') }}",
                type: "POST",
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                data: {
                    iConnectionId: iConnectionId,connectionType:'accept'
                },
                success: function(response) {
                    if(response == 0){
                            location.reload();
                    }   
                }
            });        
    });
      $(document).on('click', '#reject', function() {
        var iConnectionId = $(this).data("id");
            $.ajax({
                url: "{{ url('accept_reject_connection') }}",
                type: "POST",
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                data: {
                    iConnectionId: iConnectionId,connectionType:'reject'
                },
                success: function(response) {
                    if(response == 0){
                            location.reload();
                    }   
                }
            });        
    });
</script>
@endsection