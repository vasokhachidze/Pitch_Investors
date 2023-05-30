<?php

namespace App\Models\admin\cmspage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Cmspage extends Model
{
    use HasFactory;

    protected $table = 'cmspage';

    protected $primaryKey = 'iCmsPageId';

    public $timestamps = false;

    protected $fillable = ['iCmsPageId','vUniqueCode','vPageName','tDescription','vSlug','eStatus','dtAddedDate','dtUpdateDate','eIsDeleted'];

    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = false){
        $SQL = DB::table("cmspage");
        if(!empty($criteria["vPageName"]))
        {
            $SQL->where('vPageName', 'like', '%' . $criteria['vPageName'] . '%');
        }
        if(!empty($criteria["tDescription"]))
        {
            $SQL->where('tDescription', 'like', '%' . $criteria['tDescription'] . '%');
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
        $SQL = DB::table("cmspage");
       if($criteria['vUniqueCode'])
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }

    public static function add($data)
    {
        $add = DB::table('cmspage')->insertGetId($data);
        return $add;
    }

    public static function update_data(array $where = [], array $data = []){
        $iSystemEmailId = DB::table('cmspage');
        $iSystemEmailId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iSystemEmailId;
    }
}
