<?php
namespace App\Http\Controllers\front\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\front\dashboard\Dashboard;
use App\Models\front\user\User;
use App\Models\front\connection\Connection;
use App\Models\front\dashboard\InvestorDashboard;
use App\Models\front\investor\Investor;
use App\Models\front\dashboard\AdvisorDashboard;
use App\Models\front\advisor\BusinessAdvisor;
use App\Models\front\investment\Investment;


class InvestorDashboardController extends Controller
{
    public function investorDashboard(Request $request) 
    {
        $data['session_data'] = session('user');
        $data['investment_count'] = count(InvestorDashboard::get_investment_total_connection($data['session_data']['iUserId']));
        $data['investor_count'] = count(InvestorDashboard::get_investor_total_connection($data['session_data']['iUserId']));
        $data['advisor_count'] = count(InvestorDashboard::get_advisor_total_connection($data['session_data']['iUserId']));
        $data['investor_accepted_sender_data'] = InvestorDashboard::get_accepted_sender_data($data['session_data']['iUserId']);
        $data['investor_accepted_receiver_data'] = InvestorDashboard::get_accepted_receiver_data($data['session_data']['iUserId']);
        // \DB::enableQueryLog();
        $data['investor_send_request_data'] = InvestorDashboard::get_investor_send_request_data($data['session_data']['iUserId']);
        // dd(\DB::getQueryLog());
        $data['investor_receive_request_data'] = InvestorDashboard::get_investor_receive_request_data($data['session_data']['iUserId']);
        foreach ($data['investor_receive_request_data'] as $key => $value) 
        {
            if($value->eSenderProfileType == 'Advisor')
            {
                $data['senderAdvisorData']=BusinessAdvisor::get_by_connection_profile_id('businessAdvisorProfile.iAdvisorProfileId',$value->iSenderProfileId);
            }
            if($value->eSenderProfileType == 'Investment')
            {
                $data['senderInvestmentData']=Investment::get_by_connection_profile_id('investmentProfile.iInvestmentProfileId',$value->iSenderProfileId);
            }
        }
     
        foreach ($data['investor_send_request_data'] as $key => $value1) 
        {
            if($value1->eReceiverProfileType == 'Advisor')
            {
                $data['receiverAdvisorData']=BusinessAdvisor::get_by_connection_profile_id('businessAdvisorProfile.iAdvisorProfileId',$value1->iReceiverProfileId);
            }
            if($value1->eReceiverProfileType == 'Investment')
            {
                $data['receiverInvestmentData']=Investment::get_by_connection_profile_id('investmentProfile.iInvestmentProfileId',$value1->iReceiverProfileId);
            }
        }     
      
        $criteria['iUserId'] = $data['session_data']['iUserId'];
        
        /* $data['advisor_profile_count'] = AdvisorDashboard::get_by_iUserId($criteria); */
        $data['advisor_profile_count'] = BusinessAdvisor::get_by_iUserId($criteria);
        $data['investor_profile_count'] = Investor::get_by_iUserId($criteria);
        $data['investment_profile_count'] = Investment::get_by_iUserId($criteria);

        $data['my_investor_profile'] = [];
        if ($data['investor_profile_count'] !== null) {
            $data['my_investor_profile'] = Investor::get_by_iUserId($criteria);
        }
        return view('front.dashboard.investor_dashboard')->with($data);
    }
    public function investorDashboardTabview(Request $request) 
    {
        $data['session_data'] = session('user');
        $data['investment_count'] = count(InvestorDashboard::get_investment_total_connection($data['session_data']['iUserId']));
        $data['investor_count'] = count(InvestorDashboard::get_investor_total_connection($data['session_data']['iUserId']));
        $data['advisor_count'] = count(InvestorDashboard::get_advisor_total_connection($data['session_data']['iUserId']));
        $data['investor_accepted_sender_data'] = InvestorDashboard::get_accepted_sender_data($data['session_data']['iUserId']);
        $data['investor_accepted_receiver_data'] = InvestorDashboard::get_accepted_receiver_data($data['session_data']['iUserId']);
        // \DB::enableQueryLog();
        $data['investor_send_request_data'] = InvestorDashboard::get_investor_send_request_data($data['session_data']['iUserId']);
        // dd(\DB::getQueryLog());
        $data['investor_receive_request_data'] = InvestorDashboard::get_investor_receive_request_data($data['session_data']['iUserId']);
            
        foreach ($data['investor_receive_request_data'] as $key => $value) 
        {
            if($value->eSenderProfileType == 'Advisor')
            {
                $data['senderAdvisorData']=BusinessAdvisor::get_by_connection_profile_id('businessAdvisorProfile.iAdvisorProfileId',$value->iSenderProfileId);
            }
            if($value->eSenderProfileType == 'Investment')
            {
                $data['senderInvestmentData']=Investment::get_by_connection_profile_id('investmentProfile.iInvestmentProfileId',$value->iSenderProfileId);
            }
        }
        foreach ($data['investor_send_request_data'] as $key => $value1) 
        {
            if($value1->eReceiverProfileType == 'Advisor')
            {
                $data['receiverAdvisorData']=BusinessAdvisor::get_by_connection_profile_id('businessAdvisorProfile.iAdvisorProfileId',$value1->iReceiverProfileId);
            }
            if($value1->eReceiverProfileType == 'Investment')
            {
                $data['receiverInvestmentData']=Investment::get_by_connection_profile_id('investmentProfile.iInvestmentProfileId',$value1->iReceiverProfileId);
            }
        }      
      
        $criteria['iUserId'] = $data['session_data']['iUserId'];
        
        /* $data['advisor_profile_count'] = AdvisorDashboard::get_by_iUserId($criteria); */
        $data['advisor_profile_count'] = BusinessAdvisor::get_by_iUserId($criteria);
        $data['investor_profile_count'] = Investor::get_by_iUserId($criteria);
        $data['investment_profile_count'] = Investment::get_by_iUserId($criteria);

        $data['my_investor_profile'] = [];
        if ($data['investor_profile_count'] !== null) {
            $data['my_investor_profile'] = Investor::get_by_iUserId($criteria);
        }
        return view('front.dashboard.investor_dashboard_tabview')->with($data);
    }
    public function accept_reject_connection(Request $request)
    {
        
        $iConnectionId=$request->iConnectionId;
        $connectionType=$request->connectionType;
        if($connectionType == 'accept')
        {
            $data['dtUpdatedDate']      = date("Y-m-d h:i:s");
            $data['eConnectionStatus']       = 'Accept';
            $where = array();
            $where['iConnectionId']       = $iConnectionId;
            InvestorDashboard::update_data($where, $data);

            echo 0;
        }
        if($connectionType == 'reject')
        {
            $iSenderId=$request->iSenderId;

            $criteria['iUserId']=$iSenderId;
            $userdata= User::get_by_id($criteria);
            $oldToken=$userdata->iTotalToken;

            $user_data['iTotalToken']=$oldToken+1;
            $user_where = ['iUserId'=> $iSenderId];
            User::update_user($user_where,$user_data);

            $data['dtUpdatedDate']      = date("Y-m-d h:i:s");
            $data['eConnectionStatus']       = 'Reject';
            $where = array();
            $where['iConnectionId']       = $iConnectionId;
            InvestorDashboard::update_data($where, $data);

            echo 0;
        }
    }

