<?php

namespace App\Http\Controllers\admin\system_email;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\system_email\SystemEmail;
use App\Libraries\Paginator;


class SystemEmailController extends Controller
{
    public function index()
    {
        return view('admin.system_email.listing');
    }

    public function ajax_listing(Request $request)
    {
        $action = $request->action;
        $eStatus = $vEmailTitle  = $vEmailCode = $status_search = "";
        $column          = "iSystemEmailId";
        $order           = "DESC";
        $status_search   = $request->status_search;
        $vEmailTitle          = $request->vEmailTitle;
        $vEmailCode    = $request->vEmailCode;
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
            SystemEmail::update_data($where,$data);
          
        }
        if($action == "delete")
        {
            $where                 = array();
            $where['vUniqueCode']    = $request->vUniqueCode;
            $data['eIsDeleted'] = 'Yes';
            SystemEmail::update_data($where,$data);
            
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
                    SystemEmail::update_data($where,$data);
                }
                $eStatus = "";
            }
            else
            {
                foreach ($vUniqueCode as $key => $value) 
                {
                    $data['eStatus'] = $eStatus;
                    $where = array("vUniqueCode" => $value);
                    SystemEmail::update_data($where,$data);
                }
                $eStatus = "";
            }
        }
        $criteria = array();
        $criteria['status_search']     = $status_search;
        $criteria['vEmailTitle']       = $vEmailTitle;
        $criteria['vEmailCode']        = $vEmailCode;
        $criteria['eStatus']           = $eStatus;
        $criteria['eIsDeleted']        = $eIsDeleted;
        $criteria['column']            = $column;
        $criteria['order']             = $order;
        $banner_data = SystemEmail::get_all_data($criteria);
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
        $data['data']   = SystemEmail::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
       

        return view('admin.system_email.ajax_listing')->with($data);  
    }

    public function add()
    {
       return view('admin.system_email.add');
    }

    public function store(Request $request){
        // dd($request);exit();
        $vUniqueCode                = $request->vUniqueCode;
        $data['vEmailSubject']      = $request->vEmailSubject;
        $data['vSandgridTemplateId']      = $request->vSandgridTemplateId;
        $data['tEmailMessage']      = $request->tEmailMessage;
        $data['tSmsMessage']        = $request->tSmsMessage;
        $data['tInternalMessage']   = $request->tInternalMessage;
        $data['vEmailCode']         = $request->vEmailCode;
        $data['vEmailTitle']        = $request->vEmailTitle;
        $data['vFromName']          = $request->vFromName;
        $data['vFromEmail']         = $request->vFromEmail;
        $data['vCcEmail']           = $request->vCcEmail;
        $data['vBccEmail']          = $request->vBccEmail;
        $data['eStatus']            = $request->eStatus;        
        if(!empty($vUniqueCode)){
            $where                      = array();
            $where['vUniqueCode']         = $vUniqueCode;
            $data['dtUpdatedDate']      = date("Y-m-d h:i:s");
            SystemEmail::update_data($where, $data);
            return redirect()->route('admin.systemEmail.listing')->withSuccess('System Email updated successfully.');
        }
        else{
            $data['dtAddedDate']        = date("Y-m-d h:i:s");
            $data['vUniqueCode']        = md5(uniqid(time()));
            SystemEmail::add($data);
            return redirect()->route('admin.systemEmail.listing')->withSuccess('System Email created successfully.');
        }
    }

    public function edit($vUniqueCode)
    {
        $criteria                   = array();
        $criteria["vUniqueCode"]    = $vUniqueCode;
        $data['systemEmail']        = SystemEmail::get_by_id($criteria);
        return view('admin.system_email.add')->with($data);
    }
}
