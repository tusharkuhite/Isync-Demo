<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoginModel extends Model
{
    use HasFactory;
    
    protected $table = 'user';

     public static function  login($criteria)
    {
        $SQL = DB::table("user");
        $SQL->where('vEmail',$criteria['vEmail'])->where('vPassword',$criteria['vPassword']);
        $result = $SQL->get();
        return $result->first();
    }

    public static function email_exist($criteria = array())
    {
        $SQL = DB::table("user");
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
        $vUniqueCode = DB::table('user');
        $vUniqueCode->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        return $vUniqueCode;
    }

    public static function authentication($criteria = array())
    {
        $SQL = DB::table("user");
        if($criteria['vAuthCode'])
        {
            $SQL->where("vAuthCode", $criteria["vAuthCode"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
}
