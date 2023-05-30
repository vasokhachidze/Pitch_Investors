<?php
namespace App\Http\Controllers\admin\industry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\industry\Industry;
use App\Libraries\Paginator;
use Illuminate\Support\Facades\File;

class IndustryController extends Controller
{
    public function index()
    {
        
     return view('admin.industry.listing');
    }

    public function ajax_listing(Request $request)
    {
        $action = $request->action;
        $eStatus = $vName  = $tDescription = $status_search = "";
        // $column          = "iIndustryId";
        $column          = "eShowHomePage";
        $order           = "ASC";
        $status_search   = $request->status_search;
        $vName        = $request->vName;
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
            Industry::update_data($where,$data);
        }
        if($action == "delete")
        {
            $where = array();
            $where['vUniqueCode']    = $request->vUniqueCode;
            $data['eIsDeleted'] = 'Yes';
            Industry::update_data($where,$data);
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
                    Industry::update_data($where,$data);                   
                }
                $eStatus = 'Active';
            }
            
            if($eStatus == "delete")
            {
                foreach ($vUniqueCode as $key => $value)
                {
                    $where = array();
                    $where['vUniqueCode']    = $value;
                    $data['eIsDeleted'] = 'Yes';
                    Industry::update_data($where,$data);
                }
                $eStatus = "";
            }
            else
            {
                foreach ($vUniqueCode as $key => $value) 
                {
                    $data['eStatus'] = $eStatus;
                    $where = array("vUniqueCode" => $value);
                    Industry::update_data($where,$data);
                }
                $eStatus = "";
            }
        }
        $criteria = array();
        $criteria['status_search']     = $status_search;
        $criteria['vName']          = $vName;
        $criteria['tDescription']      = $tDescription;
        $criteria['eStatus']           = $eStatus;
        $criteria['eIsDeleted']        = $eIsDeleted;
        $criteria['column']            = $column;
        $criteria['order']             = $order;
        $banner_data = Industry::get_all_data($criteria);
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
        $data['data'] = Industry::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        return view('admin.industry.ajax_listing')->with($data);
    }

    public function add()
    {
       return view('admin.industry.add');
    }
    public function edit($vUniqueCode)
    {
        $criteria                   = array();
        $criteria["vUniqueCode"]    = $vUniqueCode;
        $data['industry']            = Industry::get_by_id($criteria);
        if(!empty($data['industry']))
        {
            return view('admin.industry.add')->with($data);
        }
        else
        {
            return redirect()->route('admin.industry.listing');
        }
    }
    public function store(Request $request)
    {
        $data = array();
        $vUniqueCode                = $request->vUniqueCode;
        $data['vName']              = $request->vName;
        $data['tDescription']       = $request->tDescription;
        $data['eStatus']            = $request->eStatus;
        $data['eShowHomePage']      = $request->eShowHomePage;
        if ($request->hasFile('vImage')) {
            $request->validate([
                'vImage' => 'required|mimes:png,jpg,jpeg|max:2048',
                'vName' => 'required',
                'tDescription' => 'required'
            ]);
            $data['vImage'] = $imageName = time().'.'.$request->vImage->extension();
            $path           = public_path('uploads/industry');
            $request->vImage->move($path, $imageName);
        }
        if(!empty($vUniqueCode))
        {
            $old_image = public_path('uploads/industry/').$request->old_vImage;
            if(File::exists($old_image) AND $request->hasFile('vImage')){
                // unlink($old_image);
            }
            $data['dtUpdatedDate']      = date("Y-m-d h:i:s");
            $where = array();
            $where['vUniqueCode']       = $vUniqueCode;
            Industry::update_data($where, $data);
            return redirect()->route('admin.industry.listing')->withSuccess('Industry updated successfully.');
        }
        else
        {
            $data['dtAddedDate']        = date("Y-m-d h:i:s");
            $data['vUniqueCode']        = md5(uniqid(time()));
            Industry::add($data);
            return redirect()->route('admin.industry.listing')->withSuccess('Industry created successfully.');
        }
    }
}