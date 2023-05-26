<?php
namespace App\Models\admin\notificationmaster;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class NotificationMaster extends Model
{
    use HasFactory;
    protected $table = 'notification_master';
    protected $primaryKey = 'iNotificationMasterId';
    public $timestamps = false;
    protected $fillable = ['iNotificationMasterId', 'vNotificationCode', 'eEmail', 'eSms', 'eInternalMessage'];
    
    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = false)
    {
        $SQL = DB::table("notification_master");
        if(!empty($criteria["iNotificationMasterId"]))
        {
            $SQL->where('iNotificationMasterId', 'like', '%' . $criteria['iNotificationMasterId'] . '%');
        }
        if(!empty($criteria["eEmail"]))
        {
            $SQL->where('eEmail', 'like', '%' . $criteria['eEmail'] . '%');
        }
        if(!empty($criteria["eSms"]))
        {
            $SQL->where('eSms', 'like', '%' . $criteria['eSms'] . '%');
        }
        if(!empty($criteria["eInternalMessage"]))
        {
            $SQL->where('eInternalMessage', 'like', '%' . $criteria['eInternalMessage'] . '%');
        }
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("eStatus", $criteria["eStatus"]);
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
        $iContactUs = DB::table('notification_master');
        $iContactUs->where('iNotificationMasterId',$where['iNotificationMasterId'])->update($data);
        return $iContactUs;
      
    }  
}
