<?php

namespace App\Models\admin\languagelabel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class LanguageLabel extends Model
{
    use HasFactory;
    protected $table = 'language_label';
    protected $primaryKey = 'iLanguageLabel';
    public $timestamps = false;
    protected $fillable = ['iLanguageLabel','vTitle','vLabel','eStatus','dtAddedDate','dtUpdateDate','eIsDeleted'];
    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = false)
    {
        $SQL = DB::table("language_label");
        if(!empty($criteria["vTitle"]))
        {
            $SQL->where('vTitle', 'like', '%' . $criteria['vTitle'] . '%');
        }
        if(!empty($criteria["vLabel"]))
        {
            $SQL->where('vLabel', 'like', '%' . $criteria['vLabel'] . '%');
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
        $SQL = DB::table("language_label");
        if($criteria['vUniqueCode'])
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
    public static function add($data)
    {
        $add = DB::table('language_label')->insertGetId($data);
        return $add;
    }
    public static function update_data(array $where = [], array $data = []){
        $iBannerId = DB::table('language_label');
        $iBannerId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iBannerId;
    }
}
