<?php
namespace App\Http\Controllers\admin\testimonial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\testimonial\Testimonial;
use App\Libraries\Paginator;
use App\Libraries\General;

class TestimonialController extends Controller
{
    public function index() {
     return view('admin.testimonial.listing');
    }
    public function ajax_listing(Request $request) {
        $action          = $request->action;
        $eStatus         = $vName = $tDescription  = $status_search = "";
        $column          = "iTestimonialId";
        $order           = "DESC";
        $status_search   = $request->status_search;
        $vName           = $request->vName;
        $tDescription    = $request->tDescription;
        $eStatus         = $request->eStatus;
        $eIsDeleted      = $request->eIsDeleted;
        if(empty($eIsDeleted)) {
            $eIsDeleted   = 'No';
        }
        if($action == "recover") {
            $vUniqueCode = $request->vUniqueCode;
            $data['eIsDeleted'] = 'No';
            $where = array("vUniqueCode" => $vUniqueCode);
            Testimonial::update_data($where,$data);
        }
        if($action == "delete") {
            $where = array();
            $where['vUniqueCode'] = $request->vUniqueCode;
            $data['eIsDeleted'] = 'Yes';
            Testimonial::update_data($where,$data);
        }
        if($action == "status") {
            $vUniqueCode = (explode(",",$request->vUniqueCode));
            $eStatus = $request->eStatus;
            if($eStatus == "delete") {
                foreach ($vUniqueCode as $key => $value) {
                    $where = array();
                    $where['vUniqueCode'] = $value;
                    $data['eIsDeleted'] = 'Yes';
                    Testimonial::update_data($where,$data);
                }
                $eStatus = "";
            }
            else {
                foreach ($vUniqueCode as $key => $value) {
                    $data['eStatus'] = $eStatus;
                    $where = array("vUniqueCode" => $value);
                    Testimonial::update_data($where,$data);
                }
                $eStatus = "";
            }
        }
        $criteria = array();
        $criteria['status_search']  = $status_search;
        $criteria['vName']          = $vName;
        $criteria['tDescription']   = $tDescription;
        $criteria['eStatus']        = $eStatus;
        $criteria['eIsDeleted']     = $eIsDeleted;
        $criteria['column']         = $column;
        $criteria['order']          = $order;
        $banner_data                = Testimonial::get_all_data($criteria);
        $pages = 1;
        if($request->pages != "") {
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = count($banner_data);
        $start = ($paginator->currentPage - 1) * $paginator->itemsPerPage;
        $limit = $paginator->itemsPerPage;
        if($request->limit_page !='') {
            $per_page = $request->limit_page;
            $paginator->itemsPerPage = $per_page;
            $paginator->range = $per_page;
            $limit =  $per_page;
        }
        $paginator->is_ajax = true;
        $paging = true;
        $data['data'] = Testimonial::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        return view('admin.testimonial.ajax_listing')->with($data);  
    }
    public function add() {
       return view('admin.testimonial.add');
    }
    public function edit($vUniqueCode) {
        $criteria = array();
        $criteria["vUniqueCode"] = $vUniqueCode;
        $data['testimonial'] = Testimonial::get_by_id($criteria);
        if(!empty($data['testimonial'])) {
            return view('admin.testimonial.add')->with($data);
        }
        else {
            return redirect()->route('admin.testimonial');
        }
    }
    public function store(Request $request) {
        $vUniqueCode           = $request->vUniqueCode;
        $data['vName']         = $request->vName;
        $data['vRating']       = $request->vRating;
        $data['tDescription']  = $request->tDescription;
        $data['eStatus']       = $request->eStatus;
        if ($request->hasFile('vImage')) 
        {
            $imageName      = time().'.'.$request->file('vImage')->extension();
            $path           = public_path('uploads/front/testimonial/'); 
            $request->vImage->move($path, $imageName);
            $data['vImage']    = $imageName;
        }

        if(!empty($vUniqueCode)) {
            $where = array();
            $where['vUniqueCode'] = $vUniqueCode;
            $data['dtUpdatedDate'] = date("Y-m-d h:i:s");
            Testimonial::update_data($where, $data);
            return redirect()->route('admin.testimonial')->withSuccess('Testimonial updated successfully.');
        }
        else {
            $data['vUniqueCode'] = md5(uniqid(time()));
            $data['dtAddedDate'] = date("Y-m-d h:i:s");
            $data['eIsDeleted']       = "No";
            Testimonial::add($data);
            return redirect()->route('admin.testimonial')->withSuccess('Testimonial created successfully.');
        }
    }
}
