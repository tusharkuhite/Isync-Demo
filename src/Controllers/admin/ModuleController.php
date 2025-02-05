<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Support\Facades\Hash;
use App\Models\admin\ModuleModel;
use App\Models\admin\PaginationModel;
=======
use App\Models\admin\ModuleModel;
>>>>>>> 594515e (testing)
use App\Models\admin\MenuModel;
use App\Models\admin\MetaModel;
use App\Models\admin\RoleModel;
use App\Libraries\Paginator;
use App\Libraries\General;
<<<<<<< HEAD
use Session;
use Validator;
use Route;
use Intervention\Image\Facades\Image;
=======
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
>>>>>>> 594515e (testing)

class ModuleController extends Controller
{
    public function index()
    {    
        $data = General::check_module_permission();
        
        if($data["permission"] != null && $data["permission"]->eRead == "Yes")
        {

            $criteria             = array();
            $criteria['eStatus']  = "Active";
            $criteria['eDelete']  = "No";
            $data['roles']        = RoleModel::get_all_data($criteria);

            $criteria             = array();
            $criteria['eStatus']  = "Active";
            $criteria['eDelete']  = "No";
            $data['menues']       = MenuModel::get_all_menu_data($criteria);
            
            $criteria             = array();
            $criteria['eStatus']  = "Active";
            $criteria['eDelete']  = "No";
            $data['totalModule']  = ModuleModel::total_module_data($criteria);

            $criteria                = array();
            $criteria['vController'] = "ModuleController";
            $criteria['vMethod']     = "index";
            $criteria['eStatus']     = "Active";
            $data['MetaTitle']       = MetaModel::get_by_id($criteria);

            return view('admin.module.listing')->with($data);

        }else{

            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }
    }

