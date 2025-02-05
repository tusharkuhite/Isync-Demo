<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Support\Facades\Hash;
use App\Models\admin\RoleModel;
use App\Models\admin\PaginationModel;
use App\Models\admin\ModuleModel;
use App\Models\admin\MetaModel;
use App\Libraries\Paginator;
use App\Libraries\General;
use Validator;
use Intervention\Image\Facades\Image;


use Session;
use App\Models\admin\SurveyLinkHistoryModel;
use Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;
use App\Models\admin\SystemEmailModel;
use App\Models\admin\SurveyModel;
=======
use App\Models\admin\RoleModel;
use App\Libraries\Paginator;
use App\Libraries\General;
>>>>>>> 594515e (testing)

class RoleController extends Controller
{
    public function index()
    {
<<<<<<< HEAD
    
        $data  = General::check_module_permission();
     
        if($data["permission"] != null && $data["permission"]->eRead == "Yes")
        {
            return view('admin.role.listing')->with($data);

        }else{

            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }  
=======

        $data  = General::check_module_permission();

        if ($data["permission"] != null && $data["permission"]->eRead == "Yes") {
            return view('admin.role.listing')->with($data);
        } else {

            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }
>>>>>>> 594515e (testing)
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
        $vCode           = $request->vCode;
        $eStatus         = $request->eStatus;
        $eDelete         = $request->eDelete;
        $vColumn         = "iRoleId";
        $vOrder          = "DESC";
        $eStatus_search  = $request->eStatus_search;
        $eFeature_search = $request->eFeature_search;
        $eDeleted        = $request->eDeleted;

<<<<<<< HEAD
        if($vAction == "status" && !empty($vUniqueCode))
        {
            $result = (explode(",",$vUniqueCode));

          
                foreach ($result as $key => $value) 
                {
                    $where = array();
                    $where["vUniqueCode"] = $value;

                    $data = array();
                    $data['eStatus'] = $eStatus;
                    
                    $ID = RoleModel::UpdateData($where,$data); 
                }
=======
        if ($vAction == "status" && !empty($vUniqueCode)) {
            $result = (explode(",", $vUniqueCode));


            foreach ($result as $key => $value) {
                $where = array();
                $where["vUniqueCode"] = $value;

                $data = array();
                $data['eStatus'] = $eStatus;

                $ID = RoleModel::UpdateData($where, $data);
            }
>>>>>>> 594515e (testing)
        }

        $criteria                    = array();
        $criteria['vRole']           = $vRole;
        $criteria['vCode']           = $vCode;
        $criteria['eFeature_search'] = $eFeature_search;
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
        $RoleData                    = RoleModel::total_role_data($criteria);
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
        $paginator->total = $RoleData;
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
        $data['data']           = RoleModel::get_all_data($criteria);
        if($paginator->total > $selectedpagelimit)
        {
=======

        $data                   = array();
        $data['data']           = RoleModel::get_all_data($criteria);
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
            $data['RoleData']  = $RoleData;
            return view('admin.role.ajax_listing')->with($data);  

        }else{

            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }  
=======

        if ($data1["permission"] != null && $data1["permission"]->eRead == "Yes") {
            $data["permission"] = $data1["permission"];
            $data['RoleData']  = $RoleData;
            return view('admin.role.ajax_listing')->with($data);
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
            return view('admin.role.add')->with($data);

        }else{

            return redirect()->route('admin.role.listing')->withError('can not  access without permission.');
        }    
    }
    public function edit($vUniqueCode)
    {
       if(!empty($vUniqueCode))
       {
            $data  = General::check_module_permission();

            if($data["permission"] != null && $data["permission"]->eWrite == "Yes")
            {
=======
        if ($data["permission"] != null && $data["permission"]->eWrite == "Yes") {
            return view('admin.role.add')->with($data);
        } else {

            return redirect()->route('admin.role.listing')->withError('can not  access without permission.');
        }
    }
    public function edit($vUniqueCode)
    {
        if (!empty($vUniqueCode)) {
            $data  = General::check_module_permission();

            if ($data["permission"] != null && $data["permission"]->eWrite == "Yes") {
>>>>>>> 594515e (testing)
                $criteria                   = array();
                $criteria["vUniqueCode"]    = $vUniqueCode;
                $data['roles']              = RoleModel::get_by_id($criteria);

<<<<<<< HEAD
                if(!empty($data['roles']))
                {
                    return view('admin.role.add')->with($data);
                }
                else
                {
                    return redirect()->route('admin.role.listing');
                }

            }else{

                return redirect()->route('admin.role.listing')->withError('can not  access without permission.');
            }     
        }
        else
        {
=======
                if (!empty($data['roles'])) {
                    return view('admin.role.add')->with($data);
                } else {
                    return redirect()->route('admin.role.listing');
                }
            } else {

                return redirect()->route('admin.role.listing')->withError('can not  access without permission.');
            }
        } else {
>>>>>>> 594515e (testing)
            return redirect()->route('admin.role.listing');
        }
    }

    public function store(Request $request)
    {
        $vUniqueCode = $request->vUniqueCode;
<<<<<<< HEAD
        
=======

>>>>>>> 594515e (testing)
        $data                 = array();
        $data['vRole']        = $request->vRole;
        $data['vCode']        = $request->vCode;
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
            $ID = RoleModel::UpdateData($where, $data);

            return redirect()->route('admin.role.listing')->withSuccess('Role updated successfully.');
<<<<<<< HEAD
        }
        else
        {                                 
            
=======
        } else {

>>>>>>> 594515e (testing)
            $data['dtAddedDate']        = date("Y-m-d h:i:s");
            $ID = RoleModel::AddData($data);

            //--- add uniquecode--->
            $where = array();
            $where["iRoleId"]  = $ID;
            $data = array();
<<<<<<< HEAD
            $data['vUniqueCode']        = md5(uniqid(rand(),true)).md5(time()).md5($ID);
=======
            $data['vUniqueCode']        = md5(uniqid(rand(), true)) . md5(time()) . md5($ID);
>>>>>>> 594515e (testing)
            RoleModel::UpdateData($where, $data);

            return redirect()->route('admin.role.listing')->withSuccess('Role created successfully.');
        }
    }
<<<<<<< HEAD
    
=======
>>>>>>> 594515e (testing)
}
