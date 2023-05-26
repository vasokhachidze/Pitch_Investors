<?php

namespace App\Models\admin\user;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class User extends Model
{
    
    use HasFactory;
    protected $table = 'user';
    protected $primaryKey = 'iUserId';
    public $timestamps = false;
    protected $fillable = ['iUserId','vFirstName', 'vLastName', 'username', 'vEmail', 'password', 'vImage', 'addedBy', 'vPhone', 'dDOB', 'eStatus','dtAddedDate','dtUpdatedDate'];
    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '')
    {
        $SQL = DB::table("user");
        if(!empty($criteria["vName"]))
        {
            $SQL->where(function ($query) use ($criteria)
            {
                $query->where('vFirstName', 'like', '%' . $criteria['vName'] . '%');
                $query->orwhere('vLastName','LIKE','%'.$criteria['vName'].'%');
            });
        }
        if(!empty($criteria["vEmail"]))
        {
            $SQL->where('vEmail', 'like', '%' . $criteria['vEmail'] . '%');
        }
        if(!empty($criteria["vPhone"]))
        {
            $SQL->where('vPhone', 'like', '%' . $criteria['vPhone'] . '%');
        }
        if(!empty($criteria["status_search"]))
        {
            $SQL->where("eStatus", $criteria["status_search"]);
        }
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria["eIsDeleted"]))
        {
            $SQL->where("eIsDeleted", $criteria["eIsDeleted"]);
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
        return $result;
    }
    public static function get_by_id($criteria = array())
    {
        $SQL = DB::table("user");
        if($criteria['vUniqueCode'])
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
    public static function add($data)
    {
        $add = DB::table('user')->insertGetId($data);
        return $add;
    }
    public static function update_data(array $where = [], array $data = [])
    {
        $iUserId = DB::table('user');
        $iUserId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iUserId;
    }
    
    public static function check_unique_email($criteria = array()) // criteria only.
    {
        $SQL = DB::table("user");
        $SQL->where('vEmail', $criteria['vEmail'] );
        if($criteria['vUniqueCode'])
        {
            $SQL->where('vUniqueCode','<>',$criteria['vUniqueCode']);
        }
        $result = $SQL->get();
        return $result->first();
    }
}
