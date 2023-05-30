<?php

namespace App\Http\Controllers\admin\pageSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\pageSetting\PageSetting;
use App\Helper\GeneralHelper;
use App\Libraries\Paginator;

class PageSettingsController extends Controller
{
    public function index()
    {
        $data['count']    = PageSetting::get_count();
        return view('admin.pageSetting.listing')->with($data);
    }

    public function ajax_listing(Request $request)
    {
        $action = $request->action;

        if($action == "sort"){
            $column = $request->column;
            $order = $request->order;
        } else{
            $column = "iPageSettingId";
            $order = "DESC";
        }

        if($action == "search"){
            $vKeyword = $request->keyword;
        } else {
            $vKeyword = "";
        }

        if($action == "delete"){
            $where                 = array();
            $where['iPageSettingId']    = $request->iPageSettingId;

            PageSetting::delete_by_id($where);
        }

        if($action == "status"){

            if($request->eStatus != ""){

                $PageSetting_ID   = (explode(",",$request->pagesettingID));
                $data1['eStatus'] = $request->eStatus;
                
                foreach ($PageSetting_ID as $key => $value) {
                    $where                      = array();
                    $where['iPageSettingId']    = $value;

                    if($data1['eStatus'] == "delete"){
                        PageSetting::delete_by_id($where);
                    }else{
                        PageSetting::update_status($where, $data1);
                    }
                }
            }  
        }

        if ($action == "removeImage") {
            $data['vImage'] = $request->vImage;

            $where                     = array();
            $where['iPageSettingId']   = $request->iPageSettingId;
           
            $FaqCategory_id = new PageSetting();
            $FaqCategory_id->update($where, $data);
        }

        if ($action == "removeImage1") {
            $data['vImage2'] = $request->vImage2;

            $where                     = array();
            $where['iPageSettingId']   = $request->iPageSettingId;
           
            $FaqCategory_id = new PageSetting();
            $FaqCategory_id->update($where, $data);
        }

        $criteria = array();
        $criteria['vKeyword']   = $vKeyword;
        $criteria['column']     = $column;
        $criteria['order']      = $order;
  
        $pagesetting_data = PageSetting::get_all_data($criteria);

        $pages = 1;
        
        if($request->pages != "")
        {
            $pages = $request->pages;
        }

        $paginator = new Paginator($pages);
        $paginator->total = count($pagesetting_data);

        $start = ($paginator->currentPage - 1) * $paginator->itemsPerPage;
        $limit = $paginator->itemsPerPage;

        $paginator->is_ajax = true;
        $paging = true;
        $data['data'] = PageSetting::get_all_data($criteria, $start, $limit, $paging);

        $data['paging'] = $paginator->paginate();

        $data['pageLimit'] = $limit;
        $data['pageTotal'] = $paginator->total;

        return view('admin.pageSetting.ajax_listing')->with($data);  
    }

    public function add()
    {
        return view('admin.pageSetting.add');
    }

    public function store(Request $request)
    {
        $iPageSettingId = $request->id;

        $data['vTitle']             = $request->vTitle;
        $data['tDescription']       = $request->tDescription;
        $data['vMetaTitle']         = $request->vMetaTitle;
        $data['tMetaDescription']   = $request->tMetaDescription;
        $data['tMetaKeywords']      = $request->tMetaKeywords;
        $data['eStatus']            = $request->eStatus;
        $data['eType']              = $request->eType;
        if(!empty($iPageSettingId)){
            $where                      = array();
            $where['iPageSettingId']         = $iPageSettingId;

            $PageSetting_id = new PageSetting();
            $data['dtUpdatedDate']     = date("Y-m-d h:i:s");
            $PageSetting_id->update($where, $data); 

            return redirect()->route('admin.pageSetting.listing')->withSuccess('PageSetting updated successfully.');
        }
        else{
            $data['dtAddedDate']    = date("Y-m-d h:i:s");
            $PageSetting_id = PageSetting::add($data);

            return redirect()->route('admin.pageSetting.listing')->withSuccess('PageSetting created successfully.');
        }
    }

    public function edit($iPageSettingId)
    {
        $data['data'] = PageSetting::get_by_id($iPageSettingId);

        return view('admin.pageSetting.add')->with($data);
    }
}
