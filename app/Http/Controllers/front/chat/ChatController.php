<?php
namespace App\Http\Controllers\front\chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\front\chat\Chat;
use Session;
use App\Models\front\user\User;
use App\Models\front\advisor\BusinessAdvisor;
use App\Models\front\contract\Contract;
use App\Models\front\connection\Connection;
use DB;


class ChatController extends Controller
{
    public function connectionList(Request $request)
    {
        $session_data = session('user');
        if (!empty(session('user')) OR !empty($session_data['iUserId'])) {
            $criteria["iSenderId"] = $session_data['iUserId'];
            $criteria["iReceiverId"] = $session_data['iUserId'];
            $data['data'] = Chat::connectionListing($criteria);

            $criteria2['eContractStatus']='Created';
            $criteria2["iUserId"] = $session_data['iUserId'];
            // \DB::enableQueryLog();
            $data['contract_data']=Contract::get_contract_data($criteria2);
            // dd(\DB::getQueryLog());

           
            return view('front.chat.ajax_chat_listing')->with($data);
        }
    }

    public function chatHistory(Request $request)
    {
        $session_data = session('user');

        if (!empty($request->iSenderId) OR !empty($request->iReceiverId)) {
            $criteria["iConnectionId"]= $request->iConnectionId;
            $criteria['iSenderId'] = $request->iSenderId;
            $criteria['iReceiverId'] = $request->iReceiverId;
            $criteria['eRead'] = $request->read;
            
            if($session_data['iUserId'] == $request->msgRecId  && $request->read == "No")
            {
                 $where =['iSenderId'=> $request->msgSenderId,'iReceiverId'=> $request->msgRecId];
                 $data['eRead']='Yes';
                 Chat::update_read_status($where,$data);
            }

            $data['data'] = Chat::chatHistory($criteria);
            
            $data['vReceiverContactPersonName'] = $request->vReceiverContactPersonName;
            $data['iConnectionId'] = $request->iConnectionId;
            $data['iSenderId'] = $request->iSenderId;
            $data['iReceiverId'] = $request->iReceiverId;
            return view('front.chat.ajax_chat_history')->with($data);
        }
    }

    public function chatSend(Request $request) {
        $session_data = session('user');
        if ($session_data['iUserId'] == $request->iSenderId) {
            $data['iSenderId'] = $request->iSenderId;
            $data['iReceiverId'] = $request->iReceiverId;
        }
        else {
            $data['iSenderId'] = $request->iReceiverId;
            $data['iReceiverId'] = $request->iSenderId;
        }
        $data['iConnectionId'] = $request->iConnectionId;
        $data['vMessage'] = $request->vMessage;
        $data['eRead'] = 'No';
        $data['dtAddedDate'] = date('Y-m-d H:i:s');
        Chat::add($data);
        return true;
    }


   
}
