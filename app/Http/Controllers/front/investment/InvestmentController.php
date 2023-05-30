<?php
namespace App\Http\Controllers\front\investment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\front\investment\Investment;
use App\Libraries\Paginator;
use App\Models\admin\industry\Industry;
use App\Models\front\user\User;
use App\Models\front\token\Token;
use App\Models\front\investor\Investor;
use App\Models\front\advisor\BusinessAdvisor;
use App\Models\front\connection\Connection;
use App\Models\admin\country\Country;
use App\Models\admin\region\Region;
use App\Models\admin\county\County;
use App\Models\admin\subcounty\SubCounty;
use App\Models\front\chat\Chat;
use App\Helper\GeneralHelper;
use App\Models\front\systememail\Systememail;
use App\Models\front\review\review;


class InvestmentController extends Controller
{
    public function listing() {
        $data['location'] = Investment::get_location();
        $data['industries'] = Industry::get_all_data([],1,15,true);
        $data['industries1'] = Industry::get_all_data([],16,50,true);
        $data['Region'] = Region::where(['eIsDeleted' => 'No','eStatus' => 'Active'])->get();

        return view('front.investment.listing')->with($data);
    }

    public function ajax_listing(Request $request)
    {
        $action = $request->action;
        $sort = $request->sort;
        if($action == 'sorting')
        {
            if($sort == 'a-z')
            {
                $column='vBusinessProfileName';
                $order='ASC';
            }
            elseif ($sort == 'EBITDA') {
                $column='vProfitMargin';
                $order='Desc';
            }
        }else
        {            
            $column         = "iInvestmentProfileId";
            $order          = "DESC";
        }
        
        $criteria = array();
        $criteria['column']         = $column;
        $criteria['order']          = $order;
        $criteria['eIsDeleted']     = 'No';
        $criteria['eAdminApproval'] = 'Approved';
        
        $transaction_type =  $iRegionId = $iCountyId = $iSubCountyId = $industry = [];
        if($action == 'search' AND $request->filter != null) 
        {
            foreach ($request->filter as $key => $value) 
            {
                if (isset($value['transaction_type'])) {
                    array_push($transaction_type,$value['transaction_type']);
                    // $criteria[$value['transaction_type']] = 'Yes';
                }
                else if (isset($value['iRegionId'])) 
                {
                    array_push($iRegionId,$value['iRegionId']);
                    // $iRegionId=$value['iRegionId'];

                }else if (isset($value['iCountyId'])) {
                    array_push($iCountyId,$value['iCountyId']);
                    // $iRegionId=$value['iRegionId'];

                }else if (isset($value['iSubCountyId'])) {
                    array_push($iSubCountyId,$value['iSubCountyId']);
                    // $iRegionId=$value['iRegionId'];

                }
                else if (isset($value['industry'])) {
                    array_push($industry,$value['industry']);
                }
                $criteria['otherField']=$transaction_type;
            }
            $criteria['industry'] = $industry;
            $criteria['iRegionId'] = $iRegionId;
            $criteria['iCountyId'] = $iCountyId;
            $criteria['iSubCountyId'] = $iSubCountyId;
        }        
        $investment_data = Investment::get_all_data($criteria);
        
        $loginSession=session('user');        
        if(!empty($loginSession)){
                $data['loginUserId']=$loginSession['iUserId'];
        }

        $pages = 1;
        if($request->pages != "")
        {
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = count($investment_data);
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
        // \DB::enableQueryLog();

        $data['total_record']=$paginator->total;
        $data['data'] = Investment::get_all_data($criteria, $start, $limit, $paging, true);
        // dd(\DB::getQueryLog());

        $criteria2=array();
        foreach ($data['data'] as $key => $value) 
        {
            $criteria2['iInvestmentProfileId'] = $value->iInvestmentProfileId;
            $data['location'][] = Investment::get_location_data($criteria2);
            $data['industries'][] = Investment::get_industries_data($criteria2);
        }
        $data['paging'] = $paginator->paginate();
        // dd($data);
        return view('front.investment.ajax_listing')->with($data);
    }
    public function connectionList()
    {
        $session_data = session('user');
        if (!empty(session('user')) OR !empty($session_data['iUserId'])) {
            $criteria["iSenderId"] = $session_data['iUserId'];
            $criteria["iReceiverId"] = $session_data['iUserId'];
            return $data['data'] = Chat::connectionListing($criteria);
            // return view('front.chat.ajax_chat_listing')->with($data);
        }
    }

    public function investment_detail($code) 
    {
        $session_data = session('user');

        $data['profileVisible'] = false;
        $data['myOwnProfile'] = false;
        $criteria = array();
        $criteria['vUniqueCode'] = $code;
        $criteria['eAdminApproval'] = 'Approved';
        $data['data']=Investment::get_by_id($criteria);
        if(isset($data['data']))
        {
            $criteria['iProfileId']=$data['data']->iInvestmentProfileId;
            $criteria['eProfileType']='Investment';
            $data['review_data']=Review::get_all_data_with_user($criteria);
           if(!empty($session_data))
           {
                $loginUser=$session_data['iUserId'];
                $criteria2['iProfileId']=$data['data']->iInvestmentProfileId;
                $criteria2['iUserId']=$loginUser;
                $criteria2['eProfileType']='Investment';
                $data['my_review_data']=Review::get_all_data_with_loginuser($criteria2);
            }

            
            
            // dd($data['data']);
            $criteria2['iInvestmentProfileId'] = $data['data']->iInvestmentProfileId;
            $criteria2['eType'] = 'facility';
            $data['investmentBannerImg']=Investment::get_document($criteria2);
            
            $criteria3['iInvestmentProfileId'] = $data['data']->iInvestmentProfileId;
            $data['investmentDocuments']=Investment::get_document($criteria3);

            $criteria3['iInvestmentProfileId'] = $data['data']->iInvestmentProfileId;
            $data['industries'] = Investment::get_industries_data($criteria3);
            $data['location'] = Investment::get_location_data($criteria3);
            
            $data1['iViewCount'] = $data['data']->iViewCount+1;
            $where1 = array();
            $where1['vUniqueCode'] = $code;
            Investment::update_data($where1, $data1);

            $loginSession=session('user');
            if(!empty($loginSession))
            {
                $data['loginUserId']=$loginSession['iUserId'];
                $criteria1['iUserId']=$loginSession['iUserId'];
                
                $data['inInvestorCheckProfile']=Investor::get_by_iUserId($criteria1);
                $data['investor_exist'] = [];
                if (!empty($data['inInvestorCheckProfile'])) {
                    $criteriaInvestorConnection = [
                        'iSenderProfileId' => $data['data']->iInvestmentProfileId,
                        'eSenderProfileType' => 'Investment',
                        'iReceiverProfileId' => $data['inInvestorCheckProfile']->iInvestorProfileId,
                        'eReceiverProfileType' => 'Investor',
                    ];
                    $temp = $this->get_connection_from_other_profiles($criteriaInvestorConnection);
                    if($temp !== null)
                    {
                        $data['investor_exist'][] = $temp;
                    }
                    /* $temp = '';
                    $temp = ($this->get_connection_from_other_profiles($criteriaInvestorConnection))??false;
                    if ($temp) {
                        $data['investor_exist'] = $temp;
                    } */
                    // $data['investor_exist'] = $this->get_connection_from_other_profiles($criteriaInvestorConnection);
                }
                else
                {
                    $data['investor_exist'] = [];
                }
                $data['inAdvisorCheckProfile'] = BusinessAdvisor::get_by_iUserId($criteria1);
                if (!empty($data['inAdvisorCheckProfile'])) {
                    $data['advisor_exist'] = [];
                    $criteriaAdvisorConnection = [
                        'iSenderProfileId' => $data['data']->iInvestmentProfileId,
                        'eSenderProfileType' => 'Investment',
                        'iReceiverProfileId' => $data['inAdvisorCheckProfile']->iAdvisorProfileId,
                        'eReceiverProfileType' => 'Advisor',
                    ];
                    $temp = '';
                    $temp = ($this->get_connection_from_other_profiles($criteriaAdvisorConnection))??false;
                    if ($temp) {
                        $data['advisor_exist'] = $temp;
                    }
                    // $data['advisor_exist'] = $this->get_connection_from_other_profiles($criteriaAdvisorConnection);
                    
                }
                else
                {
                    $data['advisor_exist'] = [];
                }
                /* Profile Visisble Code Start */
                $connection_criteria['iSenderProfileId'] = $data['data']->iInvestmentProfileId;
                $connection_criteria['iReceiverProfileId'] = $data['data']->iInvestmentProfileId;
                // \DB::enableQueryLog();
                $allConnection = Investment::get_connection_by_sender_or_receiver($connection_criteria);
                // dd(\DB::getQueryLog());

                /* If sender and Profile viewer is same  */
                if ($loginSession['iUserId'] == $data['data']->iUserId)
                {
                    $data['profileVisible'] = true;
                    $data['myOwnProfile'] = true;
                }
                
                foreach ($allConnection as $key => $value) {
                    if ($data['profileVisible'] == true)
                    {
                        break;
                    }
                    
                    if (($value->iSenderProfileId == $data['data']->iInvestmentProfileId) && ($loginSession['iUserId'] == $value->iSenderId || $loginSession['iUserId'] == $value->iReceiverId))
                    {
                        $data['profileVisible'] = true;
                    }
                    elseif($value->iReceiverProfileId == $data['data']->iInvestmentProfileId && ($loginSession['iUserId'] == $value->iSenderId || $loginSession['iUserId'] == $value->iReceiverId))
                    {
                        $data['profileVisible'] = true;
                    }
                    else
                    {
                        if ($data['profileVisible'] == false)
                        {
                           foreach ($data['advisor_exist'] as $key_advisor => $value_advisor) {
                                if(isset($value->iSenderProfileId) && isset($value_investment->iSenderProfileId )){
                                    if ($value->iSenderProfileId == $value_advisor->iSenderProfileId || $value->iSenderProfileId == $value_advisor->iReceiverProfileId) {
                                        $data['profileVisible'] = true;
                                        break;
                                    }
                                }
                           }
                        }
                    }
                }
                /* Profile Visisble Code End */
            }
            $data['connection_list'] = $this->connectionList();
            return view('front.investment.detail')->with($data);
        }else{
            return $this->listing();
        }
        
    }

    public function add() 
    {
        // $data['location'] = Investment::get_location();
        $data['countries'] = Country::where(['eIsDeleted' => 'No','eStatus' => 'Active'])->orderBy('vCountry', 'asc')->get();
        $data['industries'] = Industry::get_all_data();
        $data['iTempId']=time();
        return view('front.investment.add')->with($data);
    }

    public function addnew() 
    {
        // $data['location'] = Investment::get_location();
        $data['countries'] = Country::where(['eIsDeleted' => 'No','eStatus' => 'Active'])->orderBy('vCountry', 'asc')->get();
        $data['industries'] = Industry::get_all_data();
        $data['iTempId']=time();
        return view('front.investment.addnew')->with($data);
    }

    public function business_details() 
    {
        $data = array();
        return view('front.investment.business_details')->with($data);
    }

    public function edit($vUniqueCode) 
    {
        $criteria['vUniqueCode'] = $vUniqueCode;
        /* $data['location'] = Investment::get_location(); */
        $data['countries'] = Country::where(['eIsDeleted' => 'No','eStatus' => 'Active'])->get();
        $data['industries'] = Industry::get_all_data();
        $data['investment'] = Investment::get_by_id($criteria);
        $data['selected_memberrole'] = Investment::get_memberrole_data(['iInvestmentProfileId'=>$data['investment']->iInvestmentProfileId]);
        $data['selected_industries'] = Investment::get_industries_data(['iInvestmentProfileId'=>$data['investment']->iInvestmentProfileId]);
        $data['selected_location'] = Investment::get_location_data(['iInvestmentProfileId'=>$data['investment']->iInvestmentProfileId]);
        $data['documents'] = Investment::get_document(['iInvestmentProfileId'=>$data['investment']->iInvestmentProfileId]);
        
/*
echo "<pre>";
print_r($data['countries']);
echo "</pre>";
exit();*/

        return view('front.investment.add')->with($data);
    }

    public function store(Request $request){
        ini_set('memory_limit', -1);

        $data = array();        
        $vUniqueCode = $request->vUniqueCode;
        $legal_entity = $request->legal_entity;
        $data['vUniqueCode'] = $request->vUniqueCode;
        $data['vFirstName'] = $request->vFirstName;
        $data['vLastName'] = $request->vLastName;
        $data['dDob'] = date('Y-m-d',strtotime($request->dDob));
        $data['vEmail'] = $request->vEmail;
        $data['vPhone'] = $request->vPhone;
        $data['vIdentificationNo'] = $request->vIdentificationNo;
        $data['vBusinessName'] = $request->vBusinessName;
        $data['vBusinessEstablished'] = $request->vBusinessEstablished;
        $data['vBusinessProfileName'] = $request->vBusinessProfileName;
        $data['tBusinessProfileDetail'] = $request->tBusinessProfileDetail;
        $data['eBusinessProfile'] = $request->eBusinessProfile;
        $data['eFullSaleBusiness'] = $request->eFullSaleBusiness;
        $data['ePartialSaleBusiness'] = $request->ePartialSaleBusiness;
        $data['eLoanForBusiness'] = $request->eLoanForBusiness;
        $data['eBusinessAsset'] = $request->eBusinessAsset;
        $data['eBailout'] = $request->eBailout;

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
        $data['tRevenueAndFinancials'] = $request->tRevenueAndFinancials;
        $data['tMarketAnalysis'] = $request->tMarketAnalysis;
        $data['vBusinessStage'] = $request->vBusinessStage;
        $data['vWebsiteLink'] = $request->vWebsiteLink;
        
        
        $data['eStatus'] = 'Active';
        $data['eIsDeleted'] = 'No';
        $message = $investment_id = '';
        $loginSession=session('user');
        $loginUserId=$loginSession['iUserId'];
        if(!empty($loginUserId)){
            $data['iUserId']=$loginUserId;
        }

        if(!empty($vUniqueCode))
        {
           $old_image = public_path('uploads/investment/profile/').$request->old_vImage;

            $data['dtUpdatedDate']      = date("Y-m-d h:i:s");
            $where = array();
            $where['vUniqueCode']       = $vUniqueCode;
            Investment::update_data($where, $data);
            $get_id = Investment::get_by_id($where);
            $investment_id = $get_id->iInvestmentProfileId;
            $message = 'Investment updated successfully.';
            
            $explodeDoc=explode(',', $request->documentId);

            foreach ($explodeDoc as $key => $docid) {
                $document_data = [
                    'iInvestmentProfileId' => $investment_id
                ];
             $document_where = ['iInvestmentDocumentId'=> $docid];
             Investment::update_toDocument($document_where,$document_data);
            }

            $iName=strstr($request->industries, '_', true); 
            $iId=substr($request->industries, strpos($request->industries, "_") + 1); 

            $industry_data = [
                'iIndustryId' => $iId,
                'iInvestmentProfileId' => $investment_id,
                'vUniqueCode' => md5(uniqid(time())),
                'vIndustryName' => $iName,
                'dtUpdatedDate' => date("Y-m-d h:i:s"),
            ];
            $industry_where = ['iInvestmentProfileId'=> $investment_id];
            $industry_exist = Investment::get_industries_data(['iInvestmentProfileId'=>$investment_id]);
            if (count($industry_exist) > 0) {
                Investment::update_industry($industry_where,$industry_data);
            }
            if (!empty($request->hasFile('vImage')))
            {
                /* $doc_where = ['iInvestmentProfileId'=> $investment_id];
                Investment::delete_toDocument($doc_where); */
                $request->validate([
                    'vImage' => 'required|mimes:png,jpg,jpeg|max:2048'
                ]);
                $imageName      = time().'.'.$request->vImage->getClientOriginalName();
                $path           = public_path('uploads/investment/profile/'); 
                $request->vImage->move($path, $imageName);
                    $data_temp['vImage']    = $imageName;
                    $data_temp['dtAddedDate'] = date("Y-m-d h:i:s");
                    $data_temp['vUniqueCode'] = md5(uniqid(time()));
                    $data_temp['eType'] = 'profile';
                    $data_temp['iInvestmentProfileId'] = $investment_id;
                    Investment::add_toDocument($data_temp);
            }

            $criteria_delete_location['iInvestmentProfileId'] = $investment_id;
            Investment::delete_locations($criteria_delete_location);

            $location_request['Country'] = explode('_',$request->iCountryId);
            $location_request['Region'] = explode('_',$request->iRegionId);
            $location_request['County'] = explode('_',$request->iCountyId);
            $location_request['Sub County'] = explode('_',$request->iSubCountyId);

            foreach ($location_request as $key => $value) {
                $location_data = [
                    'iLocationId'=>$value[0],
                    'iInvestmentProfileId'=>$investment_id,
                    'vLocationName'=>$value[1],
                    'eLocationType'=>$key,
                    'vUniqueCode' => md5(uniqid(time())),
                    'dtAddedDate' => date('Y-m-d H:i:s')
                ];
                Investment::add_locations($location_data);
            }
            $criteria_delete_memberrole['iInvestmentProfileId'] = $investment_id;
            Investment::delete_memberrole($criteria_delete_memberrole);
        }
        else
        {
            $data['dtAddedDate']        = date("Y-m-d h:i:s");
            $data['vUniqueCode']        = md5(uniqid(time()));
            $data['eAdminApproval']     = 'Pending';
            $investment_id = Investment::add($data);
            $message = 'Investment created successfully.';

            $explodeDoc=explode(',', $request->documentId);

            foreach ($explodeDoc as $key => $docid) {
                $document_data = [
                    'iInvestmentProfileId' => $investment_id
                ];
             $document_where = ['iInvestmentDocumentId'=> $docid];
             Investment::update_toDocument($document_where,$document_data);
            }            

            $data1['vInvestmentDisplayId'] = str_pad($investment_id, 6, "0", STR_PAD_LEFT);
            $data1['dtUpdatedDate']      = date("Y-m-d h:i:s");
            $where1 = array();
            $where1['vUniqueCode']       = $data['vUniqueCode'];
            Investment::update_data($where1, $data1);

            $iName=strstr($request->industries, '_', true); 
            $iId=substr($request->industries, strpos($request->industries, "_") + 1); 
            
            $industry_data = [
                'iIndustryId' => $iId,
                'iInvestmentProfileId' => $investment_id,
                'vUniqueCode' => md5(uniqid(time())),
                'vIndustryName' => $iName,
                'dtAddedDate' => date("Y-m-d h:i:s"),
            ];
            Investment::add_industry($industry_data);

            //for profile upload
            if($request->hasFile('vImage')){
                $imageName = time().'.'.$request->vImage->extension();
                $path = public_path('uploads/investment/profile');
                $request->vImage->move($path, $imageName);
                $data_temp['iInvestmentProfileId'] = $investment_id;
                $data_temp['eType'] = 'profile';
                $data_temp['vImage'] = $imageName;
                
                $data_temp['dtAddedDate'] = date("Y-m-d h:i:s");
                $data_temp['vUniqueCode'] = md5(uniqid(time()));
                Investment::add_toDocument($data_temp);
            }

            $location_request['Country'] = explode('_',$request->iCountryId);
            $location_request['Region'] = explode('_',$request->iRegionId);
            $location_request['County'] = explode('_',$request->iCountyId);
            $location_request['Sub County'] = explode('_',$request->iSubCountyId);

            foreach ($location_request as $key => $value) {
                $location_data = [
                    'iLocationId'=>$value[0],
                    'iInvestmentProfileId'=>$investment_id,
                    'vLocationName'=>$value[1],
                    'eLocationType'=>$key,
                    'vUniqueCode' => md5(uniqid(time())),
                    'dtAddedDate' => date('Y-m-d H:i:s')
                ];
                Investment::add_locations($location_data);
            }
        }
        
        if ($request->vMemberName && !empty($request->vMemberName)) {
            foreach ($request->vMemberName as $key => $vMemberName) {
                if (!empty($vMemberName)) {
                    $member_data = [
                        'iInvestmentProfileId' => $investment_id,
                        'vMemberName' => $vMemberName,
                        'vMemberRole' => $request->vMemberRole[$key],
                        'dtAddedDate' => date("Y-m-d h:i:s"),
                    ];
                    Investment::add_memberrole($member_data);
                }
                
            }

        }
        $payment_setting = GeneralHelper::setting_info('Currency');
        if (!empty($get_id)) {
            if ($get_id->isNewsletterService == 1) {
                $request->isNewsletterService = 0;
            }
            if ($get_id->isSocialMediaService == 1) {
                $request->isSocialMediaService = 0;
            }
        }
        $premium_service = 0;
        $premium_thankyou_service = 4;
        if ($request->isNewsletterService == 1 || $request->isSocialMediaService == 1) {
            
            $amount = 0;
            $count = 0;
            if ($request->isNewsletterService == 1 && isset($payment_setting['NEWSLETTER_SERVICE_PRICE']['vValue'])) {
                $premium_service = 1;
                $premium_thankyou_service = 1;
                $count++;
                $amount += $payment_setting['NEWSLETTER_SERVICE_PRICE']['vValue'];
            }
            if ($request->isSocialMediaService == 1 && isset($payment_setting['SOCIAL_MEDIA_SERVICE_PRICE']['vValue'])) {
                $premium_service = 2;
                $premium_thankyou_service = 2;
                $count++;
                $amount += $payment_setting['SOCIAL_MEDIA_SERVICE_PRICE']['vValue'];
            }
            if ($request->isNewsletterService == 1 && $request->isSocialMediaService == 1) {
                $premium_service = 3;
                $premium_thankyou_service = 3;
            }
            
            if ($amount > 0) {
                if($count == 2) {
                    $amount = $amount - floatval($amount * (20/100));
                }
                return redirect('pesapal/'.$amount.'/'.$premium_service.'/'.$investment_id);
            } else {
                $premium_thankyou_service = base64_encode($premium_thankyou_service);
                return redirect('thank-you/'.$premium_thankyou_service);
                //return redirect()->route('front.dashboard.investmentDashboard')->withSuccess($message);
            }
        } else {
            if(!empty($vUniqueCode))
            {
                return redirect()->route('front.dashboard.investmentDashboard')->withSuccess($message);
            } else {
                $premium_thankyou_service = base64_encode($premium_thankyou_service);
                return redirect('thank-you/'.$premium_thankyou_service);
            }
            
           // 
        }

        /* if ($request->hasFile('file_business_proof')) {
            $path = public_path('uploads/investment/business_proof');
            $this->upload_dropzone_image($path, $request->file_business_proof, $investment_id, 'business_proof');
        }
        if ($request->hasFile('file_fast_verification')) {
            $path = public_path('uploads/investment/fast_verification');
            $this->upload_dropzone_image($path, $request->file_fast_verification, $investment_id, 'fast_verification');
        }
        if ($request->hasFile('file_facility_upload')) {
            $path = public_path('uploads/investment/facility');
            $this->upload_dropzone_image($path, $request->file_facility_upload, $investment_id, 'facility');
        }
        if ($request->hasFile('file_yearly_sales_report')) {
            $path = public_path('uploads/investment/yearly_sales_report');
            $this->upload_dropzone_image($path, $request->file_yearly_sales_report, $investment_id, 'yearly_sales_report');
        }
        if ($request->hasFile('file_NDA_upload')) {
            $path = public_path('uploads/investment/NDA');
            $this->upload_dropzone_image($path, $request->file_NDA_upload, $investment_id, 'NDA');
        } */
        //return redirect()->route('front.dashboard.investmentDashboard')->withSuccess($message);
    }

    public function upload_dropzone_image($path = '',$images = '', $iInvestmentProfileId = '', $type = '') {

        foreach($images as $image) {
            $imageName = uniqid(time()).'.'.$image->extension();
            $image->move($path, $imageName);  
            $data_temp['iInvestmentProfileId'] = $iInvestmentProfileId;
            $data_temp['vUniqueCode'] = md5(uniqid(time()));
            $data_temp['vImage'] = $imageName;
            $data_temp['eType'] = $type;
            $data_temp['dtAddedDate'] = date("Y-m-d h:i:s");
            Investment::add_toDocument($data_temp);
        }
        return true;
    }
    public function review_store(Request $request)
    {
        $iReviewId=$request->iReviewId;
        $vUniqueCode=$request->vUniqueCode;
        $iInvestmentProfileId=$request->iInvestmentProfileId;
        $iUserId=$request->iUserId;
        $star_rating=$request->star_rating;
        $vReview=$request->vReview;
        
        if(!empty($iReviewId))
        {
            $data_review['iRating']                 =$star_rating;
            $data_review['vReview']                 =$vReview;
            $data_review['dtUpdatedDate'] = date("Y-m-d h:i:s");

            $where = array();
            $where['iReviewId'] = $iReviewId;
            Review::update_data($where, $data_review);

            $criteria['iProfileId']=$iInvestmentProfileId;
            $criteria['eProfileType']='Investment';
            $getReview=Review::get_all_data($criteria);

            if(count($getReview) > 0)
            {
                $ratingValues = [];
                foreach ($getReview as $key => $value) 
                {
                     $ratingValues[] = $value->iRating;
                }
                $ratingAverage = round(collect($ratingValues)->sum() / $getReview->count());
                
                $data1['vAverageRating'] = $ratingAverage;
                $where1 = array();
                $where1['vUniqueCode'] = $vUniqueCode;
                Investment::update_data($where1, $data1);
            }
            $notification=['success'," You have successfully updated your review"];

        }else{            
            
            

            $data_review['vUniqueCode']             =$vUniqueCode;
            $data_review['iProfileId']              =$iInvestmentProfileId;
            $data_review['iUserId']                 =$iUserId;
            $data_review['iRating']                 =$star_rating;
            $data_review['vReview']                 =$vReview;
            $data_review['vUniqueCode']             = md5(uniqid(time()));
            $data_review['eProfileType']            = 'Investment';
            $data_review['dtAddedDate'] = date("Y-m-d h:i:s");
            $data_review['dtUpdatedDate'] = date("Y-m-d h:i:s");

            Review::add($data_review);

            $criteria['iProfileId']=$iInvestmentProfileId;
            $criteria['eProfileType']='Investment';
            $getReview=Review::get_all_data($criteria);

            if(count($getReview) > 0)
            {
                $ratingValues = [];
                foreach ($getReview as $key => $value) 
                {
                     $ratingValues[] = $value->iRating;
                }
                $ratingAverage = collect($ratingValues)->sum() / $getReview->count();
                
                $data1['vAverageRating'] = $ratingAverage;
                $where1 = array();
                $where1['vUniqueCode'] = $vUniqueCode;
                Investment::update_data($where1, $data1);
            }
            $notification=['success'," You have successfully added review"];
        }
    
        return redirect()->route('front.investment.detail',$vUniqueCode)->with($notification[0],$notification[1]);
    }
    public function token_store(Request $request)
    {
        $notification = array();
        $vUniqueCode = $request->vUniqueCode;
        $transaction_type = $request->transaction_type;
        $profile_name = $request->profile_name;
        /*$fName = $request->fName;
        $phone = $request->phone;
        $comments = $request->comments;*/
        $term = $request->term;
        $senderProfileType = $request->profileType;
        $senderProfileId = $request->profileId;
        $senderProfileDetail = $request->profileDetail;
        $senderContactName = $request->contactname;

        $session_data = session('user');
        $userId = $session_data['iUserId'];

        $criteria['iUserId']=$userId;
        $userdata= User::get_by_id($criteria);
        $fName=$userdata->vFirstName.' '.$userdata->vLastName;
        $phone=$userdata->vPhone;

        $criteria1['vUniqueCode']=$vUniqueCode;
        $investmentData= Investment::get_by_id($criteria1);
        $comments=$investmentData->vBusinessName;

        $oldToken=$userdata->iTotalToken;

        $user_data['iTotalToken']=$oldToken-1;

        if($oldToken > 0)        
        {
            $user_where = ['iUserId'=> $userId];
            User::update_user($user_where,$user_data);
            // getting receiver data start
            $data['iSenderId'] = $userId;
            $data['iReceiverId'] = $investmentData->iUserId;
            $data['eReceiverProfileType'] = 'Investment';
            $data['eSenderProfileType'] = $senderProfileType;
            $data['iReceiverProfileId'] = $investmentData->iInvestmentProfileId;
            $data['iSenderProfileId'] = $senderProfileId;
            $data['vReceiverProfileTitle'] = $investmentData->vBusinessName;
            $data['vReceiverProfileDetail'] = $investmentData->tBusinessProfileDetail;
            $data['vSenderProfileTitle'] = $fName;
            $data['vSenderProfileDetail'] = $senderProfileDetail;
            $data['vReceiverContactPersonName'] = $investmentData->vFirstName.'-'.$investmentData->vLastName;
            $data['vSenderContactPersonName'] = $senderContactName;
            $data['vReceiverMobNo'] = $investmentData->vPhone;
            $data['vSenderMobNo'] = $phone;
            $data['vMessage'] = $comments;
            $data['eConnectionStatus'] = 'Active';
            $data['dtAddedDate'] = date("Y-m-d h:i:s");

            $receiver_investment_data = Investment::get_by_profile_id('iInvestmentProfileId',$data['iReceiverProfileId']);
            $model = $field_name = $sender_profile_link = '';
            if ($data['eSenderProfileType'] == 'Investor')
            {
                $field_name = 'iInvestorProfileId';
                $request_sender_data = Investor::get_by_profile_id($field_name,$data['iSenderProfileId']);
                $sender_profile_link = route('front.investor.detail',$request_sender_data->vUniqueCode);
            }
            else if ($data['eSenderProfileType'] == 'Advisor')
            {
                $field_name = 'iAdvisorProfileId';
                $request_sender_data = BusinessAdvisor::get_by_profile_id($field_name,$data['iSenderProfileId']);
                $sender_profile_link = route('front.advisor.detail',$request_sender_data->vUniqueCode);
            }
            // $request_sender_data = User::get_by_id($data['iSenderProfileId']);

            
            $criteria = array();
            $criteria['vEmailCode'] = 'INVESTMENT_RECEIVED_REQUEST';
            $email = Systememail::get_email_by_code($criteria);
            $company_setting = GeneralHelper::setting_info('company');
            
            $subject = str_replace("#SYSTEM.COMPANY_NAME#", $company_setting['COMPANY_NAME']['vValue'], $email->vEmailSubject);
            $constant   = array('#sender_profiler_name#','#sender_profile_link#','#SITE_NAME#');
            $value      = array($data['vSenderProfileTitle'],$sender_profile_link,$company_setting['COMPANY_NAME']['vValue']);
            $message = str_replace($constant, $value, $email->tEmailMessage);
            
            $email_data['to']       = $receiver_investment_data->vEmail;
            $email_data['vSandgridTemplateId']       = $email->vSandgridTemplateId;
            $email_data['subject']  = $subject;
            $email_data['msg']      = $message;
            $email_data['dynamic_template_data']      = ['sender_profiler_name' => $data['vSenderProfileTitle'], 'sender_profile_link' => $sender_profile_link];
            $email_data['vFromName']     = $email->vFromName;
            $email_data['from']     = $email->vFromEmail;
            $email_data['company_name']     = $company_setting['COMPANY_NAME']['vValue'];
            
            /*GeneralHelper::send('INVESTMENT_RECEIVED_REQUEST', $email_data);*/
            GeneralHelper::send_email_notifiction('INVESTMENT_RECEIVED_REQUEST', $email_data);
            $email_data['to']       = 'support@pitch-investors.com';
            GeneralHelper::send_email_notifiction('INVESTMENT_RECEIVED_REQUEST', $email_data);
            $connection_id = Connection::add($data);
            // getting receiver data end

            $data2['iUserID']=$userId;
            $data2['iToken']=1;
            $data2['iConnectionId']=$connection_id;
            $data2['dtAddedDate']=date("Y-m-d h:i:s");
            Token::add($data2);
            $notification=['success'," You have successfully connected"];
        }else{
         $notification=['error'," You don't have sufficiant token"];
        }
        return redirect()->route('front.investment.detail',$vUniqueCode)->with($notification[0],$notification[1]);
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
            $data['vFileName']     = $image1;
            $data['vUniqueCode']   = md5(uniqid(time()));
            $data['eType']         = $type;
            $data['dtAddedDate']   = date("Y-m-d h:i:s");
            $lastId = Investment::add_toDocument($data);
        }
        $return_data = ['id' => $lastId];
        return response()->json($return_data);
    }
     public function delete_documents(Request $request)
    {   
        $iInvestmentDocumentId=$request->iInvestmentDocumentId;
        Investment::delete_document_byId($iInvestmentDocumentId);

        $fileName=$request->file_name;
        $action=$request->action;
        if($action == 'beforeSaveDelete'){
            Investment::delete_document_byName($fileName);            
        }
        echo 'true';

    }
    public function get_connection_from_other_profiles($criteriaConnection)
    {
        // return Investment::get_connection($criteriaConnection);
        return Investor::get_connection($criteriaConnection);
    }

