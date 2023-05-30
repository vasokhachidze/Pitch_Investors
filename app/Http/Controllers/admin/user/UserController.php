<?php
namespace App\Http\Controllers\admin\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\user\User;
use App\Libraries\Paginator;
use App\Helper\GeneralHelper;
use Validator;
use Session;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.listing');
    }
    public function ajax_listing(Request $request)
    {   
        $action = $request->action;
        $eStatus = $vName = $vEmail = $vPhone = $vKeyword = $status_search = "";
        $column         = "iUserId";
        $order          = "DESC";
        $status_search  = $request->status_search;
        $vName          = $request->vName;
        $vEmail         = $request->vEmail;
        $vPhone         = $request->vPhone;
        $eStatus        = $request->eStatus;
        $eIsDeleted     = $request->eIsDeleted;
        if(empty($eIsDeleted))
        {
            $eIsDeleted   = 'No';
        }
        if($action == "recover")
        {
            $vUniqueCode = $request->vUniqueCode;
            $data['eIsDeleted'] = 'No';
            $where = array("vUniqueCode" => $vUniqueCode);
            User::update_data($where,$data);
        }
        if($action == "delete")
        {
            $where                 = array();
            $where['vUniqueCode']    = $request->vUniqueCode;
            $data['eIsDeleted'] = 'Yes';
            User::update_data($where,$data);
            
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
                    User::update_data($where,$data);
                   
                }
                $eStatus = "";
            }
            else
            {
                foreach ($vUniqueCode as $key => $value) 
                {
                    $data['eStatus'] = $eStatus;
                    $where = array("vUniqueCode" => $value);
                    User::update_data($where,$data);
                   
                }
                $eStatus = "";
            }
        }
        $criteria = array();
        $criteria['vKeyword']       = $vKeyword;
        $criteria['status_search']  = $status_search;
        $criteria['vName']          = $vName;
        $criteria['vEmail']         = $vEmail;
        $criteria['vPhone']         = $vPhone;
        $criteria['eStatus']        = $eStatus;
        $criteria['eIsDeleted']     = $eIsDeleted;
        $criteria['column']         = $column;
        $criteria['order']          = $order;
        $user_data = User::get_all_data($criteria);
        $pages = 1;
        if($request->pages != "")
        {
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = count($user_data);
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
        $data['data'] = User::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        return view('admin.user.ajax_listing')->with($data);  
    }

    public function add()
    {
        return view('admin.user.add');
    }
    public function edit($vUniqueCode)
    {
        $criteria                   = array();
        $criteria["vUniqueCode"]    = $vUniqueCode;
        $data['user']              = User::get_by_id($criteria);

        if(!empty($data['user']))
        {
            return view('admin.user.add')->with($data);
        }
        else
        {
            return redirect()->route('admin.user.listing');
        }
    }

    public function store(Request $request)
    {
        $vUniqueCode = $request->vUniqueCode;
        if ($request->hasFile('vImage')) 
        {
            $request->validate([
                'vImage' => 'required|mimes:png,jpg,jpeg|max:2048'
            ]);
            $imageName      = time().'.'.$request->vImage->getClientOriginalName();
            $path           = public_path('uploads/user'); 
            $request->vImage->move($path, $imageName);
        }
        $data['vFirstName']   = $request->vFirstName;
        $data['addedBy']   = !empty(Session::get('id'))??NULL;
        $data['vLastName']    = $request->vLastName;
        $data['vEmail']        = $request->vEmail;
        $data['vPhone']       = $request->vPhone;
        $data['dDOB']       = date('y-m-d', strtotime($request->dDOB));
        $data['eStatus']      = $request->eStatus;
        if ($request->hasFile('vImage')) 
        {   
            $data['vImage']    = $imageName;
        }
        if(!empty($vUniqueCode)){
            $data['dtUpdatedDate'] = date("Y-m-d h:i:s");
            $where                      = array();
            $where['vUniqueCode']          = $vUniqueCode;
            User::update_data($where, $data);
            return redirect()->route('user.listing')->withSuccess('User updated successfully.');
        }
        else
        {
            $data['vUniqueCode']        = md5(uniqid(time()));
            $data['vAccNo']             = GeneralHelper::generateUserCode();
            $data['vPassword']          = md5($request->vPassword);
            $data['dtAddedDate']        = date("Y-m-d h:i:s");
            User::add($data);
            return redirect()->route('user.listing')->withSuccess('User created successfully.');
        }
    }
    public function check_unique_email(Request $request)
    {
        $vUniqueCode                     = $request->vUniqueCode;
        $vEmail                          = $request->email;
        $criteria['vUniqueCode']         = $vUniqueCode;
        $criteria['vEmail']              = $vEmail;
        $data = User::check_unique_email($criteria); // need to follow criteria patterns only.
        if(!empty($data))
        {
            $mydata                     = array();
            $mydata["status"]           = "200";
            $mydata["message"]          = "1";
            $mydata["notification"]     = "Email Alreday Exits";
            echo json_encode($mydata);
        } 
        else 
        {
            $mydata                     = array();
            $mydata["status"]           = "500";
            $mydata["message"]          = "0";
            $mydata["notification"]     = "Email Avalable";
            echo json_encode($mydata);
        }
    }
    public function change_password($vUniqueCode)
    {
        $criteria                   = array();
        $criteria["vUniqueCode"]    = $vUniqueCode;
        $data['user']              = User::get_by_id($criteria);
        if(isset($data['user']) && $data['user']!='')
        {
            $data['vUniqueCode'] = $vUniqueCode;
            return view('admin.user.change_password')->with($data);
        }
        else
        {
            return redirect()->route('user.listing');
        }
    }
    public function change_password_action(Request $request)
    {
        $vUniqueCode                = $request->vUniqueCode;
        $data['vPassword']          = md5($request->vPassword);
        $data['dtUpdatedDate']      = date("Y-m-d h:i:s");
        $where                      = array();
        $where['vUniqueCode']       = $vUniqueCode;
        User::update_data($where, $data);
        return redirect()->route('user.listing')->withSuccess('User Password updated successfully.');
    }
}
