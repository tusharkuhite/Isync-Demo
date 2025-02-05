<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserModel extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'iUserId';
    public $timestamps = false;
    protected $fillable = ['iUserId','iRoleId','vFirstName', 'vLastName', 'vEmail', 'vPassword', 'vImage', 'vPhone', 'dBirthDate','eGender','vImage','iImmigrationStatusId','vAddress1','vAddress2','vAddress3','eAddressCheck','vCity','vZipCode','vState','vPostalAddress','vPostCode','vPTD','vAuthCode','iLoginCount','dtLastLogin','eStatus','dtAddedDate','dtUpdatedDate'];

    public static function get_all_data($criteria = array())
    {
        
        $SQL = DB::table("users");
        $SQL->leftJoin("role", "role.iRoleId", "=", "users.iRoleId");
        $SQL->select('users.*', 'role.vRole as vRole', 'role.vCode as vCode','role.eDelete as roleeDeleted');

        if (!empty($criteria['vKeyword'])) {
            $SQL->where(function ($query) use ($criteria) {
                $query->where('users.vFirstName', "like", "%" . $criteria['vKeyword'] . "%");
                $query->orWhere(DB::raw('CONCAT(users.vFirstName," ",users.vLastName)'),"like", "%" . $criteria['vKeyword'] . "%");
                $query->orWhere('users.vLastName', "like", "%" . $criteria['vKeyword'] . "%");
                $query->orWhere('users.vEmail', "like", "%" . $criteria['vKeyword'] . "%");
                $query->orWhere('users.vPhone', "like", "%" . $criteria['vKeyword'] . "%");
            });
        }

        if(!empty($criteria["vRole"]))
        {
            $SQL->where("role.vRole", $criteria["vRole"]);
        }
        if(!empty($criteria["iUserId"]))
        {
            $SQL->where("users.iUserId", $criteria["iUserId"]);
        }

        if (!empty($criteria["eStatus"])) {
            $SQL->where("users.eStatus", $criteria["eStatus"]);
        } else {
            if (!empty($criteria["eDelete"]) && $criteria["eDelete"] === "Yes") {
                $SQL->whereIn("users.eStatus", ['Active', 'Pending', 'Inactive']);
            } else {
                $SQL->whereIn("users.eStatus", ['Active', 'Pending']);
            }
        }
        if(!empty($criteria["eDelete"]))
        {
            $SQL->where("users.eDelete", $criteria["eDelete"]);
        }else{
            $SQL->where("users.eDelete", "No");
        }
        if(!empty($criteria['column']) || !empty($criteria['order']))
        {
            $SQL->orderBy($criteria['column'],$criteria['order']);
        }
        if(!empty($criteria['paging']) && $criteria['paging'] == "No")
        {
            $SQL->limit($criteria['limit']);
            $SQL->skip($criteria['start']);

        }
        if(!empty($criteria["role"])){
          $SQL->where("role.vRole",$criteria['role']);
        }
        $SQL->where("role.eDelete","No");
        $result = $SQL->get();
        return $result;
    }
     public static function AddData($data)
    {
        $add = DB::table('users')->insertGetId($data);
        return $add;
    }

    public static function get_by_id($criteria = array())
    {
        $SQL = DB::table("users");
        $SQL->leftJoin("role", "role.iRoleId", "=", "users.iRoleId")
            ->select('users.*', 'role.vRole as vRole', 'role.vCode as vCode','role.eDelete as roleeDeleted');

        if(!empty($criteria['vUniqueCode']))
        {
            $SQL->where("users.vUniqueCode", $criteria["vUniqueCode"]);
        }
        if(!empty($criteria['iUserId']))
        {
            $SQL->where("users.iUserId", $criteria["iUserId"]);
        }

        $result = $SQL->get();
        // dd($result);
        return $result->first();
    }
    public static function UpdateData(array $where = [], array $data = [])
    {
        $iUserId = DB::table('users');
        if(!empty($where['vUniqueCode'])){
        $iUserId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        }
        elseif(!empty($where['iUserId'])){
        $iUserId->where('iUserId',$where['iUserId'])->update($data);
        }
        return $iUserId;
    }

    public static function total_user_data($criteria = array())
    {
        $SQL = DB::table("users");
        $SQL->leftJoin("role", "role.iRoleId", "=", "users.iRoleId");
        $SQL->select('users.*', 'role.vRole as vRole', 'role.vCode as vCode','role.eDelete as roleeDeleted');

        if (!empty($criteria['vKeyword'])) {
            $SQL->where(function ($query) use ($criteria) {
                $query->where('users.vFirstName', "like", "%" . $criteria['vKeyword'] . "%");
                $query->orWhere(DB::raw('CONCAT(users.vFirstName," ",users.vLastName)'),"like", "%" . $criteria['vKeyword'] . "%");
                $query->orWhere('users.vLastName', "like", "%" . $criteria['vKeyword'] . "%");
                $query->orWhere('users.vEmail', "like", "%" . $criteria['vKeyword'] . "%");
                $query->orWhere('users.vPhone', "like", "%" . $criteria['vKeyword'] . "%");
            });
        }

        if (!empty($criteria["eStatus"])) {
            $SQL->where("users.eStatus", $criteria["eStatus"]);
        } else {
            if (!empty($criteria["eDelete"]) && $criteria["eDelete"] === "Yes") {
                $SQL->whereIn("users.eStatus", ['Active', 'Pending', 'Inactive']);
            } else {
                $SQL->whereIn("users.eStatus", ['Active', 'Pending']);
            }
        }
        if(!empty($criteria['column']) || !empty($criteria['order']))
        {
            $SQL->orderBy($criteria['column'],$criteria['order']);
        }
        if(!empty($criteria['paging']) && $criteria['paging'] == "No")
        {
            $SQL->limit($criteria['limit']);
            $SQL->skip($criteria['start']);

        }
        if(!empty($criteria["eDelete"]))
        {
            $SQL->where("users.eDelete", $criteria["eDelete"]);
        }else{
            $SQL->where("users.eDelete", "No");
        }
        if(!empty($criteria["vRole"])){
          $SQL->where("role.vRole",$criteria['vRole']);
        }
        $SQL->where("role.eDelete","No");
        $result = $SQL->get()->count('users.iUserId');
        return $result;
    }

    public static function total_usercount_on_status($criteria,$data)
    {
        $SQL = DB::table("users");

        $SQL->leftJoin("role", "role.iRoleId", "=", "users.iRoleId")
            ->select('users.*', 'role.vRole as vRole', 'role.vCode as vCode','role.eDelete as roleeDeleted');

        $SQL->where('users.eDelete','No');
        $SQL->where('role.eDelete','No');
        $SQL->where('role.eStatus','Active');
        $SQL->where('users.eStatus',$criteria['eStatus']);
        $SQL->where("role.vRole",$data['vRole']);
        $result = $SQL->get()->count('users.iUserId');
        return $result;
    }


    public static function check_unique_email($criteria)
        {
            $SQL = DB::table("users");
            if(!empty($criteria['vEmail']))
            {
                $SQL->where('vEmail',$criteria['vEmail'] );
            }
            if(!empty($criteria['vUniqueCode']))
            {
                $SQL->where('vUniqueCode',$criteria['vUniqueCode'] );
            }
            $result = $SQL->first();
            if(empty($result)){
                $SQL = DB::table("user_profile");
                if(!empty($criteria['vEmail']))
                {
                    $SQL->where('vCompanyEmail',$criteria['vEmail'] );
                    $result = $SQL->first();
                }
            }
            return $result;
        }

      public static function get_user_by_role_id($criteria = array())
    {
        $SQL = DB::table("users");
        if(!empty($criteria['vUniqueCode']))
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        if(!empty($criteria['iRoleId']))
        {
            $SQL->where("iRoleId", $criteria["iRoleId"]);
        }
        if(!empty($criteria['eStatus']))
        {
            $SQL->where("eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria['eDelete']))
        {
            $SQL->where("eDelete", $criteria["eDelete"]);
        }
        $result = $SQL->get();
        return $result;
    }

    public static function get_by_role_id($criteria = array())
    {
        $SQL = DB::table("users");
        if(!empty($criteria['iRoleId']))
        {
           $SQL->where("iRoleId",$criteria['iRoleId']);
        }

        if(!empty($criteria['eStatus']))
        {
            $SQL->where("eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria['eDelete']))
        {
            $SQL->where("eDelete", $criteria["eDelete"]);
        }
        $result = $SQL->get();
        return $result;
    }

}
