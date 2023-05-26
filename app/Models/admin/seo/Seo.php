<?php

namespace App\Models\admin\seo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Seo extends Model
{
    use HasFactory;
    protected $table = 'seo';
    protected $primaryKey = 'iSeoId';
    public $timestamps = false;
    protected $fillable = ['iSeoId','vUniqueCode', 'vPageName', 'vMetaTitle','tMetaDescription','vMetaImage','vOgTitle','tOgDescription','vOgImage', 'eStatus','dtAddedDate','dtUpdateDate','eIsDeleted'];
    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = false)
    {
        $SQL = DB::table("seo");
        if(!empty($criteria["vPageName"]))
        {
            $SQL->where('vPageName', 'like', '%' . $criteria['vPageName'] . '%');
        }
        if(!empty($criteria["vMetaTitle"]))
        {
            $SQL->where('vMetaTitle', 'like', '%' . $criteria['vMetaTitle'] . '%');
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
        $SQL = DB::table("seo");
        if($criteria['vUniqueCode'])
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
    public static function add($data)
    {
        $add = DB::table('seo')->insertGetId($data);
        return $add;
    }
    public static function update_data(array $where = [], array $data = []){
        $iBannerId = DB::table('seo');
        $iBannerId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iBannerId;
    }
}
