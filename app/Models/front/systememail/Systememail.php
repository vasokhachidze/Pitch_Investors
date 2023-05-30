<?php

namespace App\Models\front\systememail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Systememail extends Model
{
    use HasFactory;
    public static function get_email_by_code($criteria = array())
    {
        $SQL = DB::table("system_email");
       if($criteria['vEmailCode'])
        {
            $SQL->where("vEmailCode", $criteria["vEmailCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
}
