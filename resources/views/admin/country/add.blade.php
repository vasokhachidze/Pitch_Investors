@extends('layouts.app.admin-app')
@section('title', 'Country - '.env('APP_NAME'))
@section('content')

<section class="content-header">


<div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ isset($country) ? 'Edit' : 'Add' }} Country</h1>
            </div>
        </div>
    </div>
    </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <!-- <div class="card-header">
                <h3 class="card-title"></h3>
            </div> -->

            <form action="{{url('admin/country/store')}}" name="frm" id="frm" method="post" enctype="multipart/form-data">
              @csrf
              <div class="card-body">

                <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if(isset($country)) {{$country->vUniqueCode}} @endif">

                <div class="row">
                    <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Country Name</label>
                        <input type="text" name="vCountry" id="vCountry" class="form-control" placeholder="Enter Country Name" value="@if(isset($country)){{$country->vCountry}}@endif">
                        <div id="vCountry_error" class="error mt-1" style="color:red;display: none;">Please Enter Country Name   
                        </div>
                    </div>
                    <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Country Code</label>
                        <input type="text" name="vCountryCode" id="vCountryCode" class="form-control" placeholder="Enter Country Code" value="@if(isset($country)){{$country->vCountryCode}}@endif">
                        <div id="vCountryCode_error" class="error mt-1" style="color:red;display: none;">Please Enter Country Code
                        </div>
                    </div>

                    <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Phone Code</label>
                        <input type="text" name="vCountryISDCode" id="vCountryISDCode" class="form-control" placeholder="Enter Phone Code" value="@if(isset($country)){{$country->vCountryISDCode}}@endif">
                        <div id="vCountryISDCode_error" class="error mt-1" style="color:red;display: none;">Please Enter Country ISD Code 
                        </div>
                    </div>
                    <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Status</label>
                      <select name="eStatus" id="eStatus" class="form-control">
                        <option value="">Select Status</option>
                        <option value="Active" @if(isset($country)) @if($country->eStatus == 'Active') selected @endif @endif>Active</option>
                        <option value="Inactive" @if(isset($country)) @if($country->eStatus == 'Inactive') selected @endif @endif>Inactive</option>
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
                <a href="{{url('admin/country/listing')}}" class="btn-info btn">Back</a>
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
    vCountry          = $("#vCountry").val();
    vCountryCode      = $("#vCountryCode").val();
    vCountryISDCode   = $("#vCountryISDCode").val();
    eStatus           = $("#eStatus").val();

    var error = false;


    if(vCountry.length == 0){
      error = true;
      $("#vCountry_error").show();
    }else{
      $("#vCountry_error").hide();
    }

    if(vCountryCode.length == 0){
      error = true;
      $("#vCountryCode_error").show();
    }else{
      $("#vCountryCode_error").hide();
    }

    if(vCountryISDCode.length == 0){
      error = true;
      $("#vCountryISDCode_error").show();
    }else{
      $("#vCountryISDCode_error").hide();
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
