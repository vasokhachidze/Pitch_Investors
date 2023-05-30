<?php
namespace App\Models\admin\business_advisor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class BusinessAdvisor extends Model
{
    use HasFactory;
    protected $table = 'businessAdvisorProfile';
    protected $primaryKey = 'iAdvisorProfileId';
    public $timestamps = false;
    protected $fillable = ['vAdvisorDisplayId', 'vUniqueCode', 'vFirstName', 'vLastName', 'vEmail', 'vPhone', 'dDob', 'tEducationDetail', 'tDescription', 'vExperince', 'vImage', 'tBio', 'eStatus', 'dtAddedDate', 'dtUpdatedDate', 'eIsDeleted'];
    
    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '')
    {
        $SQL = DB::table('businessAdvisorProfile');
        if(!empty($criteria["vName"])) {
            $SQL->where(function ($query) use ($criteria) {
                $query->where('vFirstName', 'like', '%' . $criteria['vName'] . '%');
                $query->orwhere('vLastName','LIKE','%'.$criteria['vName'].'%');
            });
        }
        if(!empty($criteria["vAdvisorDisplayId"])) {
            $SQL->where('vAdvisorDisplayId', 'like', '%' . $criteria['vAdvisorDisplayId'] . '%');
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
        return $result;
    }

    public static function get_by_id($criteria = array()) {
        $SQL = DB::table("businessAdvisorProfile");
        if($criteria['vUniqueCode']) {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
    public static function add($data) {
        $add = DB::table('businessAdvisorProfile')->insertGetId($data);
        return $add;
    }
    public static function add_toDocument($data) {
       $lastId = DB::table('businessAdvisorDocuments')->insertGetId($data);
        return $lastId;
    }
    public static function update_toDocument(array $where = [], array $data = []) {
        $update = DB::table('businessAdvisorDocuments');
        $update->where($where)->update($data);
        return true;
    }
    public static function delete_toDocument(array $where = []) {
        $delete = DB::table('businessAdvisorDocuments')->where('iBusinessAdvisorId', $where['iBusinessAdvisorId'])->delete();
        return true;
    }
    
    public static function get_advisor_images($criteria = array()) {
        $SQL = DB::table("businessAdvisorDocuments");
        if($criteria['iAdvisorProfileId']) {
            $SQL->where("iBusinessAdvisorId", $criteria["iAdvisorProfileId"]);
        }
        $result = $SQL->get();
        return $result;
    }
    public static function delete_document_byId($iDocumentId) {
        $delete = DB::table('businessAdvisorDocuments')->where('iDocumentId', $iDocumentId)->delete();
        return true;
    }
    public static function delete_document_byName($fileName) {
        $delete = DB::table('businessAdvisorDocuments')->where('vFileName', $fileName)->delete();
        return true;
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
        return DB::table('businessAdvisorLocation')->insertGetId($data); 
    }
    public static function delete_locations(array $where = []) {
        $update = DB::table('businessAdvisorLocation')->where('iAdvisorProfileId', $where['iAdvisorProfileId'])->delete();
        return true;
    }

    public static function add_industry($data) {
        return DB::table('businessAdvisorIndustries')->insertGetId($data); 
    }
    public static function delete_industry(array $where = []) {
        $update = DB::table('businessAdvisorIndustries')->where('iAdvisorProfileId', $where['iAdvisorProfileId'])->delete();
        return true;
    }
    public static function update_industry(array $where = [], array $data = []) {
        $update = DB::table('businessAdvisorIndustries');
        $update->where($where)->update($data);
        return true;
    }

    public static function get_industries_data($criteria = array()) {
        $SQL = DB::table("businessAdvisorIndustries");
        if($criteria['iAdvisorProfileId']) {
            $SQL->where("iAdvisorProfileId", $criteria["iAdvisorProfileId"]);
        }
        return $result = $SQL->get();
    }

    public static function get_location_data($criteria = array()) {
        $SQL = DB::table("businessAdvisorLocation");
        if($criteria['iAdvisorProfileId']) {
            $SQL->where("iAdvisorProfileId", $criteria["iAdvisorProfileId"]);
        }
        return $result = $SQL->get();
    }

    public static function update_data(array $where = [], array $data = []) {
        $iUserId = DB::table('businessAdvisorProfile');
        $iUserId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iUserId;
    }


    public static function update_whereIn(array $where = [], array $data = []) {
        $iUserId = DB::table('businessAdvisorDocuments');
        $iUserId->whereIn('iDocumentId',$where)->update($data);
        return $iUserId;
    }
    
    public static function check_unique_email($criteria = array()) {
        $SQL = DB::table("businessAdvisorProfile");
        $SQL->where('vEmail', $criteria['vEmail'] );
        if($criteria['vUniqueCode']) {
            $SQL->where('vUniqueCode','<>',$criteria['vUniqueCode']);
        }
        $result = $SQL->get();
        return $result->first();
    }

    public static function save_file($data) {
        $temp_array = [];
        $id = DB::table('businessAdvisorDocuments')->insertGetId($data);
        if(Session::has('uploaded_document')) {
            $temp_array = Session::get('uploaded_document');
        }
        array_push($temp_array,$id);
        Session::put('uploaded_document',$temp_array);
        return $temp_array;
    }
}
