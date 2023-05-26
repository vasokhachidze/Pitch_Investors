@extends('layouts.app.admin-app')
@section('title', 'Contact us - '.env('APP_NAME'))
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
                        <div class="row w-100">
                           <div class="col-lg-4 col-md-3 col-sm-12 col-12 pt-1 d-flex align-items-center">
                             Contact Us
                           </div>
                           <div class="col-lg-4 col-md-3 col-sm-4 col-12 pt-1">
                              <select name="eStatus" id="status" class="form-control show-tick mb-0">
                                 <option value="">Multiple Update Status</option>
                                     <option value="delete">Delete</option>
                              </select>
                           </div>
                           <div class="col-lg-2 col-md-3 col-sm-4 col-12 pt-1">
                              <select name="page_limit" id ="page_limit" class="form-control show-tick mb-0">
                                 <option value="10">10</option>
                                 <option value="20">20</option>
                                 <option value="50">50</option>
                                 <option alue="100">100</option>
                              </select>
                           </div>
                           <div class="col-lg-2 col-md-3 col-sm-4 col-12 pt-1">
                              <select name="eIsDeleted" id="eIsDeleted" class="form-control show-tick mb-0">
                                 <option value="">Deleted</option>
                                 <option value="Yes">Yes</option>
                                 <option value="No">No</option>
                              </select>
                           </div>
                          
                        </div>
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
                              <th><input placeholder="Name" id="vName" type="text" name="vName" class="search form-control"></th>
                              <th><input placeholder="Email" id="vEmail" type="text" name="vEmail" class="search form-control"></th>
                              <!-- <th><input placeholder="Mobile Number" id="vPhone" type="text" name="vPhone" class="search form-control"></th> -->
                              <th><input placeholder="Comments" id="tComments" type="text" name="tComments" class="search form-control"></th>
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
@section('custom-css')
<style></style>
@endsection
@section('custom-js')
<script>
   $(document).ready(function(){
       $("#ajax-loader").show();
       setTimeout(function() {
           $.ajax({
               url: "{{url('admin/contactus/ajax_listing')}}",
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
   $(document).on('click', '#selectall', function(){
       if(this.checked)
       {
           $('.checkboxall').each(function()
           {
               $(".checkboxall").prop('checked', true);
           });
       }
       else
       {
           $('.checkboxall').each(function(){
               $(".checkboxall").prop('checked', false);
           });
       }
   });
   $(document).on('keyup', '.search', function() {
       var keyword         = $(this).val();
       var vEmail          = $('#vEmail').val();
       var vName          = $('#vName').val();
       // var vPhone          = $('#vPhone').val();
       var tComments          = $('#tComments').val();
       var status_search   = $('#status_search').val();
       var eIsDeleted      = $('#eIsDeleted').val();
       var limit_page      = $('#page_limit').val();
       $("#table_record").hide();
       $("#ajax-loader").show();
       setTimeout(function() {
           $.ajax({
               url: "{{url('admin/contactus/ajax_listing')}}",
               type: "POST",
               headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
               data: {
                   keyword: keyword,
                   vEmail: vEmail,
                   vName: vName,
                   // vPhone:vPhone,
                   tComments:tComments,
                   status_search:status_search,
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
   $(document).on('change', '#status_search', function() {
       var search_status_val = $(this).val();
       var vEmail   = $('#vEmail').val();
       var vName   = $('#vName').val();
       // var vPhone          = $('#vPhone').val();
       var tComments          = $('#tComments').val();
       var eIsDeleted = $('#eIsDeleted').val();
       var limit_page = $('#page_limit').val();
       $("#table_record").hide();
       $("#ajax-loader").show();
       setTimeout(function() {
           $.ajax({
               url: "{{url('admin/contactus/ajax_listing')}}",
               type: "POST",
               headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
               data: {
                   eStatus: search_status_val,
                   vEmail: vEmail,
                   vName:vName,
                   // vPhone:vPhone,
                   tComments:tComments,
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
   $(document).on('change', '#eIsDeleted', function() {
       var eIsDeleted_val = $(this).val();
       var vEmail   = $('#vEmail').val();
       var vName   = $('#vName').val();
       // var vPhone          = $('#vPhone').val();
       var tComments          = $('#tComments').val();
       var limit_page = $('#page_limit').val();
       var eStatus             = $("#status_search").val();
       $("#table_record").hide();
       $("#ajax-loader").show();
       setTimeout(function() {
           $.ajax({
               url: "{{url('admin/contactus/ajax_listing')}}",
               type: "POST",
               headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
               data: {
                   vEmail:vEmail,
                   vName:vName,
                   // vPhone:vPhone,
                   tComments:tComments,
                   limit_page:limit_page,
                   eStatus:eStatus,
                   eIsDeleted: eIsDeleted_val,
                   action: 'deleted_data'
               },
               success: function(response) {
                   $("#table_record").html(response);
                   $("#ajax-loader").hide();
                   $("#table_record").show();
                   // $('#eIsDeleted').val('');
                   
               }
           });
       }, 1000);
   });
   $(document).on('click','.delete',function(){
       if (confirm('Are you sure delete this data?')) {
            iContactUs = $(this).data("id");
           $("#table_record").hide();
           $("#ajax-loader").show();
           setTimeout(function(){
               $.ajax({
                   url: "{{url('admin/contactus/ajax_listing')}}",
                   type: "POST",
                   headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                   data:  {iContactUs:iContactUs,action:'delete'}, 
                   success: function(response) {
                       $("#table_record").html(response);
                       $("#table_record").show();
                       $("#ajax-loader").hide();
                       toastr.success('Contact us Deleted Successfully.');
                   }
               });
           }, 1000);
       }
   });
   $(document).on('change','#status',function(){
       if($("#selectall").is(':checked') == true || $("input[name='iContactUs[]']:checked").is(':checked') == true)
       {
           var eStatus     = $("#status").val();
           var vEmail      = $('#vEmail').val();
           var vName      = $('#vName').val();
           // var vPhone          = $('#vPhone').val();
           var tComments          = $('#tComments').val();
           var eIsDeleted  = $('#eIsDeleted').val();
           var limit_page  = $('#page_limit').val();
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
               iContactUs = [];
               $("input[name='iContactUs[]']:checked").each(function() {
                   iContactUs.push($(this).val());
               });
               var iContactUs = iContactUs.join(",");
               $("#table_record").html('');
               $("#ajax-loader").show();
               setTimeout(function(){
                   $.ajax({
                       url: "{{url('admin/contactus/ajax_listing')}}",
                       type: "POST",
                       headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                       data:  {
                           vEmail:vEmail,
                           vName:vName,
                           // vPhone:vPhone,
                           tComments:tComments,                            
                           eIsDeleted:eIsDeleted,
                           limit_page:limit_page,
                           iContactUs: iContactUs,
                           action: 'status',
                           eStatus: eStatus
                       }, 
                       success: function(response) {
                           $("#table_record").html(response);
                           $("#ajax-loader").hide();
                           $("#table_record").show();
                           $("#status").val('');
                           $("#selectall").prop('checked', false);
                           if(eStatus == "delete"){
                               toastr.error('Contact Us Deleted Successfully.');
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
   $(document).on('change','#page_limit',function(){
       var limit_page      = this.value;
       var eIsDeleted      = $('#eIsDeleted').val();
       var status_search      = $('#status_search').val();
       $("#table_record").html('');
       $("#ajax-loader").show();
       setTimeout(function(){
           $.ajax({
               url: "{{url('admin/contactus/ajax_listing')}}",
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
   $(document).on('click','.ajax_page',function(){
       var pages           = $(this).data("pages");
       var vEmail          = $('#vEmail').val();
       var vName           = $('#vName').val();
       // var vPhone          = $('#vPhone').val();
       var tComments       = $('#tComments').val();
       var eIsDeleted = $('#eIsDeleted').val();
       var status_search = $('#status_search').val();
       var limit_page = $('#page_limit').val();
       $("#ajax-loader").show();
       $("#table_record").html('');
       url = "{{url('admin/contactus/ajax_listing')}}";
       setTimeout(function(){
           $.ajax({
                url: url,
                type: "POST",
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data:  {
                    pages: pages,
                    vEmail:vEmail,
                    vName:vName,
                    // vPhone:vPhone,
                    tComments:tComments,
                    eIsDeleted:eIsDeleted,
                    status_search:status_search,
                    limit_page:limit_page,
                    action:'search'
                }, 
                success: function(response) {
                   console.log(response);
                   $("#table_record").html(response);
                   $("#ajax-loader").hide();
                }
           });
       }, 500);
   });
   $(document).on('click', '.recover', function() {
       if (confirm('Are you sure recover this data?')) {
            iContactUs = $(this).data("id");
           $("#table_record").hide();
           $("#ajax-loader").show();
           setTimeout(function() {
               $.ajax({
                   url: "{{url('admin/contactus/ajax_listing')}}",
                   type: "POST",
                   headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                   data: {
                       iContactUs: iContactUs,
                       action: 'recover'
                   },
                   success: function(response) {
                       $("#table_record").html(response);
                       $("#ajax-loader").hide();
                       $("#table_record").show();
                       $('#eIsDeleted').val('');
                       toastr.success('contact us Data recover Successfully.');
                   }
               });
           }, 1000);
       }
   });
</script>
@endsection