    public function ajax_listing(Request $request)
    {
        $Pagination_Information     = General::get_pagination_count();
        
        $vAction         = $request->vAction;
        $vUniqueCode     = $request->vUniqueCode;
        $vModule         = $request->vModule;
        $vController     = $request->vController;
        $eStatus         = $request->eStatus;
        $eDelete         = $request->eDelete;
        $vColumn         = "iModuleId";
        $vOrder          = "DESC";
        $eStatus_search  = $request->eStatus_search;
        $eFeature_search = $request->eFeature_search;
        $eDeleted        = $request->eDeleted;
        $iRoleId         = $request->iRoleId;
        $vMenu           = $request->vMenu;

        if($vAction == "delete" && !empty($vUniqueCode))
        {
            $where                 = array();
            $where['vUniqueCode']  = $request->vUniqueCode;
            $data['eDelete']       = 'Yes';
            $ID = ModuleModel::UpdateData($where,$data);
        }
        if($vAction == "status" && !empty($vUniqueCode))
        {
            $result = (explode(",",$vUniqueCode));

            if($eStatus == "delete")
            {
                foreach ($result as $key => $value) 
                {
                    $where                 = array();
                    $where['vUniqueCode']  = $value;
                    $data = array();
                    $data['eDelete'] = 'Yes';
                    $ID = ModuleModel::UpdateData($where,$data);
                }
            }
            elseif($eStatus == "Recover")
            {
                foreach ($result as $key => $value) 
                {
                    $where                 = array();
                    $where['vUniqueCode']  = $value;
                    $data = array();
                    $data['eDelete'] = 'No';
                    $ID = ModuleModel::UpdateData($where,$data);
                   
                }
            }
            else
            {
                foreach ($result as $key => $value) 
                {
                    $where = array();
                    $where["vUniqueCode"] = $value;

                    $data = array();
                    $data['eStatus'] = $eStatus;
                    
                    $ID = ModuleModel::UpdateData($where,$data);  
                }
            }
        }

        $criteria                    = array();
        $criteria['vModule']         = $vModule;
        $criteria['vController']     = $vController;
        $criteria['iRoleId']         = $iRoleId;
        $criteria['vMenu']           = $vMenu;
        $criteria['eFeature_search'] = $eFeature_search;
        $criteria["paging"]          = false;
        if($eStatus_search != null)
        {
           $criteria['eStatus']      = $eStatus_search;
        }
        if($eDeleted != null)
        {
           $criteria['eDelete']      = $eDeleted;
        }
        $criteria['column']          = $vColumn;
        $criteria['order']           = $vOrder;
        $ModuleData                  = ModuleModel::total_module_data($criteria);
        $pages                       = 1;
        if($request->pages != "")
        {
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = $ModuleData;
        if (!empty($Pagination_Information->vSize)) {
            $paginator->itemsPerPage = $Pagination_Information->vSize;
        }
        if(!empty($request->limit_page))
        {
            $selectedpagelimit = $request->limit_page;
        }
        else  
        {
            $selectedpagelimit = $paginator->itemsPerPage;
        }
        $start = ($paginator->currentPage - 1) * $selectedpagelimit;
        $limit = $selectedpagelimit;
        $paginator->is_ajax = true;
        $paging = true;
        $criteria["start"]      = $start;
        $criteria["limit"]      = $limit;
        $criteria["paging"]     = $paging;
        
        $data                   = array();
        $data['data']           = ModuleModel::get_all_data($criteria);
        if($paginator->total > $selectedpagelimit)
        {
            $data['paging'] = $paginator->paginate($selectedpagelimit);
        }
        // --------------
        $criteria                = array();
        $criteria['vController'] = "ModuleController";
        $criteria['eDelete']     = "No";
        $criteria['eStatus']     = "Active";
        $criteria["iRoleId"]     = Session::get('iRoleId');
        $module                  = ModuleModel::get_by_id($criteria);
        
        if($module != null)
        {
            $criteria               = array();
            $criteria["iModuleId"]  = $module->iModuleId;
            $General = new General;
            $data["permission"] = $General->check_permission($criteria);
        }
        
        if($data["permission"] != null && $data["permission"]->eRead == "Yes")
        {  
            $data['ModuleData']  = $ModuleData;
            return view('admin.module.ajax_listing')->with($data);  

        }else{

            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }
    }
    public function add()
    {   
        
        $criteria                = array();
        $criteria['vController'] = "ModuleController";
        $criteria['eDelete']     = "No";
        $criteria['eStatus']     = "Active";
        $criteria["iRoleId"]     = Session::get('iRoleId');
        $module                  = ModuleModel::get_by_id($criteria);

        if($module != null)
        {
            $criteria               = array();
            $criteria["iModuleId"]  = $module->iModuleId;
            $General = new General;
            $data["permission"] = $General->check_permission($criteria);
        }  

        if($data["permission"] != null && $data["permission"]->eWrite == "Yes")
        {   
            $controllers = [];
            foreach (Route::getRoutes()->getRoutes() as $route)
            {
                $action = $route->getAction();
                if (array_key_exists('controller', $action))
                {
                    $controllers[]  = $action['controller'];
                    $result = preg_grep('/^App/', $controllers);
                                    
                }       
            }
            $i = 0;
            foreach ($result as $key => $val)
            {
                $find = array("\\");
                $replace = array("-");
                $arry[] = str_replace($find,$replace,$val);
                $results = preg_grep('/^App-Http-Controllers-admin/', $arry);
                $i++;
            }

            $j = 0;
            foreach ($results as $key => $vals)
            {
                $tests[]  = explode("-",$vals);
                $lastElementResult = end($tests[$j]);
                $arrry1[] = explode("@",$lastElementResult);
                $ControllerName[] = $arrry1[$j][0];
                $j++;
            }
            sort($ControllerName);
            $clength = count($ControllerName);
            for($x = 0; $x < $clength; $x++) {
              $ControllerName[$x];
              
            }

            $listofcontrollers = array_unique($ControllerName);
             
             if (($key = array_search('LoginController', $listofcontrollers)) !== false) {
                //dd($key);
               unset($listofcontrollers[$key]);
            }

            $data['controllers']  = $listofcontrollers;

            $criteria             = array();
            $criteria['eStatus']  = "Active";
            $criteria['eDelete']  = "No";
            $data['roles']        = RoleModel::get_all_data($criteria);

            $criteria             = array();
            $criteria['eStatus']  = "Active";
            $criteria['eDelete']  = "No";
            $data['menues']       = MenuModel::get_all_data($criteria);

            $criteria                = array();
            $criteria['vController'] = "ModuleController";
            $criteria['vMethod']     = "add";
            $criteria['eStatus']     = "Active";
            $data['MetaTitle']       = MetaModel::get_by_id($criteria);

            return view('admin.module.add')->with($data);
        }else{

            return redirect()->route('admin.module.listing')->withError('can not access without permission.');
        } 
    }
    public function edit($vUniqueCode)
    {

        $criteria                = array();
        $criteria['vController'] = "ModuleController";
        $criteria['eDelete']     = "No";
        $criteria['eStatus']     = "Active";
        $criteria["iRoleId"]     = Session::get('iRoleId');
        $module                  = ModuleModel::get_by_id($criteria);

        if($module != null)
        {
            $criteria               = array();
            $criteria["iModuleId"]  = $module->iModuleId;
            $General = new General;
            $data["permission"] = $General->check_permission($criteria);
        }

        if($data["permission"] != null && $data["permission"]->eWrite == "Yes")
        { 
               $criteria                   = array();
               $criteria["vUniqueCode"]    = $vUniqueCode;
               $data['modules']            = ModuleModel::get_by_id($criteria);

               $controllers = [];
               foreach (Route::getRoutes()->getRoutes() as $route)
                {
                    $action = $route->getAction();
                    if (array_key_exists('controller', $action))
                    {
                        $controllers[]  = $action['controller'];
                        $result = preg_grep('/^App/', $controllers);
                                        
                    }       
                }
                $i = 0;
                foreach ($result as $key => $val)
                {
                    $find = array("\\");
                    $replace = array("-");
                    $arry[] = str_replace($find,$replace,$val);
                    $results = preg_grep('/^App-Http-Controllers-admin/', $arry);
                    $i++;
                }

                $j = 0;
                foreach ($results as $key => $vals)
                {
                    $tests[]  = explode("-",$vals);
                    $lastElementResult = end($tests[$j]);
                    $arrry1[] = explode("@",$lastElementResult);
                    $ControllerName[] = $arrry1[$j][0];
                    $j++;
                }
                sort($ControllerName);
                $clength = count($ControllerName);
                for($x = 0; $x < $clength; $x++) {
                  $ControllerName[$x];
                  
                }

                $listofcontrollers = array_unique($ControllerName);
            
                 if (($key = array_search('LoginController', $listofcontrollers)) !== false) {
                    //dd($key);
                   unset($listofcontrollers[$key]);
                }

                $data['controllers']       = $listofcontrollers;
                if(!empty($data['modules']))
                {    
                    $criteria             = array();
                    $criteria['eStatus']  = "Active";
                    $criteria['eDelete']  = "No";
                    $data['roles']        = RoleModel::get_all_data($criteria);

                    $criteria             = array();
                    $criteria['eStatus']  = "Active";
                    $criteria['eDelete']  = "No";
                    $data['menues']       = MenuModel::get_all_data($criteria);

                    $criteria                = array();
                    $criteria['vController'] = "ModuleController";
                    $criteria['vMethod']     = "edit";
                    $criteria['eStatus']     = "Active";
                    $data['MetaTitle']       = MetaModel::get_by_id($criteria);

                    return view('admin.module.add')->with($data);
                }
                else
                {
                    return redirect()->route('admin.module.listing');
                }
        }else{
            return redirect()->route('admin.module.listing')->withError('can not access without permission.');
        }
    }

    public function store(Request $request)
    {
        $vUniqueCode = $request->vUniqueCode;
        
        $data                 = array();
        $data['vModule']      = $request->vModule;
        $data['iRoleId']      = $request->iRoleId;
        $data['iMenuId']      = $request->iMenuId;
        $data['vController']  = $request->vController;
        $data['eFeature']     = $request->eFeature;
        $data['eStatus']      = $request->eStatus;
        $data['iOrder']       = $request->iOrder;

        if(!empty($vUniqueCode))
        {
            $data['dtUpdatedDate'] = date("Y-m-d H:i:s");
            $where                 = array();
            $where['vUniqueCode']  = $vUniqueCode;
            $ID = ModuleModel::UpdateData($where, $data);

            return redirect()->route('admin.module.listing')->withSuccess('Module data updated successfully.');
        }
        else
        {                                 
            
            $data['dtAddedDate']   = date("Y-m-d h:i:s");
            $ID = ModuleModel::AddData($data);

            $where = array();
            $where["iModuleId"]  = $ID;
            $data = array();
            $data['vUniqueCode']   = md5(uniqid(rand(),true)).md5(time()).md5($ID);
            ModuleModel::UpdateData($where, $data);

            return redirect()->route('admin.module.listing')->withSuccess('Module created successfully.');
        }
    }  

    public function search_module(Request $request)
    {
        
        $criteria['vModule'] = $request->vModule;
        $criteria['column']  = 'module.vModule';
        $criteria['order']   = 'ASC';
        $criteria["iRoleId"] = $request->session()->get('iRoleId');
        $data = [];
        if(isset($criteria['vModule'])){
            $data['module']     = ModuleModel::show_module_with_permission($criteria);
        }
        return view('layouts.admin.module_list')->with($data);
    }
}
