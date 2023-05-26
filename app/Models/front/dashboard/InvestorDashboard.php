<?php
namespace App\Models\front\dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class InvestorDashboard extends Model
{
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

    public static function get_accepted_sender_data($id){
         $SQL = DB::table("connection");
        $SQL->where("iSenderProfileId", $id)
            ->where("eConnectionStatus", 'Accept')
            ->Where("eSenderProfileType", 'Investor');
        $result = $SQL->get();
            // dd(\DB::getQueryLog());
        return $result;
    }
    public static function get_accepted_receiver_data($id){
        $SQL = DB::table("connection");
        $SQL->where("iReceiverProfileId", $id)
            ->where("eConnectionStatus", 'Accept')
            ->Where("eReceiverProfileType", 'Investor');
        $result = $SQL->get();
            // dd(\DB::getQueryLog());
        return $result;
    }
    public static function get_investor_send_request_data($id) 
    {
        $SQL = DB::table("connection")
        ->join('investorProfile', 'investorProfile.iInvestorProfileId', '=', 'connection.iSenderProfileId');
        $SQL->where("iSenderId", $id)
        // ->where("eConnectionStatus", 'Active')
        ->where("eSenderProfileType", 'Investor');
        $result = $SQL->get();
        return $result;
    }
    public static function get_investor_receive_request_data($id) 
    {
        // DB::enableQueryLog();
        $SQL = DB::table("connection")
                ->join('investorProfile', 'investorProfile.iInvestorProfileId', '=', 'connection.iReceiverProfileId');                
        $SQL->where("iReceiverId", $id)
            ->whereNot("eConnectionStatus", 'Reject')
            ->where("eReceiverProfileType", 'Investor');
        $result = $SQL->get();
            // dd(\DB::getQueryLog());
        return $result;
    }    
    public static function update_data(array $where = [], array $data = []) {
        $investmentId = DB::table('connection');
        $investmentId->where('iConnectionId',$where['iConnectionId'])->update($data);
        return $investmentId;
    }
    // public static function update_data($table = '', $where_field = '', $where_value = '', array $data = []) {
    //     $updated_data = DB::table($table);
    //     $updated_data->where($where_field,$where_value)->update($data);
    //     return $updated_data;
    // }
}
