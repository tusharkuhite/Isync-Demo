<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class PaginationModel extends Model
{
    
    use HasFactory;
    protected $table = 'pagination';
    protected $primaryKey = 'iPaginationId';
    public $timestamps = false;
    protected $fillable = ['iPaginationId','vUniqueCode', 'vController', 'vSize', 'eStatus', 'eDelete', 'dtAddedDate', 'dtUpdatedDate'];
    
    public static function get_all_data($criteria = array())
    {
        $SQL = DB::table("pagination");
     
        if(!empty($criteria["vController"]))
        {
            $SQL->where('vController', 'like', '%' . $criteria['vController'] . '%');
        }
        if(!empty($criteria["vSize"]))
        {
            $SQL->where('vSize', 'like', '%' . $criteria['vSize'] . '%');
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
     public static function AddData($data)
    {
        $add = DB::table('pagination')->insertGetId($data);
        return $add;
    }

    public static function get_by_id($criteria = array())
    {
        $SQL = DB::table("pagination");
        if(!empty($criteria['vUniqueCode']))
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }elseif(!empty($criteria['vController']))
        {
            $SQL->where("vController", $criteria["vController"]);
        }
         if(!empty($criteria['eStatus']))
        {
            $SQL->where("eStatus", $criteria["eStatus"]);
        }
        $SQL->where("eDelete","No");
        $result = $SQL->get();
        return $result->first();
    }
    public static function UpdateData(array $where = [], array $data = [])
    {
        $iPaginationId = DB::table('pagination');
        if(!empty($where['vUniqueCode'])){
            $iPaginationId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        }elseif(!empty($where['iPaginationId'])){
            $iPaginationId->where('iPaginationId',$where['iPaginationId'])->update($data);
        }
        return $iPaginationId;
    }

    public static function DeleteData(array $where = [])
    {
        $iTokenId = DB::table('pagination');
        $iTokenId->where('vUniqueCode',$where['vUniqueCode'])->delete();
        return $iTokenId;
    }


    public static function total_pagination_data($criteria = array())
    {
        $SQL = DB::table("pagination");
     
        if(!empty($criteria["vController"]))
        {
            $SQL->where('vController', 'like', '%' . $criteria['vController'] . '%');
        }
        if(!empty($criteria["vSize"]))
        {
            $SQL->where('vSize', 'like', '%' . $criteria['vSize'] . '%');
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
        if( !empty($criteria['paging']) && $criteria['paging'] == "No")
        {
            $SQL->limit($criteria['limit']);
            $SQL->skip($criteria['start']);
        }
        $result = $SQL->get()->count('iPaginationId');
        return $result;
    }

    
    
}