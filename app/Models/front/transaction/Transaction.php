<?php
namespace App\Models\front\transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Transaction extends Model
{
    
    use HasFactory;
    protected $table = 'transaction';
    protected $primaryKey = 'iTransactionId';
    public $timestamps = false;
    protected $fillable = ['iTransactionId', 'vUniqueCode', 'iUserId', 'iPlanId', 'vPlanTitle', 'vPlanPrice', 'iNoofConnection', 'iToken', 'vTokenPrice', 'vTotal', 'vPaymentReferenceId', 'eStatus', 'dtAddedDate', 'dtUpdatedDate'];
      
     public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '')
    {
        
        $SQL = DB::table("transaction");
       
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
    public static function get_purchase_token_history($userId)
    {
        $SQL = DB::table("transaction");
        $SQL->where("iUserId", $userId);
        $result = $SQL->get();
        return $result;
    }
     public static function get_by_id($id)
    {   
        $SQL = DB::table("transaction");
        $SQL->where("iTransactionId", $id);
        $result = $SQL->get();
        return $result->first();
    }
    public static function get_by_refrenceId($id)
    {   
        $SQL = DB::table("transaction");
        $SQL->where("vPaymentReferenceId", $id);
        $result = $SQL->get();
        return $result->first();
    }

    public static function add($data)
    {
        $add = DB::table('transaction')->insertGetId($data);
        return $add;
    }
    public static function update_user(array $where = [], array $data = []) {
        $update = DB::table('transaction');
        $update->where($where)->update($data);
        return true;
    }

}
