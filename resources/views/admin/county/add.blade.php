@extends('layouts.app.admin-app')
@section('title', 'County - '.env('APP_NAME'))
@section('content')
<section class="content-header">
<div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ isset($county) ? 'Edit' : 'Add' }} County</h1>
            </div>
        </div>
    </div>
  
    <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
          <form action="{{url('admin/county/store')}}" name="frm" id="frm" method="post" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if(isset($county)){{$county->vUniqueCode}}@endif">
                <input type="hidden" id="selected_region_id" value="@if(isset($county)){{$county->iRegionId}}@endif">
                <div class="row">
                    
                    <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Select Country</label>
                        <select id="country_id" name="iCountryId" class="form-control">
                          <option value="">Select Country</option>
                            @foreach($countries as  $value)
                            <option value="{{$value->iCountryId}}" @if(isset($county))   @if($county->iCountryId == $value->iCountryId) selected @endif @endif>{{$value->vCountry}}</option>
                            @endforeach
                        </select>
                        <div id="iCountryId_error" class="error mt-1" style="color:red;display: none;">Please Select Country name</div>
                    </div>
                    
                    <div class="col-md-6">
                          <div class="form-group">
                              <label>Select Region</label>
                              <select id="iRegionId" name="iRegionId" class="form-control">
                              <option value="">Select Region</option>
                              </select>
                              <div id="region_id_error" class="error mt-1" style="color:red;display: none;">Please Select Region name   
                              </div>
                          </div>
                    </div>
                    <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>County Name</label>
                        <input type="text" name="vTitle" id="vTitle" class="form-control" placeholder="Enter County Name" value="@if(isset($county)){{$county->vTitle}}@endif">
                        <div id="vCounty_error" class="error mt-1" style="color:red;display: none;">Please Enter county Name   
                        </div>
                    </div>
                    <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Status</label>
                      <select name="eStatus" id="eStatus" class="form-control">
                        <option value="">Select Status</option>
                        <option value="Active" @if(isset($county)) @if($county->eStatus == 'Active') selected @endif @endif>Active</option>
                        <option value="Inactive" @if(isset($county)) @if($county->eStatus == 'Inactive') selected @endif @endif>Inactive</option>
                      </select>
                      <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">Please Select Status </div>
                    </div>
                </div>
              </div>
              <div class="card-footer col-12 align-self-end d-inline-block mt-0">
                <a href="javascript:;" class="btn btn-primary submit">Submit</a>
                <a href="javascript:;" class="btn btn-primary loading" style="display: none;"> 
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                </a>
                <a href="{{url('admin/county/listing')}}" class="btn-info btn">Back</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>


@endsection

@section('custom-css')
<style></style>
@endsection

@section('custom-js')

<script type="text/javascript">
  $(document).on('click','.submit',function(){
    var iRegionId            = $("#iRegionId").val();
    var iCountryId        =$("#country_id").val();
    var vTitle             = $("#vTitle").val();
    var eStatus           = $("#eStatus").val();
    var error = false;


    
    if(iCountryId.length == 0){
      error = true;
      $("#iCountryId_error").show();
    }else{
      $("#iCountryId_error").hide();
    }
    if(iRegionId.length == 0){
      error = true;
      $("#region_id_error").show();
    }else{
      $("#region_id_error").hide();
    }
    if(vTitle.length == 0){
      error = true;
      $("#vCounty_error").show();
    }else{
      $("#vCounty_error").hide();
    }
    if(eStatus.length == '')
    {
      $("#eStatus_error").show();
      error = true;
    }
    else
    {
      $("#eStatus_error").hide();
    }
    setTimeout(function(){
      if(error == true){
        return false;
      } else {
        $("#frm").submit();
        $('.submit').hide();
        $('.loading').show();
        return true;
      }
    }, 1000);

  });
 
  $(document).ready(function() {
        var country_id          = $("#country_id").val(); 
        var selected_region_id   = $("#selected_region_id").val();
        
        if(country_id != ''){
            $("#iRegionId").html('');
            $.ajax({
                url:"{{url('admin/county/get_region_by_country')}}",
                type: "POST",
                data: {
                    country_id: country_id,
                    _token: '{{csrf_token()}}' 
                },

                dataType : 'json',
                success: function(result){
                    $('#iRegionId').html('<option value="">Select Region</option>'); 
                        $.each(result.region,function(key,value){
                            if (selected_region_id == value.iRegionId) {
                                $('#iRegionId').append('<option selected value="'+value.iRegionId+'">'+value.vTitle+'</option>');
                            }else{
                                $("#iRegionId").append('<option value="'+value.iRegionId+'">'+value.vTitle+'</option>');
                            }
                        });
                    }
                });
        }

    });
    $(document).on('change','#country_id',function()
    {
        var country_id = $("#country_id").val();
        console.log(country_id);
        if(country_id != ''){
            $("#iRegionId").html('');
            $.ajax({
                url:"{{url('admin/county/get_region_by_country')}}",
                type: "POST",
                data: {
                    country_id: country_id,
                    _token: '{{csrf_token()}}' 
                },

                dataType : 'json',
                success: function(result){
                    console.log(result);
                    $('#iRegionId').html('<option value="">Select Region</option>'); 
                    $.each(result.region,function(key,value){
                        $("#iRegionId").append('<option value="'+value.iRegionId+'">'+value.vTitle+'</option>');
                    });
                }
            });
        }
    });
</script>
@endsection
