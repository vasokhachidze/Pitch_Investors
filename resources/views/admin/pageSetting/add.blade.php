@extends('layouts.app.admin-app')
@section('title', 'Page Setting - '.env('APP_NAME'))
@section('content')
<style>
.dynamic-added
    {
        margin-top: 5px;
    }
 </style>   
<section class="content-header">
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{ isset($pageSettings) ? 'Edit' : 'Add' }} Page setting</h1>
      </div>
    </div>
  </div>    
   <section class="content">
	<div class="content container-fluid">
        <div class="row">
			<div class="col-md-12">
				<div class="card">
					<!-- <div class="card-header">
                        <h4 class="card-title">Page Setting</h4>
                    </div> -->
                    <form method="post" action="{{route('admin.pageSetting.store')}}" id="frm" name="frm" enctype="multipart/form-data">
                    <div class="card-body">
                    @csrf
                        <input type="hidden" name="id" value="@if(isset($data)){{ $data->iPageSettingId }}@endif">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" id="vTitle" name="vTitle" placeholder="Title" value="@if(old('vTitle')!=''){{old('vTitle')}}@elseif(isset($data->vTitle)){{$data->vTitle}}@else{{old('vTitle')}}@endif">
                                <div id="vTitle_error" class="error mt-1" style="color :red ;display: none;">Please enter Title   
                                </div>
                                </div>    
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                <label>Description</label>
                                    <textarea class="form-control textarea" rows="2" name="tDescription" id="tDescription" placeholder="Enter Description">@if(isset($data)){{ $data->tDescription }}@endif</textarea>                                
                                    <div id="tDescription_error" class="error mt-1" style="color :red ;display: none;">Please enter Title   
                                </div>
                                </div>    
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                <label>Meta Title</label>
                                    <textarea class="form-control textarea" rows="2" name="vMetaTitle" id="vMetaTitle" placeholder="Enter Description">@if(isset($data)){{ $data->vMetaTitle }}@endif</textarea>                                
                                    <div id="vMetaTitle_error" class="error mt-1" style="color :red ;display: none;">Please enter Title   
                                </div>
                                </div>    
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Meta Keyword</label>
                                    <textarea class="form-control textarea" rows="2" name="tMetaKeywords" id="tMetaKeywords" placeholder="Enter Description">@if(isset($data)){{ $data->tMetaKeywords }}@endif</textarea>                                
                                    <div id="tMetaKeywords_error" class="error mt-1" style="color :red ;display: none;">Please enter Title   
                                </div>
                                </div>    
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                <label>Meta Description</label>
                                 <textarea class="form-control" rows="2" name="tMetaDescription" id="tMetaDescription" placeholder="Enter Meta Description">@if(isset($data)){{ $data->tMetaDescription }}@endif</textarea>
                                    <div id="tMetaDescription_error" class="error mt-1" style="color :red ;display: none;">Please enter Title   
                                </div>
                                </div>    
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Type</label>
                                <select id="eType" name="eType" class="form-control">
                                    <option value="">Select Type</option>
                                    <option value="About" @if(isset($data)){{ $data->eType == 'About' ? 'selected' : '' }}@endif>About</option>
                                    <option value="Privacy Policy" @if(isset($data)){{ $data->eType == 'Privacy Policy' ? 'selected' : '' }}@endif>Privacy Policy</option>
                                    <option value="Terms and Condition" @if(isset($data)){{ $data->eType == 'Terms and Condition' ? 'selected' : '' }}@endif>Terms and Condition</option>
                                </select>
                                <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">Please Select Status </div>
                                </div>    
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label>Status</label>
                                <select id="eStatus" name="eStatus" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="Active" @if(isset($data)) @if($data->eStatus == 'Active') selected @endif @endif>Active</option>
                                    <option value="Inactive" @if(isset($data)) @if($data->eStatus == 'Inactive') selected @endif @endif>Inactive</option>
                                </select>
                                <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">Please Select Status </div>
                                </div>    
                            </div>
                  
                            <div class="col-md-6" id="add_section"></div>
                            <div class="card-footer col-12 align-self-end d-inline-block mt-0">
                                <a href="javascript:;" class="btn btn-primary submit">Submit</a>
                                <a href="javascript:;" class="btn btn-primary loading" style="display: none;"> 
                                <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                                </a>
                                <a href="{{url('admin/pageSetting/listing')}}" class="btn-info btn">Back</a>
                            </div>
                        </div>
                       </form>
				    </div>
			    </div>
		    </div>
	    </div>
    </div>
</section>
</section>

@if(isset($pageSettings))  
<div class="modal fade bd-example-modal-lg " id="viewPage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Preview</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body" id="test">
         {!! $pageSettings->tPageSection !!}
      </div>
    </div>
  </div>
</div>
@endif
@endsection
@section('custom-js')
<script>

$(document).on('click','.submit',function()
{
   var iPageSettingId      = $("#id").val();
    var vTitle              = $("#vTitle").val();
    var vMetaTitle          = $("#vMetaTitle").val();
    var tMetaKeywords       = $("#tMetaKeywords").val();
    var tMetaDescription    = $("#tMetaDescription").val();
    var vImage              = $("#vImage").val();
    var description         = tinyMCE.get("tDescription").getContent();
    var eStatus             = $("#eStatus").val();

    var error = false;

    if(vTitle.length == ""){
        error = true;
        $("#vTitle_error").show();
    }
    else{
        $("#vTitle_error").hide();
    }

    if(description.length == 0){
        error = true;
        $("#tDescription_error").show();
    }
    else{
        $("#tDescription_error").hide();
    }
    
    // @if(!isset($data))
    // if(vImage.length == 0){
    //     error = true;
    //     $("#vImage_error").show();
    // }else{
    //     $("#vImage_error").hide();
    // }
    // @endif

    if(eStatus.length == 0){
        error = true;
        $("#eStatus_error").show();
    }
    else{
        $("#eStatus_error").hide();
    }

    if(error == true){
        return false;
    } else {
        $('.submit').hide();
        $('.loading').show();
        setTimeout(function(){
            $("#frm").submit();
            return true;
        }, 1000);
    }
});
</script>
@endsection

