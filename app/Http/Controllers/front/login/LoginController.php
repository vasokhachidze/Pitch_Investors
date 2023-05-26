<?php
namespace App\Http\Controllers\front\login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\front\login\Login;
use Illuminate\Support\Str;
use App\Models\front\systememail\Systememail;
use App\Helper\GeneralHelper;
use Session;

class LoginController extends Controller
{
    public function index() {
        return view('front.login.login');
    }

    public function login_action(Request $request)
    {
        $login    = $request->vEmail;
        if($request->regPassword){
            $password = $request->regPassword;
        }else{            
            $password = md5($request->vPassword);
        }

        $data     = Login::login($login,$password);
        
        if(empty($data))
        {
            return redirect()->route('front.login.index')->with('error',"Please enter correct login email and password");
        } 
        else
        {
            if($data->eStatus == 'Active')
            {
                
                $userId = '';
                if (!empty($data->iUserId)) {
                    session()->put('user.iUserId', $data->iUserId);
                    $userId = $data->iUserId;
                }
                if (!empty($data->vEmail)) {
                    session()->put('user.vEmail',$data->vEmail);
                }
                session()->put('user.vFirstName', $data->vFirstName);
                session()->put('user.vLastName', $data->vLastName);
                session()->put('user.vUniqueCode', $data->vUniqueCode);
                session()->put('user.vAccNo', $data->vAccNo);
                session()->put('user.vPhone', $data->vPhone);
                session()->put('user.vImage', $data->vImage);
                return redirect()->route('front.dashboard.dashboard')->with('success',"Login successfully");
            }
            else
            {
               return redirect()->route('front.login.index')->with('error'," Your Account Is Under Review");
            }
        }
    }

    public function forgot_password(){
        return view('front.login.forgot_password');
    }

    public function forgotpassword_action(Request $request) {
        $data['forgot_password_otp']   = Str::random(6);
        $data['vAuthCode']   = md5($request->vEmail);
        $data['dtUpdatedDate'] = date("Y-m-d h:i:s");
        $where                      = array();
        $where['vEmail']          = $request->vEmail;
        Login::update_data_by_email($where, $data);

        /* EMAIL To User Register */
        $auth_code = md5($request->vEmail);
        $criteria = array();
        $criteria['vEmailCode'] = 'USER_FORGOT_PASSWORD';
        $email = Systememail::get_email_by_code($criteria);
        $company_setting = GeneralHelper::setting_info('company');
        $user = GeneralHelper::user_info();
        
        $subject = str_replace("#SYSTEM.COMPANY_NAME#", $company_setting['COMPANY_NAME']['vValue'], $email->vEmailSubject);
        $constant   = array('#vName#','#activation_link#','#SITE_NAME#');
        $value      = array($request->vEmail,url('reset-password',$auth_code),$company_setting['COMPANY_NAME']['vValue']);
        $message = str_replace($constant, $value, $email->tEmailMessage);
        
        $email_data['to']       = $request->vEmail;
        $email_data['vSandgridTemplateId']       = $email->vSandgridTemplateId;
        $email_data['subject']  = $subject;
        $email_data['msg']      = $message;
        $email_data['dynamic_template_data']      = ['vName' => $request->vEmail, 'activation_link' => url('reset-password',$auth_code)];
        $email_data['vFromName']     = $email->vFromName;
        $email_data['from']     = $email->vFromEmail;
        $email_data['company_name']     = $company_setting['COMPANY_NAME']['vValue'];
        /*GeneralHelper::send('USER_FORGOT_PASSWORD', $email_data);*/
        GeneralHelper::send_email_notifiction('USER_FORGOT_PASSWORD', $email_data);
        /* EMAIL To User Register*/
        return redirect()->route('front.login.index')->withSuccess('We send email to reset password.');
    }

    public function reset_password($code)
    {
        $data['code'] = $code;
        return view('front.login.reset_password')->with($data);
    }
    public function resetPassword_action(Request $request)
    {
        $data['forgot_password_otp']   = NULL;
        $data['vAuthCode']   = NULL;
        $data['vPassword']   = md5($request->vPassword);
        $data['dtUpdatedDate'] = date("Y-m-d h:i:s");
        $where                      = array();
        $where['vAuthCode']          = $request->auth;
        $result = Login::update_data_by_authCode($where, $data);
        
        return redirect()->route('front.login.index')->withSuccess('Your password reset successfully.');
    }

    public function logout() {
        Session::flush();
        return redirect()->route('front.login.index')->withSuccess('You have been logged out successfully.');
    }
}