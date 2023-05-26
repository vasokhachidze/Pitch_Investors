<?php
namespace App\Models\front\contractTransaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class ContractTransaction extends Model
{
    
    use HasFactory;
    protected $table = 'contractTransaction';
    protected $primaryKey = 'iContractTransactionId';
    public $timestamps = false;
    protected $fillable = [ 'iContractTransactionId', 'vUniqueCode', 'iContractId', 'iSenderId', 'iReceiverId', 'vContractDescription', 'vContractAmount', 'vPaymentReferenceId', 'ePaymentStatus', 'dtAddedDate', 'dtUpdatedDate'];
      
     public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '')
    {
        
        $SQL = DB::table("contractTransaction");
       
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
        $walletAmount = DB::table('contractTransaction')
        ->selectRaw('sum(vContractAmount) as walletAmount,iSenderId')
        ->where("iSenderId", $id)
        ->orWhere("iReceiverId", $id)
        ->get();
        return $walletAmount->first();
    }
    public static function get_by_id($id)
    {   
        $SQL = DB::table("contractTransaction");
        $SQL->where("iContractTransactionId", $id);
        $result = $SQL->get();
        return $result->first();
    }
    public static function get_by_cotractId($id)
    {
        $SQL = DB::table("contractTransaction");
        $SQL->where("iContractId", $id);
        $result = $SQL->get();
        return $result->first();   
    }
    public static function get_by_contract_id($id)
    {   
        $SQL = DB::table("contractTransaction");
        $SQL->where("iContractId", $id);
        $result = $SQL->get();
        return $result->first();
    }
     public static function get_by_refrenceId($id)
    {   
        $SQL = DB::table("contractTransaction");
        $SQL->where("vPaymentReferenceId", $id);
        $result = $SQL->get();
        return $result->first();
    }

    public static function add($data)
    {
        $add = DB::table('contractTransaction')->insertGetId($data);
        return $add;
    }
    public static function update_data(array $where = [], array $data = []) {
        $update = DB::table('contractTransaction');
        $update->where($where)->update($data);
        return true;
    }

}
