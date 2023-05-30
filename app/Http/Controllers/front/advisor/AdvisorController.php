<?php
namespace App\Http\Controllers\front\advisor;

use App\Http\Controllers\Controller;
use App\Libraries\Paginator;
use App\Models\admin\industry\Industry;
use App\Models\front\advisor\BusinessAdvisor;
use Illuminate\Http\Request;
use App\Models\front\user\User;
use App\Models\front\token\Token;
use App\Models\front\connection\Connection;
use App\Models\admin\country\Country;
use App\Models\admin\region\Region;
use App\Models\admin\county\County;
use App\Models\admin\subcounty\SubCounty;

use App\Models\front\investment\Investment;
use App\Models\front\investor\Investor;
use App\Models\front\chat\Chat;
use App\Helper\GeneralHelper;
use App\Models\front\systememail\Systememail;
use App\Models\front\review\review;


use Illuminate\Support\Facades\Storage;

class AdvisorController extends Controller
{
    public function listing()
    {
        $data['location'] = BusinessAdvisor::get_location();
        $data['industries'] = Industry::get_all_data([],1,15,true);
        $data['industries1'] = Industry::get_all_data([],16,50,true);
        $data['Region'] = Region::where(['eIsDeleted' => 'No','eStatus' => 'Active'])->get();
        return view('front.advisor.listing')->with($data);
    }

    public function ajax_listing(Request $request)
    {
        $action = $request->action;
        $sort = $request->sort;
        if ($action == 'sorting') {
            if ($sort == 'a-z') {
                $column = 'vAdvisorProfileTitle';
                $order = 'ASC';
            }
        } else {
            $column = "iAdvisorProfileId";
            $order = "DESC";
        }
        $criteria = array();
        $criteria['column'] = $column;
        $criteria['order'] = $order;
        $criteria['eStatus'] = 'Active';
        $criteria['eAdminApproval'] = 'Approved';

        $iRegionId = $iCountyId = $iSubCountyId = $industry = [];
        if($action == 'search' AND $request->filter != null) {     
            foreach ($request->filter as $key => $value) {
                // if (isset($value['location'])) {
                //     array_push($location,$value['location']);
                //     // $location=$value['location'];
                // }
                if (isset($value['iRegionId'])) 
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
            }

            $criteria['industry'] = $industry;
            $criteria['iRegionId'] = $iRegionId;
            $criteria['iCountyId'] = $iCountyId;
            $criteria['iSubCountyId'] = $iSubCountyId;
        }
        $investor_data = BusinessAdvisor::get_all_data($criteria);
        $loginSession=session('user');        
        if(!empty($loginSession)){
                $data['loginUserId']=$loginSession['iUserId'];
        }

        $pages = 1;
        if ($request->pages != "") {
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = count($investor_data);
        $start = ($paginator->currentPage - 1) * $paginator->itemsPerPage;
        $limit = $paginator->itemsPerPage;
        if ($request->limit_page != '') {
            $per_page = $request->limit_page;
            $paginator->itemsPerPage = $per_page;
            $paginator->range = $per_page;
            $limit = $per_page;
        }
        $paginator->is_ajax = true;
        $paging = true;

        $data['total_record']=$paginator->total;
        $data['data'] = BusinessAdvisor::get_all_data($criteria, $start, $limit, $paging, true);
        // dd($data['data']);

        $criteria2 = array();
        foreach ($data['data'] as $key => $value) {
            $criteria2['iAdvisorProfileId'] = $value->iAdvisorProfileId;
            $data['location'][] = BusinessAdvisor::get_location_data($criteria2);
            $data['industries'][] = BusinessAdvisor::get_industries_data($criteria2);
        }
        $data['paging'] = $paginator->paginate();
        return view('front.advisor.ajax_listing')->with($data);
    }
   
    public function review_store(Request $request)
    {   
        $iReviewId=$request->iReviewId;
        $vUniqueCode=$request->vUniqueCode;
        $iAdvisorProfileId=$request->iAdvisorProfileId;
        $iUserId=$request->iUserId;
        $star_rating=$request->star_rating;
        $vReview=$request->vReview;

        if(!empty($iReviewId))
        {
            $iAdvisorProfileId=$request->iAdvisorProfileId;

            $data_review['iRating']                 =$star_rating;
            $data_review['vReview']                 =$vReview;
            $data_review['dtUpdatedDate'] = date("Y-m-d h:i:s");

            $where = array();
            $where['iReviewId'] = $iReviewId;
            Review::update_data($where, $data_review);

            $criteria['iProfileId']=$iAdvisorProfileId;
            $criteria['eProfileType']='Advisor';
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
                BusinessAdvisor::update_data($where1, $data1);
            }
            $notification=['success'," You have successfully updated your review"];
        }else{
            $data_review['vUniqueCode']             =$vUniqueCode;
            $data_review['iProfileId']              =$iAdvisorProfileId;
            $data_review['iUserId']                 =$iUserId;
            $data_review['iRating']                 =$star_rating;
            $data_review['vReview']                 =$vReview;
            $data_review['vUniqueCode']             = md5(uniqid(time()));
            $data_review['eProfileType']            = 'Advisor';
            $data_review['dtAddedDate'] = date("Y-m-d h:i:s");
            $data_review['dtUpdatedDate'] = date("Y-m-d h:i:s");

            Review::add($data_review);
            $criteria['iProfileId']=$iAdvisorProfileId;
            $criteria['eProfileType']='Advisor';
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
                BusinessAdvisor::update_data($where1, $data1);
            }
            $notification=['success'," You have successfully added review"];
        }    
        return redirect()->route('front.advisor.detail',$vUniqueCode)->with($notification[0],$notification[1]);
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

