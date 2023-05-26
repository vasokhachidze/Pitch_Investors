<?php
namespace App\Http\Controllers\admin\contactus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\contactus\Contactus;
use App\Libraries\Paginator;

class ContactusController extends Controller
{
    public function index()
    {
     return view('admin.contactus.listing');
    }
    public function ajax_listing(Request $request)
    {
        $action = $request->action;
        $eStatus = $vName = $vEmail = $vPhone =$tComments = $status_search = "";
        $column                 = "iContactUs";
        $order                  = "DESC";
        $status_search          = $request->status_search;
        $vName                  = $request->vName;
        $vEmail                 = $request->vEmail;
        $vPhone                 = $request->vPhone;
        $tComments              = $request->tComments;
        $eStatus                = $request->eStatus;
        $eIsDeleted             = $request->eIsDeleted;
        if(empty($eIsDeleted))
        {
            $eIsDeleted   = 'No';
        }
        if($action == "recover")
        {
            $iContactUs = $request->iContactUs;
            $data['eIsDeleted'] = 'No';
            $where = array("iContactUs" => $iContactUs);
            Contactus::update_data($where,$data);
        }
        if($action == "delete")
        {
            $where                 = array();
            $where['iContactUs']    = $request->iContactUs;
            $data['eIsDeleted'] = 'Yes';
            Contactus::update_data($where,$data);
        }
        if($action == "status")
        {
            $iContactUs = (explode(",",$request->iContactUs));
            $eStatus = $request->eStatus;
            if($eStatus == "delete")
            {
                foreach ($iContactUs as $key => $value) 
                {
                    $where                   = array();
                    $where['iContactUs']    = $value;
                    $data['eIsDeleted']      = 'Yes';
                    Contactus::update_data($where,$data);
                }
                $eStatus = "";
            }
            else
            {
                foreach ($iContactUs as $key => $value)
                {
                    $data['eStatus'] = $eStatus;
                    $where = array("iContactUs" => $value);
                    Contactus::update_data($where,$data);
                }
                $eStatus = "";
            }
        }
        $criteria = array();
        $criteria['status_search']           = $status_search;
        $criteria['vName']                   = $vName;
        $criteria['vEmail']                  = $vEmail;
        $criteria['vPhone']                  = $vPhone;
        $criteria['tComments']               = $tComments;
        $criteria['eStatus']                 = $eStatus;
        $criteria['eIsDeleted']              = $eIsDeleted;
        $criteria['column']                  = $column;
        $criteria['order']                   = $order;
        $make_data                           = Contactus::get_all_data($criteria);
        $pages = 1;
        if($request->pages != "")
        {
            $pages = $request->pages;
        }
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
        $data['data']   = Contactus::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        return view('admin.contactus.ajax_listing')->with($data);  
    }
}
