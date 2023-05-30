<?php
namespace App\Http\Controllers\front\home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\admin\industry\Industry;
use App\Models\admin\testimonial\Testimonial;
use App\Models\front\home\Home;
use App\Models\front\home\EmailSubscriptions;
use DB;
use App\Helper\GeneralHelper;
use Request as RequestReuest;

class HomeController extends Controller
{
    public function home(Request $request) 
    {   
        $ip = RequestReuest::ip();
        $subscibe_data = EmailSubscriptions::where('ip_address', $ip)->first();
        if(!empty($subscibe_data)) {
            session()->put('close-popup', '1');
        }
        $userData = session('user');
        if (!empty($userData)) {
            session()->put('close-popup', '1');
        }
        // GeneralHelper::send_email_notifiction();
        $criteria["eStatus"]='Active';
        $criteria["eIsDeleted"]='No';
        $criteria1["eShowHomePage"]='Yes';
        $criteria2["eStatus"]='Active';
        $criteria2["eShowHomePage"]='Yes';
        $data['industries'] = Industry::get_all_data_home();
        $data['testimonial'] = Testimonial::get_all_data($criteria);
        $data['investment_count'] = Home::get_investment_count(1);
        $data['investment_data'] = Home::get_investment_data($criteria1,true);
        $data['investor_count'] = Home::get_investor_count(1);
        $data['investor_data'] = Home::get_investor_data($criteria1,true);
        $data['advisor_count'] = Home::get_advisor_count(1);
        $data['advisor_data'] = Home::get_advisor_data($criteria1,true);
        $data['banner'] = Home::get_banner_data($criteria2);
        

        $criteria2 = array();
        foreach ($data['advisor_data'] as $key => $value) {
            $criteria2['iAdvisorProfileId'] = $value->iAdvisorProfileId;
            $data['location_advisor'][] = Home::get_advisor_location_data($criteria2);
            $data['industries_advisor'][] = Home::get_advisor_industries_data($criteria2);
        }foreach ($data['investor_data'] as $key => $value) {
            $criteria2['iInvestorProfileId'] = $value->iInvestorProfileId;
            $data['location_investor'][] = Home::get_investor_location_data($criteria2);
            $data['industries_investor'][] = Home::get_investor_industries_data($criteria2);
        }
         foreach ($data['investment_data'] as $key => $value) 
        {
            $criteria2['iInvestmentProfileId'] = $value->iInvestmentProfileId;
            $data['location_investment'][] = Home::get_investment_location_data($criteria2);
        }
        return view('front.home.home')->with($data);
    }

    public function subscribe(Request $request){       
        $data['ip_address'] =  RequestReuest::ip();
        $data['name']      = $request->name;
        $data['email']     = $request->email;
        $data['created_at']= date("Y-m-d h:i:s");        
        EmailSubscriptions::add($data);
        session()->put('close-popup', '1');
    }

    public function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }

    public function hide_subscribe()
    {
        $data['ip_address'] =  RequestReuest::ip();
        $data['created_at']= date("Y-m-d h:i:s");        
        EmailSubscriptions::add($data);
        session()->put('close-popup', '1');
    }
    public function searchProfile(Request $request)
    {
        $keyword = $request->keyword;
        $data = array();
        $criteria = array();
            // $criteria['keyword']=$vAddress;
        $criteria['keyword'] = $keyword;
        $criteria['eAdminApproval'] = 'Approved';
        $data_investor = Home::get_investor_data($criteria);
        $data_advisor = Home::get_advisor_data($criteria);
        $data_investment = Home::get_investment_data($criteria);

        if (count($data_investor) > 0) 
        {
            foreach ($data_investor as $key_state => $value_investor) 
            {
                $out_investor = array();
                $out_investor['iInvestorProfileId'] = $value_investor->iInvestorProfileId;
                $out_investor['vInvestorProfileName'] = $value_investor->vInvestorProfileName;
                $out_investor['vUniqueCode'] = $value_investor->vUniqueCode;
                $investor[] = $out_investor;
            }
            $data["investor"] = $investor;
        }

        if (count($data_advisor) > 0) 
        {
            foreach ($data_advisor as $key_state => $value_advisor) 
            {
                $out_advisor = array();
                $out_advisor['iInvestorProfileId'] = $value_advisor->iAdvisorProfileId;
                $out_advisor['vAdvisorProfileTitle'] = $value_advisor->vAdvisorProfileTitle;
                $out_advisor['vUniqueCode'] = $value_advisor->vUniqueCode;
                $advisor[] = $out_advisor;
            }
            $data["advisor"] = $advisor;
        }
        if (count($data_investment) > 0) 
        {
            foreach ($data_investment as $key_state => $value_investment) 
            {
                $out_investment = array();
                $out_investment['iInvestorProfileId'] = $value_investment->iInvestmentProfileId;
                $out_investment['vBusinessProfileName'] = $value_investment->vBusinessProfileName;
                $out_investment['vUniqueCode'] = $value_investment->vUniqueCode;
                $investment[] = $out_investment;
            }
            $data["investment"] = $investment;
        }
       
        if (!empty($data)) {
            return view('front.home.ajax_search_profile')->with($data);
        } else {
            return 1;
        }
    }
    /* public function nationality(Request $request)
    {
        $open = fopen(public_path("countries.csv"), "r");
        $data = fgetcsv($open, 1000, ",");
        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
        {
            $criteria['vCountry'] = $data[1];
            $update_data['vNationality'] = $data[3];
            $this->add_nationality($criteria,$update_data);
        }
    }

    public static function add_nationality(array $where = [], array $data = []){
        $result = DB::table('country');
        $result->where('vCountry',$where['vCountry'])->update($data);
    } */
}