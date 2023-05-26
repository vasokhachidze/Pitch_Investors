<?php
namespace App\Models\front\advisor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class BusinessAdvisor extends Model
{
    use HasFactory;
    protected $table = 'businessAdvisorProfile';
    protected $primaryKey = 'iAdvisorProfileId';
    protected $fillable = ['vAdvisorDisplayId', 'vUniqueCode', 'vFirstName', 'vLastName', 'vEmail', 'vPhone', 'dDob', 'tEducationDetail', 'tDescription', 'vExperince', 'vImage', 'tBio', 'eStatus', 'dtAddedDate', 'dtUpdatedDate', 'eIsDeleted'];

    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '',$listingImage='')
    {
        // \DB::enableQueryLog();
        $SQL = DB::table("businessAdvisorProfile");
        $select_query='';

        //for bookmark query strat
        $SQL->select('businessAdvisorProfile.*', DB::raw("(SELECT bookMark.iBookMarkProfileId FROM bookMark WHERE businessAdvisorProfile.iAdvisorProfileId = bookMark.iBookMarkProfileId AND bookMark.eType = 'Advisor') as bookmark"));
        //for bookmark query end

        if($listingImage)
        {
            $SQL->select('businessAdvisorProfile.*', DB::raw("(SELECT businessAdvisorDocuments.vImage FROM businessAdvisorDocuments WHERE businessAdvisorProfile.iAdvisorProfileId = businessAdvisorDocuments.iBusinessAdvisorId AND businessAdvisorDocuments.eType = 'profile' order by businessAdvisorDocuments.iDocumentId DESC  LIMIT 1) as vImage"), DB::raw("(SELECT bookMark.iBookMarkProfileId FROM bookMark WHERE businessAdvisorProfile.iAdvisorProfileId = bookMark.iBookMarkProfileId AND bookMark.eType = 'Advisor') as bookmark"));
        }
        if (!empty($criteria['industry'])) {
            $SQL->join('businessAdvisorIndustries', 'businessAdvisorProfile.iAdvisorProfileId', '=', 'businessAdvisorIndustries.iAdvisorProfileId');
            $current_array = [];
            foreach ($criteria['industry'] as $key => $value) {
                array_push($current_array,$value);
            }
            $SQL->whereIn('businessAdvisorIndustries.iIndustryId', $current_array);
        }
       if (!empty($criteria['iRegionId']) || !empty($criteria["iCountyId"]) || !empty($criteria["iSubCountyId"])) 
       {
            $SQL->join('businessAdvisorLocation', 'businessAdvisorProfile.iAdvisorProfileId', '=', 'businessAdvisorLocation.iAdvisorProfileId');
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
            // $SQL->whereIn('businessAdvisorLocation.vLocationName', $current_array);
        }
        if(!empty($criteria["profession"])) {
            $SQL->where($criteria["profession"], 'Yes');
        }
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("businessAdvisorProfile.eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria["eAdminApproval"])) {
            $SQL->where("eAdminApproval", $criteria["eAdminApproval"]);
        }
         if(!empty($criteria['column']) || !empty($criteria['order'])) {
            $SQL->orderBy('businessAdvisorProfile.'.$criteria['column'],$criteria['order']);
        }        
        if($paging == true) {
            $SQL->limit($limit);
            $SQL->skip($start);
        }
        $result = $SQL->get();
        // dd(\DB::getQueryLog());
        return $result;
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
    public static function get_by_iUserId($criteria = array()) 
    {
        $SQL = DB::table("businessAdvisorProfile");
        if($criteria['iUserId']) {
            $SQL->where("iUserId", $criteria["iUserId"]);
        }
        $result = $SQL->get();
        return  $result->first();
    }
    public static function get_by_id($criteria = array()) {
        $SQL = DB::table("businessAdvisorProfile");
        if($criteria['vUniqueCode']) {
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
        $add = DB::table('businessAdvisorProfile')->insertGetId($data);
        return $add;
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
    public static function add_toDocument($data) {
       $lastId = DB::table('businessAdvisorDocuments')->insertGetId($data);
        return $lastId;
    }
    public static function update_toDocument(array $where = [], array $data = []) {
        $update = DB::table('businessAdvisorDocuments');
        $update->where($where)->update($data);
        return true;
    }
    public static function get_advisor_documents($criteria = []){
        $SQL = DB::table("businessAdvisorDocuments");
        $SQL->select('vImage');
        if($criteria['iAdvisorProfileId']) {
            $SQL->where("iBusinessAdvisorId", $criteria["iAdvisorProfileId"]);
            $SQL->where("eType", $criteria["eType"]);
        }
        $SQL->orderBy('iDocumentId','DESC');
        $SQL->limit(1);
        $result = $SQL->get();
        return  $result->first();
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
    public static function delete_toDocument(array $where = []) {
        $delete = DB::table('businessAdvisorDocuments')->where('iBusinessAdvisorId', $where['iBusinessAdvisorId'])->delete();
        return true;
    }

    public static function update_data(array $where = [], array $data = []) {
        $iUserId = DB::table('businessAdvisorProfile');
        $iUserId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iUserId;
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
        // $SQL->orderBy('vName', 'asc');
        return $result = $SQL->get();
    }
    public static function get_location_data($criteria = array()) {
        //\DB::enableQueryLog();
        $SQL = DB::table("businessAdvisorLocation");
        if($criteria['iAdvisorProfileId']) {
            $SQL->where("iAdvisorProfileId", $criteria["iAdvisorProfileId"]);
        }
        // $SQL->orderBy('vLocationName', 'asc');
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
        $SQL = DB::table('businessAdvisorProfile');
        $SQL->where($where_field, $where_value);
        $result = $SQL->get();
        return $result->first();
    }
    public static function get_by_connection_profile_id($where_field = '', $where_value = '')
    {
        $SQL = DB::table('businessAdvisorProfile');
        $SQL->select('businessAdvisorProfile.*',DB::raw("(SELECT businessAdvisorDocuments.vImage FROM businessAdvisorDocuments WHERE businessAdvisorProfile.iAdvisorProfileId = businessAdvisorDocuments.iBusinessAdvisorId AND businessAdvisorDocuments.eType = 'profile' LIMIT 1) as vImage"));
        $SQL->where($where_field, $where_value);
        $result = $SQL->get();
        return $result;
    }
}
