<?php
namespace App\Models\front\connection;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Connection extends Model
{
    
    use HasFactory;
    protected $table = 'connection';
    protected $primaryKey = 'iConnectionId';
    public $timestamps = false;
    protected $fillable = ['iConnectionId','iSenderId', 'iReceiverId', 'eSenderProfileType', 'eReceiverProfileType', 'iSenderProfileId', 'iReceiverProfileId', 'vSenderProfileTitle', 'vReceiverProfileTitle', 'vSenderContactPersonName', 'vReceiverContactPersonName','vSenderMobNo','vReceiverMobNo','vMessage','eConnectionStatus','dtAddedDate','dtUpdatedDate'];
      
     public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '',$listingImage='')
    {
        
        $SQL = DB::table("connection");
       
        if(!empty($criteria['column']) || !empty($criteria['order']))
        {
            $SQL->orderBy($criteria['column'],$criteria['order']);
        }   
        if($paging == true)
        {
            $SQL->limit($limit);
            $SQL->skip($start);
        }
        $result = $SQL->get();
        return $result;
    }  
    public static function get_connection($userId)
    {
        $SQL = DB::table("connection");
        $SQL->where("iSenderId", $userId);
        $result = $SQL->get();
        return $result;
    }public static function get_hold_connection($userId)
    {
         $HoldToken = DB::table('connection')
        ->selectRaw('count(eConnectionStatus) as holdToken,iSenderId,iReceiverId')
        ->where("eConnectionStatus", 'Hold');

          $HoldToken->Where( function ($query) use ($userId)
            {
                if($userId)
                {
                    $query->where("iSenderId", $userId)
                        ->orWhere("iReceiverId", $userId);
                }
            });

        $HoldToken->get();
        return $HoldToken->first();

    }
     public static function get_by_id($id)
    {   
        $SQL = DB::table("connection");
        $SQL->where("iConnectionId", $id);
        $result = $SQL->get();
        return $result->first();
    }

    public static function add($data)
    {
        $add = DB::table('connection')->insertGetId($data);
        return $add;
    }
    public static function update_user(array $where = [], array $data = []) {
        $update = DB::table('connection');
        $update->where($where)->update($data);
        return true;
    }

}
