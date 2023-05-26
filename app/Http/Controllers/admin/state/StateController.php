<?php
namespace App\Http\Controllers\admin\state;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\state\State;
use App\Models\admin\country\Country;
use App\Libraries\Paginator;

class StateController extends Controller
{
    public function index()
    {
     return view('admin.state.listing');
    }

    public function ajax_listing(Request $request)
    {  
        $action = $request->action;
        $eStatus = $vState  = $vCountryName = $vCountryCode = $status_search = "";
        $column          = "iStateId";
        $order           = "DESC";
        $status_search   = $request->status_search;
        $vState          = $request->vState;
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
            State::update_data($where,$data);
          
        }
        if($action == "delete")
        {
            $where                 = array();
            $where['vUniqueCode']    = $request->vUniqueCode;
            $data['eIsDeleted'] = 'Yes';
            State::update_data($where,$data);
            
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
                    State::update_data($where,$data);
                }
                $eStatus = "";
            }
            else
            {
                foreach ($vUniqueCode as $key => $value) 
                {
                    $data['eStatus'] = $eStatus;
                    $where = array("vUniqueCode" => $value);
                    State::update_data($where,$data);
                }
                $eStatus = "";
            }
        }
        $criteria = array();
        $criteria['status_search']     = $status_search;
        $criteria['vState']            = $vState;
        $criteria['vCountryName']      = $vCountryName;
        $criteria['vCountryCode']      = $vCountryCode;
        $criteria['eStatus']           = $eStatus;
        $criteria['eIsDeleted']        = $eIsDeleted;
        $criteria['column']            = $column;
        $criteria['order']             = $order;
        $banner_data = State::get_all_data($criteria);
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
        $data['data'] = State::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        return view('admin.state.ajax_listing')->with($data);
    }

    public function add()
    {
       $data['countries'] = Country::get();
       return view('admin.state.add')->with($data);
    }
    public function edit($vUniqueCode)
    {
        $criteria                   = array();
        $criteria["vUniqueCode"]    = $vUniqueCode;
        $data['state']              = State::get_by_id($criteria);
        $data['countries']          = Country::get();
        if(!empty($data['state']))
        {
            return view('admin.state.add')->with($data);
        }
        else
        {
            return redirect()->route('admin.state.listing');
        }
    }
    public function store(Request $request)
    {
        $vUniqueCode                = $request->vUniqueCode;
        $data['vState']             = $request->vState;
        $data['iCountryId']         = $request->iCountryId;
        $data['vCountryCode']       = $request->vCountryCode;
        $data['eStatus']            = $request->eStatus;
        if(!empty($vUniqueCode))
        {
            $data['dtUpdatedDate']      = date("Y-m-d h:i:s");
            $where                      = array();
            $where['vUniqueCode']       = $vUniqueCode;
            State::update_data($where, $data);
            return redirect()->route('admin.state.listing')->withSuccess('State updated successfully.');
        }
        else
        {
            $data['dtAddedDate']        = date("Y-m-d h:i:s");
            $data['vUniqueCode']        = md5(uniqid(time()));
            State::add($data);
            return redirect()->route('admin.state.listing')->withSuccess('State created successfully.');
        }
        
    }
    public function getcountrycodedata(Request $request){
        $criteria                   = array();
        $criteria["iCountryId"]    = $request->iCountryId;
        $data['countries']          = Country::get_country_code($criteria);   
        return response()->json($data);      
     }
}