    public function get_region_by_country(Request $request)
    {
        $data['region'] = Region::where("iCountryId",$request->country_id)->orderBy('vTitle', 'asc')
                    ->get(["vTitle","iRegionId"]);
        return response()->json($data);
    }

    public function get_county_by_region(Request $request)
    {
        $data['county'] = County::where("iRegionId",$request->region_id)->orderBy('vTitle', 'asc')
                    ->get(["vTitle","iCountyId"]);
        return response()->json($data);
    }

    public function get_sub_county_by_county(Request $request)
    {
        $data['subCounty'] = SubCounty::where("iCountyId",$request->iCountyId)->orderBy('vTitle', 'asc')
                    ->get(["vTitle","iSubCountId"]);
        return response()->json($data);
    }
    public function investment_search($code)
    {
        $data['location']      = Investment::get_location();
        $data['industries']    = Industry::get_all_data([],1,15,true);
        $data['industries1']   = Industry::get_all_data([],16,50,true);
        $data['filterSearch']  = $code;
        
        return view('front.investment.search_listing')->with($data);
    }
    public function ajax_search_listing(Request $request)
    {
        $action = $request->action;
        $sort = $request->sort;
        $type = $request->type;
        if($action == 'sorting')
        {
            if($sort == 'a-z')
            {
                $column='vBusinessProfileName';
                $order='ASC';
            }
            elseif ($sort == 'EBITDA') {
                $column='vProfitMargin';
                $order='Desc';
            }
        }else
        {            
            $column         = "iInvestmentProfileId";
            $order          = "DESC";
        }
       
        
        $criteria = array();
        $criteria['column']         = $column;
        $criteria['order']          = $order;
        $criteria['eIsDeleted']     = 'No';
        $criteria['eAdminApproval'] = 'Approved';

         if($type == 'businesses-for-sale')
        {
            $criteria['interested']='eFullSaleBusiness';
        }
        if($type == 'investment')
        {
            $criteria['interested']='ePartialSaleBusiness';
        }
        if($type == 'opportunities')
        {
            $criteria['interested']='eBailout';
        }if($type == 'businesses-loan')
        {
            $criteria['interested']='eLoanForBusiness';
        }if($type == 'business-assets-for-sale')
        {
            $criteria['interested']='eBusinessAsset';
        }
       
        $transaction_type =  $location = $industry = [];
        if($action == 'search' AND $request->filter != null) {
            
            foreach ($request->filter as $key => $value) {
                if (isset($value['transaction_type'])) {
                    array_push($transaction_type,$value['transaction_type']);
                    // $criteria[$value['transaction_type']] = 'Yes';
                }
                else if (isset($value['location'])) {
                    // array_push($location,$value['location']);
                    $location=$value['location'];
                }
                else if (isset($value['industry'])) {
                    array_push($industry,$value['industry']);
                }
                $criteria['otherField']=$transaction_type;
            }
            $criteria['industry'] = $industry;
            $criteria['location'] = $location;
        }        
        
        $investment_data = Investment::get_all_data($criteria);
        
        $loginSession=session('user');        
        if(!empty($loginSession)){
                $data['loginUserId']=$loginSession['iUserId'];
        }

        $pages = 1;
        if($request->pages != "")
        {
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = count($investment_data);
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
        // \DB::enableQueryLog();

        $data['total_record']=$paginator->total;
        $data['data'] = Investment::get_all_data($criteria, $start, $limit, $paging, true);
        // dd(\DB::getQueryLog());

        $criteria2=array();
        foreach ($data['data'] as $key => $value) 
        {
            $criteria2['iInvestmentProfileId'] = $value->iInvestmentProfileId;
            $data['location'][] = Investment::get_location_data($criteria2);
            $data['industries'][] = Investment::get_industries_data($criteria2);
        }
        $data['paging'] = $paginator->paginate();
        // dd($data);
        return view('front.investment.ajax_search_listing')->with($data);
    }
}
