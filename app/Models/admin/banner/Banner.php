<?php

namespace App\Models\admin\banner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Banner extends Model
{
    
    use HasFactory;
    protected $table = 'banner';
    protected $primaryKey = 'iBannerId';
    public $timestamps = false;
    protected $fillable = ['iBannerId','vBannerTitle', 'vBannerImage', 'eShowHomePage', 'eStatus','dtAddedDate','dtUpdatedDate'];
    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '')
    {
        $SQL = DB::table("banner");
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
        $SQL = DB::table("banner");
        if($criteria['vUniqueCode'])
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
    public static function add($data)
    {
        $add = DB::table('banner')->insertGetId($data);
        return $add;
    }
    public static function update_data(array $where = [], array $data = [])
    {
        $iBannerId = DB::table('banner');
        $iBannerId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iBannerId;
    }
    
}
