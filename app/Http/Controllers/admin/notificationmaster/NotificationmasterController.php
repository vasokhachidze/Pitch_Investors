<?php
namespace App\Http\Controllers\admin\notificationmaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\notificationmaster\NotificationMaster;
use App\Libraries\Paginator;

class NotificationmasterController extends Controller
{
    public function index()
    {
     return view('admin.notification_master.listing');
    }
    public function ajax_listing(Request $request)
    {
        $action = $request->action;
        $vNotificationCode = $eEmail = $eSms =$eInternalMessage = "";
        $column                 = "iNotificationMasterId";
        $order                  = "DESC";
        $vNotificationCode      = $request->vNotificationCode;
        $eEmail                 = $request->eEmail;
        $eSms                 = $request->eSms;
        $eInternalMessage              = $request->eInternalMessage;
        
        $criteria = array();
        $criteria['vNotificationCode']  = $vNotificationCode;
        $criteria['eEmail']             = $eEmail;
        $criteria['eSms']               = $eSms;
        $criteria['eInternalMessage']   = $eInternalMessage;
        $criteria['column']             = $column;
        $criteria['order']              = $order;
        $make_data = NotificationMaster::get_all_data($criteria);
        $pages = 1;
        $paginator = new Paginator($pages);
        $paginator->total = count($make_data);
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
        $data['data']   = NotificationMaster::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        // return $data;
        return view('admin.notification_master.ajax_listing')->with($data);  
    }
}
