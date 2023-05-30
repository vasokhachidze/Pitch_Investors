<?php
namespace App\Models\admin\connection;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use Session;

class Connection extends Model
{
    
    use HasFactory;
    protected $table = 'connection';
    protected $primaryKey = 'iConnectionId';
    public $timestamps = false;
    
      
     public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '')
    {
        // \DB::enableQueryLog();

        $SQL = DB::table("connection")
        ->join('user as senderUser','connection.iSenderId', '=', 'senderUser.iUserId','left')
        ->join('user as receiverUser','connection.iSenderId', '=', 'receiverUser.iUserId','left')
        ->select('connection.*',
        DB::raw("CONCAT(senderUser.vFirstName, ' ', senderUser.vLastName) as connectionSenderName"),
        DB::raw("CONCAT(receiverUser.vFirstName, ' ', receiverUser.vLastName) as connectionReceiverName "),
        );
        if(!empty($criteria["connectionSenderName"]))
        {
            $SQL->where('senderUser.vFirstName', 'like', '%' . $criteria['connectionSenderName'] . '%');
        }
        if(!empty($criteria["connectionReceiverName"]))
        {
            $SQL->where('senderUser.vFirstName', 'like', '%' . $criteria['connectionReceiverName'] . '%');
        } 
        if(!empty($criteria["vSenderProfileTitle"]))
        {
           // $SQL->where("connection.vSenderProfileTitle", $criteria["vSenderProfileTitle"]);
            $SQL->where('connection.vSenderProfileTitle', 'like', '%' . $criteria['vSenderProfileTitle'] . '%');
        }
        if(!empty($criteria["vReceiverProfileTitle"]))
        {
            $SQL->where('connection.vReceiverProfileTitle', 'like', '%' . $criteria['vReceiverProfileTitle'] . '%');
        } 
        if(!empty($criteria["eReceiverProfileType"]))
        {
            $SQL->where('connection.eReceiverProfileType', 'like', '%' . $criteria['eReceiverProfileType'] . '%');
        } 
        if(!empty($criteria["dtAddedDate"]))
        {
            $SQL->where('connection.dtAddedDate', 'like', '%' . $criteria['dtAddedDate'] . '%');
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

     public static function get_week_data() {
        $data_amount = $data_order = array();
        $week_1 = 0;
        $week_2 = 0;
        for($day = 13; $day >=0; $day--){
            if($day == 0){
                $date_str = Carbon::today('UTC')->toDateString();
            }else{
                $date_str = Carbon::today('UTC')->subDay($day)->toDateString();
            }
    
            $from_date = $date_str." 00:00:00";
            $to_date   = $date_str." 23:59:59";
    
            $query_results = DB::table('connection')
                ->where('dtAddedDate', '>=', $from_date)
                ->where('dtAddedDate', '<=', $to_date)
                ->select(DB::raw("COUNT(iConnectionId)
     as sales"))
                ->first();  

                $day_text = date('l', strtotime($date_str));                      
            if($day > 6) {
                $week_1 += $query_results->sales;
                $data_order['label_2'][] = $day_text;
                $data_order['data_2'][] = $query_results->sales;
            } else {
                $week_2 += $query_results->sales;
                $data_order['label_1'][] = $day_text;
                $data_order['data_1'][] = $query_results->sales;
            }
        };
        $query_total = DB::table('connection')                
                ->select(DB::raw("COUNT(iConnectionId)
     as total_sale"))
                ->first();
        $data_order['total'] = $query_total->total_sale;

        if ($week_1 == 0) {
            $data_order['growth'] = 100;
        } else {
            $data_order['growth'] = round((( ($week_2 - $week_1)/$week_1 ) * 100), 2);
        }
        return response()->json([
            "status" => "ok",
            "data" => $data_order
        ]);
    }     

}
