@extends('layouts.app.front-app')
@section('title', 'Thank You - '.env('APP_NAME'))
@php
$general_favicon = \App\Helper\GeneralHelper::setting_info('Company');
$logo            = $general_favicon['COMPANY_LOGO']['vValue'];
$favicon         = $general_favicon['COMPANY_FAVICON']['vValue'];

@endphp
@section('custom-css')
<style>
    input:-webkit-autofill {
        -webkit-text-fill-color: white !important;
    }
</style>
@endsection
@php
$text = '';
$premium_service = base64_decode($premium_service);
if(isset($premium_service) && $premium_service == 1)  {
	$text = 'Thank you for adding your business to PitchInvestors with <b>Newsletter Service package</b>!<br> We appreciate your trust in our platform to help you secure funding and grow your business. We look forward to supporting you on your entrepreneurial journey.';
} else if(isset($premium_service) && $premium_service == 2)  {
	$text = 'Thank you for adding your business to PitchInvestors with <b>Social Media Service package</b>!<br> We appreciate your trust in our platform to help you secure funding and grow your business. We look forward to supporting you on your entrepreneurial journey.';
} else if(isset($premium_service) && $premium_service == 3)  {
	$text = 'Thank you for adding your business to PitchInvestors with <b>Newsletter and Social Media Service package</b>!<br> We appreciate your trust in our platform to help you secure funding and grow your business. We look forward to supporting you on your entrepreneurial journey.';
} else {
	$text = 'Thank you for adding your business to PitchInvestors! <br>We appreciate your trust in our platform to help you secure funding and grow your business. We look forward to supporting you on your entrepreneurial journey.';
}
@endphp
@section('content')
<section class="thankyou-page">
<div>
    <h2>Thank You!</h2>	
	<p>
	<?php echo $text; ?>
    </p>
         <div class="thankyou-icon">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="510.105px" height="459.104px" viewBox="51 166.396 510.105 459.104" enable-background="new 51 166.396 510.105 459.104"
	 xml:space="preserve">
<path fill="#6563FF" d="M415.395,312.105c9.918,9.999,26.063,10.064,36.063,0.148c0.05-0.049,0.099-0.1,0.148-0.148l101.999-102
	c10-9.999,10-26.211,0-36.21s-26.211-9.999-36.211,0L433.5,258.044l-32.895-33.149c-10-9.999-26.212-9.999-36.212,0
	c-9.999,9.999-9.999,26.211,0,36.21L415.395,312.105z M535.5,294c-14.083,0-25.5,11.418-25.5,25.5V549
	c0,14.084-11.417,25.5-25.5,25.5h-357c-14.083,0-25.5-11.416-25.5-25.5V304.455L251.94,454.65
	c14.312,14.193,33.647,22.168,53.805,22.186c20.664-0.105,40.454-8.352,55.08-22.951l43.858-43.858c9.999-10,9.999-26.211,0-36.21
	s-26.21-9.999-36.21,0l-44.625,44.625c-9.915,9.721-25.783,9.721-35.699,0L137.955,268.5H280.5c14.083,0,25.5-11.416,25.5-25.5
	c0-14.083-11.417-25.5-25.5-25.5h-153C85.25,217.5,51,251.75,51,294v255c0,42.25,34.25,76.5,76.5,76.5h357
	c42.25,0,76.5-34.25,76.5-76.5V319.5C561,305.417,549.583,294,535.5,294z"/>
<path fill="#FF6683" d="M415.395,312.105c9.918,9.998,26.063,10.064,36.063,0.146c0.05-0.049,0.099-0.099,0.148-0.146l101.999-102
	c10-9.999,10-26.211,0-36.21s-26.211-9.999-36.211,0L433.5,258.044l-32.895-33.149c-10-9.999-26.212-9.999-36.212,0
	c-9.999,10-9.999,26.21,0,36.21L415.395,312.105z"/>
</svg>

</div>
    <h4><a href="{{ url('/investmentDashboard') }}" style="  text-decoration: underline;">Click here</a> to go to Dashboard</h4>
    <!-- <p>If you didn't receive any email contact <a href="mailto:support@pitch-investors.com">support@pitch-investors.com</a></p> -->
</div>

</section>
@endsection
