<?php

namespace App\Http\Controllers\payments\mpesa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MPESAController extends Controller
{
    public function getAccessToken()
    {
        // $url = config('app.mpesa.MPESA_ENV') == 0
        // ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
        // : 'https://api.safaricom.co.ke/oauth/v1/generate';

        //Log::info(config('app.mpesa.MPESA_CONSUMER_KEY') . ':' . config('app.mpesa.MPESA_CONSUMER_SECRET'));
        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $ch = curl_init($url);
        $credentials = base64_encode('92ao5ulsLuAfX6devSc30dJHr33Hd3oI'.':'.'L81vDVrqaG0P0y3I');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic '.$credentials]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, SSL_VERIFYPEER);
        $response = curl_exec($ch);
        curl_close($ch);
		$access_token=json_decode($response);
		$access_token= $access_token->access_token;
        //return $access_token->access_token;


        /*$curl = curl_init($url);
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_HTTPHEADER => ['Content-Type: application/json; charset=utf8'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_USERPWD => config('app.mpesa.MPESA_CONSUMER_KEY') . ':' . config('app.mpesa.MPESA_CONSUMER_SECRET')
            )
        );
        $response = json_decode(curl_exec($curl));
        curl_close($curl);*/

        // Log::info($access_token);
        return $access_token;
    }

    /**
     * Register URL
     */
    public function registerURLS()
    {
        $body = array(
            'ShortCode' => env('MPESA_SHORTCODE'),
            'ResponseType' => 'Completed',
            'ConfirmationURL' => env('MPESA_TEST_URL') . '/api/confirmation',
            'ValidationURL' => env('MPESA_TEST_URL') . '/api/validation'
        );

        $url = '/c2b/v1/registerurl';
        $response = $this->makeHttp($url, $body);

        return $response;
    }

        /**
     * Simulate Transaction
     */
    public function simulateTransaction(Request $request)
    {
        $body = array(
            'ShortCode' => env('MPESA_SHORTCODE'),
            'Msisdn' => '254708374149',
            'Amount' => $request->amount,
            // 'BillRefNumber' => $request->account,
            'CommandID' => 'CustomerBuyGoodsOnline'
        );

        $url =  '/c2b/v1/simulate';
        $response = $this->makeHttp($url, $body);

        return $response;
    }

    /**
     * STK Push
     */
    public function stkPush(Request $request)
    {

        $timestamp = date('YmdHis');
        $MPESA_STK_SHORTCODE ='';
        $MPESA_PASSKEY = '';
        // $password = base64_encode(config('app.mpesa.MPESA_STK_SHORTCODE').config('app.mpesa.MPESA_PASSKEY').$timestamp);
        $password = base64_encode($MPESA_STK_SHORTCODE.$MPESA_PASSKEY.$timestamp);

        $curl_post_data = array(
            'BusinessShortCode' => $MPESA_STK_SHORTCODE,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $request->amount,
            'PartyA' => $request->phone,
            'PartyB' =>$MPESA_STK_SHORTCODE,
            'PhoneNumber' => $request->phone,
            'CallBackURL' => config('app.url'). '/api/stkpush',
            'AccountReference' => $request->account,
            'TransactionDesc' => $request->account
          );

        $url = 'stkpush/v2/processrequest';

        $response = $this->makeHttp($url, $curl_post_data);
        //Log::info('reached here');
        return $response;
    }


    public function makeHttp($url, $body)
    {
        // $url = 'https://mpesa-reflector.herokuapp.com' . $url;
        /*$url = 'https://api.safaricom.co.ke/mpesa/' . $url;
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                    CURLOPT_URL => $url,
                    CURLOPT_HTTPHEADER => array('Content-Type:application/json','Authorization: Bearer '. $this->getAccessToken()),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode($body)
                )
        );
        $curl_response = curl_exec($curl);
        curl_close($curl);
        return $curl_response;*/



        $accessToken =  $this->getAccessToken();
        $ch = curl_init('https://api.safaricom.co.ke/mpesa/' . $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '.$accessToken,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($body));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, SSL_VERIFYPEER);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
