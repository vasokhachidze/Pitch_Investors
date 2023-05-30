@extends('layouts.app.admin-app')
@section('title', 'Language - ' . env('APP_NAME'))
@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css" integrity="sha512-TQQ3J4WkE/rwojNFo6OJdyu6G8Xe9z8rMrlF9y7xpFbQfW5g8aSWcygCQ4vqRiJqFsDsE1T6MoAOMJkFXlrI9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($user) ? 'Edit' : 'Add' }} user</h1>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card ">
                            @if (isset($user))
                                <div class="card-header custome-nav-tabs">
                                    <!-- <h3 class="card-title"></h3>
                    <br> -->

                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="{{ url('admin/user/edit', $user->vUniqueCode) }}">User</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ url('admin/user/change_password', $user->vUniqueCode) }}">Change Password</a></li>
                                    </ul>

                                </div>
                            @endif
                            <form action="{{ url('admin/user/store') }}" name="frm" id="frm" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="card-body">

                                    <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if (isset($user)) {{ $user->vUniqueCode }} @endif">

                                    <div class="row">
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Firstname</label>
                                            <input type="text" name="vFirstName" id="vFirstName" class="form-control" placeholder="Enter FirstName" value="@if (isset($user)) {{ $user->vFirstName }} @endif">
                                            <div id="vFirstName_error" class="error mt-1" style="color:red;display: none;">Please Enter Firstname
                                            </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Lastname</label>
                                            <input type="text" name="vLastName" id="vLastName" class="form-control" placeholder="Enter LastName" value="@if (isset($user)) {{ $user->vLastName }} @endif">
                                            <div id="vLastName_error" class="error mt-1" style="color:red;display: none;">Please Enter Lastname
                                            </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Email</label>
                                            <input type="email" name="vEmail" id="email" class="form-control" placeholder="Enter Email" value="@if (isset($user)) {{ $user->vEmail }} @endif">
                                            <div id="email_error" class="error mt-1" style="color:red;display: none;">Please Enter Email
                                            </div>
                                            <div id="email_valid_error" class="error mt-1" style="color:red;display: none;">Please Enter Valid Email</div>
                                            <div id="email_unique_error" class="error mt-1" style="color:red;display: none;">Please Enter Different Email</div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Phone</label>
                                            <input type="text" name="vPhone" id="vPhone" class="form-control" placeholder="Enter Phone" value="@if (isset($user)) {{ $user->vPhone }} @endif">
                                            <div id="vPhone_error" class="error mt-1" style="color:red;display: none;">Please Enter Phone
                                            </div>
                                            <div id="vPhone_valid_error" class="error mt-1" style="color:red;display: none;">Please Enter 10 Digit Mobile Number
                                            </div>
                                        </div>
                                        @if (!isset($user))
                                            <div class="form-group col-lg-6 col-md-6 last">
                                                <label class="label-control">Password</label>
                                                <input type="password" class="form-control" id="vPassword" name="vPassword" value="" placeholder="Enter Password" required>
                                                <div class="text-danger" style="display: none;" id="vPassword_error">Please Enter Password</div>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 last">
                                                <label class="label-control">Confirm Password</label>
                                                <input type="password" class="form-control" id="vPassword2" name="vPassword2" value="" placeholder="Enter Confirm Password" required>
                                                <div id="vPassword2_error" class="error mt-1" style="color:red; display: none;">Please Enter Confirm Password</div>
                                                <div class="error mt-1" id="vPassword2_same_error" style="color:red; display: none;">Password should match</div>
                                            </div>
                                        @endif

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Image</label>
                                            <input type="file" name="vImage" id="vImage" accept="image/*" class="form-control">
                                            @php
                                                $image = asset('front/assets/images/defaultuser.png');
                                                if (isset($user)) {
                                                    if ($user->vImage != '') {
                                                        $image = asset('uploads/user/' . $user->vImage);
                                                    }
                                                }
                                            @endphp
                                            <img id="img" class="d-block mt-2" width="100px" height="100px" src="{{ $image }}">

                                            <div id="vImage_error" class="error mt-1" style="color:red;display: none;">Please Select Image
                                            </div>
                                            <div id="vImage_error_max" class="error mt-1" style="color:red;display: none;">Please Select Image Max File Size 2 MB
                                            </div>
                                            @if ($errors->has('vImage'))
                                                <div class="error mt-1" style="color:red;">The image must be a file of type: png, jpg, jpeg </div>
                                            @endif
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
											@php
												$date = (!empty($user->dDOB)?date('d-M-Y',strtotime($user->dDOB)):'');
											@endphp
                                            <label>DOB</label>
                                            <div class="input-group date input-wrapper">
                                                <input type="text" name="dDOB" id="dDOB" class="form-control datepicker" value="{{$date}}" placeholder="Select Date of Birth">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                {{-- <i class="fa fa-calendar" aria-hidden="true"></i> --}}
                                            </div>
                                            <div id="dDOB_error" class="error mt-1" style="color:red;display: none;">Please Select Date of Birth
                                            </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Status</label>
                                            <select name="eStatus" id="eStatus" class="form-control">
                                                <option value="">Select Status</option>
                                                <option value="Active" @if (isset($user)) @if ($user->eStatus == 'Active') selected @endif @endif>Active</option>
                                                <option value="Inactive" @if (isset($user)) @if ($user->eStatus == 'Inactive') selected @endif @endif>Inactive</option>
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
                                        <a href="{{ url('admin/user/listing') }}" class="btn-info btn">Back</a>
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
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css" integrity="sha512-TQQ3J4WkE/rwojNFo6OJdyu6G8Xe9z8rMrlF9y7xpFbQfW5g8aSWcygCQ4vqRiJqFsDsE1T6MoAOMJkFXlrI9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style type="text/css">
    </style>
@endsection

@section('custom-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        var datePicker = $('#dDOB');
        datePicker.datepicker({
            format: 'dd-MM-yyyy',
            autoclose: true,
            endDate: '+0d',
        });
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


        $(document).on('click', '.submit', function() {
            var vUniqueCode = $("#vUniqueCode").val();
            var selectedDate = datePicker.val();
            var vFirstName = $("#vFirstName").val();
            var vLastName = $("#vLastName").val();
            var email = $("#email").val();
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
            if (selectedDate.length == 0) {
                $("#dDOB_error").show();
                error = true;
            } else {
                $("#dDOB_error").hide();
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
                        url: "{{ url('admin/user/check_unique_email') }}",
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
