<?php

namespace App\Models\admin\plan;

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
        // \DB::enableQueryLog(); // Enable query log

        $SQL = DB::table("plan");
        if(!empty($criteria["vPlanTitle"]))
        {
            $SQL->where('vPlanTitle', 'like', '%' . $criteria['vPlanTitle'] . '%');
        }
        if(!empty($criteria["vPlanPrice"]))
        {
            $SQL->where('vPlanPrice', 'like', '%' . $criteria['vPlanPrice'] . '%');
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
        // dd(\DB::getQueryLog());

        return $result;
    }
    public static function get_by_id($criteria = array())
    {
        $SQL = DB::table("plan");
        if($criteria['vUniqueCode'])
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
    public static function add($data)
    {
        $add = DB::table('plan')->insertGetId($data);
        return $add;
    }
    public static function update_data(array $where = [], array $data = [])
    {
        $iPlanId = DB::table('plan');
        $iPlanId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iPlanId;
    }
    
}
