<?php
namespace App\Models\admin\investor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Investor extends Model
{
    use HasFactory;
    protected $table = 'investorProfile';
    protected $primaryKey = 'iInvestorProfileId';
    public $timestamps = false;
    protected $fillable = ['vInvestorDisplayId', 'iUserId', 'vUniqueCode', 'vFirstName', 'vLastName', 'dDob', 'vEmail', 'vPhone', 'iNationality', 'iCity', 'eInvestingExp', 'vIdentificationNo', 'eAcquiringBusiness', 'eInvestingInBusiness', 'eLendingToBusiness', 'eBuyingProperty', 'vInvest', 'vTimeofInvest', 'vLocation', 'tFactorsInBusiness', 'tAboutCompany', 'eAdvisorGuide', 'dtAddedDate', 'dtUpdatedDate', 'eIsDeleted'];

    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '')
    {
        $SQL = DB::table("investorProfile");
        if(!empty($criteria["vName"]))
        {
            $SQL->where(function ($query) use ($criteria)
            {
                $query->where('vFirstName', 'like', '%' . $criteria['vName'] . '%');
                $query->orwhere('vLastName','LIKE','%'.$criteria['vName'].'%');
            });
        }
        if(!empty($criteria["vInvestorDisplayId"]))
        {
            $SQL->where('vInvestorDisplayId', 'like', '%' . $criteria['vInvestorDisplayId'] . '%');
        }
        if(!empty($criteria["vEmail"]))
        {
            $SQL->where('vEmail', 'like', '%' . $criteria['vEmail'] . '%');
        }
        if(!empty($criteria["vPhone"]))
        {
            $SQL->where('vPhone', 'like', '%' . $criteria['vPhone'] . '%');
        }
        if(!empty($criteria["status_search"]))
        {
            $SQL->where("eStatus", $criteria["status_search"]);
        }
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria["eIsDeleted"]))
        {
            $SQL->where("eIsDeleted", $criteria["eIsDeleted"]);
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
    public static function get_location() {
        $result = [];
        $region_data = DB::table('region')->select('iRegionId', 'vTitle as regionName')->orderBy('vTitle', 'asc')->get();
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
    public static function get_by_id($criteria = array())
    {
        $SQL = DB::table("investorProfile");
        if($criteria['vUniqueCode'])
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
    public static function add($data)
    {
        $add = DB::table('investorProfile')->insertGetId($data);
        return $add;
    }
    public static function update_data(array $where = [], array $data = [])
    {
        $iUserId = DB::table('investorProfile');
        $iUserId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iUserId;
    }
    
    public static function check_unique_email($criteria = array()) // criteria only.
    {
        $SQL = DB::table("investorProfile");
        $SQL->where('vEmail', $criteria['vEmail'] );
        if($criteria['vUniqueCode'])
        {
            $SQL->where('vUniqueCode','<>',$criteria['vUniqueCode']);
        }
        $result = $SQL->get();
        return $result->first();
    }

    public static function update_whereIn(array $where = [], array $data = []) {
        $iUserId = DB::table('investorDocuments');
        $iUserId->whereIn('iInvestorDocId',$where)->update($data);
        return $iUserId;
    }

    public static function save_file($data) {
        $temp_array = [];
        $id = DB::table('investorDocuments')->insertGetId($data);
        if(Session::has('uploaded_identification')) {
            $temp_array = Session::get('uploaded_identification');
        }
        array_push($temp_array,$id);
        Session::put('uploaded_identification',$temp_array);
        return $temp_array;
    }

    public static function add_toDocument($data) {
        $lastId = DB::table('investorDocuments')->insertGetId($data);
        return $lastId;
    }
    public static function update_toDocument(array $where = [], array $data = []) {
        $update = DB::table('investorDocuments');
        $update->where($where)->update($data);
        return true;
    }
    public static function delete_toDocument(array $where = []) {
        $delete = DB::table('investorDocuments')->where('iInvestorProfileId', $where['iInvestorProfileId'])->delete();
        return true;
    }
    
    public static function add_locations($data){
        return DB::table('investorLocation')->insertGetId($data); 
    }
    public static function delete_locations(array $where = []) {
        $update = DB::table('investorLocation')->where('iInvestorProfileId', $where['iInvestorProfileId'])->delete();
        return true;
    }

    public static function add_industry($data) {
        return DB::table('investorIndustries')->insertGetId($data); 
    }
    public static function delete_industry(array $where = []) {
        $update = DB::table('investorIndustries')->where('iInvestorProfileId', $where['iInvestorProfileId'])->delete();
        return true;
    }
     public static function get_industries_data($criteria = array()) {
        $SQL = DB::table("investorIndustries");
        if($criteria['iInvestorProfileId']) {
            $SQL->where("iInvestorProfileId", $criteria["iInvestorProfileId"]);
        }
        return $result = $SQL->get();
    }
    public static function get_location_data($criteria = array()) {
        $SQL = DB::table("investorLocation");
        if($criteria['iInvestorProfileId']) {
            $SQL->where("iInvestorProfileId", $criteria["iInvestorProfileId"]);
        }
        return $result = $SQL->get();
    }
      public static function get_image_id($criteria = array()) {
        $SQL = DB::table("investorDocuments");
        if($criteria['iInvestorProfileId']) {
            $SQL->where("iInvestorProfileId", $criteria["iInvestorProfileId"]);
            $SQL->where("eType", 'profile');
        }
        $result = $SQL->get();
        return $result->first();
    }
}
