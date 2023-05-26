<?php
namespace App\Models\front\investment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Investment extends Model
{
    use HasFactory;
    protected $table = 'investmentProfile';
    protected $primaryKey = 'iInvestmentProfileId';
    protected $fillable = ['iInvestmentProfileId', 'vUniqueCode', 'vInvestmentDisplayId', 'vFirstName', 'vLastName', 'vPhone', 'vEmail', 'dDob', 'vIdentificationNo', 'vBusinessName', 'vBusinessEstablished', 'eBusinessProfile', 'eFullSaleBusiness', 'ePartialSaleBusiness', 'eLoanForBusiness', 'eBusinessAsset', 'eBailout', 'eSoleProprietor', 'eGeneralPartnership', 'eLLP', 'eLLC', 'ePrivateCompany', 'ePrivateLimitedCompany', 'eSCorporation', 'eCCorporation', 'tBusinessDetail', 'tBusinessHighLights', 'tFacility', 'tListProductService', 'vAverateMonthlySales', 'vProfitMargin', 'vPhysicalAssetValue', 'vMaxStakeSell', 'vInvestmentAmountStake', 'tInvestmentReason', 'eFindersFee', 'eStatus', 'eIsDeleted', 'dtAddedDate', 'dtUpdatedDate'];

    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '', $listingImage = '') {
        /* if ($listingImage) {
        } */
          // \DB::enableQueryLog();

        // dd($criteria);
        $SQL = DB::table('investmentProfile');
        $select_query='';

        //for bookmark query strat
        $SQL->select('investmentProfile.*', DB::raw("(SELECT bookMark.iBookMarkProfileId FROM bookMark WHERE investmentProfile.iInvestmentProfileId = bookMark.iBookMarkProfileId AND bookMark.eType = 'Investment') as bookmark"));
        //for bookmark query end


        if ($listingImage) {
            $SQL->select('investmentProfile.*', DB::raw("(SELECT investmentDocuments.vImage FROM investmentDocuments WHERE investmentProfile.iInvestmentProfileId = investmentDocuments.iInvestmentProfileId AND investmentDocuments.eType = 'profile' LIMIT 1) as vImage"),DB::raw("(SELECT bookMark.iBookMarkProfileId FROM bookMark WHERE investmentProfile.iInvestmentProfileId = bookMark.iBookMarkProfileId AND bookMark.eType = 'Investment') as bookmark"));
        }
       if(!empty($criteria['otherField'])){
            foreach ($criteria['otherField'] as $key => $value) {
                $SQL->orWhere($value,'Yes');
            }
        }
        if (!empty($criteria['industry'])) {
            $SQL->join('investmentIndustries', 'investmentProfile.iInvestmentProfileId', '=', 'investmentIndustries.iInvestmentProfileId');
            $current_array = [];
            foreach ($criteria['industry'] as $key => $value) {
                array_push($current_array,$value);
            }
            $SQL->whereIn('investmentIndustries.iIndustryId', $current_array);
        }
        if (!empty($criteria['iRegionId']) || !empty($criteria["iCountyId"]) || !empty($criteria["iSubCountyId"])) 
        {
            $SQL->join('investmentLocation', 'investmentProfile.iInvestmentProfileId', '=', 'investmentLocation.iInvestmentProfileId');
            $selectLocation=1;

            if(!empty($criteria["iRegionId"])) 
            {
                $selectLocation=$criteria["iRegionId"];
            }if(!empty($criteria["iCountyId"])) 
            {
                $selectLocation=$criteria["iCountyId"];
            }if(!empty($criteria["iSubCountyId"])) 
            {
                $selectLocation=$criteria["iSubCountyId"];
            }
            $SQL->where("vLocationName", $selectLocation);
            
            // $current_array = [];
            // foreach ($criteria['location'] as $key => $value) {
            //     array_push($current_array,$value);
            // }
            // $SQL->whereIn('investmentLocation.vLocationName', $current_array);
        }
        if(!empty($criteria["interested"])) {
            $SQL->where($criteria["interested"], 'Yes');
        }

        if(!empty($criteria["eIsDeleted"])) {
            $SQL->where("eIsDeleted", $criteria["eIsDeleted"]);
        }if(!empty($criteria["eAdminApproval"])) {
            $SQL->where("eAdminApproval", $criteria["eAdminApproval"]);
        }
        if(!empty($criteria['column']) || !empty($criteria['order'])) {
            $SQL->orderBy('investmentProfile.'.$criteria['column'],$criteria['order']);
        }
        if($paging == true) {
            $SQL->limit($limit);
            $SQL->skip($start);
        }
        $result = $SQL->get();
        // dd(\DB::getQueryLog());
        if ($listingImage) {
            /* dd($result); */
        }
        // dd(\DB::getQueryLog());
        return $result;
    }
    public static function get_by_iUserId($criteria = array()) 
    {
        $SQL = DB::table("investmentProfile");
        if($criteria['iUserId']) {
            $SQL->where("iUserId", $criteria["iUserId"]);
        }
        $result = $SQL->get();
        return  $result;
    }
    
    public static function get_by_id($criteria = array()) {
        $SQL = DB::table("investmentProfile");
         //for bookmark query strat
        $SQL->select('investmentProfile.*', DB::raw("(SELECT bookMark.iBookMarkProfileId FROM bookMark WHERE investmentProfile.iInvestmentProfileId = bookMark.iBookMarkProfileId AND bookMark.eType = 'Investment') as bookmark"));
        //for bookmark query end

        if($criteria['vUniqueCode'])
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        if(!empty($criteria['eAdminApproval']))
        {   
            $SQL->where("eAdminApproval", $criteria["eAdminApproval"]);         
        }
        $result = $SQL->get();
        return $result->first();
    }

    public static function add($data) {
        $add = DB::table('investmentProfile')->insertGetId($data);
        return $add;
    }

    public static function update_data(array $where = [], array $data = []) {

        $investmentId = DB::table('investmentProfile');
        $investmentId->where('vUniqueCode',$where['vUniqueCode'])->update($data);

        return $investmentId;
    } 

    public static function update_data_by_id(array $where = [], array $data = []) {

        $investmentId = DB::table('investmentProfile');
        $investmentId->where('iInvestmentProfileId',$where['iInvestmentProfileId'])->update($data);

        return $investmentId;
    } 

    public static function check_unique_email($criteria = array()) {
        $SQL = DB::table("investmentProfile");
        $SQL->where('vEmail', $criteria['vEmail'] );
        if($criteria['vUniqueCode']) {
            $SQL->where('vUniqueCode','<>',$criteria['vUniqueCode']);
        }
        $result = $SQL->get();
        return $result->first();
    }

    public static function get_image_id($criteria = array()) {
        $SQL = DB::table("investmentDocuments");
        if($criteria['iInvestmentProfileId']) {
            $SQL->where("iInvestmentProfileId", $criteria["iInvestmentProfileId"]);
            $SQL->where("eType", 'profile');
        }
        $result = $SQL->get();
        return $result->first();
    }

  
    public static function get_location() {
        $result = [];
        $region_data = DB::table('region')->select('iRegionId', 'vTitle as regionName')->where('eIsDeleted','No')->orderBy('vTitle', 'asc')->get();
        foreach ($region_data as $key => $value) {            
            $result[$key]['regionId'] = $value->iRegionId;
            $result[$key]['regionName'] = $value->regionName;
            
            $county_data = DB::table('county')->select('iCountyId', 'vTitle as countyName')->where('iRegionId',$value->iRegionId)->orderBy('vTitle', 'asc')->get();
            foreach ($county_data as $key1 => $value1) {                    
                $result[$key][$key1]['countyId'] = $value1->iCountyId;
                $result[$key][$key1]['countyName'] = $value1->countyName;
                
                $subCounty_data = DB::table('subCounty')->select('iSubCountId', 'vTitle as subCountyName')->where('iCountyId',$value1->iCountyId)->orderBy('vTitle', 'asc')->get();
                foreach ($subCounty_data as $key2 => $value2) {
                    $result[$key][$key1][$key2]['iSubCountId'] = $value2->iSubCountId;
                    $result[$key][$key1][$key2]['subCountyName'] = $value2->subCountyName;
                }
            }
        }
        return $result;
    }

    public static function add_locations($data){
        return DB::table('investmentLocation')->insertGetId($data); 
    }
    public static function delete_locations(array $where = []) {
        $update = DB::table('investmentLocation')->where('iInvestmentProfileId', $where['iInvestmentProfileId'])->delete();
        return true;
    }

    public static function add_industry($data) {
        
        return DB::table('investmentIndustries')->insertGetId($data); 

    }
    public static function update_industry(array $where = [], array $data = []) {
        $update = DB::table('investmentIndustries');
        $update->where($where)->update($data);
        return true;
    }

    public static function add_toDocument($data) {
        $lastID=DB::table('investmentDocuments')->insertGetId($data);
        return $lastID;
    }
    public static function update_toDocument(array $where = [], array $data = []) {
        $update = DB::table('investmentDocuments');
        $update->where($where)->update($data);
        return true;
    }

    public static function delete_toDocument(array $where = []) {
        $delete = DB::table('investmentDocuments')->where('iInvestmentProfileId', $where['iInvestmentProfileId'])->delete();
        return true;
    }
    public static function get_bookmark($criteria=array())
    {
        // \DB::enableQueryLog();
         $SQL = DB::table("bookMark");
        if($criteria['iBookMarkProfileId']) 
        {
            $SQL->where("iBookMarkProfileId", $criteria["iBookMarkProfileId"]);
        }
        if(!empty($criteria['iUserId'])) 
        {
            $SQL->where("iUserId", $criteria["iUserId"]);
        }
        $result = $SQL->get();
        // dd(\DB::getQueryLog());
        return $result->first();
    }
    public static function add_bookmark($data) {
        $add = DB::table('bookMark')->insertGetId($data);
        return $add;
    }
    public static function delete_bookmark(array $where = []) 
    {
        $update = DB::table('bookMark')->where('iBookMarkId', $where['iBookMarkId'])->delete();
        return true;
    }
    public static function get_document($criteria = array()) 
    {
        $SQL = DB::table("investmentDocuments");
        
        if(!empty($criteria['iTempId'])){
             $SQL->where("iTempId", $criteria["iTempId"]);   
        }        
        if($criteria['iInvestmentProfileId']) {
            $SQL->where("iInvestmentProfileId", $criteria["iInvestmentProfileId"]);
        }
        if(!empty($criteria['eType'])) {
            $SQL->where("eType", $criteria["eType"]);
        }
        return $result = $SQL->get();
    }
    public static function delete_document_byId($iInvestmentDocumentId) {
        $delete = DB::table('investmentDocuments')->where('iInvestmentDocumentId', $iInvestmentDocumentId)->delete();
        return true;
    }  
    public static function delete_document_byName($fileName) {
        $delete = DB::table('investmentDocuments')->where('vFileName', $fileName)->delete();
        return true;
    }
    public static function get_industries_data($criteria = array()) {
        $SQL = DB::table("investmentIndustries");
        if($criteria['iInvestmentProfileId']) {
            $SQL->where("iInvestmentProfileId", $criteria["iInvestmentProfileId"]);
        }
        // $SQL->orderBy('vName', 'asc');
        return $result = $SQL->get();
    }
    public static function get_location_data($criteria = array()) {
        $SQL = DB::table("investmentLocation");
        if($criteria['iInvestmentProfileId']) {
            $SQL->where("iInvestmentProfileId", $criteria["iInvestmentProfileId"]);
        }
        return $result = $SQL->get();
    }

    public static function get_connection($criteria = array())
    {
        $SQL = DB::table("connection");
        $SQL->where(function ($query) use ($criteria)
        {
            $query->where("iSenderProfileId", $criteria['iSenderProfileId'])
            ->where("iReceiverProfileId", $criteria['iReceiverProfileId']);
        })
        ->orWhere(function ($query) use ($criteria)
        {
            $query->where("iSenderProfileId", $criteria['iReceiverProfileId'])
            ->where("iReceiverProfileId", $criteria['iSenderProfileId']);
        });
        return $result = $SQL->get();
    }

    public static function get_connection_by_sender_or_receiver($criteria = array())
    {
        $SQL = DB::table("connection");
        $SQL->where(function ($query) use ($criteria)
        {
            $query->where("iSenderProfileId", $criteria['iSenderProfileId'])
            ->orWhere("iReceiverProfileId", $criteria['iReceiverProfileId']);
        });
        return $result = $SQL->get();
    }

    public static function get_by_profile_id($where_field = '', $where_value = '')
    {
        $SQL = DB::table('investmentProfile');
        $SQL->where($where_field, $where_value);
        $result = $SQL->get();
        return $result->first();
    }
    public static function get_by_connection_profile_id($where_field = '', $where_value = '')
    {
        $SQL = DB::table('investmentProfile');
        $SQL->select('investmentProfile.*', DB::raw("(SELECT investmentDocuments.vImage FROM investmentDocuments WHERE investmentProfile.iInvestmentProfileId = investmentDocuments.iInvestmentProfileId AND investmentDocuments.eType = 'profile' LIMIT 1) as vImage"));
        $SQL->where($where_field, $where_value);
        $result = $SQL->get();
        return $result;
    }
}