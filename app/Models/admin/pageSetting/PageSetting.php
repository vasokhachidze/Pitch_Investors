<?php

namespace App\Models\admin\pageSetting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PageSetting extends Model
{
    use HasFactory;

    protected $table = 'page_setting';

    protected $primaryKey = 'iPageSettingId';

    public $timestamps = false;

    protected $fillable = ['iPageSettingId','vTitle', 'tDescription', 'vSlug', 'vMetaTitle', 'tMetaKeywords', 'tMetaDescription', 'eStatus', 'dtAddedDate','dtUpdatedDate', 'tPageSection', 'vImage', 'vTextWithImage'];

    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = false){
        $SQL = DB::table("page_setting");

        if(!empty($criteria['vKeyword']))
        {
            $SQL->where('vTitle', 'like', '%' . $criteria['vKeyword'] . '%')->orWhere('vSlug', 'like', '%' . $criteria['vKeyword'] . '%');
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

    public static function get_by_id($iPageSettingId)
    {
        $SQL = DB::table("page_setting");
        $SQL->where("iPageSettingId", $iPageSettingId);
        $result = $SQL->get();
        return $result->first();
    }

    public static function add($data)
    {
        $add = DB::table('page_setting')->insertGetId($data);
        return $add;
    }

    public function update(array $where = [], array $data = []){
        $iPageSettingId = DB::table('page_setting');
        $iPageSettingId->where('iPageSettingId',$where['iPageSettingId'])->update($data);
        return $iPageSettingId;
    }

    public static function update_status(array $where = [], array $data = []){
        $iPageSettingId = DB::table('page_setting');
        $iPageSettingId->where('iPageSettingId',$where['iPageSettingId'])->update($data);
        return $iPageSettingId;
    }

    public static function delete_by_id(array $where = [])
    {
        DB::table('page_setting')->where('iPageSettingId',$where['iPageSettingId'])->delete();
    }

    public static function get_view_id($iPageSettingId)
    {
        $SQL = DB::table("page_setting"); 
       
        $SQL->where("iPageSettingId", $iPageSettingId);    
        $result = $SQL->get();
        return $result;
    }

    public static function get_count()
    {
        $count = DB::table("page_setting")->count();

        return $count;
    }

}
