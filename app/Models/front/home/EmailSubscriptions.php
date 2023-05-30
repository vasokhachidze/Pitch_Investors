<?php

namespace App\Models\front\home;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class EmailSubscriptions extends Model
{
    
    use HasFactory;
    protected $table = 'email_subscriptions';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id','name', 'email', 'createdAt'];
  
    public static function add($data)
    {
        $add = DB::table('email_subscriptions')->insertGetId($data);
        return $add;
    }
}
