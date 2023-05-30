<?php
namespace App\Http\Controllers\front\contract;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\front\plan\Plan;
use App\Models\front\contract\Contract;
use App\Models\front\connection\Connection;
use App\Models\front\contractTransaction\ContractTransaction;
use App\Models\front\withdraw\withdrawHistory;
use App\Models\admin\setting\Setting;
use App\Helper\GeneralHelper;

use Session;

class ContractController extends Controller
{
    public function listing(Request $request)
    {
        $session_data = session('user');
        $iUserId=$session_data['iUserId'];
        if (!empty(session('user')) OR !empty($session_data['iUserId']))
        {
            $criteria=array();
            $criteria['iUserId'] = $iUserId;
            $data['contract_list'] = Contract::get_all_contract_data($criteria);
        }
        $data['wallet_balance']=ContractTransaction::get_wallet_balance($iUserId);
        return view('front.contract.listing')->with($data);
    }
    
    public function advisorCreateContract(Request $request) 
    {
        $data1['eContractStatus']='Created';
        $where1 = array();
        $where1['iConnectionId'] = $request->iConnectionId;
        Connection::update_user($where1, $data1);

        //for geting vUnique code 5 digit
        $session_data = session('user');
        $iUserId = $session_data['iUserId'];
        if (!empty(session('user')) OR !empty($session_data['iUserId']))
        {
            $vUniqueCodeUser = $session_data['vUniqueCode'];
            $getvUnicode=substr($vUniqueCodeUser, 0, 5);
        }
        $payment_setting = Setting::get_setting('Currency');
        $commission = $payment_setting['CONTRACT_FEE']['vValue'];

        $originalAmount = $request->vContractAmount;
        $deductedPercentageAmount = ($originalAmount * $commission)/100;
        $deductedAmount = $originalAmount-$deductedPercentageAmount;
        $amount = $deductedAmount;
        
        $session_data = session('user');
        $data['vUniqueCode'] = md5(uniqid(time()));
        $data['vContractDescription'] = $request->vContractDescription;
        
        $data['vContractTotalAmount'] = $request->vContractAmount;
        $data['vContractAmount'] = $amount;
        $data['vCommissionAmount'] = $deductedPercentageAmount;
        $data['iContractPercentage'] = $commission;

        $data['iContractSenderUserID']=$request->iSenderId;
        $data['iContractReceiverUserID']=$request->iReceiverId;
        $data['vContractCode']        = GeneralHelper::generateUniqueCodePlanContract();

        $data['eContractStatus']='Created';
        $data['dtAddedDate'] = date('Y-m-d H:i:s');
        $data['dtUpdatedDate'] = date('Y-m-d H:i:s');
        $id=Contract::add($data);

        /*
            $data2['iContractId'] = $id;
            $data2['vUniqueCode']=md5(uniqid(time()));
            $data2['iSenderId'] = $request->iSenderId;
            $data2['iReceiverId'] = $request->iReceiverId;
            $data2['vContractDescription'] = $request->vContractDescription;
            
            $data2['vContractTotalAmount'] = $request->vContractAmount;
            $data2['vContractAmount'] = $amount;
            $data2['vCommissionAmount'] = $deductedPercentageAmount;
            $data2['iContractPercentage'] = $commission;

            $data2['ePaymentStatus'] = 'Pending';
            $data2['dtAddedDate'] = date('Y-m-d H:i:s');
            $data2['dtUpdatedDate'] = date('Y-m-d H:i:s');
            ContractTransaction::add($data2);
        */

        echo 0;
    }

