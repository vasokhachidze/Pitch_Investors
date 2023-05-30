<?php

namespace App\Models\front\contactus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Contactus extends Model
{
    use HasFactory;
    protected $table = 'contact_us';
    protected $fillable = ['iContactUs', 'vUniqueCode', 'vName', 'vEmail', 'vPhone', 'tComments', 'dtAddedDate', 'eStatus', 'eIsDeleted'];

    public static function add($data)
    {
        $add = DB::table('contact_us')->insertGetId($data);
        return $add;
    }
}