    public function change_password()
    {
        return view('front.dashboard.change_password');
    }
    public function change_password_store(Request $request)
    {
        $session_data = session('user');
        $data = ['vPassword' => md5($request->vPassword)];
        $where_field = 'iUserId';
        $where_value = $session_data['iUserId'];
        $result = Dashboard::update_data('user',$where_field,$where_value,$data);
        return redirect()->route('front.dashboard.dashboard')->withSuccess('Password changed successfully.');
    }

    public function edit_user()
    {
        $session_data = session('user');
        $user_data['iUserId'] = $session_data['iUserId'];
        $data['userData'] = User::get_by_id($user_data);
        return view('front.dashboard.edit_user')->with($data);
    }

    public function edit_user_store(Request $request)
    {
        ini_set('memory_limit', -1);
        
        $session_data = session('user');
        if ($request->hasFile('vImage')) 
        {
            $request->validate([
                'vImage' => 'required|mimes:png,jpg,jpeg|max:2048'
            ]);
            $imageName      = time().'.'.$request->vImage->getClientOriginalName();
            $path           = public_path('uploads/user'); 
            $request->vImage->move($path, $imageName);
            session()->put('user.vImage', $imageName);
            $data['vImage']=$imageName;
        }

        $data = [
            'vFirstName' => $request->vFirstName,
            'vLastName' => $request->vLastName,
            'vEmail' => $request->vEmail,
            'vPhone' => $request->vPhone,
            'vVat' => $request->vVat,           
        ];

        $where_field = 'iUserId';
        $where_value = $session_data['iUserId'];
        $result = Dashboard::update_data('user',$where_field,$where_value,$data);
        return redirect()->route('front.dashboard.dashboard')->withSuccess('Profile update successfully.');
    }
}