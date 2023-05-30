@extends('layouts.app.admin-app')
@section('title', 'Category / Industry - '.env('APP_NAME'))
@section('content')

<section class="content-header">
<div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ isset($industry) ? 'Edit' : 'Add' }} Category / Industry</h1>
            </div>
        </div>
    </div>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
          @if(isset($industry))
            <!-- <div class="card-header custome-nav-tabs">
                 <h3 class="card-title"></h3>
                <br>
              
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="{{url('admin/industry/edit',$industry->vUniqueCode)}}">Category / Industry</a></li>
                </ul>
            
            </div> -->
            @endif
            <form action="{{url('admin/industry/store')}}" name="frm" id="frm" method="post" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if(isset($industry)){{$industry->vUniqueCode}}@endif">
                <div class="row">
                    <div class="form-group col-xl-6 col-lg-12 col-md-6">
                        <label>Industry Name</label>
                        <input type="text" name="vName" id="vName" class="form-control" placeholder="Enter Industry Name" value="@if(isset($industry)){{$industry->vName}}@endif">
                        <div id="vName_error" class="error mt-1" style="color:red;display: none;">Please Enter Industry Name   
                        </div>
                    </div>

                    <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Status</label>
                      <select name="eStatus" id="eStatus" class="form-control">
                        <option value="">Select Status</option>
                        <option value="Active" @if(isset($industry)) @if($industry->eStatus == 'Active') selected @endif @endif>Active</option>
                        <option value="Inactive" @if(isset($industry)) @if($industry->eStatus == 'Inactive') selected @endif @endif>Inactive</option>
                      </select>
                      <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">Please Select Status</div>
                    </div>

                     <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Show On Home Page</label>
                      <select name="eShowHomePage" id="eShowHomePage" class="form-control">
                        <option value="">Select Status</option>
                        <option value="Yes" @if(isset($industry)) @if($industry->eShowHomePage  == 'Yes') selected @endif @endif>Yes</option>
                        <option value="No" @if(isset($industry)) @if($industry->eShowHomePage  == 'No') selected @endif @endif>No</option>
                      </select>
                      <div id="eHomeStatus_error" class="error mt-1" style="color:red;display: none;">Please Select Status</div>
                    </div>


                    <div class="form-group col-xl-6 col-lg-12 col-md-6">
                      <label>Image</label>
                      <input type="file" name="vImage" id="vImage" accept="image/*" class="form-control">
                      @php
                          $image = asset('uploads/default/no-image.png');
                          if(isset($industry)){
                            if($industry->vImage != ""){
                              $image = asset('uploads/industry/'.$industry->vImage);
                            }
                          }
                      @endphp
                    <input type="hidden" name="old_image" id="old_image" class="form-control" value="{{$image}}">
                      <div id="vImage_error" class="error mt-1" style="color:red;display: none;">Please Select Image</div>
                      <div id="vImage_error_max" class="error mt-1" style="color:red;display: none;">Please Select Image Max File Size 2 MB</div>
                      <div id="vImage_error_required" class="error mt-1" style="color:red;display: none;">Please Select Image</div>
                      <img id="img" class="d-block mt-2" width="100px"  height="100px" src="{{$image}}">
                      <input type="hidden" name="old_vImage" id="old_vImage" value="{{ isset($industry)?$industry->vImage:'' }}">
                      @if ($errors->has('vImage'))
                      <div class="error mt-1" style="color:red;">The image must be a file of type: png, jpg, jpeg </div>
                      @endif
                    </div>

                    <div class="form-group col-xl-12 col-lg-12 col-md-12">
                      <label>Description</label>
                      <textarea class="form-control" id="tDescription" name="tDescription" placeholder="Please enter Description">@if(isset($industry)){{$industry->tDescription}}@endif</textarea>
                      <div id="tDescription_error" class="error mt-1" style="color:red;display: none;">Please Enter Description</div>
                    </div>
              </div>
              <div class="card-footer col-12 d-inline-block mt-0">
                <a href="javascript:;" class="btn btn-primary submit" id="save">Submit</a>
                <a href="javascript:;" class="btn btn-primary loading" style="display: none;"> 
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                </a>
                <a href="{{url('admin/industry/listing')}}" class="btn-info btn">Back</a>
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
<script type="text/javascript">
    var fileName = '';
  $(document).on('change','#vImage',function()
  {
    fileName = this.files[0].name;
    var filesize = this.files[0].size
    var maxfilesize = parseInt(filesize/1024);
    if(maxfilesize > 2048)
    {
      $('#vImage').val('');
      $("#vImage_error_max").show();
      $("#save").removeClass( "submit" );
      return false;
    }
    else
    {
        $("#save").addClass( "submit" );
        $("#vImage_error_max").hide();
    }
  });
  
  $(document).on('click','.submit',function(){
    tinymce.triggerSave();
    var vUniqueCode   = $("#vUniqueCode").val();
    var vName    = $("#vName").val();
    var tDescription     = $('#tDescription').val();
    var vImage        = $("#vImage").val();
    var eStatus        = $("#eStatus").val();
    var error     = false;
    
    if(fileName == ''){
        //$("#vImage_error_required").show();
    }
    else{
        $("#vImage_error_required").hide();
    }
    if(vName.length == 0){
        $("#vName_error").show();
        error = true;
    } else{
        $("#vName_error").hide();
    }
    if(tDescription.length == 0){
        $("#tDescription_error").show();
        error = true;
    } else{
        $("#tDescription_error").hide();
    }
    if(eStatus.length == 0){
        error = true;
        $("#eStatus_error").show();
    } else{
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
  $(document).on('change','#vImage',function(){
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#img').attr('src', e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    }
});

</script>
@endsection