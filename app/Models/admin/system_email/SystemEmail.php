<?php

namespace App\Models\admin\system_email;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SystemEmail extends Model
{
    use HasFactory;

    protected $table = 'system_email';

    protected $primaryKey = 'iSystemEmailId';

    public $timestamps = false;

    protected $fillable = ['iSystemEmailId', 'vEmailCode', 'vEmailTitle', 'vFromName', 'vFromEmail', 'vCcEmail', 'vBccEmail', 'vEmailSubject', 'tEmailMessage', 'tSmsMessage', 'tInternalMessage', 'eStatus', 'dtAddedDate', 'dtUpdatedDate'];

    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = false){
        $SQL = DB::table("system_email");
        if(!empty($criteria["vEmailTitle"]))
        {
            $SQL->where('vEmailTitle', 'like', '%' . $criteria['vEmailTitle'] . '%');
        }
        if(!empty($criteria["vEmailCode"]))
        {
            $SQL->where('vEmailCode', 'like', '%' . $criteria['vEmailCode'] . '%');
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
        $SQL = DB::table("system_email");
       if($criteria['vUniqueCode'])
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }

    public static function add($data)
    {
        $add = DB::table('system_email')->insertGetId($data);
        return $add;
    }

    public static function update_data(array $where = [], array $data = []){
        $iSystemEmailId = DB::table('system_email');
        $iSystemEmailId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iSystemEmailId;
    }
}
