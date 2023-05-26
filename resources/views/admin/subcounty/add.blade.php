@extends('layouts.app.admin-app')
@section('title', 'Country - ' . env('APP_NAME'))
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ isset($region) ? 'Edit' : 'Add' }} Sub County</h1>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <form action="{{ url('admin/subCounty/store') }}" name="frm" id="frm" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" id="vUniqueCode" name="vUniqueCode" value="@if (isset($region)) {{ $region->vUniqueCode }} @endif">
                                    <input type="hidden" id="selected_region_id" value="@if (isset($region)) {{ $region->iRegionId }} @endif">
                                    <input type="hidden" id="selected_county_id" value="@if (isset($region)) {{ $region->iCountyId }} @endif">

                                    <div class="row">

                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Select Country</label>
                                            <select id="country_id" name="iCountryId" class="form-control">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $value)
                                                    <option value="{{ $value->iCountryId }}" @if (isset($region)) @if ($region->iCountryId == $value->iCountryId) selected @endif @endif>{{ $value->vCountry }}</option>
                                                @endforeach
                                            </select>
                                            <div id="iCountryId_error" class="error mt-1" style="color:red;display: none;">Please Select Country name</div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Select Region</label>
                                                <select id="iRegionId" name="iRegionId" class="form-control">
                                                    <option value="">Select Region</option>
                                                </select>
                                                <div id="region_id_error" class="error mt-1" style="color:red;display: none;">Please Select Region name
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Select County</label>
                                                <select id="iCountyId" name="iCountyId" class="form-control">
                                                    <option value="">Select County</option>
                                                </select>
                                                <div id="county_id_error" class="error mt-1" style="color:red;display: none;">Please Select County name
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Sub County Name</label>
                                            <input type="text" name="vTitle" id="vTitle" class="form-control" placeholder="Enter Sub County Name" value="@if (isset($region)) {{ $region->vTitle }} @endif">
                                            <div id="vTitle_error" class="error mt-1" style="color:red;display: none;">Please Enter Sub County Name
                                            </div>
                                        </div>
                                        <div class="form-group col-xl-6 col-lg-12 col-md-6">
                                            <label>Status</label>
                                            <select name="eStatus" id="eStatus" class="form-control">
                                                <option value="">Select Status</option>
                                                <option value="Active" @if (isset($region)) @if ($region->eStatus == 'Active') selected @endif @endif>Active</option>
                                                <option value="Inactive" @if (isset($region)) @if ($region->eStatus == 'Inactive') selected @endif @endif>Inactive</option>
                                            </select>
                                            <div id="eStatus_error" class="error mt-1" style="color:red;display: none;">Please Select Status </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer col-12 align-self-end d-inline-block mt-0">
                                    <a href="javascript:;" class="btn btn-primary submit">Submit</a>
                                    <a href="javascript:;" class="btn btn-primary loading" style="display: none;">
                                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>Loading...
                                    </a>
                                    <a href="{{ url('admin/subCounty/listing') }}" class="btn-info btn">Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    @endsection

    @section('custom-css')
        <style></style>
    @endsection

    @section('custom-js')

        <script type="text/javascript">
            $(document).on('click', '.submit', function() {
                var iCountid = $("#iCountyId").val();
                var iRegionId = $("#iRegionId").val();
                var iCountryId = $("#country_id").val();
                var vTitle = $("#vTitle").val();
                var eStatus = $("#eStatus").val();
                var error = false;

                if (iCountryId.length == 0) {
                    error = true;
                    $("#iCountryId_error").show();
                } else {
                    $("#iCountryId_error").hide();
                }
                if (iRegionId.length == 0) {
                    error = true;
                    $("#region_id_error").show();
                } else {
                    $("#region_id_error").hide();
                }
                if (iCountid.length == 0) {
                    error = true;
                    $("#county_id_error").show();
                } else {
                    $("#county_id_error").hide();
                }
                if (vTitle.length == 0) {
                    error = true;
                    $("#vTitle_error").show();
                } else {
                    $("#vTitle_error").hide();
                }

                if (eStatus.length == '') {
                    $("#eStatus_error").show();
                    error = true;
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

            $(document).ready(function() {
                var country_id = $("#country_id").val();
                var selected_region_id = $("#selected_region_id").val();
                var selected_county_id = $("#selected_county_id").val();

                if (country_id != '') {
                    $("#iRegionId").html('');
                    $.ajax({
                        url: "{{ url('admin/subCounty/get_region_by_country') }}",
                        type: "POST",
                        data: {
                            country_id: country_id,
                            _token: '{{ csrf_token() }}'
                        },

                        dataType: 'json',
                        success: function(result) {
                            $('#iRegionId').html('<option value="">Select Region</option>');
                            $.each(result.region, function(key, value) {
                                console.log(value.iRegionId);
                                if (selected_region_id == value.iRegionId) {
                                    $('select[name="iRegionId"]').append('<option selected value="' + value.iRegionId + '">' + value.vTitle + '</option>');
                                    selected_region_id = value.iRegionId;
                                } else {
                                    $("#iRegionId").append('<option value="' + value.iRegionId + '">' + value.vTitle + '</option>');
                                }
                            });
                        }
                    });
                    $("#iCountyId").html('');
                    $.ajax({
                        url: "{{ url('admin/subCounty/get_county_by_region') }}",
                        type: "POST",
                        data: {
                            region_id: selected_region_id,
                            _token: '{{ csrf_token() }}'
                        },

                        dataType: 'json',
                        success: function(result) {
                            console.log(result);
                            $('#iCountyId').html('<option value="">Select County</option>');
                            $.each(result.county, function(key, value) {

                                if (selected_county_id == value.iCountyId) {
                                    $('select[name="iCountyId"]').append('<option selected value="' + value.iCountyId + '">' + value.vTitle + '</option>');
                                } else {
                                    $("#iCountyId").append('<option value="' + value.iCountyId + '">' + value.vTitle + '</option>');
                                }
                            });
                        }
                    });
                }
            });
            $(document).on('change', '#country_id', function() {
                var country_id = $("#country_id").val();
                if (country_id != '') {
                    $("#iRegionId").html('');
                    $.ajax({
                        url: "{{ url('admin/subCounty/get_region_by_country') }}",
                        type: "POST",
                        data: {
                            country_id: country_id,
                            _token: '{{ csrf_token() }}'
                        },

                        dataType: 'json',
                        success: function(result) {
                            // console.log(result);
                            $('#iRegionId').html('<option value="">Select Region</option>');
                            $.each(result.region, function(key, value) {
                                $("#iRegionId").append('<option value="' + value.iRegionId + '">' + value.vTitle + '</option>');
                            });
                        }
                    });
                }
            });

            $(document).on('change', '#iRegionId', function() {
                var iRegionId = $("#iRegionId").val();
                if (iRegionId != '') {
                    $("#iCountyId").html('');
                    $.ajax({
                        url: "{{ url('admin/subCounty/get_county_by_region') }}",
                        type: "POST",
                        data: {
                            region_id: iRegionId,
                            _token: '{{ csrf_token() }}'
                        },

                        dataType: 'json',
                        success: function(result) {
                            // console.log(result);
                            $('#iCountyId').html('<option value="">Select County</option>');
                            $.each(result.county, function(key, value) {
                                $("#iCountyId").append('<option value="' + value.iCountyId + '">' + value.vTitle + '</option>');
                            });
                        }
                    });
                }
            });
        </script>
    @endsection
