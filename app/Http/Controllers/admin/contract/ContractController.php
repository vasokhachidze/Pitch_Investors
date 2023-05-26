<?php
namespace App\Http\Controllers\admin\contract;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\contract\Contract;
use App\Libraries\Paginator;
use App\Libraries\General;
use App\Helper\GeneralHelper;

class ContractController extends Controller
{
    public function index()
    {
        return view('admin.contract.listing');
    }

    public function ajax_listing(Request $request)
    {   
        $action = $request->action;
        $eStatus = $vPlanTitle  = $vPlanPrice = $status_search = "";
        $column          = "iContractId";
        $order           = "ASC";
        $status_search   = $request->status_search;

        $contractSenderName=$request->contractSenderName;
        $contractReceiverName=$request->contractReceiverName;
        $vContractAmount=$request->vContractAmount;
        $vCommissionAmount=$request->vCommissionAmount;
        $iContractPercentage=$request->iContractPercentage;
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
            Contract::update_data($where,$data);
        }
        if($action == "delete")
        {
            $where                 = array();
            $where['vUniqueCode']  = $request->vUniqueCode;
            $data['eIsDeleted'] = 'Yes';
            Contract::update_data($where,$data);
        }
        
        $criteria = array();
        $criteria['status_search']          = $status_search;
        $criteria['contractSenderName']     = $contractSenderName;
        $criteria['contractReceiverName']   = $contractReceiverName;
        $criteria['vContractAmount']        = $vContractAmount;
        $criteria['vCommissionAmount']      = $vCommissionAmount;
        $criteria['iContractPercentage']    = $iContractPercentage;
        $criteria['column']         = $column;
        $criteria['order']          = $order;
        $contract_data = Contract::get_all_data($criteria);
        $pages = 1;
        if($request->pages != "")
        {
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = count($contract_data);
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
        $data['data'] = Contract::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        return view('admin.contract.ajax_listing')->with($data);  
    }

    public function add()
    {
       return view('admin.contract.add');
    }
    public function edit($vUniqueCode)
    {
        $criteria                   = array();
        $criteria["vUniqueCode"]    = $vUniqueCode;
        $data['contract']              = Contract::get_by_id($criteria);
        if(!empty($data['contract']))
        {
            return view('admin.contract.add')->with($data);
        }
        else
        {
            return redirect()->route('admin.contract');
        }
    }
    public function store(Request $request)
    {
        $vUniqueCode = $request->vUniqueCode;
        $data['vUniqueCode']       = md5(uniqid(time()));
        $data['vPlanTitle']        = $request->vPlanTitle;
        $data['vPlanDetail']       = $request->vPlanDetail;
        $data['vPlanPrice']        = $request->vPlanPrice;
        $data['iNoofConnection']   = $request->iNoofConnection;
        $data['eStatus']       = $request->eStatus;
         
        if(!empty($vUniqueCode))
        {
            $where                      = array();
            $where['vUniqueCode']         = $vUniqueCode;
            $data['dtUpdatedDate'] = date("Y-m-d h:i:s");
            Contract::update_data($where, $data);
            return redirect()->route('contract.listing')->withSuccess('Contract updated successfully.');
            
        }
        else
        {
            $data['vContractCode']  = GeneralHelper::generateUniqueCodePlanContract();
            $data['vUniqueCode']    = md5(uniqid(time()));
            $data['dtAddedDate']    = date("Y-m-d h:i:s");
            $data['dtUpdatedDate']  = date("Y-m-d h:i:s");
            Contract::add($data);
            return redirect()->route('contract.listing')->withSuccess('Contract created successfully.');
        }
    }
}