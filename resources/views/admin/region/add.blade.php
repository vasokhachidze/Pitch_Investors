@extends('layouts.app.admin-app')
@section('title', 'Region - '.env('APP_NAME'))
@section('content')

<section class="content-header">
<div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ isset($region) ? 'Edit' : 'Add' }} Region</h1>
            </div>
        </div>
    </div>
  
    <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
          <form action="{{url('admin/region/store')}}" name="frm" id="frm" method="post" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if(isset($region)){{$region->vUniqueCode}}@endif">
                <div class="row">
                    
                    <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Select Country</label>
                        <select id="country_id" name="iCountryId" class="form-control">
                          <option value="">Select Country</option>
                            @foreach($countries as  $value)
                            <option value="{{$value->iCountryId}}" @if(isset($region))   @if($region->iCountryId == $value->iCountryId) selected @endif @endif>{{$value->vCountry}}</option>
                            @endforeach
                        </select>
                        <div id="iCountryId_error" class="error mt-1" style="color:red;display: none;">Please Select Country name</div>
                    </div>
                    
                    <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Region Name</label>
                        <input type="text" name="vTitle" id="vTitle" class="form-control" placeholder="Enter Region Name" value="@if(isset($region)){{$region->vTitle}}@endif">
                        <div id="vTitle_error" class="error mt-1" style="color:red;display: none;">Please Enter Region Name   
                        </div>
                    </div>
                    <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Status</label>
                      <select name="eStatus" id="eStatus" class="form-control">
                        <option value="">Select Status</option>
                        <option value="Active" @if(isset($region)) @if($region->eStatus == 'Active') selected @endif @endif>Active</option>
                        <option value="Inactive" @if(isset($region)) @if($region->eStatus == 'Inactive') selected @endif @endif>Inactive</option>
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
                <a href="{{url('admin/region/listing')}}" class="btn-info btn">Back</a>
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
    if(vTitle.length == 0){
      error = true;
      $("#vTitle_error").show();
    }else{
      $("#vTitle_error").hide();
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
</script>
@endsection
