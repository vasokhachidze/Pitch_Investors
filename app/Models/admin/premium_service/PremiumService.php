<?php
namespace App\Models\admin\premium_service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use Session;

class PremiumService extends Model
{
    
    use HasFactory;
    protected $table = 'userPayments';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
      
     public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '')
    {
        // \DB::enableQueryLog();

        $SQL = DB::table("userPayments")
        ->join('user','userPayments.iUserId', '=', 'user.iUserId','left')
        ->select('userPayments.*',
        DB::raw("CONCAT(user.vFirstName, ' ', user.vLastName) as userName"),
        );
        $SQL->where('userPayments.paymentStatus', 1);
        if(!empty($criteria["userName"]))
        {
            $SQL->where(function($query) use($criteria){
                $query->where('user.vFirstName', 'like', '%' . $criteria['userName'] . '%')
                ->orwhere('user.vLastName', 'like', '%' . $criteria['userName'] . '%');
            });
        }
        if(!empty($criteria["service"]))
        {
            $SQL->where('userPayments.service', 'like', '%' . $criteria['service'] . '%');
        }
       
        if(!empty($criteria["merchantReference"]))
        {
            $SQL->where('userPayments.merchantReference', 'like', '%' . $criteria['merchantReference'] . '%');
        }
        if(!empty($criteria["orderId"]))
        {
            $SQL->where('userPayments.orderId', 'like', '%' . $criteria['orderId'] . '%');
        }
        if(!empty($criteria["amount"]))
        {
            $SQL->where('userPayments.amount', $criteria['amount']);
        } 
        if(!empty($criteria["createdAt"]))
        {
            $SQL->where('userPayments.createdAt', 'like', '%' . $criteria['createdAt'] . '%');
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
    
            $query_results = DB::table('userPayments')
                ->where('paymentStatus', 1)
                ->where('createdAt', '>=', $from_date)
                ->where('createdAt', '<=', $to_date)
                ->select(DB::raw("SUM(amount)
     as sales"))
                ->first();
                if (is_null($query_results->sales)) {
                    $query_results->sales = 0;
                }       
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
        $query_total = DB::table('userPayments')                
                ->select(DB::raw("SUM(amount)
     as total_sale"))
     ->where('paymentStatus', 1)
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
