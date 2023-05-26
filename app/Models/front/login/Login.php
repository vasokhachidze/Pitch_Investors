<?php

namespace App\Models\front\login;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Login extends Model
{
    use HasFactory;

    protected $table = 'user';
    protected $primaryKey = 'iUserId';
    public $timestamps = false;
    protected $fillable = ['iUserId','vFirstName', 'vLastName', 'username', 'email', 'password', 'vImage', 'vPhone', 'eStatus','dtAddedDate','dtUpdatedDate'];

    public static function login($login,$password)
    {
        $SQL = DB::table("user");
        $SQL->where(["vEmail" => $login, "vPassword" => $password]);
        $result = $SQL->get();
        return $result->first();
    }

    public static function update_data(array $where = [], array $data = []){
        $iUserId = DB::table('user');
        $iUserId->where('iUserId',$where['iUserId'])->update($data);
        return $iUserId;
    }

    public static function update_data_by_email(array $where = [], array $data = []){
        $iUserId = DB::table('user');
        $iUserId->where('vEmail',$where['vEmail'])->update($data);
        return $iUserId;
    }
    
    
    public static function email_exist($criteria = array())
    {
        $SQL = DB::table("user");
        if($criteria['vEmail'])
        {
            $SQL->where("vEmail", $criteria["vEmail"]);
        }
        $result = $SQL->get();
        return $result->first();
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

    public static function update_data_by_authCode(array $where = [], array $data = []){
        $iUserId = DB::table('user');
        $iUserId->where('vAuthCode',$where['vAuthCode'])->update($data);
        return $iUserId;
    }
}
