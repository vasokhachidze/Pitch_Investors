<?php
namespace App\Helper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\admin\language\Language;
use App\Models\admin\setting\Setting;
use App\Models\admin\notification_master\NotificationMaster;
use App\Models\admin\modulePermission\ModulePermission;
use App\Models\front\user\User;
use Auth;
use Mail;
use DB;

class GeneralHelper extends Controller
{
	/* static function replaceContent($vTitle){
        $rs_catname = trim(strtolower(($vTitle)));
        $rs_catname = str_replace("/","",$rs_catname);
        $rs_catname = str_replace("G��","",$rs_catname);
        $rs_catname = str_replace("(","",$rs_catname);
       
        $rs_catname = trim(strtolower(($vTitle)));
        $rs_catname = str_replace("/","",$rs_catname);
        $rs_catname = str_replace("G��","",$rs_catname);
        $rs_catname = str_replace("(","",$rs_catname);
        $rs_catname = str_replace(")","",$rs_catname);
        $rs_catname = str_replace("?","",$rs_catname);
        $rs_catname = str_replace("-","-",$rs_catname);
        $rs_catname = str_replace("#","",$rs_catname);
        $rs_catname = str_replace(",","",$rs_catname);
        $rs_catname = str_replace(";","",$rs_catname);
        $rs_catname = str_replace(":","",$rs_catname);
        $rs_catname = str_replace("'","",$rs_catname);
        $rs_catname = str_replace("\"","",$rs_catname);
        $rs_catname = str_replace("++","-",$rs_catname);
        $rs_catname = str_replace("+","-",$rs_catname);
        $rs_catname = str_replace("+","-",$rs_catname);
        $rs_catname = str_replace("+�","-",$rs_catname);
        //$rs_catname = str_replace("s","_",$rs_catname);

        $rs_catname = str_replace(" ","-",str_replace("&","and",$rs_catname));
        return $rs_catname;
    } */

    /* static function get_all_language(){
        $criteria = array();
        $criteria['eStatus']   = 'Active';
        $languages = Language::get_all_data($criteria);
        return $languages;
    } */

    /* static function get_primary_language(){
        $criteria = array();
        $criteria['eStatus']   = 'Active';
        $criteria['ePrimary']  = 'No';

        $primary_languages = Language::get_primary_data($criteria);
        $primary_language = $primary_languages->vLangCode;
        return $primary_language;
    } */

    static function get_config_type(){
        $config_type = Setting::groupBy('eConfigType')->pluck('eConfigType');
        return $config_type;
    }

    static function setting_info($eConfigType)
    {
        $setting_info = Setting::get_setting($eConfigType);
        return $setting_info;
    }

    static function company_info(){
        $company_info = Setting::where('eConfigType','Company')->get();
        return $company_info;
    }

    static function user_info()
    {
        $user = Auth::user();
        return $user;
    }

    static function send($criteria = array(), $data = array())
    {
        // $email_info = Setting::get_setting('Email');
        // $mailConfig = [
        //     'transport' => 'smtp',
        //     'host' => $email_info['SMTP_HOST']['vValue'],
        //     'port' => $email_info['SMTP_PORT']['vValue'],
        //     'encryption' => $email_info['EMAIL_PROTOCOL']['vValue'],
        //     'username' => $email_info['SMTP_USERNAME']['vValue'],
        //     'password' => $email_info['SMTP_PASS']['vValue'],
        //     'timeout' => null ];
        //     // dd($mailConfig);
            
        // config(['mail.mailers.smtp' => $mailConfig]);
        // try 
        // {
        //         Mail::send(['html' => 'front.email.email_template'], $data, function ($message) use ($data) {
        //             // dd($company_setting);
        //             $message->to($data["to"], '')
        //             ->subject($data["subject"]);
        //             $message->from("support@pitch-investors.com", $data["company_name"]);
        //         });
        //     return true;
        // }
        // catch (Exception $e) 
        // {
        //         report($e);
        //          return false;
        // }
    }

    static function send_email_notifiction($vCode = '', $data = array())
    {
        $email_setting = Setting::get_setting('Email');
        
        /*if($data['subject'] == ""){
            $data['subject'] = "email";
        }*/
        /*Send Grid SMS Test*/

        $lib_path = app_path().'/Libraries/sendgrid-php/';

        require_once $lib_path.'vendor/autoload.php';

        $apiKey = $email_setting['SENDGRID_API_KEY']['vValue'];
        
        $sg = new \SendGrid($apiKey);
        
        $request_body['content'][0]['type']  = "text/html";
        $request_body['content'][0]['value'] = "Hello";

        $request_body['from']['name']  = $data['vFromName'];
        $request_body['from']['email'] = $data['from'];

        $request_body['personalizations'][0]['to'][0]['email'] = $data['to'];
        $request_body['personalizations'][0]['to'][0]['name']  = $data['to'];

        $request_body['personalizations'][0]['dynamic_template_data'] = $data['dynamic_template_data'];

        $request_body['reply_to']['email'] = $data['from'];
        $request_body['reply_to']['name']  = $data['vFromName'];

        $request_body['subject']        = $data['subject'];
        $request_body['template_id']    = $data['vSandgridTemplateId'];
        // echo "<pre>"; print_r($request_body); exit();
        try {
            $response = $sg->client->mail()->send()->post($request_body);
            // dd([1,2,3,4,5],$response);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            return $e->getMessage();
        }
        // exit('ok');
        
    }

