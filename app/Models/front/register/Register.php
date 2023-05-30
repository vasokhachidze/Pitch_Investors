<?php

namespace App\Models\front\register;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Register extends Model
{
    
    use HasFactory;
    protected $table = 'user';
    protected $primaryKey = 'iUserId';
    public $timestamps = false;
    protected $fillable = ['iUserId','vFirstName', 'vLastName', 'username', 'vEmail', 'password', 'vImage', 'addedBy', 'vPhone', 'dDOB', 'eStatus','dtAddedDate','dtUpdatedDate'];
        
    public static function add($data)
    {
        $add = DB::table('user')->insertGetId($data);
        return $add;
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
        $iUserId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iUserId;
    }  
    public static function update_accountNo_data(array $where = [], array $data = [])
    {
        $iUserId = DB::table('user');
        $iUserId->where('iUserId',$where['iUserId'])->update($data);
        return $iUserId;
    }

    public static function email_exist($criteria = array())
    {
        $SQL = DB::table("user");
        if($criteria['vEmail'])
        {
            $SQL->where("vEmail", $criteria["vEmail"]);
            $SQL->where("eStatus", 'Active');
        }
        $result = $SQL->get();
        return $result->first();
    }
}
