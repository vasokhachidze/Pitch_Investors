@extends('layouts.app.admin-app')
@section('title', 'Testimonial - '.env('APP_NAME'))
@section('content')

<section class="content-header">
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{ isset($testimonial) ? 'Edit' : 'Add' }} Testimonial</h1>
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

            <form action="{{url('admin/testimonial/store')}}" name="frm" id="frm" method="post" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if(isset($testimonial)) {{$testimonial->vUniqueCode}} @endif">
                  <div class="row">
                   
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>Testimonial Name </label>
                              <input type="text" class="form-control" id="vName" name="vName" placeholder="Name" value="@if(old('vName')!=''){{old('vName')}}@elseif(isset($testimonial->vName)){{$testimonial->vName}}@else{{old('vName')}}@endif">
                              <div id="vName_error" class="error mt-1" style="color:red;display: none;">Please Enter Testimonial Name</div>
                        </div>    
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>Testimonial Rating </label>
                              <input type="text" class="form-control" id="vRating" name="vRating" placeholder="Rating" value="@if(old('vRating')!=''){{old('vRating')}}@elseif(isset($testimonial->vRating)){{$testimonial->vRating}}@else{{old('vRating')}}@endif">
                              <div id="vRating_error" class="error mt-1" style="color:red;display: none;">Please Enter Testimonial Rating</div>
                        </div>    
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>Upload Image </label>
                            <input type="file" name="vImage" id="vImage" accept="image/*" class="form-control">
                            @php
                                $image = asset('uploads/default/no-image.png');
                                if (isset($testimonial)) {
                                    if (!empty($testimonial->vImage)) {
                                        $image = asset('uploads/front/testimonial/' . $testimonial->vImage);
                                    }
                                }
                            @endphp
                            <img id="img" class="d-block mt-2" width="100px" height="100px" src="{{ $image }}">
                        </div>    
                    </div>
                    <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Status</label>
                      <select name="eStatus" id="eStatus" class="form-control">
                        <option value="">Select Status</option>
                        <option value="Active" @if(isset($testimonial)) @if($testimonial->eStatus == 'Active') selected @endif @endif>Active</option>
                        <option value="Inactive" @if(isset($testimonial)) @if($testimonial->eStatus == 'Inactive') selected @endif @endif>Inactive</option>
                      </select>
                      <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">Please Select Status </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label>Description</label>
                        <textarea class="form-control description" id="tDescription" name="tDescription" placeholder="Description">@if(!empty($testimonial->tDescription)){{ $testimonial->tDescription }} @endif</textarea>
                        <div id="tDescription_error" class="error mt-1" style="color:red;display: none;">Please Enter Testimonial Description  
                        </div>
                    </div>
                

                </div>
              </div>
              <div class="card-footer col-12 align-self-end d-inline-block mt-0">
                <a href="javascript:;" class="btn btn-primary submit">Submit</a>
                <a href="javascript:;" class="btn btn-primary submit_attachment" style="display: none;">Submit</a>
                <a href="javascript:;" class="btn btn-primary loading" style="display: none;"> 
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                </a>
                <a href="{{url('admin/testimonial/listing')}}" class="btn-info btn">Back</a>
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
    eStatus       = $("#eStatus").val();
    vName         = $("#vName").val();
    vRating       = $("#vRating").val();
    tDescription  = tinyMCE.get('tDescription').getContent();
    var error = false;
    if(vName.length == 0)
    {
        $("#vName_error").show();
        error = true;
    } 
    else
    {
       $("#vName_error").hide();
    } 
    if(vRating.length == 0)
    {
        $("#vRating_error").show();
        error = true;
    } 
    else
    {
       $("#vRating_error").hide();
    } 
    if(tDescription.length == 0)
    {
        $("#tDescription_error").show();
        error = true;
    } 
    else
    {
        $("#tDescription_error").hide();
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
