<?php

namespace App\Models\admin\region;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Region extends Model
{
    use HasFactory;
    protected $table = 'region';

    protected $primaryKey = 'vRegionId';

    public $timestamps = false;

    protected $fillable = ['iRegionId', 'iCountryId', 'vTitle', 'eStatus', 'iAddedBy', 'iUpdatedBy', 'dtAddedDate', 'dtUpdatedDate', 'eIsDeleted'];

    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = false){
        $SQL = DB::table("region");

        $SQL->Join("country", "country.iCountryId", "=", "region.iCountryId")
            ->select('region.*', 'country.vTitle as countryname');
        if(!empty($criteria["vTitle"]))
        {
            $SQL->where('region.vTitle', 'like', '%' . $criteria['vTitle'] . '%');
        }
        if(!empty($criteria["vCountryName"]))
        {
            $SQL->where('country.vTitle', 'like', '%' . $criteria['vCountryName'] . '%');
        }
        if(!empty($criteria["status_search"]))
        {
            $SQL->where("region.eStatus", $criteria["status_search"]);
        }
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("region.eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria['column']) || !empty($criteria['order']))
        {
            $SQL->orderBy($criteria['column'],$criteria['order']);
        }   
        if(!empty($criteria["eIsDeleted"]))
        {
            $SQL->where("region.eIsDeleted", $criteria["eIsDeleted"]);
        }
        if($paging == true)
        {
            $SQL->limit($limit);
            $SQL->skip($start);
        }
        $SQL->orderBy('vRegionId','DESC');                    
        $result = $SQL->get();
        return $result;
    }
    public static function get_by_id($criteria = array())
    {
        $SQL = DB::table("region");
        if($criteria['vUniqueCode'])
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
    public static function add($data)
    {
        $add = DB::table('region')->insertGetId($data);
        return $add;
    }
    public static function update_data(array $where = [], array $data = []){
        $iCountryId = DB::table('region');
        $iCountryId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iCountryId;
    }
}
