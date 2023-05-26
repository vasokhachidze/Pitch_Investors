<?php

namespace App\Models\admin\state;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class State extends Model
{
    use HasFactory;

    protected $table = 'state';

    protected $primaryKey = 'iStateId';

    public $timestamps = false;

    protected $fillable = ['iStateId','vUniqueCode','vState','iCountryId','vCountryCode','eStatus','dtAddedDate','dtUpdatedDate'];

    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = false){
        $SQL = DB::table("state");
        $SQL->Join("country", "country.iCountryId", "=", "state.iCountryId")
            ->select('state.*', 'country.vCountry as vCountryName');
        if(!empty($criteria["vState"]))
        {
            $SQL->where('state.vState', 'like', '%' . $criteria['vState'] . '%');
        }
        if(!empty($criteria["vCountryName"]))
        {
            $SQL->where('country.vCountry', 'like', '%' . $criteria['vCountryName'] . '%');
        }
        if(!empty($criteria["vCountryCode"]))
        {
            $SQL->where('state.vCountryCode', 'like', '%' . $criteria['vCountryCode'] . '%');
        }
        if(!empty($criteria["status_search"]))
        {
            $SQL->where("state.eStatus", $criteria["status_search"]);
        }
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("state.eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria['column']) || !empty($criteria['order']))
        {
            $SQL->orderBy($criteria['column'],$criteria['order']);
        }   
        if(!empty($criteria["eIsDeleted"]))
        {
            $SQL->where("state.eIsDeleted", $criteria["eIsDeleted"]);
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
        $SQL = DB::table("state");
        if($criteria['vUniqueCode'])
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
    public static function add($data)
    {
        $add = DB::table('state')->insertGetId($data);
        return $add;
    }
    public static function update_data(array $where = [], array $data = []){
        $iCountryId = DB::table('state');
        $iCountryId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iCountryId;
    }
    public static function get_data_by_state($country_id)
    {
       $SQL = DB::table("state");
       $SQL->where("country_id", $country_id);
       $result = $SQL->get();
        return $result;
    }  

}
