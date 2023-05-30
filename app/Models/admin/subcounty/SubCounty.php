<?php
namespace App\Models\admin\subcounty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SubCounty extends Model
{
    use HasFactory;
    protected $table = 'subCounty';

    protected $primaryKey = 'iSubCountId';

    public $timestamps = false;

    protected $fillable = ['iSubCountId', 'vUniqueCode', 'vTitle', 'iCountryId', 'iRegionId', 'iCountyId', 'eStatus', 'iAddedBy', 'iUpdatedBy', 'dtAddedDate', 'dtUpdatedDate', 'eIsDeleted'];

    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = false){
        $SQL = DB::table("subCounty");

        $SQL->Join("country", "country.iCountryId", "=", "subCounty.iCountryId")
            ->Join("region", "region.iRegionId", "=", "subCounty.iRegionId")
            ->Join("county", "county.iCountyId", "=", "subCounty.iCountyId")
           ->select('subCounty.*', 'country.vCountry as countryname', 'region.vTitle as regionName', 'county.vTitle as countyName');
        if(!empty($criteria["vTitle"]))
        {
            $SQL->where('subCounty.vTitle', 'like', '%' . $criteria['vTitle'] . '%');
        }
        if(!empty($criteria["vCountryName"]))
        {
            $SQL->where('country.vCountry', 'like', '%' . $criteria['vCountryName'] . '%');
        }
        if(!empty($criteria["vRegionName"]))
        {
            $SQL->where('region.vTitle', 'like', '%' . $criteria['vRegionName'] . '%');
        }
        if(!empty($criteria["countyName"]))
        {
            $SQL->where('county.vTitle', 'like', '%' . $criteria['countyName'] . '%');
        }
        if(!empty($criteria["status_search"]))
        {
            $SQL->where("subCounty.eStatus", $criteria["status_search"]);
        }
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("subCounty.eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria['column']) || !empty($criteria['order']))
        {
            $SQL->orderBy($criteria['column'],$criteria['order']);
        }   
        if(!empty($criteria["eIsDeleted"]))
        {
            $SQL->where("subCounty.eIsDeleted", $criteria["eIsDeleted"]);
        }
        if($paging == true)
        {
            $SQL->limit($limit);
            $SQL->skip($start);
        }
        $SQL->orderBy('vTitle','ASC');
        // \DB::enableQueryLog();
        $result = $SQL->get();
        // dd(\DB::getQueryLog());
        // dd($result);
        return $result;
    }
    public static function get_by_id($criteria = array())
    {
        $SQL = DB::table("subCounty");
        if($criteria['vUniqueCode'])
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
    public static function add($data)
    {
        $add = DB::table('subCounty')->insertGetId($data);
        return $add;
    }
    public static function update_data(array $where = [], array $data = []){
        $iCountryId = DB::table('subCounty');
        $iCountryId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iCountryId;
    }
}
