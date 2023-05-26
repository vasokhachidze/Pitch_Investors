<?php
namespace App\Models\front\review;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Review extends Model
{
    
    use HasFactory;
    protected $table = 'review';
    protected $primaryKey = 'iReviewId';
    public $timestamps = false;
    protected $fillable = ['iReviewId','iProfileId', 'iUserId', 'iRating', 'vReview ','dtAddedDate','dtUpdatedDate'];
      
     public static function get_all_data($criteria = array(), $start = '', $limit = '')
    {        
        $SQL = DB::table("review");
        
        if(!empty($criteria['iProfileId']))
        {
            $SQL->where("iProfileId", $criteria['iProfileId']);
        }   
        if(!empty($criteria['eProfileType']))
        {
            $SQL->where("eProfileType", $criteria['eProfileType']);
        }   
        if(!empty($criteria['column']) || !empty($criteria['order']))
        {
            $SQL->orderBy($criteria['column'],$criteria['order']);
        }   
        $result = $SQL->get();
        return $result;
    }  
    public static function get_all_data_with_user($criteria = array())
    {
        //\DB::enableQueryLog();

        $SQL = DB::table("review")->join('user', 'user.iUserId', '=', 'review.iUserId');
        
        if(!empty($criteria['iProfileId']))
        {
            $SQL->where("iProfileId", $criteria['iProfileId']);
        }   
        if(!empty($criteria['eProfileType']))
        {
            $SQL->where("eProfileType", $criteria['eProfileType']);
        }   
        $result = $SQL->get();
        //dd(\DB::getQueryLog()); 

        return $result;
    }
    public static function get_all_data_with_loginuser($criteria = array())
    {   
        // \DB::enableQueryLog();
        $SQL = DB::table("review")->join('user', 'user.iUserId', '=', 'review.iUserId');
        
        if(!empty($criteria['iProfileId']))
        {
            $SQL->where("iProfileId", $criteria['iProfileId']);
        }   
        if(!empty($criteria['iUserId']))
        {
            $SQL->where("review.iUserId", $criteria['iUserId']);
        }   
        if(!empty($criteria['eProfileType']))
        {
            $SQL->where("review.eProfileType", $criteria['eProfileType']);
        }   
        $result = $SQL->get();
        // dd(\DB::getQueryLog()); 
        return $result->first();
    }

     public static function get_by_id($id)
    {   
        $SQL = DB::table("review");
        $SQL->where("iReviewId", $id);
        $result = $SQL->get();
        return $result->first();
    }

    public static function add($data)
    {
        $add = DB::table('review')->insertGetId($data);
        return $add;
    }
    public static function update_data(array $where = [], array $data = [])
    {
        $iUserId = DB::table('review');
        $iUserId->where('iReviewId',$where['iReviewId'])->update($data);
        return $iUserId;
    }
    public static function update_user(array $where = [], array $data = []) {
        $update = DB::table('review');
        $update->where($where)->update($data);
        return true;
    }

}
