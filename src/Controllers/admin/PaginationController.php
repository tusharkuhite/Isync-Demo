<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Support\Facades\Hash;
use App\Models\admin\PaginationModel;
use App\Models\admin\LogModel;
use App\Models\admin\ModuleModel;
use App\Models\admin\MetaModel;
use App\Libraries\Paginator;
use App\Libraries\General;
use Session;
use Validator;
use Route;
use Intervention\Image\Facades\Image;
=======
use App\Models\admin\PaginationModel;
use App\Models\admin\MetaModel;
use App\Libraries\Paginator;
use App\Libraries\General;
use Illuminate\Support\Facades\Route;
>>>>>>> 594515e (testing)

class PaginationController extends Controller
{
    public function index()
    {
        $data  = General::check_module_permission();
<<<<<<< HEAD
        
        if($data["permission"] != null && $data["permission"]->eRead == "Yes")
        {
=======

        if ($data["permission"] != null && $data["permission"]->eRead == "Yes") {
>>>>>>> 594515e (testing)
            $criteria                = array();
            $criteria['vController'] = "PaginationController";
            $criteria['vMethod']     = "index";
            $criteria['eStatus']     = "Active";
            $data['MetaTitle']       = MetaModel::get_by_id($criteria);


            $criteria                = array();
            $criteria['eDelete']     = "No";
            $criteria['eStatus']     = "Active";
            $data['totalPagination'] = PaginationModel::total_pagination_data($criteria);

            return view('admin.pagination.listing')->with($data);
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
<<<<<<< HEAD
       
        $Pagination_Information     = General::get_pagination_count();
        
=======

        $Pagination_Information     = General::get_pagination_count();

>>>>>>> 594515e (testing)
        $vAction         = $request->vAction;
        $vUniqueCode     = $request->vUniqueCode;
        $vController     = $request->vController;
        $vSize           = $request->vSize;
        $eStatus         = $request->eStatus;
        $eDelete         = $request->eDelete;
        $vColumn         = "iPaginationId";
        $vOrder          = "DESC";
        $eStatus_search  = $request->eStatus_search;
        $eDeleted        = $request->eDeleted;

<<<<<<< HEAD
        if($vAction == "delete" && !empty($vUniqueCode))
        {
=======
        if ($vAction == "delete" && !empty($vUniqueCode)) {
>>>>>>> 594515e (testing)

            $where                 = array();
            $where['vUniqueCode']  = $request->vUniqueCode;
            $ID = PaginationModel::DeleteData($where);
<<<<<<< HEAD
            
        }
        if($vAction == "status" && !empty($vUniqueCode))
        {
            $result = (explode(",",$vUniqueCode));

            if($eStatus == "delete")
            {
                foreach ($result as $key => $value) 
                {
=======
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
                    $ID = PaginationModel::UpdateData($where,$data);
                   
                }
            }
            elseif($eStatus == "Recover")
            {
                foreach ($result as $key => $value) 
                {
=======
                    $ID = PaginationModel::UpdateData($where, $data);
                }
            } elseif ($eStatus == "Recover") {
                foreach ($result as $key => $value) {
>>>>>>> 594515e (testing)
                    $where                 = array();
                    $where['vUniqueCode']  = $value;
                    $data = array();
                    $data['eDelete'] = 'No';
<<<<<<< HEAD
                    $ID = PaginationModel::UpdateData($where,$data);
                   
                }
            }
            else
            {
                foreach ($result as $key => $value) 
                {
=======
                    $ID = PaginationModel::UpdateData($where, $data);
                }
            } else {
                foreach ($result as $key => $value) {
>>>>>>> 594515e (testing)
                    $where = array();
                    $where["vUniqueCode"] = $value;

                    $data = array();
                    $data['eStatus'] = $eStatus;
<<<<<<< HEAD
                    
                    $ID = PaginationModel::UpdateData($where,$data); 

=======

                    $ID = PaginationModel::UpdateData($where, $data);
>>>>>>> 594515e (testing)
                }
            }
        }

        $criteria                    = array();
        $criteria['vController']     = $vController;
        $criteria['vSize']           = $vSize;
        $criteria["paging"]          = false;
<<<<<<< HEAD
        if($eStatus_search != null)
        {
           $criteria['eStatus']      = $eStatus_search;
        }

        if($eDeleted != null)
        {
           $criteria['eDelete']      = $eDeleted;
=======
        if ($eStatus_search != null) {
            $criteria['eStatus']      = $eStatus_search;
        }

        if ($eDeleted != null) {
            $criteria['eDelete']      = $eDeleted;
>>>>>>> 594515e (testing)
        }
        $criteria['column']          = $vColumn;
        $criteria['order']           = $vOrder;
        $PaginationData              = PaginationModel::total_pagination_data($criteria);
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
        $paginator->total = $PaginationData;
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
        $data['data']           = PaginationModel::get_all_data($criteria);
        if($paginator->total > $selectedpagelimit)
        {
            $data['paging'] = $paginator->paginate($selectedpagelimit);
        }
        
        $data1  = General::check_module_permission();
        
        if($data1["permission"] != null && $data1["permission"]->eRead == "Yes")
        {  
            $data["permission"] = $data1["permission"];
            $data['PaginationData']  = $PaginationData;
            return view('admin.pagination.ajax_listing')->with($data);  

        }else{
=======

        $data                   = array();
        $data['data']           = PaginationModel::get_all_data($criteria);
        if ($paginator->total > $selectedpagelimit) {
            $data['paging'] = $paginator->paginate($selectedpagelimit);
        }

        $data1  = General::check_module_permission();

        if ($data1["permission"] != null && $data1["permission"]->eRead == "Yes") {
            $data["permission"] = $data1["permission"];
            $data['PaginationData']  = $PaginationData;
            return view('admin.pagination.ajax_listing')->with($data);
        } else {
>>>>>>> 594515e (testing)

            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }
    }
    public function add()
<<<<<<< HEAD
    { 
        $data  = General::check_module_permission();

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
=======
    {
        $data  = General::check_module_permission();

        if ($data["permission"] != null && $data["permission"]->eWrite == "Yes") {
            $controllers = [];
            foreach (Route::getRoutes()->getRoutes() as $route) {
                $action = $route->getAction();
                if (array_key_exists('controller', $action)) {
                    $controllers[]  = $action['controller'];
                    $result = preg_grep('/^App/', $controllers);
                }
            }

            $i = 0;
            foreach ($result as $key => $val) {
                $find = array("\\");
                $replace = array("-");
                $arry[] = str_replace($find, $replace, $val);
>>>>>>> 594515e (testing)
                $results = preg_grep('/^App-Http-Controllers-admin/', $arry);
                $i++;
            }

            $j = 0;
<<<<<<< HEAD
            foreach ($results as $key => $vals)
            {
                $tests[]  = explode("-",$vals);
                $lastElementResult = end($tests[$j]);
                $arrry1[] = explode("@",$lastElementResult);
=======
            foreach ($results as $key => $vals) {
                $tests[]  = explode("-", $vals);
                $lastElementResult = end($tests[$j]);
                $arrry1[] = explode("@", $lastElementResult);
>>>>>>> 594515e (testing)
                $ControllerName[] = $arrry1[$j][0];
                $j++;
            }

            sort($ControllerName);
            $clength = count($ControllerName);
<<<<<<< HEAD
            for($x = 0; $x < $clength; $x++) {
              $ControllerName[$x];
              
            }

            $listofcontrollers = array_unique($ControllerName);
        
            if (($key = array_search('SettingController', $listofcontrollers)) !== false) {
                //dd($key);
               unset($listofcontrollers[$key]);
            }
             if (($key = array_search('LoginController', $listofcontrollers)) !== false) {
                //dd($key);
               unset($listofcontrollers[$key]);
=======
            for ($x = 0; $x < $clength; $x++) {
                $ControllerName[$x];
            }

            $listofcontrollers = array_unique($ControllerName);

            if (($key = array_search('SettingController', $listofcontrollers)) !== false) {
                //dd($key);
                unset($listofcontrollers[$key]);
            }
            if (($key = array_search('LoginController', $listofcontrollers)) !== false) {
                //dd($key);
                unset($listofcontrollers[$key]);
>>>>>>> 594515e (testing)
            }

            if (($key = array_search('DashboardController', $listofcontrollers)) !== false) {
                //dd($key);
<<<<<<< HEAD
               unset($listofcontrollers[$key]);
            }
             if (($key = array_search('ProfileController', $listofcontrollers)) !== false) {
                //dd($key);
               unset($listofcontrollers[$key]);
            }

            $criteria                   = array();
            $criteria["eDelete"]        = "No"; 
            $criteria["eStatus"]        = "Active"; 
            $foundControllers           = PaginationModel::get_all_data($criteria);
            $foundvalues = [];
            if (!empty($foundControllers)) {
                foreach($foundControllers as $found){
                      $foundvalues[] = $found->vController;
=======
                unset($listofcontrollers[$key]);
            }
            if (($key = array_search('ProfileController', $listofcontrollers)) !== false) {
                //dd($key);
                unset($listofcontrollers[$key]);
            }

            $criteria                   = array();
            $criteria["eDelete"]        = "No";
            $criteria["eStatus"]        = "Active";
            $foundControllers           = PaginationModel::get_all_data($criteria);
            $foundvalues = [];
            if (!empty($foundControllers)) {
                foreach ($foundControllers as $found) {
                    $foundvalues[] = $found->vController;
>>>>>>> 594515e (testing)
                }
            }
            $getExistControllers       = $foundvalues;
            $data['listofcontrollers'] = array_diff($listofcontrollers, $getExistControllers);

            return view('admin.pagination.add')->with($data);
<<<<<<< HEAD
        }else{

            return redirect()->route('admin.pagination.listing')->withError('can not access without permission.');
        }
        
    }
    public function edit($vUniqueCode)
    {  

       if(!empty($vUniqueCode))
       {
            $data  = General::check_module_permission();

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
=======
        } else {

            return redirect()->route('admin.pagination.listing')->withError('can not access without permission.');
        }
    }
    public function edit($vUniqueCode)
    {

        if (!empty($vUniqueCode)) {
            $data  = General::check_module_permission();

            if ($data["permission"] != null && $data["permission"]->eWrite == "Yes") {
                $controllers = [];
                foreach (Route::getRoutes()->getRoutes() as $route) {
                    $action = $route->getAction();
                    if (array_key_exists('controller', $action)) {
                        $controllers[]  = $action['controller'];
                        $result = preg_grep('/^App/', $controllers);
                    }
                }
                $i = 0;
                foreach ($result as $key => $val) {
                    $find = array("\\");
                    $replace = array("-");
                    $arry[] = str_replace($find, $replace, $val);
>>>>>>> 594515e (testing)
                    $results = preg_grep('/^App-Http-Controllers-admin/', $arry);
                    $i++;
                }

                $j = 0;
<<<<<<< HEAD
                foreach ($results as $key => $vals)
                {
                    $tests[]  = explode("-",$vals);
                    $lastElementResult = end($tests[$j]);
                    $arrry1[] = explode("@",$lastElementResult);
=======
                foreach ($results as $key => $vals) {
                    $tests[]  = explode("-", $vals);
                    $lastElementResult = end($tests[$j]);
                    $arrry1[] = explode("@", $lastElementResult);
>>>>>>> 594515e (testing)
                    $ControllerName[] = $arrry1[$j][0];
                    $j++;
                }
                sort($ControllerName);
                $clength = count($ControllerName);
<<<<<<< HEAD
                for($x = 0; $x < $clength; $x++) {
                  $ControllerName[$x];
                  
                }

                $listofcontrollers = array_unique($ControllerName);
                 
                if (($key = array_search('SettingController', $listofcontrollers)) !== false) {
                    //dd($key);
                   unset($listofcontrollers[$key]);
                }
                 if (($key = array_search('LoginController', $listofcontrollers)) !== false) {
                    //dd($key);
                   unset($listofcontrollers[$key]);
=======
                for ($x = 0; $x < $clength; $x++) {
                    $ControllerName[$x];
                }

                $listofcontrollers = array_unique($ControllerName);

                if (($key = array_search('SettingController', $listofcontrollers)) !== false) {
                    //dd($key);
                    unset($listofcontrollers[$key]);
                }
                if (($key = array_search('LoginController', $listofcontrollers)) !== false) {
                    //dd($key);
                    unset($listofcontrollers[$key]);
>>>>>>> 594515e (testing)
                }

                if (($key = array_search('DashboardController', $listofcontrollers)) !== false) {
                    //dd($key);
<<<<<<< HEAD
                   unset($listofcontrollers[$key]);
=======
                    unset($listofcontrollers[$key]);
>>>>>>> 594515e (testing)
                }

                $data['listofcontrollers'] = $listofcontrollers;

                $criteria                   = array();
                $criteria["vUniqueCode"]    = $vUniqueCode;
                $data['paginations']        = PaginationModel::get_by_id($criteria);
<<<<<<< HEAD
                
                if(!empty($data['paginations']) || !empty($data['listofcontrollers']))
                {
                    return view('admin.pagination.add')->with($data);
                }
                else
                {
                    return redirect()->route('admin.pagination.listing');
                }
            }
            else
            {

                return redirect()->route('admin.pagination.listing')->withError('can not access without permission.');
            } 
        }
       else
        {
            return redirect()->route('admin.pagination.listing');
        }

   }
=======

                if (!empty($data['paginations']) || !empty($data['listofcontrollers'])) {
                    return view('admin.pagination.add')->with($data);
                } else {
                    return redirect()->route('admin.pagination.listing');
                }
            } else {

                return redirect()->route('admin.pagination.listing')->withError('can not access without permission.');
            }
        } else {
            return redirect()->route('admin.pagination.listing');
        }
    }
>>>>>>> 594515e (testing)

    public function store(Request $request)
    {

        $vUniqueCode = $request->vUniqueCode;
<<<<<<< HEAD
        
        $data                 = array();
        if(!empty($request->vController) || $request->vController != null ){
        $data['vController']  = $request->vController;
=======

        $data                 = array();
        if (!empty($request->vController) || $request->vController != null) {
            $data['vController']  = $request->vController;
>>>>>>> 594515e (testing)
        }
        $data['vSize']        = $request->vSize;
        $data['eStatus']      = $request->eStatus;

<<<<<<< HEAD
        if(!empty($vUniqueCode))
        {
=======
        if (!empty($vUniqueCode)) {
>>>>>>> 594515e (testing)
            $data['dtUpdatedDate'] = date("Y-m-d H:i:s");
            $where                 = array();
            $where['vUniqueCode']  = $vUniqueCode;
            $ID = PaginationModel::UpdateData($where, $data);

            return redirect()->route('admin.pagination.listing')->withSuccess('Pagination updated successfully.');
<<<<<<< HEAD
        }
        else
        {                                 
            
=======
        } else {

>>>>>>> 594515e (testing)
            $data['dtAddedDate']        = date("Y-m-d h:i:s");
            $ID = PaginationModel::AddData($data);

            $where = array();
            $where["iPaginationId"]  = $ID;
            $data = array();
<<<<<<< HEAD
            $data['vUniqueCode']     = md5(uniqid(rand(),true)).md5(time()).md5($ID);
=======
            $data['vUniqueCode']     = md5(uniqid(rand(), true)) . md5(time()) . md5($ID);
>>>>>>> 594515e (testing)
            PaginationModel::UpdateData($where, $data);

            return redirect()->route('admin.pagination.listing')->withSuccess('Pagination created successfully.');
        }
    }
<<<<<<< HEAD
    
=======
>>>>>>> 594515e (testing)
}
