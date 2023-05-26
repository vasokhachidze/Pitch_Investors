@extends('layouts.app.front-app')
@section('title', 'Investor Dashboard - '.env('APP_NAME'))

@section('content')
@php
    // dd($session_data);
@endphp
<style type="text/css">/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  /*display: none;*/
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>
<section class="my-dashbord">
    <div class="container">
        <div class="row">
            @include('layouts.front.left_dashboard')
            <div class="col-lg-9">
                <div class="right-panal-side">

                    <!-- Sell Your business section start -->
                    <div class="row mt-3 padding-no">
                        <div class="letest-activity">
                       
                      <!-- Investment tab start-->
                      <div id="Investment" class="tabcontent">
                          
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="sell-yiur-bussinrs-activity-listing margin-top-foruthy">
                                            <div class="left-text">
                                                <h3 class="activity-hading mt-4">NewsLetter </h3>
                                                <p style = "margin:10px">
                                                Pitch Investors is now offering an exclusive opportunity to feature your business in our monthly newsletter, which is sent to a growing community of over 300 investors.<br><br>
                                                This premium package is designed to showcase your business to a wider audience of potential investors and increase your chances of securing the investment you need to grow your business. With this package, you will receive a dedicated feature in our monthly newsletter, highlighting the unique value proposition of your business and the potential for growth and profitability.
                                                </p>
                                            </div>
                                          
                                        </div>
                                    </div>
                                   
                                                           
                                </div>
                            

                            
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="sell-yiur-bussinrs-activity-listing margin-top-foruthy">
                                            <div class="left-text">
                                                <h3 class="activity-hading mt-4">Soical Media </h3>
                                                <p style = "margin:10px">Pitch Investors is excited to offer an exclusive opportunity to promote your business to our network of investors through our social media channels. With our premium package, we will share your business on our LinkedIn, Facebook, and Twitter pages, connecting you with potential investors who are actively seeking new opportunities.<br><br>
Our social media platforms are a powerful tool for expanding your reach and building credibility with potential investors. By featuring your business on our channels, you can tap into our network of followers and increase your visibility to a wider audience of potential investors.</p>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                          
                      </div>
                      <!-- investment tab end-->

                      @if ($userData->is_premium == 0)
                      <a style = "margin:20px;" href="{{ url('/pesapal') }}" class="btn btn-primary bg-blue">Join Now</a>
                      @endif
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
</section>
@endsection
