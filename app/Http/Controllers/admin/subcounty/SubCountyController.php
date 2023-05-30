<?php
namespace App\Http\Controllers\admin\subcounty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\county\County;
use App\Models\admin\region\Region;
use App\Models\admin\country\Country;
use App\Models\admin\subcounty\SubCounty;
use App\Libraries\Paginator;

class SubCountyController extends Controller
{
    public function index()
    {
        return view('admin.subcounty.listing');
    }

    public function ajax_listing(Request $request)
    {
        $action = $request->action;
        $eStatus = $vCountryName = $vRegionName = $countyName = $vSubCounty = $status_search = "";
        $column          = "iCountyId";
        $order           = "DESC";
        $status_search   = $request->status_search;
        $vTitle           = $request->vSubCounty;
        $vRegionName      = $request->vRegionName;
        $vCountryName    = $request->vCountryName;
        $countyName      = $request->vCountyName;
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
            SubCounty::update_data($where,$data);
        }
        if($action == "delete")
        {
            $where                 = array();
            $where['vUniqueCode']    = $request->vUniqueCode;
            $data['eIsDeleted'] = 'Yes';
            SubCounty::update_data($where,$data);
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
                    SubCounty::update_data($where,$data);
                }
                $eStatus = "";
            }
            else
            {
                foreach ($vUniqueCode as $key => $value) 
                {
                    $data['eStatus'] = $eStatus;
                    $where = array("vUniqueCode" => $value);
                    SubCounty::update_data($where,$data);
                }
                $eStatus = "";
            }
        }
        $criteria = array();
        $criteria['status_search']     = $status_search;
        $criteria['vTitle']              = $vTitle;
        $criteria['vCountryName']      = $vCountryName;
        $criteria['vRegionName']        = $vRegionName;
        $criteria['countyName']        = $countyName;
        $criteria['eStatus']           = $eStatus;
        $criteria['eIsDeleted']        = $eIsDeleted;
        $criteria['column']            = $column;
        $criteria['order']             = $order;
        $banner_data = SubCounty::get_all_data($criteria);
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
        $data['data'] = SubCounty::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        return view('admin.subcounty.ajax_listing')->with($data);
    }

    public function add()
    {
        $data['countries'] = Country::where(['eIsDeleted' => 'No','eStatus' => 'Active'])->get();
        return view('admin.subcounty.add')->with($data);
    }

    public function store(Request $request)
    {
        $vUniqueCode            = $request->vUniqueCode;
        $data['iCountryId']     = $request->iCountryId;
        $data['iRegionId']       = $request->iRegionId;
        $data['iCountyId']       = $request->iCountyId;
        $data['vTitle']          = $request->vTitle;
        $data['eStatus']        = $request->eStatus;
        if(!empty($vUniqueCode))
        {
            $where                      = array();
            $where['vUniqueCode']       = $vUniqueCode;
            $data['dtUpdatedDate']      = date("Y-m-d h:i:s");
            $subCounty_obj                    = new SubCounty();
            $subCounty_obj->update_data($where, $data);
            return redirect()->route('admin.subCounty.listing')->withSuccess('Sub County updated successfully.');
        }
        else
        {
            $data['vUniqueCode']    = md5(uniqid(time()));
            $data['dtAddedDate']    = date("Y-m-d h:i:s");
            $subCounty_obj          = SubCounty::add($data);
            return redirect()->route('admin.subCounty.listing')->withSuccess('Sub County created successfully.');
        }  
    }
    public function edit($vUniqueCode)
    {
        $criteria                   = array();
        $criteria["vUniqueCode"]    = $vUniqueCode;
        $data['region']             = SubCounty::get_by_id($criteria);
        $data['countries']          = Country::where(['eIsDeleted' => 'No','eStatus' => 'Active'])->get();
        if(!empty($data['region']))
        {
            return view('admin.subcounty.add')->with($data);
        }
        else
        {
            return view('admin.subcounty.add')->with($data);
        }
    }

    public function get_region_by_country(Request $request)
    {
        $data['region'] = Region::where("iCountryId",$request->country_id)
                    ->get(["vTitle","iRegionId"]);
        return response()->json($data);
    }

    public function get_county_by_region(Request $request)
    {
        $data['county'] = County::where("iRegionId",$request->region_id)
                    ->get(["vTitle","iCountyId"]);
        return response()->json($data);
    }
}
