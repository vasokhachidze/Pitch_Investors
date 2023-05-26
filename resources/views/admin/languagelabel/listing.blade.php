@extends('layouts.app.admin-app')
@section('title', 'Language Label - '.env('APP_NAME'))
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
                           <div class="col-lg-2 col-md-12 d-flex align-items-center">
                             Language Label
                           </div>
                           <div class="col-lg-2 col-md-3 col-sm-4 col-12 pt-1">
                              <select name="eStatus" id="status" class="form-control show-tick mb-0">
                                 <option value="">Multiple Update Status</option>
                                 <option value="Active">Active</option>
                                 <option value="Inactive">Inactive</option>
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
                           <div class="col-lg-2 col-md-2 col-sm-4 col-12 pt-1">
                              <select name="eIsDeleted" id="eIsDeleted" class="form-control show-tick mb-0">
                                 <option value="">Deleted</option>
                                 <option value="Yes">Yes</option>
                                 <option value="No">No</option>
                              </select>
                           </div>
                           <div class="col-md-2 col-sm-6 col-12 pt-1">
                              <a href="{{url('admin/languagelabel/add')}}" class="btn all-btn">+ Add</a>
                           </div>
                           <div class="col-md-2 col-sm-6 col-12 pt-1">
                              <a href="{{url('admin/languagelabel/generate')}}" class="btn all-btn">Generate</a>
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
                              <th><input placeholder="Language Label" id="vLabel" type="text" name="vLabel" class="search form-control"></th>
                              <th><input placeholder="Language Title" id="vTitle" type="text" name="vTitle" class="search form-control"></th>
                              <th>
                                 <select class="form-control" name="Status" id="status_search">
                                    <option value="">Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                 </select>
                              </th>
                              <th scope="col">Action</th>
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
               url: "{{url('admin/languagelabel/ajax_listing')}}",
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
       var vTitle          = $('#vTitle').val();
       var vLabel          = $('#vLabel').val();
       var status_search   = $('#status_search').val();
       var eIsDeleted      = $('#eIsDeleted').val();
       var limit_page      = $('#page_limit').val();
       $("#table_record").hide();
       $("#ajax-loader").show();
       setTimeout(function() {
           $.ajax({
               url: "{{url('admin/languagelabel/ajax_listing')}}",
               type: "POST",
               headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
               data: {
                   keyword: keyword,
                   vTitle: vTitle,
                   vLabel: vLabel,
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
       var vTitle   = $('#vTitle').val();
       var vLabel   = $('#vLabel').val();
       var eIsDeleted = $('#eIsDeleted').val();
       var limit_page = $('#page_limit').val();
       $("#table_record").hide();
       $("#ajax-loader").show();
       setTimeout(function() {
           $.ajax({
               url: "{{url('admin/languagelabel/ajax_listing')}}",
               type: "POST",
               headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
               data: {
                   eStatus: search_status_val,
                   vTitle: vTitle,
                   vLabel:vLabel,
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
       var vTitle   = $('#vTitle').val();
       var vLabel   = $('#vLabel').val();
       var limit_page = $('#page_limit').val();
       var eStatus             = $("#status_search").val();
       $("#table_record").hide();
       $("#ajax-loader").show();
       setTimeout(function() {
           $.ajax({
               url: "{{url('admin/languagelabel/ajax_listing')}}",
               type: "POST",
               headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
               data: {
                   vTitle:vTitle,
                   vLabel:vLabel,
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
           vUniqueCode = $(this).data("id");
           $("#table_record").hide();
           $("#ajax-loader").show();
           setTimeout(function(){
               $.ajax({
                   url: "{{url('admin/languagelabel/ajax_listing')}}",
                   type: "POST",
                   headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                   data:  {vUniqueCode:vUniqueCode,action:'delete'}, 
                   success: function(response) {
                       $("#table_record").html(response);
                       $("#table_record").show();
                       $("#ajax-loader").hide();
                       toastr.success('Language Label Deleted Successfully.');
                   }
               });
           }, 1000);
       }
   });
   $(document).on('change','#status',function(){
       if($("#selectall").is(':checked') == true || $("input[name='vUniqueCode[]']:checked").is(':checked') == true)
       {
           var eStatus     = $("#status").val();
           var vTitle      = $('#vTitle').val();
           var vLabel      = $('#vLabel').val();
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
               vUniqueCode = [];
               $("input[name='vUniqueCode[]']:checked").each(function() {
                   vUniqueCode.push($(this).val());
               });
               var vUniqueCode = vUniqueCode.join(",");
               $("#table_record").html('');
               $("#ajax-loader").show();
               setTimeout(function(){
                   $.ajax({
                       url: "{{url('admin/languagelabel/ajax_listing')}}",
                       type: "POST",
                       headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                       data:  {
                           vTitle:vTitle,
                           vLabel:vLabel,                            eIsDeleted:eIsDeleted,
                           limit_page:limit_page,
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
                               toastr.error('Language Label Deleted Successfully.');
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
               url: "{{url('admin/languagelabel/ajax_listing')}}",
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
       var pages = $(this).data("pages");
       var vTitle   = $('#vTitle').val();
       var vLabel   = $('#vLabel').val();
       var eIsDeleted = $('#eIsDeleted').val();
       var status_search = $('#status_search').val();
       var limit_page = $('#page_limit').val();
       $("#ajax-loader").show();
       $("#table_record").html('');
       url = "{{url('admin/languagelabel/ajax_listing')}}";
       setTimeout(function(){
           $.ajax({
               url: url,
               type: "POST",
               headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
               data:  {
                   pages: pages,
                   vTitle:vTitle,
                   vLabel:vLabel,
                   eIsDeleted:eIsDeleted,
                   status_search:status_search,
                   limit_page:limit_page,
                   action:'search'}, 
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
           vUniqueCode = $(this).data("id");
           $("#table_record").hide();
           $("#ajax-loader").show();
           setTimeout(function() {
               $.ajax({
                   url: "{{url('admin/languagelabel/ajax_listing')}}",
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
                       toastr.success('languagelabel Data recover Successfully.');
                       
                   }
               });
           }, 1000);
       }
   });
</script>
@endsection