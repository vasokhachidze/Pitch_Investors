<?php
namespace App\Http\Controllers\front\token;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\front\connection\Connection;
use App\Models\front\transaction\Transaction;

use Session;

class TokenController extends Controller
{
    public function listing(Request $request) 
    {
        $session_data = session('user');
        if (!empty(session('user')) OR !empty($session_data['iUserId'])) 
        {
            $iUserId = $session_data['iUserId'];
            $data['connection_list'] = Connection::get_connection($iUserId);
        }
        $data['hold_token']=Connection::get_hold_connection($iUserId);
       
        $data['purchase_token']=Transaction::get_purchase_token_history($iUserId);
        return view('front.token.listing')->with($data);
    }
}
