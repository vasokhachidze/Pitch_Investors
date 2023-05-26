<?php
namespace App\Models\admin\contract;

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
        // \DB::enableQueryLog();

        $SQL = DB::table("contract")
        ->select('contract.iContractId','contract.iContractSenderUserID','contract.iContractReceiverUserID','contract.dtAddedDate','contract.vContractAmount','contract.vUniqueCode','contract.vCommissionAmount','contract.iContractPercentage',
        DB::raw("(SELECT CONCAT(user.vFirstName, ' ', user.vLastName) FROM user WHERE contract.iContractSenderUserID = user.iUserId) as contractSenderName"),
        DB::raw("(SELECT CONCAT(user.vFirstName, ' ', user.vLastName) FROM user WHERE contract.iContractReceiverUserID = user.iUserId) as contractReceiverName"),
        DB::raw("(SELECT CONCAT(user.vPhone) FROM user WHERE contract.iContractReceiverUserID = user.iUserId) as vPhone"),

        );
        /*if(!empty($criteria["contractSenderName"]))
        {
            $SQL->where('user.vFirstName', 'like', '%' . $criteria['contractSenderName'] . '%');
        }
        if(!empty($criteria["contractReceiverName"]))
        {
            $SQL->where('user.vFirstName', 'like', '%' . $criteria['contractSenderName'] . '%');
        } */
        if(!empty($criteria["vContractAmount"]))
        {
            $SQL->where("contract.vContractAmount", $criteria["vContractAmount"]);
        }
        if(!empty($criteria["vCommissionAmount"]))
        {
            $SQL->where("contract.vCommissionAmount", $criteria["vCommissionAmount"]);
        } 
        if(!empty($criteria["iContractPercentage"]))
        {
            $SQL->where("contract.iContractPercentage", $criteria["iContractPercentage"]);
        }
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

        // dd(\DB::getQueryLog());

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
        $SQL = DB::table("contract");
        
         if(!empty($criteria["iContractSenderUserID"]))
        {
            $SQL->where("iContractSenderUserID", $criteria["iSenderId"]);
        }
        if(!empty($criteria["iContractReceiverUserID"]))
        {
            $SQL->where("iContractReceiverUserID", $criteria["iReceiverId"]);
        } if(!empty($criteria["eContractStatus"]))
        {
            $SQL->where("eContractStatus", $criteria["eContractStatus"]);
        }

        $result = $SQL->get();
        return $result->first();
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
