<?php
namespace App\Models\front\plan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Plan extends Model
{
    
    use HasFactory;
    protected $table = 'Plan';
    protected $primaryKey = 'iPlanId';
    public $timestamps = false;
    protected $fillable = ['iPlanId','vUniqueCode','vPlanTitle','vPlanDetail','vPlanPrice','iNoofConnection','eStatus','dtAddedDate','dtUpdatedDate'];
    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '')
    {
        $SQL = DB::table("plan");
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria['column']) || !empty($criteria['order']))
        {
            $SQL->orderBy($criteria['column'],$criteria['order']);
        }
        $result = $SQL->get();
        return $result;
    }
    public static function get_by_uniqueCode($criteria = array())
    {
        $SQL = DB::table("plan");
        if($criteria['vUniqueCode'])
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
    public static function get_by_id($id)
    {
        $SQL = DB::table("plan");
        $SQL->where("iPlanId",$id);
        $result = $SQL->get();
        return $result->first();
    }
    public static function get_by_vPlanCode($id)
    {
        $SQL = DB::table("plan");
        $SQL->where("vPlanCode",$id);
        $result = $SQL->get();
        return $result->first();
    }
}