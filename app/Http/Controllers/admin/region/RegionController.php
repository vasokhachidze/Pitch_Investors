<?php

namespace App\Http\Controllers\admin\region;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\country\Country;
use App\Models\admin\region\Region;
use App\Libraries\Paginator;


class RegionController extends Controller
{
    public function index()
    {
     return view('admin.region.listing');
    }

    public function ajax_listing(Request $request)
    {
       
        $action = $request->action;
        $eStatus = $vTitle  = $vCountryName = $vCountryCode = $status_search = "";
        $column          = "iRegionId";
        $order           = "DESC";
        $status_search   = $request->status_search;
        $vTitle          = $request->vTitle;
        $vCountryName    = $request->vCountryName;
        $vCountryCode    = $request->vCountryCode;
        $eStatus         = $request->eStatus;
        $eIsDeleted      = $request->eIsDeleted;
        if(empty($eIsDeleted))
        {
            $eIsDeleted   = 'No';
        }
        if($action == "recover")
        {
            $vUniqueCode = $request->vUniqueCode;
            $data['eIsDeleted'] = 'No';
            $where = array("vUniqueCode" => $vUniqueCode);
            Region::update_data($where,$data);
          
        }
        if($action == "delete")
        {
            $where                 = array();
            $where['vUniqueCode']    = $request->vUniqueCode;
            $data['eIsDeleted'] = 'Yes';
            Region::update_data($where,$data);
            
        }
        if($action == "status")
        {
            $vUniqueCode = (explode(",",$request->vUniqueCode));
            $eStatus = $request->eStatus;
            if($eStatus == "delete")
            {
                foreach ($vUniqueCode as $key => $value) 
                {
                    $where                 = array();
                    $where['vUniqueCode']    = $value;
                    $data['eIsDeleted'] = 'Yes';
                    Region::update_data($where,$data);
                }
                $eStatus = "";
            }
            else
            {
                foreach ($vUniqueCode as $key => $value) 
                {
                    $data['eStatus'] = $eStatus;
                    $where = array("vUniqueCode" => $value);
                    Region::update_data($where,$data);
                }
                $eStatus = "";
            }
        }
        $criteria = array();
        $criteria['status_search']     = $status_search;
        $criteria['vTitle']            = $vTitle;
        $criteria['vCountryName']      = $vCountryName;
        $criteria['vCountryCode']      = $vCountryCode;
        $criteria['eStatus']           = $eStatus;
        $criteria['eIsDeleted']        = $eIsDeleted;
        $criteria['column']            = $column;
        $criteria['order']             = $order;
        $banner_data = Region::get_all_data($criteria);
        $pages = 1;
        if($request->pages != "")
        {
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = count($banner_data);
        $start = ($paginator->currentPage - 1) * $paginator->itemsPerPage;
        $limit = $paginator->itemsPerPage;
        if($request->limit_page !='')
        {
            
            $per_page = $request->limit_page;
            $paginator->itemsPerPage = $per_page;
            $paginator->range = $per_page;
            $limit =  $per_page;
        }
        $paginator->is_ajax = true;
        $paging = true;
        $data['data'] = Region::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        return view('admin.region.ajax_listing')->with($data);  
    }

    public function add()
    {
       $data['countries'] = Country::where(['eIsDeleted' => 'No','eStatus' => 'Active'])->get();
       return view('admin.region.add')->with($data);
    }
    public function edit($vUniqueCode)
    {
        $criteria                   = array();
        $criteria["vUniqueCode"]    = $vUniqueCode;
        $data['region']              = Region::get_by_id($criteria);
        $data['countries']          = Country::where(['eIsDeleted' => 'No','eStatus' => 'Active'])->get();
        if(!empty($data['region']))
        {
            return view('admin.region.add')->with($data);
        }
        else
        {
            return redirect()->route('admin.region.listing');
        }
    }
    public function store(Request $request)
    {
        $vUniqueCode                = $request->vUniqueCode;
        $data['vTitle']             = $request->vTitle;
        $data['iCountryId']         = $request->iCountryId;
        $data['eStatus']            = $request->eStatus;
        if(!empty($vUniqueCode))
        {
            $data['dtUpdatedDate']      = date("Y-m-d h:i:s");
            $where                      = array();
            $where['vUniqueCode']       = $vUniqueCode;
            Region::update_data($where, $data);
            return redirect()->route('admin.region.listing')->withSuccess('Region updated successfully.');
        }
        else
        {
            $data['dtAddedDate']        = date("Y-m-d h:i:s");
            $data['vUniqueCode']        = md5(uniqid(time()));
            Region::add($data);
            return redirect()->route('admin.region.listing')->withSuccess('Region created successfully.');
        }
        
    }
    public function getcountrycodedata(Request $request){
        $criteria                   = array();
        $criteria["iCountryId"]    = $request->iCountryId;
        $data['countries']          = Country::get_country_code($criteria);   
        return response()->json($data);   
      
     }
}