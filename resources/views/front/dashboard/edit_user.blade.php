@extends('layouts.app.front-app')
@section('title', 'Edit Profile '.env('APP_NAME'))
@section('custom-css')
<style>
    .changePasswordButtonDiv {
        margin-top: 2%;
    }
    .add_space_top {
        margin-top: 2%;
    }
</style>
@endsection
@section('content')
@php
    /* dd($userData); */
@endphp
<section class="my-dashbord">
    <div class="container">
        <div class="row">
            @include('layouts.front.left_dashboard')
            <div class="col-lg-9">
                <div class="right-panal-side">
                    @include('layouts.front.header_dashboard')
                    <div class="row mt-3 padding-no">
                        <div class="letest-activity">
                            <form action="{{url('editUser_store')}}" method="Post" id="frm-editUser" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Edit Profile</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input margin-bottom-five">
                                            <label for="vFirstName">Enter First Name</label>
                                            <input type="text" class="form-control" id="vFirstName" name="vFirstName" value="{{$userData->vFirstName}}">
                                        </div>
                                        <div id="vFirstName_error" class="error mt-1" style="color:red;display: none;">Please Enter First Name</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input margin-bottom-five">
                                            <label for="vLastName">Enter Last Name</label>
                                            <input type="text" class="form-control" id="vLastName" name="vLastName" value="{{$userData->vLastName}}" placeholder="Enter Last Name">
                                        </div>
                                        <div id="vLastName_error" class="error mt-1" style="color:red;display: none;">Please Enter Last Name</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input margin-bottom-five">
                                            <label for="vEmail">Enter Email</label>
                                            <input type="text" class="form-control" id="vEmail" name="vEmail" value="{{$userData->vEmail}}" placeholder="Enter Email" readonly>
                                        </div>
                                        <div id="vEmail_error" class="error_show">Please Enter Email</div>
                                        <div id="vEmail_valid_error" class="error_show">Please Enter Valid Email</div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-input margin-bottom-five">
                                            <label for="vPhone">Enter Phone No.</label>
                                            <input type="text" class="form-control numeric" id="vPhone" value="{{$userData->vPhone}}" name="vPhone" maxlength="10" minlength="10" placeholder="Enter Phone No.">
                                        </div>
                                        <div id="vPhone_error" class="error mt-1" style="color:red;display: none;">Please Enter Phone No.</div>
                                        <div id="vPhone_error_min" class="error mt-1" style="color:red;display: none;">Please enter 10 digit mobile number</div>
                                    </div>

                                    
                                    <div class="col-md-6">
                                        <div class="form-input margin-bottom-five">
                                            <label for="vVat">Image</label>
                                              <input type="file" id="cropzee-input" name="vImage" id="vImage" accept="image/*" class="form-control">
                                                @php
                                                $image = asset('uploads/default/no-image.png');
                                                if(isset($session_data)){
                                                    if($session_data['vImage'] != ""){
                                                        $image = asset('uploads/user/'.$session_data['vImage']);
                                                    }
                                                }
                                                @endphp
                                                <img id="img" class="d-block mt-2 image-previewer edit-page-logo"  data-cropzee="cropzee-input"  width="100px" height="100px" src="{{$image}}">
                                                <input type="hidden"  id="get_cropped_image" name="get_cropped_image">
                                                <div id="vImage_error" class="error mt-1" style="color:red;display: none;">Please Select Image</div>
                                        </div>
                                        <div id="vImage" class="error mt-1" style="color:red;display: none;">Please Select Profile Image</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-input margin-bottom-five">
                                            <label for="vVat">Enter VAT (%)</label>
                                            <input type="text" class="form-control numeric" id="vVat" name="vVat" value="{{$userData->vVat}}" maxlength="2" placeholder="Enter VAT">
                                        </div>
                                        <div id="vVat_error" class="error mt-1" style="color:red;display: none;">Please Enter VAT</div>
                                    </div> 


                                    <div class="col-md-12 changePasswordButtonDiv">
                                        <a href="#" id="editUserSubmit" class="btn btn-primary bg-green">Submit</a>
                                        <a href="{{url('dashboard')}}" class="btn btn-danger">Cancle</a>
                                    </div>
                                    <div class="col-md-4 offset-md-4">
                                        <a href="javascript:;" class="btn loading" style="display: none;"> 
                                            <h4 style="color: gray"><span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...</h4>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="secondary-chat col-12 d-lg-none d-block" >
                        <div>
                            @if ($session_data !== '')
                                @include('layouts.front.chat_inbox_connection_listing')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('custom-js')
<script>
     $(document).ready(function() 
        {
            $("#cropzee-input").cropzee({startSize: [85, 85, '%'],});
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

    $(document).on('click','#editUserSubmit',function(){
        var vFirstName    = $("#vFirstName").val();
        var vLastName = $("#vLastName").val();
        var vEmail = $("#vEmail").val();
        var vPhone = $("#vPhone").val();
        var vVat = $("#vVat").val();
        var error     = false;
        if(vFirstName.length == 0){
            $("#vFirstName_error").show();
            error = true;
        } else{
            $("#vFirstName_error").hide();
        }
        if(vLastName.length == 0){
            $("#vLastName_error").show();
            error = true;
        } else{
            $("#vLastName_error").hide();
        }

        /* if (vEmail.length == 0) {
            $("#vEmail_error").show();
            $("#vEmail_valid_error").hide();
            error = true;
        } else {
            if (validateEmail(vEmail)) {
                $("#vEmail_error").hide();
                $("#vEmail_valid_error").hide();
            } else {
                $("#vEmail_valid_error").show();
                $("#vEmail_error").hide();
                error = true;
            }
        } */

        if(vPhone.length == 0){
            $("#vPhone_error").show();
            $("#vPhone_error_min").hide();
            error = true;
        } else{
            if (vPhone.length < 10) {
                $("#vPhone_error_min").show();
                $("#vPhone_error").hide();
                error = true;
            }
            else{
                $("#vPhone_error_min").hide();
                $("#vPhone_error").hide();
            }
        }

        if(vVat.length == 0){
            $("#vVat_error").show();
            error = true;
        } else{
            $("#vVat_error").hide();
        }
        
        setTimeout(function(){
        if(error == true){
            return false;
        } else {
            $("#frm-editUser").submit();
            $('.changePasswordButtonDiv').hide();
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
    $(document).on("input", ".numeric", function() {
        this.value = this.value.replace(/\D/g,'');
    });
</script>
@endsection
