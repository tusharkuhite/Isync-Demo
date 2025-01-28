<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use ReflectionClass;
use Illuminate\Support\Facades\Hash;
use App\Models\admin\PaginationModel;
use App\Models\admin\ModuleModel;
use App\Models\admin\MetaModel;
use App\Libraries\Paginator;
use Session;
use App\Libraries\General;
use Validator;

class MetaController extends Controller
{
    public function index()
    {  
        $methodsByController = [];

        $routeCollection = Route::getRoutes();
        
        foreach($routeCollection as $route) 
        {
            $controllerAction = $route->getActionName();

            if(strpos($controllerAction, '@') !== false) 
            {
                list($controller, $action) = explode('@', $controllerAction);
                
                if(class_exists($controller) && is_subclass_of($controller, Controller::class)) 
                {
                    $controllerName = class_basename($controller);

                    $reflectionClass = new ReflectionClass($controller);
                    $methods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);

                    foreach($methods as $method) 
                    {
                        if($method->class === $controller && $method->name !== '__construct') 
                        {
                            $methodsByController[$controllerName][] = $method->name;
                        }
                    }
                }
            }
        }

        foreach($methodsByController as $controller => $methods) 
        {
            $methodsByController[$controller] = array_unique($methods);
        }
        ksort($methodsByController);
        $data['controllers']     = $methodsByController;

        $data1  = General::check_module_permission();

