<?php
namespace App\Http\Controllers\front\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\front\dashboard\InvestmentDashboard;
use App\Models\front\user\User;
use App\Models\front\investor\Investor;
use App\Models\front\dashboard\AdvisorDashboard;
use App\Models\front\advisor\BusinessAdvisor;
use App\Models\front\investment\Investment;


class InvestmentDashboardController extends Controller
{
    public function investmentDashboard(Request $request) 
    {
        $data['session_data'] = session('user');
        $data['investment_count'] = count(InvestmentDashboard::get_investment_total_connection($data['session_data']['iUserId']));
        $data['investor_count'] = count(InvestmentDashboard::get_investor_total_connection($data['session_data']['iUserId']));
        $data['advisor_count'] = count(InvestmentDashboard::get_advisor_total_connection($data['session_data']['iUserId']));
        
        $data['investment_data'] = InvestmentDashboard::get_investment_data($data['session_data']['iUserId']);

        $criteria2=array();
        foreach ($data['investment_data'] as $key => $value) 
        {
            $criteria2['iInvestmentProfileId'] = $value->iInvestmentProfileId;
            $data['location'][] = Investment::get_location_data($criteria2);
            $data['industries'][] = Investment::get_industries_data($criteria2);
        }
        // dd($data['investment_data']);

        $criteria['iUserId'] = $data['session_data']['iUserId'];
        /* $data['advisor_profile_count'] = AdvisorDashboard::get_by_iUserId($criteria); */
        $data['advisor_profile_count'] = BusinessAdvisor::get_by_iUserId($criteria);
        $data['investor_profile_count'] = Investor::get_by_iUserId($criteria);
        $data['investment_profile_count'] = Investment::get_by_iUserId($criteria);

        return view('front.dashboard.investment_dashboard')->with($data);
    } 
    public function investmentDashboardTabview(Request $request) 
    {
        $data['session_data'] = session('user');
        $data['investment_count'] = count(InvestmentDashboard::get_investment_total_connection($data['session_data']['iUserId']));
        $data['investor_count'] = count(InvestmentDashboard::get_investor_total_connection($data['session_data']['iUserId']));
        $data['advisor_count'] = count(InvestmentDashboard::get_advisor_total_connection($data['session_data']['iUserId']));
        $data['investment_data'] = InvestmentDashboard::get_investment_data($data['session_data']['iUserId']);
        
        // \DB::enableQueryLog();
        $data['send_request'] = InvestmentDashboard::get_investment_send_request_data($data['session_data']['iUserId']);
        // dd(\DB::getQueryLog());
        $data['received_request'] = InvestmentDashboard::get_investment_received_request_data($data['session_data']['iUserId']);

        $criteria2=array();
        foreach ($data['investment_data'] as $key => $value) 
        {
            $criteria2['iInvestmentProfileId'] = $value->iInvestmentProfileId;
            $data['location'][] = Investment::get_location_data($criteria2);
            $data['industries'][] = Investment::get_industries_data($criteria2);
        }
         
        // dd(\DB::getQueryLog());
        foreach ($data['send_request'] as $key => $value1) 
        {
            if($value1->eReceiverProfileType == 'Advisor')
            {
                $data['receiverAdvisorData']=BusinessAdvisor::get_by_connection_profile_id('businessAdvisorProfile.iAdvisorProfileId',$value1->iReceiverProfileId);
            }
            if($value1->eReceiverProfileType == 'Investor')
            {
                $data['receiverInvestorData']=Investor::get_by_connection_profile_id('investorProfile.iInvestorProfileId',$value1->iReceiverProfileId);
            }   
               
        }

        // dd(\DB::getQueryLog());
         foreach ($data['received_request'] as $key => $value2) 
        {
            
            if($value2->eSenderProfileType == 'Advisor')
            {
                $data['senderAdvisorData']=BusinessAdvisor::get_by_connection_profile_id('businessAdvisorProfile.iAdvisorProfileId',$value2->iSenderProfileId);
            }
            if($value2->eSenderProfileType == 'Investor')
            {
                $data['senderInvestorData']=Investor::get_by_connection_profile_id('investorProfile.iInvestorProfileId',$value2->iSenderProfileId);
            }
        }

        $criteria['iUserId'] = $data['session_data']['iUserId'];
        /* $data['advisor_profile_count'] = AdvisorDashboard::get_by_iUserId($criteria); */
        $data['advisor_profile_count'] = BusinessAdvisor::get_by_iUserId($criteria);
        $data['investor_profile_count'] = Investor::get_by_iUserId($criteria);
        $data['investment_profile_count'] = Investment::get_by_iUserId($criteria);

        return view('front.dashboard.investment_dashboard_tabview')->with($data);
    }
    
    public function ajax_data(Request $request)
    {
        // \DB::enableQueryLog();
        $result['send_request'] = InvestmentDashboard::get_investment_send_request_data($request->profile_id);
        // dd(\DB::getQueryLog());
        foreach ($result['send_request'] as $key => $value) 
        {
            if($value->eReceiverProfileType == 'Advisor')
            {
                $result['receiverAdvisorData']=BusinessAdvisor::get_by_connection_profile_id('businessAdvisorProfile.iAdvisorProfileId',$value->iReceiverProfileId);
            }
            if($value->eReceiverProfileType == 'Investor')
            {
                $result['receiverInvestorData']=Investor::get_by_connection_profile_id('investorProfile.iInvestorProfileId',$value->iReceiverProfileId);
            }            
        }
        return view('front.dashboard.investment_send_ajax_listing')->with($result);
    }

    public function ajax_received_data(Request $request)
    {
        // \DB::enableQueryLog();
        $result['received_request'] = InvestmentDashboard::get_investment_received_request_data($request->profile_id);
        // dd(\DB::getQueryLog());
         foreach ($result['received_request'] as $key => $value) 
        {
            
            if($value->eSenderProfileType == 'Advisor')
            {
                $result['senderAdvisorData']=BusinessAdvisor::get_by_connection_profile_id('businessAdvisorProfile.iAdvisorProfileId',$value->iSenderProfileId);
            }
            if($value->eSenderProfileType == 'Investor')
            {
                $result['senderInvestorData']=Investment::get_by_connection_profile_id('investorProfile.iInvestorProfileId',$value->iSenderProfileId);
            }
        }
        return view('front.dashboard.investment_received_ajax_listing')->with($result);
    }

    public function change_status(Request $request)
    {
        $table = 'investmentProfile';
        $where_field = 'vUniqueCode';
        $where_value = $request->id;
        $update_data = ['eStatus' => $request->status];
        $result = InvestmentDashboard::update_data($table, $where_field, $where_value, $update_data);
        return $result;
    }

}