        $data['profileVisible'] = false;
        $data['myOwnProfile'] = false;
        $criteria = array();
        $criteria['vUniqueCode'] = $code;
        $criteria['eAdminApproval'] = 'Approved';
        $data['data'] = BusinessAdvisor::get_by_id($criteria);
        if(isset($data['data']))
        {
            $criteria2['iAdvisorProfileId'] = $data['data']->iAdvisorProfileId;
            $data['industries'] = BusinessAdvisor::get_industries_data($criteria2);
            $data['location'] = BusinessAdvisor::get_location_data($criteria2);
            $criteria['iProfileId']=$data['data']->iAdvisorProfileId;
            $criteria['eProfileType']='Advisor';
            $data['review_data']=Review::get_all_data_with_user($criteria);
        if(!empty($session_data))
        {
            $loginUser=$session_data['iUserId'];
            $criteria2['iProfileId']=$data['data']->iAdvisorProfileId;
            $criteria2['iUserId']=$loginUser;
            $criteria2['eProfileType']='Advisor';
            $data['my_review_data']=Review::get_all_data_with_loginuser($criteria2);
        }

        $data1['iViewCount'] = $data['data']->iViewCount+1;
        $where1 = array();
        $where1['vUniqueCode'] = $code;
        BusinessAdvisor::update_data($where1, $data1);
        // dd($data['data']);

        $loginSession=session('user');
        if(!empty($loginSession))
        {
            $data['loginUserId']=$loginSession['iUserId'];
            $criteria1['iUserId']=$loginSession['iUserId'];

            $data['inInvestmentCheckProfile']=Investment::get_by_iUserId($criteria1);
            if (!empty($data['inInvestmentCheckProfile']))
            {
                $data['investment_exist'] = [];
                foreach ($data['inInvestmentCheckProfile'] as $investment_key => $investment_value) {
                    $criteriaInvestmentConnection = [
                        /* 'loginUserId' => $loginSession['iUserId'],
                        'iAdvisorProfileId' => $data['data']->iAdvisorProfileId, */
                        'iSenderProfileId' => $data['data']->iAdvisorProfileId,
                        'eSenderProfileType' => 'Advisor',
                        'iReceiverProfileId' => $investment_value->iInvestmentProfileId,
                        'eReceiverProfileType' => 'Investment',
                    ];
                    $temp = $this->get_connection_from_other_profiles($criteriaInvestmentConnection);
                    if($temp !== null)
                    {
                        $data['investment_exist'][] = $temp;
                    }
                    // $data['investment_exist'][] = ($this->get_connection_from_other_profiles($criteriaInvestmentConnection))??false;
                    /* $temp = '';
                    $temp = ($this->get_connection_from_other_profiles($criteriaInvestmentConnection))??false;
                    if ($temp) {
                        $data['investment_exist'][] = $temp;
                    } */
                }
            }
            else
            {
                $data['investment_exist'] = [];
            }

            $data['inInvestorCheckProfile']=Investor::get_by_iUserId($criteria1);
            
            if (!empty($data['inInvestorCheckProfile'])) {
                $data['advisor_exist'] = [];
                $criteriaInvestorConnection = [
                    'iSenderProfileId' => $data['data']->iAdvisorProfileId,
                    'eSenderProfileType' => 'Advisor',
                    'iReceiverProfileId' => $data['inInvestorCheckProfile']->iInvestorProfileId,
                    'eReceiverProfileType' => 'Investor',
                ];
                $temp = '';
                $temp = ($this->get_connection_from_other_profiles($criteriaInvestorConnection))??false;
                if ($temp) {
                    $data['advisor_exist'][] = $temp;
                }
            }
            else
            {
                $data['advisor_exist'] = [];
            }

            /* Profile Visisble Code Start */
            $connection_criteria['iSenderProfileId'] = $data['data']->iAdvisorProfileId;
            $connection_criteria['iReceiverProfileId'] = $data['data']->iAdvisorProfileId;
            $allConnection = Investor::get_connection_by_sender_or_receiver($connection_criteria);

            /* If sender and Profile viewer is same  */
            if ($loginSession['iUserId'] == $data['data']->iUserId)
            {
                $data['profileVisible'] = true;
                $data['myOwnProfile'] = true;
            }
            
            foreach ($allConnection as $key => $value)
            {
                if ($data['profileVisible'] == true)
                {
                    break;
                }
                
                if ($value->iSenderId == $data['loginUserId'] || $value->iReceiverId == $data['loginUserId'])
                {
                    $data['profileVisible'] = true;
                }

                if (($value->iSenderProfileId == $data['data']->iAdvisorProfileId) && ($loginSession['iUserId'] == $value->iSenderId || $loginSession['iUserId'] == $value->iReceiverId))
                {
                    $data['profileVisible'] = true;
                }
                elseif(($value->iReceiverProfileId == $data['data']->iAdvisorProfileId) && ($loginSession['iUserId'] == $value->iSenderId || $loginSession['iUserId'] == $value->iReceiverId))
                {
                    $data['profileVisible'] = true;
                }
                else
                {
                    if ($data['profileVisible'] == false)
                    {
                        foreach ($data['advisor_exist'] as $key_advisor => $value_advisor)
                        {
                            if($value->iSenderProfileId == $value_advisor[0]->iSenderProfileId || $value->iSenderProfileId == $value_advisor[0]->iReceiverProfileId)
                            {
                                $data['profileVisible'] = true;
                                break;
                            }
                        }
                        if (($value->iSenderProfileId == $data['data']->iAdvisorProfileId) && ($loginSession['iUserId'] == $value->iSenderId || $loginSession['iUserId'] == $value->iReceiverId))
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
        return view('front.advisor.detail')->with($data);
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
        /* $data['location'] = BusinessAdvisor::get_location(); */
        $data['countries'] = Country::where(['eIsDeleted' => 'No','eStatus' => 'Active'])->get();
        $data['industries'] = Industry::get_all_data();
        return view('front.advisor.add')->with($data);
    }

    public function edit($vUniqueCode)
    {
        $criteria = array();
        $criteria["vUniqueCode"] = $vUniqueCode;
        $data['advisor'] = BusinessAdvisor::get_by_id($criteria);
        /* $data['location'] = BusinessAdvisor::get_location(); */
        $data['countries'] = Country::where(['eIsDeleted' => 'No','eStatus' => 'Active'])->get();
        $data['industries'] = Industry::get_all_data();
        $data['selected_industries'] = BusinessAdvisor::get_industries_data(['iAdvisorProfileId'=>$data['advisor']->iAdvisorProfileId]);
        $data['selected_location'] = BusinessAdvisor::get_location_data(['iAdvisorProfileId'=>$data['advisor']->iAdvisorProfileId]);
        $data['image_data'] = BusinessAdvisor::get_advisor_images(['iAdvisorProfileId' => $data['advisor']->iAdvisorProfileId]);

        // echo "<pre>";
        // print_r($data['image_data']);
        // echo "</pre>";
        // exit();
        $data['session_data'] = session('user');
        $criteria['iUserId'] = $data['session_data']['iUserId'];
         $data['my_advisor_profile'] = [];
        if ($data['advisor'] !== null) {
            $data['my_advisor_profile'] = BusinessAdvisor::get_by_iUserId($criteria);
            $doc_critaria['iAdvisorProfileId'] = $data['my_advisor_profile']->iAdvisorProfileId;
            $doc_critaria['eType'] = 'profile';
            $data['my_advisor_profile']->new_image = BusinessAdvisor::get_advisor_documents($doc_critaria);
        }
        return view('front.advisor.add')->with($data);
    }

    public function store(Request $request)
    {
        // dd($request);
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
        $data['iCost'] = $request->iCost;
        /* $data['vAdvisorProfileName'] = $request->vAdvisorProfileName; */
        
        $data['eFinancialAnalyst'] = $request->eFinancialAnalyst;
        $data['eAccountant'] = $request->eAccountant;
        $data['eBusinessLawer'] = $request->eBusinessLawer;
        $data['eTaxConsultant'] = $request->eTaxConsultant;
        $data['eBusinessBrokers'] = $request->eBusinessBrokers;
        $data['eCommercialRealEstateBrokers'] = $request->eCommercialRealEstateBrokers;
        $data['eMandAAdvisor'] = $request->eMandAAdvisor;
        $data['eInvestmentBanks'] = $request->eInvestmentBanks;

        $data['tAdvisorProfileDetail'] = $request->tAdvisorProfileDetail;
        $data['dDob'] = date('Y-m-d', strtotime($request->dDob));
        $data['vIdentificationNo'] = $request->vIdentificationNo;
        $data['tEducationDetail'] = $request->tEducationDetail;
        $data['tDescription'] = $request->tDescription;
        $data['vExperince'] = $request->vExperince;
        $data['tBio'] = $request->tBio;
        $data['eStatus'] = 'Active';
        $data['eIsDeleted'] = 'No';

        $message = $advisor_id = '';
        $loginSession=session('user');
        $loginUserId=$loginSession['iUserId'];
        if(!empty($loginUserId)){
            $data['iUserId']=$loginUserId;
        }

        if (!empty($vUniqueCode)) 
        {
            $data['dtUpdatedDate'] = date("Y-m-d h:i:s");
            $where = array();
            $where['vUniqueCode'] = $vUniqueCode;
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

            if (isset($request->industries)) {
                $industries_where = ['iAdvisorProfileId'=> $advisor_id];
                BusinessAdvisor::delete_industry($industries_where);
                
                foreach ($request->industries as $key => $value) {
                    $iName = strstr($value, '_', true);
                    $iId = substr($value, strpos($value, "_") + 1);

                    $industry_data = [
                        'iIndustryId' => $iId,
                        'iAdvisorProfileId' => $advisor_id,
                        'vUniqueCode' => md5(uniqid(time())),
                        'vIndustryName' => $iName,
                        'dtAddedDate' => date("Y-m-d h:i:s"),
                    ];
                  
                    BusinessAdvisor::add_industry($industry_data);
                  
                }
            }

            $criteria_delete_location['iAdvisorProfileId'] = $advisor_id;
            BusinessAdvisor::delete_locations($criteria_delete_location);

            $location_request['Country'] = explode('_',$request->iCountryId);
            $location_request['Region'] = explode('_',$request->iRegionId);
            $location_request['County'] = explode('_',$request->iCountyId);
            $location_request['Sub County'] = explode('_',$request->iSubCountyId);

            foreach ($location_request as $key => $value) {
                $location_data = [
                    'iLocationId'=>$value[0],
                    'iAdvisorProfileId'=>$advisor_id,
                    'vLocationName'=>$value[1],
                    'eLocationType'=>$key,
                    'vUniqueCode' => md5(uniqid(time())),
                    'dtAddedDate' => date('Y-m-d H:i:s')
                ];
                BusinessAdvisor::add_locations($location_data);
            }

            /* if (!empty($request->locations)) {
                $location_where = ['iAdvisorProfileId'=> $advisor_id];
                BusinessAdvisor::delete_locations($location_where);

                foreach ($request->locations as $key => $value) {
                    $lid = '';
                    $ltype = strstr($value, '_', true);
                    $lname = substr($value, strpos($value, "-") + 1);
                    if (preg_match('/_(.*?)-/', $value, $match) == 1) {
                        $lid = $match[1];
                    }
                    $location_data = [
                        'iLocationId' => $lid,
                        'iAdvisorProfileId' => $advisor_id,
                        'vLocationName' => $lname,
                        'eLocationType' => $ltype,
                        'vUniqueCode' => md5(uniqid(time())),
                        'dtAddedDate' => date('Y-m-d H:i:s'),
                    ];
                    BusinessAdvisor::add_locations($location_data);
                }
            } */

        } else {
            $data['dtAddedDate'] = date("Y-m-d h:i:s");
            $data['vUniqueCode'] = md5(uniqid(time()));
            $data['eAdminApproval']     = 'Pending';
            
            $advisor_id = BusinessAdvisor::add($data);
            $message = 'Business Advisor created successfully.';

            $data1['vAdvisorDisplayId'] = str_pad($advisor_id, 6, "0", STR_PAD_LEFT);
            $data1['dtUpdatedDate'] = date("Y-m-d h:i:s");
            $where1 = array();
            $where1['vUniqueCode'] = $data['vUniqueCode'];
            BusinessAdvisor::update_data($where1, $data1);

             $explodeDoc=explode(',', $request->documentId);

            foreach ($explodeDoc as $key => $docid) {
                $document_data = [
                    'iBusinessAdvisorId' => $advisor_id
                ];
             $document_where = ['iDocumentId'=> $docid];
             BusinessAdvisor::update_toDocument($document_where,$document_data);
            }

            if (isset($request->industries)) {
                foreach ($request->industries as $key => $value) {
                    $iName = strstr($value, '_', true);
                    $iId = substr($value, strpos($value, "_") + 1);

                    $industry_data = [
                        'iIndustryId' => $iId,
                        'iAdvisorProfileId' => $advisor_id,
                        'vUniqueCode' => md5(uniqid(time())),
                        'vIndustryName' => $iName,
                        'dtAddedDate' => date("Y-m-d h:i:s"),
                    ];
                    BusinessAdvisor::add_industry($industry_data);
                }
            }

            $location_request['Country'] = explode('_',$request->iCountryId);
            $location_request['Region'] = explode('_',$request->iRegionId);
            $location_request['County'] = explode('_',$request->iCountyId);
            $location_request['Sub County'] = explode('_',$request->iSubCountyId);

            foreach ($location_request as $key => $value) {
                $location_data = [
                    'iLocationId'=>$value[0],
                    'iAdvisorProfileId'=>$advisor_id,
                    'vLocationName'=>$value[1],
                    'eLocationType'=>$key,
                    'vUniqueCode' => md5(uniqid(time())),
                    'dtAddedDate' => date('Y-m-d H:i:s')
                ];
                BusinessAdvisor::add_locations($location_data);
            }

            /* if (!empty($request->locations)) {

                foreach ($request->locations as $key => $value) {
                    $lid = '';
                    $ltype = strstr($value, '_', true);
                    $lname = substr($value, strpos($value, "-") + 1);
                    if (preg_match('/_(.*?)-/', $value, $match) == 1) {
                        $lid = $match[1];
                    }
                    $location_data = [
                        'iLocationId' => $lid,
                        'iAdvisorProfileId' => $advisor_id,
                        'vLocationName' => $lname,
                        'eLocationType' => $ltype,
                        'vUniqueCode' => md5(uniqid(time())),
                        'dtAddedDate' => date('Y-m-d H:i:s'),
                    ];
                    BusinessAdvisor::add_locations($location_data);
                }
            } */
        }
       
   

            if($request->get_cropped_image !="")
            {
                $base64string = '';
                $uploadpath   = public_path('uploads/business-advisor/profile/');
                $parts        = explode(";base64,", $request->get_cropped_image);
                $imageparts   = explode("image/", @$parts[0]);
                $imagetype    = $imageparts[1];
                $imagebase64  = base64_decode($parts[1]);
                $imagename    =  uniqid(time()) . '.jpg';
                $filePath     = $uploadpath . $imagename;
                file_put_contents($filePath, $imagebase64);
                        
                $imageName = $imagename;
                $data_temp['iBusinessAdvisorId'] = $advisor_id;
                $data_temp['vUniqueCode'] = md5(uniqid(time()));
                $data_temp['vImage'] = $imageName;
                $data_temp['eType'] = 'profile';
                $data_temp['dtAddedDate'] = date("Y-m-d h:i:s");
                BusinessAdvisor::add_toDocument($data_temp);
            }


         if ($request->hasFile('file_advisor_profile_image') && empty($request->get_cropped_image)) 
         {
             $path = public_path('uploads/business-advisor/profile');
             $this->upload_dropzone_image($path, $request->file_advisor_profile_image, $advisor_id, 'profile');
         }
        if ($request->hasFile('file_education_documents')) {
            $path = public_path('uploads/business-advisor/education_document');
            $this->upload_dropzone_image($path, $request->file_education_documents, $advisor_id, 'education_document');
        }
        if ($request->hasFile('file_experience_documents')) {
            $path = public_path('uploads/business-advisor/experience');
            $this->upload_dropzone_image($path, $request->file_experience_documents, $advisor_id, 'experience');
        }
        return redirect()->route('front.dashboard.advisorDashboard')->withSuccess($message);
    }

    public function upload_dropzone_image($path = '', $images = '', $advisor_id = '', $type = '')
    {
        foreach ($images as $image) {
            $imageName = uniqid(time()) . '.' . $image->extension();
            $image->move($path, $imageName);
            $data_temp['iBusinessAdvisorId'] = $advisor_id;
            $data_temp['vUniqueCode'] = md5(uniqid(time()));
            $data_temp['vImage'] = $imageName;
            $data_temp['eType'] = $type;
            $data_temp['dtAddedDate'] = date("Y-m-d h:i:s");
            BusinessAdvisor::add_toDocument($data_temp);
        }
        return true;
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
        $senderContactName = $request->contactname;

        $session_data = session('user');
        $userId = $session_data['iUserId'];

        $criteria['iUserId']=$userId;
        $userdata= User::get_by_id($criteria);
        $fName=$userdata->vFirstName.' '.$userdata->vLastName;
        $phone=$userdata->vPhone;

        $criteria1['vUniqueCode']=$vUniqueCode;
        $advisorData= BusinessAdvisor::get_by_id($criteria1);
        $comments=$advisorData->vAdvisorProfileTitle;

        $oldToken=$userdata->iTotalToken;

        $user_data['iTotalToken']=$oldToken-1;

        if($oldToken > 0)
        {
            $user_where = ['iUserId'=> $userId];
            User::update_user($user_where,$user_data);

            // getting receiver data start
            $data['iSenderId'] = $userId;
            $data['iReceiverId'] = $advisorData->iUserId;
            $data['eReceiverProfileType'] = 'Advisor';
            $data['eSenderProfileType'] = $senderProfileType;
            $data['iReceiverProfileId'] = $advisorData->iAdvisorProfileId;
            $data['iSenderProfileId'] = $senderProfileId;
            $data['vReceiverProfileTitle'] = $advisorData->vAdvisorProfileTitle;
            $data['vSenderProfileTitle'] = $fName;
            $data['vReceiverContactPersonName'] = $advisorData->vFirstName.'-'.$advisorData->vLastName;
            $data['vSenderContactPersonName'] = $senderContactName;
            $data['vReceiverMobNo'] = $advisorData->vPhone;
            $data['vSenderMobNo'] = $phone;
            $data['vMessage'] = $comments;
            /* $data['eConnectionStatus'] = 'Hold'; */
            $data['eConnectionStatus'] = 'Active';
            $data['dtAddedDate'] = date("Y-m-d h:i:s");

            $receiver_advisor_data = BusinessAdvisor::get_by_profile_id('iAdvisorProfileId',$data['iReceiverProfileId']);

            $model = $field_name = $sender_profile_link = '';
            if ($data['eSenderProfileType'] == 'Investment')
            {
                $field_name = 'iInvestmentProfileId';
                $request_sender_data = Investment::get_by_profile_id($field_name,$data['iSenderProfileId']);
                $sender_profile_link = route('front.investment.detail',$request_sender_data->vUniqueCode);
            }
            else if ($data['eSenderProfileType'] == 'Investor')
            {
                $field_name = 'iInvestorProfileId';
                $request_sender_data = Investor::get_by_profile_id($field_name,$data['iSenderProfileId']);
                $sender_profile_link = route('front.investor.detail',$request_sender_data->vUniqueCode);
            }
            // $request_sender_data = User::get_by_id($data['iSenderProfileId']);

            /* EMAIL To User Register */
            $criteria = array();
            $criteria['vEmailCode'] = 'ADVISOR_RECEIVED_REQUEST';
            $email = Systememail::get_email_by_code($criteria);
            $company_setting = GeneralHelper::setting_info('company');
            
            $subject = str_replace("#SYSTEM.COMPANY_NAME#", $company_setting['COMPANY_NAME']['vValue'], $email->vEmailSubject);
            $constant   = array('#sender_profiler_name#','#sender_profile_link#','#SITE_NAME#');
            $value      = array($data['vSenderProfileTitle'],$sender_profile_link,$company_setting['COMPANY_NAME']['vValue']);
            $message = str_replace($constant, $value, $email->tEmailMessage);
            
            $email_data['to']       = $receiver_advisor_data->vEmail;
            $email_data['vSandgridTemplateId']       = $email->vSandgridTemplateId;
            $email_data['subject']  = $subject;
            $email_data['msg']      = $message;
            $email_data['dynamic_template_data']      = ['sender_profiler_name' => $data['vSenderProfileTitle'], 'sender_profile_link' => $sender_profile_link];
            $email_data['vFromName']     = $email->vFromName;
            $email_data['from']     = $email->vFromEmail;
            $email_data['company_name']     = $company_setting['COMPANY_NAME']['vValue'];
            /*GeneralHelper::send('ADVISOR_RECEIVED_REQUEST', $email_data);*/
            GeneralHelper::send_email_notifiction('ADVISOR_RECEIVED_REQUEST', $email_data);
            /* EMAIL To User Register*/
            
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
        return redirect()->route('front.advisor.detail',$vUniqueCode)->with($notification[0],$notification[1]);
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
            $temp = move_uploaded_file($image['tmp_name'],$destination_path);
            
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
    
    public function advisor_search($code)
    {
        $data['location'] = BusinessAdvisor::get_location();
        $data['industries'] = Industry::get_all_data([],1,15,true);
        $data['industries1'] = Industry::get_all_data([],16,50,true);
        $data['filterSearch']  = $code;
        return view('front.advisor.search_listing')->with($data);
    }

    public function ajax_search_listing(Request $request)
    {
        $action = $request->action;
        $sort = $request->sort;
        $type = $request->type;
        
        if ($action == 'sorting') {
            if ($sort == 'a-z') {
                $column = 'vAdvisorProfileTitle';
                $order = 'ASC';
            }
        } else {
            $column = "iAdvisorProfileId";
            $order = "DESC";
        }
        $criteria = array();
        $criteria['column'] = $column;
        $criteria['order'] = $order;
        $criteria['eStatus'] = 'Active';
        $criteria['eAdminApproval'] = 'Approved';
        if($type == 'business-financial-consultants')
        {
            $criteria['profession']='eFinancialAnalyst';
        }
        if($type == 'business-accounting-firms')
        {
            $criteria['profession']='eAccountant';
        }
        if($type == 'law-firms')
        {
            $criteria['profession']='eBusinessLawer';
        }
        if($type == 'financial-consultants')
        {
            $criteria['profession']='eTaxConsultant';
        }
        if($type == 'business-brokers')
        {
            $criteria['profession']='eBusinessBrokers';
        }
        if($type == 'ma-advisors')
        {
            $criteria['profession']='eMandAAdvisor';
        }
        if($type == 'investment-banks')
        {
            $criteria['profession']='eInvestmentBanks';
        }
        if($type == 'commercial-real-estate-brokers')
        {
            $criteria['profession']='eCommercialRealEstateBrokers';
        }
        $location = $industry = [];
        if($action == 'search' AND $request->filter != null) {     
        foreach ($request->filter as $key => $value) {
                if (isset($value['location'])) {
                    /*array_push($location,$value['location']);*/
                    $location=$value['location'];
                }
                else if (isset($value['industry'])) {
                    array_push($industry,$value['industry']);
                }
            }

            $criteria['industry'] = $industry;
            $criteria['location'] = $location;
        }
        $investor_data = BusinessAdvisor::get_all_data($criteria);
        $loginSession=session('user');        
        if(!empty($loginSession)){
                $data['loginUserId']=$loginSession['iUserId'];
        }

        $pages = 1;
        if ($request->pages != "") {
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = count($investor_data);
        $start = ($paginator->currentPage - 1) * $paginator->itemsPerPage;
        $limit = $paginator->itemsPerPage;
        if ($request->limit_page != '') {
            $per_page = $request->limit_page;
            $paginator->itemsPerPage = $per_page;
            $paginator->range = $per_page;
            $limit = $per_page;
        }
        $paginator->is_ajax = true;
        $paging = true;

        $data['total_record']=$paginator->total;
        $data['data'] = BusinessAdvisor::get_all_data($criteria, $start, $limit, $paging, true);
        // dd($data['data']);

        $criteria2 = array();
        foreach ($data['data'] as $key => $value) {
            $criteria2['iAdvisorProfileId'] = $value->iAdvisorProfileId;
            $data['location'][] = BusinessAdvisor::get_location_data($criteria2);
            $data['industries'][] = BusinessAdvisor::get_industries_data($criteria2);

        }
        $data['paging'] = $paginator->paginate();
        return view('front.advisor.ajax_search_listing')->with($data);

    }

}
