<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class MetaModel extends Model
{
    
    use HasFactory;
    protected $table = 'meta';
    protected $primaryKey = 'iMetaId';
    public $timestamps = false;
    protected $fillable = ['iMetaId', 'vUniqueCode', 'ePanel', 'vTitle', 'vController','vMethod', 'tKeyword', 'tDescription', 'eStatus'];
    
    public static function get_all_data($criteria = array())
    {   
        $SQL = DB::table("meta");

        if(!empty($criteria["vController"]))
        {
            $SQL->where('vController', 'like', '%' . $criteria['vController'] . '%');
        }
        if(!empty($criteria["vTitle"]))
        {
            $SQL->where('vTitle', 'like', '%' . $criteria['vTitle'] . '%');
        }
        if(!empty($criteria["vSlug"]))
        {
            $SQL->where('vSlug', 'like', '%' . $criteria['vSlug'] . '%');
        }
        if(!empty($criteria["eStatus_search"]))
        {
            $SQL->where("eStatus", $criteria["eStatus_search"]);
        }
        if(!empty($criteria["ePanal_search"]))
        {
            $SQL->where("ePanel", $criteria["ePanal_search"]);
        }
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("eStatus", $criteria["eStatus"]);
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
        $add = DB::table('meta')->insertGetId($data);
        return $add;
    }

    public static function DeleteData(array $where = [])
    {
        $iMetaId = DB::table('meta');
        $iMetaId->where('vUniqueCode',$where['vUniqueCode'])->delete();
        return $iMetaId;
    }

    public static function get_by_id($criteria = array())
    {
        $SQL = DB::table("meta");
        if(!empty($criteria['vUniqueCode']))
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }
        if(!empty($criteria['vController']))
        {
            $SQL->where("vController", $criteria["vController"]);
        }
        if(!empty($criteria['vMethod']))
        {
            $SQL->where("vMethod", $criteria["vMethod"]);
        }
        if(!empty($criteria['eStatus']))
        {
            $SQL->where("eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria['ePanel']))
        {
            $SQL->where("ePanel", $criteria["ePanel"]);
        }
        if(!empty($criteria['vSlug']))
        {
            $SQL->where("vSlug", $criteria["vSlug"]);
        }
     
        $result = $SQL->get();
        return $result->first();
    }
    public static function UpdateData(array $where = [], array $data = [])
    {
        $iMetaId = DB::table('meta');
        if(!empty($where['vUniqueCode'])){
            $iMetaId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        }elseif(!empty($where['iMetaId'])){
            $iMetaId->where('iMetaId',$where['iMetaId'])->update($data);
        }
        return $iMetaId;
    }


    public static function total_data($criteria = array())
    {
        $SQL = DB::table("meta");

        if(!empty($criteria["vController"]))
        {
            $SQL->where('vController', 'like', '%' . $criteria['vController'] . '%');
        }
        if(!empty($criteria["vTitle"]))
        {
            $SQL->where('vTitle', 'like', '%' . $criteria['vTitle'] . '%');
        }
        if(!empty($criteria["vSlug"]))
        {
            $SQL->where('vSlug', 'like', '%' . $criteria['vSlug'] . '%');
        }
        if(!empty($criteria["eStatus_search"]))
        {
            $SQL->where("eStatus", $criteria["eStatus_search"]);
        }
        if(!empty($criteria["eStatus"]))
        {
            $SQL->where("eStatus", $criteria["eStatus"]);
        }
        if(!empty($criteria["ePanal_search"]))
        {
            $SQL->where("ePanel", $criteria["ePanal_search"]);
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
        $result = $SQL->get()->count('iMetaId');
        return $result;
    }

    
    
}