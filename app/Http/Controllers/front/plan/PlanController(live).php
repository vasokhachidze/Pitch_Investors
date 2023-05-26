<?php
namespace App\Http\Controllers\front\plan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\front\plan\Plan;
use App\Models\front\transaction\Transaction;
use App\Libraries\Paginator;
use App\Libraries\General;
use App\Models\front\user\User;
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

    public function plan_purchase(Request $request)
    {
        $loginUserId=$request->loginUserId;
        $iPlanId=$request->iPlanId;
        $vPhoneNumber=$request->vPhoneNumber;

        $consumer_key="n1oy7OgEFvWIzlXGHHl8HoiLoJriQjoC";
        $consumer_secret="gSjdNGi1cq0BdT5B";
        $shortKey="4098707";
        $credentials=base64_encode($consumer_key.':'.$consumer_secret);
        $passkey='98eea13a30bb6557930f9742e51846b0b78fcfdb37c7c286f406bedc9255d185';
        $timestamp = date('Ymdhis');
        $encode_password=base64_encode($shortKey . $passkey . $timestamp);

       // $url = "https://api.sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
       $url = "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";


       $curl = curl_init();
       curl_setopt($curl, CURLOPT_URL, $url);
       curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials,"Content-Type:application/json"));
       curl_setopt($curl, CURLOPT_HEADER, false);
       curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
       $curl_response = curl_exec($curl);
       $token=json_decode($curl_response);
       curl_close($curl);
       // dd($token);
       $access_token= $token->access_token;

         $this->payment($access_token,$encode_password,$loginUserId,$iPlanId,$vPhoneNumber,$timestamp);        
    }

    public function payment($new_access_token,$encode_password,$loginUserId,$iPlanId,$vPhoneNumber,$timestamp)
    {
        $criteria = array();
        $criteria['vUniqueCode']        = $iPlanId;
        $planData = Plan::get_by_uniqueCode($criteria);

        $planId=$planData->iPlanId;
        $vPlanTitle=$planData->vPlanTitle;
        $vPlanPrice=$planData->vPlanPrice;
        $iNoofConnection=$planData->iNoofConnection;
        
        //$timestamp = date('Ymdhis');

        $shortKey="4098707";
        $passkey='98eea13a30bb6557930f9742e51846b0b78fcfdb37c7c286f406bedc9255d185';
        $timestamp = date('Ymdhis');
        $encode_password=base64_encode($shortKey . $passkey . $timestamp);

       $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
       $curl_post_data = [
            'BusinessShortCode' => 4098707,
            'Password' => $encode_password,
            'Timestamp' =>$timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $vPlanPrice,
            'PartyA' => $vPhoneNumber,
            'PartyB' => 4098707,
            'PhoneNumber' => $vPhoneNumber,
            'CallBackURL' => 'https://pitch-investor.demo-available.com/plan-callback',
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
       
       echo "<pre>";
       print_r($curl_response);
       echo "</pre>";
       exit();
       if(isset($curl_response->ResponseCode) && $curl_response->ResponseCode == 0)
       {

            $data2['iUserId']=$loginUserId;
            $data2['vUniqueCode']=md5(uniqid(time()));
            $data2['iPlanId']=$planId;
            $data2['vPlanTitle']=$vPlanTitle;
            $data2['vPlanPrice']=$vPlanPrice;
            $data2['iNoofConnection']=$iNoofConnection;
            $data2['iToken']=$iNoofConnection;
            $data2['vTokenPrice']=$vPlanPrice;
            $data2['vPaymentReferenceId']=$curl_response->CheckoutRequestID;
            $data2['eStatus']='Pending';
            $data2['dtAddedDate']=date("Y-m-d h:i:s");
            $data2['dtUpdatedDate']=date("Y-m-d h:i:s");
            Transaction::add($data2);

            $criteria=array();
            $criteria['iUserId']=$loginUserId;
            $userdata= User::get_by_id($criteria);
            $oldToken=$userdata->iTotalToken;

            $user_data['iTotalToken']=$oldToken+$iNoofConnection;
            $user_where = ['iUserId'=> $loginUserId];
            User::update_user($user_where,$user_data);
                
          $message="Payment successfully completed";
          return redirect()->route('front.token.listing')->withSuccess($message);
       }else
       {

         $message="Payment not successfully completed";

              return Redirect::route('front.plan.listing')->with();

        // return redirect()->route('front.plan.listing')->withSuccess($message);
       }
       // print_r($curl_response);*/
       
    }

    public function plan_callback(Request $request)
    {

        $user_data['paymentstatus']="Done111";
        $user_where = ['iTransactionId'=> 9];
        Transaction::update_user($user_where,$user_data);

        // paymentstatus
    }
}
