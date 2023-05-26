<?php
namespace App\Models\admin\industry;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Industry extends Model
{
    use HasFactory;
    protected $table = 'industry';
    protected $primaryKey = 'iIndustryId';

    public $timestamps = false;
    protected $fillable = ['iIndustryId', 'vUniqueCode', 'vName', 'tDescription', 'vImage', 'eStatus', 'iAddedBy', 'iUpdatedBy', 'dtAddedDate', 'dtUpdatedDate', 'eIsDeleted'];
    
    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = false)
    {
        $SQL = DB::table("industry");

        if(!empty($criteria["vName"]))
        {
            $SQL->where('vName', 'like', '%' . $criteria['vName'] . '%');
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
        else {
            $SQL->where("eIsDeleted", 'No');
        }
        $SQL->orderBy('vName','ASC');
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
        $SQL = DB::table("industry");
        if($criteria['vUniqueCode'])
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }

    public static function get_all_data_home()
    {
        $SQL = DB::table("industry");
        $SQL->where('eShowHomePage','Yes');
        $SQL->limit(17);
        $result = $SQL->get();
        return $result;
    }

    public static function add($data)
    {
        $add = DB::table('industry')->insertGetId($data);
        return $add;
    }

    public static function update_data(array $where = [], array $data = []){
        $iIndustryId = DB::table('industry');
        $iIndustryId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iIndustryId;
    }

    public static function update_status(array $where = [], array $data = []){
        $iIndustryId = DB::table('industry');
        $iIndustryId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iIndustryId;
    }

    public static function get_country_code($criteria = array()){
        $SQL = DB::table('industry');
        $SQL->where("iIndustryId", $criteria["iIndustryId"]);
        $result = $SQL->get();
        return $result;
    }
}