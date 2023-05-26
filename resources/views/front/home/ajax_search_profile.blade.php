<div class="profile_list custom-dropdown-lost">
	<div class="new">
	@if(!empty($investor))
	<label class="profile_listing_label">Investor</label>
	<ul class="listing">
		@foreach ($investor as $value)
			<li id="investorValue" value="{{$value['vInvestorProfileName']}}">
			<a href="{{url('investor-detail',$value['vUniqueCode'])}}" class="investorValue">{{$value['vInvestorProfileName']}} </a></li>
	 	@endforeach
	</ul>
	@endif

	@if(!empty($advisor))
	<label class="profile_listing_label">Advisor</label>
	<ul class="listing">
		@foreach ($advisor as $value)
			<li id="advisorValue" value="{{$value['vAdvisorProfileTitle']}}">
			<a href="{{url('advisor-detail',$value['vUniqueCode'])}}" class="advisorValue">{{$value['vAdvisorProfileTitle']}} </a></li>
	 	@endforeach
	</ul>
	@endif

	@if(!empty($investment))
	<label class="profile_listing_label">Investment</label>
	<ul class="listing">
		@foreach ($investment as $value)
			<li id="investmentValue" value="{{$value['vBusinessProfileName']}}">
			<a href="{{url('investment-detail',$value['vUniqueCode'])}}" class="investmentValue">{{$value['vBusinessProfileName']}} </a></li>
	 	@endforeach
	</ul>
	@endif

	</div>
</div>