    public function mPesaAccessToken_generate()
    {
        $url = $access_token = $shortCode = $passKey = $consumerKey = $consumerSecret = '';
        $timestamp = date('Ymdhis');
        $payment_setting = GeneralHelper::setting_info('Payment');
        // dd($payment_setting);
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
        // dd($consumerKey, $consumerSecret);
        $credentials = base64_encode($consumerKey.':'.$consumerSecret);
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials,"Content-Type:application/json"));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);

        // echo "<pre>"; print_r($curl_response);
        $token=json_decode($curl_response);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            dd($error_msg);
        }else{
            // dd($token);
        }

        curl_close($curl);

        if (!empty($token->access_token)) {
            $access_token = $token->access_token;
        }

        return $access_token;
    }

    public function contract_payment(Request $request)
    {
        $iConnectionId=$request->iConnectionId;
        $iContractId=$request->iContractId;
        $iPhoneNumber=$request->iPhoneNumber;

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
        $this->payment($access_token,$encode_password,$iContractId,$iPhoneNumber,$iConnectionId);
    }

    public function payment($new_access_token,$encode_password,$iContractId,$iPhoneNumber,$iConnectionId)
    {
         info('resuse in ContractController::payment');
        $cData = Contract::get_by_id($iContractId);
        $amount=$cData->vContractAmount;
        
        $url = $access_token = $shortCode = $passKey = '';
        $payment_setting = GeneralHelper::setting_info('Payment');
        if ($payment_setting['PAYMENT_MODE']['vValue'] == 'live') {
            $shortCode = $payment_setting['C2B_SHORT_CODE_LIVE']['vValue'];
            $passKey = $payment_setting['C2B_PASS_KEY_LIVE']['vValue'];
            $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        }
        elseif ($payment_setting['PAYMENT_MODE']['vValue'] == 'sandbox') {
            $shortCode = $payment_setting['C2B_SHORT_CODE_SANDBOX']['vValue'];
            $passKey = $payment_setting['C2B_PASS_KEY_SANDBOX']['vValue'];
            $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        }

        $timestamp = date('Ymdhis');
        $encode_password=base64_encode($shortCode . $passKey . $timestamp);
        
        $curl_post_data = [
            'BusinessShortCode' => $shortCode,
            'Password' => $encode_password,
            'Timestamp' =>$timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $iPhoneNumber,
            'PartyB' => $shortCode,
            'PhoneNumber' => $iPhoneNumber,
            'CallBackURL' => url('/contract-callback/'.$iContractId),
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
       
        if($curl_response)
        {
            session()->put('contract_payment.CheckoutRequestID', $curl_response->CheckoutRequestID);
            session()->put('contract_payment.iConnectionId', $iConnectionId);
            echo 'true';
        }else{
            echo 'false';
        }
    }

    public function contract_callback($iContractId1, Request $request)
    {
        header("Content-Type: application/json");
        $mpesaResponse = file_get_contents('php://input');
        $jsonMpesaResponse = json_decode($mpesaResponse, true);
        
        /*$fp = fopen('./contract_callback_response.txt', 'w');
        fwrite($fp, $mpesaResponse);
        fclose($fp);*/

        /*$session_data = session('contract_payment');
        $iConnectionId= $session_data['iConnectionId'];*/

        // $iContractId=$request->iContractId;
        $status= $jsonMpesaResponse['Body']['stkCallback']['ResultCode'];
        $iContractId = $iContractId1;
        if($status == 0)
        {
            $cData = Contract::get_by_id($iContractId);

            $data['iContractId'] = null;
            $data['vUniqueCode']=md5(uniqid(time()));
            $data['iSenderId'] = $cData->iContractSenderUserID;
            $data['iReceiverId'] = $cData->iContractReceiverUserID;
            $data['vContractDescription'] = $cData->vContractDescription;
            $data['vContractTotalAmount'] = $cData->vContractAmount;
            $data['vContractAmount'] = $cData->vContractAmount;
            $data['vCommissionAmount'] = $cData->vCommissionAmount;
            $data['iContractPercentage'] = $cData->iContractPercentage;
            $data['vPaymentReferenceId']=$jsonMpesaResponse['Body']['stkCallback']['CheckoutRequestID'];
            $data['vMerchantRequestID']=$jsonMpesaResponse['Body']['stkCallback']['MerchantRequestID'];
            $data['vMpesaReceiptNumber']=$jsonMpesaResponse['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
            $data['dtTransactionDate']=$jsonMpesaResponse['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'];
            $data['iPhoneNumber']=$jsonMpesaResponse['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
            $data['vResultCode']=$jsonMpesaResponse['Body']['stkCallback']['ResultCode'];
            $data['vResultDesc']=$jsonMpesaResponse['Body']['stkCallback']['ResultDesc'];
            $data['ePaymentStatus']="Paid";

            $data['dtAddedDate'] = date('Y-m-d H:i:s');
            $data['dtUpdatedDate'] = date('Y-m-d H:i:s');
            ContractTransaction::add($data);

            $data2['eContractStatus']='Closed';
            $where1 = array();
            $where1['iContractId'] = $iContractId;
            Contract::update_data($where1, $data2);

            $data1['eContractStatus']=NULL;
            $where1 = array();
            $where1['iConnectionId'] = $iConnectionId;
            Connection::update_user($where1, $data1);
        }
        else{
            $cData = Contract::get_by_id($iContractId);
            
            $data['iContractId'] = null;
            $data['vUniqueCode']=md5(uniqid(time()));
            $data['iSenderId'] = $cData->iContractSenderUserID;
            $data['iReceiverId'] = $cData->iContractReceiverUserID;
            $data['vContractDescription'] = $cData->vContractDescription;
            $data['vContractTotalAmount'] = $cData->vContractAmount;
            $data['vContractAmount'] = $cData->vContractAmount;
            $data['vCommissionAmount'] = $cData->vCommissionAmount;
            $data['iContractPercentage'] = $cData->iContractPercentage;
            $data['vPaymentReferenceId']=$jsonMpesaResponse['Body']['stkCallback']['CheckoutRequestID'];

            $data['vMerchantRequestID']=$jsonMpesaResponse['Body']['stkCallback']['MerchantRequestID'];
            $data['vMpesaReceiptNumber']=null;
            $data['dtTransactionDate']=null;
            $data['iPhoneNumber']=null;
            $data['vResultCode'] = $jsonMpesaResponse['Body']['stkCallback']['ResultCode'];
            $data['vResultDesc']=$jsonMpesaResponse['Body']['stkCallback']['ResultDesc'];
            $data['ePaymentStatus']="Paid";

            $data['dtAddedDate'] = date('Y-m-d H:i:s');
            $data['dtUpdatedDate'] = date('Y-m-d H:i:s');
            ContractTransaction::add($data);
        }
    }

    public function verify_contract_payment(Request $request)
    {   
        // $session_data = session('contract_payment');
        $session_data1 = $request->session_payment1;
        if (!empty($session_data1))
        {
            $vPaymentReferenceId=$session_data1;
            $getPaymentData = ContractTransaction::get_by_refrenceId($vPaymentReferenceId);
            $message=$getPaymentData->vResultDesc;
            if(!empty($getPaymentData1))
            {
                if($getPaymentData->vResultCode != "")
                {
                    $return_data = ['status'=>1,'error_msg'=>$message];
                    echo json_encode($return_data);
                    session()->forget('contract_payment');
                }else{
                    $return_data = ['status'=>0,'error_msg'=>$message];
                    // $return_data = ['status'=>0,'error_msg'=>'Waiting for response.'];
                    echo json_encode($return_data);
                    session()->forget('contract_payment');
                }
            }else{
                $return_data = ['status'=>0,'error_msg'=>$message];
                // $return_data = ['status'=>0,'error_msg'=>'Waiting for response.'];
                echo json_encode($return_data);
                session()->forget('contract_payment');
            }
        }
    }

    public function withdraw_amount(Request $request)
    {
        $amount=$request->amount;
        $phone=$request->iPhoneNumber;
        $loginUserId=$request->loginUserId;
        $vUniqueCode=$request->vUniqueCode;


        /*
            $consumer_key="n1oy7OgEFvWIzlXGHHl8HoiLoJriQjoC";
            $consumer_secret="gSjdNGi1cq0BdT5B";
            $credentials=base64_encode($consumer_key.':'.$consumer_secret);
            $access_token_url = "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $access_token_url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials,"Content-Type:application/json"));
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $curl_response = curl_exec($curl);
            $token=json_decode($curl_response);
            $access_token= $token->access_token;
            curl_close($curl);
        */
        

        
        $token=json_decode($curl_response);
        $b2c_url="https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest";

        echo $access_token;exit;
        
        $access_token= $this->mPesaAccessToken_generate();
        
        $b2c_url = $access_token = $shortCode = $passKey = '';
        $payment_setting = GeneralHelper::setting_info('Payment');
        if ($payment_setting['PAYMENT_MODE']['vValue'] == 'live') {
            $shortCode = $payment_setting['B2C_SHORT_CODE_LIVE']['vValue'];
            $passKey = $payment_setting['B2C_PASS_KEY_LIVE']['vValue'];
            $b2c_url = "https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest";
        }
        elseif ($payment_setting['PAYMENT_MODE']['vValue'] == 'sandbox') {
            $shortCode = $payment_setting['B2C_SHORT_CODE_SANDBOX']['vValue'];
            $passKey = $payment_setting['B2C_PASS_KEY_SANDBOX']['vValue'];
            $b2c_url = "https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest";
        }
        

        $request_data = array(
            'InitiatorName' => 'Pitchinvestors',
            'SecurityCredential' => " ",
            'CommandID' => 'BusinessPayment',
            'Amount' => $amount,
            'PartyA' => $shortCode,
            'PartyB' => $phone,
            'Remarks' => 'withraw',
            'QueueTimeOutURL' => url('/withdraw-callback/'.$loginUserId.'/'.$amount.'/'.$vUniqueCode),
            'ResultURL' => url('/withdraw-callback/'.$loginUserId.'/'.$amount.'/'.$vUniqueCode),
            'Occasion' => 'christmas'
        );
        $b2c_curl = curl_init();
        curl_setopt($b2c_curl, CURLOPT_URL, $b2c_url);
        curl_setopt($b2c_curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token));
        curl_setopt($b2c_curl, CURLOPT_POST, true);
        curl_setopt($b2c_curl, CURLOPT_POSTFIELDS, $request_data);
        curl_setopt($b2c_curl, CURLOPT_RETURNTRANSFER, true);
        $response     = json_decode(curl_exec($b2c_curl));
        curl_close($b2c_curl);

        if($response)
        {
            session()->put('withdraw_amount.ConversationID', 'AG_20180326_00005ca7f7c21d608166');
            echo json_encode(['key' => 'true', 'vConversationID' => 'AG_20180326_00005ca7f7c21d608166']);
        }else{   
            echo json_encode(['key' => 'false', 'vConversationID' => '']);
        }
    }

    public function withdraw_callback($loginUserId,$amount)
    {
        header("Content-Type: application/json");
        $mpesaResponse = file_get_contents('php://input');
        
        $jsonMpesaResponse = json_decode($mpesaResponse, true);

        $session_data = session('withdraw_amount');
        $loginUserId=$loginUserId;
        $amount=$amount;

        $status= $jsonMpesaResponse['Body']['stkCallback']['ResultCode']; 

        if($status == 0)
        {
            $data['vUniqueCode']=md5(uniqid(time()));
            $data['iUserId']=$loginUserId;
            $data['iWithDrawAmount']=$amount;
            $data['vConversationID']=$jsonMpesaResponse['Body']['stkCallback']['ConversationID'];
            $data['vOriginatorConversationID']=$jsonMpesaResponse['Body']['stkCallback']['OriginatorConversationID'];
            $data['iResponseCode']=$jsonMpesaResponse['Body']['stkCallback']['ResponseCode'];
            $data['vResponseDescription']=$jsonMpesaResponse['Body']['stkCallback']['ResponseDescription'];
            $data['dtAddedDate'] = date('Y-m-d H:i:s');
            $data['dtUpdatedDate'] = date('Y-m-d H:i:s');
            withdrawHistory::add($data);
        }
    }

    public function verify_withdrawal(Request $request)
    {
        $session_data = session('withdraw_amount');
        $session_data_vConversationID = $request->session_withdraw;

        if (!empty($session_data))
        {
            $vConversationID=$session_data_vConversationID;
            $getWithdrawData = withdrawHistory::get_by_conversationId($vConversationID);
            if(!empty($getWithdrawData))
            {
                if(!empty($session_data_vConversationID) == $getWithdrawData->vConversationID)
                {
                    $message=$getWithdrawData->vResponseDescription;
                    if($getWithdrawData->vResultCode != "")
                    {
                       echo $message;
                        session()->forget('withdraw_amount');
                    }else{
                        echo  "Withdrawal Not Done Successfully";
                        session()->forget('withdraw_amount');
                    }
                }
            }
            else{
                echo "Withdrawal Not Done Successfully";
                session()->forget('withdraw_amount');
            }
        }
    }

    public function contract_payment_alternative_callback(Request $request)
    {
        // $access_token = $this->mPesaAccessToken_generate();
        /*echo "123 -- ";
        dd($access_token);*/
        
        // $payment_setting = GeneralHelper::setting_info('Payment');
        /*if ($payment_setting['C2B_PAYMENT_MODE']['vValue'] == 'live') {
            exit('if');
        }*/
        /*dd($payment_setting['C2B_PAYMENT_MODE']);*/

        header("Content-Type: application/json");
        $mpesaResponse = file_get_contents('php://input');
        $jsonMpesaResponse = json_decode($mpesaResponse, true); 
        
        $status= $jsonMpesaResponse['Body']['stkCallback']['ResultCode']; 

        if($status == 0)
        {
            /*
                $cData = Contract::get_by_id($iContractId);
                $data['iContractId'] = $iContractId;
                $data['vUniqueCode']=md5(uniqid(time()));
                $data['iSenderId'] = $cData->iContractSenderUserID;
                $data['iReceiverId'] = $cData->iContractReceiverUserID;
                $data['vContractDescription'] = $cData->vContractDescription;
            */
            $payment_setting = Setting::get_setting('Currency');
            $commission=$payment_setting['CONTRACT_FEE']['vValue'];

            $originalAmount= $jsonMpesaResponse['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
            $deductedPercentageAmount=($originalAmount * $commission)/100;
            $deductedAmount=$originalAmount-$deductedPercentageAmount;
            $amount=$deductedAmount;


            $data['vContractTotalAmount'] = $originalAmount;
            $data['vContractAmount'] = $amount;
            $data['vCommissionAmount'] = $deductedPercentageAmount;
            $data['iContractPercentage'] = $commission;
            $data['vPaymentReferenceId']=$jsonMpesaResponse['Body']['stkCallback']['CheckoutRequestID'];

            $data['vMerchantRequestID']=$jsonMpesaResponse['Body']['stkCallback']['MerchantRequestID'];
            $data['vMpesaReceiptNumber']=$jsonMpesaResponse['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
            $data['dtTransactionDate']=$jsonMpesaResponse['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'];
            $data['iPhoneNumber']=$jsonMpesaResponse['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
            $data['vResultCode']=$jsonMpesaResponse['Body']['stkCallback']['ResultCode'];
            $data['vResultDesc']=$jsonMpesaResponse['Body']['stkCallback']['ResultDesc'];
            $data['ePaymentStatus']="Paid";

            $data['dtAddedDate'] = date('Y-m-d H:i:s');
            $data['dtUpdatedDate'] = date('Y-m-d H:i:s');
            ContractTransaction::add($data);

            $data2['eContractStatus']='Closed';
            $where1 = array();
            $where1['iContractId'] = $iContractId;
            Contract::update_data($where1, $data2);

            $data1['eContractStatus']=NULL;
            $where1 = array();
            $where1['iConnectionId'] = $iConnectionId;
            Connection::update_user($where1, $data1);
        }
    }

    public function contract_payment_validate_alternative(Request $request)
    {
        info('called from somewhere...how did we get here???');
        header("Content-Type: application/json");
        $mpesaValidationResponse = file_get_contents('php://input');

        /* STATIC RESPONSE DATA */
        // $mpesaValidationResponse = '{"TransactionType":"","TransID":"YUNV2HE5W9","TransTime":"20230118085842","TransAmount":"10","BusinessShortCode":"700000","BillRefNumber":"yT7Be#R8T","InvoiceNumber":"","OrgAccountBalance":"","ThirdPartyTransID":"","MSISDN":"2547 ***** 149","FirstName":"John"}';
        
        $jsonMpesaValidationResponse = json_decode($mpesaValidationResponse, true);
        $amount = $jsonMpesaValidationResponse['TransAmount'];
        
        $jsonMpesaValidationResponse['BillRefNumber'];
        $allUniqueId = explode('#', $jsonMpesaValidationResponse['BillRefNumber']);
        $userAccNo = $allUniqueId[0];
        $planCode = $allUniqueId[1];
        
        $planData = Plan::get_by_vPlanCode($planCode);
        $userData = GeneralHelper::get_user_by_vAccNo($userAccNo);
        if ($planData != null && $userData != null) {
            echo json_encode(['ResultCode'=>0,'ResultDesc'=>'Success']);
        }
        else{
            echo json_encode(['ResultCode'=>254,'ResultDesc'=>'Failed']);
        }
    }
}

?>