<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SystemEmailModel extends Model
{
    use HasFactory;

    protected $table = 'system_email';

    protected $primaryKey = 'iSystemEmailId';

    public $timestamps = false;

    protected $fillable = ['iSystemEmailId', 'vEmailCode', 'vEmailTitle', 'vFromName', 'vFromEmail', 'vCcEmail', 'vBccEmail', 'vEmailSubject', 'tEmailMessage', 'tSmsMessage', 'tInternalMessage', 'eStatus', 'dtAddedDate', 'dtUpdatedDate'];

      public static function get_all_data($criteria = array())
    {
        $SQL = DB::table("system_email");
     
        if(!empty($criteria["vEmailTitle"]))
        {   
            $SQL->where('vEmailTitle', 'like', '%' . $criteria['vEmailTitle'] . '%');
        }
        if(!empty($criteria["vEmailCode"]))
        {   
            $SQL->where('vEmailCode', 'like', '%' . $criteria['vEmailCode'] . '%');
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
        $result = $SQL->get();
        return $result;
    }
     public static function AddData($data)
    {
        $add = DB::table('system_email')->insertGetId($data);
        return $add;
    }

    public static function get_by_id($criteria = array())
    {
        //dd($criteria);
        $SQL = DB::table("system_email");
        if(!empty($criteria['vUniqueCode']))
        {
            $SQL->where("vUniqueCode", $criteria["vUniqueCode"]);
        }elseif(!empty($criteria['vEmailCode']) && !empty($criteria['eStatus']) )
        {
            $SQL->where("vEmailCode", $criteria["vEmailCode"]);
            $SQL->where("eStatus", $criteria["eStatus"]);
        }
        $SQL->where("eDelete","No");
        $result = $SQL->get();
        return $result->first();
    }
    public static function UpdateData(array $where = [], array $data = [])
    {
        $iSystemEmailId = DB::table('system_email');
        if(!empty($where['vUniqueCode'])){
          $iSystemEmailId->where('vUniqueCode',$where['vUniqueCode'])->update($data);
        }elseif(!empty($where['iSystemEmailId'])){
          $iSystemEmailId->where('iSystemEmailId',$where['iSystemEmailId'])->update($data);
        }
        return $iSystemEmailId;
    }


    public static function total_system_email_data($criteria = array())
    {
        $SQL = DB::table("system_email");
     
        if(!empty($criteria["vEmailTitle"]))
        {
            $SQL->where('vEmailTitle', 'like', '%' . $criteria['vEmailTitle'] . '%');
        }
        if(!empty($criteria["vEmailCode"]))
        {   
            $SQL->where('vEmailCode', 'like', '%' . $criteria['vEmailCode'] . '%');
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
        $result = $SQL->get()->count('iSystemEmailId');
        return $result;
    }
}
