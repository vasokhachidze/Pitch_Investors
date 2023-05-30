@extends('layouts.app.front-app')
@section('title', 'About Us - '.env('APP_NAME'))
@section('content')

    <!-- banner section start -->
    <section class="about-bread-camp">
      <div class="container">
          <div class="col-md-9">
            <div class="bread-text-head">
              <h4><a class="bread-tag-hover" href="{{ route('front.home') }}">Home</a> / About us</h4>
              <p>PitchInvestors is a B2B company developing a banking platform that automates deal origination, business valuation, deal matching, and the introduction of businesses and investors. The company connects business owners, entrepreneurs, CEOs, investors, and lenders.</p>
              <!-- <button type="submit" class="btn">Watch Video</button> -->
          </div>
          </div>
      </div>
    </section>
    <!-- banner section end -->

    <!-- about section start -->
    <section class="about-detail">
      <div class="container">
        <h2 class="top-head">About Us</h2>
        <div class="about-dec-warp">
          <!-- <h5>Mission statement:</h5> <p>To help businesses raise capital in Africa by connecting them to investors and business advisors</p>
          <h5>Vision statement:</h5> <p>To ensure all businesses in Africa have affordable access to capital whenever they need capital.</p> -->
          <!-- <h5>Our Story</h5> -->
        <p>PitchInvestors is a result of my lifelong desire to create a company focused on helping SMEs grow.</p> 
        <p style="text-align: justify;">In Kenya and by extension Africa, Micro, Small and Medium Size Enterprises (MSMEs) contribute hugely to the economy. They employ 74% of the country's working population and contribute 54% to the country’s GDP. One of the biggest challenges faced by MSMEs is the lack of capital to properly manage their working capital and invest in fixed capital for growth. As a result, they fail to grow and many times are forced to close down. The other challenge comes with poor financial management and planning. Given that most MSMEs are managed by individuals with no financial background and who can hardly afford to employ one full-time accountant or financial analyst. Many fail to plan well and develop realistic budgets that cover areas such as tax, working capital and CAPEX.</p>
        <p>PitchInvestors aims to help MSMEs tackle these two problems. The platforms connect investors looking for an investment opportunity to investments. This way, the MSMEs can access the capital needed to run their operations and expand. The platform also connects qualified financial advisors to MSMEs on a freelance contract. This helps MSMEs get the needed financial advice to help them better plan and manage their finances. We truly believe that the value we create extends beyond the success of MSMEs, but to the economy as a whole. This is the true power of technology.</p>
                
          <div class="sign-img">
            <img src="{{asset('uploads/front/aboutus/s.png')}}" alt="">
          </div>
          <div class="honor-name">
            <h4>Ochieng Rodgers</h4>
            <h5>Founder & CEO</h5>
          </div>
        </div>
      </div>
    </section>
    <!-- about section end -->



     <!-- grt-in touch section start -->
     <!-- <section class="get-touch">
      <div class="container">
        <div class="row">
          <div class="col-md-5">
            <div class="get-touch-img">
              <img src="{{asset('uploads/front/aboutus/men1.png')}}" alt="">
            </div>
          </div>
          <div class="col-md-7 get-touch-message">
            <div class="get-message">
              <h1>Get In Touch</h1>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In nibh neque proin vel, molestie nec, lobortis viverra. Nunc, amet etiam etiam velit aliquet. Proin tincidunt nec lacus pretium nulla facilisi et. Nunc fermentum sem faucibus ut morbi elit erat dictum.</p>
              <div class="send-message">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Email" aria-label="Recipient's username" aria-describedby="basic-addon2">
                  <span class="input-group-text" id="basic-addon2">Send</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
     </section> -->
     <!-- grt-in touch section end -->
@endsection
