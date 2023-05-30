<?php
namespace App\Http\Controllers\admin\business_advisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\business_advisor\BusinessAdvisor;
use Validator;
use Illuminate\Support\Facades\File;
use App\Libraries\Paginator;
use App\Models\admin\industry\Industry;
use App\Helper\GeneralHelper;
use App\Models\front\systememail\Systememail;

use Session;

class BusinessAdvisorController extends Controller
{
    public function listing() {
        return view('admin.business_advisor.listing');
    }

    public function ajax_listing(Request $request) {
        $action = $request->action;
        $iAdvisorProfileId = $vUniqueCode = $vFirstName = $vLastName = $vEmail = $vPhone = $dDob = $tEducationDetail = $tDescription = $vExperince = $vImage = $tBio = $eStatus = $eIsDeleted = $vKeyword = $status_search = '';
        $column         = "iAdvisorProfileId";
        /*$column         = "eShowHomePage";*/
        $order          = "DESC";
        $status_search  = $request->status_search;
        $iAdvisorProfileId = $request->iAdvisorProfileId;
        $vAdvisorDisplayId = $request->vAdvisorDisplayId;
        $vUniqueCode = $request->vUniqueCode;
        $vName = $request->vName;
        $vEmail = $request->vEmail;
        $vPhone = $request->vPhone;
        $dDob = $request->dob;
        $tEducationDetail = $request->tEducationDetail;
        $tDescription = $request->tDescription;
        $vExperince = $request->vExperince;
        $tBio = $request->tBio;
        $eStatus = $request->eStatus;
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
            BusinessAdvisor::update_data($where,$data);
        }
        if($action == "delete")
        {
            $where                 = array();
            $where['vUniqueCode']    = $request->vUniqueCode;
            $data['eIsDeleted'] = 'Yes';
            BusinessAdvisor::update_data($where,$data);
            
        }
        if($action == "admin_approval")
        {
            $name=$request->vName;
            $where                 = array();
            $where['vUniqueCode']    = $request->vUniqueCode;
            $data['eAdminApproval'] = 'Approved';
            BusinessAdvisor::update_data($where,$data);

            /* EMAIL To User for profile approved */
            $criteria = array();
            $criteria['vEmailCode'] = 'ADMIN_PROFILE_APPROVED';
            $email = Systememail::get_email_by_code($criteria);
            $company_setting = GeneralHelper::setting_info('company');
            $subject = str_replace("#SYSTEM.COMPANY_NAME#", $company_setting['COMPANY_NAME']['vValue'], $email->vEmailSubject);
            $constant   = array('#name#','#profile_vuniquecode#','#SITE_NAME#');
            $value      = array($name,url('advisor-detail',$request->vUniqueCode),$company_setting['COMPANY_NAME']['vValue']);
            $message = str_replace($constant, $value, $email->tEmailMessage);
            
            $email_data['to']       = $request->vEmail;
            $email_data['vSandgridTemplateId']       = $email->vSandgridTemplateId;
            $email_data['subject']  = $subject;
            $email_data['msg']      = $message;
            $email_data['dynamic_template_data']      = ['name' => $name, 'profile_vuniquecode' =>  url('advisor-detail',$request->vUniqueCode)];
            $email_data['vFromName']     = $email->vFromName;
            $email_data['from']     = $email->vFromEmail;
            $email_data['company_name']     = $company_setting['COMPANY_NAME']['vValue'];
            /*GeneralHelper::send('ADMIN_PROFILE_APPROVED', $email_data);*/
            GeneralHelper::send_email_notifiction('ADMIN_PROFILE_APPROVED', $email_data);
             /* EMAIL To User for profile approved*/
            
        }if($action == "admin_reject")
        {

            $name=$request->vName;
            $where                 = array();
            $where['vUniqueCode']    = $request->vUniqueCode;
            $data['eAdminApproval'] = 'Reject';
            BusinessAdvisor::update_data($where,$data);

            $criteria = array();
            $criteria['vEmailCode'] = 'ADMIN_PROFILE_REJECTED';
            $email = Systememail::get_email_by_code($criteria);
            $company_setting = GeneralHelper::setting_info('company');
            $subject = str_replace("#SYSTEM.COMPANY_NAME#", $company_setting['COMPANY_NAME']['vValue'], $email->vEmailSubject);
            $constant   = array('#name#','#profile_vuniquecode#','#SITE_NAME#');
            $value      = array($name,url('advisor-detail',$request->vUniqueCode),$company_setting['COMPANY_NAME']['vValue']);
            $message = str_replace($constant, $value, $email->tEmailMessage);
            
            $email_data1['to']       = $request->vEmail;
            $email_data1['vSandgridTemplateId']       = $email->vSandgridTemplateId;
            $email_data1['subject']  = $subject;
            $email_data1['msg']      = $message;
            $email_data1['dynamic_template_data']      = ['name' => $name, 'profile_vuniquecode' =>  url('advisor-detail',$request->vUniqueCode)];
            $email_data1['vFromName']     = $email->vFromName;
            $email_data1['from']     = $email->vFromEmail;
            $email_data1['company_name']     = $company_setting['COMPANY_NAME']['vValue'];
            GeneralHelper::send_email_notifiction('ADMIN_PROFILE_REJECTED', $email_data1);
            
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
                    BusinessAdvisor::update_data($where,$data);                   
                }
                $eStatus = 'Active';
            }

            if($eStatus == "delete")
            {
                foreach ($vUniqueCode as $key => $value) 
                {
                    $where                 = array();
                    $where['vUniqueCode']    = $value;
                    $data['eIsDeleted'] = 'Yes';
                    BusinessAdvisor::update_data($where,$data);                   
                }
                $eStatus = "";
            }
            else
            {
                foreach ($vUniqueCode as $key => $value) 
                {
                    $data['eStatus'] = $eStatus;
                    $where = array("vUniqueCode" => $value);
                    BusinessAdvisor::update_data($where,$data);                   
                }
                $eStatus = "";
            }
        }
        
        $criteria = array();
        $criteria['vKeyword']       = $vKeyword;
        $criteria['status_search']  = $status_search;
        $criteria['vAdvisorDisplayId'] = $vAdvisorDisplayId;
        $criteria['vName']          = $vName;        
        $criteria['vEmail']         = $vEmail;
        $criteria['vPhone']         = $vPhone;
        $criteria['eStatus']        = $eStatus;
        $criteria['eIsDeleted']     = $eIsDeleted;
        $criteria['column']         = $column;
        $criteria['order']          = $order;
        $user_data = BusinessAdvisor::get_all_data($criteria);
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
        $data['data'] = BusinessAdvisor::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        return view('admin.business_advisor.ajax_listing')->with($data);  
    }
    public function view($vUniqueCode)
    {
        $criteria = array();
        $criteria["vUniqueCode"] = $vUniqueCode;
        $data['advisor'] = BusinessAdvisor::get_by_id($criteria);
        $data['location'] = BusinessAdvisor::get_location();
        $data['industries'] = Industry::get_all_data();
        $data['selected_industries'] = BusinessAdvisor::get_industries_data(['iAdvisorProfileId'=>$data['advisor']->iAdvisorProfileId]);

        $data['selected_location'] = BusinessAdvisor::get_location_data(['iAdvisorProfileId'=>$data['advisor']->iAdvisorProfileId]);

        
        if(!empty($data['advisor'])) {
            return view('admin.business_advisor.view')->with($data);
        }
        else {
            return redirect()->route('admin.business_advisor.listing');
        }
    }

    public function add() {
        $data['location'] = BusinessAdvisor::get_location();
        $data['industries'] = Industry::get_all_data();

        return view('admin.business_advisor.add')->with($data); 
    }

    public function edit($vUniqueCode)
    {
        $criteria = array();
        $criteria["vUniqueCode"] = $vUniqueCode;
        $data['advisor'] = BusinessAdvisor::get_by_id($criteria);
        $data['location'] = BusinessAdvisor::get_location();
        $data['industries'] = Industry::get_all_data();
        $data['selected_industries'] = BusinessAdvisor::get_industries_data(['iAdvisorProfileId'=>$data['advisor']->iAdvisorProfileId]);

        $data['selected_location'] = BusinessAdvisor::get_location_data(['iAdvisorProfileId'=>$data['advisor']->iAdvisorProfileId]);

        $data['image_data'] = BusinessAdvisor::get_advisor_images(['iAdvisorProfileId' => $data['advisor']->iAdvisorProfileId]);

        if(!empty($data['advisor'])) {
            return view('admin.business_advisor.add')->with($data);
        }
        else {
            return redirect()->route('admin.business_advisor.listing');
        }
    }

    public function store(Request $request)
    {
        ini_set('memory_limit', -1);
        $data = array();
        $vUniqueCode = $request->vUniqueCode;
        $data['vUniqueCode'] = $request->vUniqueCode;
        $data['vAdvisorProfileTitle'] = $request->vAdvisorProfileTitle;
        $data['vCompanyName'] = $request->vCompanyName;
        $data['vFirstName'] = $request->vFirstName;
        $data['vLastName'] = $request->vLastName;
        $data['vEmail'] = $request->vEmail;
        $data['vPhone'] = $request->vPhone;
        /* $data['vAdvisorProfileName'] = $request->vAdvisorProfileName; */

        $data['eFinancialAnalyst'] = $request->eFinancialAnalyst;
        $data['eAccountant'] = $request->eAccountant;
        $data['eBusinessLawer'] = $request->eBusinessLawer;
        $data['eTaxConsultant'] = $request->eTaxConsultant;
        $data['eBusinessBrokers'] = $request->eBusinessBrokers;
        $data['eCommercialRealEstateBrokers'] = $request->eCommercialRealEstateBrokers;
        $data['eMandAAdvisor'] = $request->eMandAAdvisor;
        $data['eInvestmentBanks'] = $request->eInvestmentBanks;

        $data['vIdentificationNo'] = $request->vIdentificationNo;
        $data['iCost'] = $request->iCost;
        $data['tAdvisorProfileDetail'] = $request->tAdvisorProfileDetail;
        $data['dDob'] = date('Y-m-d',strtotime($request->dDob));        
        $data['tEducationDetail'] = $request->tEducationDetail;
        $data['tDescription'] = $request->tDescription;
        $data['vExperince'] = $request->vExperince;
        $data['tBio'] = $request->tBio;
        $data['eStatus'] = $request->eStatus;
        $data['eShowHomePage'] = $request->eShowHomePage;
        $data['eAdminApproval'] = $request->eAdminApproval;

        
        $message = '';
        if(!empty($vUniqueCode)) 
        {
            $data['dtUpdatedDate']      = date("Y-m-d h:i:s");
            $where = array();
            $where['vUniqueCode']       = $vUniqueCode;
            BusinessAdvisor::update_data($where, $data);    
            $get_id = BusinessAdvisor::get_by_id($where);
            $advisor_id = $get_id->iAdvisorProfileId;

            $message = 'Business Advisor updated successfully.';

            $doc_where = ['iBusinessAdvisorId'=> $advisor_id];
             BusinessAdvisor::delete_toDocument($doc_where);

            $explodeDoc=explode(',', $request->documentId);

            foreach ($explodeDoc as $key => $docid) {
                $document_data = [
                    'iBusinessAdvisorId' => $advisor_id
                ];
             $document_where = ['iDocumentId'=> $docid];
             BusinessAdvisor::update_toDocument($document_where,$document_data);
            }

            if (isset($request->industries)) 
            {
                $industries_where = ['iAdvisorProfileId'=> $advisor_id];
                BusinessAdvisor::delete_industry($industries_where);

                foreach ($request->industries as $key => $value) 
                {
                    $iName=strstr($value, '_', true); 
                    $iId=substr($value, strpos($value, "_") + 1); 
                
                    $industry_data = [
                        'iIndustryId' => $iId,
                        'iAdvisorProfileId'=>$advisor_id,
                        'vUniqueCode' => md5(uniqid(time())),
                        'vIndustryName' => $iName,
                        'dtAddedDate' => date("Y-m-d h:i:s"),
                    ];
                    BusinessAdvisor::add_industry($industry_data);
                }
            }
            if(!empty($request->locations))
            {
                $location_where = ['iAdvisorProfileId'=> $advisor_id];
                BusinessAdvisor::delete_locations($location_where);
                foreach ($request->locations as $key => $value) 
                {
                    $lid='';
                    $ltype=strstr($value, '_', true); 
                    $lname= substr($value, strpos($value, "-") + 1);

                    if (preg_match('/_(.*?)-/', $value, $match) == 1) {
                            $lid=$match[1];
                        }

                    $location_data = [
                        'iLocationId'=>$lid,
                        'iAdvisorProfileId'=>$advisor_id,
                        'vLocationName'=>$lname,
                        'eLocationType'=>$ltype,
                        'vUniqueCode' => md5(uniqid(time())),
                        'dtAddedDate' => date('Y-m-d H:i:s')
                    ];
                    BusinessAdvisor::add_locations($location_data);
                }
            }

        }
        else 
        {
            $data['dtAddedDate']        = date("Y-m-d h:i:s");
            $data['vUniqueCode']        = md5(uniqid(time()));
            $advisorId = BusinessAdvisor::add($data);
            $message = 'Business Advisor created successfully.';

            $data1['vAdvisorDisplayId'] = str_pad($advisorId, 6, "0", STR_PAD_LEFT);
            $data1['dtUpdatedDate']      = date("Y-m-d h:i:s");
            $where1 = array();
            $where1['vUniqueCode']       = $data['vUniqueCode'];
            BusinessAdvisor::update_data($where1, $data1);
       
          $explodeDoc=explode(',', $request->documentId);

            foreach ($explodeDoc as $key => $docid) {
                $document_data = [
                    'iBusinessAdvisorId' => $advisorId
                ];
             $document_where = ['iDocumentId'=> $docid];
             BusinessAdvisor::update_toDocument($document_where,$document_data);
            }

            if (isset($request->industries)) 
            {
                foreach ($request->industries as $key => $value) 
                {
                $iName=strstr($value, '_', true); 
                $iId=substr($value, strpos($value, "_") + 1); 
                
                    $industry_data = [
                        'iIndustryId' => $iId,
                        'iAdvisorProfileId' => $advisorId,
                        'vUniqueCode' => md5(uniqid(time())),
                        'vIndustryName' => $iName,
                        'dtAddedDate' => date("Y-m-d h:i:s"),
                    ];
                    
                        BusinessAdvisor::add_industry($industry_data);
                }
            }

            if(!empty($request->locations))
            {                  
                foreach ($request->locations as $key => $value) 
                {
                    $lid='';
                    $ltype=strstr($value, '_', true); 
                    $lname= substr($value, strpos($value, "-") + 1);
                    if (preg_match('/_(.*?)-/', $value, $match) == 1) {
                            $lid=$match[1];
                        }
                    $location_data = [
                        'iLocationId'=>$lid,
                        'iAdvisorProfileId'=>$advisorId,
                        'vLocationName'=>$lname,
                        'eLocationType'=>$ltype,
                        'vUniqueCode' => md5(uniqid(time())),
                        'dtAddedDate' => date('Y-m-d H:i:s')
                    ];
                   BusinessAdvisor::add_locations($location_data);
                }
            }
        }
        if(Session::has('uploaded_document')) {            
            $output = BusinessAdvisor::get_by_id(["vUniqueCode" => $data['vUniqueCode']]);
            $data1['iBusinessAdvisorId']      = $output->iAdvisorProfileId;
            $where = array();
            $where = Session::get('uploaded_document');

            BusinessAdvisor::update_whereIn($where, $data1);
            Session::put('uploaded_document',[]);
        }
        return redirect()->route('admin.business-advisor.listing')->withSuccess($message);
    }

    public function upload(Request $request) 
    {
        ini_set('memory_limit', -1);
        $lastId='';
        foreach($_FILES as $image) {
            $image1 = $image['name'];
            $type = $request->type;
            $extension = pathinfo($image1, PATHINFO_EXTENSION);
            $imageName = md5(RAND(1,999)).time().'.'.$extension;
            $destination_path = public_path('uploads/business-advisor/'.$type.'/'.$imageName);
            move_uploaded_file($image['tmp_name'],$destination_path);
    
            $data['vImage']        = $imageName;
            $data['vFileName']     = $image1;
            $data['vUniqueCode'] = md5(uniqid(time()));
            $data['eType']        = $type;
            $data['dtAddedDate'] = date("Y-m-d h:i:s");
            $lastId = BusinessAdvisor::add_toDocument($data);
        }

        $return_data = ['id' => $lastId];
        return response()->json($return_data);
    }
     public function delete_documents(Request $request)
    {
        $iDocumentId=$request->iDocumentId;
        BusinessAdvisor::delete_document_byId($iDocumentId);
        echo 'true';

        $fileName=$request->file_name;
        $action=$request->action;
        if($action == 'beforeSaveDelete'){
            BusinessAdvisor::delete_document_byName($fileName);            
        }
        echo 'true';

    }
}
