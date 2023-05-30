@extends('layouts.app.front-app')
@section('title', 'Investor Listing ' . env('APP_NAME'))
@section('custom-css')

    <style>
        .pagination-wrapper ul:nth-child(1) {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            margin-bottom: 35px;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            gap: 5px;
        }

        .pagination-wrapper ul li {
            position: relative;
        }

        .pagination-wrapper ul.pagination li.active a {
            background-color: #7DBA3F;
            border-color: #7DBA3F;
            color: #fff;
        }

        .pagination-wrapper ul.pagination li.active a:hover {
            background-color: #003075;
            color: #fff;
        }

        .pagination-wrapper ul.pagination li a {
            height: 30px;
            width: 30px;
            display: inline-block;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            color: #003075;
            border: 1px solid #003075;
            transition: 0.2s ease-in all;
            -webkit-transition: 0.2s ease-in all;
            -moz-transition: 0.2s ease-in all;
            -ms-transition: 0.2s ease-in all;
            -o-transition: 0.2s ease-in all;
        }

        .pagination-wrapper ul.pagination li a:hover {
            background-color: #003075;
            color: #fff;
            transition: 0.2s ease-in all;
            -webkit-transition: 0.2s ease-in all;
            -moz-transition: 0.2s ease-in all;
            -ms-transition: 0.2s ease-in all;
            -o-transition: 0.2s ease-in all;
        }

        .bread-tag-hover:hover {
            color: #f29d1c;

        }
    </style>
@endsection

