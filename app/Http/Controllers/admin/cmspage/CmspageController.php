<?php
namespace App\Http\Controllers\admin\cmspage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\cmspage\Cmspage;
use App\Libraries\Paginator;
class CmspageController extends Controller
{
    public function index()
    {
      return view('admin.cmspage.listing');
    }
    public function ajax_listing(Request $request)
    {
        $action = $request->action;
        $eStatus = $vPageName  = $tDescription = $status_search = "";
        $column          = "iCmspageId";
        $order           = "DESC";
        $status_search   = $request->status_search;
        $vPageName       = $request->vPageName;
        $tDescription    = $request->tDescription;
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
            Cmspage::update_data($where,$data);
          
        }
        if($action == "delete")
        {
            $where                 = array();
            $where['vUniqueCode']    = $request->vUniqueCode;
            $data['eIsDeleted'] = 'Yes';
            Cmspage::update_data($where,$data);
            
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
                    Cmspage::update_data($where,$data);
                }
                $eStatus = "";
            }
            else
            {
                foreach ($vUniqueCode as $key => $value)
                {
                    $data['eStatus'] = $eStatus;
                    $where = array("vUniqueCode" => $value);
                    Cmspage::update_data($where,$data);
                }
                $eStatus = "";
            }
        }
        $criteria = array();
        $criteria['status_search']     = $status_search;
        $criteria['vPageName']         = $vPageName;
        $criteria['tDescription']      = $tDescription;
        $criteria['eStatus']           = $eStatus;
        $criteria['eIsDeleted']        = $eIsDeleted;
        $criteria['column']            = $column;
        $criteria['order']             = $order;
        $banner_data = Cmspage::get_all_data($criteria);
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
        $data['data']   = Cmspage::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        return view('admin.cmspage.ajax_listing')->with($data);  
    }

    public function add()
    {
       return view('admin.cmspage.add');
    }

    public function store(Request $request){
        $vUniqueCode                = $request->vUniqueCode;
        $data['tDescription']       = $request->tDescription;
        $data['vPageName']          = $request->vPageName;
        $data['eStatus']            = $request->eStatus;        
        if(!empty($vUniqueCode)){
            $where                      = array();
            $where['vUniqueCode']       = $vUniqueCode;
            $data['dtUpdateDate']       = date("Y-m-d h:i:s");
            Cmspage::update_data($where, $data);
            return redirect()->route('admin.cmspage.listing')->withSuccess('System Email updated successfully.');
        }
        else{
            $data['vSlug']              = str_replace(' ','-',$request->vPageName);
            $data['dtAddedDate']        = date("Y-m-d h:i:s");
            $data['vUniqueCode']        = md5(uniqid(time()));
            Cmspage::add($data);
            return redirect()->route('admin.cmspage.listing')->withSuccess('System Email created successfully.');
        }
    }

    public function edit($vUniqueCode)
    {   
        $criteria                   = array();
        $criteria["vUniqueCode"]    = $vUniqueCode;
        $data['cmspage']            = Cmspage::get_by_id($criteria);
        return view('admin.cmspage.add')->with($data);
    }
}