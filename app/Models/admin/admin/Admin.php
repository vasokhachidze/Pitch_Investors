<?php

namespace App\Models\admin\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'admin';
    protected $primaryKey = 'iAdminId';
    public $timestamps = false;
    protected $fillable = ['iAdminId','vFirstName', 'vLastName', 'username', 'email', 'password', 'vImage', 'vPhone', 'eStatus','dtAddedDate','dtUpdatedDate'];
    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '')
    {
        $SQL = DB::table("admin");
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
            $SQL->where('email', 'like', '%' . $criteria['vEmail'] . '%');
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
        $SQL = DB::table("admin");
        if($criteria['vUniqueCode'])
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
    public static function add($data)
    {
        $add = DB::table('admin')->insertGetId($data);
        return $add;
    }
    public static function update_data(array $where = [], array $data = [])
    {
        $iAdminId = DB::table('admin');
        $iAdminId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iAdminId;
    }
    
    public static function check_unique_email($criteria = array()) // criteria only.
    {
        $SQL = DB::table("admin");
        $SQL->where('email', $criteria['email'] );
        if($criteria['vUniqueCode'])
        {
            $SQL->where('vUniqueCode','<>',$criteria['vUniqueCode']);
        }
        $result = $SQL->get();
        return $result->first();
    }
}
