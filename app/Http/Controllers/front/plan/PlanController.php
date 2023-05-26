<?php
namespace App\Http\Controllers\front\plan;

use App\Events\LoaderSwitchEvent;
use App\Events\MpesaResponseEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\front\plan\Plan;
use App\Models\front\transaction\Transaction;
use App\Libraries\Paginator;
use App\Libraries\General;
use App\Models\front\user\User;
use App\Helper\GeneralHelper;
use App\Models\front\systememail\Systememail;
use Storage;


require 'vendor/autoload.php';
use Carbon\Carbon;


class PlanController extends Controller
{
    public function index()
    {
        return view('front.plan.listing');
    }
    public function plan_detail($code)
    {
        $criteria = array();
        $criteria['vUniqueCode']        = $code;
        $data['data'] = Plan::get_by_uniqueCode($criteria);
        return view('front.plan.detail')->with($data);
    }

    public function ajax_listing(Request $request)
    {
        $criteria = array();
        $criteria['eStatus']        = 'Active';
        $criteria['eIsDeleted']     = 'No';
        $criteria['column']         = "iPlanId";
        $criteria['order']          = "ASC";
        
        $data['data'] = Plan::get_all_data($criteria);
        return view('front.plan.ajax_listing')->with($data);
    }
    public function mPesaAccessToken_generate()
    {
        $url = $access_token = $shortCode = $passKey = $consumerKey = $consumerSecret = '';
        $timestamp = date('Ymdhis');
        $payment_setting = GeneralHelper::setting_info('Payment');

        if ($payment_setting['PAYMENT_MODE']['vValue'] == 'live') {
            $url = "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
            $shortCode = $payment_setting['C2B_SHORT_CODE_LIVE']['vValue'];
            $passKey = $payment_setting['C2B_PASS_KEY_LIVE']['vValue'];
            $consumerKey = $payment_setting['C2B_CONSUMER_KEY_LIVE']['vValue'];
            $consumerSecret = $payment_setting['C2B_CONSUMER_SECRET_LIVE']['vValue'];
        }
        elseif ($payment_setting['PAYMENT_MODE']['vValue'] == 'sandbox') {
            $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
            $shortCode = $payment_setting['C2B_SHORT_CODE_SANDBOX']['vValue'];
            $passKey = $payment_setting['C2B_PASS_KEY_SANDBOX']['vValue'];
            $consumerKey = $payment_setting['C2B_CONSUMER_KEY_SANDBOX']['vValue'];
            $consumerSecret = $payment_setting['C2B_CONSUMER_SECRET_SANDBOX']['vValue'];
        }
        $credentials = base64_encode($consumerKey.':'.$consumerSecret);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials,"Content-Type:application/json"));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        $token=json_decode($curl_response);

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            dd($error_msg);
        }

        curl_close($curl);

        if (!empty($token->access_token)) {
            $access_token = $token->access_token;
        }
        return $access_token;
    }

    public function plan_purchase(Request $request)
    {
        info('got to plan purchase');
        $loginUserId=$request->loginUserId;
        $iPlanId=$request->iPlanId;
        $vPhoneNumber = '254'.substr($request->vPhoneNumber, 1);
        
        $access_token = $shortCode = $passKey = '';
        $payment_setting = GeneralHelper::setting_info('Payment');

        if ($payment_setting['PAYMENT_MODE']['vValue'] == 'live') {
            $shortCode = $payment_setting['C2B_SHORT_CODE_LIVE']['vValue'];
            $passKey = $payment_setting['C2B_PASS_KEY_LIVE']['vValue'];
        }
        elseif ($payment_setting['PAYMENT_MODE']['vValue'] == 'sandbox') {
            $shortCode = $payment_setting['C2B_SHORT_CODE_SANDBOX']['vValue'];
            $passKey = $payment_setting['C2B_PASS_KEY_SANDBOX']['vValue'];
        }
        $timestamp = date('Ymdhis');
        $encode_password=base64_encode($shortCode . $passKey . $timestamp);

        $access_token = $this->mPesaAccessToken_generate();

        $this->payment($access_token,$encode_password,$loginUserId,$iPlanId,$vPhoneNumber,$timestamp);
    }

    public function payment($new_access_token,$encode_password,$loginUserId,$iPlanId,$vPhoneNumber,$timestamp)
    {
        info('still in PlanController::payment');
        $criteria = array();
        $criteria['vUniqueCode']        = $iPlanId;
        $planData = Plan::get_by_uniqueCode($criteria);

        $planId=$planData->iPlanId;
        $vPlanTitle=$planData->vPlanTitle;
        $vPlanPrice=$planData->vPlanPrice;
        $iNoofConnection=$planData->iNoofConnection;
        
        //$timestamp = date('Ymdhis');
      
        $timestamp = date('Ymdhis');
        
        $url = $access_token = $shortCode = $passKey = '';
        
        $payment_setting = GeneralHelper::setting_info('payment');
        if ($payment_setting['PAYMENT_MODE']['vValue'] == 'live') {
            $passKey = $payment_setting['C2B_PASS_KEY_LIVE']['vValue'];
            $shortCode = $payment_setting['C2B_SHORT_CODE_LIVE']['vValue'];
            $url = "https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest";

        }
        elseif ($payment_setting['PAYMENT_MODE']['vValue'] == 'sandbox') {
            $shortCode = $payment_setting['C2B_SHORT_CODE_SANDBOX']['vValue'];
            $passKey = $payment_setting['C2B_PASS_KEY_SANDBOX']['vValue'];
            $url = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";
        }
       
        $encode_password=base64_encode($shortCode . $passKey . $timestamp);

        $curl_post_data = [
            'BusinessShortCode' => $shortCode,
            'Password' => $encode_password,
            'Timestamp' =>$timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $vPlanPrice,
            'PartyA' => $shortCode,
            'PartyB' => $shortCode,
            'PhoneNumber' => $vPhoneNumber,
            'CallBackURL' => url('/plan-callback/'.$planId.'/'.$loginUserId),
            'AccountReference' => "Pitchinvestors",
            'TransactionDesc' => "Pitchinvestors lipa Na M-PESA"
        ];
        $data_string = json_encode($curl_post_data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$new_access_token));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = json_decode(curl_exec($curl));
        // $curl_response = curl_exec($curl);
        if(isset($curl_response->ResponseCode) && $curl_response->ResponseCode == 0)
        {
            session()->put('payment.CheckoutRequestID', $curl_response->CheckoutRequestID);
           
            echo "true";
        }else
        {
            echo "false";
        }
        // return $curl_response;
    }
    public function plan_callback($iPlanId,$loginUserId,Request $request)
    {
        info('still in PlanController::plan_callback');
        info('about to exit() ');
        // exit("0k");
        info('exting...) ');
        info('gone...) ');
        header("Content-Type: application/json");
        $mpesaResponse = file_get_contents('php://input');
        // echo $mpesaResponse; exit;
        // Storage::put('./stkPushCallbackResponse.txt', $mpesaResponse);

        info('ooh i did not exit...) ');
        $jsonMpesaResponse = json_decode($mpesaResponse, true); 

        $planData = Plan::get_by_id($iPlanId);

        $planId=$planData->iPlanId;
        $vPlanTitle=$planData->vPlanTitle;
        $vPlanPrice=$planData->vPlanPrice;
        $iNoofConnection=$planData->iNoofConnection;

        $status= $jsonMpesaResponse['Body']['stkCallback']['ResultCode']; 

        if($status == 0)//success
        {
            info('PAYMENT SUCCESS!');
            $data2['iUserId']=$loginUserId;
            $data2['vUniqueCode']=md5(uniqid(time()));
            $data2['iPlanId']=$iPlanId;
            $data2['vPlanTitle']=$vPlanTitle;
            $data2['vPlanPrice']=$vPlanPrice;
            $data2['iNoofConnection']=$iNoofConnection;
            $data2['iToken']=$iNoofConnection;
            $data2['vTokenPrice']=$vPlanPrice;
            //$data2['vPaymentReferenceId']=$curl_response->CheckoutRequestID;


            $data2['vPaymentReferenceId']=$jsonMpesaResponse['Body']['stkCallback']['CheckoutRequestID'];
            $data2['eStatus']="Paid";
            $data2['vMerchantRequestID']=$jsonMpesaResponse['Body']['stkCallback']['MerchantRequestID'];
            $data2['vMpesaReceiptNumber']=$jsonMpesaResponse['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
            $data2['dtTransactionDate']=$jsonMpesaResponse['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'];
            $data2['iPhoneNumber']=$jsonMpesaResponse['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
            $data2['vResultCode']=$jsonMpesaResponse['Body']['stkCallback']['ResultCode'];
            $data2['vResultDesc']=$jsonMpesaResponse['Body']['stkCallback']['ResultDesc'];

            $data2['dtAddedDate']=date("Y-m-d h:i:s");
            $data2['dtUpdatedDate']=date("Y-m-d h:i:s");
          
            Transaction::add($data2);

            $criteria=array();
            $criteria['iUserId']=$loginUserId;
            $userdata= User::get_by_id($criteria);
            $oldToken=$userdata->iTotalToken;
            $name=$userdata->vFirstName;
            $vEmail=$userdata->vEmail;

            $user_data['iTotalToken']=$oldToken+$iNoofConnection;
            $user_where = ['iUserId'=> $loginUserId];
            User::update_user($user_where,$user_data);

             /* EMAIL To User for token purchase */

           
            $criteria = array();
            $criteria['vEmailCode'] = 'PURCHASE_TOKEN';
            $email = Systememail::get_email_by_code($criteria);
            $company_setting = GeneralHelper::setting_info('company');
            $subject = str_replace("#SYSTEM.COMPANY_NAME#", $company_setting['COMPANY_NAME']['vValue'], $email->vEmailSubject);
            $constant   = array('#name#','#token_page#','#SITE_NAME#');
            $value      = array($name,url('token-listing'),$company_setting['COMPANY_NAME']['vValue']);
            $message = str_replace($constant, $value, $email->tEmailMessage);
            
            $email_data['to']       = $vEmail;
            $email_data['vSandgridTemplateId']       = $email->vSandgridTemplateId;
            $email_data['subject']  = $subject;
            $email_data['msg']      = $message;
            $email_data['dynamic_template_data']      = ['name' => $name, 'token_page' => url('token-listing')];
            $email_data['from']     = $email->vFromEmail;
            $email_data['vFromName']     = $email->vFromName;
            $email_data['company_name']     = $company_setting['COMPANY_NAME']['vValue'];
            //GeneralHelper::send('PURCHASE_TOKEN', $email_data);
            GeneralHelper::send_email_notifiction('PURCHASE_TOKEN', $email_data);
          
            /* EMAIL To User for for token purchase*/

            //emit event()

             //send event to cancel loading in checkout page
             event(new LoaderSwitchEvent(false));
             //send event to save this data from Mpesa call_back_url
             event(new MpesaResponseEvent($jsonMpesaResponse['Body']['stkCallback']));
             //send success message to customer
             // $request->get('Body')['stkCallback']['CallbackMetadata']['Item'];

        }else{
            info('PAYMENT UNSUCCESSFUL!!');
            $data2['iUserId']=$loginUserId;
            $data2['vUniqueCode']=md5(uniqid(time()));
            $data2['iPlanId']=$iPlanId;
            $data2['vPlanTitle']=$vPlanTitle;
            $data2['vPlanPrice']=$vPlanPrice;
            $data2['iNoofConnection']=$iNoofConnection;
            $data2['iToken']=$iNoofConnection;
            $data2['vTokenPrice']=$vPlanPrice;
            //$data2['vPaymentReferenceId']=$curl_response->CheckoutRequestID;


            $data2['vPaymentReferenceId']=$jsonMpesaResponse['Body']['stkCallback']['CheckoutRequestID'];
            $data2['eStatus']="Cancelled";
            $data2['vMerchantRequestID']=$jsonMpesaResponse['Body']['stkCallback']['MerchantRequestID'];
            $data2['vMpesaReceiptNumber']=null;
            $data2['dtTransactionDate']=null;
            $data2['iPhoneNumber']=null;
            $data2['vResultCode']=$jsonMpesaResponse['Body']['stkCallback']['ResultCode'];
            $data2['vResultDesc']=$jsonMpesaResponse['Body']['stkCallback']['ResultDesc'];

            $data2['dtAddedDate']=date("Y-m-d h:i:s");
            $data2['dtUpdatedDate']=date("Y-m-d h:i:s");
          
            Transaction::add($data2);

            //emit event()

             //send event to cancel loading in checkout page
             event(new LoaderSwitchEvent(false));
             //send event to save this data from Mpesa call_back_url
             event(new MpesaResponseEvent($jsonMpesaResponse['Body']['stkCallback']));
             //send success message to customer
             // $request->get('Body')['stkCallback']['CallbackMetadata']['Item'];
        }
    }

     public function verify_payment(Request $request)
    {     
        $session_data = session('payment');
        
        $session_payment_data = $request->session_payment;
        
        if (!empty($session_data)) 
        {
            info('session_data not empty');
            $vPaymentReferenceId=$session_data['CheckoutRequestID'];
            info($session_data['CheckoutRequestID']);
            $getPaymentData= Transaction::get_by_refrenceId($vPaymentReferenceId);

            if(!empty($getPaymentData))
            {
                $message=$getPaymentData->vResultDesc;
                if($getPaymentData->vResultCode != "")
                {
                   
                    echo $message;

                }else{
                    echo "1";
                }
            }else{
                echo "1";
            }
        } else {
            info('session_data is empty');
        }
    }
}