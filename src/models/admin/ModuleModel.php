<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ModuleModel extends Model
{
    
    use HasFactory;
    protected $table = 'module';
    protected $primaryKey = 'iModuleId';
    public $timestamps = false;
    protected $fillable = ['iModuleId','vUniqueCode', 'vModule', 'vController','eStatus', 'eDelete', 'dtAddedDate', 'dtUpdatedDate'];
    
    public static function get_all_data($criteria = array())
    {
        $SQL = DB::table("module");

        $SQL->leftJoin("role", "role.iRoleId", "=", "module.iRoleId")
            ->leftJoin("menu", "menu.iMenuId", "=", "module.iMenuId")
            ->select('module.*', 'role.vRole as vRole','menu.vMenu as vMenu');

        if(!empty($criteria["iMenuId"]))
        {
            $SQL->where('module.iMenuId',$criteria['iMenuId']);
        }
        if(!empty($criteria["iRoleId"]))
        {
            $SQL->where('module.iRoleId',$criteria['iRoleId']);
        }
        if(!empty($criteria["vController"]))
        {
            $SQL->where('module.vController', 'like', '%' . $criteria['vController'] . '%');
        }
        if(!empty($criteria["vModule"]))
        {
            $SQL->where('module.vModule', 'like', '%' . $criteria['vModule'] . '%');
        }
        if(!empty($criteria["vMenu"]))
        {
            $SQL->where('menu.vMenu', 'like', '%' . $criteria['vMenu'] . '%');
        }
        if(!empty($criteria["eStatus_search"]))
        {
            $SQL->where("module.eStatus", $criteria["eStatus_search"]);
        }
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("module.eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria["eFeature_search"]))
        {
            $SQL->where("module.eFeature", $criteria["eFeature_search"]);
        }
        if(!empty($criteria["eDelete"]))          
        { 
            $SQL->where("module.eDelete", $criteria["eDelete"]);
        }else{
            $SQL->where('module.eDelete','No');
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
        $add = DB::table('module')->insertGetId($data);
        return $add;
    }

    public static function get_by_id($criteria = array())
    {
        $SQL = DB::table("module");
        if(!empty($criteria['vUniqueCode']))
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        if(!empty($criteria['vController']))
        {
            $SQL->where("vController", $criteria["vController"]);
        }
        if(!empty($criteria['iRoleId']))
        {
            $SQL->where("iRoleId", $criteria["iRoleId"]);
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
        $result = $SQL->get();
        return $result->first();
    }
     public static function get_all_data_by_id($criteria = array())
    {
        $SQL = DB::table("module");
        if(!empty($criteria['vUniqueCode']))
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
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
        $result = $SQL->get();
        return $result;
    }
    public static function UpdateData(array $where = [], array $data = [])
    {
        $iModuleId = DB::table('module');
        if(!empty($where['vUniqueCode'])){
            $iModuleId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        }elseif(!empty($where['iModuleId'])){
            $iModuleId->where('iModuleId',$where['iModuleId'])->update($data);
        }
        return $iModuleId;
    }


    public static function total_module_data($criteria = array())
    {
        $SQL = DB::table("module");
     
        $SQL->leftJoin("role", "role.iRoleId", "=", "module.iRoleId")
            ->leftJoin("menu", "menu.iMenuId", "=", "module.iMenuId")
            ->select('module.*', 'role.vRole as vRole','menu.vMenu as vMenu');

        if(!empty($criteria["iMenuId"]))
        {
            $SQL->where('module.iMenuId',$criteria['iMenuId']);
        }
        if(!empty($criteria["iRoleId"]))
        {
            $SQL->where('module.iRoleId',$criteria['iRoleId']);
        }
        if(!empty($criteria["vController"]))
        {
            $SQL->where('module.vController', 'like', '%' . $criteria['vController'] . '%');
        }
        if(!empty($criteria["vModule"]))
        {
            $SQL->where('module.vModule', 'like', '%' . $criteria['vModule'] . '%');
        }
        if(!empty($criteria["vMenu"]))
        {
            $SQL->where('menu.vMenu', 'like', '%' . $criteria['vMenu'] . '%');
        }
        if(!empty($criteria["eFeature_search"]))
        {
            $SQL->where("module.eFeature", $criteria["eFeature_search"]);
        }
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("module.eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria["eDelete"]))          
        { 
            $SQL->where("module.eDelete", $criteria["eDelete"]);
        }else{
            $SQL->where('module.eDelete','No');
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
        $result = $SQL->get()->count('iModuleId');
        return $result;
    }

    public static function show_module_with_permission($criteria){
        $SQL = DB::table("permission");
        $SQL->leftJoin("module", "module.iModuleId", "=", "permission.iModuleId");
        $SQL->select('module.vModule')->distinct();

        if(!empty($criteria["iRoleId"]))
        {
            $SQL->where('permission.iRoleId',$criteria['iRoleId']);
        }
        if(!empty($criteria["vModule"]))
        {
            // $SQL->where('module.vModule', 'like',$criteria['vModule'].'%');
            $SQL->where('module.vModule', 'like','%'.$criteria['vModule'].'%');
        }
        if(!empty($criteria['column']) || !empty($criteria['order']))
        {
            $SQL->orderBy($criteria['column'],$criteria['order']);
        }
     
        $result = $SQL->get();
        return $result;
    }

    public static function get_all_modules($criteria = array())
    {
        $SQL = DB::table("module")->select('vModule')->distinct();
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
        $result = $SQL->get();
        return $result;
    }
}