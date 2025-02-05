<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class RoleModel extends Model
{
    
    use HasFactory;
    protected $table = 'role';
    protected $primaryKey = 'iRoleId';
    public $timestamps = false;
    protected $fillable = ['iRoleId','vUniqueCode', 'vRole', 'vCode', 'eStatus', 'eFeature', 'eDelete', 'dtAddedDate', 'dtUpdatedDate'];
    
    public static function get_all_data($criteria = array())
    {
        $SQL = DB::table("role");
     
        if(!empty($criteria["vRole"]))
        {
            $SQL->where('vRole', 'like', '%' . $criteria['vRole'] . '%');
        }
        if(!empty($criteria["vCode"]))
        {
            $SQL->where('vCode', 'like', '%' . $criteria['vCode'] . '%');
        }
        if(!empty($criteria["eFeature_search"]))
        {
            $SQL->where("eFeature", $criteria["eFeature_search"]);
        }
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria["eDelete"]))          
        { 
            $SQL->where("eDelete", $criteria["eDelete"]);
        }else{
            $SQL->where('eDelete','No');
        }
        if(!empty($criteria['iRoleId']))
        {
            $SQL->where("iRoleId", $criteria["iRoleId"]);
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

    public static function get_by_id($criteria = array())
    {
        $SQL = DB::table("role");
        if(!empty($criteria['vRole']))
        {
            $SQL->where("vRole", $criteria["vRole"]);
        }
        if(!empty($criteria['iRoleId']))
        {
            $SQL->where("iRoleId", $criteria["iRoleId"]);
        }
        if(!empty($criteria['vUniqueCode']))
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        if(!empty($criteria['eDelete']))
        {
            $SQL->where("eDelete", $criteria["eDelete"]);
        }
        else
        {
            $SQL->where("eDelete","No");
        }
        if(!empty($criteria['eStatus']))
        {
            $SQL->where("eStatus", $criteria["eStatus"]);
        }
        $result = $SQL->get();
        return $result->first();
    }

    public static function AddData($data)
    {
        $add = DB::table('role')->insertGetId($data);
        return $add;
    }
    
    public static function UpdateData(array $where = [], array $data = [])
    {
        $iRoleId = DB::table('role');
        if(!empty($where['vUniqueCode'])){
          $iRoleId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        }elseif(!empty($where['iRoleId'])){
          $iRoleId->where('iRoleId',$where['iRoleId'])->update($data);  
        }
        return $iRoleId;
    }

    public static function total_role_data($criteria = array())
    {
        $SQL = DB::table("role");
     
        if(!empty($criteria["vRole"]))
        {
            $SQL->where('vRole', 'like', '%' . $criteria['vRole'] . '%');
        }
        if(!empty($criteria["vCode"]))
        {
            $SQL->where('vCode', 'like', '%' . $criteria['vCode'] . '%');
        }
        if(!empty($criteria["eFeature_search"]))
        {
            $SQL->where("eFeature", $criteria["eFeature_search"]);
        }
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria["eDelete"]))          
        { 
            $SQL->where("eDelete", $criteria["eDelete"]);
        }else{
            $SQL->where('eDelete','No');
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
        $result = $SQL->get()->count('iRoleId');
        return $result;
    }

    public static function find_role_id($criteria = array())
    {
        $SQL = DB::table("role");
        $SQL->where("eDelete","No");
        $SQL->where("eStatus","Active");
        $SQL->where("vRole",$criteria['role']);
        $result = $SQL->get();
        return $result->first();
    }

}