<?php
namespace App\Models\front\home;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Home extends Model
{
    public static function get_banner_data($criteria) {
        $SQL = DB::table("banner");

        if(!empty($criteria['eShowHomePage'])){
            $SQL->where("eShowHomePage", $criteria["eShowHomePage"]);
        } 
        if(!empty($criteria['eStatus']))
        {
            $SQL->where("eStatus", $criteria["eStatus"])->where('eIsDeleted','No');
        }
        $result = $SQL->get();
        return  $result;
    }

    public static function get_investment_count($id) {
        $SQL = DB::table("investmentProfile")->select(DB::raw('COALESCE(COUNT(iInvestmentProfileId),0) as total_investment'));
        return $result = $SQL->get();
    }
    public static function get_investor_count($id) {
        $SQL = DB::table("investorProfile")->select(DB::raw('COALESCE(COUNT(iInvestorProfileId),0) as total_investor'));;
        return $result = $SQL->get();
    }
    public static function get_advisor_count($id) {
        $SQL = DB::table("businessAdvisorProfile")->select(DB::raw('COALESCE(COUNT(iAdvisorProfileId),0) as total_advisor'));;
        return $result = $SQL->get();
    }
     public static function get_investment_data($criteria,$listingImage = '') 
     {
        $SQL = DB::table("investmentProfile");

        if(!empty($criteria['keyword'])){
            $SQL->where('vBusinessProfileName', 'like', '%' . $criteria['keyword'] . '%');
        }  
        if(!empty($criteria['eShowHomePage'])){
            $SQL->where("eShowHomePage", $criteria["eShowHomePage"]);
        }
         if(!empty($criteria['eAdminApproval'])){
            $SQL->where("eAdminApproval", $criteria["eAdminApproval"]);
        }
        if ($listingImage) {
            $SQL->select('investmentProfile.*', DB::raw("(SELECT investmentDocuments.vImage FROM investmentDocuments WHERE investmentProfile.iInvestmentProfileId = investmentDocuments.iInvestmentProfileId AND investmentDocuments.eType = 'profile' LIMIT 1) as vImage"));
        }

        $result = $SQL->get();
        return  $result;
    } 
    public static function get_investor_data($criteria) 
    {
        $SQL = DB::table("investorProfile");

        if(!empty($criteria['keyword'])){
            $SQL->where('vInvestorProfileName', 'like', '%' . $criteria['keyword'] . '%');
        }        
        if(!empty($criteria['eShowHomePage'])){
            $SQL->where("eShowHomePage", $criteria["eShowHomePage"]);
        }
        if(!empty($criteria['eAdminApproval'])){
            $SQL->where("eAdminApproval", $criteria["eAdminApproval"]);
        }
        $result = $SQL->get();
        return  $result;
    }public static function get_advisor_data($criteria,$listingImage = '') 
    {
        $SQL = DB::table("businessAdvisorProfile");

        if(!empty($criteria['keyword'])){
            $SQL->where('vAdvisorProfileTitle', 'like', '%' . $criteria['keyword'] . '%');
        }    
        if(!empty($criteria['eShowHomePage'])){
            $SQL->where("eShowHomePage", $criteria["eShowHomePage"]);
        }
         if(!empty($criteria['eAdminApproval'])){
            $SQL->where("eAdminApproval", $criteria["eAdminApproval"]);
        }
        if($listingImage)
        {
            $SQL->select('businessAdvisorProfile.*', DB::raw("(SELECT businessAdvisorDocuments.vImage FROM businessAdvisorDocuments WHERE businessAdvisorProfile.iAdvisorProfileId = businessAdvisorDocuments.iBusinessAdvisorId AND businessAdvisorDocuments.eType = 'profile' LIMIT 1) as vImage"), DB::raw("(SELECT bookMark.iBookMarkProfileId FROM bookMark WHERE businessAdvisorProfile.iAdvisorProfileId = bookMark.iBookMarkProfileId AND bookMark.eType = 'Advisor') as bookmark"));
        }
        $result = $SQL->get();
        return  $result;
    }
     public static function get_advisor_industries_data($criteria = array()) 
     {
        $SQL = DB::table("businessAdvisorIndustries");
        if($criteria['iAdvisorProfileId']) {
            $SQL->where("iAdvisorProfileId", $criteria["iAdvisorProfileId"]);
        }
        return $result = $SQL->get();
    }

    public static function get_advisor_location_data($criteria = array()) {
        $SQL = DB::table("businessAdvisorLocation");
        if($criteria['iAdvisorProfileId']) {
            $SQL->where("iAdvisorProfileId", $criteria["iAdvisorProfileId"]);
        }
        return $result = $SQL->get();
    }
    public static function get_investor_location_data($criteria = array()) {
        $SQL = DB::table("investorIndustries");
        if($criteria['iInvestorProfileId']) {
            $SQL->where("iInvestorProfileId", $criteria["iInvestorProfileId"]);
        }
        return $result = $SQL->get();
    }
     public static function get_investment_location_data($criteria = array()) {
        $SQL = DB::table("investmentLocation");
        if($criteria['iInvestmentProfileId']) {
            $SQL->where("iInvestmentProfileId", $criteria["iInvestmentProfileId"]);
        }
        return $result = $SQL->get();
    }
    public static function get_investor_industries_data($criteria = array()) {
        $SQL = DB::table("investmentLocation");
        if(!empty($criteria['iInvestmentProfileId'])) {
            $SQL->where("iInvestmentProfileId", $criteria["iInvestmentProfileId"]);
        }
        return $result = $SQL->get();
    }
}