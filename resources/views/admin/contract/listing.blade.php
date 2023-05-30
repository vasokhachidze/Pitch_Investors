@extends('layouts.app.admin-app')
@section('title', 'Admin - '.env('APP_NAME'))
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools w-100">
                            <!-- used component -->
                            <p>Contract Listing</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th> 
                                        <div class="checkbox adcheck">
                                            <input id="selectall" type="checkbox" name="selectall" class="css-checkbox">
                                            <!-- <label for="selectall">&nbsp;</label> -->
                                        </div>
                                    </th>
                                    <th><input placeholder="Contract Sender Name" id="contractSenderName" type="text" name="contractSenderName" class="search form-control"></th>
                                    <th><input placeholder="Contract Created With" id="contractReceiverName" type="text" name="contractReceiverName" class="search form-control"></th>
                                    <th><input placeholder="Contract Amount" id="vContractAmount" type="text" name="vContractAmount" class="search form-control"></th>
                                    <th><input placeholder="Contract Commission Amount" id="vCommissionAmount" type="text" name="vCommissionAmount" class="search form-control"></th>
                                    <th><input placeholder="Contract Percentage" id="iContractPercentage" type="text" name="iContractPercentage" class="search form-control"></th>
                                    
                                </tr>
                            </thead>
                            <tbody id="table_record">
                            </tbody>
                            
                        </table>
                        <div class="text-center" id="ajax-loader">
                            <img src="{{asset('admin/assets/images/ajax-loader.gif')}}" width="100px" height="auto" />
                        </div>
                    </div>
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
<script>
    $(document).on('keypress','#vPhone',function(e)
    {
        var charCode = (e.which) ? e.which : event.keyCode    
        if (String.fromCharCode(charCode).match(/[^0-9]/g))    
        return false;        
    });
    $(document).ready(function() {
        $("#ajax-loader").show();
        setTimeout(function() {
            $.ajax({
                url: "{{url('admin/contract/ajax_listing')}}",
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
    $(document).on('click', '#selectall', function() {
        if (this.checked) {
            $('.checkboxall').each(function() {
                $(".checkboxall").prop('checked', true);
            });
        } else {
            $('.checkboxall').each(function() {
                $(".checkboxall").prop('checked', false);
            });
        }
    });
    $(document).on('keyup', '.search', function() {
        var keyword                 = $(this).val();
        var contractSenderName      = $('#contractSenderName').val();
        var contractReceiverName    = $('#contractReceiverName').val();
        var vContractAmount         = $('#vContractAmount').val();
        var vCommissionAmount       = $('#vCommissionAmount').val();
        var iContractPercentage     = $('#iContractPercentage').val();
        var limit_page              = $('#page_limit').val();
        $("#table_record").hide();
        $("#ajax-loader").show();
        setTimeout(function() {
            $.ajax({
                url: "{{url('admin/contract/ajax_listing')}}",
                type: "POST",
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data: {
                    keyword: keyword,
                    contractSenderName: contractSenderName,
                    contractReceiverName: contractReceiverName,
                    vContractAmount:vContractAmount,
                    vCommissionAmount:vCommissionAmount,
                    iContractPercentage:iContractPercentage,                    
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
    $(document).on('change', '#status_search', function() {
        var search_status_val = $(this).val();
         var contractSenderName      = $('#contractSenderName').val();
        var contractReceiverName    = $('#contractReceiverName').val();
        var vContractAmount         = $('#vContractAmount').val();
        var vCommissionAmount       = $('#vCommissionAmount').val();
        var iContractPercentage     = $('#iContractPercentage').val();
        var limit_page      = $('#page_limit').val();
        $("#table_record").hide();
        $("#ajax-loader").show();
        setTimeout(function() {
            $.ajax({
                url: "{{url('admin/contract/ajax_listing')}}",
                type: "POST",
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data: {
                    eStatus: search_status_val,                    
                    contractSenderName: contractSenderName,
                    contractReceiverName: contractReceiverName,
                    vContractAmount:vContractAmount,
                    vCommissionAmount:vCommissionAmount,
                    iContractPercentage:iContractPercentage,    
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
    $(document).on('change', '#eIsDeleted', function() {
        var eIsDeleted_val      = $(this).val();
         var contractSenderName      = $('#contractSenderName').val();
        var contractReceiverName    = $('#contractReceiverName').val();
        var vContractAmount         = $('#vContractAmount').val();
        var vCommissionAmount       = $('#vCommissionAmount').val();
        var iContractPercentage     = $('#iContractPercentage').val();
        var limit_page          = $('#page_limit').val();
        $("#table_record").hide();
        $("#ajax-loader").show();
        setTimeout(function() {
            $.ajax({
                url: "{{url('admin/contract/ajax_listing')}}",
                type: "POST",
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data: {
                     contractSenderName: contractSenderName,
                    contractReceiverName: contractReceiverName,
                    vContractAmount:vContractAmount,
                    vCommissionAmount:vCommissionAmount,
                    iContractPercentage:iContractPercentage,    
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
                    url: "{{url('admin/contract/ajax_listing')}}",
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
                        toastr.success('User Deleted Successfully.');
                    }
                });
            }, 1000);
        }
    });
    $(document).on('click', '.recover', function() {
        if (confirm('Are you sure recover this data?')) {
            vUniqueCode = $(this).data("id");
            $("#table_record").hide();
            $("#ajax-loader").show();
            setTimeout(function() {
                $.ajax({
                    url: "{{url('admin/contract/ajax_listing')}}",
                    type: "POST",
                    headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                    data: {
                        vUniqueCode: vUniqueCode,
                        action: 'recover'
                    },
                    success: function(response) {
                        $("#table_record").html(response);
                        $("#ajax-loader").hide();
                        $("#table_record").show();
                        $('#eIsDeleted').val('');
                        toastr.success('User Data recover Successfully.');
                        
                    }
                });
            }, 1000);
        }
    });
    $(document).on('click', '.ajax_page', function() {
        var pages           = $(this).data("pages");
        var keyword         = $("#keyword").val();
         var contractSenderName      = $('#contractSenderName').val();
        var contractReceiverName    = $('#contractReceiverName').val();
        var vContractAmount         = $('#vContractAmount').val();
        var vCommissionAmount       = $('#vCommissionAmount').val();
        var iContractPercentage     = $('#iContractPercentage').val();
        var limit_page = $('#page_limit').val();
        $("#table_record").hide();
        $("#table_record").html('');
        $("#ajax-loader").show();
       setTimeout(function() {
            $.ajax({
                url: "{{url('admin/contract/ajax_listing')}}",
                type: "POST",
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data: {
                    pages: pages,
                    keyword: keyword,
                    contractSenderName: contractSenderName,
                    contractReceiverName: contractReceiverName,
                    vContractAmount:vContractAmount,
                    vCommissionAmount:vCommissionAmount,
                    iContractPercentage:iContractPercentage,    
                    limit_page:limit_page,
                    action: 'search'
                },
                success: function(response) {
                    $("#table_record").html(response);
                    $("#ajax-loader").hide();
                    $("#table_record").show();
                }
            });
        }, 500);
    });
    $(document).on('change', '#status', function() {
        if ($("#selectall").is(':checked') == true || $("input[name = 'vUniqueCode[]']").is(':checked') == true) {
            var eStatus             = $("#status").val();
            var contractSenderName      = $('#contractSenderName').val();
            var contractReceiverName    = $('#contractReceiverName').val();
            var vContractAmount         = $('#vContractAmount').val();
            var vCommissionAmount       = $('#vCommissionAmount').val();
            var iContractPercentage     = $('#iContractPercentage').val();
            var limit_page          = $('#page_limit').val();
            var eIsDeleted          = $('#eIsDeleted').val();
            if (eStatus == "delete") {

                if (confirm('Are you sure you want to delete?')) {

                    MultipleUpdate();
                }
            }
            else if(eStatus == "recover")
            {
                if(confirm('Are you sure recover data?')) {
                MultipleUpdate();
                } 
            }
            else {

                if (confirm('Are you sure changes this status?')) {

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
                setTimeout(function() {
                    $.ajax({
                        url: "{{url('admin/contract/ajax_listing')}}",
                        type: "POST",
                        headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                        data: {
                             contractSenderName: contractSenderName,
                            contractReceiverName: contractReceiverName,
                            vContractAmount:vContractAmount,
                            vCommissionAmount:vCommissionAmount,
                            iContractPercentage:iContractPercentage,    
                            limit_page:limit_page,
                            vUniqueCode: vUniqueCode,
                            eIsDeleted:eIsDeleted,
                            eStatus: eStatus,
                            action: 'status',
                        },
                        success: function(response) {
                            $("#table_record").html(response);
                            $("#ajax-loader").hide();
                            $("#status").val('');
                            $("#selectall").prop('checked', false);
                            if(eStatus == "delete"){
                                toastr.error('User Deleted Successfully.');
                            }
                            else{
                                toastr.success('Data Update Successfully.');
                            }
                        }
                    });
                }, 500);
            }
        } else {
            alert('Please Select Data');
            exit();
        }
    });
    $(document).on('change','#page_limit',function(){
        var limit_page      = this.value;
        var eIsDeleted      = $('#eIsDeleted').val();
        var status_search      = $('#status_search').val();
        $("#table_record").html('');
        $("#ajax-loader").show();
        setTimeout(function(){
            $.ajax({
                url: "{{url('admin/contract/ajax_listing')}}",
                type: "POST",
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data:  {
                    limit_page: limit_page,
                    eIsDeleted:eIsDeleted,
                    status_search:status_search,
                }, 
                success: function(response) {
                    $("#table_record").html(response);
                    $("#ajax-loader").hide();
                }
            });
            hideLoader();
            }, 500);
    });
</script>
@endsection