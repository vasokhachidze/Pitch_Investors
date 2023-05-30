<?php
namespace App\Http\Controllers\front\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\front\dashboard\Dashboard;
use App\Models\front\user\User;
use App\Models\front\connection\Connection;
use App\Models\front\dashboard\AdvisorDashboard;
use App\Models\front\dashboard\InvestorDashboard;
use App\Models\front\investor\Investor;
use App\Models\front\investment\Investment;
use App\Models\front\advisor\BusinessAdvisor;

class AdvisorDashboardController extends Controller
{
    public function advisorDashboard(Request $request) 
    {
        $data['session_data'] = session('user');
        $data['investment_count'] = count(AdvisorDashboard::get_investment_total_connection($data['session_data']['iUserId']));
        $data['investor_count'] = count(AdvisorDashboard::get_investor_total_connection($data['session_data']['iUserId']));
        $data['advisor_count'] = count(AdvisorDashboard::get_advisor_total_connection($data['session_data']['iUserId']));
        $data['advisor_accepted_sender_data'] = AdvisorDashboard::get_accepted_sender_data($data['session_data']['iUserId']);
        $data['advisor_accepted_receiver_data'] = AdvisorDashboard::get_accepted_receiver_data($data['session_data']['iUserId']);
        
        $data['advisor_send_request_data'] = AdvisorDashboard::get_advisor_send_request_data($data['session_data']['iUserId']);
        $data['advisor_receive_request_data'] = AdvisorDashboard::get_advisor_receive_request_data($data['session_data']['iUserId']);
        
        $criteria['iUserId'] = $data['session_data']['iUserId'];
        /* $data['advisor_profile_count'] = AdvisorDashboard::get_by_iUserId($criteria); */
        $data['advisor_profile_count'] = BusinessAdvisor::get_by_iUserId($criteria);
        $data['investor_profile_count'] = Investor::get_by_iUserId($criteria);
        $data['investment_profile_count'] = Investment::get_by_iUserId($criteria);

        $data['my_advisor_profile'] = [];
        if ($data['advisor_profile_count'] !== null) {
            $data['my_advisor_profile'] = AdvisorDashboard::get_by_iUserId($criteria);
            $doc_critaria['iAdvisorProfileId'] = $data['my_advisor_profile']->iAdvisorProfileId;
            $doc_critaria['eType'] = 'profile';
            $data['my_advisor_profile']->new_image = AdvisorDashboard::get_advisor_documents($doc_critaria);
        }
        foreach ($data['advisor_receive_request_data'] as $key => $value) 
        {
            if($value->eSenderProfileType == 'Investor')
            {
                $data['senderInvestorData']=Investor::get_by_connection_profile_id('investorProfile.iInvestorProfileId',$value->iSenderProfileId);
            }
            if($value->eSenderProfileType == 'Investment')
            {
                $data['senderInvestmentData']=Investment::get_by_connection_profile_id('investmentProfile.iInvestmentProfileId',$value->iSenderProfileId);
            }
        }
        foreach ($data['advisor_send_request_data'] as $key => $value1) 
        {
            if($value1->eReceiverProfileType == 'Investor')
            {
                $data['receiverInvestorData']=Investor::get_by_connection_profile_id('investorProfile.iInvestorProfileId',$value1->iReceiverProfileId);
            }
            if($value1->eReceiverProfileType == 'Investment')
            {
                $data['receiverInvestmentData']=Investment::get_by_connection_profile_id('investmentProfile.iInvestmentProfileId',$value1->iReceiverProfileId);
            }
        }
        return view('front.dashboard.advisor_dashboard')->with($data);
    } 
    public function advisorDashboardTabview(Request $request) 
    {
        $data['session_data'] = session('user');
        $data['investment_count'] = count(AdvisorDashboard::get_investment_total_connection($data['session_data']['iUserId']));
        $data['investor_count'] = count(AdvisorDashboard::get_investor_total_connection($data['session_data']['iUserId']));
        $data['advisor_count'] = count(AdvisorDashboard::get_advisor_total_connection($data['session_data']['iUserId']));
        $data['advisor_accepted_sender_data'] = AdvisorDashboard::get_accepted_sender_data($data['session_data']['iUserId']);
        $data['advisor_accepted_receiver_data'] = AdvisorDashboard::get_accepted_receiver_data($data['session_data']['iUserId']);
        
        $data['advisor_send_request_data'] = AdvisorDashboard::get_advisor_send_request_data($data['session_data']['iUserId']);
        $data['advisor_receive_request_data'] = AdvisorDashboard::get_advisor_receive_request_data($data['session_data']['iUserId']);
        
        $criteria['iUserId'] = $data['session_data']['iUserId'];
        /* $data['advisor_profile_count'] = AdvisorDashboard::get_by_iUserId($criteria); */
        $data['advisor_profile_count'] = BusinessAdvisor::get_by_iUserId($criteria);
        $data['investor_profile_count'] = Investor::get_by_iUserId($criteria);
        $data['investment_profile_count'] = Investment::get_by_iUserId($criteria);

        $data['my_advisor_profile'] = [];
        if ($data['advisor_profile_count'] !== null) {
            $data['my_advisor_profile'] = AdvisorDashboard::get_by_iUserId($criteria);
        }
        foreach ($data['advisor_receive_request_data'] as $key => $value) 
        {
            if($value->eSenderProfileType == 'Investor')
            {
                $data['senderInvestorData']=Investor::get_by_connection_profile_id('investorProfile.iInvestorProfileId',$value->iSenderProfileId);
            }
            if($value->eSenderProfileType == 'Investment')
            {
                $data['senderInvestmentData']=Investment::get_by_connection_profile_id('investmentProfile.iInvestmentProfileId',$value->iSenderProfileId);
            }
        }
        foreach ($data['advisor_send_request_data'] as $key => $value1) 
        {
            if($value1->eReceiverProfileType == 'Investor')
            {
                $data['receiverInvestorData']=Investor::get_by_connection_profile_id('investorProfile.iInvestorProfileId',$value1->iReceiverProfileId);
            }
            if($value1->eReceiverProfileType == 'Investment')
            {
                $data['receiverInvestmentData']=Investment::get_by_connection_profile_id('investmentProfile.iInvestmentProfileId',$value1->iReceiverProfileId);
            }
        }      
        return view('front.dashboard.advisor_dashboard_tabview')->with($data);
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
        if($connectionType == 'reject'){
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