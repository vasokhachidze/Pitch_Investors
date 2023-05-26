@extends('layouts.app.admin-app')
@section('title', 'Language - '.env('APP_NAME'))
@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{ isset($admin) ? 'Edit' : 'Add' }} Admin</h1>
      </div>
    </div>
  </div>
  <!- <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card ">
            @if(isset($admin))
            <div class="card-header custome-nav-tabs">
              <h3 class="card-title"></h3>
                <br>

              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="{{url('admin/admin/edit',$admin->vUniqueCode)}}">Admin</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('admin/admin/change_password',$admin->vUniqueCode)}}">Change Password</a></li>
              </ul>

            </div>
            @endif
            <form action="{{url('admin/admin/store')}}" name="frm" id="frm" method="post" enctype="multipart/form-data">
              @csrf

              <div class="card-body">

                <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if(isset($admin)){{$admin->vUniqueCode}}@endif">

                <div class="row">

                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Firstname</label>
                    <input type="text" name="vFirstName" id="vFirstName" class="form-control" placeholder="Enter FirstName" value="@if(isset($admin)){{$admin->vFirstName}}@endif">
                    <div id="vFirstName_error" class="error mt-1" style="color:red;display: none;">Please Enter Firstname
                    </div>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Lastname</label>
                    <input type="text" name="vLastName" id="vLastName" class="form-control" placeholder="Enter LastName" value="@if(isset($admin)){{$admin->vLastName}}@endif">
                    <div id="vLastName_error" class="error mt-1" style="color:red;display: none;">Please Enter Lastname
                    </div>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" value="@if(isset($admin)){{$admin->email}}@endif">
                    <div id="email_error" class="error mt-1" style="color:red;display: none;">Please Enter Email
                    </div>
                    <div id="email_valid_error" class="error mt-1" style="color:red;display: none;">Please Enter Valid Email</div>
                    <div id="email_unique_error" class="error mt-1" style="color:red;display: none;">Please Enter Different Email</div>
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Phone</label>
                    <input type="text" name="vPhone" id="vPhone" class="form-control" placeholder="Enter Phone" value="@if(isset($admin)){{$admin->vPhone}}@endif">
                    <div id="vPhone_error" class="error mt-1" style="color:red;display: none;">Please Enter Phone
                    </div>
                    <div id="vPhone_valid_error" class="error mt-1" style="color:red;display: none;">Please Enter 10 Digit Mobile Number
                    </div>
                  </div>
                  @if(!isset($admin))
                  <div class="form-group col-lg-6 col-md-6 last">
                    <label class="label-control">Password</label>
                    <input type="password" class="form-control" id="vPassword" name="vPassword" maxlength="6" value="" placeholder="Enter Password" required>
                    <div class="text-danger" style="display: none;" id="vPassword_error">Please Enter Password</div>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 last">
                    <label class="label-control">Confirm Password</label>
                    <input type="password" class="form-control" id="vPassword2" name="vPassword2" value="" maxlength="6" placeholder="Enter Confirm Password" required>
                    <div id="vPassword2_error" class="error mt-1" style="color:red; display: none;">Please Enter Confirm Password</div>
                    <div class="error mt-1" id="vPassword2_same_error" style="color:red; display: none;">Password should match</div>
                  </div>
                  @endif

                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Image</label>
                    <input type="file" name="vImage" id="vImage" accept="image/*" class="form-control">
                    @php
                    $image = asset('uploads/default/no-image.png');
                    if(isset($admin)){
                    if($admin->vImage != ""){
                    $image = asset('uploads/admin/'.$admin->vImage);
                    }
                    }
                    @endphp
                    <img id="img" class="d-block mt-2" width="100px" height="100px" src="{{$image}}">
                    @if(isset($admin))
                    @if($admin->vImage!= "")
                    <a href="javascript:;" class="removeImage btn btn-danger">X</a>
                    @endif
                    @endif
                    <div id="vImage_error" class="error mt-1" style="color:red;display: none;">Please Select Image
                    </div>
                    <div id="vImage_error_max" class="error mt-1" style="color:red;display: none;">Please Select Image Max File Size 2 MB
                    </div>
                    @if ($errors->has('vImage'))
                    <div class="error mt-1" style="color:red;">The image must be a file of type: png, jpg, jpeg </div>
                    @endif
                  </div>
                  <div class="form-group col-xl-6 col-lg-12 col-md-6">
                    <label>Status</label>
                    <select name="eStatus" id="eStatus" class="form-control">
                      <option value="">Select Status</option>
                      <option value="Active" @if(isset($admin)) @if($admin->eStatus == 'Active') selected @endif @endif>Active</option>
                      <option value="Inactive" @if(isset($admin)) @if($admin->eStatus == 'Inactive') selected @endif @endif>Inactive</option>
                    </select>
                    <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">Please Select Status
                    </div>
                  </div>
                </div>
                <div class="card-footer col-12 d-inline-block mt-0">
                  <a href="javascript:;" class="btn btn-primary submit" id="save">Submit</a>
                  <a href="javascript:;" class="btn btn-primary loading" style="display: none;">
                    <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                  </a>
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
  $(document).on('change', '#vImage', function() {
    var filesize = this.files[0].size
    var maxfilesize = parseInt(filesize / 1024);
    if (maxfilesize > 2048) {
      $('#vImage').val('');
      $("#vImage_error_max").show();
      $("#save").removeClass("submit");
      return false;
    } else {
      $("#save").addClass("submit");
      $("#vImage_error_max").hide();
    }
  });
  $(document).on('keyup', '#vPhone', function() {
    vPhone = $(this).val();
    if (vPhone.length > 10) {
      $('#vPhone').val(vPhone.substring(0, 10));
    }

  });
  $(document).on('keypress', '#vPhone', function(e) {
    var charCode = (e.which) ? e.which : event.keyCode
    if (String.fromCharCode(charCode).match(/[^0-9]/g))
      return false;
  });
  $(document).on('click', '.removeImage', function() {

    if (confirm('Are you sure delete this data?')) {
      var vUniqueCode = $("#vUniqueCode").val();
      var vImage = $("#vImage").val(null);
      var vFiles = $(this).data('files');

      $.ajax({
        url: "{{url('admin/admin/remove_attachment')}}",
        method: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: "JSON",
        data: {
          vUniqueCode: vUniqueCode,
          vFiles: vFiles
        },
        success: function(response) {
          if (response.status == "200") {
            toastr.success(response.notification);
          } else {
            toastr.error(response.notification);
          }
          $("#img").remove();
          $(".removeImage").hide();
        }
      })
    }
  });

  $(document).on('click', '.submit', function() {
    var vUniqueCode = $("#vUniqueCode").val();
    var vFirstName = $("#vFirstName").val();
    var vLastName = $("#vLastName").val();
    var email = $("#email").val(); // should be vEmail not email
    var vPhone = $("#vPhone").val();
    var vPassword = $("#vPassword").val();
    var vPassword2 = $("#vPassword2").val();
    var vImage = $("#vImage").val();
    var eStatus = $("#eStatus").val();
    var error = false;

    if (vFirstName.length == 0) {
      $("#vFirstName_error").show();
      error = true;
    } else {
      $("#vFirstName_error").hide();
    }
    if (vLastName.length == 0) {
      error = true;
      $("#vLastName_error").show();
    } else {
      $("#vLastName_error").hide();
    }
    if (vPhone.length == 0) {
      $("#vPhone_error").show();
      error = true;
    } else if (vPhone.length < 10) {
      $("#vPhone_error").hide();
      $('#vPhone_valid_error').show();
      error = true;
    } else {
      $("#vPhone_error").hide();
      $('#vPhone_valid_error').hide();
    }
    if (eStatus.length == 0) {
      error = true;
      $("#eStatus_error").show();
    } else {
      $("#eStatus_error").hide();
    }
    if (email.length == 0) {
      $("#email_error").show();
      $("#email_unique_error").hide();
      $("#email_valid_error").hide();
      error = true;
    } else {
      if (vUniqueCode != "")
        data = {
          vUniqueCode: vUniqueCode,
          email: email
        };
      else
        data = {
          email: email
        };

      if (validateEmail(email)) {
        $("#email_valid_error").hide();
        $.ajax({
          url: "{{url('admin/admin/check_unique_email')}}",
          type: "POST",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          dataType: "JSON",
          data: data,
          success: function(response) {
            if (response.message == "1") {
              $("#email_unique_error").show();
              $("#email_error").hide();
              error = true;
            } else {
              $("#email_unique_error").hide();
              $("#email_error").hide();
            }
          }
        });
      } else {
        $("#email_valid_error").show();
        $("#email_error").hide();
        $("#email_unique_error").hide();
        error = true;
      }
    }
    if (vUniqueCode == "") {
      if (vPassword.length == 0) {
        $("#vPassword_error").show();
        error = true;
      } else {
        $("#vPassword_error").hide();
      }

      if (vPassword2.length == 0) {
        $("#vPassword2_error").show();
        $("#vPassword2_same_error").hide();
        error = true;
      } else {
        $("#vPassword2_error").hide();
      }
      if (vPassword.length != 0 && vPassword2.length != 0) {
        if (vPassword != vPassword2) {
          $("#vPassword2_same_error").show();
          return false;
        } else {
          $("#vPassword2_same_error").hide();
        }
      }
    }

    setTimeout(function() {
      if (error == true) {
        return false;
      } else {
        $("#frm").submit();
        $('.submit').hide();
        $('.loading').show();
        return true;
      }
    }, 1000);

  });

  function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
      return true;
    } else {
      return false;
    }
  }
</script>
@endsection