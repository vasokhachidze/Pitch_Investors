<?php

namespace App\Models\admin\setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'setting';

    protected $primaryKey = 'iSettingId';

    public $timestamps = false;

    protected $fillable = ['iSettingId','vName','vDesc','vValue','iSettingOrder','eConfigType','eDisplayType','eSource', 'eStatus','eSource','dtAddedDate','dtUpdatedDate'];

    public static function get_all_settings($criteria = array())
    { 
        $SQL = DB::table("setting");

        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("eStatus", $criteria["eStatus"]);
        }

        if(!empty($criteria["eConfigType"]))
        {
            $SQL->where("eConfigType", $criteria["eConfigType"]);
        }
        $SQL->orderBy('iSettingOrder', 'ASC');  
        $result = $SQL->get();
        return $result;
    }

    public static function get_by_id($iSettingId)
    {
        $SQL = DB::table("setting");
        $SQL->where("iSettingId", $iSettingId);
        $result = $SQL->get();
        return $result->first();
    }

    public static function add($data)
    {
        $add = DB::table('setting')->insertGetId($data);
        return $add;
    }

    public static function setting_update(array $where = [], array $data = []){
        $SQL = DB::table('setting');
        $SQL->where('vName',$where['vName'])->update($data);
        return $SQL;
    }

    // public static function setting_update($where, $data)
    // {
    //     $SQL = DB::table('setting');
    //     $SQL->update($data, $where);
    //     $result = $SQL->affected_rows();
    //     return $result;
    // }

    public static function get_setting($eConfigType = '', $vName = ''){
        $SQL = DB::table('setting');
    
        if($eConfigType != ""){
            $SQL->where('eConfigType', $eConfigType );
        }

        if($vName != ""){
            $SQL->where('vName', $vName );
        }

        $SQL->where('eStatus', 'Active');
        $result = $SQL->get();

        $array = array();
        foreach ($result as $key => $value) {
            $array[$value->vName]['vValue'] = $value->vValue;
        }

        return $array;
    }

}
