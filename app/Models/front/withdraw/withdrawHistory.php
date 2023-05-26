<?php
namespace App\Models\front\withdraw;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class withdrawHistory extends Model
{
    
    use HasFactory;
    protected $table = 'withdraw_history';
    protected $primaryKey = 'iWithDrawId';
    public $timestamps = false;
    protected $fillable = [ 'iWithDrawId', 'vUniqueCode', 'iUserId','iWithDrawAmount', 'vConversationID', 'vOriginatorConversationID','vTransactionID', 'iResponseCode', 'vResponseDescription', 'dtAddedDate', 'dtUpdatedDate'];
      
     public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '')
    {
        
        $SQL = DB::table("withdraw_history");
       
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
     public static function get_wallet_balance($id)
    {   
        // \DB::enableQueryLog(); // Enable query log
        $walletAmount = DB::table('withdraw_history')
        ->selectRaw('sum(iWithDrawAmount) as walletAmount,iUserId')
        ->where("iUserId", $id)
        ->get();
        return $walletAmount->first();
    }
    public static function get_by_id($id)
    {   
        $SQL = DB::table("withdraw_history");
        $SQL->where("iWithDrawId", $id);
        $result = $SQL->get();
        return $result->first();
    }
    public static function get_by_cotractId($id)
    {
        $SQL = DB::table("withdraw_history");
        $SQL->where("iContractId", $id);
        $result = $SQL->get();
        return $result->first();   
    }
    public static function get_by_contract_id($id)
    {   
        $SQL = DB::table("withdraw_history");
        $SQL->where("iContractId", $id);
        $result = $SQL->get();
        return $result->first();
    }
     public static function get_by_conversationId($id)
    {   
        $SQL = DB::table("withdraw_history");
        $SQL->where("vConversationID", $id);
        $result = $SQL->get();
        return $result->first();
    }

    public static function add($data)
    {
        $add = DB::table('withdraw_history')->insertGetId($data);
        return $add;
    }
    public static function update_data(array $where = [], array $data = []) {
        $update = DB::table('withdraw_history');
        $update->where($where)->update($data);
        return true;
    }

}
