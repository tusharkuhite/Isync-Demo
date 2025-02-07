<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\MenuModel;
use App\Models\admin\RoleModel;
use App\Libraries\Paginator;
use App\Libraries\General;

class MenuController extends Controller
{
    public function index()
    {   

            $criteria             = array();
            $criteria['eStatus']  = "Active";
            $criteria['eDelete']  = "No";
            $data['roles']        = RoleModel::get_all_data($criteria);

            return view('admin.menu.listing')->with($data);
    }

    public function ajax_listing(Request $request)
    {
        $Pagination_Information     = General::get_pagination_count();
        
        $vAction         = $request->vAction;
        $vUniqueCode     = $request->vUniqueCode;
        $vMenu           = $request->vMenu;
        $eStatus         = $request->eStatus;
        $eDelete         = $request->eDelete;
        $vColumn         = "iMenuId";
        $vOrder          = "DESC";
        $eFeature_search = $request->eFeature_search;
        $eStatus_search  = $request->eStatus_search;
        $eDeleted        = $request->eDeleted;
        $iRoleId         = $request->iRoleId;
        $vCode           = $request->vCode;

        if($vAction == "delete" && !empty($vUniqueCode))
        {
            $where                 = array();
            $where['vUniqueCode']  = $request->vUniqueCode;
            $data['eDelete']       = 'Yes';
            $ID = MenuModel::UpdateData($where,$data);
        }
        if($vAction == "status" && !empty($vUniqueCode))
        {
            $result = (explode(",",$vUniqueCode));

            if($eStatus == "delete")
            {
                foreach($result as $key => $value) 
                {
                    $where                 = array();
                    $where['vUniqueCode']    = $value;
                    $data = array();
                    $data['eDelete'] = 'Yes';
                    $ID = MenuModel::UpdateData($where,$data);
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
                    $ID = MenuModel::UpdateData($where,$data);
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
                    $ID = MenuModel::UpdateData($where,$data);  
                }
            }
        }

        $criteria                    = array();
        $criteria['vMenu']           = $vMenu;
        $criteria['iRoleId']         = $iRoleId;
        $criteria['vCode']           = $vCode;
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
        $MenuData                    = MenuModel::total_menu_data($criteria);
        $pages                       = 1;
        if($request->pages != "")
        {
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = $MenuData;
        if(!empty($Pagination_Information->vSize)) 
        {
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
        $data['data']           = MenuModel::get_all_data($criteria);
        if($paginator->total > $selectedpagelimit)
        {
            $data['paging'] = $paginator->paginate($selectedpagelimit);
        }
        // --------------
        $data1  = General::check_module_permission();
        
      
            $data['MenuData']  = $MenuData;
            return view('admin.menu.ajax_listing')->with($data);  

    }

    public function add()
    {   
        $criteria             = array();
        $criteria['eStatus']  = "Active";
        $criteria['eDelete']  = "No";
        $data['roles']        = RoleModel::get_all_data($criteria);

        return view('admin.menu.add')->with($data);
    }

    public function edit($vUniqueCode)
    {
       if(!empty($vUniqueCode))
       {    
          
            $criteria                    = array();
            $criteria["vUniqueCode"]     = $vUniqueCode;
            $data['menues']              = MenuModel::get_by_id($criteria);

            $criteria             = array();
            $criteria['eStatus']  = "Active";
            $criteria['eDelete']  = "No";
            $data['roles']        = RoleModel::get_all_data($criteria);

            if(!empty($data['menues']))
            {
                return view('admin.menu.add')->with($data);
            }
            else
            {
                return redirect()->route('admin.menu.listing');
            }
        }
        else
        {
            return redirect()->route('admin.menu.listing');
        }
    }

    public function store(Request $request)
    {
        $vUniqueCode = $request->vUniqueCode;
        
        $data                 = array();
        $data['vMenu']        = $request->vMenu;
        $data['eFeature']     = $request->eFeature;
        $data['iRoleId']      = $request->iRoleId;
        $data['eStatus']      = $request->eStatus;
        $data['vCode']        = $request->vCode;
        $data['iOrder']       = $request->iOrder;

        if(!empty($vUniqueCode))
        {
            $data['dtUpdatedDate'] = date("Y-m-d H:i:s");
            $where                 = array();
            $where['vUniqueCode']  = $vUniqueCode;
            $ID = MenuModel::UpdateData($where, $data);

            return redirect()->route('admin.menu.listing')->withSuccess('Menu data updated successfully.');
        }
        else
        {                                 
            $data['dtAddedDate']   = date("Y-m-d h:i:s");
            $ID = MenuModel::AddData($data);

            $where = array();
            $where["iMenuId"]  = $ID;
            $data = array();
            $data['vUniqueCode']   = md5(uniqid(rand(),true)).md5(time()).md5($ID);
            MenuModel::UpdateData($where, $data);

            return redirect()->route('admin.menu.listing')->withSuccess('Menu created successfully.');
        }
    }

    public function fetch_menu(Request $request)
    {    
        $criteria                     = array();
        $criteria['iRoleId']          = $request->iRoleId;
        $criteria['eStatus']          = "Active";
        $criteria['eDelete']          = "No";
        $data['menus']                = MenuModel::get_all_data($criteria);
        
        return response()->json($data);
    }
}
