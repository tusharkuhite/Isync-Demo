<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Support\Facades\Hash;
use App\Models\admin\PermissionModel;
use App\Models\admin\PaginationModel;
use App\Models\admin\RoleModel;
use App\Models\admin\UserModel;
use App\Models\admin\ModuleModel;
use App\Models\admin\MetaModel;
use App\Libraries\Paginator;
use App\Libraries\General;
use App\Models\admin\UserPermission;
use Session;
use Validator;
use Intervention\Image\Facades\Image;
=======
use App\Models\admin\PermissionModel;
use App\Models\admin\RoleModel;
use App\Models\admin\UserModel;
use App\Models\admin\ModuleModel;
use App\Libraries\Paginator;
use App\Libraries\General;
>>>>>>> 594515e (testing)

class PermissionController extends Controller
{
    public function index()
<<<<<<< HEAD
    {   
        
        $data  = General::check_module_permission();

        if($data["permission"] != null && $data["permission"]->eRead == "Yes")
        {   
=======
    {

        $data  = General::check_module_permission();

        if ($data["permission"] != null && $data["permission"]->eRead == "Yes") {
>>>>>>> 594515e (testing)
            $criteria             = array();
            $criteria['eStatus']  = "Active";
            $criteria['eDelete']  = "No";
            $data['roles']        = RoleModel::get_all_data($criteria);

            $criteria             = array();
            $criteria['eStatus']  = "Active";
            $criteria['eDelete']  = "No";
            $data['modules']      = ModuleModel::get_all_modules($criteria);

            return view('admin.permission.listing')->with($data);
<<<<<<< HEAD

        }else{
=======
        } else {
>>>>>>> 594515e (testing)

            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }
    }

    public function ajax_listing(Request $request)
    {
        $Pagination_Information     = General::get_pagination_count();
<<<<<<< HEAD
         
=======

>>>>>>> 594515e (testing)
        $vAction         = $request->vAction;
        $vUniqueCode     = $request->vUniqueCode;
        $vRole           = $request->vRole;
        $vModule         = $request->vModule;
        $eStatus         = $request->eStatus;
        $eRead           = $request->eRead;
        $eWrite          = $request->eWrite;
        $eDelete         = $request->eDelete;
        $vColumn         = "iPermissionId";
        $vOrder          = "DESC";
        $iRoleId         = $request->iRoleId;
        $iModuleId       = $request->iModuleId;
        $vKeyword        = $request->vKeyword;
<<<<<<< HEAD
      
        if($vAction == "delete" && !empty($vUniqueCode))
        {
=======

        if ($vAction == "delete" && !empty($vUniqueCode)) {
>>>>>>> 594515e (testing)

            $where                 = array();
            $where['vUniqueCode']  = $request->vUniqueCode;
            $data['eDelete'] = 'Yes';
<<<<<<< HEAD
            $ID = PermissionModel::DeleteData($where,$data);
            
        }
        if($vAction == "status" && !empty($vUniqueCode))
        {
            $result = (explode(",",$vUniqueCode));

            if($eStatus == "delete")
            {
                foreach ($result as $key => $value) 
                {
=======
            $ID = PermissionModel::DeleteData($where, $data);
        }
        if ($vAction == "status" && !empty($vUniqueCode)) {
            $result = (explode(",", $vUniqueCode));

            if ($eStatus == "delete") {
                foreach ($result as $key => $value) {
>>>>>>> 594515e (testing)
                    $where                 = array();
                    $where['vUniqueCode']    = $value;
                    $data = array();
                    $data['eDelete'] = 'Yes';
<<<<<<< HEAD
                    $ID = PermissionModel::DeleteData($where,$data);
                   
                }
            }
            if($eRead == "Yes")
            {
                foreach ($result as $key => $value) 
                {
=======
                    $ID = PermissionModel::DeleteData($where, $data);
                }
            }
            if ($eRead == "Yes") {
                foreach ($result as $key => $value) {
>>>>>>> 594515e (testing)
                    $where                 = array();
                    $where['vUniqueCode']  = $value;
                    $data = array();
                    $data['eRead'] = 'Yes';
<<<<<<< HEAD
                    $ID = PermissionModel::UpdateData($where,$data);
                   
                }

            }
            elseif($eRead == "No")
            {
                foreach ($result as $key => $value) 
                {
=======
                    $ID = PermissionModel::UpdateData($where, $data);
                }
            } elseif ($eRead == "No") {
                foreach ($result as $key => $value) {
>>>>>>> 594515e (testing)
                    $where                 = array();
                    $where['vUniqueCode']  = $value;
                    $data = array();
                    $data['eRead'] = 'No';
<<<<<<< HEAD
                    $ID = PermissionModel::UpdateData($where,$data);
                   
                }
            }
            if($eWrite == "Yes")
            {
                foreach ($result as $key => $value) 
                {
=======
                    $ID = PermissionModel::UpdateData($where, $data);
                }
            }
            if ($eWrite == "Yes") {
                foreach ($result as $key => $value) {
>>>>>>> 594515e (testing)
                    $where                 = array();
                    $where['vUniqueCode']  = $value;
                    $data = array();
                    $data['eWrite'] = 'Yes';
<<<<<<< HEAD
                    $ID = PermissionModel::UpdateData($where,$data);
                }
            }
            elseif($eWrite == "No")
            {
                foreach ($result as $key => $value) 
                {
=======
                    $ID = PermissionModel::UpdateData($where, $data);
                }
            } elseif ($eWrite == "No") {
                foreach ($result as $key => $value) {
>>>>>>> 594515e (testing)
                    $where                 = array();
                    $where['vUniqueCode']  = $value;
                    $data = array();
                    $data['eWrite'] = 'No';
<<<<<<< HEAD
                    $ID = PermissionModel::UpdateData($where,$data);
                   
                }
            }
            if($eDelete == "Yes")
            {
                foreach ($result as $key => $value) 
                {
=======
                    $ID = PermissionModel::UpdateData($where, $data);
                }
            }
            if ($eDelete == "Yes") {
                foreach ($result as $key => $value) {
>>>>>>> 594515e (testing)
                    $where                 = array();
                    $where['vUniqueCode']  = $value;
                    $data = array();
                    $data['eDelete'] = 'Yes';
<<<<<<< HEAD
                    $ID = PermissionModel::UpdateData($where,$data);
                   
                }

            }
            elseif($eDelete == "No")
            {
                foreach ($result as $key => $value) 
                {
=======
                    $ID = PermissionModel::UpdateData($where, $data);
                }
            } elseif ($eDelete == "No") {
                foreach ($result as $key => $value) {
>>>>>>> 594515e (testing)
                    $where                 = array();
                    $where['vUniqueCode']  = $value;
                    $data = array();
                    $data['eDelete'] = 'No';
<<<<<<< HEAD
                    $ID = PermissionModel::UpdateData($where,$data);
                   
=======
                    $ID = PermissionModel::UpdateData($where, $data);
>>>>>>> 594515e (testing)
                }
            }
        }

        $criteria                    = array();
        $criteria['vRole']           = $vRole;
        $criteria['vModule']         = $vModule;
        $criteria['eStatus']         = $eStatus;
        $criteria["paging"]          = false;
        $criteria['column']          = $vColumn;
        $criteria['order']           = $vOrder;
        $criteria['iRoleId']         = $iRoleId;
        $criteria['iModuleId']       = $iModuleId;
        $criteria['vKeyword']        = $vKeyword;
        $PermissionData              = PermissionModel::total_permission_data($criteria);
        $pages                       = 1;
<<<<<<< HEAD
        if($request->pages != "")
        {
=======
        if ($request->pages != "") {
>>>>>>> 594515e (testing)
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = $PermissionData;
        if (!empty($Pagination_Information->vSize)) {
            $paginator->itemsPerPage = $Pagination_Information->vSize;
        }
<<<<<<< HEAD
        if(!empty($request->limit_page))
        {
            $selectedpagelimit = $request->limit_page;
        }
        else  
        {
=======
        if (!empty($request->limit_page)) {
            $selectedpagelimit = $request->limit_page;
        } else {
>>>>>>> 594515e (testing)
            $selectedpagelimit = $paginator->itemsPerPage;
        }
        $start = ($paginator->currentPage - 1) * $selectedpagelimit;
        $limit = $selectedpagelimit;
        $paginator->is_ajax = true;
        $paging = true;
        $criteria["start"]      = $start;
        $criteria["limit"]      = $limit;
        $criteria["paging"]     = $paging;
<<<<<<< HEAD
        
        $data                   = array();
        $data['data']           = PermissionModel::get_all_data($criteria);
        if($paginator->total > $selectedpagelimit)
        {
=======

        $data                   = array();
        $data['data']           = PermissionModel::get_all_data($criteria);
        if ($paginator->total > $selectedpagelimit) {
>>>>>>> 594515e (testing)
            $data['paging'] = $paginator->paginate($selectedpagelimit);
        }
        // --------------

        $data1  = General::check_module_permission();
<<<<<<< HEAD
        
        if($data1["permission"] != null && $data1["permission"]->eRead == "Yes")
        {   
            $data["permission"] = $data1["permission"];
            $data['PermissionData'] = $PermissionData;
            return view('admin.permission.ajax_listing')->with($data); 

        }else{
            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        } 
=======

        if ($data1["permission"] != null && $data1["permission"]->eRead == "Yes") {
            $data["permission"] = $data1["permission"];
            $data['PermissionData'] = $PermissionData;
            return view('admin.permission.ajax_listing')->with($data);
        } else {
            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }
>>>>>>> 594515e (testing)
    }
    public function add()
    {
        $data  = General::check_module_permission();

<<<<<<< HEAD
        if($data["permission"] != null && $data["permission"]->eWrite == "Yes")
        { 
=======
        if ($data["permission"] != null && $data["permission"]->eWrite == "Yes") {
>>>>>>> 594515e (testing)
            $criteria             = array();
            $criteria['eStatus']  = "Active";
            $criteria['eDelete']  = "No";
            $data['roles']        = RoleModel::get_all_data($criteria);

            $criteria             = array();
            $criteria['eStatus']  = "Active";
            $criteria['eDelete']  = "No";
            $data['modules']      = ModuleModel::get_all_data($criteria);

            return view('admin.permission.add')->with($data);
<<<<<<< HEAD
        }else{

            return redirect()->route('admin.permission.listing')->withError('can not access without permission.');
        }  
=======
        } else {

            return redirect()->route('admin.permission.listing')->withError('can not access without permission.');
        }
>>>>>>> 594515e (testing)
    }
    public function edit($vUniqueCode)
    {
        $criteria                   = array();
        $criteria["vUniqueCode"]    = $vUniqueCode;
        $data['permissions']        = PermissionModel::get_by_id($criteria);
<<<<<<< HEAD
         
=======

>>>>>>> 594515e (testing)
        $criteria                   = array();
        $criteria["iModuleId"]      = $data['permissions']->iModuleId;
        $criteria["iRoleId"]        = $data['permissions']->iRoleId;
        $data['allpermissions']     = PermissionModel::get_all_data($criteria);
<<<<<<< HEAD
        
=======

>>>>>>> 594515e (testing)
        $criteria                   = array();
        $criteria["eStatus"]        = "Active";
        $criteria["eDelete"]        = "No";
        $criteria["iRoleId"]        = $data['permissions']->iRoleId;
        $data['userdata']           = UserModel::get_user_by_role_id($criteria);


<<<<<<< HEAD
        if(!empty($vUniqueCode))
        {
            $data1  = General::check_module_permission();

            if($data1["permission"] != null && $data1["permission"]->eWrite == "Yes")
            { 
                $data["permission"] = $data1["permission"];

                 if(!empty($data['permissions']))
                {   
=======
        if (!empty($vUniqueCode)) {
            $data1  = General::check_module_permission();

            if ($data1["permission"] != null && $data1["permission"]->eWrite == "Yes") {
                $data["permission"] = $data1["permission"];

                if (!empty($data['permissions'])) {
>>>>>>> 594515e (testing)
                    $criteria             = array();
                    $criteria['eStatus']  = "Active";
                    $criteria['eDelete']  = "No";
                    $data['roles']        = RoleModel::get_all_data($criteria);

                    $criteria             = array();
                    $criteria['eStatus']  = "Active";
                    $criteria['eDelete']  = "No";
                    $data['modules']      = ModuleModel::get_all_data($criteria);
<<<<<<< HEAD
                    
                    return view('admin.permission.add')->with($data);
                }
                else
                {
                    return redirect()->route('admin.permission.listing');
                }
                
            }else{

                return redirect()->route('admin.permission.listing')->withError('can not access without permission.');
            } 
           
        }
        else
        {
=======

                    return view('admin.permission.add')->with($data);
                } else {
                    return redirect()->route('admin.permission.listing');
                }
            } else {

                return redirect()->route('admin.permission.listing')->withError('can not access without permission.');
            }
        } else {
>>>>>>> 594515e (testing)
            return redirect()->route('admin.permission.listing');
        }
    }

    public function store(Request $request)
<<<<<<< HEAD
    {   
        //dd($request);
        $vUniqueCode = $request->vUniqueCode;

        if($request->eRead != null){
          $data['eRead']        = $request->eRead;   
        }else{
          $data['eRead']        = "No";  
        }
        if($request->eWrite != null){
          $data['eWrite']       = $request->eWrite;   
        }else{
          $data['eWrite']       = "No";  
        }
        if($request->eDelete != null){
          $data['eDelete']      = $request->eDelete;
        }else{
          $data['eDelete']      = "No";  
        } 
        
        if(!empty($vUniqueCode))
        {   
           
=======
    {
        //dd($request);
        $vUniqueCode = $request->vUniqueCode;

        if ($request->eRead != null) {
            $data['eRead']        = $request->eRead;
        } else {
            $data['eRead']        = "No";
        }
        if ($request->eWrite != null) {
            $data['eWrite']       = $request->eWrite;
        } else {
            $data['eWrite']       = "No";
        }
        if ($request->eDelete != null) {
            $data['eDelete']      = $request->eDelete;
        } else {
            $data['eDelete']      = "No";
        }

        if (!empty($vUniqueCode)) {

>>>>>>> 594515e (testing)
            $data['dtUpdatedDate'] = date("Y-m-d H:i:s");
            $where                 = array();
            $where['vUniqueCode']  = $vUniqueCode;
            $ID = PermissionModel::UpdateData($where, $data);
            return redirect()->route('admin.permission.listing')->withSuccess('Permission data updated successfully.');
<<<<<<< HEAD
        }
        else
        {      
            
=======
        } else {

>>>>>>> 594515e (testing)
            $data['iRoleId']     = $request->iRoleId;
            $data['iModuleId']   = $request->iModuleId;
            $data['dtAddedDate'] = date("Y-m-d h:i:s");

            $ID = PermissionModel::AddData($data);
<<<<<<< HEAD
            
            if($ID != null)
            {
                $where = array();
                $where["iPermissionId"]  = $ID;
                $data = array();
                $data['vUniqueCode']     = md5(uniqid(rand(),true)).md5(time()).md5($ID);
=======

            if ($ID != null) {
                $where = array();
                $where["iPermissionId"]  = $ID;
                $data = array();
                $data['vUniqueCode']     = md5(uniqid(rand(), true)) . md5(time()) . md5($ID);
>>>>>>> 594515e (testing)
                PermissionModel::UpdateData($where, $data);
            }

            return redirect()->route('admin.permission.listing')->withSuccess('Permission Added successfully.');
        }
<<<<<<< HEAD
    } 
=======
    }
>>>>>>> 594515e (testing)

    public function get_module_by_role(Request $request)
    {
        $criteria                  = array();
        $criteria['column'] = 'module.vModule';
        $criteria['order']  =   'ASC';
        $criteria['iRoleId']       = $request->iRoleId;
        $allModules                = ModuleModel::get_all_data($criteria);

        $criteria                  = array();
        $criteria['iRoleId']       = $request->iRoleId;
        $moduleExist               = PermissionModel::get_all_data($criteria);
<<<<<<< HEAD
        
        $newArray = [];

        if($allModules != null &&  $moduleExist != null)
        {
            foreach ($allModules as $value1) {
                $moduleIdExists = false;
                if($moduleExist != null)
                {
=======

        $newArray = [];

        if ($allModules != null &&  $moduleExist != null) {
            foreach ($allModules as $value1) {
                $moduleIdExists = false;
                if ($moduleExist != null) {
>>>>>>> 594515e (testing)
                    foreach ($moduleExist as $value2) {
                        if ($value1->iModuleId === $value2->iModuleId) {
                            $moduleIdExists = true;
                            break;
                        }
                    }
                }

                if (!$moduleIdExists) {
                    $newArray[] = $value1;
                }
            }
        }

        $data['modules']  = $newArray;
<<<<<<< HEAD
       
        if(!empty($data['modules']))
        {
          return response()->json($data);

        }else{
          $datas['modules']  = null;
          return response()->json($data);
        }
    }   
=======

        if (!empty($data['modules'])) {
            return response()->json($data);
        } else {
            $datas['modules']  = null;
            return response()->json($data);
        }
    }
>>>>>>> 594515e (testing)

    public function get_user_by_role(Request $request)
    {
        $criteria                  = array();
        $criteria['eStatus']       = "Active";
        $criteria['eDelete']       = "No";
        $criteria['iRoleId']       = $request->iRoleId;
        $users                     = UserModel::get_user_by_role_id($criteria);

        $userData = [];
<<<<<<< HEAD
        foreach($users as $val){

                $userData[]   = $val;     
        }
        if($userData != null)
        {
          $datas['userdata']  = $userData;
          return response()->json($datas);
        }else{

          $datas['userdata']  = null;
          return response()->json($datas);
        }

    } 
=======
        foreach ($users as $val) {

            $userData[]   = $val;
        }
        if ($userData != null) {
            $datas['userdata']  = $userData;
            return response()->json($datas);
        } else {

            $datas['userdata']  = null;
            return response()->json($datas);
        }
    }
>>>>>>> 594515e (testing)
}
