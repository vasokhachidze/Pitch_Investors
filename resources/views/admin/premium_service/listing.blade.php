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
                            <p>Premium Service Listing</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><input placeholder="User Name" id="userName" type="text" name="userName" class="search form-control"></th>
                                    <th><input placeholder="Service" id="service" type="text" name="service" class="search form-control"></th>
                                    <th><input placeholder="Merchant Reference" id="merchantReference" type="text" name="merchantReference" class="search form-control"></th>
                                    <th><input placeholder="Order Id" id="orderId" type="text" name="orderId" class="search form-control"></th>
                                    <th><input placeholder="Amount" id="amount" type="text" name="amount" class="search form-control"></th>
                                    <th><input placeholder="Created At" id="createdAt" type="text" name="createdAt" class="search form-control"></th>
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
  
    $(document).ready(function() {
        $("#ajax-loader").show();
        setTimeout(function() {
            $.ajax({
                url: "{{url('admin/premium_service/ajax_listing')}}",
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
        var limit_page              = $('#page_limit').val();
        $("#table_record").hide();
        $("#ajax-loader").show();
        setTimeout(function() {
            $.ajax({
                url: "{{url('admin/premium_service/ajax_listing')}}",
                type: "POST",
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data: {
                    keyword: keyword,
                    userName: $('#userName').val(),
                    service: $('#service').val(),
                    merchantReference:  $('#merchantReference').val(),
                    orderId:$('#orderId').val(),
                    amount:$('#amount').val(),               
                    createdAt:$('#createdAt').val(),        
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
   
    // $(document).on('click', '.ajax_page', function() {
    //     var pages           = $(this).data("pages");
    //     var keyword         = $("#keyword").val();
    //      var connectionSenderName      = $('#connectionSenderName').val();
    //     var connectionReceiverName    = $('#connectionReceiverName').val();
    //     var vSenderProfileTitle         = $('#vSenderProfileTitle').val();
    //     var vReceiverProfileTitle       = $('#vReceiverProfileTitle').val();
    //     var dtAddedDate       = $('#dtAddedDate').val();
    //     var limit_page = $('#page_limit').val();
    //     $("#table_record").hide();
    //     $("#table_record").html('');
    //     $("#ajax-loader").show();
    //    setTimeout(function() {
    //         $.ajax({
    //             url: "{{url('admin/connection/ajax_listing')}}",
    //             type: "POST",
    //             headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
    //             data: {
    //                 pages: pages,
    //                 keyword: keyword,
    //                 connectionSenderName: connectionSenderName,
    //                 connectionReceiverName: connectionReceiverName,
    //                 vSenderProfileTitle:vSenderProfileTitle,
    //                 vReceiverProfileTitle:vReceiverProfileTitle, 
    //                 dtAddedDate:dtAddedDate, 
    //                 limit_page:limit_page,
    //                 action: 'search'
    //             },
    //             success: function(response) {
    //                 $("#table_record").html(response);
    //                 $("#ajax-loader").hide();
    //                 $("#table_record").show();
    //             }
    //         });
    //     }, 500);
    // });
    $(document).on('change','#page_limit',function(){
        var limit_page      = this.value;
        var eIsDeleted      = $('#eIsDeleted').val();
        var status_search      = $('#status_search').val();
        $("#table_record").html('');
        $("#ajax-loader").show();
        setTimeout(function(){
            $.ajax({
                url: "{{url('admin/premium_service/ajax_listing')}}",
                type: "POST",
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data:  {
                    limit_page: limit_page
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