<?php
namespace App\Http\Controllers\front\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\front\dashboard\Dashboard;
use App\Models\front\user\User;
use App\Models\front\investor\Investor;
use App\Models\front\advisor\BusinessAdvisor;
use App\Models\front\investment\Investment;

class DashboardController extends Controller
{
    public function dashboard(Request $request) 
    {
        $data['session_data'] = session('user');
        $criteria['iUserId'] = $data['session_data']['iUserId'];

        $user_data['iUserId'] = $data['session_data']['iUserId'];
        $data['userData'] = User::get_by_id($user_data);
        $data['investment_count'] = count(Dashboard::get_investment_total_connection($data['session_data']['iUserId']));

        $data['investor_found'] = Dashboard::get_investor_total_connection($data['session_data']['iUserId']);
        $data['investor_edit_data'] = Investor::get_by_iUserId($criteria);
        // dd($data['investor_edit_data']);
        $data['investor_count'] = count($data['investor_found']);
        
        $data['advisor_found'] = Dashboard::get_advisor_total_connection($data['session_data']['iUserId']);
        $data['advisor_edit_data'] = BusinessAdvisor::get_by_iUserId($criteria);
        $data['advisor_count'] = count($data['advisor_found']);
        
        $data['advisor_profile_count'] = BusinessAdvisor::get_by_iUserId($criteria);
        $data['investor_profile_count'] = Investor::get_by_iUserId($criteria);
        $data['investment_profile_count'] = Investment::get_by_iUserId($criteria);
        
        return view('front.dashboard.dashboard')->with($data);
    }

    public function premiumAccountDetail(Request $request) 
    {
        $data['session_data'] = session('user');
        $user_data['iUserId'] = $data['session_data']['iUserId'];
        $data['userData'] = User::get_by_id($user_data);
        return view('front.dashboard.premium_account_detail')->with($data);
    }

    public function change_password()
    {
        $data['session_data'] = session('user');
        $criteria['iUserId'] = $data['session_data']['iUserId'];
        $data['investment_count'] = count(Dashboard::get_investment_total_connection($data['session_data']['iUserId']));
        $data['investor_count'] = count(Dashboard::get_investor_total_connection($data['session_data']['iUserId']));
        $data['advisor_count'] = count(Dashboard::get_advisor_total_connection($data['session_data']['iUserId']));
        $data['advisor_profile_count'] = BusinessAdvisor::get_by_iUserId($criteria);
        $data['investor_profile_count'] = Investor::get_by_iUserId($criteria);
        $data['investment_profile_count'] = Investment::get_by_iUserId($criteria);
        return view('front.dashboard.change_password')->with($data);
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
        $data['session_data'] = $session_data = session('user');
        $criteria['iUserId'] = $data['session_data']['iUserId'];
        $data['investment_count'] = count(Dashboard::get_investment_total_connection($data['session_data']['iUserId']));
        $data['investor_count'] = count(Dashboard::get_investor_total_connection($data['session_data']['iUserId']));
        $data['advisor_count'] = count(Dashboard::get_advisor_total_connection($data['session_data']['iUserId']));

        $user_data['iUserId'] = $session_data['iUserId'];
        $data['userData'] = User::get_by_id($user_data);
        $data['advisor_profile_count'] = BusinessAdvisor::get_by_iUserId($criteria);
        $data['investor_profile_count'] = Investor::get_by_iUserId($criteria);
        $data['investment_profile_count'] = Investment::get_by_iUserId($criteria);
        return view('front.dashboard.edit_user')->with($data);
    }
    public function edit_user_store(Request $request)
    {
        ini_set('memory_limit', -1);
        $session_data = session('user');
        $image_name = '';
        if($request->get_cropped_image !="")
            {
                $base64string = '';
                $uploadpath   = public_path('uploads/user/');
                $parts        = explode(";base64,", $request->get_cropped_image);
                $imageparts   = explode("image/", @$parts[0]);
                $imagetype    = $imageparts[1];
                $imagebase64  = base64_decode($parts[1]);
                $imagename=  uniqid(time()) . '.jpg';
                $filePath       = $uploadpath . $imagename;
                file_put_contents($filePath, $imagebase64);
                        
                session()->put('user.vImage', $imagename);
                  $image_name = $imagename;
            }


/*
        if($request->hasFile('vImage')) 
        {
            $request->validate([
                'vImage' => 'mimes:png,jpg,jpeg|max:2048'
            ]);
            $imageName      = time().'.'.$request->vImage->getClientOriginalName();
            $path           = public_path('uploads/user'); 
            $request->vImage->move($path, $imageName);
            session()->put('user.vImage', $imageName);
            $image_name = $imageName;
        }
*/
        $data = [
            'vFirstName' => $request->vFirstName,
            'vLastName' => $request->vLastName,
            'vEmail' => $request->vEmail,
            'vPhone' => $request->vPhone,
            'vVat' => $request->vVat,
        ];
        if (!empty($image_name)) {
            $data['vImage'] = $image_name;
        }
        
        $where_field = 'iUserId';
        $where_value = $session_data['iUserId'];
        $result = Dashboard::update_data('user',$where_field,$where_value,$data);
        return redirect()->route('front.dashboard.dashboard')->withSuccess('Profile update successfully.');
    }
}