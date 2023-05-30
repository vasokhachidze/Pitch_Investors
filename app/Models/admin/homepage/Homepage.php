<?php

namespace App\Models\admin\homepage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Homepage extends Model
{
    use HasFactory;
    
    public static function get_all_homepage($criteria = array())
    { 
        $SQL = DB::table("home_page");
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("eStatus", $criteria["eStatus"]);
        }

        if(!empty($criteria["vType"]))
        {
            $SQL->where("vType", $criteria["vType"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
    public static function homepage_update(array $where = [], array $data = []){
        $SQL = DB::table('home_page');
        $SQL->where('vType',$where['vType'])->update($data);
        return $SQL;
    }
}
