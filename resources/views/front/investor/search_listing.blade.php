@extends('layouts.app.front-app')
@section('title', 'Investor Listing '.env('APP_NAME'))
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
        border-color:#7DBA3F ;
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

</style>
@endsection
 
@section('content') 
<!-- banner section start -->
<section class="bread-camp investor-bg">
      <div class="container">
          <div class="bread-text-head">
              <h4> <a class="bread-tag-hover" href="{{ route('front.home') }}">Home</a>  / Investor</h4>
              <h1>
                @if($filterSearch == 'buying-business'){{'Acquiring / Buying a Business'}}@endif               
                @if($filterSearch == 'investing-business'){{'Investing in a Business'}}@endif                
                @if($filterSearch == 'lending-business'){{'Lending to a Business'}}@endif
                @if($filterSearch == 'buying-property'){{'Buying Property'}}@endif
                @if($filterSearch == 'corporate-investors'){{'Corporate Investors'}}@endif                  
                @if($filterSearch == 'venture-capital-firms'){{'Venture Capital Firms'}}@endif                  
                @if($filterSearch == 'private-equity-firms'){{'Private Equity Firms'}}@endif                  
                @if($filterSearch == 'family-offices'){{'Family Offices'}}@endif                  
              </h1>
          </div>
      </div>
    </section>
    <!-- banner section end -->
<input type="hidden" name="filterSearch" id="type" value="{{$filterSearch}}">
    <!-- business warap section start -->
    <section class="business-sale-warap investor">
      <div class="container">
        <div class="row">
          <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-12">
            <div class="heding">
              <h3>Filters</h3>
            </div>

            <div class="business-option pt-2">
              <div class="row row-padding">

                <div class="col-lg-12 col-md-12">
                  <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          <div class="heading">
                            <img src="{{asset('uploads/front/investment/Vector1.png')}}"><span>Transaction Types</span>
                          </div>
                        </button>
                      </h2>
                      <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                         <div class="in-detail">

                          <div class="form-check">
                            <input class="form-check-input filterCheckbox" type="checkbox" value="eAcquiringBusiness" id="eAcquiringBusiness" name="transaction_type">
                            <label class="form-check-label" for="eAcquiringBusiness">
                               Acquiring / Buying a Business
                            </label>
                          </div>
                            
                          <div class="form-check">
                            <input class="form-check-input filterCheckbox" type="checkbox" value="eInvestingInBusiness" id="eInvestingInBusiness" name="transaction_type">
                            <label class="form-check-label" for="eInvestingInBusiness">
                               Investing in a Business
                            </label>
                          </div>
    
                          <div class="form-check">
                            <input class="form-check-input filterCheckbox" type="checkbox" value="eLendingToBusiness" id="eLendingToBusiness" name="transaction_type">
                            <label class="form-check-label" for="eLendingToBusiness">
                              Lending to a Business
                            </label>
                          </div>
    
                          <div class="form-check">
                            <input class="form-check-input filterCheckbox" type="checkbox" value="eBuyingProperty" id="eBuyingProperty" name="transaction_type">
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
                                data-bs-toggle="collapse" data-bs-target="#collapsetwo" aria-expanded="false"
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
                                  <select class="js-select2 filterCheckbox" id="location" name="location" multiple="multiple">
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
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingthree">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapsethree"
                                aria-expanded="false" aria-controls="collapseOne">
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
                                                value="{{ $value->iIndustryId }}" id="{{ 'Industries_'.$value->iIndustryId }}">
                                            <label class="form-check-label" for ="{{ 'Industries_'.$value->iIndustryId }}">
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
                                                value="{{ $value->iIndustryId }}" id="{{ 'Industries_'.$value->iIndustryId }}">
                                            <label class="form-check-label" for="{{ 'Industries_'.$value->iIndustryId }}">
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
                  <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                    Sort By
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                    <li><a class="dropdown-item sort" data-id="a-z" href="javascript:;">A to Z</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="bussines-sale-box pt-4">
              <div class="row" id="investor-data">
                <!-- item-1 -->             
              </div>
                  <div class="text-center" id="investor-ajax-loader">
                      <img src="{{asset('admin/assets/images/ajax-loader.gif')}}" width="100px" height="auto" >
                  </div>
              <!-- <div class="box-pagination">
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
              </div> -->
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

   $(document).ready(function() 
   {
    var type=$('#type').val()

        $("#investor-ajax-loader").show();
        setTimeout(function() {
            $.ajax({
                url: "{{url('front/investor/ajax_search_listing')}}",
                type: "POST",
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data: {type:type},
                success: function(response) {
                    $("#investor-data").html(response);
                    $("#investor-ajax-loader").hide();
                }
            });
        }, 1000);
    });
    $('#load_more').click(function(e) {
            e.preventDefault();
            $("#load_more").css('display', 'none');
            $(".hided_industry").show();
        });
   //for pagination
   $(document).on('click', '.ajax_page', function() {
        var pages           = $(this).data("pages");
        var keyword         = $("#keyword").val();
        var limit_page = page_limit;
        $("#investor-ajax-loader").show();
        $("#investor-data").hide();
        $("#investor-data").html('');
       setTimeout(function() {
            $.ajax({
                url: "{{url('front/investor/ajax_search_listing')}}",
                type: "POST",
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data: {
                    pages: pages,
                    keyword: keyword,
                    limit_page:limit_page,
                    action: 'search'
                },
                success: function(response) {
                    $("#investor-data").html(response);
                    $("#investor-ajax-loader").hide();
                    $("#investor-data").show();
                }
            });
        }, 500);
    });
    $(document).on('click','.sort',function()
    {
      sort = $(this).data('id');

      $("#investor-data").html('');
      $("#investor-ajax-loader").show();

      setTimeout(function(){
          $.ajax({
              url: "{{url('front/investor/ajax_search_listing')}}",
              type: "POST",
              headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
              data:  {sort : sort,action:'sorting'}, 
              success: function(response) {
                  $("#investor-data").html(response);
                  $("#investor-ajax-loader").hide();
              }
          });
      }, 500); 
 });

//for filters
var checkboxArray = [];

        var selected = new Array();
        var temp_array = '';
        $('.filterCheckbox').change(function() {
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
            $("#investor-ajax-loader").show();
            setTimeout(function() {
                $.ajax({
                    url: "{{ url('front/investor/ajax_search_listing') }}",
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
                        $("#investor-ajax-loader").hide();
                        $("#investor-data").show();
                    }
                });
            }, 500);
        }
    
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
</script>
@endsection