<?php
namespace App\Http\Controllers\admin\connection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\contract\Contract;
use App\Models\admin\connection\Connection;
use App\Libraries\Paginator;
use App\Libraries\General;
use App\Helper\GeneralHelper;

class ConnectionController extends Controller
{
    public function index()
    {
        return view('admin.connection.listing');
    }

    public function ajax_listing(Request $request)
    {   
        $action = $request->action;
        $eStatus = $vPlanTitle  = $vPlanPrice = $status_search = "";
        $column          = "iConnectionId";
        $order           = "ASC";
      //  $status_search   = $request->status_search;

        // $contractSenderName=$request->contractSenderName;
        // $contractReceiverName=$request->contractReceiverName;
        // $vContractAmount=$request->vContractAmount;
        // $vCommissionAmount=$request->vCommissionAmount;
        // $iContractPercentage=$request->iContractPercentage;
        // $eIsDeleted      = $request->eIsDeleted;

        // if(empty($eIsDeleted))
        // {
        //     $eIsDeleted   = 'No';
        // }
        // if($action == "recover")
        // {
        //     $vUniqueCode = $request->vUniqueCode;
        //     $data['eIsDeleted'] = 'No';
        //     $where = array("vUniqueCode" => $vUniqueCode);
        //     Contract::update_data($where,$data);
        // }
        // if($action == "delete")
        // {
        //     $where                 = array();
        //     $where['vUniqueCode']  = $request->vUniqueCode;
        //     $data['eIsDeleted'] = 'Yes';
        //     Contract::update_data($where,$data);
        // }
        
        $criteria = array();
       // $criteria['status_search']          = $status_search;
        $criteria['connectionSenderName']     = $request->connectionSenderName;
        $criteria['connectionReceiverName']   = $request->connectionReceiverName;
        $criteria['vSenderProfileTitle']        = $request->vSenderProfileTitle;
        $criteria['vReceiverProfileTitle']      = $request->vReceiverProfileTitle;
        $criteria['eReceiverProfileType']      = $request->eReceiverProfileType;
        $criteria['dtAddedDate']      = $request->dtAddedDate;
        $criteria['column']         = $column;
        $criteria['order']          = $order;
        $contract_data = Connection::get_all_data($criteria);
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
        $data['data'] = Connection::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        return view('admin.connection.ajax_listing')->with($data);  
    }

    public function ajax_week_data(Request $request)
    {   
        return Connection::get_week_data();
    }


}