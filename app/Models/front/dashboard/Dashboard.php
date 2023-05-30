<?php
namespace App\Models\front\dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Dashboard extends Model
{
    public static function add($data) {
        $add = DB::table('businessAdvisorProfile')->insertGetId($data);
        return $add;
    }

    public static function update_data($table = '', $where_field = '', $where_value = '', array $data = []) {
        $updated_data = DB::table($table);
        $updated_data->where($where_field,$where_value)->update($data);
        return $updated_data;
    }
    public static function add_locations($table,$data){
        return DB::table($table)->insertGetId($data); 
    }

    public static function get_investment_total_connection($id) {
        $SQL = DB::table("connection")->select('*');
        $SQL->where(function ($query) use ($id) 
        {
            $query->where("iSenderId", $id)
            ->where( 'eSenderProfileType', '=', 'Investment' )
            ->where( 'eConnectionStatus', '=', 'Active' );
        })
        ->orWhere(function ($query) use ($id) 
        {
            $query->where("iReceiverId", $id)
            ->where( 'eReceiverProfileType', '=', 'Investment' )
            ->where( 'eConnectionStatus', '=', 'Active' );
        });
        return $result = $SQL->get();
    }

    public static function get_investor_total_connection($id) {
        $SQL = DB::table("connection")->select('*');
        $SQL->where(function ($query) use ($id) 
        {
            $query->where("iSenderId", $id)
            ->where( 'eSenderProfileType', '=', 'Investor' );
            // ->where( 'eConnectionStatus', '=', 'Active' );
        })
        ->orWhere(function ($query) use ($id) 
        {
            $query->where("iReceiverId", $id)
            ->where( 'eReceiverProfileType', '=', 'Investor' );
            // ->where( 'eConnectionStatus', '=', 'Active' );
        });
        return $result = $SQL->get();
    }

    public static function get_advisor_total_connection($id) {
        $SQL = DB::table("connection")->select('*');
        $SQL->where(function ($query) use ($id) 
        {
            $query->where("iSenderId", $id)
            ->where( 'eSenderProfileType', '=', 'Advisor' )
            ->where( 'eConnectionStatus', '=', 'Active' );
        })
        ->orWhere(function ($query) use ($id) 
        {
            $query->where("iReceiverId", $id)
            ->where( 'eReceiverProfileType', '=', 'Advisor' )
            ->where( 'eConnectionStatus', '=', 'Active' );
        });
        return $result = $SQL->get();
    }

    /* public static function get_data($table) {
        $SQL = DB::table($table);
        return $result = $SQL->get();
    } */
}
