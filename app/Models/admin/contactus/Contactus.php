<?php

namespace App\Models\admin\contactus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Contactus extends Model
{
    use HasFactory;
    protected $table = 'contact_us';
    protected $primaryKey = 'iLanguageLabel';
    public $timestamps = false;
    protected $fillable = ['iContactUs','vName','vEmail','vPhone','eStatus','dtAddedDate','dtUpdateDate','eIsDeleted'];
    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = false)
    {
        $SQL = DB::table("contact_us");
        if(!empty($criteria["vName"]))
        {
            $SQL->where('vName', 'like', '%' . $criteria['vName'] . '%');
        }
        if(!empty($criteria["vEmail"]))
        {
            $SQL->where('vEmail', 'like', '%' . $criteria['vEmail'] . '%');
        }
        if(!empty($criteria["vPhone"]))
        {
            $SQL->where('vPhone', 'like', '%' . $criteria['vPhone'] . '%');
        }
        if(!empty($criteria["tComments"]))
        {
            $SQL->where('tComments', 'like', '%' . $criteria['tComments'] . '%');
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
    public static function update_data(array $where = [], array $data = []){
        $iContactUs = DB::table('contact_us');
        $iContactUs->where('iContactUs',$where['iContactUs'])->update($data);
        return $iContactUs;
      
    }  
}
