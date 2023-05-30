<?php
namespace App\Http\Controllers\admin\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\admin\admin\Admin;
use App\Libraries\Paginator;
use Validator;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function index() {
        return view('admin.admin.listing');
    }
    public function ajax_listing(Request $request){
        $action = $request->action;
        $eStatus = $vName = $vEmail = $vPhone = $vKeyword = $status_search = "";
        $column         = "iAdminId";
        $order          = "DESC";
        $status_search  = $request->status_search;
        $vName          = $request->vName;
        $vEmail         = $request->vEmail;
        $vPhone         = $request->vPhone;
        $eStatus        = $request->eStatus;
        $eIsDeleted      = $request->eIsDeleted;
        if(empty($eIsDeleted)) {
            $eIsDeleted   = 'No';
        }
        if($action == "recover") {
            $vUniqueCode = $request->vUniqueCode;
            $data['eIsDeleted'] = 'No';
            $where = array("vUniqueCode" => $vUniqueCode);
            Admin::update_data($where,$data);
        }
        if($action == "delete") {
            $where = array();
            $where['vUniqueCode'] = $request->vUniqueCode;
            $data['eIsDeleted'] = 'Yes';
            Admin::update_data($where,$data);
        }
        if($action == "status") {
            $vUniqueCode = (explode(",",$request->vUniqueCode));
            $eStatus = $request->eStatus;
            if($eStatus == "delete") {
                foreach ($vUniqueCode as $key => $value) {
                    $where = array();
                    $where['vUniqueCode'] = $value;
                    $data['eIsDeleted'] = 'Yes';
                    Admin::update_data($where,$data);
                }
                $eStatus = "";
            }
            else {
                foreach ($vUniqueCode as $key => $value) {
                    $data['eStatus'] = $eStatus;
                    $where = array("vUniqueCode" => $value);
                    Admin::update_data($where,$data);
                }
                $eStatus = "";
            }
        }
        $criteria = array();
        $criteria['vKeyword'] = $vKeyword;
        $criteria['status_search']  = $status_search;
        $criteria['vName'] = $vName;
        $criteria['vEmail'] = $vEmail;
        $criteria['vPhone'] = $vPhone;
        $criteria['eStatus'] = $eStatus;
        $criteria['eIsDeleted'] = $eIsDeleted;
        $criteria['column'] = $column;
        $criteria['order'] = $order;
        $admin_data = Admin::get_all_data($criteria);
        $pages = 1;
        if($request->pages != "") {
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = count($admin_data);
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
        $data['data'] = Admin::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        return view('admin.admin.ajax_listing')->with($data);  
    }
    public function add() {
        return view('admin.admin.add');
    }
    public function edit($vUniqueCode) {
        $criteria = array();
        $criteria["vUniqueCode"] = $vUniqueCode;
        $data['admin'] = Admin::get_by_id($criteria);

        if(!empty($data['admin'])) {
            return view('admin.admin.add')->with($data);
        }
        else {
            return redirect()->route('admin.listing');
        }
    }

    public function store(Request $request) {
        $vUniqueCode = $request->vUniqueCode;
        if($request->hasfile('vImage')) {
            $request->validate([
                'vImage' => 'required|mimes:png,jpg,jpeg|max:2048'
            ]);
            $imageName          = time().'.'.$request->vImage->getClientOriginalName();
            $image              = $request->file('vImage');
            $destinationPath    = public_path('/uploads/admin');
            $img                = Image::make($image->path());
            $width              = Image::make($image->path())->width();
            $img->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$imageName);
        }    
        $data['vFirstName']   = $request->vFirstName;
        $data['vLastName']    = $request->vLastName;
        $data['email']        = $request->email; //vEmail
        $data['vPhone']       = $request->vPhone;
        $data['eStatus']      = $request->eStatus;
        if ($request->hasFile('vImage')) {   
            $data['vImage']    = $imageName;
        }
        if(!empty($vUniqueCode)){
            $data['dtUpdatedDate'] = date("Y-m-d h:i:s");
            $where = array();
            $where['vUniqueCode'] = $vUniqueCode;
            Admin::update_data($where, $data);
            return redirect()->route('admin.listing')->withSuccess('Admin updated successfully.');
        }
        else {
            $data['vUniqueCode']        = md5(uniqid(time()));
            $data['password']           = Hash::make($request->vPassword);
            $data['dtAddedDate']        = date("Y-m-d h:i:s");
            Admin::add($data);
            return redirect()->route('admin.listing')->withSuccess('Admin created successfully.');
        }
    }
    public function check_unique_email(Request $request) {
        $vUniqueCode                     = $request->vUniqueCode;
        $email                           = $request->email;
        $criteria['vUniqueCode']         = $vUniqueCode;
        $criteria['email']               = $email;
        $data = Admin::check_unique_email($criteria); // need to follow criteria patterns only.
        if(!empty($data)) {
            $mydata                     = array();
            $mydata["status"]           = "200";
            $mydata["message"]          = "1";
            $mydata["notification"]     = "Email Alreday Exits";
            echo json_encode($mydata);
           
        } 
        else {
            $mydata                     = array();
            $mydata["status"]           = "500";
            $mydata["message"]          = "0";
            $mydata["notification"]     = "Email Avalable";
            echo json_encode($mydata);
        }
    }
    public function change_password($vUniqueCode) {
        $criteria                   = array();
        $criteria["vUniqueCode"]    = $vUniqueCode;
        $data['admin']              = Admin::get_by_id($criteria);
        if(isset($data['admin']) && $data['admin']!='')
        {
            $data['vUniqueCode'] = $vUniqueCode;
            return view('admin.admin.change_password')->with($data);
        }
        else
        {
            return redirect()->route('admin.listing');
        }
    }
    public function change_password_action(Request $request) {
        $vUniqueCode                  = $request->vUniqueCode;
        $data['password']           = Hash::make($request->vPassword);
        $data['dtUpdatedDate']      = date("Y-m-d h:i:s");
        $where                      = array();
        $where['vUniqueCode']         = $vUniqueCode;
        Admin::update_data($where, $data);
        return redirect()->route('admin.listing')->withSuccess('Admin Password updated successfully.');
    }
    public function remove_attachment(Request $request) {
        $vUniqueCode             = $request->vUniqueCode;
        $criteria['vUniqueCode'] = $vUniqueCode;
        $admin                   = Admin::get_by_id($criteria);
        $data['vImage']          = $request->vImage;
        $destinationPath         = public_path('/uploads/admin/'.$admin->vImage);
        if(file_exists($destinationPath)) {
            unlink($destinationPath);
        }
        $where                    = array();
        $where['vUniqueCode']     = $vUniqueCode;
        $data = Admin::update_data($where, $data);    
        if(!empty($data)) {
            $mydata                     = array();
            $mydata["status"]           = "200";
            $mydata["message"]          = "success";
            $mydata["notification"]     = "Image Removed Successfully";
            echo json_encode($mydata);
           
        } 
        else {
            $mydata = array();
            $mydata["status"] = "500";
            $mydata["message"] = "error";
            $mydata["notification"] = "something went wrong";
            echo json_encode($mydata);
        } 
    }
}
