<?php
namespace App\Models\front\investor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Investor extends Model
{
    use HasFactory;
    protected $table = 'investorProfile';
    protected $primaryKey = 'iInvestorProfileId';
    public $timestamps = false;
    protected $fillable = ['vInvestorDisplayId', 'iUserId', 'vUniqueCode', 'vFirstName', 'vLastName', 'dDob', 'vEmail', 'vPhone', 'iNationality', 'iCity', 'eInvestingExp', 'vIdentificationNo', 'eAcquiringBusiness', 'eInvestingInBusiness', 'eLendingToBusiness', 'eBuyingProperty', 'vInvest', 'vTimeofInvest', 'vLocation', 'tFactorsInBusiness', 'tAboutCompany', 'eAdvisorGuide', 'dtAddedDate', 'dtUpdatedDate', 'eIsDeleted'];

    public static function get_all_data($criteria = array(), $start = '', $limit = '', $paging = '',$listingImage='')
    {
       // \DB::enableQueryLog();
        $SQL = DB::table("investorProfile");
        $select_query='';

        //for bookmark query strat
        $SQL->select('investorProfile.*', DB::raw("(SELECT bookMark.iBookMarkProfileId FROM bookMark WHERE investorProfile.iInvestorProfileId = bookMark.iBookMarkProfileId AND bookMark.eType = 'Investor') as bookmark"));
        //for bookmark query end

        if($listingImage)
        {
            $SQL->select('investorProfile.*', DB::raw("(SELECT investorDocuments.vImage FROM investorDocuments WHERE investorProfile.iInvestorProfileId = investorDocuments.iInvestorProfileId AND investorDocuments.eType = 'profile' LIMIT 1) as vImage"), DB::raw("(SELECT bookMark.iBookMarkProfileId FROM bookMark WHERE investorProfile.iInvestorProfileId = bookMark.iBookMarkProfileId AND bookMark.eType = 'Investor') as bookmark"));
        }
        if(!empty($criteria['otherField']))
        {
            foreach ($criteria['otherField'] as $key => $value) {                
                $SQL->orWhere($value,'Yes');
            }
        }
        if (!empty($criteria['industry'])) {
            $SQL->join('investorIndustries', 'investorProfile.iInvestorProfileId', '=', 'investorIndustries.iInvestorProfileId');
            $current_array = [];
            foreach ($criteria['industry'] as $key => $value) {
                array_push($current_array,$value);
            }
            $SQL->whereIn('investorIndustries.iIndustryId', $current_array);
        }
       if (!empty($criteria['iRegionId']) || !empty($criteria["iCountyId"]) || !empty($criteria["iSubCountyId"])) 
        {
            $SQL->join('investorLocation', 'investorProfile.iInvestorProfileId', '=', 'investorLocation.iInvestorProfileId');
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
            // $SQL->whereIn('investorLocation.vLocationName', $current_array);
        }

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
         if(!empty($criteria["eInvestorType"]))
        {
            $SQL->where('eInvestorType',$criteria['eInvestorType']);
        }      
        if(!empty($criteria["interested"])) {
            $SQL->where($criteria["interested"], 'Yes');
        }

        if(!empty($criteria["status_search"]))
        {
            $SQL->where("eStatus", $criteria["status_search"]);
        }
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("investorProfile.eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria["eIsDeleted"]))
        {
            $SQL->where("eIsDeleted", $criteria["eIsDeleted"]);
        }
        if(!empty($criteria["eAdminApproval"])) {
            $SQL->where("eAdminApproval", $criteria["eAdminApproval"]);
        }
        if(!empty($criteria['column']) || !empty($criteria['order']))
        {
            $SQL->orderBy('investorProfile.'.$criteria['column'],$criteria['order']);
        }   
        if($paging == true)
        {
            $SQL->limit($limit);
            $SQL->skip($start);
        }
        $result = $SQL->get();
//        dd(\DB::getQueryLog()); // Show results of log

        return $result;
    }
    public static function get_by_iUserId($criteria = array()) 
    {
        $SQL = DB::table("investorProfile");
        if($criteria['iUserId']) {
            $SQL->where("iUserId", $criteria["iUserId"]);
        }
        $result = $SQL->get();
        return  $result->first();
    }

    public static function get_by_id($criteria = array())
    {
        $SQL = DB::table("investorProfile");
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
    public static function add($data)
    {
        $add = DB::table('investorProfile')->insertGetId($data);
        return $add;
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

    public static function get_image_id($criteria = array()) {
        $SQL = DB::table("investorDocuments");
        if($criteria['iInvestorProfileId']) {
            $SQL->where("iInvestorProfileId", $criteria["iInvestorProfileId"]);
            // $SQL->where("eType", 'profile');
        }
        $result = $SQL->get();
        return $result;
        // return $result->first();
    }
     public static function delete_document_byId($iInvestorDocId) {
        $delete = DB::table('investorDocuments')->where('iInvestorDocId', $iInvestorDocId)->delete();
        return true;
    } 
    public static function delete_document_byName($fileName) {
        $delete = DB::table('investorDocuments')->where('vFileName', $fileName)->delete();
        return true;
    }
   /* public static function get_all_documents($criteria = array()) {
        $SQL = DB::table("investorDocuments");
        if(!empty($criteria['iInvestorProfileId'])) 
        {
            $SQL->where("iInvestorProfileId", $criteria["iInvestorProfileId"]);
            $SQL->where("eType", 'profile');
        }
        $result = $SQL->get();
        return $result->first();
    }*/

    public static function add_industry($data) {
        return DB::table('investorIndustries')->insertGetId($data);
    }
    public static function delete_industry(array $where = []) {
        $update = DB::table('investorIndustries')->where('iInvestorProfileId', $where['iInvestorProfileId'])->delete();
        return true;
    }

    public static function add_locations($data){
        return DB::table('investorLocation')->insertGetId($data);
    }
    
    public static function delete_locations(array $where = []) {
        $update = DB::table('investorLocation')->where('iInvestorProfileId', $where['iInvestorProfileId'])->delete();
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
    public static function update_data(array $where = [], array $data = [])
    {
        $iUserId = DB::table('investorProfile');
        $iUserId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $iUserId;
    }
    public static function get_industries_data($criteria = array()) {
        $SQL = DB::table("investorIndustries");
        if($criteria['iInvestorProfileId']) {
            $SQL->where("iInvestorProfileId", $criteria["iInvestorProfileId"]);
        }
        $SQL->orderBy('vIndustryName', 'asc');
        return $result = $SQL->get();
    }
    public static function get_location_data($criteria = array()) {
        // \DB::enableQueryLog();
        $SQL = DB::table("investorLocation");
        if($criteria['iInvestorProfileId']) {
            $SQL->where("iInvestorProfileId", $criteria["iInvestorProfileId"]);
        }
        

        return $result = $SQL->get();
    }

    public static function get_connection($criteria = array())
    {
        $SQL = DB::table("connection");
        $SQL->where(function ($query) use ($criteria)
        {
            $query->where("iSenderProfileId", $criteria['iSenderProfileId'])
            ->where("eSenderProfileType", $criteria['eSenderProfileType'])
            ->where("iReceiverProfileId", $criteria['iReceiverProfileId'])
            ->where("eReceiverProfileType", $criteria['eReceiverProfileType']);
        })
        ->orWhere(function ($query) use ($criteria)
        {
            $query->where("iSenderProfileId", $criteria['iReceiverProfileId'])
            ->where("eSenderProfileType", $criteria['eReceiverProfileType'])
            ->where("iReceiverProfileId", $criteria['iSenderProfileId'])
            ->where("eReceiverProfileType", $criteria['eSenderProfileType']);
        });
        /* echo $result = $SQL->toSql();dd($criteria); */
        $result = $SQL->get();
        if (isset($result[0]->iConnectionId)) {
            return $result;
        }
        return;
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
        $SQL = DB::table('investorProfile');
        $SQL->where($where_field, $where_value);
        $result = $SQL->get();
        return $result->first();
    }
     public static function get_by_connection_profile_id($where_field = '', $where_value = '')
    {
        $SQL = DB::table('investorProfile');
         $SQL->select('investorProfile.*', DB::raw("(SELECT investorDocuments.vImage FROM investorDocuments WHERE investorProfile.iInvestorProfileId = investorDocuments.iInvestorProfileId AND investorDocuments.eType = 'profile' LIMIT 1) as vImage"));
        $SQL->where($where_field, $where_value);
        $result = $SQL->get();
        return $result;
    }
    
}