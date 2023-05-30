@extends('layouts.app.admin-app')
@section('title', 'Language - '.env('APP_NAME'))
@section('content')

<section class="content-header">

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            <div class="card-header">                              
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link" href="{{url('admin/admin/edit',$vUniqueCode)}}">Admin</a></li>
                  <li class="nav-item"><a class="nav-link active" href="{{url('admin/admin/change_password',$vUniqueCode)}}">Change Password</a></li>
                </ul>
            </div>
            <form action="{{url('admin/admin/change_password_action')}}" name="frm" id="frm" method="post" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="{{$vUniqueCode}}">

                <div class="row">
                    <div class="form-group col-lg-6 col-md-6 last">
                        <label class="label-control">Password</label>
                        <input type="password" class="form-control" id="vPassword" name="vPassword" maxlength="" value="" placeholder="Enter Password" required>
                        <div class="text-danger" style="display: none;" id="vPassword_error">Please Enter Password</div>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 last">
                        <label class="label-control">Confirm Password</label>
                            <input type="password" class="form-control" id="vPassword2" name="vPassword2" value="" maxlength="" placeholder="Enter Confirm Password" required>
                         <div id="vPassword2_error" class="error mt-1" style="color:red; display: none;">Please Enter Confirm Password</div>
                        <div class="error mt-1" id="vPassword2_same_error" style="color:red; display: none;">Password should match</div>
                    </div>
                </div>
              </div>
              <div class="card-footer col-12 d-inline-block mt-0">
                <a href="javascript:;" class="btn btn-primary submit">Submit</a>
                <a href="{{url('admin/admin')}}" class="btn-info btn">Back</a>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </section>
</section>


@endsection

@section('custom-css')
<style></style>
@endsection

@section('custom-js')
<script type="text/javascript">
 
  $(document).on('click','.submit',function(){
    vPassword  = $("#vPassword").val();
    vPassword2 = $("#vPassword2").val();
    
    var error = false;

    if(vPassword.length == 0){
        $("#vPassword_error").show();
        error = true;
      } else{
        $("#vPassword_error").hide();
      }

      if(vPassword2.length == 0){
        $("#vPassword2_error").show();
        $("#vPassword2_same_error").hide();
        error = true;
      } else{
        $("#vPassword2_error").hide();
      }
      if(vPassword.length != 0 && vPassword2.length != 0)
      {
        if(vPassword != vPassword2){
          $("#vPassword2_same_error").show();
          return false;
        } else{
          $("#vPassword2_same_error").hide();
        }
      }

    setTimeout(function(){
      if(error == true){
        return false;
      } else {
        $("#frm").submit();
        return true;
      }
    }, 1000);

});

</script>
@endsection