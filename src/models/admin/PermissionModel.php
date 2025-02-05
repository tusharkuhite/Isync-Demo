<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class PermissionModel extends Model
{
    
    use HasFactory;
    protected $table = 'permission';
    protected $primaryKey = 'iPermissionId';
    public $timestamps = false;
    protected $fillable = ['iPermissionId','vUniqueCode', 'vCompany','eStatus', 'eDelete', 'dtAddedDate', 'dtUpdatedDate'];
    
    public static function get_all_data($criteria = array())
    {
       
        $SQL = DB::table("permission");

        $SQL->leftJoin("role", "role.iRoleId", "=", "permission.iRoleId")
            ->leftJoin("module", "module.iModuleId", "=", "permission.iModuleId")
            ->select('permission.*', 'role.vRole as vRole', 'role.vCode as vCode','module.vModule as vModule');

        if (!empty($criteria["vKeyword"])) {
            $SQL->where(function ($query) use ($criteria) {
                $query->where('user.vFirstName', "like", "%" . $criteria['vKeyword'] . "%");
                $query->orWhere('user.vLastName', "like", "%" . $criteria['vKeyword'] . "%");
                $query->orWhere(DB::raw('CONCAT(user.vFirstName," ",user.vLastName)'),"like", "%" . $criteria['vKeyword'] . "%");  
            });
        }
    
        if(!empty($criteria["vUniqueCode"]))
        {
            $SQL->where("permission.vUniqueCode",$criteria['vUniqueCode']);
        }
        if(!empty($criteria["iRoleId"]))
        {
            $SQL->where("permission.iRoleId",$criteria['iRoleId']);
        }
        if(!empty($criteria["iModuleId"]))
        {
            $SQL->where("permission.iModuleId",$criteria['iModuleId']);
        }
        if(!empty($criteria["vRole"]))
        {
            $SQL->where("role.vRole", 'like','%' . $criteria['vRole'] . '%');
        }
        if(!empty($criteria["vModule"]))
        {
            $SQL->where("module.vModule", 'like', '%' . $criteria['vModule'] . '%');
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
        
        $result = $SQL->get();
        return $result;
    }
     public static function AddData($data)
    {
        $add = DB::table('permission')->insertGetId($data);
        return $add;
    }

    public static function get_by_id($criteria = array())
    {
        $SQL = DB::table("permission");

        if(!empty($criteria['vUniqueCode']))
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }

        $result = $SQL->get();
        return $result->first();
    }

    public static function get_by_id_permission($criteria = array())
    {
        $SQL = DB::table("permission");
        $SQL->leftJoin("role", "role.iRoleId", "=", "permission.iRoleId")
            ->select('permission.*', 'role.vRole as vRole',);

        if(!empty($criteria['iRoleId']))
        {
            $SQL->where("permission.iRoleId", $criteria["iRoleId"]);
        }
        if(!empty($criteria['iModuleId']))
        {
            $SQL->where("permission.iModuleId", $criteria["iModuleId"]);
        }
        $result = $SQL->get();
        return $result->first();
    }
    
    public static function UpdateData(array $where = [], array $data = [])
    {
        $iPermissionId = DB::table('permission');
        if(!empty($where['vUniqueCode'])){
            $iPermissionId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        }elseif(!empty($where['iPermissionId'])){
            $iPermissionId->where('iPermissionId',$where['iPermissionId'])->update($data);
        }
        return $iPermissionId;
    }

     public static function DeleteData(array $where = [])
    {
        $iPermissionId = DB::table('permission');
        $iPermissionId->where('vUniqueCode',$where['vUniqueCode'])->delete();
        return $iPermissionId;
    }


    public static function total_permission_data($criteria = array())
    {
        $SQL = DB::table("permission");

        $SQL->leftJoin("role", "role.iRoleId", "=", "permission.iRoleId")
            ->leftJoin("module", "module.iModuleId", "=", "permission.iModuleId")
            ->select('permission.*', 'role.vRole as vRole', 'role.vCode as vCode','module.vModule as vModule');

        if (!empty($criteria["vKeyword"])) {
            $SQL->where(function ($query) use ($criteria) {
                $query->where('user.vFirstName', "like", "%" . $criteria['vKeyword'] . "%");
                $query->orWhere('user.vLastName', "like", "%" . $criteria['vKeyword'] . "%");
                $query->orWhere(DB::raw('CONCAT(user.vFirstName," ",user.vLastName)'),"like", "%" . $criteria['vKeyword'] . "%");  
            });
        }
        if(!empty($criteria["vUniqueCode"]))
        {
            $SQL->where("permission.vUniqueCode",$criteria['vUniqueCode']);
        }
        if(!empty($criteria["iRoleId"]))
        {
            $SQL->where("permission.iRoleId",$criteria['iRoleId']);
        }
        if(!empty($criteria["iModuleId"]))
        {
            $SQL->where("permission.iModuleId",$criteria['iModuleId']);
        }
        if(!empty($criteria["vRole"]))
        {
            $SQL->where("role.vRole", 'like','%' . $criteria['vRole'] . '%');
        }
        if(!empty($criteria["vModule"]))
        {
            $SQL->where("module.vModule", 'like', '%' . $criteria['vModule'] . '%');
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

        $result = $SQL->get()->count('permission.iPermissionId');
        return $result;
    }

    public static function check_exist($criteria = array())
    { 
        $SQL = DB::table('permission');

        $SQL->leftJoin("role", "role.iRoleId", "=", "permission.iRoleId")
            ->leftJoin("module", "module.iModuleId", "=", "permission.iModuleId")
            ->select('permission.*', 'role.vRole as vRole', 'role.vCode as vCode','module.vModule as vModule');

        if(!empty($criteria['iRoleId']))
        { 
           $SQL->where('permission.iRoleId',$criteria['iRoleId']);
        }
        if(!empty($criteria['iModuleId']))
        { 
           $SQL->where('permission.iModuleId',$criteria['iModuleId']);
        }
            
        $result = $SQL->get();
        return $result;  

    }
        
}