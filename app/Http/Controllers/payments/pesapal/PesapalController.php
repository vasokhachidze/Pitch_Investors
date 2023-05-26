<?php

namespace App\Http\Controllers\payments\pesapal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\front\payments\UserPayments;
use App\Models\front\user\User;
use Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use App\Helper\GeneralHelper;
use App\Models\front\investment\Investment;
use App\Models\front\systememail\Systememail;

class PesapalController extends Controller
{
   
    public function getAccessToken()
    {
        $url = env('PESAPAL_URL').'/Auth/RequestToken';
        
        $header =  array(
            "Accept: application/json",
            "Content-Type: application/json"
        );
        $body = array("consumer_key" => env('PESAPAL_KEY'), "consumer_secret" => env('PESAPAL_SECRET'));
        $access_token = $this->callPostCurl($url, $header, $body);
        return $access_token['token'];
    }

    public function registerIPN($token)
    {
        $url = env('PESAPAL_URL').'/URLSetup/RegisterIPN';
        
        $header =  array(
            "Accept: application/json",
            "Content-Type: application/json",
            "Authorization: Bearer $token"
            
        );
        $body = array("url" => env('PESAPAL_NOTIFICATION_URL'), "ipn_notification_type" => "GET");
        $registerPinData = $this->callPostCurl($url, $header, $body);
        return $registerPinData;
    }

    public function submitOrderRequest($submitData, $token)
    {
        $url = env('PESAPAL_URL').'/Transactions/SubmitOrderRequest';
        
        $header =  array(
            "Accept: application/json",
            "Content-Type: application/json",
            "Authorization: Bearer $token"
            
        );
        $body = array(
                "id" => $submitData['reference'],
                "currency" => $submitData['currency'],
                "amount" => $submitData['amount'],
                "description" => 'Premium payment for user '. $submitData['email_address'],
                "callback_url" => env('PESAPAL_CALLBACK_URL'),
                "notification_id" => $submitData['notification_id'],
                "billing_address" =>array(
                                    "email_address" =>  isset($submitData['email_address']) ? $submitData['email_address'] : '', 
                                    "phone_number" =>  isset($submitData['phone_number']) ? $submitData['phone_number'] : '', 
                                    "first_name" =>  isset($submitData['first_name']) ? $submitData['first_name'] : '', 
                                    "last_name" =>  isset($submitData['last_name']) ? $submitData['last_name'] : '', 
                                    "postal_code" =>  isset($submitData['postal_code']) ? $submitData['postal_code'] : '', 
                                    "zip_code" =>  isset($submitData['zip_code']) ? $submitData['zip_code'] : ''
                                ),
            );
       
        $orderSubmitData = $this->callPostCurl($url, $header, $body);
        return $orderSubmitData;
    }

