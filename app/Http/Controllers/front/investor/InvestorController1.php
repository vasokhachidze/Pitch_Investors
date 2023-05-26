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


use App\Libraries\Paginator;

class InvestorController extends Controller
{
    public function listing() {
        $data['location'] = Investor::get_location();
        $data['industries'] = Industry::get_all_data([],1,15,true);
        $data['industries1'] = Industry::get_all_data([],16,50,true);
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
                $column='vFirstName';
                $order='ASC';
            }
            
        }else
        {            
            $column         = "iInvestorProfileId";
            $order          = "ASC";
        }

        $criteria = array();
        $criteria['column']         = $column;
        $criteria['order']          = $order;
        $criteria['eStatus']        = 'Active';
        
        $transaction_type =  $location = $industry = [];
        if($action == 'search' AND $request->filter != null) {
            
            foreach ($request->filter as $key => $value) 
            {
                if (isset($value['transaction_type'])) {
                    array_push($transaction_type,$value['transaction_type']);
                    //$criteria[$value['transaction_type']] = 'Yes';
                }
                else if (isset($value['location'])) {
                    array_push($location,$value['location']);
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
    
    public function ajax_bookmark(Request $request)
    {
        $iUserId       = $request->loginUserId;
        $iProfileId     = $request->iProfileId;

        $criteria['iBookMarkProfileId'] = $iProfileId;
        $criteria['iUserId'] = $iUserId;

        $data_bookmark  = Investor::get_bookmark($criteria);
        
        if (empty($data_bookmark)) 
        {
            $bdata                           = array();
            $bdata['iUserId']                = $iUserId;
            $bdata['iBookMarkProfileId']     = $iProfileId;
            $bdata['vUniqueCode']            = md5(uniqid(time()));
            $bdata['dtAddedDate']            = date('Y-m-d H:i:s');
            $bdata['dtUpdatedDate']          = date('Y-m-d H:i:s');
            $bdata['eType']                  = 'Investor';
        
            Investor::add_bookmark($bdata);

            echo 0;
        }else
        {
            $criteria                = array();
            $criteria['iBookMarkId'] = $data_bookmark->iBookMarkId;            
            Investor::delete_bookmark($criteria);        
            
            echo 1;
        }
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
        $criteria = array();
        $data['profileVisible'] = false;
        $data['myOwnProfile'] = false;
        $criteria['vUniqueCode']=$code;
        $data['data'] = Investor::get_by_id($criteria);
        
        $criteria2['iInvestorProfileId'] = $data['data']->iInvestorProfileId;
        $data['industries'] = Investor::get_industries_data($criteria2);
        $data['location'] = Investor::get_location_data($criteria2);

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
                foreach ($data['inInvestmentCheckProfile'] as $investment_key => $investment_value) {
                    $criteriaInvestmentConnection = [
                        'iSenderProfileId' => $data['data']->iInvestorProfileId,
                        'iReceiverProfileId' => $investment_value->iInvestmentProfileId,
                    ];
                    $data['investment_exist'][] = $this->get_connection_from_other_profiles($criteriaInvestmentConnection);
                }
            }
            else
            {
                $data['investment_exist'] = [];
            }

            $data['inAdvisorCheckProfile']=BusinessAdvisor::get_by_iUserId($criteria1);
            if (!empty($data['inAdvisorCheckProfile'])) {
                $criteriaAdvisorConnection = [
                    'iSenderProfileId' => $data['data']->iInvestorProfileId,
                    'iReceiverProfileId' => $data['inAdvisorCheckProfile']->iAdvisorProfileId,
                ];
                $data['advisor_exist'] = $this->get_connection_from_other_profiles($criteriaAdvisorConnection);
            }
            else
            {
                $data['advisor_exist'] = [];
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

                if ($value->iSenderProfileId == $data['data']->iInvestorProfileId)
                {
                    $data['profileVisible'] = true;
                }
                else
                {
                    if ($data['profileVisible'] == false)
                    {
                        foreach ($data['advisor_exist'] as $key_advisor => $value_advisor)
                        {  
                            if($value->iSenderProfileId == $value_advisor->iSenderProfileId || $value->iSenderProfileId == $value_advisor->iReceiverProfileId)
                            {
                                $data['profileVisible'] = true;
                                break;
                            }
                        }
                        if ($value->iSenderProfileId == $data['data']->iInvestorProfileId)
                        {
                            $data['profileVisible'] = true;
                        }   
                       foreach ($data['investment_exist'] as $key_investment => $value_investment)
                       {   
                            if ($value->iSenderProfileId == $value_investment->iSenderProfileId || $value->iSenderProfileId == $value_investment->iReceiverProfileId)
                            {
                                $data['profileVisible'] = true;
                                break;
                            }
                        }
                    }
                }
            }
            /* Profile Visisble Code End */
        }
        $data['connection_list'] = $this->connectionList();
        return view('front.investor.detail')->with($data);
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
        $data['countries'] = Country::where(['eIsDeleted' => 'No','eStatus' => 'Active'])->get();
        /* $data['location'] = Investor::get_location(); */
        /* $data['countries'] = Country::get_country_code($criteria); */
        $data['subRegion'] = SubCounty::get_all_data($criteria);
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
        $data['countries'] = Country::where(['eIsDeleted' => 'No','eStatus' => 'Active'])->get();
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

            $criteria_delete_location['iInvestorProfileId'] = $investor_id;
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
            }

            /* if ($request->hasFile('file_identification_photo')) {
                $path = public_path('uploads/investor/identification_photo');
                $this->upload_dropzone_image($path, $request->file_identification_photo, $investor_id, 'identification_photo');
            }
            if ($request->hasFile('file_company_document')) {
                $path = public_path('uploads/investor/company_document');
                $this->upload_dropzone_image($path, $request->file_company_document, $investor_id, 'company_document');
            } */
        }
        return redirect()->route('front.investor.listing')->withSuccess($message);
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
        $notification = array();
        $vUniqueCode = $request->vUniqueCode;
        $transaction_type = $request->transaction_type;
        $profile_name = $request->profile_name;
        $fName = $request->fName;
        $phone = $request->phone;
        $comments = $request->comments;
        $term = $request->term;
        $senderProfileType = $request->profileType;
        $senderProfileId = $request->profileId;
        $senderContactName = $request->contactname;

        $session_data = session('user');
        $userId = $session_data['iUserId'];

        $criteria['iUserId']=$userId;
        $userdata= User::get_by_id($criteria);

         $criteria1['vUniqueCode']=$vUniqueCode;
         $investorData= Investor::get_by_id($criteria1);
         
        $oldToken=$userdata->iTotalToken;

        $user_data['iTotalToken']=$oldToken-0;

        /*if($oldToken > 0)*/
        if(1)
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
