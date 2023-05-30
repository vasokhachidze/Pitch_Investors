<?php
namespace App\Http\Controllers\front\register;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\front\register\Register;
use App\Models\front\systememail\Systememail;
use App\Http\Controllers\front\login\LoginController;
use App\Helper\GeneralHelper;
use Session;

class RegisterController extends Controller
{
    public function index() {
        return view('front.register.register');
    }

    public function register_action(Request $request)
    {
        $data['vEmail']        = $request->vEmail;
        $data['vUniqueCode']   = md5(uniqid(time()));
        $data['vPassword']     = md5($request->vPassword);
        $data['vAuthCode']     = md5($request->vEmail);
        $data['vAccNo']        = GeneralHelper::generateUserCode();
        $data['dtAddedDate']   = date("Y-m-d h:i:s");

        $email_exist_criteria['vEmail'] = $data['vEmail'];
        $email_exist = Register::email_exist($email_exist_criteria);
        if ($email_exist !== null) {
            return redirect()->route('front.register.index')->with('error',"Email already exist! Please use different email.");
        }
        
        Register::add($data);

        /* EMAIL To User Register */
        $auth_code = md5($request->vEmail);
        $criteria = array();
        $criteria['vEmailCode'] = 'USER_REGISTER_FRONT';
        $email = Systememail::get_email_by_code($criteria);
        $company_setting = GeneralHelper::setting_info('company');
        $subject = str_replace("#SYSTEM.COMPANY_NAME#", $company_setting['COMPANY_NAME']['vValue'], $email->vEmailSubject);
        $constant   = array('{{activation_link}}','#SITE_NAME#');
        $value      = array(url('active-profile',$auth_code),$company_setting['COMPANY_NAME']['vValue']);
        $value      = array(url('active-profile',$auth_code),$company_setting['COMPANY_NAME']['vValue']);
        $message = str_replace($constant, $value, $email->tEmailMessage);
        
        $email_data['to']       = $request->vEmail;
        $email_data['vSandgridTemplateId']       = $email->vSandgridTemplateId;
        $email_data['subject']  = $subject;
        $email_data['msg']      = $message;
        $email_data['dynamic_template_data']      = ['activation_link' => url('active-profile',$auth_code)];
        $email_data['vFromName']     = $email->vFromName;
        $email_data['from']     = $email->vFromEmail;
        $email_data['company_name']     = $company_setting['COMPANY_NAME']['vValue'];
        /*GeneralHelper::send('USER_REGISTER_FRONT', $email_data);*/        
        // dd($email_data);
        GeneralHelper::send_email_notifiction('USER_REGISTER_FRONT', $email_data);


    /* EMAIL To User Register*/
        return redirect()->route('front.register.sign_up_thank_you')->withSuccess('User register successfully.');
    }

    public function sign_up_thank_you(Request $request) {
        if(Session::has('user') == null)
        {
            return view('front.register.thank_you_register');
        }
        return redirect()->route('front.dashboard.dashboard');
    }

    public function active_profile($code)
    {
        $criteria = array();
        $criteria['vAuthCode'] = $code;
        $result = Register::authentication($criteria);
        $content = new Request();
        if (empty($result)) {
            return redirect()->route('home');
        }
         $content->vEmail = $result->vEmail;
         $content->regPassword = $result->vPassword;

        $login_controller = new LoginController;

        if(!empty($result))
        {
            $data['eEmailVerified']     = 'Yes';
            $data['eStatus']            = 'Active';
            $data['vAuthCode']          = '';
            $where                      = array();
            $where['vUniqueCode']       = $result->vUniqueCode;
            Register::update_data($where, $data);
            
            $login_controller->login_action($content);
            return redirect()->route('front.dashboard.dashboard')->with('success',"Login successfully");
        } 
        else
        {
            $login_controller->login_action($content);
            return redirect()->route('front.dashboard.dashboard')->with('success',"Login successfully");
        }
    }
}