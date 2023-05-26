<?php
namespace App\Http\Controllers\admin\plan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\plan\Plan;
use App\Libraries\Paginator;
use App\Libraries\General;
use App\Helper\GeneralHelper;

class PlanController extends Controller
{
    public function index()
    {
     return view('admin.plan.listing');
    }

    public function ajax_listing(Request $request)
    {
        $action = $request->action;
        $eStatus = $vPlanTitle  = $vPlanPrice = $status_search = "";
        $column          = "iPlanId";
        $order           = "ASC";
        $status_search   = $request->status_search;
        $vPlanTitle      = $request->vPlanTitle;
        $vPlanPrice      = $request->vPlanPrice;
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
            Plan::update_data($where,$data);
        }
        if($action == "delete")
        {
            $where                 = array();
            $where['vUniqueCode']  = $request->vUniqueCode;
            $data['eIsDeleted'] = 'Yes';
            Plan::update_data($where,$data);
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
                    $where['vUniqueCode']  = $value;
                    $data['eIsDeleted'] = 'Yes';
                    Plan::update_data($where,$data);
                }
                $eStatus = "";
            }
            else
            {
                foreach ($vUniqueCode as $key => $value)
                {
                    $data['eStatus'] = $eStatus;
                    $where = array("vUniqueCode" => $value);
                    Plan::update_data($where,$data);
                }
                $eStatus = "";
            }
        }
        $criteria = array();
        $criteria['status_search']  = $status_search;
        $criteria['vPlanTitle']     = $vPlanTitle;
        $criteria['vPlanPrice']     = $vPlanPrice;
        $criteria['eStatus']        = $eStatus;
        $criteria['eIsDeleted']     = $eIsDeleted;
        $criteria['column']         = $column;
        $criteria['order']          = $order;
        $Plan_data = Plan::get_all_data($criteria);
        $pages = 1;
        if($request->pages != "")
        {
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = count($Plan_data);
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
        $data['data'] = Plan::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        return view('admin.plan.ajax_listing')->with($data);
    }

    public function add()
    {
       return view('admin.plan.add');
    }
    public function edit($vUniqueCode)
    {
        $criteria                  = array();
        $criteria["vUniqueCode"]   = $vUniqueCode;
        $data['plan']              = Plan::get_by_id($criteria);
        if(!empty($data['plan']))
        {
            return view('admin.plan.add')->with($data);
        }
        else
        {
            return redirect()->route('admin.plan');
        }
    }
    public function store(Request $request)
    {
        $vUniqueCode = $request->vUniqueCode;
        // $vPlanCode = $request->vPlanCode;
        $data['vUniqueCode']       = md5(uniqid(time()));
        $data['vPlanTitle']        = $request->vPlanTitle;
        $data['vPlanDetail']       = $request->vPlanDetail;
        $data['vPlanPrice']        = $request->vPlanPrice;
        // $data['vPlanCode']         = GeneralHelper::generateUniqueCodePlanContract();
        $data['iNoofConnection']   = $request->iNoofConnection;
        $data['eStatus']       = $request->eStatus;
         
        if(!empty($vUniqueCode))
        {
            $where  = array();
            $where['vUniqueCode']   = $vUniqueCode;
            $data['dtUpdatedDate']  = date("Y-m-d h:i:s");
            /*if(empty($vPlanCode)){
                $data['vPlanCode']         = GeneralHelper::generateUniqueCodePlanContract();
            }*/
            Plan::update_data($where, $data);
            return redirect()->route('plan.listing')->withSuccess('Plan updated successfully.');
        }
        else
        {
            $data['vUniqueCode']    = md5(uniqid(time()));
            $data['dtAddedDate']    = date("Y-m-d h:i:s");
            $data['dtUpdatedDate']  = date("Y-m-d h:i:s");
            // if(empty($vPlanCode)){
             $data['vPlanCode']     = GeneralHelper::generateUniqueCodePlanContract();
            // }
            Plan::add($data);
            return redirect()->route('plan.listing')->withSuccess('Plan created successfully.');
        }
    }
}