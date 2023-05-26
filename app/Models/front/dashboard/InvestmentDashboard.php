<?php
namespace App\Models\front\dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class InvestmentDashboard extends Model
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
    
    public static function get_investment_data($id) {
        $SQL = DB::table("investmentProfile")->select('investmentProfile.*',DB::raw("(SELECT investmentDocuments.vImage FROM investmentDocuments WHERE investmentProfile.iInvestmentProfileId = investmentDocuments.iInvestmentProfileId AND investmentDocuments.eType = 'profile' LIMIT 1) as vImage"), DB::raw("(SELECT count(connection.iConnectionId) FROM connection WHERE connection.iReceiverProfileId = investmentProfile.iInvestmentProfileId AND eConnectionStatus = 'Active' AND eReceiverProfileType = 'Investment' ) as total_received_connection"), DB::raw("(SELECT count(connection.iConnectionId) FROM connection WHERE connection.iSenderProfileId = investmentProfile.iInvestmentProfileId AND eConnectionStatus = 'Active' AND eSenderProfileType = 'Investment' ) as total_send_connection"));
        $SQL->where("iUserId", $id);
        // $SQL->where("eStatus", 'Active');
        return $result = $SQL->get();
    }

    public static function get_investment_send_request_data($profile_id) {
        $SQL = DB::table("connection");
         $SQL->join('investmentProfile', 'investmentProfile.iInvestmentProfileId', '=', 'connection.iSenderProfileId');                
        $SQL->where("iSenderId", $profile_id)
            // ->where("eConnectionStatus", 'Active')
            ->whereIn('eConnectionStatus', ['Active', 'Hold'])
            ->where("eSenderProfileType", 'Investment');
        return $result = $SQL->get();
    }

    public static function get_investment_received_request_data($profile_id) {
        $SQL = DB::table("connection");
        $SQL->join('investmentProfile', 'investmentProfile.iInvestmentProfileId', '=', 'connection.iReceiverProfileId');                
        $SQL->where("iReceiverId", $profile_id)
            // ->where("eConnectionStatus", 'Active')
        ->whereIn('eConnectionStatus', ['Active', 'Hold'])
            ->where("eReceiverProfileType", 'Investment');
        return $result = $SQL->get();
    }
    
    public static function update_data($table = '', $where_field = '', $where_value = '', array $data = []) {
        $updated_data = DB::table($table);
        $result = $updated_data->where($where_field,$where_value)->update($data);
        return $result;
    }
}
