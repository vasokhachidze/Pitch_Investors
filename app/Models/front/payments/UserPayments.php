<?php

namespace App\Models\front\payments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class UserPayments extends Model
{
    
    use HasFactory;
    protected $table = 'userPayments';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id','iUserId', 'merchantReference', 'orderId', 'amount', 'ipnNotificationId', 'paymentStatus', 'createdAt', 'updatedAt'];
      
    //  public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '',$listingImage='')
    // {
        
    //     $SQL = DB::table("user");
    //     if(!empty($criteria["vUniqueCode"]))
    //     {
    //         $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
    //     }
    //     if(!empty($criteria["eStatus"]))
    //     {
    //         $SQL->where("eStatus", $criteria["eStatus"]);
    //     }       
    //     if(!empty($criteria['column']) || !empty($criteria['order']))
    //     {
    //         $SQL->orderBy($criteria['column'],$criteria['order']);
    //     }   
    //     if($paging == true)
    //     {
    //         $SQL->limit($limit);
    //         $SQL->skip($start);
    //     }
    //     $result = $SQL->get();
    //     return $result;
    // }  
    public static function get_payment_detail($criteria)
    {
        $SQL = DB::table("userPayments");
        if(!empty($criteria['merchantReference']))
        {
            $SQL->where("merchantReference", $criteria["merchantReference"]);
        }
        $result = $SQL->get();
        return $result->first();
    }

    public static function add($data)
    {
        $add = DB::table('userPayments')->insertGetId($data);
        return $add;
    }
    public static function update_userpayments(array $where = [], array $data = []) {
        $update = DB::table('userPayments');
        $update->where($where)->update($data);
        return true;
    }

    // public static function authentication($criteria = array())
    // {
    //     $SQL = DB::table("user");
    //     if($criteria['vAuthCode'])
    //     {
    //         $SQL->where("vAuthCode", $criteria["vAuthCode"]);
    //     }
    //     $result = $SQL->get();
    //     return $result->first();
    // }

    // public static function update_data(array $where = [], array $data = [])
    // {
    //     $iUserId = DB::table('user');
    //     if(!empty($criteria['iUserId']))
    //     {
    //         $iUserId->where('iUserId',$where['iUserId'])->update($data);
    //     }
    //     if(!empty($criteria['vUniqueCode']))
    //     {
    //         $iUserId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
    //     }
    //     return $iUserId;
    // }
}