    public function callPostCurl($url , $header, $body)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($body));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        return json_decode($response, true);
    }

    public function getTransactionStatus($token, $OrderTrackingId)
    {
        $url = env('PESAPAL_URL').'/Transactions/GetTransactionStatus?orderTrackingId='.$OrderTrackingId;
        
        $header =  array(
            "Accept: application/json",
            "Content-Type: application/json",
            "Authorization: Bearer $token"
            
        );
        $transactionDetail = $this->callGetCurl($url, $header);
        return $transactionDetail;
    }



    public function callGetCurl($url , $header)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        return json_decode($response, true);
    }

    public function pesapalResponse(Request $request)
    {
        $requestData = $request->all();
        Log::info(json_encode($requestData));
        if (!empty($requestData['OrderMerchantReference'])) {
            $OrderTrackingId = $requestData['OrderTrackingId'];
            $accessToken =  $this->getAccessToken(); 
            $transactionDetail = $this->getTransactionStatus($accessToken, $OrderTrackingId);
            if (!empty($transactionDetail['payment_status_description']) && $transactionDetail['payment_status_description'] == 'Completed' && $transactionDetail['status_code'] == 1) {
                $order_detail = UserPayments::get_payment_detail(['merchantReference' => $requestData['OrderMerchantReference']]);
                if (!empty($order_detail)) {
                    $where = ['merchantReference'=> $requestData['OrderMerchantReference']];
                    $paymentData['paymentStatus'] = 1;
                    $paymentData['orderId'] =  $OrderTrackingId;
                    $paymentData['updatedAt'] =  date("Y-m-d h:i:s");
                    $merchantReferenceData = explode("-", $requestData['OrderMerchantReference']);
                    $premiumService = $merchantReferenceData[1];
                    $investmentId = $merchantReferenceData[2];
                    UserPayments::update_userpayments($where,$paymentData);
                    $where = array();
                    $where['iInvestmentProfileId']       = $investmentId;
                    $service = '';
                    if ($premiumService == 3) {
                        $investmentData['isNewsletterService'] = 1;
                        $investmentData['isSocialMediaService'] = 1;
                        $service = 'Email Subscription, or Social Media Post';
                       
                    } else if ($premiumService == 2) {
                        $investmentData['isSocialMediaService'] = 1;
                        $service = 'Social Media Post';

                    } else if ($premiumService == 1) {
                        $investmentData['isNewsletterService'] = 1;
                        $service = 'Email Subscription';
                    }
                    Investment::update_data_by_id($where, $investmentData);
                    /* EMAIL To User Register */
                    $criteria = array();
                    $criteria['vEmailCode'] = 'PREMIUM_SERVICE';
                    $email = Systememail::get_email_by_code($criteria);
                    $company_setting = GeneralHelper::setting_info('company');
                    $user = GeneralHelper::get_user_data($order_detail->iUserId);
                    $lastName = $user->vLastName;
                    
                    // $constant   = array('#name#','#service#');
                    // $value      = array($lastName,$service);
                    // $message = str_replace($constant, $value, $email->tEmailMessage);
                    
                    $email_data['to']       = 'phpslick@gmail.com';
                    $email_data['vSandgridTemplateId']       = $email->vSandgridTemplateId;
                    $email_data['subject']  = $email->vEmailSubject;
                    //$email_data['msg']      = $message;
                    $email_data['dynamic_template_data']      = ['name' => $user->vLastName, 'service' => $service];
                    $email_data['vFromName']     = $email->vFromName;
                    $email_data['from']     = $email->vFromEmail;
                    /*GeneralHelper::send('ADVISOR_RECEIVED_REQUEST', $email_data);*/
                    GeneralHelper::send_email_notifiction('PREMIUM_SERVICE', $email_data);
                }
            }
        }
        echo "<pre>"; print_r($request->all()); exit;
    }

  
    public function pesapalRequest($amount, $premium_service, $investment_id)
    {
        $userData = session('user');
        if (empty($userData)) {
            return redirect()->route('front.login.index');
        }
        $user_data['iUserId'] = $userData['iUserId'];
        $data['userData'] = User::get_by_id($user_data);
        // if ($data['userData']->is_premium == 1) {
        //     return redirect()->route('front.login.index');
        // }
        if ($amount > 0  && $premium_service> 0 && $investment_id > 0) {
            $submitData['reference'] =  'Mer-'.$premium_service.'-'.$investment_id.'-'.$userData['iUserId'].time();
            $submitData['currency'] = 'KES';
            $submitData['amount'] = $amount;
            $accessToken =  $this->getAccessToken(); 
            $IPNData =    $this->registerIPN($accessToken);
            $paymentData['iUserId']        = $userData['iUserId'];
            $paymentData['merchantReference']        = $submitData['reference'];
            $paymentData['amount']     =  $submitData['amount'];
            $paymentData['ipnNotificationId']     = $IPNData['ipn_id'];
            $paymentData['paymentStatus']        = 0;
            $paymentData['createdAt']   = date("Y-m-d h:i:s");
            $paymentData['updatedAt']   = $paymentData['createdAt'];
            if ($premium_service == 1) {
                $paymentData['service'] = 'NewsLetter';
            } else if ($premium_service == 2) {
                $paymentData['service'] = 'Social Media';
            } else if ($premium_service == 3) {
                $paymentData['service'] = 'Both';
            }
            UserPayments::add($paymentData);
            $submitData['notification_id']  = $IPNData['ipn_id'];
            $submitData['email_address'] = $userData['vEmail'];
            $orderSubmitData = $this->submitOrderRequest($submitData, $accessToken);
            if (isset($orderSubmitData['redirect_url'])) {
                return new RedirectResponse($orderSubmitData['redirect_url']);
            }    
        }   
        
        
    }
}
