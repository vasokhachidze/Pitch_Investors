<?php

namespace App\Models\front\token;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Token extends Model
{
    
    use HasFactory;
    protected $table = 'token_history';
    protected $primaryKey = 'iTokenHistoryId ';
    public $timestamps = false;
    protected $fillable = ['iTokenHistoryId','iUserID', 'iToken', 'iConnectionId', 'dtAddedDate'];
      
    
    public static function add($data)
    {
        $add = DB::table('token_history')->insertGetId($data);
        return $add;
    }

    public static function authentication($criteria = array())
    {
        $SQL = DB::table("token_history");
        if($criteria['iUserID'])
        {
            $SQL->where("iUserID", $criteria["iUserID"]);
        }
        $result = $SQL->get();
        return $result->first();
    }

    public static function update_data(array $where = [], array $data = [])
    {
        $iUserId = DB::table('token_history');
        $iUserId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iUserId;
    }
}
