<?php
namespace App\Http\Controllers\admin\investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\investor\Investor;
use App\Models\admin\country\Country;
use App\Models\admin\industry\Industry;
use App\Models\admin\subcounty\SubCounty;
use Illuminate\Support\Facades\File;
use App\Libraries\Paginator;
use App\Helper\GeneralHelper;
use App\Models\front\systememail\Systememail;


use Validator;
use Session;

class InvestorController extends Controller
{
    public function listing() {
        return view('admin.investor.listing');
    }

    public function ajax_listing(Request $request)
    {
        $action = $request->action;
        $eStatus = $vInvestorDisplayId = $vName = $vEmail = $vPhone = $vKeyword = $status_search = "";
        $column         = "iInvestorProfileId";
        //$column         = "eShowHomePage";
        $order          = "DESC";
        $status_search  = $request->status_search;
        $vInvestorDisplayId = $request->vInvestorDisplayId;
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
            Investor::update_data($where,$data);
        }
        if($action == "delete")
        {
            $where                 = array();
            $where['vUniqueCode']    = $request->vUniqueCode;
            $data['eIsDeleted'] = 'Yes';
            Investor::update_data($where,$data);            
        }
        if($action == "admin_approval") 
        {
            $name=$request->vName;
            $where                 = array();
            $where['vUniqueCode']    = $request->vUniqueCode;
            $data['eAdminApproval'] = 'Approved';
            Investor::update_data($where,$data);            
            
            /* EMAIL To User for profile approved */
            $criteria = array();
            $criteria['vEmailCode'] = 'ADMIN_PROFILE_APPROVED';
            $email = Systememail::get_email_by_code($criteria);
            $company_setting = GeneralHelper::setting_info('company');
            $subject = str_replace("#SYSTEM.COMPANY_NAME#", $company_setting['COMPANY_NAME']['vValue'], $email->vEmailSubject);
            $constant   = array('#name#','#profile_vuniquecode#','#SITE_NAME#');
            $value      = array($name,url('investor-detail',$request->vUniqueCode),$company_setting['COMPANY_NAME']['vValue']);
            $message = str_replace($constant, $value, $email->tEmailMessage);
            
            $email_data['to']       = $request->vEmail;
            $email_data['vSandgridTemplateId']       = $email->vSandgridTemplateId;
            $email_data['subject']  = $subject;
            $email_data['msg']      = $message;
            $email_data['dynamic_template_data']      = ['name' => $name, 'profile_vuniquecode' => url('investor-detail',$request->vUniqueCode)];
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
            Investor::update_data($where,$data);      

            $criteria = array();
            $criteria['vEmailCode'] = 'ADMIN_PROFILE_REJECTED';
            $email = Systememail::get_email_by_code($criteria);
            $company_setting = GeneralHelper::setting_info('company');
            $subject = str_replace("#SYSTEM.COMPANY_NAME#", $company_setting['COMPANY_NAME']['vValue'], $email->vEmailSubject);
            $constant   = array('#name#','#profile_vuniquecode#','#SITE_NAME#');
            $value      = array($name,url('investor-detail',$request->vUniqueCode),$company_setting['COMPANY_NAME']['vValue']);
            $message = str_replace($constant, $value, $email->tEmailMessage);
            
            $email_data1['to']       = $request->vEmail;
            $email_data1['vSandgridTemplateId']       = $email->vSandgridTemplateId;
            $email_data1['subject']  = $subject;
            $email_data1['msg']      = $message;
            $email_data1['dynamic_template_data']      = ['name' => $name, 'profile_vuniquecode' => url('investor-detail',$request->vUniqueCode)];
            $email_data1['vFromName']     = $email->vFromName;
            $email_data1['from']     = $email->vFromEmail;
            $email_data1['company_name']     = $company_setting['COMPANY_NAME']['vValue'];
            // GeneralHelper::send('ADMIN_PROFILE_REJECTED', $email_data1);
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
                    Investor::update_data($where,$data);                   
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
                    Investor::update_data($where,$data);                   
                }
                $eStatus = "";
            }
            else
            {
                foreach ($vUniqueCode as $key => $value) 
                {
                    $data['eStatus'] = $eStatus;
                    $where = array("vUniqueCode" => $value);
                    Investor::update_data($where,$data);                   
                }
                $eStatus = "";
            }
        }
        $criteria = array();
        $criteria['vKeyword']       = $vKeyword;
        $criteria['status_search']  = $status_search;
        $criteria['vInvestorDisplayId'] = $vInvestorDisplayId;
        $criteria['vName']          = $vName;
        $criteria['vEmail']         = $vEmail;
        $criteria['vPhone']         = $vPhone;
        $criteria['eStatus']        = $eStatus;
        $criteria['eIsDeleted']     = $eIsDeleted;
        $criteria['column']         = $column;
        $criteria['order']          = $order;
        $user_data = Investor::get_all_data($criteria);
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
        $data['data'] = Investor::get_all_data($criteria, $start, $limit, $paging);
        $data['paging'] = $paginator->paginate();
        return view('admin.investor.ajax_listing')->with($data);  
    }
    public function view($vUniqueCode)
    {
        $criteria = array();
        $criteria["vUniqueCode"] = $vUniqueCode;
        $criteria["iCountryId"] = 110; /* Kenya */
        $data['investor'] = Investor::get_by_id($criteria);
        $data['industries'] = Industry::get_all_data();
        $data['location'] = Investor::get_location();
        $data['image_data'] = Investor::get_image_id(['iInvestorProfileId' => $data['investor']->iInvestorProfileId]);
        $data['countries'] = Country::get_country_code($criteria);
        $data['subRegion'] = SubCounty::get_all_data($criteria);

        $data['selected_industries'] = Investor::get_industries_data(['iInvestorProfileId'=>$data['investor']->iInvestorProfileId]);
        $data['selected_location'] = Investor::get_location_data(['iInvestorProfileId'=>$data['investor']->iInvestorProfileId]);

        if(!empty($data['investor']))
        {
            return view('admin.investor.view')->with($data);
        }
        else
        {
            return redirect()->route('admin.investor.listing');
        }
    }

    public function add()
    {
        $criteria = array();
        $criteria["iCountryId"] = 110; /* Kenya */
        $criteria["eStatus"] = 'Active';
        $criteria["eIsDeleted"] = 'No';
        $data['industries'] = Industry::get_all_data();
        $data['location'] = Investor::get_location();
        
        $data['countries'] = Country::get();
        $data['subRegion'] = SubCounty::get_all_data($criteria);
        return view('admin.investor.add')->with($data);
    }
    public function edit($vUniqueCode)
    {
        $criteria = array();
        $criteria["vUniqueCode"] = $vUniqueCode;
        $criteria["iCountryId"] = 110; /* Kenya */
        $data['investor'] = Investor::get_by_id($criteria);
        $data['industries'] = Industry::get_all_data();
        $data['location'] = Investor::get_location();
        $data['image_data'] = Investor::get_image_id(['iInvestorProfileId' => $data['investor']->iInvestorProfileId]);
        $data['countries'] = Country::get();
        $data['subRegion'] = SubCounty::get_all_data($criteria);

        $data['selected_industries'] = Investor::get_industries_data(['iInvestorProfileId'=>$data['investor']->iInvestorProfileId]);
        $data['selected_location'] = Investor::get_location_data(['iInvestorProfileId'=>$data['investor']->iInvestorProfileId]);

        if(!empty($data['investor']))
        {
            return view('admin.investor.add')->with($data);
        }
        else
        {
            return redirect()->route('admin.investor.listing');
        }
    }
    public function store(Request $request)
    {
        ini_set('memory_limit', -1);
        $data = array();        
        $vUniqueCode = $request->vUniqueCode;
        $data['vUniqueCode']                = $request->vUniqueCode;
        $data['vProfileTitle']              = $request->vProfileTitle;
        $data['vFirstName']                 = $request->vFirstName;
        $data['vLastName']                  = $request->vLastName;
        $data['vEmail']                     = $request->vEmail;
        $data['dDob']                       = date('Y-m-d',strtotime($request->dDob));
        $data['vPhone']                     = $request->vPhone;
        $data['vCompanyWebsite']            = $request->vCompanyWebsite;
        $data['vInvestorProfileName']       = $request->vInvestorProfileName;
        $data['tInvestorProfileDetail']     = $request->tInvestorProfileDetail;
        $data['iNationality']               = $request->iNationality;
        $data['iCity']                      = $request->iCity;
        $data['eInvestingExp']              = $request->eInvestingExp;
        $data['eAdvisorGuide']              = $request->eAdvisorGuide;
        $data['eInvestorType']              = $request->eInvestorType;
        $data['vIdentificationNo']          = $request->vIdentificationNo;
        $data['vWhenInvest']                = $request->vWhenInvest;
        $data['eAcquiringBusiness']         = $request->eAcquiringBusiness;
        $data['eInvestingInBusiness']       = $request->eInvestingInBusiness;
        $data['eLendingToBusiness']         = $request->eLendingToBusiness;
        $data['eBuyingProperty']            = $request->eBuyingProperty;
         $data['eCorporateInvestor']     = $request->eCorporateInvestor;
        $data['eVentureCapitalFirms']   = $request->eVentureCapitalFirms;
        $data['ePrivateEquityFirms']    = $request->ePrivateEquityFirms;
        $data['eFamilyOffices']         = $request->eFamilyOffices;
        $data['vHowMuchInvest']             = $request->vHowMuchInvest;
        $data['tFactorsInBusiness']         = $request->tFactorsInBusiness;
        $data['tAboutCompany']              = $request->tAboutCompany;
        $data['eStatus']                    = $request->eStatus;
        $data['eShowHomePage'] = $request->eShowHomePage;
        $data['eAdminApproval'] = $request->eAdminApproval;

        $message = $investor_id = '';
        if(!empty($vUniqueCode))
        {
            $old_image = public_path('uploads/investor/profile/').$request->old_vImage;
            if(!empty($request->old_vImage) && File::exists($old_image) AND $request->hasFile('vImage')){
                unlink($old_image);
            }
            $data['dtUpdatedDate']      = date("Y-m-d h:i:s");
            $where = array();
            $where['vUniqueCode']       = $vUniqueCode;
            Investor::update_data($where, $data);
            $get_id = Investor::get_by_id($where);
            $investor_id = $get_id->iInvestorProfileId;
            $message = 'Investor updated successfully.';

            $doc_where = ['iInvestorProfileId'=> $investor_id];
            Investor::delete_toDocument($doc_where);

            $explodeDoc=explode(',', $request->documentId);
            foreach ($explodeDoc as $key => $docid) {
                $document_data = [
                    'iInvestorProfileId' => $investor_id
                ];
             $document_where = ['iInvestorDocId'=> $docid];
             Investor::update_toDocument($document_where,$document_data);
            }

            if (isset($request->industries)) 
            {
                $industries_where = ['iInvestorProfileId'=> $investor_id];
                Investor::delete_industry($industries_where);

                foreach ($request->industries as $key => $value) 
                {
                    $iName=strstr($value, '_', true); 
                    $iId=substr($value, strpos($value, "_") + 1); 
                
                    $industry_data = [
                       'iIndustryId' => $iId,
                        'iInvestorProfileId' => $investor_id,
                        'vUniqueCode' => md5(uniqid(time())),
                        'vIndustryName' => $iName,
                        'dtAddedDate' => date("Y-m-d h:i:s"),
                    ];
                    Investor::add_industry($industry_data);
                }
            }

            if(!empty($request->locations)){
                $location_where = ['iInvestorProfileId'=> $investor_id];
                Investor::delete_locations($location_where);
                foreach ($request->locations as $key => $value) {
                    $lid='';
                    $ltype=strstr($value, '_', true); 
                    $lname= substr($value, strpos($value, "-") + 1);
                    if (preg_match('/_(.*?)-/', $value, $match) == 1) {
                            $lid=$match[1];
                        }

                    $location_data = [
                        'iLocationId'=>$lid,
                        'iInvestorProfileId'=>$investor_id,
                        'vLocationName'=>$lname,
                        'eLocationType'=>$ltype,
                        'vUniqueCode' => md5(uniqid(time())),
                        'dtAddedDate' => date('Y-m-d H:i:s')
                    ];
                    Investor::add_locations($location_data);
                }
            }

        }
        else
        {
            $data['dtAddedDate']        = date("Y-m-d h:i:s");
            $data['vUniqueCode']        = md5(uniqid(time()));
            $investor_id = Investor::add($data);
            $message = 'Investor created successfully.';

            $data1['vInvestorDisplayId'] = str_pad($investor_id, 6, "0", STR_PAD_LEFT);
            $data1['dtUpdatedDate']      = date("Y-m-d h:i:s");
            $where1 = array();
            $where1['vUniqueCode']       = $data['vUniqueCode'];
            Investor::update_data($where1, $data1);

            $explodeDoc=explode(',', $request->documentId);

            foreach ($explodeDoc as $key => $docid) {
                $document_data = [
                    'iInvestorProfileId' => $investor_id
                ];
             $document_where = ['iInvestorDocId'=> $docid];
             Investor::update_toDocument($document_where,$document_data);
            }
            
            if (isset($request->industries)) 
            {
                foreach ($request->industries as $key => $value) 
                {
                    $iName=strstr($value, '_', true); 
                    $iId=substr($value, strpos($value, "_") + 1); 
                
                    $industry_data = [
                       'iIndustryId' => $iId,
                        'iInvestorProfileId' => $investor_id,
                        'vUniqueCode' => md5(uniqid(time())),
                        'vIndustryName' => $iName,
                        'dtAddedDate' => date("Y-m-d h:i:s"),
                    ];
                    Investor::add_industry($industry_data);
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
                        'iInvestorProfileId'=>$investor_id,
                        'vLocationName'=>$lname,
                        'eLocationType'=>$ltype,
                        'vUniqueCode' => md5(uniqid(time())),
                        'dtAddedDate' => date('Y-m-d H:i:s')
                    ];
                    Investor::add_locations($location_data);
                }
            }
        }
        if(Session::has('uploaded_identification')) {
            $output = Investor::get_by_id(["vUniqueCode" => $data['vUniqueCode']]);
            $data1['iInvestorProfileId']      = $output->iInvestorProfileId;
            $where = array();
            $where = Session::get('uploaded_identification');

            Investor::update_whereIn($where, $data1);
            Session::put('uploaded_identification',[]);
        }

        if ($request->hasFile('vImage')) {
            $request->validate([
                'vImage' => 'required|mimes:png,jpg,jpeg|max:2048'
            ]);
            
            $imageName = time().'.'.$request->vImage->extension();
            $path = public_path('uploads/investor/profile');
            $request->vImage->move($path, $imageName);
            $data_temp['iInvestorProfileId'] = $investor_id;
            $data_temp['eType'] = 'profile';
            $data_temp['vImage'] = $imageName;
            if(!empty($request->old_vImage)){
                $data_temp['dtAddedDate'] = date("Y-m-d h:i:s");
                $where = [
                    'eType'=>'profile',
                    'iInvestorProfileId'=>$investor_id
                ];
                Investor::update_toDocument($where, $data_temp);
            }
            else{
                $data_temp['dtAddedDate'] = date("Y-m-d h:i:s");
                $data_temp['vUniqueCode'] = md5(uniqid(time()));
                Investor::add_toDocument($data_temp);
            }
            $data_temp = [];
        }
        return redirect()->route('admin.investor.listing')->withSuccess($message);
    }

    /* public function upload(Request $request)
    {
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('uploads/investor/documents'),$imageName);
        return response()->json(['success'=>$imageName]);
    } */

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
            $destination_path = public_path('uploads/investor/'.$type.'/'.$imageName);
            move_uploaded_file($image['tmp_name'],$destination_path);
    
            $data['vImage']        = $imageName;
            $data['vUniqueCode'] = md5(uniqid(time()));
            $data['eType']        = $type;
            $data['dtAddedDate'] = date("Y-m-d h:i:s");
            $lastId = Investor::add_toDocument($data);
        }

        $return_data = ['id' => $lastId];
        return response()->json($return_data);
    }
}