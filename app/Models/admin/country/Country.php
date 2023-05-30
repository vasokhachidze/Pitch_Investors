<?php
namespace App\Models\admin\country;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Country extends Model
{
    use HasFactory;

    protected $table = 'country';

    protected $primaryKey = 'iCountryId';

    public $timestamps = false;
    protected $fillable = ['iCountryId','name', 'iso3', 'phonecode', 'eStatus', 'dtAddedDate','dtUpdatedDate'];
    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = false)
    {
        $SQL = DB::table("country");      

        if(!empty($criteria["vCountry"]))
        {
            $SQL->where('vCountry', 'like', '%' . $criteria['vCountry'] . '%');
        }
        if(!empty($criteria["vCountryCode"]))
        {
            $SQL->where('vCountryCode', 'like', '%' . $criteria['vCountryCode'] . '%');
        }
        if(!empty($criteria["vCountryISDCode"]))
        {
            $SQL->where('vCountryISDCode', 'like', '%' . $criteria['vCountryISDCode'] . '%');
        }
        if(!empty($criteria["status_search"]))
        {
            $SQL->where("eStatus", $criteria["status_search"]);
        }
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria['column']) || !empty($criteria['order']))
        {
            $SQL->orderBy($criteria['column'],$criteria['order']);
        }   
        if(!empty($criteria["eIsDeleted"]))
        {
            $SQL->where("eIsDeleted", $criteria["eIsDeleted"]);
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
        $SQL = DB::table("country");
        if($criteria['vUniqueCode'])
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }

    public static function add($data)
    {
        $add = DB::table('country')->insertGetId($data);
        return $add;
    }

    public static function update_data(array $where = [], array $data = []){
        $iCountryId = DB::table('country');
        $iCountryId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iCountryId;
    }

    public static function update_status(array $where = [], array $data = []){
        $iCountryId = DB::table('country');
        $iCountryId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iCountryId;
    }

    public static function get_country_code($criteria = array()){
        $where = [
            'iCountryId' => $criteria["iCountryId"],
            'eStatus' => 'Active',
            'eIsDeleted' => 'No',
        ];
        $SQL = DB::table('country');
        $SQL->where($where);
        $result = $SQL->get();
        return $result;
    }
}
