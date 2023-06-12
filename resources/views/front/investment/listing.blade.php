@php
/* dd($industries1); */
@endphp
@extends('layouts.app.front-app')
@section('title', 'Investment Listing - ' . env('APP_NAME'))
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
.select2-container {
  min-width:  200px;
}

.select2-results__option {
  padding-right: 20px;
  vertical-align: middle;
}
.select2-results__option:before {
  content: "";
  display: inline-block;
  position: relative;
  height: 20px;
  width: 20px;
  border: 2px solid #e9e9e9;
  border-radius: 4px;
  background-color: #fff;
  margin-right: 20px;
  vertical-align: middle;
}
.select2-results__option[aria-selected=true]:before {
  font-family:fontAwesome;
  content: "\f00c";
  color: #fff;
  background-color: #f77750;
  border: 0;
  display: inline-block;
  padding-left: 3px;
}
.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #fff;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #eaeaeb;
    color: #272727;
}
.select2-container--default .select2-selection--multiple {
    margin-bottom: 10px;
}
.select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple {
    border-radius: 4px;
}
.select2-container--default.select2-container--focus .select2-selection--multiple {
    border-color: #f77750;
    border-width: 2px;
}
.select2-container--default .select2-selection--multiple {
    border-width: 2px;
}
.select2-container--open .select2-dropdown--below {
    
    border-radius: 6px;
    box-shadow: 0 0 10px rgba(0,0,0,0.5);

}
.select2-selection .select2-selection--multiple:after {
    content: 'hhghgh';
}
/* select with icons badges single*/
.select-icon .select2-selection__placeholder .badge {
    display: none;
}
.select-icon .placeholder {
/*  display: none; */
}
.select-icon .select2-results__option:before,
.select-icon .select2-results__option[aria-selected=true]:before {
    display: none !important;
    /* content: "" !important; */
}
.select-icon  .select2-search--dropdown {
    display: none;
}

.listing-titles{
    color:#2B7292;
    font-size:20px;
}

.listing-titles-mini{
    color:#2B7292;
    font-size:16px;
    font-weight:500;
}

.line_horizontal{
    border-bottom: 1px solid #D1D7DC;
}

.form-check-label-style{
    font-size:15px !important;
    color: #313538;
}

