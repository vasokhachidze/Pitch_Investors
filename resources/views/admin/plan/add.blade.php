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
                    <h1>{{ isset($plan) ? 'Edit' : 'Add' }} Plan</h1>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card ">

                            <form action="{{ url('admin/plan/store') }}" name="frm" id="frm" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="card-body">

                                    <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if (isset($plan)) {{ $plan->vUniqueCode }} @endif">
                                    <input type="hidden" id="vPlanCode" name="vPlanCode" value="@if (isset($plan)) {{ $plan->vPlanCode }} @endif">

                                    <div class="row">
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Plan Title</label>
                                            <input type="text" name="vPlanTitle" id="vPlanTitle" class="form-control" placeholder="Enter Plan Title" value="@if(isset($plan)){{$plan->vPlanTitle}}@endif">
                                            <div id="vPlanTitle_error" class="error mt-1" style="color:red;display: none;">Please Enter Plan Title
                                            </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Plan Price</label>
                                            <input type="number" name="vPlanPrice" id="vPlanPrice" class="form-control" placeholder="Enter Plan Price" value="@if(isset($plan)){{$plan->vPlanPrice}}@endif">
                                            <div id="vPlanPrice_error" class="error mt-1" style="color:red;display: none;">Please Enter Plan Price
                                            </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Plan No of Connection</label>
                                            <input type="number" name="iNoofConnection" id="iNoofConnection" class="form-control" placeholder="Enter Plan No of Connection" value="@if(isset($plan)){{$plan->iNoofConnection}}@endif">
                                            <div id="iNoofConnection_error" class="error mt-1" style="color:red;display: none;">Please Enter Plan No of Connection
                                            </div>
                                        </div>
                                        <div class="form-group col-xl-12 col-lg-12 col-md-6">
                                            <label>Plan Detail</label>
                                            <textarea name="vPlanDetail" id="vPlanDetail" class="form-control" placeholder="Enter Banner sub title" >@if(isset($plan)){{$plan->vPlanDetail}}@endif</textarea>
                                            <div id="vPlanDetail_error" class="error mt-1" style="color:red;display: none;">Please Enter Plan Detail
                                            </div>
                                        </div>              

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Status</label>
                                            <select name="eStatus" id="eStatus" class="form-control">
                                                <option value="">Select Status</option>
                                                <option value="Active" @if (isset($plan)) @if ($plan->eStatus == 'Active') selected @endif @endif>Active</option>
                                                <option value="Inactive" @if (isset($plan)) @if ($plan->eStatus == 'Inactive') selected @endif @endif>Inactive</option>vUniqueCode
                                            </select>
                                            <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">Please Select Status
                                            </div>
                                        </div>                                      
                                    </div>
                                </div>
                                <div class="card-footer col-12 d-inline-block mt-0">
                                    <a href="javascript:;" class="btn btn-primary submit" id="save">Submit</a>
                                    <a href="javascript:;" class="btn btn-primary loading" style="display: none;">
                                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                                    </a>
                                    <a href="{{ url('admin/plan/listing') }}" class="btn-info btn">Back</a>
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
       
       

        $(document).on('click', '.submit', function() {
            var vUniqueCode = $("#vUniqueCode").val();
            var vPlanTitle = $("#vPlanTitle").val();
            var vPlanPrice = $("#vPlanPrice").val();
            var iNoofConnection = $("#iNoofConnection").val();
            var eStatus = $("#eStatus").val();
            var error = false;

            if (vPlanTitle.length == 0) {
                $("#vPlanTitle_error").show();
                error = true;
            } else {
                $("#vPlanTitle_error").hide();
            }
           
            if (vPlanPrice.length == 0) {
                $("#vPlanPrice_error").show();
                error = true;
            } else {
                $("#vPlanPrice_error").hide();
            }if(iNoofConnection.length == 0) {
                $("#iNoofConnection_error").show();
                error = true;
            } else {
                $("#iNoofConnection_error").hide();
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
