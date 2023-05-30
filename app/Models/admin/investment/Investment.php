<?php
namespace App\Models\admin\investment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Investment extends Model
{
    use HasFactory;
    protected $table = 'investmentProfile';
    protected $primaryKey = 'iInvestmentProfileId';
    protected $fillable = ['iInvestmentProfileId', 'vUniqueCode', 'vInvestmentDisplayId', 'vFirstName', 'vLastName', 'vPhone', 'vEmail', 'dDob', 'vIdentificationNo', 'vBusinessName', 'vBusinessEstablished', 'eBusinessProfile', 'eFullSaleBusiness', 'ePartialSaleBusiness', 'eLoanForBusiness', 'eBusinessAsset', 'eBailout', 'eSoleProprietor', 'eGeneralPartnership', 'eLLP', 'eLLC', 'ePrivateCompany', 'ePrivateLimitedCompany', 'eSCorporation', 'eCCorporation', 'tBusinessDetail', 'tBusinessHighLights', 'tFacility', 'tListProductService', 'vAverateMonthlySales', 'vProfitMargin', 'vPhysicalAssetValue', 'vMaxStakeSell', 'vInvestmentAmountStake', 'tInvestmentReason', 'eFindersFee', 'eStatus', 'eIsDeleted', 'dtAddedDate', 'dtUpdatedDate'];

    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '') {
        // \DB::enableQueryLog();
        $SQL = DB::table('investmentProfile');
        if(!empty($criteria["vName"])) {
            $SQL->where(function ($query) use ($criteria) {
                $query->where('vFirstName', 'like', '%' . $criteria['vName'] . '%');
                $query->orwhere('vLastName','LIKE','%'.$criteria['vName'].'%');
            });

            /* $this->db->where('(CONCAT(hi.vFirstName, " ",hi.vLastName) like "%'.$criteria['keyword'].'%" || hi.vEmail like "%'.$criteria['keyword'].'%" || hi.vUniqueId like "%'.$criteria['keyword'].'%")' );
             $this->db->where('hi.eType','Member'); */
        }
        if(!empty($criteria["vInvestmentDisplayId"])) {
            $SQL->where('vInvestmentDisplayId', 'like', '%' . $criteria['vInvestmentDisplayId']  . '%');
        }
        if(!empty($criteria["vUniqueCode"])) {
            $SQL->where('vUniqueCode', $criteria['vUniqueCode']);
        }
        if(!empty($criteria["vEmail"])) {
            $SQL->where('vEmail', 'like', '%' . $criteria['vEmail'] . '%');
        }
        if(!empty($criteria["vPhone"])) {
            $SQL->where('vPhone', 'like', '%' . $criteria['vPhone'] . '%');
        }
        if(!empty($criteria["status_search"])) {
            $SQL->where("eStatus", $criteria["status_search"]);
        }
        if(!empty($criteria["eStatus"])) {
            $SQL->where("eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria["eIsDeleted"])) {
            $SQL->where("eIsDeleted", $criteria["eIsDeleted"]);
        }
        if(!empty($criteria['column']) || !empty($criteria['order'])) {
            $SQL->orderBy($criteria['column'],$criteria['order']);
        }   
        if($paging == true) {
            $SQL->limit($limit);
            $SQL->skip($start);
        }
        $result = $SQL->get();
        // dd(\DB::getQueryLog());
        return $result;
    }

    public static function get_by_id($criteria = array()) {
        $SQL = DB::table("investmentProfile");
        if($criteria['vUniqueCode'])
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
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
    public static function delete_industry(array $where = []) {
        $update = DB::table('investmentIndustries')->where('iInvestmentProfileId', $where['iInvestmentProfileId'])->delete();
        return true;
    }

    public static function update_industry(array $where = [], array $data = []) {
        \DB::enableQueryLog();
        $update = DB::table('investmentIndustries');
        $update->where($where)->update($data);
        dd(\DB::getQueryLog());
        return true;
    }

    public static function add_toDocument($data) {
        $lastId = DB::table('investmentDocuments')->insertGetId($data);
        return $lastId;
    }
    public static function update_toDocument(array $where = [], array $data = []) {
        $update = DB::table('investmentDocuments');
        $update->where($where)->update($data);
        return true;
    }

    public static function get_ducoments($criteria = array()) {
        $SQL = DB::table("investmentDocuments");
        if($criteria['iInvestmentProfileId']) {
            $SQL->where("iInvestmentProfileId", $criteria["iInvestmentProfileId"]);
        }
        return $result = $SQL->get();
    }
    public static function get_industries_data($criteria = array()) {
        $SQL = DB::table("investmentIndustries");
        if($criteria['iInvestmentProfileId']) {
            $SQL->where("iInvestmentProfileId", $criteria["iInvestmentProfileId"]);
        }
        return $result = $SQL->get();
    }
    public static function get_location_data($criteria = array()) {
        $SQL = DB::table("investmentLocation");
        if($criteria['iInvestmentProfileId']) {
            $SQL->where("iInvestmentProfileId", $criteria["iInvestmentProfileId"]);
        }
        return $result = $SQL->get();
    }
}
