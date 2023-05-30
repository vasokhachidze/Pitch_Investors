<?php
namespace App\Http\Controllers\admin\investment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\investment\Investment;
use Validator;
use Illuminate\Support\Facades\File;
use App\Libraries\Paginator;
use App\Models\admin\industry\Industry;
use App\Helper\GeneralHelper;
use App\Models\front\systememail\Systememail;


class InvestmentController extends Controller {
    public function listing() {
        Investment::get_all_data();
        return view('admin.investment.listing');
    }

    public function ajax_listing(Request $request)
    {
        $action = $request->action;
        $eStatus = $vInvestmentDisplayId = $vName = $vEmail = $vPhone = $vKeyword = $status_search = "";
        //$column         = "eShowHomePage";
        $column        = "iInvestmentProfileId";
        $order          = "DESC";
        $status_search  = $request->status_search;
        $vInvestmentDisplayId = $request->vInvestmentDisplayId;
        $vName          = $request->vName;
        $vEmail         = $request->vEmail;
        $vPhone         = $request->vPhone;
        $eStatus        = $request->eStatus;
        $eIsDeleted     = $request->eIsDeleted;
        if(empty($eIsDeleted)) {
            $eIsDeleted   = 'No';
        }
        if($action == "recover") {
            $vUniqueCode = $request->vUniqueCode;
            $data['eIsDeleted'] = 'No';
            $where = array("vUniqueCode" => $vUniqueCode);
            Investment::update_data($where,$data);
        }
        if($action == "delete") {
            $where                 = array();
            $where['vUniqueCode']    = $request->vUniqueCode;
            $data['eIsDeleted'] = 'Yes';
            Investment::update_data($where,$data);            
        }  
        if($action == "admin_approval") {
                        $name=$request->vName;

            $where                 = array();
            $where['vUniqueCode']    = $request->vUniqueCode;
            $data['eAdminApproval'] = 'Approved';
            Investment::update_data($where,$data);     

            /* EMAIL To User for profile approved */
            $criteria = array();
            $criteria['vEmailCode'] = 'ADMIN_PROFILE_APPROVED';
            $email = Systememail::get_email_by_code($criteria);
            $company_setting = GeneralHelper::setting_info('company');
            $subject = str_replace("#SYSTEM.COMPANY_NAME#", $company_setting['COMPANY_NAME']['vValue'], $email->vEmailSubject);
            $constant   = array('#name#','#profile_vuniquecode#','#SITE_NAME#');
            $value      = array($name,url('investment-detail',$request->vUniqueCode),$company_setting['COMPANY_NAME']['vValue']);
            $message = str_replace($constant, $value, $email->tEmailMessage);
            
            $email_data['to']       = $request->vEmail;
            $email_data['vSandgridTemplateId']       = $email->vSandgridTemplateId;
            $email_data['subject']  = $subject;
            $email_data['msg']      = $message;
            $email_data['dynamic_template_data']      = ['name' => $name, 'profile_vuniquecode' => url('investment-detail',$request->vUniqueCode)];
            $email_data['vFromName']     = $email->vFromName;
            $email_data['from']     = $email->vFromEmail;
            $email_data['company_name']     = $company_setting['COMPANY_NAME']['vValue'];
            /*GeneralHelper::send('ADMIN_PROFILE_APPROVED', $email_data);*/
            GeneralHelper::send_email_notifiction('ADMIN_PROFILE_APPROVED', $email_data);
             /* EMAIL To User for profile approved*/

        }if($action == "admin_reject") {
                        $name=$request->vName;

            $where                 = array();
            $where['vUniqueCode']    = $request->vUniqueCode;
            $data['eAdminApproval'] = 'Reject';
            Investment::update_data($where,$data);    

            $criteria = array();
            $criteria['vEmailCode'] = 'ADMIN_PROFILE_REJECTED';
            $email = Systememail::get_email_by_code($criteria);
            $company_setting = GeneralHelper::setting_info('company');
            $subject = str_replace("#SYSTEM.COMPANY_NAME#", $company_setting['COMPANY_NAME']['vValue'], $email->vEmailSubject);
            $constant   = array('#name#','#profile_vuniquecode#','#SITE_NAME#');
            $value      = array($name,url('investment-detail',$request->vUniqueCode),$company_setting['COMPANY_NAME']['vValue']);
            $message = str_replace($constant, $value, $email->tEmailMessage);
            
            $email_data1['to']       = $request->vEmail;
            $email_data1['vSandgridTemplateId']       = $email->vSandgridTemplateId;
            $email_data1['subject']  = $subject;
            $email_data1['msg']      = $message;
            $email_data1['dynamic_template_data']      = ['name' => $name, 'profile_vuniquecode' => url('investment-detail',$request->vUniqueCode)];
            $email_data1['vFromName']     = $email->vFromName;
            $email_data1['from']     = $email->vFromEmail;
            $email_data1['company_name']     = $company_setting['COMPANY_NAME']['vValue'];
            GeneralHelper::send('ADMIN_PROFILE_REJECTED', $email_data1);

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
                    Investment::update_data($where,$data);                   
                }
                $eStatus = 'Active';
            }


