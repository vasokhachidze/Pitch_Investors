<?php

namespace App\Models\front\user;

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
      
     public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '',$listingImage='')
    {
        
        $SQL = DB::table("user");
        if(!empty($criteria["vUniqueCode"]))
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("eStatus", $criteria["eStatus"]);
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
     public static function get_by_id($criteria)
    {
        $SQL = DB::table("user");
        if(!empty($criteria['iUserId']))
        {
            $SQL->where("iUserId", $criteria["iUserId"]);
        }
        if(!empty($criteria['vUniqueCode']))
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
    public static function update_user(array $where = [], array $data = []) {
        $update = DB::table('user');
        $update->where($where)->update($data);
        return true;
    }

    public static function authentication($criteria = array())
    {
        $SQL = DB::table("user");
        if($criteria['vAuthCode'])
        {
            $SQL->where("vAuthCode", $criteria["vAuthCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }

    public static function update_data(array $where = [], array $data = [])
    {
        $iUserId = DB::table('user');
        if(!empty($criteria['iUserId']))
        {
            $iUserId->where('iUserId',$where['iUserId'])->update($data);
        }
        if(!empty($criteria['vUniqueCode']))
        {
            $iUserId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        }
        return $iUserId;
    }
}
