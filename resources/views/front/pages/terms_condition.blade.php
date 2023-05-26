@extends('layouts.app.front-app')
@section('title', 'Terms & Conditions - '.env('APP_NAME'))
@section('content')

    <!-- banner section start -->
    <section class="about-bread-camp">
      <div class="container">
          <div class="col-md-9">
            <div class="bread-text-head">
              <h4><a class="bread-tag-hover" href="{{ route('front.home') }}">Home</a> / Terms & Conditions</h4>
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
        <h2 class="top-head">Terms & Conditions</h2>
        <div class="about-dec-warp">
        <p><b>@if($pageSetting[0]->vTitle != ""){{$pageSetting[0]->vTitle}}@endif</b></p> 
        <p>@if($pageSetting[0]->tDescription != ""){!! $pageSetting[0]->tDescription !!}@endif</p>
      
        </div>
      </div>
    </section>
    <!-- about section end -->
@endsection
