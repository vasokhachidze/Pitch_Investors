<?php
namespace App\Http\Controllers\admin\banner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\banner\Banner;
use App\Libraries\Paginator;
use App\Libraries\General;

class BannerController extends Controller
{
    public function index()
    {
     return view('admin.banner.listing');
    }

    public function ajax_listing(Request $request)
    {
        $action = $request->action;
        $eStatus = $vTitle  = $status_search = "";
        $column          = "eShowHomePage";
        $order           = "ASC";
        $status_search   = $request->status_search;
        $vTitle          = $request->vTitle;
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
            Banner::update_data($where,$data);
        }
        if($action == "delete")
        {
            $where                 = array();
            $where['vUniqueCode']  = $request->vUniqueCode;
            $data['eIsDeleted'] = 'Yes';
            Banner::update_data($where,$data);
        }
        if($action == "status")
        {
            $vUniqueCode = (explode(",",$request->vUniqueCode));
            $eStatus = $request->eStatus;

            if($eStatus == "ShowHomePage")
            {
                foreach ($vUniqueCode as $key => $value) 
                {
                    $where                 = array();
                    $where['vUniqueCode']    = $value;
                    $data['eShowHomePage'] = 'Yes';                    
                    Banner::update_data($where,$data);                   
                }
                $eStatus = 'Active';
            }

            if($eStatus == "delete")
            {
                foreach ($vUniqueCode as $key => $value) 
                {
                    $where                 = array();
                    $where['vUniqueCode']  = $value;
                    $data['eIsDeleted'] = 'Yes';
                    Banner::update_data($where,$data);
                }
                $eStatus = "";
            }
            else
            {
                foreach ($vUniqueCode as $key => $value)
                {
                    $data['eStatus'] = $eStatus;
                    $where = array("vUniqueCode" => $value);
                    Banner::update_data($where,$data);
                }
                $eStatus = "";
            }
        }
        $criteria = array();
        $criteria['status_search']  = $status_search;
        $criteria['vTitle']         = $vTitle;
        $criteria['eStatus']        = $eStatus;
        $criteria['eIsDeleted']     = $eIsDeleted;
        $criteria['column']         = $column;
        $criteria['order']          = $order;
        $banner_data = Banner::get_all_data($criteria);
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
        $data['data'] = Banner::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        return view('admin.banner.ajax_listing')->with($data);  
    }

    public function add()
    {
       return view('admin.banner.add');
    }
    public function edit($vUniqueCode)
    {
        $criteria                   = array();
        $criteria["vUniqueCode"]    = $vUniqueCode;
        $data['banner']              = Banner::get_by_id($criteria);
        if(!empty($data['banner']))
        {
            return view('admin.banner.add')->with($data);
        }
        else
        {
            return redirect()->route('admin.banner');
        }
    }
    public function store(Request $request)
    {
        $vUniqueCode = $request->vUniqueCode;
        if($request->hasfile('vImage'))
        {
            $request->validate([
                'vImage' => 'required|mimes:png,jpg,jpeg|max:2048'
            ]);

            $imageName              = time().'.'.$request->vImage->getClientOriginalName();
            $path                   = public_path('uploads/banner'); 
            $request->vImage->move($path, $imageName);
            $general                = new General();
            $uploadpath             = $path.'/'.$imageName;
            $webp                   = $general->webpConvert2($uploadpath);
            $expload1               = explode('/',$webp);
            $expload                = end($expload1);
            $data['vBannerImage']         = $expload;
            // $data['OrgvImage']      = $imageName;
        }
        $data['vUniqueCode']        = md5(uniqid(time()));
        $data['vBannerTitle']        = $request->vBannerTitle;
        $data['vSubTitle']        = $request->vSubTitle;
         $data['eStatus']       = $request->eStatus;
         if(isset($request->eShowHomePage))
         {
            $data['eShowHomePage']       = $request->eShowHomePage;
         }
         
        if(!empty($vUniqueCode))
        {
            $where                      = array();
            $where['vUniqueCode']         = $vUniqueCode;
            $data['dtUpdatedDate'] = date("Y-m-d h:i:s");
            Banner::update_data($where, $data);
            return redirect()->route('banner.listing')->withSuccess('Banner updated successfully.');
            
        }
        else
        {
            $data['vUniqueCode']        = md5(uniqid(time()));
            $data['dtAddedDate']   = date("Y-m-d h:i:s");
            $data['dtUpdatedDate'] = date("Y-m-d h:i:s");
            Banner::add($data);
            return redirect()->route('banner.listing')->withSuccess('Banner created successfully.');
        }
    }
}
