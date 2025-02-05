<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoginModel extends Model
{
    use HasFactory;
    
<<<<<<< HEAD
    protected $table = 'user';

     public static function  login($criteria)
    {
        $SQL = DB::table("user");
=======
    protected $table = 'users';

     public static function  login($criteria)
    {
        $SQL = DB::table("users");
>>>>>>> 594515e (testing)
        $SQL->where('vEmail',$criteria['vEmail'])->where('vPassword',$criteria['vPassword']);
        $result = $SQL->get();
        return $result->first();
    }

    public static function email_exist($criteria = array())
    {
<<<<<<< HEAD
        $SQL = DB::table("user");
=======
        $SQL = DB::table("users");
>>>>>>> 594515e (testing)
        if($criteria['vEmail'])
        {
            $SQL->where("vEmail", $criteria["vEmail"]);
        }
        $SQL->where("eDelete",$criteria["eDelete"]);
        $SQL->where("eStatus",$criteria["eStatus"]);
        $result = $SQL->get();
        return $result->first();
    }

    public static function UpdateData(array $where = [], array $data = []){
<<<<<<< HEAD
        $vUniqueCode = DB::table('user');
=======
        $vUniqueCode = DB::table('users');
>>>>>>> 594515e (testing)
        $vUniqueCode->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $vUniqueCode;
    }

    public static function authentication($criteria = array())
    {
<<<<<<< HEAD
        $SQL = DB::table("user");
=======
        $SQL = DB::table("users");
>>>>>>> 594515e (testing)
        if($criteria['vAuthCode'])
        {
            $SQL->where("vAuthCode", $criteria["vAuthCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
}
