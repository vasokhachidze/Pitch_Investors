<?php
namespace App\Models\front\chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Chat extends Model
{
    public static function connectionListing($criteria = []) 
    {
        // \DB::enableQueryLog();

        $SQL = DB::table("connection")
        ->select('connection.iConnectionId','connection.iSenderId', 'connection.iReceiverId', 'connection.vSenderMobNo', 'connection.vReceiverMobNo','connection.eSenderProfileType','connection.eReceiverProfileType','connection.eConnectionStatus','eContractStatus',
        DB::raw("(SELECT CONCAT(user.vFirstName, ' ', user.vLastName) FROM user WHERE connection.iSenderId = user.iUserId) as senderName"),
            DB::raw("(SELECT CONCAT(user.vFirstName, ' ', user.vLastName) FROM user WHERE connection.iReceiverId = user.iUserId) as receiverName"),
            DB::raw("(SELECT vImage FROM user WHERE connection.iSenderId = user.iUserId) as senderImage"),
            DB::raw("(SELECT vImage FROM user WHERE connection.iReceiverId = user.iUserId) as receiverImage"),
            DB::raw("(SELECT vMessage FROM chat WHERE (connection.iSenderId = chat.iSenderId AND connection.iReceiverId = chat.iReceiverId) OR (connection.iSenderId = chat.iReceiverId AND connection.iReceiverId = chat.iSenderId)  ORDER BY iChatId DESC LIMIT 1) as vMessage"),
            DB::raw("(SELECT eRead FROM chat WHERE (connection.iSenderId = chat.iSenderId AND connection.iReceiverId = chat.iReceiverId) OR (connection.iSenderId = chat.iReceiverId AND connection.iReceiverId = chat.iSenderId)  ORDER BY iChatId DESC LIMIT 1) as eRead"),
            DB::raw("(SELECT chat.iReceiverId FROM chat WHERE (connection.iSenderId = chat.iSenderId AND connection.iReceiverId = chat.iReceiverId) OR (connection.iSenderId = chat.iReceiverId AND connection.iReceiverId = chat.iSenderId)  ORDER BY iChatId DESC LIMIT 1) as iMessageReceiverId"),
            DB::raw("(SELECT chat.iSenderId FROM chat WHERE (connection.iSenderId = chat.iSenderId AND connection.iReceiverId = chat.iReceiverId) OR (connection.iSenderId = chat.iReceiverId AND connection.iReceiverId = chat.iSenderId)  ORDER BY iChatId DESC LIMIT 1) as iMessageSenderId"),
        );
        $SQL->Where( function ($query) use ($criteria)
            {
                if($criteria['iSenderId'] AND $criteria['iReceiverId'])
                {
                    $query->where("iSenderId", $criteria["iSenderId"])
                        ->orWhere("iReceiverId", $criteria["iReceiverId"]);
                }
            });

        $SQL->whereNotIn("eConnectionStatus",['Hold','Reject']);
        $SQL->groupBy('connection.iSenderId','connection.iReceiverId');
        // $result = $SQL->get();
        // dd(\DB::getQueryLog());
        
        return $result = $SQL->get();
    }
    public static function chatHistory($criteria = []) 
    {
        $SQL = DB::table('chat');
        if($criteria['iReceiverId'] OR $criteria['iSenderId'])
        {
            $SQL->where( function ($query) use ($criteria)
            {
                $query->where( 'iReceiverId', '=', $criteria["iReceiverId"] )
                    ->where( 'iSenderId', '=', $criteria["iSenderId"] );
            });
            $SQL->orWhere( function ($query) use ($criteria)
            {
                $query->where( 'iReceiverId', '=', $criteria["iSenderId"] )
                    ->where( 'iSenderId', '=', $criteria["iReceiverId"] );
            });
        }
        return $result = $SQL->get();
    }

    public static function add($data) {
        $add = DB::table('chat')->insertGetId($data);
        return $add;
    }
    public static function update_read_status(array $where = [], array $data = []) 
    {
        // \DB::enableQueryLog();
        $update = DB::table('chat');
        $update->where($where)->update($data);
        // dd(\DB::getQueryLog());
        return true;
    }

    public static function update_data($table = '', $where_field = '', $where_value = '', array $data = []) {
        $updated_data = DB::table($table);
        $updated_data->where($where_field,$where_value)->update($data);
        return $updated_data;
    }
}
