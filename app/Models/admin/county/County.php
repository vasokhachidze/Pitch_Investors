<?php

namespace App\Models\admin\county;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class County extends Model
{
    use HasFactory;
    protected $table = 'county';

    protected $primaryKey = 'iCountyId';

    public $timestamps = false;

    protected $fillable = ['iCountyId', 'vUniqueCode', 'vTitle', 'iCountryId', 'iRegionId', 'eStatus', 'iAddedBy', 'iUpdatedBy', 'dtAddedDate', 'dtUpdatedDate', 'eIsDeleted'];

    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = false){
        $SQL = DB::table("county");

        $SQL->Join("country", "country.iCountryId", "=", "county.iCountryId")
            ->Join("region", "region.iRegionId", "=", "county.iRegionId")
           ->select('county.*', 'country.vCountry as countryname', 'region.vTitle as vRegionName');
        if(!empty($criteria["vTitle"]))
        {
            $SQL->where('county.vTitle', 'like', '%' . $criteria['vTitle'] . '%');
        }
        if(!empty($criteria["vRegionName"]))
        {
            $SQL->where('region.vTitle', 'like', '%' . $criteria['vRegionName'] . '%');
        }
        if(!empty($criteria["vCountryName"]))
        {
            $SQL->where('country.vCountry', 'like', '%' . $criteria['vCountryName'] . '%');
        }
        if(!empty($criteria["status_search"]))
        {
            $SQL->where("county.eStatus", $criteria["status_search"]);
        }
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("county.eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria['column']) || !empty($criteria['order']))
        {
            $SQL->orderBy($criteria['column'],$criteria['order']);
        }   
        if(!empty($criteria["eIsDeleted"]))
        {
            $SQL->where("county.eIsDeleted", $criteria["eIsDeleted"]);
        }
        if($paging == true)
        {
            $SQL->limit($limit);
            $SQL->skip($start);
        }
        $SQL->orderBy('vTitle','ASC');
        $result = $SQL->get();
        return $result;
    }
    public static function get_by_id($criteria = array())
    {
        $SQL = DB::table("county");
        if($criteria['vUniqueCode'])
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
    public static function add($data)
    {
        $add = DB::table('county')->insertGetId($data);
        return $add;
    }
    public static function update_data(array $where = [], array $data = []){
        $iCountryId = DB::table('county');
        $iCountryId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iCountryId;
    }
}