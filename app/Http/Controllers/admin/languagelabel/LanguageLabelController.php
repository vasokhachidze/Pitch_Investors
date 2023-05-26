<?php
namespace App\Http\Controllers\admin\languagelabel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\languagelabel\LanguageLabel;
use App\Libraries\Paginator;
use File;

class LanguageLabelController extends Controller
{
    public function index()
    {
       return view('admin.languagelabel.listing');
    }
    public function ajax_listing(Request $request)
    {
        $action = $request->action;
        $eStatus = $vTitle = $vLabel = $status_search = "";
        $column          = "iLanguageLabel";
        $order           = "DESC";
        $status_search   = $request->status_search;
        $vTitle          = $request->vTitle;
        $vLabel          = $request->vLabel;
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
            LanguageLabel::update_data($where,$data);
        }
        if($action == "delete")
        {
            $where                 = array();
            $where['vUniqueCode']    = $request->vUniqueCode;
            $data['eIsDeleted'] = 'Yes';
            LanguageLabel::update_data($where,$data);
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
                    LanguageLabel::update_data($where,$data);
                }
                $eStatus = "";
            }
            else
            {
                foreach ($vUniqueCode as $key => $value)
                {
                    $data['eStatus'] = $eStatus;
                    $where = array("vUniqueCode" => $value);
                    LanguageLabel::update_data($where,$data);
                }
                $eStatus = "";
            }
        }
        $criteria = array();
        $criteria['status_search']  = $status_search;
        $criteria['vTitle']         = $vTitle;
        $criteria['vLabel']         = $vLabel;
        $criteria['eStatus']        = $eStatus;
        $criteria['eIsDeleted']     = $eIsDeleted;
        $criteria['column']         = $column;
        $criteria['order']          = $order;
        $languagelabel              = LanguageLabel::get_all_data($criteria);
        $pages = 1;
        if($request->pages != "")
        {
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = count($languagelabel);
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
        $data['data'] = LanguageLabel::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        return view('admin.languagelabel.ajax_listing')->with($data);  
    }

    public function add()
    {
       return view('admin.languagelabel.add');
    }
    public function edit($vUniqueCode)
    {
        $criteria                   = array();
        $criteria["vUniqueCode"]    = $vUniqueCode;
        $data['languagelabel']               = LanguageLabel::get_by_id($criteria);
        if(!empty($data['languagelabel']))
        {
            return view('admin.languagelabel.add')->with($data);
        }
        else
        {
            return redirect()->route('admin.languagelabel.listing');
        }
    }
    public function store(Request $request)
    {
        $vUniqueCode = $request->vUniqueCode;
        $data['vTitle']        = $request->vTitle;
        $data['vLabel']        = $request->vLabel;
        $data['eStatus']       = $request->eStatus;
        if(!empty($vUniqueCode))
        {
            $where                      = array();
            $where['vUniqueCode']         = $vUniqueCode;
            $data['dtUpdateDate'] = date("Y-m-d h:i:s");
            LanguageLabel::update_data($where, $data);
            return redirect()->route('admin.languagelabel.listing')->withSuccess('Language Label updated successfully.');
            
        }
        else
        {
            
            $data['vUniqueCode']        = md5(uniqid(time()));
            $data['dtAddedDate']   = date("Y-m-d h:i:s");
            LanguageLabel::add($data);
            return redirect()->route('admin.languagelabel.listing')->withSuccess('Language Label created successfully.');
        }
    }
    public function generate()
    {
        $languages['languages'] = LanguageLabel::get_all_data();
        $file_str = '<?php'."\n" .'return ['."\n";
		foreach ($languages['languages'] as $key => $value) {
			$teat = "'";
			$file_str .= "$teat"."$value->vLabel"."$teat => $teat"."$value->vTitle"."$teat".","."\n";
        }
        $file_str .='];';
        $base_path   = resource_path();
        $dir_path    =  '/lang/en/';
        $file   = 'lang.php';
        $destinationPath        = $base_path.$dir_path;
        File::put($destinationPath.$file,$file_str);
        return redirect()->route('admin.languagelabel.listing')->withSuccess('Language Label Genrate Successfully.');
	}
}
