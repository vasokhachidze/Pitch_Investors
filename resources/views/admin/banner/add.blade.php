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
                    <h1>{{ isset($banner) ? 'Edit' : 'Add' }} Banner</h1>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card ">

                            <form action="{{ url('admin/banner/store') }}" name="frm" id="frm" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="card-body">

                                    <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if (isset($banner)) {{ $banner->vUniqueCode }} @endif">

                                    <div class="row">
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Banner Title</label>
                                            <input type="text" name="vBannerTitle" id="vBannerTitle" class="form-control" placeholder="Enter Banner Title" value="@if (isset($banner)) {{ $banner->vBannerTitle }} @endif">
                                            <div id="vBannerTitle_error" class="error mt-1" style="color:red;display: none;">Please Enter Banner Title
                                            </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Banner sub title</label>
                                            <input type="text" name="vSubTitle" id="vSubTitle" class="form-control" placeholder="Enter Banner sub title" value="@if (isset($banner)) {{ $banner->vSubTitle }} @endif">
                                            <div id="vSubTitle_error" class="error mt-1" style="color:red;display: none;">Please Enter Banner sub Title
                                            </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Image</label>
                                            <input type="file" name="vImage" id="vImage" accept="image/*" class="form-control">
                                            @php
                                                $image = asset('uploads/default/no-image.png');
                                                if (isset($banner)) {
                                                    if ($banner->vBannerImage != '' && file_exists(asset('uploads/banner/' . $banner->vBannerImage))) {
                                                        $image = asset('uploads/banner/' . $banner->vBannerImage);
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
                                            <label>Status</label>
                                            <select name="eStatus" id="eStatus" class="form-control">
                                                <option value="">Select Status</option>
                                                <option value="Active" @if (isset($banner)) @if ($banner->eStatus == 'Active') selected @endif @endif>Active</option>
                                                <option value="Inactive" @if (isset($banner)) @if ($banner->eStatus == 'Inactive') selected @endif @endif>Inactive</option>vUniqueCode
                                            </select>
                                            <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">Please Select Status
                                            </div>
                                        </div>

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Show On Home Page</label>
                                            <select name="eShowHomePage" id="eShowHomePage" class="form-control">
                                                <option value="">Select option</option>
                                                <option value="Yes" @if (isset($banner)) @if ($banner->eShowHomePage == 'Yes') selected @endif @endif>Yes</option>
                                                <option value="No" @if (isset($banner)) @if ($banner->eShowHomePage == 'No') selected @endif @endif>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer col-12 d-inline-block mt-0">
                                    <a href="javascript:;" class="btn btn-primary submit" id="save">Submit</a>
                                    <a href="javascript:;" class="btn btn-primary loading" style="display: none;">
                                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                                    </a>
                                    <a href="{{ url('admin/banner/listing') }}" class="btn-info btn">Back</a>
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
            var vBannerTitle = $("#vBannerTitle").val();
            var vSubTitle = $("#vSubTitle").val();
            var vImage = $("#vImage").val();
            var eStatus = $("#eStatus").val();
            var error = false;

            if (vBannerTitle.length == 0) {
                $("#vBannerTitle_error").show();
                error = true;
            } else {
                $("#vBannerTitle_error").hide();
            }
            if (vSubTitle.length == 0) {
                $("#vSubTitle_error").show();
                error = true;
            } else {
                $("#vSubTitle_error").hide();
            }

            if (eStatus.length == 0) {
                error = true;
                $("#eStatus_error").show();
            } else {
                $("#eStatus_error").hide();
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

        $(document).on('change', '#vImage', function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#img').attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
@endsection
