<?php
namespace App\Models\front\contract;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Contract extends Model
{
    
    use HasFactory;
    protected $table = 'contract';
    protected $primaryKey = 'icontractId';
    public $timestamps = false;
    protected $fillable = ['iContractId', 'vUniqueCode', 'iContractSenderUserID', 'iContractReceiverUserID', 'vContractDescription', 'vContractTotalAmount', 'vContractAmount', 'vCommissionAmount', 'iContractPercentage', 'eContractStatus', 'dtAddedDate', 'dtUpdatedDate'];
      
     public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '')
    {
        $SQL = DB::table("contract");

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
     public static function get_all_contract_data($criteria=array())
    {
        // \DB::enableQueryLog(); // Enable query log

        $SQL = DB::table("contract")
        ->select('contract.iContractId','contract.iContractSenderUserID','contract.iContractReceiverUserID','contract.dtAddedDate','contract.vContractAmount',
        DB::raw("(SELECT CONCAT(user.vFirstName, ' ', user.vLastName) FROM user WHERE contract.iContractSenderUserID = user.iUserId) as contractSenderName"),
        DB::raw("(SELECT CONCAT(user.vFirstName, ' ', user.vLastName) FROM user WHERE contract.iContractReceiverUserID = user.iUserId) as contractReceiverName"),
        DB::raw("(SELECT CONCAT(user.vPhone) FROM user WHERE contract.iContractReceiverUserID = user.iUserId) as vPhone"),

        );

         $SQL->Where( function ($query) use ($criteria)
            {
                if($criteria['iUserId'])
                {
                    $query->where("iContractSenderUserID", $criteria["iUserId"])
                        ->orWhere("iContractReceiverUserID", $criteria["iUserId"]);
                }
            });

        if(!empty($criteria['column']) || !empty($criteria['order']))
        {
            $SQL->orderBy($criteria['column'],$criteria['order']);
        }
        // $SQL->groupBy('user.iUserId');        
        $result = $SQL->get();
        // dd(\DB::getQueryLog()); // Show results of log

        return $result;
    }
     public static function get_contract_data($criteria=array())
    {   
        \DB::enableQueryLog(); // Enable query log

        $SQL = DB::table("contract");
        
         /*if(!empty($criteria["iContractSenderUserID"]))
        {
            $SQL->where("iContractSenderUserID", $criteria["iSenderId"]);
        }
        if(!empty($criteria["iContractReceiverUserID"]))
        {
            $SQL->where("iContractReceiverUserID", $criteria["iReceiverId"]);
        }*/
        $SQL->Where( function ($query) use ($criteria)
            {
                if($criteria['iUserId'])
                {
                    $query->where("iContractSenderUserID", $criteria["iUserId"])
                        ->orWhere("iContractReceiverUserID", $criteria["iUserId"]);
                }
            });
         if(!empty($criteria["eContractStatus"]))
        {
            $SQL->where("eContractStatus", $criteria["eContractStatus"]);
        }

        $result = $SQL->get();
        // dd(\DB::getQueryLog()); // Show results of log
        return $result->last();
    }     
     public static function get_by_id($id)
    {   
        $SQL = DB::table("contract");
        $SQL->where("iContractId", $id);
        $result = $SQL->get();
        return $result->first();
    }
    
    public static function add($data)
    {
        $add = DB::table('contract')->insertGetId($data);
        return $add;
    }
    public static function update_data(array $where = [], array $data = []) {
        $update = DB::table('contract');
        $update->where($where)->update($data);
        return true;
    }

}