.card_box{
    background: #FFFFFF;
    border-bottom: 2px solid #2B7292;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}
    </style>
@endsection

@section('content')
    <!-- banner section start -->
    <!-- <section class="bread-camp">
        <div class="container">
            <div class="bread-text-head">
                <h4><a class="bread-tag-hover" href="{{ route('front.home') }}">Home</a> / Investments</h4>
                <h1>Investments</h1>
            </div>
        </div>
    </section> -->
    <!-- banner section end -->

    <!-- business warap section start -->
    <section class="business-sale-warap investment mt-sm-4" style="padding-top:61px;">
        <div class="container">
            <div class="row">
                <div class="heading-second">
                    <div class="heding">
                        <h3 class="mt-0 listing-titles">Filters</h3>
                    </div>

                    <div class="left-text">
                        <p style="color: #313538; font-size:14px; padding-top:10px;">Businesses for Sale and Investment Opportunities. Buy or Invest in a Business.</p>
                    </div>
                    
                    <div class="right-text mt-1">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton2"
                                data-bs-toggle="dropdown" aria-expanded="false" style="color: #4E4D50; font-size: 16px; width:150px;">
                                Sort By
                            </button>
                            <ul class="dropdown-menu border-0" aria-labelledby="dropdownMenuButton2">
                                <li><a class="dropdown-item sort" data-id="a-z" href="javascript:;" style="color: #4E4D50; font-size: 14px; font-weight:500;">Name</a></li>
                                <li><a class="dropdown-item sort" data-id="EBITDA" href="javascript:;"style="color: #4E4D50; font-size: 14px !important; font-weight:500;">EBITDA</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-12">
                    <div class="business-option pt-2">
                        <div class="row row-padding">
                            <div class="col-lg-12 col-md-12">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item card_box">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                <div class="heading">
                                                    <span class="listing-titles-mini">Transaction Types</span>
                                                </div>
                                            </button>
                                        </h2>

                                        <div class="px-3">
                                            <div class="line_horizontal"></div>
                                        </div>

                                        <div id="collapseOne" class="accordion-collapse collapse show"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body mt-0 border-0    ">
                                                <div class="in-detail">
                                                    <div class="form-check">
                                                        <input class="form-check-input intrestCheckbox filterCheckbox"
                                                            type="checkbox" value="eFullSaleBusiness" id="eFullSaleBusiness"
                                                            name="transaction_type">
                                                        <label class="form-check-label form-check-label-style" for="eFullSaleBusiness">
                                                            Full sale of business
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-label-style">
                                                        <input class="form-check-input intrestCheckbox filterCheckbox"
                                                            type="checkbox" value="eLoanForBusiness" id="eLoanForBusiness"
                                                            name="transaction_type">
                                                        <label class="form-check-label" for="eLoanForBusiness">
                                                            Loan for business
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-label-style">
                                                        <input class="form-check-input intrestCheckbox filterCheckbox"
                                                            type="checkbox" value="ePartialSaleBusiness"
                                                            id="ePartialSaleBusiness" name="transaction_type">
                                                        <label class="form-check-label" for="ePartialSaleBusiness"> Partial
                                                            sale of business/Investment </label>
                                                    </div>

                                                    <div class="form-check form-check-label-style">
                                                        <input class="form-check-input intrestCheckbox filterCheckbox"
                                                            type="checkbox" value="eBailout" id="eBailout"
                                                            name="transaction_type">
                                                        <label class="form-check-label" for="eBailout">
                                                            Distressed company looking for bailout
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-label-style">
                                                        <input class="form-check-input intrestCheckbox filterCheckbox"
                                                            type="checkbox" value="Yes" id="eBusinessAsset"
                                                            name="transaction_type">
                                                        <label class="form-check-label" for="eBusinessAsset">
                                                            Selling or leasing out business asset
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item card_box">
                                        <h2 class="accordion-header" id="headingtwo">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapsetwo" aria-expanded="false"
                                                aria-controls="collapseOne">
                                                <div class="heading">
                                                    <!-- <img src="{{ asset('uploads/front/investment/location.png') }}"> -->
                                                    <span class="listing-titles-mini">Location</span>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapsetwo" class="accordion-collapse collapse"
                                            aria-labelledby="headingtwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="in-detail">
                                                     
                                                    <!-- <div class="form-check"> -->
                                                    <!-- <select class="js-select2 filterCheckbox" id="location" name="location" multiple="multiple">
                                                    @foreach ($location as $key => $value)
                                                        @foreach ($location as $key1 => $value)
                                                             <option value="{{$value['regionName']}}" data-badge="">{{$value['regionName']}}</option>
                                                        @endforeach
                                                        @foreach ($location as $key1 => $value)
                                                            @foreach($value as  $key1 => $value1)
                                                               @if (in_array($key1,['regionId','regionName']))
                                                                @continue
                                                              @endif
                                                              <option value="{{$value1['countyName']}}" data-badge="">{{$value1['countyName']}}</option>
                                                            @endforeach
                                                        @endforeach
                                                        @foreach ($location as $key1 => $value)
                                                            @foreach($value as  $key1 => $value1)
                                                                @if (in_array($key1,['regionId','regionName']))
                                                                    @continue
                                                                @endif
                                                              
                                                                @foreach($value1 as  $key2 => $value2)
                                                                @if (in_array($key2,['countyId','countyName']))
                                                                  @continue
                                                                @endif
                                                                <option value="{{$value2['subCountyName']}}" data-badge="">{{$value2['subCountyName']}}</option>
                                                               @endforeach
                                                            @endforeach
                                                         @endforeach
                                                    @endforeach
                                                        </select> -->
                                                    <!-- </div> -->

                                          
                                                
                                                <div class="col-lg-12 mb-2 form-group custom-select positon-relative"  id="div_iRegionId">
                                                    <label class="py-2 pt-0" style="font-size:14px; font-weight:500;">Select Region</label>
                                                    <select id="iRegionId" name="iRegionId" class="add_select2 form-control with-border" >
                                                        <option value="">Select Region</option>
                                                         @foreach ($Region as $value)
                                                            <option value="{{ $value->iRegionId . '_' . $value->vTitle }}" @if(isset($investment)) @if($selected_location[0]->iLocationId == $value->iRegionId) {{'selected'}}@endif @endif>{{ $value->vTitle }}</option>
                                                            @endforeach
                                                    </select>
                                                </div>

                                                
                                                <div class="col-lg-12 mb-2 form-group custom-select positon-relative"  style="display:none;" id="div_iCountyId">
                                                    <label>Select County</label>
                                                    <select id="iCountyId" name="iCountyId" class="add_select2 form-control with-border">
                                                        <option value="">Select County</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-lg-12 mb-2 form-group custom-select positon-relative" style="display:none;" id="div_iSubCountyId">
                                                    <label>Select Sub County</label>
                                                    <select id="iSubCountyId" name="iSubCountyId" class="add_select2 form-control with-border" >
                                                        <option value="">Select Sub County</option>
                                                    </select>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item card_box">
                                        <h2 class="accordion-header" id="headingthree">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethree" aria-expanded="false" aria-controls="collapseOne">
                                                <div class="heading">
                                                    <!-- <img src="{{ asset('uploads/front/investment/industri.png') }}"> -->
                                                        <span class="listing-titles-mini">Industries</span>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapsethree" class="accordion-collapse collapse" aria-labelledby="headingthree" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="in-detail">
                                                    @foreach ($industries as $key => $value)
                                                        <div class="form-check">
                                                            <input class="form-check-input industry_checkbox filterCheckbox" type="checkbox" name="industry" value="{{ $value->iIndustryId }}" id="{{ 'Industries_'.$value->iIndustryId }}">
                                                            <label class="form-check-label" for="{{ 'Industries_'.$value->iIndustryId }}"> {{ $value->vName }} </label>
                                                        </div>
                                                    @endforeach
                                                    @if (count($industries) > 5)
                                                        <a id="load_more" style="color: #003075; text-decoration:underline; cursor:pointer;">
                                                        Load More</a>
                                                    @endif
                                                    @foreach ($industries1 as $key => $value)
                                                        <div class="form-check hided_industry" style="display: none;">
                                                            <input class="form-check-input industry_checkbox filterCheckbox" type="checkbox" name="industry" value="{{ $value->iIndustryId }}" id="{{ 'Industries_'.$value->iIndustryId }}">
                                                            <label class="form-check-label" for="{{ 'Industries_'.$value->iIndustryId }}"> {{ $value->vName }} </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-9 col-xl-9 col-lg-8 col-md-12">
                    <div class="bussines-sale-box pt-3">
                        <div class="row" id="investment_list_row">
                            <!-- item-1 -->
                        </div>
                        
                        <div class="text-center" id="investment-listing-ajax-loader">
                            <img src="{{ asset('admin/assets/images/ajax-loader.gif') }}" width="100px" height="auto">
                        </div>
                        {{-- <div class="box-pagination">
							<nav aria-label="Page navigation example">
							<ul class="pagination justify-content-center">
								<li class="page-item">
								<a class="page-link" href="#" tabindex="-1" aria-disabled="true"><i class="far fa-angle-left px-3"></i>Previous</a>
								</li>
								<li class="page-item"><a class="page-link" href="#">1</a></li>
								<li class="page-item"><a class="page-link active" href="#">2</a></li>
								<li class="page-item"><a class="page-link" href="#">3</a></li>
								<li class="page-item"><a class="page-link" href="#">...21</a></li>
								<li class="page-item">
								<a class="page-link" href="#">Next<i class="far fa-angle-right px-3"></i></a>
								</li>
							</ul>
							</nav>
						</div> --}}
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
            $("#investment-listing-ajax-loader").show();
            setTimeout(function() {
                $.ajax({
                    url: "{{ url('front/investment/ajax_listing') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: "",
                    success: function(response) {
                        $("#investment_list_row").html(response);
                        $("#investment-listing-ajax-loader").hide();
                    }
                });
            }, 1000);
        });
        $('#load_more').click(function(e) {
            e.preventDefault();
            $("#load_more").css('display', 'none');
            $(".hided_industry").show();
        });
        $(document).on('click', '.ajax_page', function() {
            var pages = $(this).data("pages");
            var keyword = $("#keyword").val();
            var limit_page = page_limit;
            $("#investment_list_row").hide();
            $("#investment_list_row").html('');
            $("#investment-listing-ajax-loader").show();
            setTimeout(function() {
                $.ajax({
                    url: "{{ url('front/investment/ajax_listing') }}",
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
                        $("#investment_list_row").html(response);
                        $("#investment-listing-ajax-loader").hide();
                        $("#investment_list_row").show();
                    }
                });
            }, 500);
        });
        var checkboxArray = [];
        /* $("input:checkbox[name=industry]:checked").each(function(){
          checkboxArray.push($(this).val());
          console.log(checkboxArray);
        }); */

        var selected = new Array();
        var temp_array = '';
        $('.filterCheckbox').change(function() {
                $("#location :selected").map(function(i, el) {
                    // alert(12)
                    return $(el).val();
                }).get();

                if (this.name == 'location') 
                {                    
                    selected.push({
                        location:  $('#location').val()
                    });
                    /* var obj = {};
                    obj['location'] = {
                      location: this.value
                    };
                    selected.push(obj); */
                }

            if (this.checked) {
                if (this.name == 'industry') {
                    selected.push({
                        industry: this.value
                    });
                    /* var obj = {};
                    obj['industry'] = {
                      industry: this.value
                    };
                    selected.push(obj); */
                } else if (this.name == 'transaction_type') {
                    selected.push({
                        transaction_type: this.value
                    });
                    /* var obj = {};
                    obj['transaction_type'] = {
                      transaction_type: this.value
                    };
                    selected.push(obj); */
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
            console.log(params)
            /* var pages = $(this).data("pages"); */
            var pages = 1;
            var limit_page = page_limit;
            $("#investment_list_row").hide();
            $("#investment_list_row").html('');
            $("#investment-listing-ajax-loader").show();
            setTimeout(function() {
                $.ajax({
                    url: "{{ url('front/investment/ajax_listing') }}",
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
                        $("#investment_list_row").html(response);
                        $("#investment-listing-ajax-loader").hide();
                        $("#investment_list_row").show();
                    }
                });
            }, 500);
        }

        /* Sorting */
        $(document).on('click', '.sort', function() {
            sort_by = $(this).data('id');
			console.log(sort_by);
            $("#investment_list_row").html('');
            $("#investment-listing-ajax-loader").show();

            setTimeout(function() {
                $.ajax({
                    url: "{{ url('front/investment/ajax_listing') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        sort: sort_by,
                        action: 'sorting'
                    },
                    success: function(response) {
                        $("#investment_list_row").html(response);
                        $("#investment-listing-ajax-loader").hide();
                    }
                });
            }, 500);
        });

   
    </script>
<script type="text/javascript">

    $(document).on('click', '.detailPageLink', function() {
    var url = $(this).data("id"); 
            location.href = url;
});

$("#location").select2({
    closeOnSelect : false,
    placeholder : "Placeholder",
    // allowHtml: true,
    allowClear: true,
    tags: true // создает новые опции на лету
});

//start filter code for location selection
   // $(document).on('change', '#country_id', function() {
   //       if (this.name == 'iCountryId') 
   //      {
   //          value = $('#country_id').val().split("_").pop();

   //          selected.push({
   //              location:  value
   //          });
   //      }
   //      if (this.name == 'iCountryId') { 
   //          var current_value = this.value;
   //          current_value = current_value.split("_").pop();

   //          var temp_array = selected.filter(function(itm) 
   //          {
   //              return itm.location !== current_value;
   //          });
   //      }
   //          var country_id = $("#country_id").val();
   //          if (country_id != '') {
   //              $("#iRegionId").html('');
   //              $.ajax({
   //                  url: "{{ url('investment/get_region_by_country') }}",
   //                  type: "POST",
   //                  data: {
   //                      country_id: country_id,
   //                      _token: '{{ csrf_token() }}'
   //                  },

   //                  dataType: 'json',
   //                  success: function(result) {
   //                      $('#div_iRegionId').show();
   //                      $('#iRegionId').html('<option value="">Select Region</option>');
   //                      $.each(result.region, function(key, value) {
   //                          $("#iRegionId").append('<option value="' + value.iRegionId + '_' + value.vTitle + '">' + value.vTitle + '</option>');
   //                      });
   //                       ajax_call_filter(selected);
   //                  }
   //              });
   //          }
   //      });

        $(document).on('change', '#iRegionId', function() 
        {            
            selected.splice(0)
             if (this.name == 'iRegionId') 
            {
                value = $('#iRegionId').val().split("_").pop();

                selected.push({
                    iRegionId:  value
                });
            }
            var iRegionId = $("#iRegionId").val();
            if (iRegionId != '') {
                $("#iCountyId").html('');
                $.ajax({
                    url: "{{ url('investment/get_county_by_region') }}",
                    type: "POST",
                    data: {
                        region_id: iRegionId,
                        _token: '{{ csrf_token() }}'
                    },

                    dataType: 'json',
                    success: function(result) {
                        // console.log(result);
                        $('#div_iCountyId').show();
                        $('#iCountyId').html('<option value="">Select County</option>');
                        $.each(result.county, function(key, value) {                            
                            $("#iCountyId").append('<option value="' + value.iCountyId + '_' + value.vTitle + '">' + value.vTitle + '</option>');
                        });
                        ajax_call_filter(selected);
                    }
                });
            }
        });

        $(document).on('change', '#iCountyId', function() {
            selected.splice(0)
              if (this.name == 'iCountyId') 
            {
                value = $('#iCountyId').val().split("_").pop();

                selected.push({
                    iCountyId:  value
                });
            }
            
            var iCountyId = $("#iCountyId").val();
            if (iCountyId != '') {
                $("#iSubCountyId").html('');
                $.ajax({
                    url: "{{ url('investment/get_sub_county_by_county') }}",
                    type: "POST",
                    data: {
                        iCountyId: iCountyId,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) 
                    {
                        $('#div_iSubCountyId').show();
                        // console.log(result);
                        $('#iSubCountyId').html('<option value="">Select Sub County</option>');
                        $.each(result.subCounty, function(key, value) {
                            $("#iSubCountyId").append('<option value="' + value.iSubCountId + '_' + value.vTitle + '">' + value.vTitle + '</option>');
                        });
                        ajax_call_filter(selected);
                    }
                });
            }
        });
        $(document).on('change', '#iSubCountyId', function() 
        {
            selected.splice(0)
             if (this.name == 'iSubCountyId') 
            {
                value = $('#iSubCountyId').val().split("_").pop();

                selected.push({
                    iSubCountyId:  value
                });
            }
           
            ajax_call_filter(selected);
        });
//end filter code for location selection
</script>
@endsection
