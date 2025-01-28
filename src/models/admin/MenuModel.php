<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class MenuModel extends Model
{
    
    use HasFactory;
    protected $table = 'menu';
    protected $primaryKey = 'iMenuId';
    public $timestamps = false;
    protected $fillable = ['iMenuId','vUniqueCode', 'vMenu','eStatus', 'eDelete', 'dtAddedDate', 'dtUpdatedDate'];
    
    public static function get_all_data($criteria = array())
    {
        $SQL = DB::table("menu");

        $SQL->leftJoin("role", "role.iRoleId", "=", "menu.iRoleId")
            ->select('menu.*', 'role.vRole as vRole');
     
        if(!empty($criteria["iRoleId"]))
        {
            $SQL->where('menu.iRoleId',$criteria['iRoleId']);
        }
        if(!empty($criteria["vMenu"]))
        {
            $SQL->where('menu.vMenu', 'like', '%' . $criteria['vMenu'] . '%');
        }
        if(!empty($criteria["vCode"]))
        {
            $SQL->where('menu.vCode', 'like', '%' . $criteria['vCode'] . '%');
        }
        if(!empty($criteria["eFeature_search"]))
        {
            $SQL->where("menu.eFeature", $criteria["eFeature_search"]);
        }
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("menu.eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria["eDelete"]))          
        { 
            $SQL->where("menu.eDelete", $criteria["eDelete"]);
        }else{
            $SQL->where('menu.eDelete','No');
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

        foreach($result as $key=>$value){
            $SQL = DB::table("module");
            $SQL->where("iMenuId",$value->iMenuId);
            $SQL->where("eDelete","No");
            $SQL->where("eStatus","Active");
            $SQL->orderBy('iOrder', 'ASC')->get();
            $result[$key]->iModuleId = $SQL->get();   
        }

        return $result;
    }
     public static function AddData($data)
    {
        $add = DB::table('menu')->insertGetId($data);
        return $add;
    }

    public static function get_by_id($criteria = array())
    {
        $SQL = DB::table("menu");
        if(!empty($criteria['vUniqueCode']))
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        $SQL->where("eDelete","No");
        $result = $SQL->get();
        return $result->first();
    }
    public static function UpdateData(array $where = [], array $data = [])
    {
        $iMenuId = DB::table('menu');
        if(!empty($where['vUniqueCode'])){
            $iMenuId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        }elseif(!empty($where['iMenuId'])){
            $iMenuId->where('iMenuId',$where['iMenuId'])->update($data);
        }
        return $iMenuId;
    }


    public static function total_menu_data($criteria = array())
    {

        $SQL = DB::table("menu");

        $SQL->leftJoin("role", "role.iRoleId", "=", "menu.iRoleId")
            ->select('menu.*', 'role.vRole as vRole');
     
        if(!empty($criteria["iRoleId"]))
        {
            $SQL->where('menu.iRoleId',$criteria['iRoleId']);
        }
        if(!empty($criteria["vMenu"]))
        {
            $SQL->where('menu.vMenu',  'like', '%' . $criteria['vMenu'] . '%');
        }
        if(!empty($criteria["vCode"]))
        {
            $SQL->where('menu.vCode', 'like', '%' . $criteria['vCode'] . '%');
        }
        if(!empty($criteria["eFeature_search"]))
        {
            $SQL->where("menu.eFeature", $criteria["eFeature_search"]);
        }
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("menu.eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria["eDelete"]))          
        { 
            $SQL->where("menu.eDelete", $criteria["eDelete"]);
        }else{
            $SQL->where('menu.eDelete','No');
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
        $result = $SQL->get()->count('iMenuId');
        return $result;
    }

    public static function get_all_menu_data($criteria = array())
    {

        $SQL = DB::table("menu")->select('vMenu')->distinct();

        if(!empty($criteria["iRoleId"]))
        {
            $SQL->where('iRoleId',$criteria['iRoleId']);
        }
        if(!empty($criteria["vMenu"]))
        {
            $SQL->where('vMenu',  'like', '%' . $criteria['vMenu'] . '%');
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
        $result = $SQL->get();
        return $result;
    }

    
    
}