        if($data1["permission"] != null && $data1["permission"]->eRead == "Yes")
        {
            $data["permission"] = $data1["permission"];
            return view('admin.meta.listing')->with($data);
        }
        else
        {
            return redirect()->route('admin.dashboard')->withError('Sorry, you do not have permission to access this page.');
        } 
    }

    public function ajax_listing(Request $request)
    {
        $Pagination_Information     = General::get_pagination_count();
        $vAction        = $request->vAction;
        $vUniqueCode    = $request->vUniqueCode;
        $eStatus        = $request->eStatus;
        $eDelete        = $request->eDelete;
        $vColumn        = "iMetaId";
        $vOrder         = "DESC";
        $eFeature_search = $request->eFeature_search;
        $eDeleted       = $request->eDeleted;
        $vController    = $request->vController;
        $vTitle         = $request->vTitle;
        $ePanal_search  = $request->ePanal_search;
        $vSlug          = $request->vSlug; 
 
       
        if($vAction == "recover" && !empty($vUniqueCode))
        {
            $where                  = array();
            $where["vUniqueCode"]   = $vUniqueCode;

            $data                   = array();
            $data['eDelete']        = "No"; 
            MetaModel::UpdateData($where,$data);
        }

        if($vAction == "delete" && !empty($vUniqueCode))
        {
            $where                 = array();
            $where['vUniqueCode']  = $request->vUniqueCode;
            MetaModel::DeleteData($where);
        }
        if($vAction == "status" && !empty($vUniqueCode))
        {
            $result = (explode(",",$vUniqueCode));
            $eStatuschange  = $request->eStatuschange;
            if($eStatus == "delete")
            {
                foreach($result as $key => $value) 
                {
                    $where                 = array();
                    $where['vUniqueCode']  = $value;
                    MetaModel::DeleteData($where);   
                }
            }
            elseif($eStatus == "Recover")
            {
                foreach($result as $key => $value) 
                {
                    $where                 = array();
                    $where['vUniqueCode']  = $value;
                    $data = array();
                    $data['eDelete'] = 'No';
                    MetaModel::UpdateData($where,$data);
                }
            }
            else
            {
                foreach($result as $key => $value) 
                {
                    $where = array();
                    $where["vUniqueCode"] = $value;

                    $data = array();
                    $data['eStatus'] = $eStatus;  
                    MetaModel::UpdateData($where,$data);  
                }
            }
        }

        $criteria                   = array();
        $criteria['vController']    = $vController;
        $criteria['vTitle']         = $vTitle;
        $criteria['vSlug']          = $vSlug;
        $criteria['ePanal_search']  = $ePanal_search;
        $criteria['eFeature_search']= $eFeature_search;
        $criteria['eStatus']        = $eStatus;
        $criteria["paging"]         = false;
        $criteria['eStatus']        = $eStatus;
        $criteria['eDelete']        = $eDelete;
        $criteria['eDeleted']       = $eDeleted;
        $criteria['column']         = $vColumn;
        $criteria['order']          = $vOrder;
        $MetaData                   = MetaModel::total_data($criteria);
        
        $pages                      = 1;
        if($request->pages != "")
        {
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = $MetaData;
        if(!empty($Pagination_Information->vSize)) {
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
        $data['data']           = MetaModel::get_all_data($criteria);

        if($paginator->total > $selectedpagelimit)
        {
            $data['paging'] = $paginator->paginate($selectedpagelimit);
        }
        // --------------
        $data1  = General::check_module_permission();
        
        if($data1["permission"] != null && $data1["permission"]->eRead == "Yes")
        {  
            $data["permission"] = $data1["permission"];
            $data['MetaData']  = $MetaData;
            return view('admin.meta.ajax_listing')->with($data);  
        }
        else
        {
            return redirect()->route('admin.dashboard')->withError('Sorry, you do not have permission to access this page.');
        }
    }

    public function add()
    {   
        $methodsByController = [];

        $routeCollection = Route::getRoutes();

        foreach($routeCollection as $route) 
        {
            $controllerAction = $route->getActionName();

            if(strpos($controllerAction, '@') !== false) 
            {
                list($controller, $action) = explode('@', $controllerAction);

                if(class_exists($controller) && is_subclass_of($controller, Controller::class)) 
                {
                    $controllerName = class_basename($controller);

                    $reflectionClass = new ReflectionClass($controller);
                    $methods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);

                    foreach($methods as $method) 
                    {
                        if($method->class === $controller && $method->name !== '__construct') 
                        {
                            $methodsByController[$controllerName][] = $method->name;
                        }
                    }
                }
            }
        }

        foreach($methodsByController as $controller => $methods) 
        {
            $methodsByController[$controller] = array_unique($methods);
        }
        //ksort($methodsByController);
        $data['controllers']     = $methodsByController;

        $data1  = General::check_module_permission();

        if($data1["permission"] != null && $data1["permission"]->eWrite == "Yes")
        { 
            $data["permission"] = $data1["permission"];
            return view('admin.meta.add')->with($data);
        }
        else
        {
            return redirect()->route('admin.menu.listing')->withError('can not access without permission.');
        }  
    }
    
    public function edit($vUniqueCode)
    {
        $data  = General::check_module_permission();
        if($data["permission"] != null && $data["permission"]->eWrite == "Yes")
        { 
            if(!empty($vUniqueCode))
            {
                $criteria                   = array();
                $criteria["vUniqueCode"]    = $vUniqueCode;
                $data['metas']              = MetaModel::get_by_id($criteria);
                
                if(!empty($data['metas']))
                {   
                    $methodsByController = [];
                    $routeCollection = Route::getRoutes();

                    foreach($routeCollection as $route) 
                    {
                        $controllerAction = $route->getActionName();

                        if(strpos($controllerAction, '@') !== false) 
                        {
                            list($controller, $action) = explode('@', $controllerAction);

                            if(class_exists($controller) && is_subclass_of($controller, Controller::class)) 
                            {
                                $controllerName = class_basename($controller); 
                                $reflectionClass = new ReflectionClass($controller);
                                $methods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);

                                foreach($methods as $method) 
                                {
                                    if($method->class === $controller && $method->name !== '__construct') 
                                    {
                                        $methodsByController[$controllerName][] = $method->name;
                                    }
                                }
                            }
                        }
                    }

                    foreach($methodsByController as $controller => $methods) 
                    {
                        $methodsByController[$controller] = array_unique($methods);
                    }
                    ksort($methodsByController);
                    $data['controllers']  = $methodsByController;

                    return view('admin.meta.add')->with($data);
                }
                else
                {
                    return redirect()->route('admin.meta.listing');
                }
            }
            else
            {
                return redirect()->route('dashboard.listing')->withError('Data Not Found!');
            }
        }
        else
        {
            return redirect()->route('admin.menu.listing')->withError('can not access without permission.');
        }   
    }

    public function store(Request $request)
    {
        $vUniqueCode = $request->vUniqueCode;
         
        $data                 = array();
        $data['vController']  = $request->vController;
        $data['vMethod']      = $request->vMethod;
        $data['vSlug']        = $request->vSlug;
        $data['ePanel']       = $request->ePanel;
        $data['tDescription'] = $request->tDescription;
        $data['vTitle']       = $request->vTitle;
        $data['eStatus']      = $request->eStatus;
        $data['tKeyword']     = $request->tKeyword;

        if(!empty($vUniqueCode))
        {
            $where                 = array();
            $where['vUniqueCode']  = $vUniqueCode;
            MetaModel::UpdateData($where, $data);
            return redirect()->route('admin.meta.listing')->withSuccess('Meta updated successfully.');
        }
        else
        {                                 
            $data['dtAddedDate']  = date("Y-m-d h:i:s");
            $ID = MetaModel::AddData($data);

            if($ID != null)
            {
                $where1                = array();
                $where1["iMetaId"]     = $ID;
                $data1                 = array();
                $data1['vUniqueCode']  = md5(uniqid(rand(),true)).md5(time()).md5($ID);
                MetaModel::UpdateData($where1, $data1);
            }
            return redirect()->route('admin.meta.listing')->withSuccess('Meta created successfully.');
        }
    }

    public function get_method_by_controller(Request $request)
    {
        $methodsByController = [];
        $routeCollection = Route::getRoutes();

        foreach($routeCollection as $route) 
        {
            $controllerAction = $route->getActionName();

            if(strpos($controllerAction, '@') !== false) 
            {
                list($controller, $action) = explode('@', $controllerAction);

                if(class_exists($controller) && is_subclass_of($controller, Controller::class)) 
                {
                    $controllerName = class_basename($controller);

                    $reflectionClass = new ReflectionClass($controller);
                    $methods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);

                    foreach($methods as $method) 
                    {
                        if($method->class === $controller && $method->name !== '__construct') 
                        {
                            $methodsByController[$controllerName][] = $method->name;
                        }
                    }
                }
            }
        }

        foreach($methodsByController as $controller => $methods) 
        {
            $methodsByController[$controller] = array_unique($methods);
        }

        $controllerName = $request->vController;

        if(isset($methodsByController[$controllerName])) 
        {
            $methodsForController = $methodsByController[$controllerName];
            return response()->json($methodsForController);
        } 
        else 
        {
            return response()->json(['error' => 'Controller not found in the list.'], 404);
        }
    }
} 