@section('content')

    <!-- banner section start -->
    <section class="bread-camp investor-bg">
        <div class="container">
            <div class="bread-text-head">
                <h4> <a class="bread-tag-hover" href="{{ route('front.home') }}">Home</a> / Investor</h4>
                <h1>Investor</h1>
            </div>
        </div>

    </section>
    <!-- banner section end -->

    <!-- business warap section start -->
    <section class="business-sale-warap investor">
        <div class="container">
            <div class="row">
                <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-12">
                    <div class="heding">
                        <h3>Filters</h3>
                    </div>

                    <div class="business-option pt-4">
                        <div class="row row-padding">

                            <div class="col-lg-12 col-md-12">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                <div class="heading">
                                                    <img src="{{ asset('uploads/front/investment/Vector1.png') }}"><span>Transaction
                                                        Types</span>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="in-detail">

                                                    <div class="form-check">
                                                        <input class="form-check-input filterCheckbox" type="checkbox"
                                                            value="eAcquiringBusiness" id="eAcquiringBusiness"
                                                            name="transaction_type">
                                                        <label class="form-check-label" for="eAcquiringBusiness">
                                                            Acquiring / Buying a Business
                                                        </label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input class="form-check-input filterCheckbox" type="checkbox"
                                                            value="eInvestingInBusiness" id="eInvestingInBusiness"
                                                            name="transaction_type">
                                                        <label class="form-check-label" for="eInvestingInBusiness">
                                                            Investing in a Business
                                                        </label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input class="form-check-input filterCheckbox" type="checkbox"
                                                            value="eLendingToBusiness" id="eLendingToBusiness"
                                                            name="transaction_type">
                                                        <label class="form-check-label" for="eLendingToBusiness">
                                                            Lending to a Business
                                                        </label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input class="form-check-input filterCheckbox" type="checkbox"
                                                            value="eBuyingProperty" id="eBuyingProperty"
                                                            name="transaction_type">
                                                        <label class="form-check-label" for="eBuyingProperty">
                                                            Buying Property
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<div class="accordion-item">
										<h2 class="accordion-header" id="headingtwo">
											<button class="accordion-button collapsed" type="button"
												data-bs-toggle="collapse" data-bs-target="#collapsetwo" aria-expanded="true"
												aria-controls="collapseOne">
												<div class="heading">
													<img
														src="{{ asset('uploads/front/investment/location.png') }}"><span>Location</span>
												</div>
											</button>
										</h2>
										<div id="collapsetwo" class="accordion-collapse collapse"
											aria-labelledby="headingtwo" data-bs-parent="#accordionExample">
											<div class="accordion-body">
												<div class="in-detail">
													@foreach ($location as $key => $value)
														<div class="form-check">
															<input class="form-check-input region_checkbox filterCheckbox"
																type="checkbox" name="location"
																value="{{ $value['regionId'] }}"
																id="{{ $value['regionId'] }}">
															<label class="form-check-label" for="{{ $value['regionId'] }}">
																{{ $value['regionName'] }}
															</label>
														</div>
													@endforeach
												</div>
											</div>
										</div>
									</div>
									<div class="accordion-item">
										<h2 class="accordion-header" id="headingthree">
											<button class="accordion-button collapsed" type="button"
												data-bs-toggle="collapse" data-bs-target="#collapsethree"
												aria-expanded="true" aria-controls="collapseOne">
												<div class="heading">
													<img
														src="{{ asset('uploads/front/investment/industri.png') }}"><span>Industries</span>
												</div>
											</button>
										</h2>
										<div id="collapsethree" class="accordion-collapse collapse"
											aria-labelledby="headingthree" data-bs-parent="#accordionExample">
											<div class="accordion-body">
												<div class="in-detail">
													@foreach ($industries as $key => $value)
														<div class="form-check">
															<input
																class="form-check-input industry_checkbox filterCheckbox"
																type="checkbox" name="industry"
																value="{{ $value->iIndustryId }}"
																id="{{ $value->iIndustryId }}">
															<label class="form-check-label"
																for="{{ $value->iIndustryId }}">
																{{ $value->vName }}
															</label>
														</div>
													@endforeach
													@if (count($industries1) > 25)
														<a id="load_more"
															style="color: #003075; text-decoration:underline; cursor:pointer; ">Load
															More</a>
													@endif
													@foreach ($industries1 as $key => $value)
														<div class="form-check hided_industry" style="display: none;">
															<input
																class="form-check-input industry_checkbox filterCheckbox"
																type="checkbox" name="industry"
																value="{{ $value->iIndustryId }}"
																id="{{ $value->iIndustryId }}">
															<label class="form-check-label"
																for="{{ $value->iIndustryId }}">
																{{ $value->vName }}
															</label>
														</div>
													@endforeach
												</div>
											</div>
										</div>
									</div>
                                </div>
								
                            </div>

                            {{-- <div class="col-lg-12 col-md-12">
                                <div class="accordion" id="accordionExample2">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingtwo">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapsetwo" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                <div class="heading">
                                                    <img
                                                        src="{{ asset('uploads/front/investment/location.png') }}"><span>Location</span>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapsetwo" class="accordion-collapse collapse"
                                            aria-labelledby="headingtwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="in-detail">
                                                    @foreach ($location as $key => $value)
                                                        <div class="form-check">
                                                            <input class="form-check-input region_checkbox filterCheckbox"
                                                                type="checkbox" name="location"
                                                                value="{{ $value['regionId'] }}"
                                                                id="{{ $value['regionId'] }}">
                                                            <label class="form-check-label" for="{{ $value['regionId'] }}">
                                                                {{ $value['regionName'] }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            {{-- <div class="col-lg-12 col-md-12">
                                <div class="accordion" id="accordionExample3">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingthree">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapsethree"
                                                aria-expanded="true" aria-controls="collapseOne">
                                                <div class="heading">
                                                    <img
                                                        src="{{ asset('uploads/front/investment/industri.png') }}"><span>Industries</span>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapsethree" class="accordion-collapse collapse"
                                            aria-labelledby="headingthree" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="in-detail">
                                                    @foreach ($industries as $key => $value)
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input industry_checkbox filterCheckbox"
                                                                type="checkbox" name="industry"
                                                                value="{{ $value->iIndustryId }}"
                                                                id="{{ $value->iIndustryId }}">
                                                            <label class="form-check-label"
                                                                for="{{ $value->iIndustryId }}">
                                                                {{ $value->vName }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                    @if (count($industries1) > 25)
                                                        <a id="load_more"
                                                            style="color: #003075; text-decoration:underline; cursor:pointer; ">Load
                                                            More</a>
                                                    @endif
                                                    @foreach ($industries1 as $key => $value)
                                                        <div class="form-check hided_industry" style="display: none;">
                                                            <input
                                                                class="form-check-input industry_checkbox filterCheckbox"
                                                                type="checkbox" name="industry"
                                                                value="{{ $value->iIndustryId }}"
                                                                id="{{ $value->iIndustryId }}">
                                                            <label class="form-check-label"
                                                                for="{{ $value->iIndustryId }}">
                                                                {{ $value->vName }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        {{-- @endforeach --}}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

                <div class="col-xxl-9 col-xl-9 col-lg-8 col-md-12">
                    <div class="heading-second">
                        <div class="left-text">
                            <p>Businesses for Sale and Investment Opportunities. Buy or Invest in a Business.</p>
                        </div>
                        <div class="right-text">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Sort By
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <li><a class="dropdown-item sort" data-id="a-z" href="javascript:;">A to Z</a></li>
                                </ul>
                            </div>
                        </div>
                        
                        @if (count($industries1) > 25)
                        <a id="load_more" style="color: #003075; text-decoration:underline; cursor:pointer; ">Load
                          More</a>
                        @endif
                        @foreach ($industries1 as $key => $value)
                        <div class="form-check hided_industry" style="display: none;">
                          <input class="form-check-input industry_checkbox filterCheckbox" type="checkbox" name="industry" value="{{ $value->iIndustryId }}" id="{{ $value->iIndustryId }}">
                          <label class="form-check-label" for="{{ $value->iIndustryId }}">
                            {{ $value->vName }}
                          </label>
                        </div>
                        @endforeach
                      </div>
                    </div>
                    <div class="bussines-sale-box pt-4">
                        <div class="row" id="investor-data">
                            <!-- item-1 -->

                        </div>
                        <div class="text-center" id="ajax-loader">
                            <img src="{{ asset('admin/assets/images/ajax-loader.gif') }}" width="100px"
                                height="auto" />
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </section>
    <!-- business warap section start -->
@endsection
@section('custom-js')
    <script>
        var page_limit = 10;

        $(document).ready(function() {
            $("#ajax-loader").show();
            setTimeout(function() {
                $.ajax({
                    url: "{{ url('front/investor/ajax_listing') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: "",
                    success: function(response) {
                        $("#investor-data").html(response);
                        $("#ajax-loader").hide();
                    }
                });
            }, 1000);
        });
        //for pagination
        $(document).on('click', '.ajax_page', function() {
            var pages = $(this).data("pages");
            var keyword = $("#keyword").val();
            var limit_page = page_limit;
            $("#investor-data").hide();
            $("#investor-data").html('');
            $("#ajax-loader").show();
            setTimeout(function() {
                $.ajax({
                    url: "{{ url('front/investor/ajax_listing') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        pages: pages,
                        keyword: keyword,
                        limit_page: limit_page,
                        action: 'search'
                    },
                    success: function(response) {
                        $("#investor-data").html(response);
                        $("#ajax-loader").hide();
                        $("#investor-data").show();
                    }
                });
            }, 500);
        });
        $(document).on('click', '.sort', function() {
            sort = $(this).data('id');

            $("#investor-data").html('');
            $("#ajax-loader").show();

            setTimeout(function() {
                $.ajax({
                    url: "{{ url('front/investor/ajax_listing') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        sort: sort,
                        action: 'sorting'
                    },
                    success: function(response) {
                        $("#investor-data").html(response);
                        $("#ajax-loader").hide();
                    }
                });
            }, 500);
        });

        //for filters
        var checkboxArray = [];

        var selected = new Array();
        var temp_array = '';
        $('.filterCheckbox').change(function() {
            if (this.checked) {
                if (this.name == 'location') {
                    selected.push({
                        location: this.value
                    });

                } else if (this.name == 'industry') {
                    selected.push({
                        industry: this.value
                    });

                } else if (this.name == 'transaction_type') {
                    selected.push({
                        transaction_type: this.value
                    });
                }
            } else {
                if (this.name == 'location') {
                    var current_value = this.value;
                    var temp_array = selected.filter(function(itm) {
                        return itm.location !== current_value;
                    });
                } else if (this.name == 'industry') {
                    var current_value = this.value;
                    var temp_array = selected.filter(function(itm) {
                        return itm.industry !== current_value;
                    });
                } else if (this.name == 'transaction_type') {

                    var current_value = this.value;
                    var temp_array = selected.filter(function(itm) {
                        return itm.transaction_type !== current_value;
                    });
                }
                selected = temp_array;
            }
            console.log(selected);
            ajax_call_filter(selected);
        });

        function ajax_call_filter(params) {
            /* var pages = $(this).data("pages"); */
            var pages = 1;
            var limit_page = page_limit;
            $("#investor-data").hide();
            $("#investor-data").html('');
            $("#ajax-loader").show();
            setTimeout(function() {
                $.ajax({
                    url: "{{ url('front/investor/ajax_listing') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        pages: pages,
                        limit_page: limit_page,
                        filter: params,
                        action: 'search'
                    },
                    success: function(response) {
                        $("#investor-data").html(response);
                        $("#ajax-loader").hide();
                        $("#investor-data").show();
                    }
                });
            }, 500);
        }

    </script>
@endsection