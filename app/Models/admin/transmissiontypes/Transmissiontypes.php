<?php

namespace App\Models\admin\transmissiontypes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Transmissiontypes extends Model
{
    use HasFactory;
    protected $table = 'transmission_types';
    protected $primaryKey = 'iTransmissionTypesId';
    public $timestamps = false;
    protected $fillable = ['iTransmissionTypesId','vUniqueCode', 'vTransmissionTypesCode', 'vTransmissionTypesName', 'eStatus','dtAddedDate','dtUpdateDate','eIsDeleted'];
    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = false)
    {
        $SQL = DB::table("transmission_types");
        if(!empty($criteria["vTransmissionTypesCode"]))
        {
            $SQL->where('vTransmissionTypesCode', 'like', '%' . $criteria['vTransmissionTypesCode'] . '%');
        }
        if(!empty($criteria["vTransmissionTypesName"]))
        {
            $SQL->where('vTransmissionTypesName', 'like', '%' . $criteria['vTransmissionTypesName'] . '%');
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
        $SQL = DB::table("transmission_types");
        if($criteria['vUniqueCode'])
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
    public static function add($data)
    {
        $add = DB::table('transmission_types')->insertGetId($data);
        return $add;
    }
    public static function update_data(array $where = [], array $data = []){
        $iBannerId = DB::table('transmission_types');
        $iBannerId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iBannerId;
    }
}
