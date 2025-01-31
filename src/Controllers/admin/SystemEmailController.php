<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\SystemEmailModel;
use App\Libraries\Paginator;
use App\Libraries\General;

class SystemEmailController extends Controller
{
    public function index()
    {
        $data  = General::check_module_permission();

        if ($data["permission"] != null && $data["permission"]->eRead == "Yes") {
            return view('admin.system_email.listing')->with($data);
        } else {
            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }
    }

    public function ajax_listing(Request $request)
    {

        $Pagination_Information     = General::get_pagination_count();

        $vAction         = $request->vAction;

        $vUniqueCode     = $request->vUniqueCode;
        $vEmailTitle     = $request->vEmailTitle;
        $vEmailCode      = $request->vEmailCode;
        $eStatus         = $request->eStatus;
        $eDelete         = $request->eDelete;
        $vColumn         = "iSystemEmailId";
        $vOrder          = "DESC";
        $eStatus_search  = $request->eStatus_search;
        $eDeleted        = $request->eDeleted;

        if ($vAction == "status" && !empty($vUniqueCode)) {
            $result = (explode(",", $vUniqueCode));
            foreach ($result as $key => $value) {
                $where = array();
                $where["vUniqueCode"] = $value;

                $data = array();
                $data['eStatus'] = $eStatus;

                $ID = SystemEmailModel::UpdateData($where, $data);
            }
        }

        $criteria                    = array();
        $criteria['vEmailTitle']     = $vEmailTitle;
        $criteria['vEmailCode']      = $vEmailCode;
        $criteria['eStatus']         = $eStatus;
        $criteria["paging"]          = false;
        if ($eStatus_search != null) {
            $criteria['eStatus']      = $eStatus_search;
        }
        if ($eDeleted != null) {
            $criteria['eDelete']      = $eDeleted;
        }
        $criteria['column']          = $vColumn;
        $criteria['order']           = $vOrder;
        $SystemEmailData             = SystemEmailModel::total_system_email_data($criteria);
        $pages                       = 1;
        if ($request->pages != "") {
            $pages = $request->pages;
        }
        $paginator = new Paginator($pages);
        $paginator->total = $SystemEmailData;
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
        $data['data']           = SystemEmailModel::get_all_data($criteria);
        if ($paginator->total > $selectedpagelimit) {
            $data['paging'] = $paginator->paginate($selectedpagelimit);
        }
        // --------------
        $data1  = General::check_module_permission();

        if ($data1["permission"] != null && $data1["permission"]->eRead == "Yes") {
            $data["permission"] = $data1["permission"];
            $data['SystemEmailData']  = $SystemEmailData;
            return view('admin.system_email.ajax_listing')->with($data);
        } else {

            return redirect()->route('admin.dashboard')->withError('can not access without permission.');
        }
    }
    public function add()
    {
        $data  = General::check_module_permission();

        if ($data["permission"] != null && $data["permission"]->eWrite == "Yes") {
            return view('admin.system_email.add')->with($data);
        } else {

            return redirect()->route('make.listing')->withError('can not access without permission.');
        }
    }
    public function edit($vUniqueCode)
    {
        if (!empty($vUniqueCode)) {
            $data  = General::check_module_permission();

            if ($data["permission"] != null && $data["permission"]->eWrite == "Yes") {
                $criteria                   = array();
                $criteria["vUniqueCode"]    = $vUniqueCode;
                $data['systemEmail']        = SystemEmailModel::get_by_id($criteria);

                return view('admin.system_email.add')->with($data);
            } else {

                return redirect()->route('system_email.listing')->withError('can not access without permission.');
            }
        } else {
            return redirect()->route('admin.systemEmail.listing');
        }
    }

    public function store(Request $request)
    {
        $vUniqueCode                = $request->vUniqueCode;
        $data['vEmailSubject']      = $request->vEmailSubject;
        $data['tEmailMessage']      = $request->tEmailMessage;
        $data['vEmailCode']         = $request->vEmailCode;
        $data['vFromName']          = $request->vFromName;
        $data['vFromEmail']         = $request->vFromEmail;
        $data['eStatus']            = $request->eStatus;
        if (!empty($vUniqueCode)) {
            $where                  = array();
            $where['vUniqueCode']   = $vUniqueCode;
            $data['dtUpdatedDate']  = date("Y-m-d h:i:s");
            $ID = SystemEmailModel::UpdateData($where, $data);

            return redirect()->route('admin.systemEmail.listing')->withSuccess('System Email updated successfully.');
        } else {

            $data['dtAddedDate']     = date("Y-m-d h:i:s");
            $ID = SystemEmailModel::AddData($data);

            $where = array();
            $where["iSystemEmailId"]  = $ID;
            $data  = array();
            $data['vUniqueCode']      = md5(uniqid(rand(), true)) . md5(time()) . md5($ID);
            SystemEmailModel::UpdateData($where, $data);
            return redirect()->route('admin.systemEmail.listing')->withSuccess('System Email created successfully.');
        }
    }
}
