@extends('layouts.app.admin-app')
@section('title', 'Category / Industry - '.env('APP_NAME'))
@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
    </div>
  </div>
</section>
<section class="content">
    <div class="container-fluid">   
        <div class="main-panel">
            <div class="col-lg-12">
                <div class="listing-page">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools w-100">
                               <!-- used component -->
                                <x-table-layout : name="Category / Industry" : url="admin/industry/add"/>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr align="center" class="text-center">
                                        <th data-orderable="false">
                                            <div class="checkbox adcheck">
                                                <input id="selectall" type="checkbox" name="selectall" class="css-checkbox">
                                                <!-- <label for="selectall">&nbsp;</label> -->
                                            </div>
                                        </th>
                                        <th scope="col">Image</th>
                                        <th><input placeholder="Search Industry Name" id="vName" type="text" name="vName" class="search form-control"></th>
                                        <th><select class="form-control" name="Status" id="status_search"><option value="">Status</option><option value="Active">Active</option><option value="Inactive">Inactive</option></select></th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table_record">   
                                </tbody>
                            </table>
                            <div class="text-center" id="ajax-loader">
                                <img src="{{asset('admin/assets/images/ajax-loader.gif')}}" width="100px" height="auto"/>
                            </div>
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
    $(document).ready(function(){
        $("#ajax-loader").show();
        setTimeout(function() {
            $.ajax({
                url: "{{url('admin/industry/ajax_listing')}}",
                type: "POST",
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data: "",
                success: function(response) {
                    $("#table_record").html(response);
                    $("#ajax-loader").hide();
                }
            });
        }, 1000);
    });

    // Select all
    $(document).on('click', '#selectall', function(){
        if(this.checked) {
            $('.checkboxall').each(function()
            {
                $(".checkboxall").prop('checked', true);
            });
        }
        else {
            $('.checkboxall').each(function(){
                $(".checkboxall").prop('checked', false);
            });
        }
    });

    // Search
    $(document).on('keyup', '.search', function() {
        var vName           = $('#vName').val();
        var eIsDeleted      = $('#eIsDeleted').val();
        var limit_page      = $('#page_limit').val();
        $("#table_record").hide();
        $("#ajax-loader").show();
        setTimeout(function() {
            $.ajax({
                url: "{{url('admin/industry/ajax_listing')}}",
                type: "POST",
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data: {
                    vName: vName,
                    eIsDeleted:eIsDeleted,
                    limit_page:limit_page,
                    action: 'search'
                },
                success: function(response) {
                    $("#table_record").html(response);
                    $("#ajax-loader").hide();
                    $("#table_record").show();
                }
            });
        }, 1000);
    });

    // Search by status
    $(document).on('change', '#status_search', function() {
        var vName = $('#vName').val();
        var eStatus = $('#status_search').val();
        console.log(eStatus)
        var eIsDeleted = $('#eIsDeleted').val();
        var limit_page = $('#page_limit').val();
        $("#table_record").hide();
        $("#ajax-loader").show();
        setTimeout(function() {
            $.ajax({
                url: "{{url('admin/industry/ajax_listing')}}",
                type: "POST",
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data: {
                    vName: vName,
                    eStatus: eStatus,
                    eIsDeleted : eIsDeleted,
                    limit_page:limit_page,
                    action: 'search_status'
                },
                success: function(response) {
                    $("#table_record").html(response);
                    $("#ajax-loader").hide();
                    $("#table_record").show();
                }
            });
        }, 1000);
    }); 

    // Search by isDeleted

    $(document).on('change', '#eIsDeleted', function() {
        var eIsDeleted_val      = $(this).val();
        var vName               = $('#vName').val();
        var vEmail              = $('#vEmail').val();
        var limit_page          = $('#page_limit').val();
        $("#table_record").hide();
        $("#ajax-loader").show();
        setTimeout(function() {
            $.ajax({
                url: "{{url('admin/industry/ajax_listing')}}",
                type: "POST",
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data: {
                    vName: vName,
                    vEmail: vEmail,
                    limit_page:limit_page,
                    eIsDeleted: eIsDeleted_val,
                    action: 'deleted_data'
                },
                success: function(response) {
                    $("#table_record").html(response);
                    $("#ajax-loader").hide();
                    $("#table_record").show();
                }
            });
        }, 1000);
    });

    $(document).on('click', '.delete', function() {
        if (confirm('Are you sure delete this data?')) {
            vUniqueCode = $(this).data("id");
            $("#table_record").hide();
            $("#ajax-loader").show();
            setTimeout(function() {
                $.ajax({
                    url: "{{url('admin/industry/ajax_listing')}}",
                    type: "POST",
                    headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                    data: {
                        vUniqueCode: vUniqueCode,
                        action: 'delete'
                    },
                    success: function(response) {
                        $("#table_record").html(response);
                        $("#ajax-loader").hide();
                        $("#table_record").show();
                        toastr.success('Category / Industry Deleted Successfully.');
                    }
                });
            }, 1000);
        }
    });

    $(document).on('click', '.ajax_page', function() {
        var pages           = $(this).data("pages");
        var vName           = $('#vName').val();
        var vEmail          = $('#vEmail').val();
        var eIsDeleted      = $('#eIsDeleted').val();
        var limit_page = $('#page_limit').val();
        $("#ajax-loader").show();
        $("#table_record").html('');
        setTimeout(function() {
            $.ajax({
                url: "{{url('admin/industry/ajax_listing')}}",
                type: "POST",
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data: {
                    pages: pages,
                    vName:vName,
                    vEmail:vEmail,
                    eIsDeleted:eIsDeleted,
                    limit_page:limit_page,
                    action: 'search'
                },
                success: function(response) {
                    $("#table_record").html(response);
                    $("#ajax-loader").hide();
                }
            });
        }, 500);
    });
    $(document).on('change','#page_limit',function(){
        var limit_page      = this.value;
        var eIsDeleted      = $('#eIsDeleted').val();
        $("#table_record").html('');
        $("#ajax-loader").show();
        setTimeout(function(){
            $.ajax({
                url: "{{url('admin/industry/ajax_listing')}}",
                type: "POST",
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data:  {
                    limit_page: limit_page,
                    eIsDeleted:eIsDeleted
                },
                success: function(response) {
                    $("#table_record").html(response);
                    $("#ajax-loader").hide();
                }
            });
            hideLoader();
            }, 500);
    });

    $(document).on('change','#status',function(){
        if($("#selectall").is(':checked') == true || $("input[name='vUniqueCode[]']:checked").is(':checked') == true)
        {
            var eStatus = $("#status").val();
            if(eStatus == "delete"){
                if(confirm("Are you sure you want to delete?")){
                    MultipleUpdate();
                }
            }else{
               if(confirm("Are you sure you want to change status?")){
                    MultipleUpdate();
                } 
            }
            function MultipleUpdate() {
                vUniqueCode = [];
                $("input[name='vUniqueCode[]']:checked").each(function() {
                    vUniqueCode.push($(this).val());
                });
                var vUniqueCode = vUniqueCode.join(",");
                $("#table_record").html('');
                $("#ajax-loader").show();
                setTimeout(function(){
                    $.ajax({
                        url: "{{url('admin/industry/ajax_listing')}}",
                        type: "POST",
                        headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                        data:  {
                            vUniqueCode: vUniqueCode,
                            action: 'status',
                            eStatus: eStatus
                        }, 
                        success: function(response) {
                            $("#table_record").html(response);
                            $("#ajax-loader").hide();
                            $("#status").val('');
                            $("#selectall").prop('checked', false);
                            if(eStatus == "delete"){
                                toastr.error('Category / Industry Deleted Successfully.');
                            }
                            else{
                                toastr.success('Data Update Successfully.');
                            }
                        }
                    });
                }, 1000);
            }
        }else{
           alert('Please select records.') 
        }
    });
</script>
@endsection