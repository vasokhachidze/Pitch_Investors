@php
$general_company = \App\Helper\GeneralHelper::setting_info('Company');
$copyrighte_text = $general_company['COPYRIGHTED_TEXT']['vValue'];
$footer_discription = $general_company['FOOTER_DESCRIPTION']['vValue'];
$company_number = $general_company['COMPANY_NUMBER']['vValue'];

$general_social = \App\Helper\GeneralHelper::setting_info('Social');
$social_facebook = $general_social['SOCIAL_FACEBOOK']['vValue'];
$social_twitter = $general_social['SOCIAL_TWITTER']['vValue'];
$social_linkedin = $general_social['SOCIAL_LINKEDIN']['vValue'];
$social_insrtagram = $general_social['SOCIAL_INSTAGRAM']['vValue'];
$social_youtube = $general_social['SOCIAL_YOUTUBE']['vValue'];

$session_data = session('user');
if (!empty($session_data)) 
{
  $advisorUser = App\Helper\GeneralHelper::get_advisor_data($session_data['iUserId']);
}
@endphp

<!--  footer start-->
<section class="footer">
  <div class="container">
    <div class="footer-logo logo-respnosive">
      <img src="{{asset('uploads/logo/'.$footer_logo)}}" alt="footer logo">
    </div>
    <ul class="ft-main">
      <li class="ft-logo-view">
        <div class="footer-logo">
          <img src="{{asset('uploads/logo/'.$footer_logo)}}" alt="footer logo">
        </div>
      </li>

      <!-- <ul class="ft-main-other"> -->
        <li class="footer-item-li second-list-type">
        <div class="ft-head">
          <h5>Advisors</h5>
        </div>
        <ul class="hover-effect">
          <li><a href="{{route('front.advisor.search','financial-analyst')}}">Financial Analyst</a></li>
          <li><a href="{{route('front.advisor.search','business-lawyer')}}">Business Lawyer</a></li>
          <li><a href="{{route('front.advisor.search','business-brokers')}}">Busines Brokers</a></li>
          <li><a href="{{route('front.advisor.search','ma-advisors')}}">M&A Advisors</a></li>
          <li><a href="{{route('front.advisor.search','accountant')}}">Accountant</a></li>
          <li><a href="{{route('front.advisor.search','tax-consultant')}}">Tax Consultant</a></li>
          <li><a href="{{route('front.advisor.search','commercial-real-estate-brokers')}}">Commercial Real Estate Brokers</a></li>
          <li><a href="{{route('front.advisor.search','investment-banks')}}">Investment Bankers</a></li>


          {{-- <li><a href="{{route('front.advisor.search','business-financial-consultants')}}">Businesses Seeking advisor</a></li>
          <li><a href="{{route('front.advisor.search','investment-banks')}}">Investment Bankers</a></li>
          <li><a href="{{route('front.advisor.search','ma-advisors')}}">M&A Advisors</a></li>
          <li><a href="{{route('front.advisor.search','business-brokers')}}">Business Brokers</a></li>
          <li><a href="{{route('front.advisor.search','commercial-real-estate-brokers')}}">CRE Brokers</a></li>
          <li><a href="{{route('front.advisor.search','financial-consultants')}}">Financial Consultants</a></li>
          <li><a href="{{route('front.advisor.search','business-accounting-firms')}}">Accountants</a></li>
          <li><a href="{{route('front.advisor.search','law-firms')}}">Law Firms</a></li> --}}
        </ul>
      </li>

      <li class="footer-item-li">
        <div class="ft-head">
          <h5>Investors</h5>
        </div>
        <ul class="hover-effect">
          <li><a href="{{route('front.investor.search','buying-business')}}">Acquiring / Buying a Business</a></li>
          <li><a href="{{route('front.investor.search','investing-business')}}">Investing in a Business</a></li>
          <li><a href="{{route('front.investor.search','lending-business')}}">Lending to a Business</a></li>
          <li><a href="{{route('front.investor.search','buying-property')}}">Buying Property</a></li>
          <li><a href="{{route('front.investor.search','corporate-investors')}}">Corporate Investors</a></li>
          <li><a href="{{route('front.investor.search','venture-capital-firms')}}">Venture Capital Firms</a></li>
          <li><a href="{{route('front.investor.search','private-equity-firms')}}">Private Equity Firms</a></li>
          <li><a href="{{route('front.investor.search','family-offices')}}">Family Offices</a></li>


          {{-- <li><a href="{{route('front.investor.search','individual-investors')}}">Individual Investors</a></li>
          <li><a href="{{route('front.investor.search','business-buyers')}}">Business Buyers</a></li>
          <li><a href="{{route('front.investor.search','corporate-investors')}}">Corporate Investors</a></li>
          <li><a href="{{route('front.investor.search','venture-capital-firms')}}">Venture Capital Firms</a></li>
          <li><a href="{{route('front.investor.search','private-equity-firms')}}">Private Equity Firms</a></li>
          <li><a href="{{route('front.investor.search','family-offices')}}">Family Offices</a></li>
          <li><a href="{{route('front.investor.search','business-lenders')}}">Business Lenders</a></li> --}}
        </ul>
      </li>

      {{-- <li class="footer-item-li">
        <div class="ft-head">
          <h5>Businesses</h5>
        </div>
        <ul class="hover-effect">
          <li><a href="{{route('front.investment.search','businesses-for-sale')}}">Businesses For Sale</a></li>
          <li><a href="{{route('front.investment.search','investment')}}" id="footer_search_for_investment" data-id="Investment" data-value="Investment"> Investment</a></li>
          <li><a href="{{route('front.investment.search','opportunities')}}" id="footer_search_for_investment" data-id="Investment" data-value="Opportunities">Opportunities</a></li>
          <li><a href="{{route('front.investment.search','businesses-loan')}}" id="footer_search_for_investment" data-id="Investment" data-value="Businesses Loan"> Businesses Loan</a></li>
          <li><a href="{{route('front.investment.search','business-assets-for-sale')}}" id="footer_search_for_investment" data-id="Investment" data-value="Business Assets For Sale">Business Assets For Sale</a></li>
        </ul>
      </li> --}}

      <!-- </ul> -->

      <!-- <ul class="ft-main-other-two"> -->
      {{-- <li class="footer-item-li">
        <div class="ft-head">
          <h5>Get Started</h5>
        </div>
        <ul class="hover-effect">
          <li><a href="{{url('investment-add')}}">Sell your Business</a></li>
          <li><a href="{{url('investor')}}"> Finance your Business</a></li>
          <li><a href="{{url('investment')}}"> Buy a Business</a></li>
          <li><a href="{{url('investment')}}"> Invest in a Business</a></li>
          <li><a href="{{url('investor')}}"> Value your Business</a></li>
          <li><a href="@if(empty($advisorUser)) {{url('advisor-add')}} @else {{ url('advisor-edit',$advisorUser->vUniqueCode)}} @endif
            "> Register as Advisor</a></li>
        </ul>
      </li> --}}

      <li class="footer-item-li">
        <div class="ft-head">
          <h5>Company</h5>
        </div>
        <ul class="hover-effect">
          <li><a href="{{url('about-us')}}">About</a></li>
          {{-- <li><a href="#"> Testimonials</a></li> --}}
          <li><a href="{{url('contact_us')}}">Contact Us</a></li>
        </ul>
      </li>

      {{-- <li class="footer-item-li">
        <div class="ft-head">
          <h5>Social link</h5>
        </div>
        <ul class="hover-effect">
          <li><a href="{{$social_facebook}}">Facebook</a></li>
          <li><a href="{{$social_linkedin}}">LinkedIn</a></li>
          <li><a href="{{$social_youtube}}">YouTube</a></li>
          <li><a href="{{$social_twitter}}">Twitter</a></li>
          <li><a href="{{$social_insrtagram}}">Instagram</a></li>
        </ul>
      </li> --}}
      <!-- </ul> -->

    </ul>

    <div class="ft-bottom">
      <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
          <div class="copy-right">
            <p>{{$copyrighte_text}}</p>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
          <div class="payment">
            <div class="payment-logo">
              <a href="#"><img src="{{asset('uploads/front/payment_images/visa.png')}}" alt=""></a>
              <a href="#"><img src="{{asset('uploads/front/payment_images/master.png')}}" alt=""></a>
              <a href="#"><img src="{{asset('uploads/front/payment_images/amex.png')}}" alt=""></a>
              <a href="#"><img src="{{asset('uploads/front/payment_images/strip.png')}}" alt=""></a>
            </div>
            <div class="usefull-links">
              <a href="{{url('privacy-policy')}}">Privacy Policy </a>
              <a href="{{url('terms-condition')}}">Terms of Use </a>
              <a href="#">Refund Policy </a>
            </div>
          </div>{{-- end payment div --}}
        </div>{{-- end col div --}}
      </div>{{-- end row div --}}
    </div>{{-- end ft-bottom div --}}
  </div>{{-- end container div --}}

  <div class="scrool-up">
    <button onclick="topFunction()" id="myscrollbtn" title="Go to top"><i class="fas fa-chevron-double-up"></i></button>
  </div>
</section>{{-- end footer section --}}

<script type="text/javascript">
/*$(document).on('click', '#footer_search_for_investment', function() 
{
    id = $(this).data('id');
    filterKeyword = $(this).data('value');
    alert(filterKeyword)
    
    setTimeout(function() 
    {
      $.ajax({
        url: "{{ url('footerSearchProfile') }}",
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          id: id,
          filterKeyword: filterKeyword
        },
        success: function(response) 
        {
          $("#listing-data").html(response);
          $("#ajax-loader").hide();
        }
      });
    }, 500);
});*/
</script>