    static function get_user_data($iUserId)
    {
        $user_data = User::get_by_id($iUserId);
        return $user_data;
    }

    static function get_method(){
        $routes = \Route::getCurrentRoute()->getActionName();
        $method = explode('@',$routes);
        return $method[1];
    }

    static function get_class(){
        $routes = \Route::getCurrentRoute()->getActionName();
        $method = explode('@',$routes);
        $value = explode('\\',$method[0]);
        $controller = end($value);
        return $controller;
    }

    static function get_user_by_id($useId) {
        $SQL = DB::table("user");
        $SQL->where(["iUserId" => $useId]);
        $result = $SQL->get();
        return $result->first();
    }

    static function get_user_by_vAccNo($accNo) {
        $SQL = DB::table("user");
        $SQL->where(["vAccNo" => $accNo]);
        $result = $SQL->get();
        return $result->first();
    }

    static function rupees_format_thaousand_billion_million( $n, $precision = 1) {
        if( strpos($n, ',') !== false ) {
            $n = str_replace( ',', '', $n );
        }
        
        if(!floatval($n)) {
            return "N/A";
        }
        $n = floatval($n);
        
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }
      // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }
        return $n_format . $suffix;
    }
    static function get_user_data_in_profile($iUserId)
    {
         $investment;
         $investor;
         $advisor;
      
        $SQL = DB::table("investmentProfile");
        $SQL->selectRaw('vFirstName,vLastName,vPhone,dDob,vIdentificationNo');
        $SQL->where(["iUserId" => $iUserId]);
        $investment = $SQL->get();
        if(count($investment) > 0)
        {            
            return $investment->first();           
        }
        $SQL = DB::table("investorProfile");
        $SQL->selectRaw('vFirstName,vLastName,vPhone,dDob,vIdentificationNo');
        $SQL->where(["iUserId" => $iUserId]);
        $investor = $SQL->get();
        if(count($investor) > 0)
        {           
            return $investor->first();    
        }
        $SQL = DB::table("businessAdvisorProfile");
        $SQL->selectRaw('vFirstName,vLastName,vPhone,dDob,vIdentificationNo');
        $SQL->where(["iUserId" => $iUserId]);
        $advisor = $SQL->get();
        if(count($advisor) > 0)
        {           
            return $advisor->first();    
        }
        if(count($investment) == 0 && count($investor) == 0 && count($advisor) == 0){ 
          return 0;
        }
    }
    static function get_advisor_data($iUserId){
        $SQL = DB::table("businessAdvisorProfile");
        $SQL->selectRaw('iUserId,vUniqueCode');
        $SQL->where(["iUserId" => $iUserId]);
        $result = $SQL->get();
        return $result->first();    
    }
    static function get_myAvailable_token($useId)
    {        
        $SQL = DB::table("user");
        $SQL->selectRaw('iTotalToken');
        $SQL->where(["iUserId" => $useId]);
        $result = $SQL->get();
        return $result->first();    
    }
    static function get_mychat_notification($useId)
    {
        // \DB::enableQueryLog();

        $SQL = DB::table("chat");
        $SQL->selectRaw('iChatId,iSenderId ,iReceiverId,eRead');
        $SQL->where(["iReceiverId" => $useId]);
        $SQL->where(["eRead" => 'No']);
        $result = $SQL->get();
        // dd(\DB::getQueryLog());
        return $result->last();
    }

    /*static function generateAccountCode($useId) {
        $userSQL = DB::table("user")->select('vAccNo');
        $userResult = $userSQL->get();
            dd($userResult);
    }*/

    static function generateUserCode() {
        $string = "0123456789abcdefghijklmnopqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $randomNum=substr(str_shuffle($string), 0, 5);
        
        $userSQL = DB::table("user")->select('vAccNo')->whereNotNull('vAccNo');
        $userResult = $userSQL->get();
        foreach ($userResult as $key => $value) {
            if ($value->vAccNo == $randomNum) {
                self::generateUserCode();
            }
            else {
                return $randomNum;
            }
        }
    }
    
    static function generateUniqueCodePlanContract() {
        $length = 3;
        $string = "0123456789abcdefghijklmnopqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $randomNum = substr(str_shuffle($string), 0, $length);
        $temp_array = [];

        $contractSQL = DB::table("contract")->select('vContractCode')->where(['vContractCode' => $randomNum]);
        $contractResult = $contractSQL->get();
        foreach ($contractResult as $key => $value) {
            array_push($temp_array,$value->vContractCode);
        }
        
        $planSQL = DB::table("plan")->select('vPlanCode')->where(['vPlanCode' => $randomNum]);
        $planResult = $planSQL->get();
        // echo $randomNum;
        // dd($contractResult,$planResult);
        foreach ($planResult as $key => $value) {
            array_push($temp_array,$value->vPlanCode);
        }
        if (in_array($randomNum,$temp_array)) {
            self::generateUniqueCodePlanContract();
        }
        else{
            return $randomNum;
        }
    }
}