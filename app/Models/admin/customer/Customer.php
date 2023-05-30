<?php

namespace App\Models\admin\customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customer';
    protected $primaryKey = 'iCustomerId';
    protected $fillable = ['vUniqueCode', 'vFirstName', 'vLastName', 'vEmailId', 'eGender', 'vProfilePic', 'eIsDeleted', 'eStatus', 'dtCreatedAt', 'dtUpdatedAt'];

    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '') {
        $SQL = DB::table('customer');
        if(!empty($criteria["vName"])) {
            $SQL->where(function ($query) use ($criteria) 
            {
                $query->where('vFirstName', 'like', '%' . $criteria['vName'] . '%');
                $query->orwhere('vLastName','LIKE','%'.$criteria['vName'].'%');
            });
        }
        if(!empty($criteria["vEmailId"])) {
            $SQL->where('vEmailId', 'like', '%' . $criteria['vEmailId'] . '%');
        }

        if(!empty($criteria["eStatus"])) {
            $SQL->where('eStatus', 'like', '%' . $criteria['eStatus'] . '%');
        }
        if(!empty($criteria["eIsDeleted"])) {
            $SQL->where("eIsDeleted", $criteria["eIsDeleted"]);
        }
        if(!empty($criteria['column']) || !empty($criteria['order'])) {
            $SQL->orderBy($criteria['column'],$criteria['order']);
        }   
        if($paging == true) {
            $SQL->limit($limit);
            $SQL->skip($start);
        }
        // \DB::enableQueryLog();
        $result = $SQL->get();
        // dd(\DB::getQueryLog());
        return $result;
    }

    public static function update_data(array $where = [], array $data = []) {
        $iUserId = DB::table('customer');
        $iUserId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iUserId;
    }
    public static function add($data) {
        $add = DB::table('customer')->insertGetId($data);
        return $add;
    }

    public static function get_by_id($criteria = array()) {
        $SQL = DB::table("customer");
        if($criteria['vUniqueCode']) {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
}