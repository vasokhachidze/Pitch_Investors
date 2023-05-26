<?php
namespace App\Http\Controllers\front\investor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\front\investor\Investor;
use App\Models\admin\industry\Industry;
use App\Models\front\investment\Investment;
use App\Models\front\advisor\BusinessAdvisor;
use App\Models\front\user\User;
use App\Models\front\token\Token;
use App\Models\front\connection\Connection;
use App\Models\admin\country\Country;
use App\Models\admin\region\Region;
use App\Models\admin\county\County;
use App\Models\admin\subcounty\SubCounty;
use App\Models\front\chat\Chat;
use App\Helper\GeneralHelper;
use App\Models\front\systememail\Systememail;
use App\Models\front\review\review;


use App\Libraries\Paginator;

class InvestorController extends Controller
{
    public function listing() {
        $data['location'] = Investor::get_location();
        $data['industries'] = Industry::get_all_data([],1,15,true);
        $data['industries1'] = Industry::get_all_data([],16,50,true);
        $data['Region'] = Region::where(['eIsDeleted' => 'No','eStatus' => 'Active'])->get();
        
        return view('front.investor.listing')->with($data);
    }

    public function ajax_listing(Request $request)
    {
        $action = $request->action;
        $sort = $request->sort;
        if($action == 'sorting')
        {
            if($sort == 'a-z')
            {
                $column='vInvestorProfileName';
                $order='ASC';
            }    
        }else
        {            
            $column         = "iInvestorProfileId";
            $order          = "DESC";
        }

        $criteria = array();
        $criteria['column']         = $column;
        $criteria['order']          = $order;
        $criteria['eStatus']        = 'Active';
        $criteria['eAdminApproval'] = 'Approved';

        $transaction_type =  $iRegionId = $iCountyId = $iSubCountyId  = $industry = [];
        if($action == 'search' AND $request->filter != null) {
            
            foreach ($request->filter as $key => $value) 
            {
                if (isset($value['transaction_type'])) {
                    array_push($transaction_type,$value['transaction_type']);
                    //$criteria[$value['transaction_type']] = 'Yes';
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

        $user_data = Investor::get_all_data($criteria);
   
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
        
        $data['total_record']=$paginator->total;
        $data['data'] = Investor::get_all_data($criteria, $start, $limit, $paging,true);
        
        $criteria2=array();
        foreach ($data['data'] as $key => $value) 
        {
            $criteria2['iInvestorProfileId'] = $value->iInvestorProfileId;        
            $data['location'][] = Investor::get_location_data($criteria2);
            $data['industries'][] = Investor::get_industries_data($criteria2);
        }

        $data['paging'] = $paginator->paginate();
        return view('front.investor.ajax_listing')->with($data);       

    }
    
   
    public function review_store(Request $request)
    {
        $iReviewId=$request->iReviewId;
        $vUniqueCode=$request->vUniqueCode;
        $iInvestorProfileId=$request->iInvestorProfileId;
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

            $criteria['iProfileId']=$iInvestorProfileId;
            $criteria['eProfileType']='Investor';
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
                Investor::update_data($where1, $data1);
            }
            $notification=['success'," You have successfully updated your review"];
        }else
        {
            $data_review['vUniqueCode']             =$vUniqueCode;
            $data_review['iProfileId']              =$iInvestorProfileId;
            $data_review['iUserId']                 =$iUserId;
            $data_review['iRating']                 =$star_rating;
            $data_review['vReview']                 =$vReview;
            $data_review['vUniqueCode']             = md5(uniqid(time()));
            $data_review['eProfileType']            = 'Investor';
            $data_review['dtAddedDate'] = date("Y-m-d h:i:s");
            $data_review['dtUpdatedDate'] = date("Y-m-d h:i:s");

            Review::add($data_review);

            $criteria['iProfileId']=$iInvestorProfileId;
            $criteria['eProfileType']='Investor';
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
                Investor::update_data($where1, $data1);
            }
            $notification=['success'," You have successfully added review"];
        }
       
    
        return redirect()->route('front.investor.detail',$vUniqueCode)->with($notification[0],$notification[1]);
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

    public function detail($code) 
    {
        $session_data = session('user');
        

        $criteria = array();
        $data['profileVisible'] = false;
        $data['myOwnProfile'] = false;
        $criteria['vUniqueCode']=$code;
        $criteria['eAdminApproval'] = 'Approved';
        
        $data['data'] = Investor::get_by_id($criteria);
        if(isset($data['data']))
        {
        $criteria2['iInvestorProfileId'] = $data['data']->iInvestorProfileId;
        $data['industries'] = Investor::get_industries_data($criteria2);
        /*$data['location'] = Investor::get_location_data($criteria2);*/
        $data['countries'] = Country::get();

        $criteria['iProfileId']=$data['data']->iInvestorProfileId;        
        $criteria['eProfileType']='Investor';
        $data['review_data']=Review::get_all_data_with_user($criteria);
        if(!empty($session_data))
       {
            $loginUser=$session_data['iUserId'];
            $criteria2['iProfileId']=$data['data']->iInvestorProfileId;
            $criteria2['iUserId']=$loginUser;
            $criteria2['eProfileType']='Investor';
            $data['my_review_data']=Review::get_all_data_with_loginuser($criteria2);
        }
      
        $data1['iViewCount'] = $data['data']->iViewCount+1;
        $where1 = array();
        $where1['vUniqueCode'] = $code;
        Investor::update_data($where1, $data1);

        $loginSession=session('user');
        if(!empty($loginSession))
        {
            $data['loginUserId']=$loginSession['iUserId'];
            $criteria1['iUserId']=$loginSession['iUserId'];

            $data['inInvestmentCheckProfile']=Investment::get_by_iUserId($criteria1);
            
            if (!empty($data['inInvestmentCheckProfile'])) {
                $data['investment_exist'] = [];
                $temp1 = [];
                foreach ($data['inInvestmentCheckProfile'] as $investment_key => $investment_value) {
                    $criteriaInvestmentConnection = [
                        'iSenderProfileId' => $data['data']->iInvestorProfileId,
                        'eSenderProfileType' => 'Investor',
                        'iReceiverProfileId' => $investment_value->iInvestmentProfileId,
                        'eReceiverProfileType' => 'Investment',
                    ];
                    
                    // $data['investment_exist'][] = $this->get_connection_from_other_profiles($criteriaInvestmentConnection);
                    
                    $temp = $this->get_connection_from_other_profiles($criteriaInvestmentConnection);
                    if($temp !== null)
                    {
                        $data['investment_exist'][] = $temp;
                    }
                }
            }
            else
            {
                $data['investment_exist'] = [];
            }
            // dd($data['investment_exist']);
            $data['inAdvisorCheckProfile']=BusinessAdvisor::get_by_iUserId($criteria1);
            if (!empty($data['inAdvisorCheckProfile'])) {
                $data['investor_exist'] = [];
                $criteriaAdvisorConnection = [
                    'iSenderProfileId' => $data['data']->iInvestorProfileId,
                    'eSenderProfileType' => 'Investor',
                    'iReceiverProfileId' => $data['inAdvisorCheckProfile']->iAdvisorProfileId,
                    'eReceiverProfileType' => 'Advisor',
                ];
                $temp = '';
                $temp = ($this->get_connection_from_other_profiles($criteriaAdvisorConnection))??false;
                if ($temp) {
                    $data['investor_exist'] = $temp;
                }
                // $data['investor_exist'] = $this->get_connection_from_other_profiles($criteriaAdvisorConnection);
            }
            else
            {
                $data['investor_exist'] = [];
            }

            /* Profile Visisble Code Start */
            $connection_criteria['iSenderProfileId'] = $data['data']->iInvestorProfileId;
            $connection_criteria['iReceiverProfileId'] = $data['data']->iInvestorProfileId;
            $allConnection = Investor::get_connection_by_sender_or_receiver($connection_criteria);

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

                if (($value->iSenderProfileId == $data['data']->iInvestorProfileId) && ($loginSession['iUserId'] == $value->iSenderId || $loginSession['iUserId'] == $value->iReceiverId))
                {
                    $data['profileVisible'] = true;
                }
                elseif(($value->iReceiverProfileId == $data['data']->iInvestorProfileId) && ($loginSession['iUserId'] == $value->iSenderId || $loginSession['iUserId'] == $value->iReceiverId))
                {
                    $data['profileVisible'] = true;
                }
                else
                {
                    if ($data['profileVisible'] == false)
                    {
                        foreach ($data['investor_exist'] as $key_advisor => $value_advisor)
                        {  
                            if($value->iSenderProfileId == $value_advisor->iSenderProfileId || $value->iSenderProfileId == $value_advisor->iReceiverProfileId)
                            {
                                $data['profileVisible'] = true;
                                break;
                            }
                        }
                        if (($value->iSenderProfileId == $data['data']->iInvestorProfileId) && ($loginSession['iUserId'] == $value->iSenderId || $loginSession['iUserId'] == $value->iReceiverId))
                        {
                            $data['profileVisible'] = true;
                        }   
                       foreach ($data['investment_exist'] as $key_investment => $value_investment)
                       {   
                            if(isset($value->iSenderProfileId) && isset($value_investment->iSenderProfileId )){
                                if ($value->iSenderProfileId == $value_investment->iSenderProfileId || $value->iSenderProfileId == $value_investment->iReceiverProfileId)
                                {
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
        return view('front.investor.detail')->with($data);
         }else{
            return $this->listing();
        }
    }

    public function get_connection_from_other_profiles($criteriaConnection)
    {
        return Investor::get_connection($criteriaConnection);
    }

    public function add() 
    {
        $criteria = array();
        /* $criteria["iCountryId"] = 110; // Kenya  */
        $criteria["eStatus"] = 'Active';
        $criteria["eIsDeleted"] = 'No';
        $data['industries'] = Industry::get_all_data();
        $data['countries'] = Country::get();
        // dd($data['countries']);
        /* $data['location'] = Investor::get_location(); */
        /* $data['countries'] = Country::get_country_code($criteria); */
        $data['subRegion'] = SubCounty::get_all_data($criteria);
        
        $session_data = session('user');
        $userId = $session_data['iUserId'];

        $criteria['iUserId']=$userId;
        $data['loginuserdata']= User::get_by_id($criteria);
        $data['iTempId']=time();
        return view('front.investor.add')->with($data);
    }

    public function edit($vUniqueCode)
    {
        $criteria = array();
        $criteria["vUniqueCode"] = $vUniqueCode;
        /* $criteria["iCountryId"] = 110; */ /* Kenya */
        $data['investor'] = Investor::get_by_id($criteria);
        $data['industries'] = Industry::get_all_data();
        $data['location'] = Investor::get_location();
        $data['image_data'] = Investor::get_image_id(['iInvestorProfileId' => $data['investor']->iInvestorProfileId]);
        /* $data['countries'] = Country::get_country_code($criteria); */
        $data['countries'] = Country::get();
        $data['subRegion'] = SubCounty::get_all_data($criteria);

        $data['selected_industries'] = Investor::get_industries_data(['iInvestorProfileId'=>$data['investor']->iInvestorProfileId]);
        $data['selected_location'] = Investor::get_location_data(['iInvestorProfileId'=>$data['investor']->iInvestorProfileId]);
        // dd($data['location']);
        
        return view('front.investor.add')->with($data);
    }

    public function store(Request $request)
    {
        ini_set('memory_limit', -1);
        $data = array();
        $message = $investor_id = '';
        $vUniqueCode = $request->vUniqueCode;
        $data['vProfileTitle']          = $request->vProfileTitle;
        $data['vFirstName']             = $request->vFirstName;
        $data['vLastName']              = $request->vLastName;
        $data['vEmail']                 = $request->vEmail;
        $data['dDob']                   = date('Y-m-d',strtotime($request->dDob));
        $data['vPhone']                 = $request->vPhone;
        $data['eAdvisorGuide']          = $request->eAdvisorGuide;
        $data['iNationality']           = $request->iNationality;
        $data['iCity']                  = $request->iCity;
        $data['vAddress']               = $request->vAddress;
        $data['eInvestorType']          = $request->eInvestorType;
        $data['eInvestingExp']          = $request->eInvestingExp;
        $data['vIdentificationNo']      = $request->vIdentificationNo;
        $data['vWhenInvest']            = $request->vWhenInvest;
        $data['eAcquiringBusiness']     = $request->eAcquiringBusiness;
        $data['eInvestingInBusiness']   = $request->eInvestingInBusiness;
        $data['eLendingToBusiness']     = $request->eLendingToBusiness;
        $data['eBuyingProperty']        = $request->eBuyingProperty;
        $data['eCorporateInvestor']     = $request->eCorporateInvestor;
        $data['eVentureCapitalFirms']   = $request->eVentureCapitalFirms;
        $data['ePrivateEquityFirms']    = $request->ePrivateEquityFirms;
        $data['eFamilyOffices']         = $request->eFamilyOffices;

        $data['vHowMuchInvest']         = $request->vHowMuchInvest;
        $data['tFactorsInBusiness']     = $request->tFactorsInBusiness;
        $data['tAboutCompany']          = $request->tAboutCompany;
        $data['vCompanyWebsite']        = $request->vCompanyWebsite;
        $data['vInvestorProfileName']        = $request->vInvestorProfileName;
        $data['tInvestorProfileDetail']        = $request->tInvestorProfileDetail;
        $data['eStatus']                = 'Active';
        $data['eIsDeleted'] = 'No';
        

        $message = $investor_id = '';
        $loginSession=session('user');
        $loginUserId=$loginSession['iUserId'];
        if(!empty($loginUserId)){
            $data['iUserId']=$loginUserId;
        }

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

           
            /* $doc_where = ['iInvestorProfileId'=> $investor_id];
            Investor::delete_toDocument($doc_where); */

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

            /* Start Location store */
            /* $criteria_delete_location['iInvestorProfileId'] = $investor_id;
            Investor::delete_locations($criteria_delete_location);

            $location_request['Country'] = explode('_',$request->iCountryId);
            $location_request['Region'] = explode('_',$request->iRegionId);
            $location_request['County'] = explode('_',$request->iCountyId);
            $location_request['Sub County'] = explode('_',$request->iSubCountyId);

            foreach ($location_request as $key => $value) {
                $location_data = [
                    'iLocationId'=>$value[0],
                    'iInvestorProfileId'=>$investor_id,
                    'vLocationName'=>$value[1],
                    'eLocationType'=>$key,
                    'vUniqueCode' => md5(uniqid(time())),
                    'dtAddedDate' => date('Y-m-d H:i:s')
                ];
                Investor::add_locations($location_data);
            } */
            /* End Location store */
        }
        else
        {
            $data['dtAddedDate']        = date("Y-m-d h:i:s");
            $data['vUniqueCode']        = md5(uniqid(time()));
            $data['eAdminApproval']     = 'Pending';
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
            
            /* Start Location store */
            /* $location_request['Country'] = explode('_',$request->iCountryId);
            $location_request['Region'] = explode('_',$request->iRegionId);
            $location_request['County'] = explode('_',$request->iCountyId);
            $location_request['Sub County'] = explode('_',$request->iSubCountyId);

            foreach ($location_request as $key => $value) {
                $location_data = [
                    'iLocationId'=>$value[0],
                    'iInvestorProfileId'=>$investor_id,
                    'vLocationName'=>$value[1],
                    'eLocationType'=>$key,
                    'vUniqueCode' => md5(uniqid(time())),
                    'dtAddedDate' => date('Y-m-d H:i:s')
                ];
                Investor::add_locations($location_data);
            } */
            /* End Location store */

            /* if ($request->hasFile('file_identification_photo')) {
                $path = public_path('uploads/investor/identification_photo');
                $this->upload_dropzone_image($path, $request->file_identification_photo, $investor_id, 'identification_photo');
            }
            if ($request->hasFile('file_company_document')) {
                $path = public_path('uploads/investor/company_document');
                $this->upload_dropzone_image($path, $request->file_company_document, $investor_id, 'company_document');
            } */
        }
        return redirect()->route('front.dashboard.investorDashboard')->withSuccess($message);
    }

    public function upload_dropzone_image($path = '',$images = '', $iInvestorProfileId = '', $type = '')
    {
        foreach($images as $image) {
            $imageName = uniqid(time()).'.'.$image->extension();
            $image->move($path, $imageName);  
            $data_temp['iInvestorProfileId'] = $iInvestorProfileId;
            $data_temp['vUniqueCode'] = md5(uniqid(time()));
            $data_temp['vImage'] = $imageName;
            $data_temp['eType'] = $type;
            $data_temp['dtAddedDate'] = date("Y-m-d h:i:s");
            Investor::add_toDocument($data_temp);
        }
        return true;
    }
    
    public function token_store(Request $request)
    {
        // dd($request);
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
        $senderContactName = $request->contactname;

        $session_data = session('user');
        $userId = $session_data['iUserId'];

        $criteria['iUserId']=$userId;
        $userdata= User::get_by_id($criteria);
        $fName=$userdata->vFirstName.' '.$userdata->vLastName;
        $phone=$userdata->vPhone;

        $criteria1['vUniqueCode']=$vUniqueCode;
        $investorData= Investor::get_by_id($criteria1);
        $comments=$investorData->vProfileTitle;

        $oldToken=$userdata->iTotalToken;
        $user_data['iTotalToken']=$oldToken-1;

        if($oldToken > 0)
        {
            $user_where = ['iUserId'=> $userId];
            User::update_user($user_where,$user_data);

            // getting receiver data start
            $data['iSenderId'] = $userId;
            $data['iReceiverId'] = $investorData->iUserId;
            $data['eReceiverProfileType'] = 'Investor';
            $data['eSenderProfileType'] = $senderProfileType;
            $data['iReceiverProfileId'] = $investorData->iInvestorProfileId;
            $data['iSenderProfileId'] = $senderProfileId;
            $data['vReceiverProfileTitle'] = $investorData->vProfileTitle;
            $data['vSenderProfileTitle'] = $fName;
            $data['vReceiverContactPersonName'] = $investorData->vFirstName.'-'.$investorData->vLastName;
            $data['vSenderContactPersonName'] = $senderContactName;
            $data['vReceiverMobNo'] = $investorData->vPhone;
            $data['vSenderMobNo'] = $phone;
            $data['vMessage'] = $comments;
            $data['eConnectionStatus'] = 'Hold';
            $data['dtAddedDate'] = date("Y-m-d h:i:s");            
            $connection_id = Connection::add($data);
            // getting receiver data end

            $data2['iUserID']=$userId;
            $data2['iToken']=1;
            $data2['iConnectionId']=$connection_id;
            $data2['dtAddedDate']=date("Y-m-d h:i:s");

            $receiver_investor_data = Investor::get_by_profile_id('iInvestorProfileId',$data['iReceiverProfileId']);

            $model = $field_name = $sender_profile_link = '';
            if ($data['eSenderProfileType'] == 'Investment')
            {
                $field_name = 'iInvestmentProfileId';
                $request_sender_data = Investment::get_by_profile_id($field_name,$data['iSenderProfileId']);
                $sender_profile_link = route('front.investment.detail',$request_sender_data->vUniqueCode);
            }
            else if ($data['eSenderProfileType'] == 'Advisor')
            {
                $field_name = 'iAdvisorProfileId';
                $request_sender_data = BusinessAdvisor::get_by_profile_id($field_name,$data['iSenderProfileId']);
                $sender_profile_link = route('front.advisor.detail',$request_sender_data->vUniqueCode);
            }
            // $request_sender_data = User::get_by_id($data['iSenderProfileId']);

            /* EMAIL To User Register */
            $criteria = array();
            $criteria['vEmailCode'] = 'INVESTOR_RECEIVED_REQUEST';
            $email = Systememail::get_email_by_code($criteria);
            $company_setting = GeneralHelper::setting_info('company');
            
            $subject = str_replace("#SYSTEM.COMPANY_NAME#", $company_setting['COMPANY_NAME']['vValue'], $email->vEmailSubject);
            $constant   = array('#sender_profiler_name#','#sender_profile_link#','#SITE_NAME#');
            $value      = array($data['vSenderProfileTitle'],$sender_profile_link,$company_setting['COMPANY_NAME']['vValue']);
            $message = str_replace($constant, $value, $email->tEmailMessage);
            
            $email_data['to']       = $receiver_investor_data->vEmail;
            $email_data['vSandgridTemplateId']       = $email->vSandgridTemplateId;
            $email_data['subject']  = $subject;
            $email_data['msg']      = $message;
            $email_data['dynamic_template_data']      = ['sender_profiler_name' => $data['vSenderProfileTitle'], 'sender_profile_link' => $sender_profile_link];
            $email_data['vFromName']     = $email->vFromName;
            $email_data['from']     = $email->vFromEmail;
            $email_data['company_name']     = $company_setting['COMPANY_NAME']['vValue'];
            /*GeneralHelper::send('INVESTOR_RECEIVED_REQUEST', $email_data);*/
            GeneralHelper::send_email_notifiction('INVESTOR_RECEIVED_REQUEST', $email_data);
            /* EMAIL To User Register*/

            Token::add($data2);
            $notification=['success'," You have successfully connected"];
        }else{
         $notification=['error'," You don't have sufficiant token"];
        }
        return redirect()->route('front.investor.detail',$vUniqueCode)->with($notification[0],$notification[1]);
    }
    public function upload(Request $request) 
    {

        ini_set('memory_limit', -1);
        
        $lastId='';
        // $iTempId=$request->iTempId;
        
        foreach($_FILES as $image) 
        {
            $image1 = $image['name'];
            $type = $request->type;
            $extension = pathinfo($image1, PATHINFO_EXTENSION);
            $imageName = md5(RAND(1,999)).time().'.'.$extension;
            $destination_path = public_path('uploads/investor/'.$type.'/'.$imageName);
            move_uploaded_file($image['tmp_name'],$destination_path);
    
            $data['vImage']        = $imageName;
            $data['vFileName']     = $image1;
            $data['vUniqueCode'] = md5(uniqid(time()));
            $data['eType']        = $type;
            $data['dtAddedDate'] = date("Y-m-d h:i:s");
            $lastId = Investor::add_toDocument($data);
        }
        $return_data = ['id' => $lastId];
        return response()->json($return_data);
    }
    public function delete_documents(Request $request)
    {
        $iInvestorDocId=$request->iInvestorDocId;
        Investor::delete_document_byId($iInvestorDocId);
        echo 'true';

        $fileName=$request->file_name;
        $action=$request->action;
        if($action == 'beforeSaveDelete'){
            Investor::delete_document_byName($fileName);            
        }
    }
    public function investor_search($code)
    {
        $data['location'] = BusinessAdvisor::get_location();
        $data['industries'] = Industry::get_all_data([],1,15,true);
        $data['industries1'] = Industry::get_all_data([],16,50,true);
        $data['filterSearch']  = $code;
        return view('front.investor.search_listing')->with($data);
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
                $column='vInvestorProfileName';
                $order='ASC';
            }    
        }else
        {            
            $column         = "iInvestorProfileId";
            $order          = "DESC";
        }

        $criteria = array();
        $criteria['column']         = $column;
        $criteria['order']          = $order;
        $criteria['eStatus']        = 'Active';
        $criteria['eAdminApproval'] = 'Approved';
        
        if($type == 'individual-investors')
        {
            $criteria['eInvestorType']='Individual';
        } 
        if($type == 'business-buyers')
        {
            $criteria['interested']='eAcquiringBusiness';
        }
        if($type == 'corporate-investors')
        {
            $criteria['interested']='eCorporateInvestor';
        }if($type == 'venture-capital-firms')
        {
            $criteria['interested']='eVentureCapitalFirms';
        }if($type == 'private-equity-firms')
        {
            $criteria['interested']='ePrivateEquityFirms';
        }if($type == 'family-offices')
        {
            $criteria['interested']='eFamilyOffices';
        }if($type == 'business-lenders')
        {
            $criteria['interested']='eLendingToBusiness';
        }

        $transaction_type =  $location = $industry = [];
        if($action == 'search' AND $request->filter != null) 
        {
            
            foreach ($request->filter as $key => $value) 
            {
                if (isset($value['transaction_type'])) {
                    array_push($transaction_type,$value['transaction_type']);
                    //$criteria[$value['transaction_type']] = 'Yes';
                }
                else if (isset($value['location'])) {
                    /*array_push($location,$value['location']);*/
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

        $user_data = Investor::get_all_data($criteria);
   
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
        
        $data['total_record']=$paginator->total;
        $data['data'] = Investor::get_all_data($criteria, $start, $limit, $paging,true);
        
        $criteria2=array();
        foreach ($data['data'] as $key => $value) 
        {
            $criteria2['iInvestorProfileId'] = $value->iInvestorProfileId;        
            $data['location'][] = Investor::get_location_data($criteria2);
            $data['industries'][] = Investor::get_industries_data($criteria2);
        }

        $data['paging'] = $paginator->paginate();
        return view('front.investor.ajax_search_listing')->with($data);       

    }
    
}
