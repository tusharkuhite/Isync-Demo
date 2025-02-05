<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\RoleModel;
use App\Libraries\Paginator;
use App\Libraries\General;

class RoleController extends Controller
{
    public function index()
    {

        $data  = General::check_module_permission();

        if ($data["permission"] != null && $data["permission"]->eRead == "Yes") {
            return view('admin.role.listing')->with($data);
        } else {

            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }
    }

    public function ajax_listing(Request $request)
    {
        $Pagination_Information     = General::get_pagination_count();
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

        if ($vAction == "status" && !empty($vUniqueCode)) {
            $result = (explode(",", $vUniqueCode));


            foreach ($result as $key => $value) {
                $where = array();
                $where["vUniqueCode"] = $value;

                $data = array();
                $data['eStatus'] = $eStatus;

                $ID = RoleModel::UpdateData($where, $data);
            }
        }

        $criteria                    = array();
        $criteria['vRole']           = $vRole;
        $criteria['vCode']           = $vCode;
        $criteria['eFeature_search'] = $eFeature_search;
        $criteria["paging"]          = false;
        if ($eStatus_search != null) {
            $criteria['eStatus']      = $eStatus_search;
        }

        if ($eDeleted != null) {
            $criteria['eDelete']      = $eDeleted;
        }
        $criteria['column']          = $vColumn;
        $criteria['order']           = $vOrder;
        $RoleData                    = RoleModel::total_role_data($criteria);
        $pages                       = 1;
        if ($request->pages != "") {
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = $RoleData;
        if (!empty($Pagination_Information->vSize)) {
            $paginator->itemsPerPage = $Pagination_Information->vSize;
        }
        if (!empty($request->limit_page)) {
            $selectedpagelimit = $request->limit_page;
        } else {
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
        $data['data']           = RoleModel::get_all_data($criteria);
        if ($paginator->total > $selectedpagelimit) {
            $data['paging'] = $paginator->paginate($selectedpagelimit);
        }
        // --------------
        $data1  = General::check_module_permission();

        if ($data1["permission"] != null && $data1["permission"]->eRead == "Yes") {
            $data["permission"] = $data1["permission"];
            $data['RoleData']  = $RoleData;
            return view('admin.role.ajax_listing')->with($data);
        } else {

            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }
    }
    public function add()
    {
        $data  = General::check_module_permission();

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
                $criteria                   = array();
                $criteria["vUniqueCode"]    = $vUniqueCode;
                $data['roles']              = RoleModel::get_by_id($criteria);

                if (!empty($data['roles'])) {
                    return view('admin.role.add')->with($data);
                } else {
                    return redirect()->route('admin.role.listing');
                }
            } else {

                return redirect()->route('admin.role.listing')->withError('can not  access without permission.');
            }
        } else {
            return redirect()->route('admin.role.listing');
        }
    }

    public function store(Request $request)
    {
        $vUniqueCode = $request->vUniqueCode;
        $data                 = array();
        $data['vRole']        = $request->vRole;
        $data['vCode']        = $request->vCode;
        $data['eStatus']      = $request->eStatus;

        if (!empty($vUniqueCode)) {
            $data['dtUpdatedDate'] = date("Y-m-d H:i:s");
            $where                 = array();
            $where['vUniqueCode']  = $vUniqueCode;
            $ID = RoleModel::UpdateData($where, $data);

            return redirect()->route('admin.role.listing')->withSuccess('Role updated successfully.');
        } else {

            $data['dtAddedDate']        = date("Y-m-d h:i:s");
            $ID = RoleModel::AddData($data);

            //--- add uniquecode--->
            $where = array();
            $where["iRoleId"]  = $ID;
            $data = array();
            $data['vUniqueCode']        = md5(uniqid(rand(), true)) . md5(time()) . md5($ID);
            RoleModel::UpdateData($where, $data);

            return redirect()->route('admin.role.listing')->withSuccess('Role created successfully.');
        }
    }
}
