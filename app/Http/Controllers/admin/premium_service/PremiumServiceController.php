<?php
namespace App\Http\Controllers\admin\premium_service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\premium_service\PremiumService;
use App\Libraries\Paginator;
use App\Libraries\General;
use App\Helper\GeneralHelper;

class PremiumServiceController extends Controller
{
    public function index()
    {
        return view('admin.premium_service.listing');
    }

    public function ajax_listing(Request $request)
    {   
        $action = $request->action;
        $eStatus = $vPlanTitle  = $vPlanPrice = $status_search = "";
        $column          = "id";
        $order           = "ASC";
        $criteria = array();
        $criteria['userName']     = $request->userName;
        $criteria['service']   = $request->service;
        $criteria['merchantReference']   = $request->merchantReference;
        $criteria['orderId']        = $request->orderId;
        $criteria['amount']      = $request->amount;
        $criteria['createdAt']      = $request->createdAt;
        $criteria['column']         = $column;
        $criteria['order']          = $order;
        $contract_data = PremiumService::get_all_data($criteria);
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
        $data['data'] = PremiumService::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        return view('admin.premium_service.ajax_listing')->with($data);  
    }

    public function ajax_week_data(Request $request)
    {   
        return PremiumService::get_week_data();
    }


}