<?php

namespace App\Models\admin\login;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Login extends Model
{
    use HasFactory;
    
    protected $table = 'admin';

    public function login($email, $password)
    {
        $SQL = DB::table("admin")->where('email',$email)->where('password',$password);
        $result = $SQL->get();
        return $result;
    }
}