            if($eStatus == "delete") {
                foreach ($vUniqueCode as $key => $value) {
                    $where                 = array();
                    $where['vUniqueCode']    = $value;
                    $data['eIsDeleted'] = 'Yes';
                    Investment::update_data($where,$data);
                }
                $eStatus = "";
            }
            else {
                foreach ($vUniqueCode as $key => $value) {
                    $data['eStatus'] = $eStatus;
                    $where = array("vUniqueCode" => $value);
                    Investment::update_data($where,$data);
                }
                $eStatus = "";
            }
        }
        $criteria = array();
        $criteria['vKeyword']       = $vKeyword;
        $criteria['status_search']  = $status_search;
        $criteria['vInvestmentDisplayId'] = $vInvestmentDisplayId;
        $criteria['vName']          = $vName;
        $criteria['vEmail']         = $vEmail;
        $criteria['vPhone']         = $vPhone;
        $criteria['eStatus']        = $eStatus;
        $criteria['eIsDeleted']     = $eIsDeleted;
        $criteria['column']         = $column;
        $criteria['order']          = $order;
        $user_data = Investment::get_all_data($criteria);
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
        $data['data'] = Investment::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        return view('admin.investment.ajax_listing')->with($data);  
    }
     public function view($vUniqueCode) {
        $criteria['vUniqueCode'] = $vUniqueCode;
        $data['location'] = Investment::get_location();
        $data['industries'] = Industry::get_all_data();
        $data['investment'] = Investment::get_by_id($criteria);        
        $data['selected_industries'] = Investment::get_industries_data(['iInvestmentProfileId'=>$data['investment']->iInvestmentProfileId]);
        $data['selected_location'] = Investment::get_location_data(['iInvestmentProfileId'=>$data['investment']->iInvestmentProfileId]);
        $data['documents'] = Investment::get_ducoments(['iInvestmentProfileId'=>$data['investment']->iInvestmentProfileId]);
        
        if(!empty($data['investment'])) {
            return view('admin.investment.view')->with($data);
        }
        else {
            return redirect()->route('admin.investment.listing');
        }

    }

    public function add() 
    {
        $data['location'] = Investment::get_location();
        $data['industries'] = Industry::get_all_data();
        return view('admin.investment.add')->with($data);
    }

    public function edit($vUniqueCode) {
        $criteria['vUniqueCode'] = $vUniqueCode;
        $data['location'] = Investment::get_location();
        $data['industries'] = Industry::get_all_data();
        $data['investment'] = Investment::get_by_id($criteria);        
        $data['selected_industries'] = Investment::get_industries_data(['iInvestmentProfileId'=>$data['investment']->iInvestmentProfileId]);
        $data['selected_location'] = Investment::get_location_data(['iInvestmentProfileId'=>$data['investment']->iInvestmentProfileId]);
        $data['documents'] = Investment::get_ducoments(['iInvestmentProfileId'=>$data['investment']->iInvestmentProfileId]);
        // dd($data['location']);
        // dd($data['selected_location']);
        return view('admin.investment.add')->with($data);
    }

    /* public function upload_dropzone_image($path = '',$images = '', $investment_id = '', $type = '') {
        foreach($images as $image) {
            $imageName = uniqid(time()).'.'.$image->extension();
            $image->move($path, $imageName);  
            $data_temp['iInvestmentProfileId'] = $investment_id;
            $data_temp['vUniqueCode'] = md5(uniqid(time()));
            $data_temp['vImage'] = $imageName;
            $data_temp['eType'] = $type;
            $data_temp['dtAddedDate'] = date("Y-m-d h:i:s");
            Investment::add_toDocument($data_temp);
        }
        return true;
    } */

    public function store(Request $request)
    {
        ini_set('memory_limit', -1);
        // dd($request);
        $data = array();
        $vUniqueCode = $request->vUniqueCode;
        $legal_entity = $request->legal_entity;
        $data['vUniqueCode'] = $request->vUniqueCode;
        $data['vFirstName'] = $request->vFirstName;
        $data['vLastName'] = $request->vLastName;
        $data['vEmail'] = $request->vEmail;
        $data['vBusinessProfileName'] = $request->vBusinessProfileName;
        $data['tBusinessProfileDetail'] = $request->tBusinessProfileDetail;
        $data['dDob'] = date('Y-m-d',strtotime($request->dDob));
        $data['vPhone'] = $request->vPhone;
        $data['vIdentificationNo'] = $request->vIdentificationNo;
        $data['vBusinessName'] = $request->vBusinessName;
        $data['vBusinessEstablished'] = $request->vBusinessEstablished;
        $data['eBusinessProfile'] = $request->eBusinessProfile;
        $data['eFullSaleBusiness'] = $request->eFullSaleBusiness;
        $data['ePartialSaleBusiness'] = $request->ePartialSaleBusiness;
        $data['eLoanForBusiness'] = $request->eLoanForBusiness;
        $data['eBusinessAsset'] = $request->eBusinessAsset;
        $data['eBailout'] = $request->eBailout;
        $data['tBusinessDetail'] = $request->tBusinessDetail;
        $data['tBusinessHighLights'] = $request->tBusinessHighLights;
        $data['tFacility'] = $request->tFacility;
        $data['tListProductService'] = $request->tListProductService;
        $data['vAverateMonthlySales'] = $request->vAverateMonthlySales;
        $data['vProfitMargin'] = $request->vProfitMargin;
        $data['vPhysicalAssetValue'] = $request->vPhysicalAssetValue;
        $data['vMaxStakeSell'] = $request->vMaxStakeSell;
        $data['vInvestmentAmountStake'] = $request->vInvestmentAmountStake;
        $data['tInvestmentReason'] = $request->tInvestmentReason;
        $data['eFindersFee'] = $request->eFindersFee;
        $data['eStatus'] = 'Active';
        $data['eIsDeleted'] = 'No';
        $data['eShowHomePage'] = $request->eShowHomePage;
        $data['eAdminApproval'] = $request->eAdminApproval;

        if ($legal_entity == 'eSoleProprietor') {
            $data['eSoleProprietor'] = 'Yes';
        }
        else if ($legal_entity == 'ePrivateCompany') {
            $data['ePrivateCompany'] = 'Yes';
        }
        else if ($legal_entity == 'eGeneralPartnership') {
            $data['eGeneralPartnership'] = 'Yes';
        }
        else if ($legal_entity == 'ePrivateLimitedCompany') {
            $data['ePrivateLimitedCompany'] = 'Yes';
        }
        else if ($legal_entity == 'eLLP') {
            $data['eLLP'] = 'Yes';
        }
        else if ($legal_entity == 'eSCorporation') {
            $data['eSCorporation'] = 'Yes';
        }
        else if ($legal_entity == 'eLLC') {
            $data['eLLC'] = 'Yes';
        }
        else if ($legal_entity == 'eCCorporation') {
            $data['eCCorporation'] = 'Yes';
        }

        $message = $investment_id = '';
        if(!empty($vUniqueCode))
        {
            $old_image = public_path('uploads/investment/profile/').$request->old_vImage;
            if(!empty($request->old_vImage) && File::exists($old_image) AND $request->hasFile('vImage')){
                // unlink($old_image);
            }
            $data['dtUpdatedDate']      = date("Y-m-d h:i:s");
            $where = array();
            $where['vUniqueCode']       = $vUniqueCode;
            Investment::update_data($where, $data);
            $get_id = Investment::get_by_id($where);
            $investment_id = $get_id->iInvestmentProfileId;
            $message = 'Investment updated successfully.';
            
            if(!empty($request->facility_image_upload_id))
            {
                $facility_image_array = explode(',',$request->facility_image_upload_id);
                foreach ($facility_image_array as $key => $value) {
                    $where = array();
                    $where['iInvestmentDocumentId']       = $value;
                    $dataFacility['iInvestmentProfileId'] = $investment_id;
                    $get_id = Investment::update_toDocument($where,$dataFacility);
                }
            }
            
            if (isset($request->industries)) 
            {
                $industries_where = ['iInvestmentProfileId'=> $investment_id];
                Investment::delete_industry($industries_where);

                foreach ($request->industries as $key => $value) 
                {
                    $iName=strstr($value, '_', true); 
                    $iId=substr($value, strpos($value, "_") + 1); 
                
                    $industry_data = [
                        'iIndustryId' => $iId,
                        'iInvestmentProfileId' => $investment_id,
                        'vUniqueCode' => md5(uniqid(time())),
                        'vIndustryName' => $iName,
                        'dtUpdatedDate' => date("Y-m-d h:i:s"),
                    ];
                    Investment::add_industry($industry_data);
                }
            }

            if(!empty($request->locations)){
                $location_where = ['iInvestmentProfileId'=> $investment_id];
                Investment::delete_locations($location_where);
                foreach ($request->locations as $key => $value) {
                    $lid='';
                    $ltype=strstr($value, '_', true); 
                    $lname= substr($value, strpos($value, "-") + 1);
                    if (preg_match('/_(.*?)-/', $value, $match) == 1) {
                            $lid=$match[1];
                        }

                    $location_data = [
                        'iLocationId'=>$lid,
                        'iInvestmentProfileId'=>$investment_id,
                        'vLocationName'=>$lname,
                        'eLocationType'=>$ltype,
                        'vUniqueCode' => md5(uniqid(time())),
                        'dtAddedDate' => date('Y-m-d H:i:s')
                    ];
                    Investment::add_locations($location_data);
                }
            }
        }
        else
        {
            $data['dtAddedDate']        = date("Y-m-d h:i:s");
            $data['vUniqueCode']        = md5(uniqid(time()));
            $investment_id = Investment::add($data);
            $message = 'Investment created successfully.';

            

            $data1['vInvestmentDisplayId'] = str_pad($investment_id, 6, "0", STR_PAD_LEFT);
            $data1['dtUpdatedDate']      = date("Y-m-d h:i:s");
            $where1 = array();
            $where1['vUniqueCode']       = $data['vUniqueCode'];
            Investment::update_data($where1, $data1);
            
            if (isset($request->industries)) 
            {
                foreach ($request->industries as $key => $value) 
                {
                    $iName=strstr($value, '_', true); 
                    $iId=substr($value, strpos($value, "_") + 1);
                    $industry_data = [
                        'iIndustryId' => $iId,
                        'iInvestmentProfileId' => $investment_id,
                        'vUniqueCode' => md5(uniqid(time())),
                        'vIndustryName' => $iName,
                        'dtAddedDate' => date("Y-m-d h:i:s"),
                    ];
                    Investment::add_industry($industry_data);
                }
            }
            if(!empty($request->locations)){
                foreach ($request->locations as $key => $value) {
                    $lid='';
                    $ltype=strstr($value, '_', true); 
                    $lname= substr($value, strpos($value, "-") + 1);
                    if (preg_match('/_(.*?)-/', $value, $match) == 1) {
                        $lid=$match[1];
                    }
                    $location_data = [
                        'iLocationId'=>$lid,
                        'iInvestmentProfileId'=>$investment_id,
                        'vLocationName'=>$lname,
                        'eLocationType'=>$ltype,
                        'vUniqueCode' => md5(uniqid(time())),
                        'dtAddedDate' => date('Y-m-d H:i:s')
                    ];
                    Investment::add_locations($location_data);
                }
            }
        }

        if ($request->hasFile('vImage')) {
            $request->validate([
                'vImage' => 'required|mimes:png,jpg,jpeg|max:2048'
            ]);

            $imageName = time().'.'.$request->vImage->extension();
            $path = public_path('uploads/investment/profile');
            $request->vImage->move($path, $imageName);
            $data_temp['iInvestmentProfileId'] = $investment_id;
            $data_temp['eType'] = 'profile';
            $data_temp['vImage'] = $imageName;
            if(!empty($request->old_vImage)){
                $data_temp['dtAddedDate'] = date("Y-m-d h:i:s");
                $where = [
                    'eType'=>'profile',
                    'iInvestmentProfileId'=>$investment_id
                ];
                Investment::update_toDocument($where, $data_temp);
            }
            else{
                $data_temp['dtAddedDate'] = date("Y-m-d h:i:s");
                $data_temp['vUniqueCode'] = md5(uniqid(time()));
                Investment::add_toDocument($data_temp);
            }
            $data_temp = [];
        }
        // $file_business_proof = $request->file('file_business_proof');
        /* if ($request->hasFile('file_business_proof')) {
            $path = public_path('uploads/investment/business_proof');
            $this->upload_dropzone_image($path, $request->file_business_proof, $investment_id, 'business_proof');
        } */
        // $file_fast_verification = $request->file('file_fast_verification');
        /* if ($request->hasFile('file_fast_verification')) {
            $path = public_path('uploads/investment/fast_verification');
            $this->upload_dropzone_image($path, $request->file_fast_verification, $investment_id, 'fast_verification');
        } */
        // $file_facility_upload = $request->file('file_facility_upload');
        /* if ($request->hasFile('file_facility_upload')) {
            $path = public_path('uploads/investment/facility');
            $this->upload_dropzone_image($path, $request->file_facility_upload, $investment_id, 'facility');
        } */
        // $file_yearly_sales_report = $request->file('file_yearly_sales_report');
        /* if ($request->hasFile('file_yearly_sales_report')) {
            $path = public_path('uploads/investment/yearly_sales_report');
            $this->upload_dropzone_image($path, $request->file_yearly_sales_report, $investment_id, 'yearly_sales_report');
        } */
        // $file_NDA_upload = $request->file('file_NDA_upload');
        /* if ($request->hasFile('file_NDA_upload')) {
            $path = public_path('uploads/investment/NDA');
            $this->upload_dropzone_image($path, $request->file_NDA_upload, $investment_id, 'NDA');
        } */

        return redirect()->route('admin.investment.listing')->withSuccess($message);
    }

    public function upload(Request $request) 
    {
        ini_set('memory_limit', -1);
        $lastId='';
        foreach($_FILES as $image) 
        {
            $image1 = $image['name'];
            $type = $request->type;
            $extension = pathinfo($image1, PATHINFO_EXTENSION);
            $imageName = md5(RAND(1,999)).time().'.'.$extension;
            $destination_path = public_path('uploads/investment/'.$type.'/'.$imageName);
            move_uploaded_file($image['tmp_name'],$destination_path);
    
            $data['vImage']        = $imageName;
            $data['vUniqueCode'] = md5(uniqid(time()));
            $data['eType']        = $type;
            $data['dtAddedDate'] = date("Y-m-d h:i:s");
            $lastId = Investment::add_toDocument($data);
        }
        $return_data = ['id' => $lastId];
        return response()->json($return_data);
    }
    /*public function upload() 
    {
        ini_set('memory_limit', -1);
        $image = $request->file('file');
        $type = $request->type;
        
        $extension = $image->getClientOriginalExtension();
        $imageName = md5(RAND(1,999)).time().'.'.$extension;
        $image->move(public_path('uploads/investment/'.$type.'/'),$imageName);

        $data['vImage']        = $imageName;
        $data['vUniqueCode'] = md5(uniqid(time()));
        $data['eType']        = $type;
        $data['dtAddedDate'] = date("Y-m-d h:i:s");
        $output = Investment::save_file($data);
        $return_data = ['success' => true];
        return response()->json($return_data);
    } */
}