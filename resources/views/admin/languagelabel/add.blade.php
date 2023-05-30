@extends('layouts.app.admin-app')
@section('title', 'Language Label- '.env('APP_NAME'))
@section('content')

<section class="content-header">
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{ isset($languagelabel) ? 'Edit' : 'Add' }} Language Label</h1>
      </div>
    </div>
  </div>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <!-- <div class="card-header">
                <h3 class="card-title"></h3>
            </div> -->

            <form action="{{url('admin/languagelabel/store')}}" name="frm" id="frm" method="post" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if(isset($languagelabel)) {{$languagelabel->vUniqueCode}} @endif">
                  <div class="row">
                  
                  <div class="col-md-6">
                        <div class="form-group">
                          <label>Language Label </label>
                              <input type="text" class="form-control" id="vLabel" name="vLabel" placeholder="Language Label" value="@if(old('vLabel')!=''){{old('vLabel')}}@elseif(isset($languagelabel->vLabel)){{$languagelabel->vLabel}}@else{{old('vLabel')}}@endif">
                              <div id="vLabel_error" class="error mt-1" style="color:red;display: none;">Please Enter Language Label</div>
                        </div>    
                    </div>
                   <div class="col-md-6">
                        <div class="form-group">
                          <label>Language Title </label>
                              <input type="text" class="form-control" id="vTitle" name="vTitle" placeholder="Language Title" value="@if(old('vTitle')!=''){{old('vTitle')}}@elseif(isset($languagelabel->vTitle)){{$languagelabel->vTitle}}@else{{old('vTitle')}}@endif">
                              <div id="vTitle_error" class="error mt-1" style="color:red;display: none;">Please Enter Language Title</div>
                        </div>    
                    </div>
                    <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Status</label>
                      <select name="eStatus" id="eStatus" class="form-control">
                        <option value="">Select Status</option>
                        <option value="Active" @if(isset($languagelabel)) @if($languagelabel->eStatus == 'Active') selected @endif @endif>Active</option>
                        <option value="Inactive" @if(isset($languagelabel)) @if($languagelabel->eStatus == 'Inactive') selected @endif @endif>Inactive</option>
                      </select>
                      <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">Please Select Status </div>
                    </div>
                    
                

                </div>
              </div>
              <div class="card-footer col-12 align-self-end d-inline-block mt-0">
                <a href="javascript:;" class="btn btn-primary submit" id="save">Submit</a>
                <a href="javascript:;" class="btn btn-primary submit_attachment" style="display: none;">Submit</a>
                <a href="javascript:;" class="btn btn-primary loading" style="display: none;"> 
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                </a>
                <a href="{{url('admin/languagelabel/listing')}}" class="btn-info btn">Back</a>
              </div>
            </form>
      </div>
    </div>
  </div>

</div>
</section>
</section>
@endsection

@section('custom-js')
<script>
  
  $(document).on('click','.submit',function(){
    vUniqueCode   = $("#vUniqueCode").val();
    eStatus       = $("#eStatus").val();
    vTitle        = $("#vTitle").val();
    vLabel        = $('#vLabel').val();
    var error = false;
    if(vLabel.length == 0)
    {
        $("#vLabel_error").show();
        error = true;
    } 
    else
    {
       $("#vLabel_error").hide();
    } 
    
    if(vTitle.length == 0)
    {
        $("#vTitle_error").show();
        error = true;
    } 
    else
    {
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
    setTimeout(function()
    {
      if(error == true){
        return false;
      } 
      else 
      {
        $("#frm").submit();
      }
      }, 1000);

    });
   
</script>
@endsection
