@php 
$url2   = Request::segment(2);
@endphp
<div class="row w-100">
    <div class="col-lg-3 col-md-2 col-sm-12 d-flex justify-content-start align-items-center">
        {{$name}}
    </div>    
    <div class="col-lg-3 col-md-4 col-sm-6 pt-1">
        <select name="eStatus" id="status" class="form-control show-tick mb-0">
            <option value="">Multiple Update Status</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
            <option value="delete">Delete</option>
            @if($url2 == 'business-advisor' || $url2 == 'investor' || $url2== 'investment' || $url2 == 'banner' || $url2 == 'industry')
            <option value="ShowHomePage">ShowHomePage</option>
            @endif
        </select>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-6 pt-1">
        <select name="page_limit" id ="page_limit" class="form-control show-tick mb-0">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option alue="100">100</option>
        </select>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-6 pt-1">
        <select name="eIsDeleted" id="eIsDeleted" class="form-control show-tick mb-0">
            <option value="">Deleted</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-6 pt-1">
             <a href="{{url($url)}}" class="btn all-btn">+ Add</a>
    </div>
    
</div>
